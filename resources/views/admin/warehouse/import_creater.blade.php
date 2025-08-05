@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tạo đơn nhập hàng</h3>
        <a href="{{ route('warehouse.product') }}" class="btn btn-success">
            <i class="fas fa-boxes me-2"></i> Chọn sản phẩm
        </a>
    </div>

    <form action="{{ route('warehouse.store_warehouse') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã xảy ra lỗi:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row g-4">
            <!-- Danh sách sản phẩm -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header fw-semibold">
                        Sản phẩm đã chọn
                    </div>
                    <div class="card-body">
                        <table class="table align-middle table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Đơn Giá</th>
                                    <th>Thành Tiền</th>
                                    <th class="text-center">Xóa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <img src="{{ asset($item['product']->image) }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded border">
                                            <div>
                                                <strong>{{ $item['product']->name }}</strong>
                                                @if($item['is_variant'] && $item['variant'])
                                                - {{ $item['variant']->name }}
                                                @endif
                                                <br>
                                                @if($item['attributes']->count())
                                                <small>
                                                    @foreach($item['attributes'] as $attrVal)
                                                    <span class="badge bg-success">
                                                        {{ $attrVal->attributeValue->value ?? '' }}
                                                    </span>
                                                    @endforeach
                                                </small>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Hidden inputs -->
                                        <input type="hidden" name="product_id[]" value="{{ $item['product']->id }}">
                                        <input type="hidden" name="variant_id[]" value="{{ $item['variant']->id ?? '' }}">
                                    </td>
                                    <td style="width: 120px;">
                                        <input
                                            type="number"
                                            name="quantity[]"
                                            value="{{ $item['quantity'] ?? 0 }}"
                                            class="form-control form-control-sm quantity-input"
                                            data-id="{{ $item['import_id'] }}"
                                            data-index="{{ $index }}"
                                            min="1"
                                            style="width: 80px;">

                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="text-primary text-decoration-underline update-price"
                                            data-index="{{ $index }}"
                                            data-product-id="{{ $item['product']->id }}"
                                            data-variant-id="{{ $item['variant']->id ?? '' }}"
                                            data-import-price="{{ $item['is_variant'] ? $item['variant']->import_price : $item['product']->import_price }}"
                                            data-price="{{ $item['is_variant'] ? $item['variant']->price ?? 0 : $item['product']->price ?? 0 }}"
                                            data-discount-price="{{ $item['is_variant'] ? $item['variant']->discount_price ?? 0 : $item['product']->discount_price ?? 0 }}">
                                            {{ number_format($item['is_variant'] ? $item['variant']->import_price : $item['product']->import_price) }} đ
                                        </a>
                                    </td>
                                    <td class="text-end fw-semibold">
                                        {{ number_format(($item['is_variant'] ? $item['variant']->import_price : $item['product']->import_price) * ($item['quantity'] ?? 0)) }}
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $item['import_id'] }}">
                                            &times;
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Không có sản phẩm nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Thanh toán -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header fw-semibold">Thông tin thanh toán</div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-3">

                            <li class="d-flex justify-content-between">
                                <span>Giảm giá:</span>
                                <input type="number" name="discount" id="discount" class="form-control form-control-sm w-25 text-end" value="0" min="0">
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Chi phí nhập hàng:</span>
                                <input type="number" name="additional_cost" id="additional_cost" class="form-control form-control-sm w-25 text-end" value="0" min="0">
                            </li>
                            <hr>
                            <li class="d-flex justify-content-between fw-bold">
                                <span>Tiền cần trả NCC:<strong id="grand-total"></strong></span>
                                <span id="total-payable-display" class="text-danger fw-bold">0 đ</span>
                                <input type="hidden" name="total_price" id="total-payable" class="text-danger fw-bold" value="0" min="1">
                            </li>
                        </ul>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_status" value="Đã thanh toán" id="paid">
                            <label class="form-check-label" for="paid">Đã thanh toán</label>
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
                            <input class="form-check-input" type="radio" name="payment_status" value="Thanh toán sau" id="unpaid" checked>
                            <label class="form-check-label" for="unpaid">Thanh toán sau</label>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Thông tin đơn -->
            <div class="col-lg-4">
                <!-- Nhà cung cấp -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <select name="supplier_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">-- Nhà Cung Cấp --</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- Thông tin bổ sung -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <label class="form-label">Nhân viên phụ trách</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">-- Chọn nhân viên phụ trách --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>

                        <label class="form-label">Ngày nhập dự kiến</label>
                        <input type="date" name="import_date" class="form-control mb-2">

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
        <!-- Nút Lưu -->
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save me-2"></i> Lưu đơn nhập
            </button>
        </div>
    </form>

    <!-- Modal cập nhật giá -->
    <div class="modal fade" id="updatePriceModal" tabindex="-1" aria-labelledby="updatePriceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="update-price-form" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePriceLabel">Cập nhật giá</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_id" id="modal-product-id">
                        <input type="hidden" name="variant_id" id="modal-variant-id">
                        <div class="mb-3">
                            <label for="import_price" class="form-label">Giá nhập</label>
                            <input type="number" class="form-control" name="import_price" id="modal-import-price" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá Bán</label>
                            <input type="number" class="form-control" name="price" id="modal-price">
                        </div>
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">Giá Khuyến Mãi</label>
                            <input type="number" class="form-control" name="discount_price" id="modal-discount-price">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const importId = this.dataset.id;
                const quantity = this.value;

                fetch(`/admin/warehouse/update-quantity/${importId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log("Cập nhật thành công");
                        } else {
                            alert("Cập nhật thất bại!");
                        }
                    })
                    .catch(() => alert("Lỗi máy chủ hoặc mạng!"));
            });
        });
    });

    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN').format(number) + ' đ';
    }

    function updateTotals() {
        let total = 0;

        document.querySelectorAll('tr').forEach(row => {
            const priceCell = row.querySelector('td:nth-child(3)');
            const quantityInput = row.querySelector('.quantity-input');
            const totalCell = row.querySelector('td:nth-child(4)');

            if (priceCell && quantityInput && totalCell) {
                const priceText = priceCell.textContent.replace(/[^\d]/g, '');
                const quantity = parseInt(quantityInput.value) || 0;
                const price = parseInt(priceText) || 0;
                const lineTotal = price * quantity;

                total += lineTotal;
                totalCell.textContent = formatCurrency(lineTotal);
            }
        });

        const discount = parseInt(document.getElementById('discount')?.value) || 0;
        const cost = parseInt(document.getElementById('additional_cost')?.value) || 0;
        const grandTotal = total + cost - discount;

        const display = document.getElementById('total-payable-display');
        const input = document.getElementById('total-payable');

        const finalAmount = grandTotal > 0 ? grandTotal : 0;

        if (display) display.textContent = formatCurrency(finalAmount);
        if (input) input.value = finalAmount;
    }


    document.addEventListener('DOMContentLoaded', function() {
        // Gọi hàm lần đầu để hiển thị tổng
        updateTotals();

        // Cập nhật khi thay đổi số lượng
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', updateTotals);
        });

        // Cập nhật khi thay đổi chi phí/giảm giá
        document.getElementById('discount').addEventListener('input', updateTotals);
        document.getElementById('additional_cost').addEventListener('input', updateTotals);
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const importId = this.dataset.id;
                const row = this.closest('tr');

                fetch(`/admin/warehouse/${importId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Xóa dòng khỏi bảng nếu thành công
                            if (row) {
                                row.remove();
                            }
                        } else {
                            console.error("Xóa thất bại: " + data.message);
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi khi xóa:", error);
                    });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const paidRadio = document.getElementById('paid');
        const unpaidRadio = document.getElementById('unpaid');
        const paymentDetail = document.getElementById('payment-detail');

        function togglePaymentForm() {
            if (paidRadio.checked) {
                paymentDetail.classList.remove('d-none');
            } else {
                paymentDetail.classList.add('d-none');
            }
        }

        paidRadio.addEventListener('change', togglePaymentForm);
        unpaidRadio.addEventListener('change', togglePaymentForm);

        // Gọi ngay để set đúng trạng thái ban đầu
        togglePaymentForm();
    });
    document.addEventListener('DOMContentLoaded', function() {
        const paidRadio = document.getElementById('paid');
        const unpaidRadio = document.getElementById('unpaid');
        const paymentAmountInput = document.getElementById('payment_amount');
        const totalInput = document.getElementById('total-payable');
        const paymentDateInput = document.getElementById('payment_date');

        function handlePaymentAmountAndDate() {
            const total = totalInput ? parseFloat(totalInput.value) : 0;

            if (paidRadio.checked) {
                // Cập nhật số tiền thanh toán bằng tổng tiền
                if (paymentAmountInput) {
                    paymentAmountInput.value = total;
                }

                // Khóa ngày thanh toán là hôm nay
                if (paymentDateInput) {
                    const today = new Date().toISOString().split('T')[0];
                    paymentDateInput.value = today;
                    paymentDateInput.readOnly = true;
                }
            } else {
                if (paymentAmountInput) {
                    paymentAmountInput.value = '';
                }

                if (paymentDateInput) {
                    paymentDateInput.readOnly = false;
                }
            }
        }

        paidRadio.addEventListener('change', handlePaymentAmountAndDate);
        unpaidRadio.addEventListener('change', handlePaymentAmountAndDate);

        // Cập nhật khi người dùng thay đổi giảm giá hoặc chi phí
        ['discount', 'additional_cost'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', handlePaymentAmountAndDate);
            }
        });

        // Gọi lúc đầu để thiết lập đúng nếu form reload
        handlePaymentAmountAndDate();
    });



    document.addEventListener('DOMContentLoaded', function() {
    const updateLinks = document.querySelectorAll('.update-price');
    const modal = new bootstrap.Modal(document.getElementById('updatePriceModal'));

    updateLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            // Lấy dữ liệu từ data-attributes
            const productId = this.dataset.productId;
            const variantId = this.dataset.variantId;
            const importPrice = this.dataset.importPrice;
            const price = this.dataset.price;
            const discountPrice = this.dataset.discountPrice;

            // Đổ dữ liệu vào form trong modal
            document.getElementById('modal-product-id').value = productId;
            document.getElementById('modal-variant-id').value = variantId;
            document.getElementById('modal-import-price').value = importPrice;
            document.getElementById('modal-price').value = price;
            document.getElementById('modal-discount-price').value = discountPrice;

            // Mở modal
            modal.show();
        });
    });

    // Gửi form cập nhật giá
    document.getElementById('update-price-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch(`/admin/warehouse/update-price`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Cập nhật thành công');
                location.reload(); // Reload trang để cập nhật UI
            } else {
                alert('Cập nhật thất bại: ' + (data.message || 'Lỗi không xác định'));
            }
        })
        .catch(err => {
            alert('Lỗi khi gửi yêu cầu: ' + err.message);
        });
    });
});

</script>

@endsection
