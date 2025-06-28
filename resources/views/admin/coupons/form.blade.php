@csrf

<div class="row g-4">
    <!-- Cột trái -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">
                Thông tin mã giảm giá
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                           value="{{ old('code', $coupon->code ?? '') }}">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại mã <span class="text-danger">*</span></label>
                    <select name="type" class="form-select">
                        <option value="percent" {{ old('type', $coupon->type ?? '') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                        <option value="fixed" {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>Số tiền cố định (₫)</option>
                    </select>
                    @error('type') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                    <input type="number" name="value" min="0" class="form-control"
                           value="{{ old('value', $coupon->value ?? '') }}">
                    @error('value') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
                    <input type="number" name="min_cart_value" min="0" class="form-control"
                           value="{{ old('min_cart_value', $coupon->min_cart_value ?? '') }}">
                    @error('min_cart_value') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Giới hạn số lượt sử dụng</label>
                    <input type="number" name="usage_limit" min="1" class="form-control"
                           value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $coupon->status ?? 'active') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                        <option value="inactive" {{ old('status', $coupon->status ?? '') == 'inactive' ? 'selected' : '' }}>Tạm tắt</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Cột phải -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">
                Cài đặt thêm
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="form-control"
                           value="{{ old('start_date', isset($coupon->start_date) ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '') }}"
                           min="{{ now()->format('Y-m-d') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="form-control"
                           value="{{ old('end_date', isset($coupon->end_date) ? \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" rows="3" class="form-control">{{ old('description', $coupon->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hình ảnh</label>
                    @if (!empty($coupon->image))
                        <div class="mb-2">
                            <img src="{{ asset($coupon->image) }}" alt="Ảnh mã giảm giá" class="img-thumbnail" style="max-width: 100px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted">Dung lượng tối đa 2MB</small>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="text-end">
    <button type="submit" class="btn btn-success px-4">
        <i class="bi bi-save me-1"></i> Lưu mã giảm giá
    </button>
</div>
