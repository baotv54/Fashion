@csrf
<div class="form-group">
    <label>Mã giảm giá</label>
    <input type="text" name="code" class="form-control" value="{{ old('code', $coupon->code ?? '') }}" required>
</div>

<div class="form-group">
    <label>Loại mã</label>
    <select name="type" class="form-control" required>
        <option value="percent" {{ (old('type', $coupon->type ?? '') == 'percent') ? 'selected' : '' }}>Phần trăm</option>
        <option value="fixed" {{ (old('type', $coupon->type ?? '') == 'fixed') ? 'selected' : '' }}>Số tiền cố định</option>
    </select>
</div>

<div class="form-group">
    <label>Giá trị</label>
    <input type="number" name="value" class="form-control" value="{{ old('value', $coupon->value ?? '') }}" required>
</div>

<div class="form-group">
    <label>Giá trị đơn hàng tối thiểu</label>
    <input type="number" name="min_cart_value" class="form-control" value="{{ old('min_cart_value', $coupon->min_cart_value ?? '') }}" required>
</div>

<div class="form-group">
    <label>Ngày bắt đầu</label>
    <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ?? '') }}">
</div>

<div class="form-group">
    <label>Ngày kết thúc</label>
    <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date ?? '') }}">
</div>

<div class="form-group">
    <label>Giới hạn số lượt sử dụng</label>
    <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
</div>

<!-- <div class="form-group">
    <label>Số lượt đã sử dụng</label>
    <input type="number" name="used" class="form-control" value="{{ old('used', $coupon->used ?? 0) }}" readonly>
</div> -->

<div class="form-group">
    <label>Mô tả</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $coupon->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Hình ảnh</label>
    @if(!empty($coupon->image))
    <div class="mb-2">
        <img src="{{ asset($coupon->image) }}" alt="Hình ảnh mã giảm giá" style="max-width: 100px;">
    </div>
    @endif
    <input type="file" name="image" class="form-control">
</div>

<button type="submit" class="btn btn-success">Lưu</button>