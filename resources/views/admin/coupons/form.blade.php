@csrf

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Mã giảm giá <span class="text-danger">*</span></label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code ?? '') }}">
            @error('code')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label>Loại mã <span class="text-danger">*</span></label>
            <select name="type" class="form-control">
                <option value="percent" {{ old('type', $coupon->type ?? '') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                <option value="fixed" {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>Số tiền cố định (₫)</option>
            </select>
            @error('type')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label>Giá trị <span class="text-danger">*</span></label>
            <input type="number" name="value" class="form-control" value="{{ old('value', $coupon->value ?? '') }}" min="0">
             @error('value')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label>Giá trị đơn hàng tối thiểu <span class="text-danger">*</span></label>
            <input type="number" name="min_cart_value" class="form-control" value="{{ old('min_cart_value', $coupon->min_cart_value ?? '') }}" min="0">
             @error('min_cart_value')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label>Giới hạn số lượt sử dụng</label>
            <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" min="1">
             @error('usage_limit')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ old('status', $coupon->status ?? 'active') == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                <option value="inactive" {{ old('status', $coupon->status ?? '') == 'inactive' ? 'selected' : '' }}>Tạm tắt</option>
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" 
                value="{{ old('start_date', isset($coupon->start_date) ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '') }}"
                min="{{ now()->format('Y-m-d') }}">
        </div>

        <div class="form-group">
            <label>Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" 
                value="{{ old('end_date', isset($coupon->end_date) ? \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $coupon->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Hình ảnh</label>
            @if (!empty($coupon->image))
                <div class="mb-2">
                    <img src="{{ asset($coupon->image) }}" alt="Ảnh mã giảm giá" style="max-width: 100px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>
    </div>
</div>

<hr>
<div class="text-right">
    <button type="submit" class="btn btn-success">
        <i class="fas fa-save mr-1"></i> Lưu mã giảm giá
    </button>
</div>
