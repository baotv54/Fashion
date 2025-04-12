@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Chi tiết đơn hàng: {{ $order->order_code }}</h1>

    <p><strong>Trạng thái:</strong>
        @switch($order->status)
            @case('processing')
                Đang xử lý
                @break
            @default
                {{ ucfirst($order->status) }}
        @endswitch
    </p>

    @if ($order->status === 'processing')
    <h3>Cập nhật địa chỉ giao hàng</h3>
    <form action="{{ route('user.orders.updateAddress', $order->id) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="billingProvince">Tỉnh/Thành</label>
                    <select name="province" id="billingProvince" class="form-control" required>
                        <option value="">Chọn tỉnh/thành</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="billingDistrict">Quận/Huyện</label>
                    <select name="district" id="billingDistrict" class="form-control" required style="display: none;">
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="billingWard">Phường/Xã</label>
                    <select name="ward" id="billingWard" class="form-control" required style="display: none;">
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ chi tiết:</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $order->address }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật địa chỉ</button>
    </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const provinceSelect = document.getElementById('billingProvince');
        const districtSelect = document.getElementById('billingDistrict');
        const wardSelect = document.getElementById('billingWard');

        // Load provinces
        fetch('/address/province')
            .then(response => response.json())
            .then(data => {
                provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành</option>';
                data.forEach(province => {
                    provinceSelect.innerHTML += `<option value="${province.ProvinceID}" ${province.ProvinceID == "{{ $order->province }}" ? 'selected' : ''}>${province.ProvinceName}</option>`;
                });

                // Trigger change event if province is pre-selected
                if ("{{ $order->province }}") {
                    provinceSelect.dispatchEvent(new Event('change'));
                }
            });

        // Load districts when a province is selected
        provinceSelect.addEventListener('change', function() {
            const provinceId = this.value;
            districtSelect.style.display = 'none';
            wardSelect.style.display = 'none';
            districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

            if (provinceId) {
                fetch(`/address/district/${provinceId}`)
                    .then(response => response.json())
                    .then(data => {
                        districtSelect.style.display = 'block';
                        data.forEach(district => {
                            districtSelect.innerHTML += `<option value="${district.DistrictID}" ${district.DistrictID == "{{ $order->district }}" ? 'selected' : ''}>${district.DistrictName}</option>`;
                        });

                        // Trigger change event if district is pre-selected
                        if ("{{ $order->district }}") {
                            districtSelect.dispatchEvent(new Event('change'));
                        }
                    });
            }
        });

        // Load wards when a district is selected
        districtSelect.addEventListener('change', function() {
            const districtId = this.value;
            wardSelect.style.display = 'none';
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

            if (districtId) {
                fetch(`/address/ward/${districtId}`)
                    .then(response => response.json())
                    .then(data => {
                        wardSelect.style.display = 'block';
                        data.forEach(ward => {
                            wardSelect.innerHTML += `<option value="${ward.WardCode}" ${ward.WardCode == "{{ $order->ward }}" ? 'selected' : ''}>${ward.WardName}</option>`;
                        });
                    });
            }
        });
    });
</script>
@endsection