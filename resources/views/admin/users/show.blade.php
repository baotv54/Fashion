@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="card">
    <div class="card-header border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Chi tiết khách hàng</h5>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="icon-base ti tabler-arrow-left icon-16px me-1"></i>
                Quay lại
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Thông tin khách hàng -->
        <div class="row mb-4">
            <div class="col-md-3 text-center">
                @if($user->avatar)
                    <img src="{{ asset('avatars/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" width="120" height="120">
                @else
                    <div class="avatar avatar-xl mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary" style="font-size: 3rem;">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </span>
                    </div>
                @endif
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                @if($user->phone)
                    <p class="text-muted">{{ $user->phone }}</p>
                @endif
            </div>
            
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['total_orders'] ?? 0 }}</h3>
                                <p class="mb-0">Tổng đơn hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['completed_orders'] ?? 0 }}</h3>
                                <p class="mb-0">Đơn thành công</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['pending_orders'] ?? 0 }}</h3>
                                <p class="mb-0">Đơn chờ xử lý</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['cancelled_orders'] ?? 0 }}</h3>
                                <p class="mb-0">Đơn đã hủy</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h3>{{ number_format($stats['total_spent'] ?? 0) }} ₫</h3>
                                <p class="mb-0">Tổng chi tiêu</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $user->created_at->format('d/m/Y') }}</h3>
                                <p class="mb-0">Ngày tham gia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs cho đơn hàng -->
        <ul class="nav nav-tabs mb-3" id="orderTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                    Tất cả đơn hàng ({{ $stats['total_orders'] ?? 0 }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                    Đơn thành công ({{ $stats['completed_orders'] ?? 0 }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                    Đơn chờ xử lý ({{ $stats['pending_orders'] ?? 0 }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">
                    Đơn đã hủy ({{ $stats['cancelled_orders'] ?? 0 }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="orderTabsContent">
            <!-- Tab tất cả đơn hàng -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <strong>#{{ $order->id }}</strong>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount) }} ₫</td>
                                <td>
                                    @php
                                    $statusColors = [
                                        'ordered' => 'warning',
                                        'processing' => 'info',
                                        'confirmed' => 'primary',
                                        'shipping' => 'warning',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                        'returned' => 'dark'
                                    ];
                                    $statusLabels = [
                                        'ordered' => 'Đặt hàng',
                                        'processing' => 'Đang xử lý',
                                        'confirmed' => 'Đã xác nhận',
                                        'shipping' => 'Đang giao hàng',
                                        'delivered' => 'Đã giao',
                                        'cancelled' => 'Đã hủy',
                                        'returned' => 'Trả hàng'
                                    ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="icon-base ti tabler-eye icon-16px"></i>
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có đơn hàng nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab đơn thành công -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Ngày hoàn thành</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($completedOrders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount) }} ₫</td>
                                <td>
                                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="icon-base ti tabler-eye icon-16px"></i>
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có đơn hàng thành công</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab đơn chờ xử lý -->
            <div class="tab-pane fade" id="pending" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingOrders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount) }} ₫</td>
                                <td>
                                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="icon-base ti tabler-eye icon-16px"></i>
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có đơn hàng chờ xử lý</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab đơn đã hủy -->
            <div class="tab-pane fade" id="cancelled" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Ngày hủy</th>
                                <th>Tổng tiền</th>
                                <th>Lý do hủy</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cancelledOrders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount) }} ₫</td>
                                <td>{{ $order->cancel_reason ?? 'Không có' }}</td>
                                <td>
                                    <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="icon-base ti tabler-eye icon-16px"></i>
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có đơn hàng đã hủy</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#orderTabs button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
    });
});
</script>
@endsection 