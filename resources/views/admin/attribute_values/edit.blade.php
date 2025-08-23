@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Sửa Giá Trị Thuộc Tính: <span class="text-primary">{{ $attribute->name }}</span></h2>
    </div>

    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-6">
            <div class="card mb-4">
                <form action="{{ route('attribute_values.update', [$attribute->id, $attributeValue->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <h5 class="card-title">Thông tin danh mục</h5>

                        <div class="mb-3">
                            <label for="value" class="form-label">Tên danh mục</label>
                            <input type="text" name="value" id="value" class="form-control" value="{{ $attributeValue->value }}">
                            @error('value')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('attribute_values.index', $attribute->id) }}" class="btn btn-outline-primary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
