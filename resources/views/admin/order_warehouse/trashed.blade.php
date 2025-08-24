@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container py-4">



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
        <button class="btn btn-outline-secondary">Lọc</button>
        <a href="{{ route('warehouse.list') }}" class="btn btn-light">Xóa lọc</a>
    </form>

    {{-- Danh sách đơn --}}
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-nowrap">
                        <th>Mã đơn nhập</th>
                        <th>Ngày Xóa</th>
                        <th>Trạng thái</th>
                        <th>Trạng thái nhập</th>
                        <th>Nhà cung cấp</th>
                        <th>Nhân viên tạo</th>
                        <th>Giá Trị Đơn</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($imports as $import)
                    <tr>
                        <td class="text-primary fw-semibold text-break" style="max-width: 200px;">
                            <a href="{{ route('warehouse.showDeleted', $import->id) }}" class="text-decoration-none">
                                {{ $import->code }}
                            </a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($import->deleted_at)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-success-subtle text-success border border-success">{{ $import->status ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning-subtle text-warning border border-warning">{{ $import->import_type ?? '-' }}</span>
                        </td>
                        <td>{{ $import->supplier->name ?? '-' }}</td>
                        <td>{{ $import->user->name ?? '-' }}</td>
                        <td>{{ number_format($import->total_price) }}₫</td>
                        <td>
                            {{-- Form khôi phục --}}
                            <form action="{{ route('warehouse.restore', $import->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success"
                                    onclick="return confirm('Bạn có chắc muốn khôi phục đơn này?')">
                                    <i class="fas fa-undo"></i> Khôi phục
                                </button>
                            </form>

                            {{-- Form xóa vĩnh viễn --}}
                            <form action="{{ route('warehouse.forceDestroy', $import->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn đơn này? Hành động này không thể hoàn tác.')">
                                    <i class="fas fa-trash-alt"></i> Xóa vĩnh viễn
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
