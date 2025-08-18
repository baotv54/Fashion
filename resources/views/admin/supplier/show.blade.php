@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex align-items-center mb-3">
            <a href="{{ route('suppliers.index') }}" class="btn btn-light me-3">←</a>
            <h4 class="mb-0 me-3">{{ $supplier->name }}</h4>
            <span class="badge bg-success bg-opacity-10 text-success">Đang hoạt động</span>
        </div>

        <div class="row g-3">
            <!-- Cột trái -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <strong>Mã nhà cung cấp:</strong> {{ $supplier->supplier_code }}
                        </div>
                        <div>
                            Tháng này (01/07/2025 - 31/07/2025)
                            <i class="bi bi-chevron-down ms-1"></i>
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class="card-body row text-center">
                        <div class="col-md-3">
                            <p class="mb-1">Đơn nhập đã tạo</p>
                            <p class="text-primary fw-semibold mb-0">0 đơn</p>
                            <small>0g</small>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1">Đơn đã nhập chưa thanh toán</p>
                            <p class="text-primary fw-semibold mb-0">0 đơn</p>
                            <small>0g</small>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1">Đơn trả đã tạo</p>
                            <p class="text-danger fw-semibold mb-0">0 đơn</p>
                            <small>0g</small>
                        </div>
                        <div class="col-md-3">
                            <p class="mb-1">Đơn trả chưa nhận hoàn tiền</p>
                            <p class="text-danger fw-semibold mb-0">0 đơn</p>
                            <small>0g</small>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header fw-semibold">Lịch sử nhập/trả hàng</div>
                    <div class="card-body">
                        <p class="mb-0">Không có đơn nhập/ đơn trả của nhà cung cấp trong khoảng thời gian đang chọn.</p>
                    </div>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                        <span>Liên hệ</span>
                        <a href="{{ route('suppliers.edit', $supplier->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                    <div class="card-body small">
                        <p class="mb-1"><strong>Số điện thoại</strong></p>
                        <p class="mb-2">{{ $supplier->phone ?? '-' }}</p>

                        <p class="mb-1"><strong>Email</strong></p>
                        <p class="mb-2">{{ $supplier->email ?? '-' }}</p>

                        <p class="mb-1"><strong>Địa chỉ</strong></p>
                        <p class="mb-2" id="ghn-address">
                            Đang tải địa chỉ...
                        </p>

                        <p class="mb-1"><strong>Fax</strong></p>
                        <p class="mb-2">{{ $supplier->fax ?? '-' }}</p>

                        <p class="mb-1"><strong>Website</strong></p>
                        <a href="{{ $supplier->website ?? '#' }}" target="_blank" class="text-decoration-none">
                            {{ $supplier->website ?? '-' }}
                        </a>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header fw-semibold">Nhân viên phụ trách</div>
                    <div class="card-body">
                        <select class="form-select" disabled>
                            <option selected>
                                {{ $supplier->user ? $supplier->user->name : 'Chưa có nhân viên phụ trách' }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header fw-semibold d-flex justify-content-between">
                        <span>Tag</span>
                        <a href="#">Danh sách tag</a>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" placeholder="Tìm kiếm hoặc thêm mới tag" disabled>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
            onsubmit="return confirm('Bạn có chắc chắn muốn xoá nhà cung cấp này không?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Xóa</button>
        </form>
    </div>
    <script>
        const API_URL = "https://online-gateway.ghn.vn/shiip/public-api";
        const TOKEN = "{{ env('GHNHANH_API_KEY') }}";

        // Lấy mã đã lưu trong database
        const provinceId = `{{ $supplier->province }}`;
        const districtId = `{{ $supplier->district }}`;
        const wardCode = `{{ $supplier->ward }}`;
        const addressDetail = `{{ $supplier->address_detail }}`;

        document.addEventListener("DOMContentLoaded", async function() {
            let provinceName = "",
                districtName = "",
                wardName = "";

            try {
                // 1. Get Provinces
                const provinces = await fetch(API_URL + "/master-data/province", {
                    headers: {
                        "Token": TOKEN
                    }
                }).then(res => res.json());

                provinceName = provinces.data.find(p => p.ProvinceID == provinceId)?.ProvinceName || "";

                // 2. Get Districts
                const districts = await fetch(API_URL + "/master-data/district", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Token": TOKEN
                    },
                    body: JSON.stringify({
                        province_id: Number(provinceId)
                    })
                }).then(res => res.json());

                districtName = districts.data.find(d => d.DistrictID == districtId)?.DistrictName || "";

                // 3. Get Wards
                const wards = await fetch(`${API_URL}/master-data/ward?district_id=${districtId}`, {
                    headers: {
                        "Token": TOKEN
                    }
                }).then(res => res.json());

                wardName = wards.data.find(w => w.WardCode == wardCode)?.WardName || "";
            } catch (error) {
                console.error("Lỗi khi tải địa chỉ từ GHN:", error);
            }

            const fullAddress = [addressDetail, wardName, districtName, provinceName]
                .filter(Boolean)
                .join(', ');

            document.getElementById("ghn-address").textContent = fullAddress || 'Không xác định';
        });
    </script>
@endsection
