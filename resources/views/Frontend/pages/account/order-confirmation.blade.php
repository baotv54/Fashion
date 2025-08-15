<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px;
            vertical-align: top;
        }

        .info-table .label {
            font-weight: bold;
            width: 50%;
        }

        .order-details {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th,
        .order-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .order-details th {
            background-color: #f2f2f2;
        }

        .totals {
            margin-top: 20px;
        }

        .totals p {
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }

        .cta {
            text-align: center;
            margin: 20px 0;
        }

        .cta a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Xác nhận đơn hàng</h2>
        </div>
        <div class="content">
            <p>Xin chào {{ $order->name }},</p>
            <p>Cảm ơn Anh/chị đã đặt hàng tại F1GENZ Shoes!</p>
            <p>Đơn hàng của Anh/chị đã được tiếp nhận, chúng tôi sẽ nhanh chóng liên hệ với Anh/chị.</p>

            <table class="info-table">
                <tr>
                    <td class="label">Thông tin mua hàng</td>
                    <td class="label">Địa chỉ nhận hàng</td>
                </tr>
                <tr>
                    <td>{{ $order->name }}<br>{{ $order->email }}<br>{{ $order->phone }}</td>
                    <td>{{ $order->name }}<br>{{ $order->address }}<br>{{ $order->ward }}, {{ $order->district }}, {{ $order->province }}<br>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <td class="label">Phương thức thanh toán</td>
                    <td class="label">Phương thức vận chuyển</td>
                </tr>
                <tr>
                    <td>
                        @if($order->payment_method === 'cod')
                        Thu hộ (COD)
                        @elseif($order->payment_method === 'vnpay')
                        VNPay
                        @elseif($order->payment_method === 'momo')
                        MoMo
                        @else
                        {{ ucfirst($order->payment_method) }}
                        @endif
                    </td>
                    <td>Giao hàng tận nơi</td>
                </tr>
            </table>

            <div class="order-details">
                <h3>Thông tin đơn hàng</h3>
                <p><strong>Mã đơn hàng:</strong> #{{ $order->order_code }}<br><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

                @if($order->orderDetails && $order->orderDetails->count() > 0)
                @foreach ($order->orderDetails as $item)
                <p><strong>{{ $item->product_name }}</strong><br>
                    @if($item->variant_details)
                    @php
                    $variantData = json_decode($item->variant_details, true);
                    @endphp
                    @if(isset($variantData['size']))
                    Size: {{ $variantData['size'] }}<br>
                    @endif
                    @if(isset($variantData['color']))
                    Màu: {{ $variantData['color'] }}<br>
                    @endif
                    @endif
                    @if($item->variant_id)
                    SKU: {{ $item->variant_id }}<br>
                    @endif
                    {{ number_format($item->price, 0, ',', '.') }} VND x {{ $item->quantity }}<br>
                    <strong>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</strong>
                </p>
                @endforeach
                @endif

                <div class="totals">
                    <p><strong>Tạm tính:</strong> {{ number_format($order->subtotal, 0, ',', '.') }} VND</p>
                    @if($order->discount > 0)
                    <p><strong>Giảm giá:</strong> -{{ number_format($order->discount, 0, ',', '.') }} VND</p>
                    <p><strong>Giá trừ khuyến mãi:</strong> {{ number_format($order->subtotal - $order->discount, 0, ',', '.') }} VND</p>
                    @endif
                    <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee, 0, ',', '.') }} VND</p>
                    <p><strong>Thành tiền:</strong> {{ number_format($order->total, 0, ',', '.') }} VND</p>
                </div>
            </div>

            @if($order->note)
            <div style="margin-top: 15px;">
                <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
            </div>
            @endif

            <div class="cta">
                <p>Để kiểm tra trạng thái đơn hàng, Anh/chị vui lòng: <a href="{{ url('/account') }}">Đăng nhập vào tài khoản</a></p>
            </div>
        </div>
        <div class="footer">
            <p>Nếu Anh/chị có bất kỳ câu hỏi nào, xin liên hệ với chúng tôi tại <a href="mailto:support@f1genz.com">support@f1genz.com</a></p>
            <p>Trân trọng,<br>Ban quản trị cửa hàng F1GENZ Shoes</p>
        </div>
    </div>
</body>

</html>