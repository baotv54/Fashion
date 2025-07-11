@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">
            <a href="" class="text-decoration-none me-2">
                ←
            </a>
            Thêm mới nhà cung cấp
        </h4>

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Cột trái -->
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header fw-semibold">Thông tin chung</div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Mã nhà cung cấp *</label>
                                <input type="text" name="supplier_code"
                                    class="form-control @error('supplier_code') is-invalid @enderror"
                                    placeholder="Nhập mã nhà cung cấp" value="{{ old('supplier_code') }}">
                                @error('supplier_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tên nhà cung cấp *</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Nhập tên nhà cung cấp" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Số điện thoại -->
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <div class="input-group">
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                                    <span class="input-group-text">
                                        <img src="https://flagcdn.com/w40/vn.png" style="height: 16px">
                                    </span>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Mã số thuế -->
                            <div class="col-md-6">
                                <label class="form-label">Mã số thuế</label>
                                <input type="text" name="tax_code"
                                    class="form-control @error('tax_code') is-invalid @enderror"
                                    placeholder="Nhập mã số thuế" value="{{ old('tax_code') }}">
                                @error('tax_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Số fax -->
                            <div class="col-md-6">
                                <label class="form-label">Số fax</label>
                                <input type="text" name="fax" class="form-control @error('fax') is-invalid @enderror"
                                    placeholder="Nhập số fax" value="{{ old('fax') }}">
                                @error('fax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Website -->
                            <div class="col-md-12">
                                <label class="form-label">Website</label>
                                <input type="text" name="website"
                                    class="form-control @error('website') is-invalid @enderror" placeholder="https://"
                                    value="{{ old('website') }}">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header fw-semibold">Địa chỉ</div>
                        <div class="card-body row g-3">
                            <!-- Tỉnh -->
                            <div class="col-md-6">
                                <label class="form-label">Tỉnh</label>
                                <select id="province" name="province"
                                    class="form-select @error('province') is-invalid @enderror">
                                    <option value="">Chọn tỉnh/thành</option>
                                </select>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Huyện -->
                            <div class="col-md-6">
                                <label class="form-label">Huyện</label>
                                <select id="district" name="district"
                                    class="form-select @error('district') is-invalid @enderror">
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                                @error('district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phường/Xã -->
                            <div class="col-md-6">
                                <label class="form-label">Phường xã</label>
                                <select id="ward" name="ward"
                                    class="form-select @error('ward') is-invalid @enderror">
                                    <option value="">Chọn phường/xã</option>
                                </select>
                                @error('ward')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Địa chỉ chi tiết -->
                            <div class="col-md-12">
                                <label class="form-label">Địa chỉ cụ thể</label>
                                <input type="text" name="address_detail"
                                    class="form-control @error('address_detail') is-invalid @enderror"
                                    placeholder="Nhập địa chỉ cụ thể" value="{{ old('address_detail') }}">
                                @error('address_detail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header fw-semibold">Nhân viên phụ trách</div>
                        <!-- Nhân viên phụ trách -->
                        <div class="card-body">
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Chọn nhân viên phụ trách --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="card mb-3">
                        <div class="card-header fw-semibold d-flex justify-content-between">
                            <span>Tag</span>
                            <a href="#">Danh sách tag</a>
                        </div>
                        <div class="card-body">
                            <input type="text" name="tags" class="form-control"
                                placeholder="Tìm kiếm hoặc thêm mới tag">
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
    <script>
        const TOKEN = "{{ env('GHNHANH_API_KEY') }}";
        const API_URL = "https://online-gateway.ghn.vn/shiip/public-api";

        document.addEventListener("DOMContentLoaded", function() {
            loadProvinces();

            document.getElementById("province").addEventListener("change", function() {
                document.getElementById("district").innerHTML = `<option>Đang tải...</option>`;
                loadDistricts();
            });

            document.getElementById("district").addEventListener("change", function() {
                document.getElementById("ward").innerHTML = `<option>Đang tải...</option>`;
                loadWards();
            });
        });

        function loadProvinces() {
            fetch(API_URL + "/master-data/province", {
                    headers: {
                        "Token": TOKEN
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const provinceSelect = document.getElementById("province");
                    provinceSelect.innerHTML = `<option value="">Chọn tỉnh/thành</option>`;
                    data.data.forEach(province => {
                        provinceSelect.innerHTML +=
                            `<option value="${province.ProvinceID}">${province.ProvinceName}</option>`;
                    });
                });
        }

        function loadDistricts() {
            const provinceId = document.getElementById("province").value;

            fetch(API_URL + "/master-data/district", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Token": TOKEN
                    },
                    body: JSON.stringify({
                        province_id: Number(provinceId)
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const districtSelect = document.getElementById("district");
                    districtSelect.innerHTML = `<option value="">Chọn quận/huyện</option>`;
                    data.data.forEach(d => {
                        districtSelect.innerHTML +=
                            `<option value="${d.DistrictID}">${d.DistrictName}</option>`;
                    });
                });
        }

        function loadWards() {
            const districtId = document.getElementById("district").value;

            fetch(API_URL + "/master-data/ward?district_id=" + districtId, {
                    headers: {
                        "Token": TOKEN
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const wardSelect = document.getElementById("ward");
                    wardSelect.innerHTML = `<option value="">Chọn phường/xã</option>`;
                    data.data.forEach(w => {
                        wardSelect.innerHTML += `<option value="${w.WardCode}">${w.WardName}</option>`;
                    });
                });
        }
    </script>
@endsection
