@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')
<div class="container">
    @if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif
    <h3 class="mb-4">Tạo đơn trả hàng cho đơn nhập {{ $main->code }}</h3>

    <form action="{{ route('returns.store') }}" method="POST">
        @csrf
        <!-- hidden: return_code, supplier_id, user_id -->
        <input type="hidden" name="return_code" value="RT{{ time() }}">
        <input type="hidden" name="supplier_id" value="{{ $main->supplier_id }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <!-- hidden để cập nhật khi tính toán -->
        <input type="hidden" name="total_quantity" id="total_quantity_input" value="0">
        <input type="hidden" name="total_amount" id="total_amount_input" value="0">

        <div class="row">
            <!-- Bên trái -->
            <div class="col-md-8">
                <!-- Sản phẩm hoàn trả -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Sản phẩm hoàn trả</h5>
                    </div>
                    <div class="card-body">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá trả</th>
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
                                                <div class="fw-bold">{{ $detail->product->name }}</div>
                                                <small class="text-muted">SKU: {{ $detail->product->slug ?? '---' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="hidden" name="product_id[]" value="{{ $detail->product_id }}">
                                        <input type="hidden" name="variant_id[]" value="{{ $detail->variant_id }}">

                                        <input type="number"
                                            class="form-control return-qty"
                                            name="quantity[]"
                                            value="0" min="0"
                                            max="{{ $detail->stock }}"
                                            data-price="{{ $detail->price }}">
                                        <small class="text-muted">có thể trả: {{ $detail->stock }}</small>
                                    </td>
                                    <td>{{ number_format($detail->price) }}đ</td>
                                    <td class="line-total">0đ</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Hoàn tiền -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Hoàn tiền</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Tổng số lượng hàng trả:</strong> <span id="total_qty">0</span></p>
                        <p><strong>Giá trị hàng trả:</strong> <span id="return_value">0</span>đ</p>
                        <h5 class="mt-3">Giá trị hoàn trả: <span class="text-success" id="refund_value">0</span>đ</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="refund_status" value="Đã Hoàn Tiền" id="paid">
                            <label class="form-check-label" for="paid">Đã Hoàn Tiền</label>
                        </div>

                        <!-- Form chi tiết thanh toán -->
                        <div id="payment-detail" class="border p-3 rounded d-none">
                            <div class="mb-2">
                                <label class="form-label">Hình thức thanh toán</label>
                                <select name="payment_method" class="form-select">
                                    <option value="">Chọn hình thức thanh toán</option>
                                    <option value="Tiền mặt">Tiền mặt</option>
                                    <option value="Chuyển khoản">Chuyển khoản</option>
                                    <option value="Thẻ">Thẻ</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Số tiền thanh toán</label>
                                <input type="text" name="payment_amount" id="payment_amount" class="form-control" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Ngày ghi nhận</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Tham chiếu</label>
                                <input type="text" name="payment_reference" class="form-control" placeholder="Nhập mã tham chiếu">
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="refund_status" value="Đang Xử Lý" id="unpaid" checked>
                            <label class="form-check-label" for="unpaid">Hoàn tiền sau</label>
                        </div>
                    </div>
                </div>

                <!-- Nút submit -->
                <button type="submit" class="btn btn-success">Xác nhận trả hàng</button>
            </div>

            <!-- Bên phải -->
            <div class="col-md-4">
                <!-- Nhà cung cấp -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Nhà cung cấp</h5>
                    </div>
                    <div class="card-body">
                        <p class="fw-bold text-primary d-flex align-items-center">
                            <i class="fa-solid fa-user fa-2x me-2"></i>
                            <span class="fs-5">{{ $main->supplier->name ?? '---' }}</span>
                        </p>
                        <p>Email: {{ $main->supplier->email ?? '' }}</p>
                        <p>SĐT: {{ $main->supplier->phone ?? '' }}</p>
                        <p>Địa chỉ: {{ $main->supplier->address_detail ?? '' }}</p>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Lý do hoàn trả</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="reason" id="reason" class="form-control mb-2" rows="3" placeholder="Nhập lý do hoàn trả"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const qtyInputs = document.querySelectorAll(".return-qty");
        const totalQtyEl = document.getElementById("total_qty");
        const returnValueEl = document.getElementById("return_value");
        const refundValueEl = document.getElementById("refund_value");

        // hidden inputs để submit
        const totalQtyInput = document.getElementById("total_quantity_input");
        const totalAmountInput = document.getElementById("total_amount_input");

        function formatCurrency(num) {
            return new Intl.NumberFormat("vi-VN").format(num);
        }

        function calculate() {
            let totalQty = 0;
            let totalValue = 0;

            qtyInputs.forEach(input => {
                let qty = parseInt(input.value) || 0;
                const max = parseInt(input.max);
                const min = parseInt(input.min);

                if (qty < min) {
                    qty = min;
                    input.value = min;
                } else if (qty > max) {
                    qty = max;
                    input.value = max;
                }

                const price = parseFloat(input.dataset.price) || 0;
                const lineTotal = qty * price;
                totalQty += qty;
                totalValue += lineTotal;

                input.closest("tr").querySelector(".line-total").textContent = formatCurrency(lineTotal) + "đ";
            });

            totalQtyEl.textContent = totalQty;
            returnValueEl.textContent = formatCurrency(totalValue);
            refundValueEl.textContent = formatCurrency(totalValue);

            totalQtyInput.value = totalQty;
            totalAmountInput.value = totalValue;
        }

        qtyInputs.forEach(input => input.addEventListener("input", calculate));
    });

    document.addEventListener("DOMContentLoaded", () => {
        const qtyInputs = document.querySelectorAll(".return-qty");
        const totalQtyEl = document.getElementById("total_qty");
        const returnValueEl = document.getElementById("return_value");
        const refundValueEl = document.getElementById("refund_value");

        const totalQtyInput = document.getElementById("total_quantity_input");
        const totalAmountInput = document.getElementById("total_amount_input");

        const paidRadio = document.getElementById("paid");
        const unpaidRadio = document.getElementById("unpaid");
        const paymentDetail = document.getElementById("payment-detail");
        const paymentAmountInput = document.getElementById("payment_amount");

        function formatCurrency(num) {
            return new Intl.NumberFormat("vi-VN").format(num);
        }

        function calculate() {
            let totalQty = 0;
            let totalValue = 0;

            qtyInputs.forEach(input => {
                let qty = parseInt(input.value) || 0;
                const max = parseInt(input.max);
                const min = parseInt(input.min);

                if (qty < min) {
                    qty = min;
                    input.value = min;
                } else if (qty > max) {
                    qty = max;
                    input.value = max;
                }

                const price = parseFloat(input.dataset.price) || 0;
                const lineTotal = qty * price;
                totalQty += qty;
                totalValue += lineTotal;

                input.closest("tr").querySelector(".line-total").textContent = formatCurrency(lineTotal) + "đ";
            });

            totalQtyEl.textContent = totalQty;
            returnValueEl.textContent = formatCurrency(totalValue);
            refundValueEl.textContent = formatCurrency(totalValue);

            totalQtyInput.value = totalQty;
            totalAmountInput.value = totalValue;

            // nếu chọn "Đã thanh toán" thì cập nhật số tiền thanh toán
            if (paidRadio.checked) {
                paymentAmountInput.value = totalValue;
            }
        }

        qtyInputs.forEach(input => input.addEventListener("input", calculate));

        // Toggle hiển thị chi tiết thanh toán
        paidRadio.addEventListener("change", () => {
            paymentDetail.classList.remove("d-none");
            paymentAmountInput.value = totalAmountInput.value;
        });

        unpaidRadio.addEventListener("change", () => {
            paymentDetail.classList.add("d-none");
            paymentAmountInput.value = "";
        });
    });
</script>
@endsection
