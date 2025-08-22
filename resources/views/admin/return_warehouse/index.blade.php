@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Tiêu đề & nút tạo --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Danh sách đơn trả hàng</h4>
        <div>
            <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReturnModal">
                <i class="fas fa-plus-circle me-1"></i> Tạo đơn trả hàng
            </a>
        </div>
    </div>

    {{-- Tabs trạng thái --}}
    @php
    $currentStatus = request('status');
    @endphp
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ !$currentStatus ? 'active' : '' }}"
                href="{{ route('warehouse.list', request()->except('status')) }}">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'dang-giao-dich' ? 'active' : '' }}"
                href="{{ route('warehouse.list', array_merge(request()->except('page'), ['status' => 'dang-giao-dich'])) }}">Đang giao dịch</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'hoan-thanh' ? 'active' : '' }}"
                href="{{ route('warehouse.list', array_merge(request()->except('page'), ['status' => 'hoan-thanh'])) }}">Hoàn thành</a>
        </li>
    </ul>

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

    @if(session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    {{-- Bộ lọc tìm kiếm --}}
    <form method="GET" action="{{ route('warehouse.list') }}" class="d-flex flex-wrap gap-2 mb-3">
        <input type="date" name="date" class="form-control" style="max-width: 180px;" value="{{ request('date') }}">

        <select name="status" class="form-select" style="max-width: 180px;">
            <option value="">Tất cả trạng thái</option>
            <option value="dang-giao-dich" {{ request('status') == 'dang-giao-dich' ? 'selected' : '' }}>Đang giao dịch</option>
            <option value="hoan-thanh" {{ request('status') == 'hoan-thanh' ? 'selected' : '' }}>Hoàn thành</option>
        </select>

        <button class="btn btn-outline-secondary">Lọc</button>
        <a href="{{ route('warehouse.list') }}" class="btn btn-light">Xóa lọc</a>
    </form>

    {{-- Danh sách đơn --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-nowrap">
                        <th>Mã đơn trả</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                        <th>Nhà cung cấp</th>
                        <th>Nhân viên tạo</th>
                        <th>Giá Trị Đơn</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                    <tr>
                        <td class="text-primary fw-semibold text-break" style="max-width: 200px;">
                            <a href="{{ route('returns.details', $return->id) }}" class="text-decoration-none">
                                {{ $return->return_code }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($return->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success">{{ $return->return_status ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning border border-warning">{{ $return->refund_status ?? '-' }}</span>
                        </td>
                        <td>{{ $return->supplier->name ?? '-' }}</td>
                        <td>{{ $return->user->name ?? '-' }}</td>
                        <td>{{ number_format($return->total_amount) }}₫</td>
                        <td>
                            <form action="{{ route('returns.destroy', $return->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Xóa">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Không có đơn nhập nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($returns->hasPages())
        <div class="row mx-3 justify-content-between mt-4">
            <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                <div class="dt-info">
                    Hiển thị {{ $returns->firstItem() }} đến {{ $imports->lastItem() }} trong tổng số {{ $imports->total() }} Đơn Hàng
                </div>
            </div>

            <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                <div class="dt-paging">
                    <nav aria-label="pagination">
                        <ul class="pagination">
                            {{-- First --}}
                            <li class="dt-paging-button page-item {{ $imports->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link first" href="{{ $imports->url(1) }}">
                                    <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                </a>
                            </li>

                            {{-- Previous --}}
                            <li class="dt-paging-button page-item {{ $imports->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link previous" href="{{ $imports->previousPageUrl() }}">
                                    <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                </a>
                            </li>

                            {{-- Page numbers --}}
                            @foreach ($imports->getUrlRange(
                            max(1, $imports->currentPage() - 2),
                            min($imports->lastPage(), $imports->currentPage() + 2)
                            ) as $page => $url)
                            <li class="dt-paging-button page-item {{ $imports->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endforeach

                            {{-- Dấu 3 chấm nếu có --}}
                            @if ($imports->lastPage() > $imports->currentPage() + 2)
                            <li class="dt-paging-button page-item disabled">
                                <span class="page-link ellipsis">…</span>
                            </li>
                            <li class="dt-paging-button page-item">
                                <a class="page-link" href="{{ $imports->url($imports->lastPage()) }}">{{ $imports->lastPage() }}</a>
                            </li>
                            @endif

                            {{-- Next --}}
                            <li class="dt-paging-button page-item {{ !$imports->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link next" href="{{ $imports->nextPageUrl() }}">
                                    <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                </a>
                            </li>

                            {{-- Last --}}
                            <li class="dt-paging-button page-item {{ !$imports->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link last" href="{{ $imports->url($imports->lastPage()) }}">
                                    <i class="icon-base ti tabler-chevrons-right icon-18px"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>
<!-- Modal chọn đơn nhập để trả -->
<div class="modal fade" id="createReturnModal" tabindex="-1" aria-labelledby="createReturnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createReturnModalLabel">Chọn đơn nhập hàng để trả</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <!-- Ô tìm kiếm -->
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchImport" class="form-control" placeholder="Tìm theo mã đơn, NCC, nhân viên...">
                </div>

                <!-- Bảng đơn nhập -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Mã đơn nhập</th>
                                <th>Ngày tạo</th>
                                <th>Nhân viên</th>
                                <th>Nhà cung cấp</th>
                                <th>Giá trị đơn nhập</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="importList">
                            @foreach($imports as $import)
                            <tr>
                                <td>{{ \Illuminate\Support\Str::limit($import->code, 10) }}</td>
                                <td>{{ \Carbon\Carbon::parse($import->created_at)->format('d/m/Y H:i') }}</td>
                                <td>{{ $import->user->name ?? '-' }}</td>
                                <td>{{ $import->supplier->name ?? '-' }}</td>
                                <td>{{ number_format($import->total_price) }}₫</td>
                                <td>
                                    <a href="{{ route('returns.show', $import->id) }}" class="btn btn-sm btn-link text-primary">Trả hàng</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

@endsection
