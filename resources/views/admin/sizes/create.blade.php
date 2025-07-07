@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Thêm Size Mới</h2>
    <form action="{{ route('sizes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="height" class="form-label">Chiều cao</label>
            <input type="number" step="0.01" name="height" id="height" class="form-control" value="{{ old('height') }}" placeholder="Nhập chiều cao">
        </div>
        <div class="mb-3">
            <label for="width" class="form-label">Chiều rộng</label>
            <input type="number" step="0.01" name="width" id="width" class="form-control" value="{{ old('width') }}" placeholder="Nhập chiều rộng">
        </div>
        <div class="mb-3">
            <label for="weight" class="form-label">Cân nặng (kg)</label>
            <input type="number" step="0.01" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" placeholder="Nhập cân nặng">
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}" placeholder="Nhập tên size" required>
        </div>
        <button type="submit" class="btn btn-success">Tạo Mới</button>
        <a href="{{ route('sizes.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection 