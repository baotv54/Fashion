<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ordered,processing,confirmed,shipping,delivered,cancelled,returned',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        // Nếu admin chuyển từ trạng thái khác sang cancelled, cần trả hàng về kho
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            $this->restoreStockQuantity($order);
            $order->cancel_reason = 'Đơn hàng bị hủy bởi admin';
        }
        
        $order->status = $newStatus;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function userOrderHistory()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('Frontend.pages.account.orders', compact('orders'));
    }

    public function userOrderDetails($id)
    {
        $order = Order::with(['orderDetails.product'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('Frontend.pages.account.order-detail', compact('order'));
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'address' => 'required|max:255',
            'province' => 'required|max:255',
            'district' => 'required|max:255',
            'ward' => 'required|max:255',
        ]);

        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Bạn chỉ có thể thay đổi địa chỉ khi đơn hàng đang ở trạng thái Đang xử lý.');
        }

        $order->address = $request->address;
        $order->province = $request->province;
        $order->district = $request->district;
        $order->ward = $request->ward;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật địa chỉ giao hàng thành công!');
    }

    public function orderSuccess($order_id)
    {
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

    /**
     * Hủy đơn hàng - Trả số lượng về kho
     */
    public function cancelOrder(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_reason_other' => 'nullable|string|max:255',
        ]);

        return DB::transaction(function () use ($request, $id) {
            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['ordered', 'processing', 'confirmed'])
                ->lockForUpdate() // Khóa để tránh race condition
                ->firstOrFail();

            // Nếu chọn "Tôi không tìm thấy lý do hủy phù hợp" thì lấy lý do khác
            $cancelReason = $request->cancel_reason === 'Tôi không tìm thấy lý do hủy phù hợp' 
                ? $request->cancel_reason_other 
                : $request->cancel_reason;

            // Trả số lượng về kho
            $this->restoreStockQuantity($order);

            // Cập nhật trạng thái đơn hàng
            $order->status = 'cancelled';
            $order->cancel_reason = $cancelReason;
            $order->save();

            Log::info('Đơn hàng đã được hủy và trả hàng về kho', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'cancel_reason' => $cancelReason
            ]);

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công và số lượng sản phẩm đã được trả về kho!');
        });
    }

    /**
     * Trả số lượng về kho khi hủy đơn hàng
     */
    private function restoreStockQuantity(Order $order)
    {
        $order->load('orderDetails');
        
        foreach ($order->orderDetails as $detail) {
            try {
                if ($detail->variant_id) {
                    // Trả kho cho variant
                    $variant = ProductVariant::find($detail->variant_id);
                    if ($variant) {
                        $oldStock = $variant->stock;
                        $variant->increment('stock', $detail->quantity);
                        
                        Log::info('Đã trả kho cho variant', [
                            'variant_id' => $detail->variant_id,
                            'old_stock' => $oldStock,
                            'new_stock' => $variant->stock,
                            'restored_amount' => $detail->quantity,
                            'order_id' => $order->id
                        ]);
                    }
                } else {
                    // Trả kho cho sản phẩm chính
                    $product = Product::find($detail->product_id);
                    if ($product) {
                        $oldQuantity = $product->quantity;
                        $product->increment('quantity', $detail->quantity);
                        
                        Log::info('Đã trả kho cho sản phẩm', [
                            'product_id' => $detail->product_id,
                            'old_quantity' => $oldQuantity,
                            'new_quantity' => $product->quantity,
                            'restored_amount' => $detail->quantity,
                            'order_id' => $order->id
                        ]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Lỗi khi trả kho cho đơn hàng', [
                    'order_id' => $order->id,
                    'detail_id' => $detail->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Mua lại đơn hàng - Kiểm tra tồn kho trước khi thêm vào giỏ
     */
    public function reorder($id)
    {
        return DB::transaction(function () use ($id) {
            $order = Order::with('orderDetails.product')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $outOfStockItems = [];
            $insufficientStockItems = [];
            $availableItems = [];

            // Kiểm tra từng sản phẩm trong đơn hàng
            foreach ($order->orderDetails as $item) {
                if (!$item->product) {
                    $outOfStockItems[] = [
                        'name' => $item->product_name,
                        'reason' => 'Sản phẩm không còn tồn tại'
                    ];
                    continue;
                }

                $availableQuantity = 0;
                $productName = $item->product->name;

                if ($item->variant_id) {
                    // Kiểm tra tồn kho variant
                    $variant = ProductVariant::find($item->variant_id);
                    if ($variant) {
                        $availableQuantity = $variant->stock;
                        
                        // Thêm thông tin variant vào tên sản phẩm
                        if ($item->variant_details) {
                            $variantDetails = json_decode($item->variant_details, true);
                            $attributes = [];
                            foreach ($variantDetails as $key => $value) {
                                $attributes[] = "$key: $value";
                            }
                            $productName .= ' (' . implode(', ', $attributes) . ')';
                        }
                    }
                } else {
                    // Kiểm tra tồn kho sản phẩm chính
                    $availableQuantity = $item->product->quantity;
                }

                if ($availableQuantity <= 0) {
                    $outOfStockItems[] = [
                        'name' => $productName,
                        'requested' => $item->quantity,
                        'available' => 0
                    ];
                } elseif ($availableQuantity < $item->quantity) {
                    $insufficientStockItems[] = [
                        'name' => $productName,
                        'requested' => $item->quantity,
                        'available' => $availableQuantity
                    ];
                } else {
                    $availableItems[] = $item;
                }
            }

            // Nếu có sản phẩm hết hàng hoặc không đủ số lượng
            if (!empty($outOfStockItems) || !empty($insufficientStockItems)) {
                
                // Chuẩn bị dữ liệu cho session để hiển thị chi tiết
                $stockInfo = [
                    'out_of_stock' => $outOfStockItems,
                    'insufficient_stock' => $insufficientStockItems,
                    'available_items' => count($availableItems)
                ];
                
                if (!empty($availableItems)) {
                    // Thêm các sản phẩm có thể mua vào giỏ hàng
                    foreach ($availableItems as $item) {
                        $this->addItemToCart($item);
                    }
                    
                    Session::flash('reorder_stock_info', $stockInfo);
                    Session::flash('reorder_partial_success', true);
                    
                    return redirect()->route('cart.index')->with('warning', 'Một số sản phẩm không thể mua lại do hết hàng hoặc không đủ số lượng. Những sản phẩm còn đủ đã được thêm vào giỏ hàng.');
                } else {
                    Session::flash('reorder_stock_info', $stockInfo);
                    return redirect()->back()->with('error', 'Không thể mua lại đơn hàng do tất cả sản phẩm đều hết hàng hoặc không đủ số lượng.');
                }
            }

            // Nếu tất cả sản phẩm đều có đủ số lượng, thêm vào giỏ hàng
            foreach ($availableItems as $item) {
                $this->addItemToCart($item);
            }

            Log::info('Mua lại đơn hàng thành công', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'items_added' => count($availableItems)
            ]);

            return redirect()->route('cart.index')->with('success', 'Tất cả sản phẩm đã được thêm vào giỏ hàng thành công!');
        });
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    private function addItemToCart($item)
    {
        $cartOptions = [
            'image' => $item->product->image,
            'product_id' => $item->product_id,
        ];

        if ($item->variant_id) {
            $cartOptions['type'] = 'variant';
            $cartOptions['variant_id'] = $item->variant_id;
            
            if ($item->variant_details) {
                $cartOptions['variant_attributes'] = json_decode($item->variant_details, true);
            }
        }

        Cart::add([
            'id' => $item->variant_id ? 'variant_' . $item->variant_id : $item->product_id,
            'name' => $item->product->name,
            'qty' => $item->quantity,
            'price' => $item->price,
            'options' => $cartOptions
        ]);
    }
}