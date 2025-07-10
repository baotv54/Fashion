<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

use Illuminate\Support\Facades\Auth;

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
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    public function userOrderHistory()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('Frontend.pages.account.orders', compact('orders')); // Truyền $orders sang view
    }
    public function userOrderDetails($id)
    {
        // Lấy thông tin đơn hàng của người dùng hiện tại
        $order = Order::with(['orderDetails.product'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Trả về view chi tiết đơn hàng
        return view('Frontend.pages.account.order-detail', compact('order'));
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

    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['ordered', 'processing', 'confirmed'])
            ->firstOrFail();

        $order->status = 'cancelled';
        $order->save();

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
}
