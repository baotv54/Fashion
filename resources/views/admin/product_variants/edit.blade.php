@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chỉnh Sửa Biến Thể</h2>
    </div>


    <form action="{{ route('product_variants.update', [$productId, $variant->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Thông tin sản phẩm</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Giá</label>
                                <input type="number" id="price" name="price" value="{{ $variant->price }}" class="form-control">
                                @error('price')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Số lượng</label>
                                <input type="number" id="stock" name="stock" value="{{ $variant->stock }}" class="form-control">
                                @error('stock')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($attributes as $attribute)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $attribute->name }}</label>
                                <select name="attribute_values[]" class="form-select">
                                    <option value="">-- Chọn {{ $attribute->name }} --</option>
                                    @foreach ($attribute->values as $value)
                                    <option value="{{ $value->id }}"
                                        @if ($variant->attributeValues->contains('id', $value->id)) selected @endif>
                                        {{ $value->value }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('attribute_values')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <label class="form-label">Ảnh (để trống nếu không đổi)</label>
                        <input type="file" name="image" class="form-control mb-2" accept="image/*">

                        @if ($variant->image)
                        <div class="mt-2">
                            <img src="{{ asset($variant->image) }}" class="img-fluid rounded border" style="width: 100%; max-width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Nút -->
            <div class="mt-3">
                <button class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Quay lại</a>
            </div>
    </form>
</div>
@endsection
