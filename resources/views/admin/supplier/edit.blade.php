@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h4 class="mb-4">
            <a href="{{ route('suppliers.index') }}" class="text-decoration-none me-2">←</a>
            Chỉnh sửa nhà cung cấp
        </h4>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                                    value="{{ old('supplier_code', $supplier->supplier_code) }}">
                                @error('supplier_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tên nhà cung cấp *</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $supplier->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <div class="input-group">
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $supplier->phone) }}">
                                    <span class="input-group-text">
                                        <img src="https://flagcdn.com/w40/vn.png" style="height: 16px">
                                    </span>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $supplier->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mã số thuế</label>
                                <input type="text" name="tax_code"
                                    class="form-control @error('tax_code') is-invalid @enderror"
                                    value="{{ old('tax_code', $supplier->tax_code) }}">
                                @error('tax_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Số fax</label>
                                <input type="text" name="fax"
                                    class="form-control @error('fax') is-invalid @enderror"
                                    value="{{ old('fax', $supplier->fax) }}">
                                @error('fax')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Website</label>
                                <input type="url" name="website"
                                    class="form-control @error('website') is-invalid @enderror"
                                    value="{{ old('website', $supplier->website) }}">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header fw-semibold">Địa chỉ</div>
                        <div class="card-body row g-3">
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

                            <div class="col-md-12">
                                <label class="form-label">Địa chỉ cụ thể</label>
                                <input type="text" name="address_detail"
                                    class="form-control @error('address_detail') is-invalid @enderror"
                                    value="{{ old('address_detail', $supplier->address_detail) }}">
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
                        <div class="card-body">
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Chọn nhân viên phụ trách --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $supplier->user_id) == $user->id ? 'selected' : '' }}>
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
                                value="{{ old('tags', $supplier->tags) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút cập nhật -->
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>

    {{-- JavaScript địa chỉ GHN --}}
    <script>
        const TOKEN = "{{ env('GHNHANH_API_KEY') }}";
        const API_URL = "https://online-gateway.ghn.vn/shiip/public-api";
        const defaultProvince = `{{ old('province', $supplier->province) }}`;
        const defaultDistrict = `{{ old('district', $supplier->district) }}`;
        const defaultWard = `{{ old('ward', $supplier->ward) }}`;

        document.addEventListener("DOMContentLoaded", function() {
            loadProvinces();

            document.getElementById("province").addEventListener("change", function() {
                loadDistricts();
            });

            document.getElementById("district").addEventListener("change", function() {
                loadWards();
            });
        });

        function loadProvinces() {
            fetch(API_URL + "/master-data/province", {
                    headers: { "Token": TOKEN }
                })
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById("province");
                    select.innerHTML = `<option value="">Chọn tỉnh/thành</option>`;
                    data.data.forEach(p => {
                        const selected = p.ProvinceID == defaultProvince ? 'selected' : '';
                        select.innerHTML += `<option value="${p.ProvinceID}" ${selected}>${p.ProvinceName}</option>`;
                    });
                    if (defaultProvince) loadDistricts();
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
                    body: JSON.stringify({ province_id: Number(provinceId) })
                })
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById("district");
                    select.innerHTML = `<option value="">Chọn quận/huyện</option>`;
                    data.data.forEach(d => {
                        const selected = d.DistrictID == defaultDistrict ? 'selected' : '';
                        select.innerHTML += `<option value="${d.DistrictID}" ${selected}>${d.DistrictName}</option>`;
                    });
                    if (defaultDistrict) loadWards();
                });
        }

        function loadWards() {
            const districtId = document.getElementById("district").value;
            fetch(`${API_URL}/master-data/ward?district_id=${districtId}`, {
                    headers: { "Token": TOKEN }
                })
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById("ward");
                    select.innerHTML = `<option value="">Chọn phường/xã</option>`;
                    data.data.forEach(w => {
                        const selected = w.WardCode == defaultWard ? 'selected' : '';
                        select.innerHTML += `<option value="${w.WardCode}" ${selected}>${w.WardName}</option>`;
                    });
                });
        }
    </script>
@endsection
