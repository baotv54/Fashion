<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        if (Cart::count() == 0) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
        }
        $request->validate([
            'email' => 'required|email',
            'billingName' => 'required|max:255',
            'billingPhone' => 'required|max:15',
            'billingAddress' => 'required|max:255',
            'billingProvince' => 'required|max:255',
            'billingDistrict' => 'required|max:255',
            'billingWard' => 'required|max:255',
            'paymentMethod' => 'required|in:cod,vnpay,bank_transfer',

        ]);
        if ($request->paymentMethod === 'vnpay') {
            return $this->vnpay_payment($request);
        }
        $orderCode = 'ORDER-' . strtoupper(uniqid());

        // Tính toán tổng giá trị đơn hàng
        $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal()));
        $discount = floatval(Session::get('coupon.discount', 0));
        $total = $subtotal - $discount;

        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'order_code' => $orderCode,
            'email' => $request->email,
            'name' => $request->billingName,
            'phone' => $request->billingPhone,
            'address' => $request->billingAddress,
            'province' => $request->billingProvince,
            'district' => $request->billingDistrict,
            'ward' => $request->billingWard,
            'note' => $request->note,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => $request->paymentMethod,
            'status' => 'pending',
        ]);

        foreach (Cart::content() as $cartItem) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->id,
                'product_name' => $cartItem->name,
                'quantity' => $cartItem->qty,
                'price' => $cartItem->price,
            ]);
        }

        Cart::destroy();
        Session::forget('coupon');

        return redirect()->route('checkout.success', ['order_id' => $order->id]);
    }
    public function vnpay_payment(Request $request)
    {
        // Tạo mã đơn hàng
        $orderCode = 'ORDER-' . strtoupper(uniqid());

        // Tính toán giá trị đơn hàng 
        $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal()));
        $discount = floatval(Session::get('coupon.discount', 0));
        $total = $subtotal - $discount;

        // Lưu thông tin đơn hàng vào session
        $orderData = [
            'order_code' => $orderCode,
            'email' => $request->email,
            'name' => $request->billingName,
            'phone' => $request->billingPhone,
            'address' => $request->billingAddress,
            'province' => $request->billingProvince,
            'district' => $request->billingDistrict,
            'ward' => $request->billingWard,
            'note' => $request->note,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => 'vnpay',
            'cart_items' => Cart::content()->toArray(),
        ];

        Session::put('pending_order', $orderData);

        // Thiết lập tham số cho VNPay
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/checkout/vnpay-return"; // Đảm bảo route này đã được định nghĩa
        $vnp_TmnCode = "CIBBR99S";
        $vnp_HashSecret = "DPP5XSIV3CO812NZFEKELTCGDQWQ3M93";

        // Sử dụng mã đơn hàng đã tạo
        $vnp_TxnRef = $orderCode;
        $vnp_Amount = (int)($total * 100);

        $vnp_Params = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $request->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toan don hang " . $orderCode,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        // Sắp xếp và tạo chữ ký
        ksort($vnp_Params);
        $i = 0;
        $hashdata = "";
        foreach ($vnp_Params as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Params['vnp_SecureHash'] = $secureHash;

        $queryString = http_build_query($vnp_Params);
        $vnp_Url .= "?" . $queryString;

        return redirect($vnp_Url);
    }

    public function vnpay_return(Request $request)
    {
        // Khởi tạo các biến từ môi trường
        $vnp_TmnCode = "CIBBR99S";
        $vnp_HashSecret = "DPP5XSIV3CO812NZFEKELTCGDQWQ3M93";

        // Thu thập dữ liệu từ VNPay gửi về
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        // Lấy giá trị vnp_SecureHash
        if (isset($inputData['vnp_SecureHash'])) {
            $vnp_SecureHash = $inputData['vnp_SecureHash'];
            // Xóa vnp_SecureHash ra khỏi mảng để tính toán lại hash
            unset($inputData['vnp_SecureHash']);
        } else {
            return redirect()->route('checkout.failed')->with('error', 'Dữ liệu không hợp lệ!');
        }

        // Sắp xếp mảng theo thứ tự a-z và tạo chuỗi hash
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        // Tính toán lại hash để xác thực
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Xác thực chữ ký
        if ($secureHash == $vnp_SecureHash) {
            // Lấy thông tin đơn hàng từ session
            if (!Session::has('pending_order')) {
                return redirect()->route('checkout.failed')->with('error', 'Thông tin đơn hàng không hợp lệ!');
            }

            $orderData = Session::get('pending_order');

            // Xác nhận mã đơn hàng
            if (!isset($inputData['vnp_TxnRef'])) {
                return redirect()->route('checkout.failed')->with('error', 'Thiếu thông tin mã đơn hàng!');
            }

            $orderCode = $inputData['vnp_TxnRef'];

            // Kiểm tra mã đơn hàng có khớp không
            if ($orderData['order_code'] != $orderCode) {
                return redirect()->route('checkout.failed')->with('error', 'Mã đơn hàng không khớp!');
            }

            // Kiểm tra mã phản hồi từ VNPay
            if (isset($inputData['vnp_ResponseCode'])) {
                if ($inputData['vnp_ResponseCode'] == '00') {
                    // Thanh toán thành công - tạo đơn hàng trong database
                    $order = Order::create([
                        'user_id' => Auth::check() ? Auth::id() : null,
                        'order_code' => $orderCode,
                        'email' => $orderData['email'],
                        'name' => $orderData['name'],
                        'phone' => $orderData['phone'],
                        'address' => $orderData['address'],
                        'province' => $orderData['province'],
                        'district' => $orderData['district'],
                        'ward' => $orderData['ward'],
                        'note' => $orderData['note'],
                        'subtotal' => $orderData['subtotal'],
                        'discount' => $orderData['discount'],
                        'total' => $orderData['total'],
                        'payment_method' => 'vnpay',
                        'status' => 'processing',
                        'payment_status' => 'paid'
                    ]);

                    // Lưu chi tiết đơn hàng
                    foreach ($orderData['cart_items'] as $cartItem) {
                        OrderDetail::create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem['id'],
                            'product_name' => $cartItem['name'],
                            'quantity' => $cartItem['qty'],
                            'price' => $cartItem['price'],
                        ]);
                    }

                    // Xóa giỏ hàng và coupon
                    Cart::destroy();
                    Session::forget('coupon');
                    Session::forget('pending_order');

                    return redirect()->route('checkout.success')->with('success', 'Thanh toán thành công!');
                } else {
                    // Thanh toán thất bại
                    return redirect()->route('checkout.failed')->with('error', 'Thanh toán không thành công. Mã lỗi: ' . $inputData['vnp_ResponseCode']);
                }
            } else {
                return redirect()->route('checkout.failed')->with('error', 'Thiếu mã phản hồi từ cổng thanh toán!');
            }
        } else {
            return redirect()->route('checkout.failed')->with('error', 'Chữ ký không hợp lệ!');
        }
    }
}
