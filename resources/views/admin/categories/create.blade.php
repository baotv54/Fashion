@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
       <h1 class="my-4 text-center">
            {{ isset($banners) ? '✏️ Chỉnh sửa Banner' : '➕ Thêm mới Banner' }}
        </h1>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nhập tên danh mục">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Danh mục cha</label>
                    <select name="parent_id" class="form-select">
                        <option value="">-- Không có --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Lưu danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
