@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Danh sách nhà cung cấp</h4>
        <div>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">➕ Thêm nhà cung cấp</a>
        </div>
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
                                @if($supplier->status === 'Đang Hoạt Động')
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    {{ $supplier->status }}
                                </span>
                                @elseif($supplier->status === 'Ngưng Hoạt Động')
                                <span class="badge bg-danger bg-opacity-10 text-danger">
                                    {{ $supplier->status }}
                                </span>
                                @endif
                            </td>
                            <td>{{ $supplier->phone }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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