@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">
        <a href="" class="text-decoration-none me-2">
            ←
        </a>
        Thêm mới nhà cung cấp
    </h4>

    <form action="" method="POST">
        @csrf
        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header fw-semibold">Thông tin chung</div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên nhà cung cấp *</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập tên nhà cung cấp" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mã nhà cung cấp</label>
                            <input type="text" name="code" class="form-control" placeholder="Nhập mã nhà cung cấp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại</label>
                            <div class="input-group">
                                <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại">
                                <span class="input-group-text">
                                    <img src="https://flagcdn.com/w40/vn.png" style="height: 16px">
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mã số thuế</label>
                            <input type="text" name="tax_code" class="form-control" placeholder="Nhập mã số thuế">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số fax</label>
                            <input type="text" name="fax" class="form-control" placeholder="Nhập số fax">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-control" placeholder="https://">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header fw-semibold">Địa chỉ</div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Quốc gia</label>
                            <select name="country" class="form-select">
                                <option value="Vietnam">Vietnam</option>
                                <!-- Thêm các quốc gia khác nếu cần -->
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Khu vực</label>
                            <select name="region" class="form-select">
                                <option value="">Chọn khu vực</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phường xã</label>
                            <select name="ward" class="form-select">
                                <option value="">Chọn Phường xã</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Địa chỉ cụ thể</label>
                            <input type="text" name="address_detail" class="form-control" placeholder="Nhập địa chỉ cụ thể">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header fw-semibold">Nhân viên phụ trách</div>
                    <div class="card-body">
                        <select name="staff_in_charge" class="form-select">
                            <option selected>YTHANH ÊBAN</option>
                            <!-- Thêm lựa chọn khác nếu có -->
                        </select>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header fw-semibold d-flex justify-content-between">
                        <span>Tag</span>
                        <a href="#">Danh sách tag</a>
                    </div>
                    <div class="card-body">
                        <input type="text" name="tags" class="form-control" placeholder="Tìm kiếm hoặc thêm mới tag">
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút submit -->
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
    </form>
</div>
@endsection
