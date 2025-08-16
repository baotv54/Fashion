<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use App\Helpers\GHNHelper;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Xử lý lưu đơn hàng và thanh toán
     */
    public function store(Request $request)
    {
        if (Cart::count() === 0) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
        }

        $this->validateRequest($request);

        return match ($request->paymentMethod) {
            'momo' => $this->momoPayment($request),
            'vnpay' => $this->vnpay_payment($request),
            default => $this->processCODPayment($request),
        };
    }

    /**
     * Validate request data
     */
    private function validateRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'billingName' => 'required|max:255',
            'billingPhone' => 'required|max:15',
            'billingAddress' => 'required|max:255',
            'billingProvince' => 'required',
            'billingDistrict' => 'required',
            'billingWard' => 'required',
            'paymentMethod' => 'required|in:cod,vnpay,bank_transfer,momo',
        ]);
    }

    /**
     * Gửi email xác nhận đơn hàng
     */
    private function sendOrderConfirmationEmail(Order $order)
    {
        try {
            // Load order details để sử dụng trong email template
            $order->load('orderDetails');
            
            Mail::to($order->email)->send(new OrderConfirmationMail($order));
            
            Log::info('Email xác nhận đơn hàng đã được gửi thành công cho order: ' . $order->order_code);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Lỗi khi gửi email xác nhận đơn hàng: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'email' => $order->email
            ]);
            
            return false;
        }
    }

    /**
     * Xử lý thanh toán COD
     */
    private function processCODPayment(Request $request)
    {
        $orderData = $this->prepareOrderData($request, 'cod');
        $order = $this->createOrder($orderData);

        foreach (Cart::content() as $cartItem) {
            $this->createOrderDetail($order, $cartItem);
        }

        $this->updateCouponUsage();
        $this->clearCartAndSession();

        // Gửi email xác nhận đơn hàng
        $this->sendOrderConfirmationEmail($order);

        return redirect()->route('checkout.success', ['order_id' => $order->id]);
    }

    /**
     * Xử lý thanh toán VNPay
     */
    private function vnpay_payment(Request $request)
    {
        $orderData = $this->prepareOrderData($request, 'vnpay');
        Session::put('pending_order', $orderData);

        $vnpParams = $this->buildVnpayParams($orderData);
        $vnpUrl = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html?" . http_build_query($vnpParams);

        return redirect($vnpUrl);
    }

    /**
     * Xử lý trả về từ VNPay
     */
    public function vnpay_return(Request $request)
    {
        if (!$this->verifyVnpaySignature($request) || !Session::has('pending_order')) {
            return redirect()->route('checkout.failed')->with('error', 'Dữ liệu không hợp lệ!');
        }

        $orderData = Session::get('pending_order');
        $inputData = $this->getVnpayInputData($request);

        if ($inputData['vnp_TxnRef'] !== $orderData['order_code'] || $inputData['vnp_ResponseCode'] !== '00') {
            return redirect()->route('checkout.failed')->with('error', 'Thanh toán không thành công. Mã lỗi: ' . ($inputData['vnp_ResponseCode'] ?? 'Unknown'));
        }

        $order = $this->createOrder($orderData);
        foreach ($orderData['cart_items'] as $cartItem) {
            $this->createOrderDetail($order, (object) $cartItem);
        }

        $this->updateCouponUsage();
        $this->clearCartAndSession();

        // Gửi email xác nhận đơn hàng
        $this->sendOrderConfirmationEmail($order);

        return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Thanh toán thành công!');
    }

    /**
     * Xử lý thanh toán MoMo
     */
    private function momoPayment(Request $request)
    {
        $orderData = $this->prepareOrderData($request, 'momo');
        Session::put('pending_order', $orderData);

        $momoData = $this->buildMomoParams($orderData);
        $result = $this->execPostRequest("https://test-payment.momo.vn/v2/gateway/api/create", json_encode($momoData));
        $jsonResult = json_decode($result, true);

        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        }

        return redirect()->route('checkout.failed')->with('error', 'Không thể kết nối với cổng thanh toán MoMo.');
    }

    /**
     * Xử lý trả về từ MoMo
     */
    public function momo_return(Request $request)
    {
        if (!Session::has('pending_order') || !$request->has('resultCode') || $request->resultCode !== '0') {
            return redirect()->route('checkout.failed')->with('error', 'Thanh toán không thành công. Mã lỗi: ' . ($request->resultCode ?? 'Unknown'));
        }

        $orderData = Session::get('pending_order');
        $order = $this->createOrder($orderData);
        foreach ($orderData['cart_items'] as $cartItem) {
            $this->createOrderDetail($order, (object) $cartItem);
        }

        $this->updateCouponUsage();
        $this->clearCartAndSession();

        // Gửi email xác nhận đơn hàng
        $this->sendOrderConfirmationEmail($order);

        return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Thanh toán thành công!');
    }

    /**
     * Xử lý IPN từ MoMo
     */
    public function momo_ipn(Request $request)
    {
        if ($this->verifyMomoSignature($request) && $request->resultCode === '0') {
            $order = Order::where('order_code', $request->orderId)->first();
            if ($order) {
                $order->update(['status' => 'processing', 'payment_status' => 'paid']);
                
                // Gửi email xác nhận khi thanh toán thành công qua IPN
                $this->sendOrderConfirmationEmail($order);
            }
            return response()->json(['message' => 'Success', 'status' => 'ok']);
        }
        return response()->json(['message' => 'Failed', 'status' => 'error']);
    }

    /**
     * Chuẩn bị dữ liệu đơn hàng
     */
    private function prepareOrderData(Request $request, $paymentMethod)
    {
        $orderCode = 'ORDER-' . strtoupper(uniqid());
        $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::subtotal()));
        $discount = floatval(Session::get('coupon.discount', 0));
        $shippingFee = floatval($request->shipping_fee ?? 0);
        $total = $subtotal - $discount + $shippingFee;

        return [
            'order_code' => $orderCode,
            'email' => $request->email,
            'name' => $request->billingName,
            'phone' => $request->billingPhone,
            'address' => $request->billingAddress,
            'province' => GHNHelper::getProvinceName($request->billingProvince),
            'district' => GHNHelper::getDistrictName($request->billingDistrict),
            'ward' => GHNHelper::getWardName($request->billingWard, $request->billingDistrict),
            'note' => $request->note,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_fee' => $shippingFee,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'cart_items' => Cart::content()->toArray(),
            'status' => $paymentMethod === 'cod' ? 'ordered' : 'pending',
            'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
        ];
    }

    /**
     * Tạo đơn hàng
     */
    private function createOrder(array $orderData)
    {
        return Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'order_code' => $orderData['order_code'],
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
            'shipping_fee' => $orderData['shipping_fee'],
            'total' => $orderData['total'],
            'payment_method' => $orderData['payment_method'],
            'status' => $orderData['status'],
            'payment_status' => $orderData['payment_status'],
        ]);
    }

    /**
     * Tạo chi tiết đơn hàng
     */
    private function createOrderDetail($order, $cartItem)
    {
        $productId = $cartItem->options['product_id'] ?? $cartItem->id;
        $variantId = null;
        $variantDetails = null;

        Log::info('Cart Item Options: ' . json_encode($cartItem->options));

        if (isset($cartItem->options['type']) && $cartItem->options['type'] === 'variant') {
            $variantId = $cartItem->options['variant_id'] ?? null;
            if (isset($cartItem->options['variant_attributes']) && !empty($cartItem->options['variant_attributes'])) {
                $variantDetails = json_encode($cartItem->options['variant_attributes']);
            }
        }

        OrderDetail::create([
            'order_id' => $order->id,
            'product_id' => $productId,
            'variant_id' => $variantId,
            'product_name' => $cartItem->name,
            'quantity' => $cartItem->qty,
            'price' => $cartItem->price,
            'variant_details' => $variantDetails,
        ]);
    }

    /**
     * Cập nhật sử dụng coupon
     */
    private function updateCouponUsage()
    {
        if (Session::has('coupon')) {
            $coupon = Coupon::where('code', Session::get('coupon.code'))->first();
            $coupon?->increment('used');
        }
    }

    /**
     * Xóa giỏ hàng và session
     */
    private function clearCartAndSession()
    {
        Cart::destroy();
        Session::forget(['coupon', 'pending_order']);
    }

    /**
     * Xây dựng tham số cho VNPay
     */
    private function buildVnpayParams($orderData)
    {
        $vnpParams = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => 'CIBBR99S',
            'vnp_Amount' => (int)($orderData['total'] * 100),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => request()->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => "Thanh toan don hang " . $orderData['order_code'],
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => route('checkout.vnpay_return'),
            'vnp_TxnRef' => $orderData['order_code'],
        ];

        ksort($vnpParams);
        $hashData = http_build_query($vnpParams);
        $vnpParams['vnp_SecureHash'] = hash_hmac('sha512', $hashData, 'DPP5XSIV3CO812NZFEKELTCGDQWQ3M93');

        return $vnpParams;
    }

    /**
     * Lấy dữ liệu đầu vào từ VNPay
     */
    private function getVnpayInputData(Request $request)
    {
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) === 'vnp_') {
                $inputData[$key] = $value;
            }
        }
        return $inputData;
    }

    /**
     * Xác thực chữ ký VNPay
     */
    private function verifyVnpaySignature(Request $request)
    {
        $inputData = $this->getVnpayInputData($request);
        $vnpSecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, 'DPP5XSIV3CO812NZFEKELTCGDQWQ3M93');

        return $secureHash === $vnpSecureHash;
    }

    /**
     * Xây dựng tham số cho MoMo
     */
    private function buildMomoParams($orderData)
    {
        $requestId = time() . '';
        $rawHash = "accessKey=klm05TvNBzhg7h7j&amount=" . $orderData['total'] . "&extraData=&ipnUrl=" . route('checkout.momo-ipn') .
            "&orderId=" . $orderData['order_code'] . "&orderInfo=Thanh toán đơn hàng " . $orderData['order_code'] .
            "&partnerCode=MOMOBKUN20180529&redirectUrl=" . route('checkout.momo-return') .
            "&requestId=" . $requestId . "&requestType=payWithATM";
        $signature = hash_hmac('sha256', $rawHash, 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');

        return [
            'partnerCode' => 'MOMOBKUN20180529',
            'partnerName' => 'Test',
            'storeId' => 'MomoTestStore',
            'requestId' => $requestId,
            'amount' => (int)$orderData['total'],
            'orderId' => $orderData['order_code'],
            'orderInfo' => "Thanh toán đơn hàng " . $orderData['order_code'],
            'redirectUrl' => route('checkout.momo-return'),
            'ipnUrl' => route('checkout.momo-ipn'),
            'lang' => 'vi',
            'extraData' => '',
            'requestType' => 'payWithATM',
            'signature' => $signature,
        ];
    }

    /**
     * Xác thực chữ ký MoMo
     */
    private function verifyMomoSignature(Request $request)
    {
        $inputData = $request->all();
        $m2signature = $inputData['signature'] ?? '';
        unset($inputData['signature']);

        $rawHash = "accessKey=klm05TvNBzhg7h7j&amount=" . ($inputData['amount'] ?? '') . "&extraData=" . ($inputData['extraData'] ?? '') .
            "&message=" . ($inputData['message'] ?? '') . "&orderId=" . ($inputData['orderId'] ?? '') . "&orderInfo=" . ($inputData['orderInfo'] ?? '') .
            "&orderType=" . ($inputData['orderType'] ?? '') . "&partnerCode=" . ($inputData['partnerCode'] ?? '') . "&payType=" . ($inputData['payType'] ?? '') .
            "&requestId=" . ($inputData['requestId'] ?? '') . "&responseTime=" . ($inputData['responseTime'] ?? '') . "&resultCode=" . ($inputData['resultCode'] ?? '') .
            "&transId=" . ($inputData['transId'] ?? '');
        $signature = hash_hmac('sha256', $rawHash, 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa');

        return $signature === $m2signature;
    }

    /**
     * Thực hiện yêu cầu POST
     */
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($data)]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}