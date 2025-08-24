@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container">
    <h3 class="mb-4">Chi tiết đơn nhập: {{ $main->code }}</h3>

    <div class="row">
        <!-- Bên trái: Danh sách sản phẩm -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-clock text-warning me-2"></i> <strong> {{ $main->import_type }}</strong>

                </div>
                <form action="{{ route('warehouse.update_quantity') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $main->id }}">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($main->details as $index => $detail)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="/{{ $detail->product->image ?? 'https://via.placeholder.com/40' }}" class="rounded me-2" width="40" height="40" alt="">
                                            <div>
                                                <div class="fw-bold">
                                                    {{ \Illuminate\Support\Str::limit($detail->product->name, 20) }}
                                                </div>

                                                <small class="text-muted">SKU: {{ \Illuminate\Support\Str::limit($detail->product->slug ?? '---') }}</small><br>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>{{ number_format($detail->price) }}đ</td>
                                    <td>{{ number_format($detail->price * $detail->quantity) }}đ</td>

                                    <input type="hidden" name="details[{{ $index }}][detail_id]" value="{{ $detail->id }}">
                                    <input type="hidden" name="details[{{ $index }}][product_id]" value="{{ $detail->product_id }}">
                                    <input type="hidden" name="details[{{ $index }}][variant_id]" value="{{ $detail->variant_id }}">
                                    <input type="hidden" name="details[{{ $index }}][quantity]" value="{{ $detail->quantity }}">
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-end mt-3">
                            @if($main->payment_status === 'Đã thanh toán')
                            @if($main->import_type === 'Đã Nhập Kho')
                            <span class="badge bg-success">Đã nhập kho</span>
                            @else
                            <button class="btn btn-primary">Nhập kho</button>
                            @endif
                            @else
                            <span class="badge bg-danger">Vui Lòng Thanh Toán Trước Khi Nhập Kho</span>
                            @endif

                        </div>

                    </div>
                </form>
            </div>

            <!-- Thanh toán -->
            <div class="card mb-4">
                <div class="card-header text-success fw-bold">
                    <i class="fas fa-check-circle me-2"></i>{{$main->payment_status}}
                </div>
                <div class="card-body">
                    <p><strong>Tổng số :</strong> {{ $main->details->sum('quantity') }} sản phẩm</p>
                    <p><strong>Giảm giá:</strong> {{ number_format($main->discount) }}đ</p>
                    <p><strong>Chi phí nhập hàng:</strong> {{ number_format($main->additional_cost)}}</p>
                    <p><strong>Tổng Tiền Sản Phẩm:</strong> {{ number_format($main->total_price) }}đ</p>
                    <div class="alert border d-flex justify-content-between align-items-center">
                        <div><strong>Tiền cần trả NCC:</strong> {{ $main->total_price + $main->additional_cost - $main->discount }}đ</div>
                        <div><strong>Đã trả:</strong> {{ number_format($main->payment_amount) }}đ</div>
                    </div>
                    @if($main->payment_status === 'Thanh toán sau')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        Xác Nhận Thanh Toán
                    </button>
                    @endif
                </div>
            </div>

            <!-- Lịch sử -->
            <div class="card">
                <div class="card-header">Lịch sử đơn nhập hàng</div>
                <div class="card-body">
                    <p>{{ date('d/m/Y', strtotime($main->import_date)) }}</p>
                </div>
            </div>
        </div>

        <!-- Bên phải: Thông tin phụ -->
        <div class="col-md-4">
            <!-- Nhà cung cấp -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Nhà Cung Cấp</h5>
                </div>
                <div class="card-body">
                    <p class="fw-bold text-primary d-flex align-items-center">
                        <i class="fa-solid fa-user fa-2x me-3"></i>
                        <span class="fs-5">{{ $main->supplier->name ?? '---' }}</span>
                    </p>
                    <p><strong>Thông Tin Nhà Cung Cấp:</strong></p>
                    <p>Email: {{ $main->supplier->email ?? '' }}</p>
                    <p>Số Điện Thoại: {{ $main->supplier->phone ?? '' }}</p>
                    <p class="mb-2" id="ghn-address">
                        Đang tải địa chỉ...
                    </p>
                </div>
            </div>
            <!-- Thông tin bổ sung -->
            <div class="card">
                <div class="card-header">Thông tin bổ sung</div>
                <div class="card-body">
                    <p><strong>Nhân viên phụ trách:</strong> {{ $main->user->name ?? '---' }}</p>
                    <p><strong>Ngày nhập dự kiến:</strong> {{ $main->import_date }} 14:00</p>
                    <p><strong>Tham chiếu:</strong> {{ $main->note ?? '---' }}</p>
                </div>
            </div>
            <br>
            @if($main->payment_status === 'Thanh toán sau' ||$main->import_type === 'Đã Nhập Kho' )
            <div class="text-end">
                <form action="{{ route('warehouse.destroy', $main->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn hủy đơn này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hủy Đơn">
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
            @endif
        </div>
    </div>

    <!-- Modal Xác Nhận Thanh Toán -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('warehouse.confirm_payment', $main->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Xác nhận thanh toán</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Hình thức thanh toán</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="">Chọn hình thức thanh toán</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                                <option value="Tiền mặt">Tiền mặt</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số tiền thanh toán</label>
                            <input type="number" name="payment_amount" class="form-control" value="{{ $main->total_price + $main->additional_cost - $main->discount }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ngày ghi nhận</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tham chiếu</label>
                            <input type="text" name="payment_reference" class="form-control" placeholder="Nhập mã tham chiếu">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const API_URL = "https://online-gateway.ghn.vn/shiip/public-api";
    const TOKEN = "{{ env('GHNHANH_API_KEY') }}";

    // Lấy mã đã lưu trong database
    const provinceId = `{{ $main->supplier->province }}`;
    const districtId = `{{ $main->supplier->district }}`;
    const wardCode = `{{ $main->supplier->ward }}`;
    const addressDetail = `{{ $main->supplier->address_detail }}`;

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

        const fullAddress = [wardName, districtName, provinceName]
            .filter(Boolean)
            .join(', ');

        document.getElementById("ghn-address").textContent = fullAddress || 'Không xác định';
    });
</script>
@endsection
