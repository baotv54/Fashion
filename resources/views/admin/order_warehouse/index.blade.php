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
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Tất cả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Đang giao dịch</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Hoàn thành</a>
        </li>
    </ul>

    {{-- Bộ lọc tìm kiếm --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <input type="text" class="form-control flex-grow-1" placeholder="Tìm theo mã đơn, tên, SĐT, mã NCC">
        <select class="form-select" style="max-width: 180px;">
            <option selected>Trạng thái nhập</option>
            <option>Chưa nhập</option>
            <option>Đã nhập</option>
        </select>
        <input type="date" class="form-control" style="max-width: 180px;">
        <input type="text" class="form-control" placeholder="Sản phẩm" style="max-width: 180px;">
        <button class="btn btn-outline-secondary">Bộ lọc khác</button>
        <button class="btn btn-light">Lưu bộ lọc</button>
    </div>

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
                        <td>{{ $import->total_price ?? '-' }}</td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Không có đơn nhập nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $imports->links() }}
    </div>
</div>
@endsection
