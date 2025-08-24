@extends('layouts.admin')

@section('content')
<div class="card mb-6">
    <div class="card-widget-separator-wrapper">
        @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        @endif
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                        <div>
                            <h4 class="mb-0">{{ $ordered }}</h4>
                            <p class="mb-0">Đã Đặt</p>
                        </div>
                        <span class="avatar me-sm-6">
                            <span class="avatar-initial bg-label-secondary rounded text-heading">
                                <i class="icon-base ti tabler-calendar-stats icon-26px text-heading"></i>
                            </span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-6">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                        <div>
                            <h4 class="mb-0">{{$delivered}}</h4>
                            <p class="mb-0">Hoàn Thành</p>
                        </div>
                        <span class="avatar p-2 me-lg-6">
                            <span class="avatar-initial bg-label-secondary rounded"><i class="icon-base ti tabler-checks icon-26px text-heading"></i></span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                        <div>
                            <h4 class="mb-0">{{$returned}}</h4>
                            <p class="mb-0">Trả Hàng</p>
                        </div>
                        <span class="avatar p-2 me-sm-6">
                            <span class="avatar-initial bg-label-secondary rounded"><i class="icon-base ti tabler-wallet icon-26px text-heading"></i></span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="mb-0">{{$cancelled}}</h4>
                            <p class="mb-0">Đã Hủy</p>
                        </div>
                        <span class="avatar p-2">
                            <span class="avatar-initial bg-label-secondary rounded"><i class="icon-base ti tabler-alert-octagon icon-26px text-heading"></i></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-datatable table-responsive">
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            {{-- Header: Thanh tìm kiếm và Export --}}
            <div class="row mx-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
                    <div class="dt-search">

                    </div>
                </div>
            </div>

            {{-- Bảng dữ liệu --}}
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    {{-- Nav tabs --}}
                    <ul class="nav nav-tabs mb-3">
                        @php
                        $statuses = [
                        'all' => 'Tất cả',
                        'ordered' => 'Đã đặt',
                        'processing' => 'Đang xử lý',
                        'confirmed' => 'Đã xác nhận',
                        'shipping' => 'Đang giao',
                        'delivered' => 'Đã giao',
                        'cancelled' => 'Đã hủy',
                        'returned' => 'Trả hàng',
                        ];
                        @endphp
                        @foreach ($statuses as $key => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ $currentStatus === $key ? 'active' : '' }}"
                                href="{{ route('orders.index', ['status' => $key]) }}">
                                {{ $label }} (<small style="color: red;">{{ $counts[$key] ?? 0 }}</small>)
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <table class="datatables-order table border-top dataTable dtr-column collapsed" id="DataTables_Table_0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Mã đơn</th>
                                <th>Ngày</th>
                                <th>Khách hàng</th>
                                <th>Trạng thái</th>
                                <th>Phương thức</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}" title="Chi tiết đơn hàng">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Modal Chi tiết đơn hàng -->
                                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết đơn hàng: #{{ $order->order_code }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered mb-4">
                                                        <tr>
                                                            <th>Người đặt</th>
                                                            <td>{{ $order->user->name ?? 'Khách vãng lai' }}
                                                                <br>
                                                                <small>{{ $order->email }}</small>
                                                                <br>
                                                                <small>{{$order->phone}}</small>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ngày đặt</th>
                                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Trạng thái</th>
                                                            <td>
                                                                @php
                                                                $map = [
                                                                'ordered' => 'Đã đặt',
                                                                'processing' => 'Đang xử lý',
                                                                'confirmed' => 'Đã xác nhận',
                                                                'shipping' => 'Đang giao',
                                                                'delivered' => 'Đã giao',
                                                                'cancelled' => 'Đã hủy',
                                                                'returned' => 'Trả hàng',
                                                                ];
                                                                @endphp
                                                                <span class="badge bg-label-{{ $order->status == 'cancelled' ? 'danger' : 'primary' }}">
                                                                    {{ $map[$order->status] ?? 'Không xác định' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phương thức thanh toán</th>
                                                            <td>{{ ucfirst($order->payment_method) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tổng tiền</th>
                                                            <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hành động</th>
                                                            <td>
                                                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @php
                                                                    $nextStatus = [
                                                                    'ordered' => 'processing',
                                                                    'processing' => 'confirmed',
                                                                    'confirmed' => 'shipping',
                                                                    'shipping' => 'delivered',
                                                                    ];

                                                                    $statusLabel = [
                                                                    'ordered' => 'Đang xử lý',
                                                                    'processing' => 'Đã xác nhận',
                                                                    'confirmed' => 'Đang giao hàng',
                                                                    'shipping' => 'Đã giao',
                                                                    ];

                                                                    $current = $order->status;
                                                                    @endphp

                                                                    @if (array_key_exists($current, $nextStatus))
                                                                    <input type="hidden" name="status" value="{{ $nextStatus[$current] }}">
                                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                                        Cập nhật: {{ $statusLabel[$current] }}
                                                                    </button>
                                                                    @elseif ($current === 'delivered')
                                                                    <span class="badge bg-label-success">Đã hoàn tất</span>
                                                                    @elseif ($current === 'cancelled')
                                                                    <span class="badge bg-label-danger">Đã hủy</span>
                                                                    @elseif ($current === 'returned')
                                                                    <span class="badge bg-label-warning">Trả hàng</span>
                                                                    @else
                                                                    <span class="badge bg-label-secondary">Không xác định</span>
                                                                    @endif
                                                                </form>

                                                                @if($order->status === 'shipping')
                                                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value="cancelled">
                                                                    <input type="hidden" name="cancel_reason" value="Giao Hàng Thất Bại">
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        Giao Thất Bại
                                                                    </button>
                                                                </form>
                                                                @endif

                                                            </td>
                                                    </table>

                                                    <h6 class="mb-3">Danh sách sản phẩm:</h6>
                                                    <table class="table table-sm table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Sản phẩm</th>
                                                                <th>Biến thể</th>
                                                                <th>Giá</th>
                                                                <th>Số lượng</th>
                                                                <th>Thành tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order->orderDetails as $detail)
                                                            <tr>
                                                                <td>{{ $detail->product_name }}</td>
                                                                <td>{{ $detail->variation_name ?? 'Mặc định' }}</td>
                                                                <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                                                                <td>{{ $detail->quantity }}</td>
                                                                <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="text-end">
                                                        <strong>Tổng cộng: {{ number_format($order->total, 0, ',', '.') }} VNĐ</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span>#{{ $order->order_code }}</span></td>
                                <td><span class="text-nowrap">{{ $order->created_at->format('d/m/Y, H:i') }}</span></td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center order-name text-nowrap">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($order->user->name ?? 'K', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="m-0">
                                                <a href="#" class="text-heading">{{ $order->user->name ?? 'Khách vãng lai' }}</a>
                                            </h6>
                                            <small>{{ $order->email }}</small>
                                            <small>{{$order->phone}}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                    $map = [
                                    'ordered' => ['text' => 'Đã đặt', 'color' => 'primary'],
                                    'processing' => ['text' => 'Đang xử lý', 'color' => 'info'],
                                    'confirmed' => ['text' => 'Đã xác nhận', 'color' => 'success'],
                                    'shipping' => ['text' => 'Đang giao', 'color' => 'warning'],
                                    'delivered' => ['text' => 'Đã giao', 'color' => 'success'],
                                    'cancelled' => ['text' => 'Đã hủy', 'color' => 'danger'],
                                    ];
                                    $status = $map[$order->status] ?? ['text' => 'Không xác định', 'color' => 'secondary'];
                                    @endphp
                                    <span class="badge px-2 bg-label-{{ $status['color'] }}">
                                        {{ $status['text'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-nowrap">
                                        <span class="ms-1">{{ ucfirst($order->payment_method) }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($order->status !== 'processing' && $order->status !== 'ordered')
                                    <a href="{{ route('orders.print', $order->id) }}" target="_blank" class="btn btn-success">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    @endif

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer: Pagination --}}
            <div class="row mx-3 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
                    <div class="dt-info">
                        Hiển thị {{ $orders->firstItem() }} đến {{ $orders->lastItem() }} trên tổng số {{ $orders->total() }} đơn hàng
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $orders->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $orders->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($orders->getUrlRange(
                                max(1, $orders->currentPage() - 2),
                                min($orders->lastPage(), $orders->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($orders->lastPage() > $orders->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $orders->url($orders->lastPage()) }}">{{ $orders->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $orders->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $orders->url($orders->lastPage()) }}">
                                        <i class="icon-base ti tabler-chevrons-right icon-18px"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection