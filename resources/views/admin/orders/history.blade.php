@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lịch sử đơn hàng</h1>

    @if ($orders->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->order_code }}</td>
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
                        <a href="{{ route('user.orders.details', $order->id) }}" class="btn btn-primary btn-sm">Xem chi tiết</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection