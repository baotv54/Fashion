    @extends('layouts.admin')

    @section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Danh sách đơn hàng</h1>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Mã đơn</th>
                                <th>Người đặt</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
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
                                <td class="text-center"><strong>{{ $order->order_code }}</strong></td>
                                <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td class="small">
                                    {{ $order->address }}, {{ $order->ward }},
                                    {{ $order->district }}, {{ $order->province }}
                                </td>
                                <td class="text-nowrap text-center">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">{{ number_format($order->total, 0, ',', '.') }}₫</td>
                                <td class="text-center">
                                    @php
                                    $statusMap = [
                                    'ordered' => ['label' => 'Đặt hàng', 'class' => 'primary'],
                                    'processing' => ['label' => 'Đang xử lý', 'class' => 'info'],
                                    'confirmed' => ['label' => 'Đã xác nhận', 'class' => 'success'],
                                    'shipping' => ['label' => 'Đang giao hàng', 'class' => 'warning'],
                                    'delivered' => ['label' => 'Đã giao', 'class' => 'success'],
                                    'cancelled' => ['label' => 'Đã hủy', 'class' => 'danger'],
                                    'returned' => ['label' => 'Trả hàng', 'class' => 'dark'],
                                    ];
                                    $status = $statusMap[$order->status] ?? ['label' => 'Không xác định', 'class' => 'light'];
                                    $textColor = in_array($status['class'], ['warning', 'light']) ? 'text-dark' : '';
                                    @endphp
                                    <span class="badge bg-{{ $status['class'] }} {{ $textColor }}">
                                        {{ $status['label'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i data-feather="eye"></i> Xem
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination (nếu có) -->
                @if(method_exists($orders, 'links'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            feather.replace();
        });
    </script>
    @endpush
    @endsection