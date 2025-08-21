@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Danh sách nhà cung cấp</h4>
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="#">Tất cả</a>
        </li>
    </ul>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
    @endif


    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-2 mb-3">
                <form method="GET" action="{{ route('suppliers.index') }}">
                    <div class="row g-3 mb-3 align-items-end">
                        <!-- Tìm kiếm -->
                        <div class="col-md-4">
                            <label class="form-label">Tìm kiếm</label>
                            <input type="text" name="search" class="form-control"
                                placeholder="Nhập tên nhà cung cấp" value="{{ request('search') }}">
                        </div>

                        <!-- Từ ngày -->
                        <div class="col-md-2">
                            <label class="form-label">Từ ngày</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>

                        <!-- Đến ngày -->
                        <div class="col-md-2">
                            <label class="form-label">Đến ngày</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <!-- Nhân viên phụ trách -->
                        <div class="col-md-2">
                            <label class="form-label">Nhân viên phụ trách</label>
                            <select name="user_id" class="form-select">
                                <option value="">-- Tất cả --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nút lọc -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">🔍 Lọc</button>
                        </div>
                    </div>
                </form>


            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã NCC</th>
                            <th>Tên NCC</th>
                            <th>Trạng thái</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Hành Động</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                        <tr>
                            <td>
                                <a href="{{ route('suppliers.show', $supplier->id) }}"
                                    class="text-decoration-none">
                                    {{ $supplier->supplier_code }}
                                </a>
                            </td>
                            <td>{{ $supplier->name }}</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success">Đang hoạt động</span>
                            </td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <form action="{{ route('suppliers.restore', $supplier->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Khôi phục
                                        </button>
                                    </form>

                                    <form action="{{ route('suppliers.forceDelete', $supplier->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            xóa
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Chưa có nhà cung cấp nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Từ {{ $suppliers->firstItem() ?? 0 }} đến {{ $suppliers->lastItem() ?? 0 }} trên tổng
                    {{ $suppliers->total() }}
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label>Hiển thị</label>
                    <select class="form-select form-select-sm w-auto">
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <span>Kết quả</span>
                </div>
                <nav>
                    {{ $suppliers->links() }}
                </nav>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <a href="#">Tìm hiểu thêm về <strong>nhà cung cấp</strong></a>
    </div>
</div>
@endsection
