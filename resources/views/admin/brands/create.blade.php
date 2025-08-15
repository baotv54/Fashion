@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">{{ isset($brand) ? '✏️ Chỉnh sửa thương hiệu' : '➕ Thêm mới thương hiệu' }}</h1>

    <form action="{{ isset($brand) ? route('brands.update', $brand->id) : route('brands.store') }}" method="POST" class="card p-4 shadow">
        @csrf
        @if(isset($brand))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Tên thương hiệu:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $brand->name ?? '') }}">
             @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái:</label>
            <select name="status" id="status" class="form-select">
                <option value="1" {{ (isset($brand) && $brand->status) ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ (isset($brand) && !$brand->status) ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('brands.index') }}" class="btn btn-secondary">⬅️ Quay lại</a>
            <button type="submit" class="btn btn-success">{{ isset($brand) ? '✔️ Cập nhật' : '➕ Thêm mới' }}</button>
        </div>
    </form>
</div>
@endsection
