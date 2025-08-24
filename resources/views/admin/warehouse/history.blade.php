@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    <h4 class="mb-4">Danh sách đơn nhập hàng</h4>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <ul class="nav nav-tabs">
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

        <div>
            <button class="btn btn-outline-secondary me-2">Xuất file</button>
            <button class="btn btn-outline-secondary me-2">Nhập file</button>
            <a class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tạo đơn nhập hàng
            </a>
        </div>
    </div>

    <!-- Bộ lọc -->
    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="🔍 Tìm kiếm theo mã đơn nhập, tên, SDT, mã NCC">
        </div>
        <div class="col-md-2">
            <select class="form-select">
                <option selected>Trạng thái nhập</option>
                <option>Đã nhập</option>
                <option>Chưa nhập</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control" placeholder="Ngày tạo">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control" placeholder="Sản phẩm">
        </div>
        <div class="col-md-2 d-flex">
            <button class="btn btn-outline-secondary w-100">Lưu bộ lọc</button>
        </div>
    </form>

    <!-- Bảng dữ liệu -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col"><input type="checkbox"></th>
                    <th scope="col">Mã đơn nhập</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Chi nhánh nhập</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Trạng thái nhập</th>
                    <th scope="col">Nhà cung cấp</th>
                    <th scope="col">Nhân viên tạo</th>
                    <th scope="col">Số lượng nhập</th>
                    <th scope="col">Giá trị đơn</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dòng dữ liệu ví dụ -->
                <tr>
                    <td><input type="checkbox"></td>
                    <td><a href="#">aaaaaaaaaaaaaaaa</a></td>
                    <td>09/07/2025 08:16</td>
                    <td>Cửa hàng chính</td>
                    <td><span class="badge bg-success">Hoàn thành</span></td>
                    <td><span class="badge bg-secondary">Đã nhập</span></td>
                    <td>YTHANH ÊBAN</td>
                    <td>YTHANH ÊBAN</td>
                    <td>3</td>
                    <td>33,000₫</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td><a href="#">124567</a></td>
                    <td>09/07/2025 08:12</td>
                    <td>Cửa hàng chính</td>
                    <td><span class="badge bg-success">Hoàn thành</span></td>
                    <td><span class="badge bg-secondary">Đã nhập</span></td>
                    <td>YTHANH ÊBAN</td>
                    <td>YTHANH ÊBAN</td>
                    <td>3</td>
                    <td>33,000₫</td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td><a href="#">aaaaaaaaaaaaaa</a></td>
                    <td>02/07/2025 15:28</td>
                    <td>Cửa hàng chính</td>
                    <td><span class="badge bg-success">Hoàn thành</span></td>
                    <td><span class="badge bg-secondary">Đã nhập</span></td>
                    <td>YTHANH ÊBAN</td>
                    <td>YTHANH ÊBAN</td>
                    <td>100</td>
                    <td>1,100,000₫</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Từ 1 đến 3 trên tổng 3
        </div>
        <nav>
            <ul class="pagination mb-0">
                <li class="page-item active"><span class="page-link">1</span></li>
            </ul>
        </nav>
    </div>

    <div class="mt-3">
        <a href="#">Tìm hiểu thêm về <strong>đơn nhập hàng</strong></a>
    </div>
</div>
@endsection
