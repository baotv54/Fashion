@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-4">Chi tiết đơn hàng: <span class="text-primary">{{ $order->order_code }}</span></h1>

    <!-- Thông tin đơn hàng -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    Thông tin người đặt
                </div>
                <div class="card-body">
                    <p><strong>Người đặt:</strong> {{ $order->user->name ?? 'Khách vãng lai' }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Tổng tiền:</strong> <span class="text-success fw-bold">{{ number_format($order->total, 0, ',', '.') }}₫</span></p>
                    <p>
                        <strong>Trạng thái:</strong>
                        @php
                            $statusMap = [
                                'ordered'    => ['label' => 'Đặt hàng', 'class' => 'secondary'],
                                'processing' => ['label' => 'Đang xử lý', 'class' => 'info'],
                                'confirmed'  => ['label' => 'Đã xác nhận', 'class' => 'primary'],
                                'shipping'   => ['label' => 'Đang giao hàng', 'class' => 'warning'],
                                'delivered'  => ['label' => 'Đã giao', 'class' => 'success'],
                                'cancelled'  => ['label' => 'Đã hủy', 'class' => 'danger'],
                                'returned'   => ['label' => 'Trả hàng', 'class' => 'dark'],
                            ];
                            $status = $statusMap[$order->status] ?? ['label' => 'Không xác định', 'class' => 'light'];
                            $textColor = in_array($status['class'], ['warning', 'light']) ? 'text-dark' : '';
                        @endphp
                        <span class="badge bg-{{ $status['class'] }} {{ $textColor }}">
                            {{ $status['label'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="card mb-4">
        <div class="card-header">
            Sản phẩm trong đơn hàng
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-end">Giá</th>
                        <th class="text-end">Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product_name }}</td>
                        <td class="text-center">{{ $detail->quantity }}</td>
                        <td class="text-end">{{ number_format($detail->price, 0, ',', '.') }}₫</td>
                        <td class="text-end">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form cập nhật trạng thái -->
    <div class="card">
        <div class="card-header">
            Cập nhật trạng thái đơn hàng
        </div>
        <div class="card-body">
            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="row g-3 align-items-center">
                @csrf
                <div class="col-md-6">
                    <label for="status" class="form-label">Trạng thái:</label>
                    <select name="status" id="status" class="form-select">
                        <option value="ordered"    {{ $order->status === 'ordered' ? 'selected' : '' }}>Đặt hàng</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="confirmed"  {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="shipping"   {{ $order->status === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="delivered"  {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao</option>
                        <option value="cancelled"  {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="returned"   {{ $order->status === 'returned' ? 'selected' : '' }}>Trả hàng</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">
                        <i data-feather="refresh-cw" class="me-1"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>
@endpush
@endsection
