@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Chi tiết đơn hàng: {{ $order->order_code }}</h1>

    <p><strong>Người đặt:</strong> {{ $order->user->name ?? 'Khách vãng lai' }}</p>
    <p><strong>Email:</strong> {{ $order->email }}</p>
    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Trạng thái:</strong>
        @switch($order->status)
        @case('ordered')
        Đặt hàng
        @break
        @case('processing')
        Đang xử lý
        @break
        @case('confirmed')
        Đã xác nhận
        @break
        @case('shipping')
        Đang giao hàng
        @break
        @case('delivered')
        Đã giao
        @break
        @case('cancelled')
        Đã hủy
        @break
        @case('returned')
        Trả hàng
        @break
        @default
        Không xác định
        @endswitch
    </p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }}₫</p>

    <h3>Sản phẩm</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->product_name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}₫</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="status">Cập nhật trạng thái:</label>
            <select name="status" id="status" class="form-control">
                <option value="ordered" {{ $order->status === 'ordered' ? 'selected' : '' }}>Đặt hàng</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>Trả hàng</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection