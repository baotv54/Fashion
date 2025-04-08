@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Thêm biến thể cho: {{ $product->name }}</h2>

        <form action="{{ route('product_variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Giá</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Số lượng</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Ảnh</label>
                <input type="file" name="image" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Giá trị thuộc tính</label>
                @foreach ($attributes as $attribute)
                    <label>{{ $attribute->name }}</label>
                    <select name="attribute_values[]" class="form-control" required>
                        <option value="">-- Chọn {{ $attribute->name }} --</option>
                        @foreach ($attribute->values as $value)
                            <option value="{{ $value->id }}">{{ $value->value }}</option>
                        @endforeach
                    </select>
                @endforeach
            </div>

            <button class="btn btn-primary">Thêm</button>
        </form>
    </div>
@endsection
