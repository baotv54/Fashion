<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
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
            'paymentMethod' => 'required|in:cod,vnpay,bank_transfer,momo',

        ]);
        if ($request->paymentMethod === 'momo') {
            return $this->momo_payment($request);
        }
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
            'province' => $request->billingProvinceName,
            'district' => $request->billingDistrictName,
            'ward' => $request->billingWardName,
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
        if (Session::has('coupon')) {
            $code = Session::get('coupon.code');

            $coupon = Coupon::where('code', $code)->first();
            if ($coupon) {
                $coupon->increment('used'); // Tăng số lần đã sử dụng lên 1
            }

            Session::forget('coupon'); // Xóa coupon khỏi session sau khi dùng xong
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
            'province' => $request->billingProvinceName, // ✅ dùng tên
            'district' => $request->billingDistrictName, // ✅ dùng tên
            'ward' => $request->billingWardName,
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
                    // Giảm số lần sử dụng coupon nếu có
                    if (Session::has('coupon')) {
                        $code = Session::get('coupon.code');
                        $coupon = Coupon::where('code', $code)->first();
                        if ($coupon) {
                            $coupon->increment('used');
                        }
                    }

                    // Xóa giỏ hàng và coupon
                    Cart::destroy();
                    Session::forget('coupon');
                    Session::forget('pending_order');

                    return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Thanh toán thành công!');
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


    public function momo_payment(Request $request)
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
            'province' => $request->billingProvinceName, 
            'district' => $request->billingDistrictName, 
            'ward' => $request->billingWardName,
            'note' => $request->note,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => 'momo',
            'cart_items' => Cart::content()->toArray(),
        ];

        Session::put('pending_order', $orderData);

        // Cấu hình MoMo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán đơn hàng " . $orderCode;
        $amount = (int)$total;
        $orderId = $orderCode;
        $redirectUrl = route('checkout.momo-return'); // Sử dụng route đã định nghĩa
        $ipnUrl = route('checkout.momo-ipn'); // IPN URL để MoMo gửi callback
        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";

        // Tạo chữ ký HMAC SHA256
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        } else {
            // Xử lý khi không nhận được URL thanh toán
            return redirect()->route('checkout.failed')->with('error', 'Không thể kết nối với cổng thanh toán MoMo.');
        }
    }

    // Method to handle MoMo payment return
    public function momo_return(Request $request)
    {
        // Lấy thông tin đơn hàng từ session
        if (!Session::has('pending_order')) {
            return redirect()->route('checkout.failed')->with('error', 'Thông tin đơn hàng không hợp lệ!');
        }

        $orderData = Session::get('pending_order');
        $orderCode = $orderData['order_code'];

        // Kiểm tra kết quả thanh toán từ MoMo
        if ($request->has('resultCode')) {
            if ($request->resultCode == '0') {
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
                    'payment_method' => 'momo',
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
                // Giảm số lần sử dụng coupon nếu có
                if (Session::has('coupon')) {
                    $code = Session::get('coupon.code');
                    $coupon = Coupon::where('code', $code)->first();
                    if ($coupon) {
                        $coupon->increment('used');
                    }
                }

                // Xóa giỏ hàng và coupon
                Cart::destroy();
                Session::forget('coupon');
                Session::forget('pending_order');

                // Truyền order_id khi chuyển hướng
                return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Thanh toán thành công!');
            } else {
                // Thanh toán thất bại
                return redirect()->route('checkout.failed')->with('error', 'Thanh toán không thành công. Mã lỗi: ' . $request->resultCode);
            }
        } else {
            return redirect()->route('checkout.failed')->with('error', 'Thiếu thông tin phản hồi từ cổng thanh toán!');
        }
    }

    // Method to handle MoMo IPN (Instant Payment Notification)
    public function momo_ipn(Request $request)
    {
        // Khởi tạo các biến từ môi trường
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        // Xác thực chữ ký từ MoMo
        $inputData = $request->all();
        $partnerCode = $inputData["partnerCode"] ?? "";
        $orderId = $inputData["orderId"] ?? "";
        $requestId = $inputData["requestId"] ?? "";
        $amount = $inputData["amount"] ?? "";
        $orderInfo = $inputData["orderInfo"] ?? "";
        $orderType = $inputData["orderType"] ?? "";
        $transId = $inputData["transId"] ?? "";
        $resultCode = $inputData["resultCode"] ?? "";
        $message = $inputData["message"] ?? "";
        $payType = $inputData["payType"] ?? "";
        $responseTime = $inputData["responseTime"] ?? "";
        $extraData = $inputData["extraData"] ?? "";
        $m2signature = $inputData["signature"] ?? "";

        // Tạo chữ ký để xác thực
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData
            . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo
            . "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType
            . "&requestId=" . $requestId . "&responseTime=" . $responseTime . "&resultCode=" . $resultCode
            . "&transId=" . $transId;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // Kiểm tra xác thực chữ ký
        if ($m2signature == $signature) {
            // Chữ ký hợp lệ, kiểm tra kết quả giao dịch
            if ($resultCode == '0') {
                // Tìm đơn hàng theo orderId
                $order = Order::where('order_code', $orderId)->first();

                if ($order) {
                    // Cập nhật trạng thái đơn hàng
                    $order->update([
                        'status' => 'processing',
                        'payment_status' => 'paid'
                    ]);

                    // Trả về thông báo thành công cho MoMo
                    return response()->json([
                        'message' => 'Success',
                        'status' => 'ok'
                    ]);
                }
            }
        }

        // Trả về lỗi nếu xác thực thất bại hoặc giao dịch không thành công
        return response()->json([
            'message' => 'Failed',
            'status' => 'error'
        ]);
    }

    // Helper method to execute POST request
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;
    }
}
