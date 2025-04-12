@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Danh sách đơn hàng</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Người đặt</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->order_code }}</td>
                <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->address }}, {{ $order->ward }}, {{ $order->district }}, {{ $order->province }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ number_format($order->total, 0, ',', '.') }}₫</td>
                <td>
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
                </td>
                <td>
                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection