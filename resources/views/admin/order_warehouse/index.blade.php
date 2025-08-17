@extends('layouts.admin')

@section('content')
<div class="container py-4">

    {{-- Tiêu đề & nút tạo --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Danh sách đơn nhập hàng</h4>
        <div>
            <button class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-export me-1"></i> Xuất file
            </button>
            <button class="btn btn-outline-secondary me-2">
                <i class="fas fa-file-import me-1"></i> Nhập file
            </button>
            <a href="{{ route('warehouse.import_creater', ['review' => 1]) }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Tạo đơn nhập hàng
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
                        <th><input type="checkbox"></th>
                        <th>Mã đơn nhập</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Trạng thái nhập</th>
                        <th>Nhà cung cấp</th>
                        <th>Nhân viên tạo</th>
                        <th>Giá Trị Đơn</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($imports as $import)
                    <tr>
                        <td><input type="checkbox"></td>
                        <td class="text-primary fw-semibold text-break" style="max-width: 200px;">
                            <a href="{{ route('warehouse.show', $import->id) }}" class="text-decoration-none">
                                {{ $import->code }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($import->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success">{{ $import->status ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning border border-warning">{{ $import->import_type ?? '-' }}</span>
                        </td>
                        <td>{{ $import->supplier->name ?? '-' }}</td>
                        <td>{{ $import->user->name ?? '-' }}</td>
                        <td>{{ number_format($import->total_price) }}₫</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Không có đơn nhập nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($imports->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $imports->firstItem() }} đến {{ $imports->lastItem() }} trong tổng số {{ $imports->total() }} Đơn Hàng
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
@endsection
