<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\OrderReview;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Order::with('user')->orderBy('created_at', 'desc');
        $ordered = Order::where('status', 'ordered')->count();
        $delivered      = Order::where('status', 'delivered')->count();
        $returned       = Order::where('status', 'returned')->count();
        $cancelled         = Order::where('status', 'cancelled')->count();


        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->appends(['status' => $status]);

        $counts = [
            'all'        => Order::count(),
            'ordered' => $ordered,
            'delivered' => $delivered,
            'returned' => $returned,
            'cancelled' => $cancelled,
        ];

        return view('admin.orders.index', [
            'orders' => $orders,
            'currentStatus' => $status
        ], compact('ordered', 'delivered', 'returned', 'cancelled', 'counts'));
    }

    /**
     * Điều chỉnh tồn kho theo chi tiết đơn hàng (tăng/giảm)
     * direction: 'increase' | 'decrease'
     */
    private function adjustStockForOrder(Order $order, string $direction = 'increase'): void
    {
        $order->loadMissing('orderDetails');
        foreach ($order->orderDetails as $detail) {
            $qty = (int) ($detail->quantity ?? 0);
            if ($qty <= 0) {
                continue;
            }

            if ($detail->variant_id) {
                $variant = ProductVariant::where('id', $detail->variant_id)->lockForUpdate()->first();
                if ($variant) {
                    if ($direction === 'increase') {
                        $variant->increment('stock', $qty);
                    } else {
                        $variant->decrement('stock', $qty);
                    }
                }
            } else if ($detail->product_id) {
                $product = Product::where('id', $detail->product_id)->lockForUpdate()->first();
                if ($product) {
                    if ($direction === 'increase') {
                        $product->increment('quantity', $qty);
                    } else {
                        $product->decrement('quantity', $qty);
                    }
                }
            }
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ordered,processing,confirmed,shipping,delivered,cancelled,returned',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::with('orderDetails')->findOrFail($id);
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            // Hoàn tồn khi chuyển sang cancelled/returned từ trạng thái chưa hoàn tất
            if (in_array($order->status, ['cancelled', 'returned']) && !in_array($oldStatus, ['cancelled', 'returned'])) {
                $this->adjustStockForOrder($order, 'increase');
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái đơn: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    public function userOrderHistory(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10)->appends(['status' => $status]);

        // Đếm số lượng từng trạng thái
        $statusCounts = [
            'all'        => Order::where('user_id', Auth::id())->count(),
            'ordered'    => Order::where('user_id', Auth::id())->where('status', 'ordered')->count(),
            'processing' => Order::where('user_id', Auth::id())->where('status', 'processing')->count(),
            'confirmed'  => Order::where('user_id', Auth::id())->where('status', 'confirmed')->count(),
            'shipping'   => Order::where('user_id', Auth::id())->where('status', 'shipping')->count(),
            'delivered'  => Order::where('user_id', Auth::id())->where('status', 'delivered')->count(),
            'cancelled'  => Order::where('user_id', Auth::id())->where('status', 'cancelled')->count(),
            'returned'   => Order::where('user_id', Auth::id())->where('status', 'returned')->count(),
        ];

        return view('Frontend.pages.account.orders', [
            'orders'        => $orders,
            'currentStatus' => $status,
            'statusCounts'  => $statusCounts,
        ]);
    }

    public function userOrderDetails($id)
    {
        // Lấy thông tin đơn hàng của người dùng hiện tại
        $order = Order::with(['orderDetails.product.reviews' => function ($query) {
            $query->where('is_approved', true);
        }])->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Tính avgRating và totalReviews cho từng product
        foreach ($order->orderDetails as $detail) {
            $product = $detail->product;
            if ($product) {
                $product->avgRating = $product->reviews->avg('rating') ?? 0;
                $product->totalReviews = $product->reviews->count();
            }
        }

        // ==== TÍNH REVIEW CHO TOÀN ĐƠN HÀNG ====
        $reviews = OrderReview::where('order_id', $id)->where('is_approved', true);

        $totalReviews = $reviews->count();
        $avgRating = $reviews->avg('rating') ?? 0;

        // Rating distribution
        $ratingStats = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = (clone $reviews)->where('rating', $i)->count();
            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
            $ratingStats[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        // Check if current user can review
        $canReview = false;
        $userReview = null;
        if (Auth::check()) {
            $canReview = $order->canBeReviewedBy(Auth::id());
            $userReview = $order->getUserReview(Auth::id());
        }

        // Trả về view chi tiết đơn hàng
        return view('Frontend.pages.account.order-detail', compact(
            'order',
            'totalReviews',
            'avgRating',
            'ratingStats',
            'canReview',
            'userReview',
        ));
    }


    public function updateAddress(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'address' => 'required|max:255',
            'province' => 'required|max:255',
            'district' => 'required|max:255',
            'ward' => 'required|max:255',
        ]);

        // Tìm đơn hàng của người dùng hiện tại
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Kiểm tra trạng thái đơn hàng
        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Bạn chỉ có thể thay đổi địa chỉ khi đơn hàng đang ở trạng thái Đang xử lý.');
        }

        // Cập nhật địa chỉ giao hàng
        $order->address = $request->address;
        $order->province = $request->province;
        $order->district = $request->district;
        $order->ward = $request->ward;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật địa chỉ giao hàng thành công!');
    }
    public function orderSuccess($order_id)
    {
        // Lấy thông tin đơn hàng từ cơ sở dữ liệu
        $order = Order::with('orderDetails')->findOrFail($order_id);

        return view('Frontend.pages.checkout_success', compact('order'));
    }
    public function getProvince()
    {
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/province";
        $token = env('GHNHANH_API_KEY');
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return response()->json($data['data'] ?? []);
    }
    public function getDistrict($provinceId)
    {
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/district?province_id=$provinceId";
        $token = env('GHNHANH_API_KEY');
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return response()->json($data['data'] ?? []);
    }
    public function getWard($districtId)
    {
        $url = env('GHNHANH_API_URL') . "/shiip/public-api/master-data/ward?district_id=$districtId";
        $token = env('GHNHANH_API_KEY');
        $options = [
            'http' => [
                'header' => "Token: $token\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $data = json_decode($response, true);
        return response()->json($data['data'] ?? []);
    }

    public function cancelOrder(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_reason_other' => 'nullable|string|max:255',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['ordered', 'processing', 'confirmed'])
            ->firstOrFail();

        // Nếu chọn "Tôi không tìm thấy lý do hủy phù hợp" thì lấy lý do khác
        $cancelReason = $request->cancel_reason === 'Tôi không tìm thấy lý do hủy phù hợp'
            ? $request->cancel_reason_other
            : $request->cancel_reason;

        try {
            DB::beginTransaction();

            $order->status = 'cancelled';
            $order->cancel_reason = $cancelReason;
            $order->save();

            // Hoàn tồn kho khi người dùng hủy đơn
            $this->adjustStockForOrder($order, 'increase');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không thể huỷ đơn hàng: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Đơn hàng đã được huỷ thành công!');
    }

    public function cancelOrder_admin(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_reason_other' => 'nullable|string|max:255',
        ]);

        $order = Order::where('id', $id)
            ->whereIn('status', ['ordered', 'processing', 'confirmed'])
            ->firstOrFail();


        // Nếu chọn "Tôi không tìm thấy lý do hủy phù hợp" thì lấy lý do khác
        $cancelReason = $request->cancel_reason === 'Tôi không tìm thấy lý do hủy phù hợp'
            ? $request->cancel_reason_other
            : $request->cancel_reason;

        try {
            DB::beginTransaction();

            $order->status = 'cancelled';
            $order->cancel_reason = $cancelReason;
            $order->save();

            // Hoàn tồn kho khi người dùng hủy đơn
            $this->adjustStockForOrder($order, 'increase');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Không thể huỷ đơn hàng: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Đơn hàng đã được huỷ thành công!');
    }


    public function reorder($id)
    {
        $order = Order::with('orderDetails.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        foreach ($order->orderDetails as $item) {
            if ($item->product) {
                Cart::add([
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'qty' => $item->quantity,
                    'price' => $item->price,
                    'options' => [
                        // Nếu có variant: 'size' => $item->size, 'color' => $item->color,...
                        'image' => $item->product->image,
                    ]
                ]);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Các sản phẩm đã được thêm lại vào giỏ hàng.');
    }

    public function print($id)
    {
        // Lấy đơn hàng và sản phẩm liên quan
        $order = Order::with(['orderDetails.product'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Load view vào PDF
        $pdf = Pdf::loadView('admin.orders.print', compact('order'))
            ->setPaper('a4');

        // Xuất file PDF (xem trực tiếp trên trình duyệt)
        return $pdf->stream('order-' . $order->id . '.pdf');

        // Nếu muốn tải về luôn:
        // return $pdf->download('order-'.$order->id.'.pdf');
    }
}
