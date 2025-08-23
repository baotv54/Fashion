<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa đơn #{{ $order->order_code }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            margin: 30px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 22px;
        }

        .shop-info {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-bottom: 10px;
        }

        .info {
            margin: 15px 0;
        }

        .info h3 {
            border-left: 4px solid #333;
            padding-left: 6px;
            font-size: 14px;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        th {
            background: #f9f9f9;
        }

        .right {
            text-align: right;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-size: 15px;
            font-weight: bold;
        }

        .note {
            margin-top: 12px;
            font-style: italic;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
        }

        .highlight {
            margin-top: 20px;
            padding: 8px;
            border: 1px dashed #E49C06;
            color: #E49C06;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h1>HÓA ĐƠN BÁN HÀNG</h1>
        <div class="shop-info">
            <p>Cửa hàng S7STUDIO</p>
        </div>
        <p><strong>Mã đơn:</strong> #{{ $order->order_code }} | <strong>Ngày đặt:</strong>
            {{ $order->created_at->format('d/m/Y') }}</p>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="info">
        <h3>Thông tin khách hàng</h3>
        <p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}, {{ $order->ward }}, {{ $order->district }},
            {{ $order->province }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Thanh toán:</strong> {{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Đã thanh toán online' }}
        </p>
    </div>

    <!-- Bảng sản phẩm -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 40%;">Sản phẩm</th>
                <th style="width: 25%;">Thuộc tính</th>
                <th style="width: 10%;">SL</th>
                <th style="width: 12%;">Đơn giá</th>
                <th style="width: 13%;">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>
                    @if ($detail->variant_id)
                    @php
                    $variantDetails = json_decode($detail->variant_details, true);
                    $attributes = [];
                    foreach ($variantDetails as $key => $value) {
                        $attributes[] = "$key: $value";
                    }
                    echo implode(', ', $attributes);
                    @endphp
                    @else
                    -
                    @endif
                </td>
                <td class="text-end">{{ $detail->quantity }}</td>
                <td class="text-end">{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                <td class="text-end">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Tổng cộng -->
    <div class="total">
        Tổng tiền: {{ number_format($order->total, 0, ',', '.') }}₫
    </div>

    <!-- Ghi chú -->
    <div class="note">
        <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có ghi chú' }}</p>
    </div>

    <!-- Ký tên -->
    <div class="row text-center mt-5">
        <div class="col-md-6">
            <p><strong>Người giao hàng</strong></p>
            <p>(Ký & ghi rõ họ tên)</p>
        </div>
        <div class="col-md-6">
            <p><strong>Người nhận hàng</strong></p>
            <p>(Ký & ghi rõ họ tên)</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="highlight">
        CHUYỂN HOÀN SAU 3 LẦN PHÁT – LƯU KHO TỐI ĐA 5 NGÀY
    </div>

    <div class="footer">
        <p>Cảm ơn quý khách đã mua hàng tại cửa hàng !</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
