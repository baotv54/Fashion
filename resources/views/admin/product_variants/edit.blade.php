@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Cập nhật biến thể</h2>

    <form action="{{ route('product_variants.update', [$productId, $variant->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Giá</label>
            <input type="number" name="price" value="{{ $variant->price }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Số lượng</label>
            <input type="number" name="stock" value="{{ $variant->stock }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Ảnh (để trống nếu không đổi)</label>
            <input type="file" name="image" class="form-control">
            @if ($variant->image)
            <img src="{{ asset($variant->image) }}" width="80" class="mt-2">
            @endif
        </div>

        <div class="mb-3">
            <label>Giá trị thuộc tính</label>
            @foreach ($attributes as $attribute)
            <label>{{ $attribute->name }}</label>
            <select name="attribute_values[]" class="form-control" required>
                <option value="">-- Chọn {{ $attribute->name }} --</option>
                @foreach ($attribute->values as $value)
                <option value="{{ $value->id }}"
                    @if ($variant->attributeValues->contains($value->id)) selected @endif>
                    {{ $value->value }}
                </option>
                @endforeach
            </select>
            @endforeach
        </div>

        <button class="btn btn-success">Cập nhật</button>
    </form>
</div>
@endsection