@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h3 class="mb-4">Tạo đơn nhập hàng</h3>
    <form action="{{ route('warehouse.import_creater') }}" method="POST">
        @csrf

        <div class="row g-4">
            <!-- Cột trái: Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold">Sản phẩm</div>
                    <div class="card-body">
                        <div class="mb-6 d-flex justify-content-between align-items-center">
                            <div class="mb-3">
                                <label for="products">Chọn sản phẩm</label>
                                <select id="products" name="products[]" multiple class="form-control" style="width: 100%"></select>
                            </div>
                            <div id="selected-products-list"></div>
                        </div>

                        <!-- Danh sách sản phẩm đã chọn -->
                        <table class="table align-middle table-bordered">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="/images/shirt.jpg" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                            <div>
                                                <div><strong>Áo Đẹp</strong> - Size S</div>
                                                <small class="text-muted">SKU: aodep-1 | Đơn vị: Kg</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="number" class="form-control text-center" name="quantities[]" value="100"></td>
                                    <td class="text-end text-primary">11,000đ</td>
                                    <td class="text-end fw-semibold">1,100,000đ</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="/images/shirt.jpg" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                            <div>
                                                <div><strong>Áo Đẹp</strong> - Size X</div>
                                                <small class="text-muted">SKU: aodep-2 | Đơn vị: Kg</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="number" class="form-control text-center" name="quantities[]" value="10"></td>
                                    <td class="text-end text-primary">11,000đ</td>
                                    <td class="text-end fw-semibold">110,000đ</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="auto_stock_in" id="auto_stock_in">
                            <label class="form-check-label" for="auto_stock_in">
                                Nhập kho khi tạo đơn
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Thanh toán -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header fw-semibold">Thanh toán</div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-3">
                            <li class="d-flex justify-content-between">
                                <span>Tổng tiền (110 sản phẩm):</span>
                                <span class="fw-bold">1,210,000đ</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span><a href="#">Thêm giảm giá (F6)</a></span>
                                <span>0đ</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span><a href="#">Chi phí nhập hàng (F7)</a></span>
                                <span>0đ</span>
                            </li>
                            <hr>
                            <li class="d-flex justify-content-between fw-bold">
                                <span>Tiền cần trả NCC:</span>
                                <span>1,210,000đ</span>
                            </li>
                        </ul>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_status" value="paid" id="paid">
                            <label class="form-check-label" for="paid">
                                Đã thanh toán
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_status" value="unpaid" id="unpaid" checked>
                            <label class="form-check-label" for="unpaid">
                                Thanh toán sau
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Thông tin đơn -->
            <div class="col-lg-4">
                <!-- Nhà cung cấp -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <label class="form-label">Nhà cung cấp</label>
                        <input type="text" class="form-control" placeholder="Tìm theo tên, SDT, mã NCC...(F4)">
                    </div>
                </div>

                <!-- Chi nhánh -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <label class="form-label">Chi nhánh nhập</label>
                        <select name="branch_id" class="form-select">
                            <option>Cửa hàng chính</option>
                        </select>
                    </div>
                </div>

                <!-- Thông tin bổ sung -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <label class="form-label">Nhân viên phụ trách</label>
                        <select name="staff_id" class="form-select mb-2">
                            <option>YTHANH ÊBAN</option>
                        </select>

                        <label class="form-label">Ngày nhập dự kiến</label>
                        <input type="date" name="expected_date" class="form-control mb-2">

                        <label class="form-label">Mã đơn nhập</label>
                        <input type="text" name="code" class="form-control mb-2">

                        <label class="form-label">Tham chiếu</label>
                        <input type="text" name="reference" class="form-control">
                    </div>
                </div>

                <!-- Ghi chú -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <label class="form-label">Ghi chú</label>
                        <textarea name="note" class="form-control" rows="3" placeholder="VD: Chỉ nhận hàng trong giờ hành chính"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-4 text-end">
            <button class="btn btn-primary">
                <i data-feather="save"></i> Lưu đơn nhập
            </button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#products').select2({
            placeholder: 'Tìm theo tên, mã SKU, quét mã Barcode...',
            ajax: {
                url: '{{ route("products.search") }}', // tạo route này
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: `${item.name} (${item.slug})`
                        }))
                    };
                },
                cache: true
            }
        });

        $('#products').on('select2:select', function(e) {
            const data = e.params.data;
            $.ajax({
                url: '{{ route("products.info") }}',
                method: 'GET',
                data: {
                    id: data.id
                },
                success: function(product) {
                    const html = `
                    <div class="border p-2 mb-2" data-id="${product.id}">
                        <strong>${product.name}</strong> | SKU: ${product.slug}<br>
                        Số lượng: <input type="number" name="quantities[${product.id}]" value="1" min="1" class="form-control mt-1" style="width: 100px; display: inline-block;">
                        <button type="button" onclick="removeProduct(${product.id})" class="btn btn-sm btn-outline-danger">X</button>
                    </div>
                `;
                    $('#selected-products-list').append(html);
                }
            });
        });
    });

    function removeProduct(id) {
        $(`[data-id="${id}"]`).remove();
        const selected = $('#products').val().filter(i => i != id);
        $('#products').val(selected).trigger('change');
    }
</script>

@endsection
