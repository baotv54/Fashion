<!-- filepath: c:\xampp\htdocs\php3\shoe-store\resources\views\categories\edit.blade.php -->
@extends('layouts.app')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Chỉnh sửa danh mục</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>

    <!-- Hiển thị thông báo lỗi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form chỉnh sửa danh mục cha -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5>Chỉnh sửa danh mục cha</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="parent" class="form-label">Danh mục cha</label>
                    <input type="text" id="parent" class="form-control" value="{{ $category->parent ? $category->parent->name : 'Không có' }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ $category->status ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ !$category->status ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật danh mục cha</button>
            </form>
        </div>
    </div>

    <!-- Form thêm danh mục con -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5>Thêm danh mục con</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $category->id }}">

                <div class="row">
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" placeholder="Tên danh mục con" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100">Thêm danh mục con</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách danh mục con -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5>Danh mục con</h5>
        </div>
        <div class="card-body">
            @if ($category->children->count() > 0)
                @foreach ($category->children as $child)
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <form action="{{ route('categories.update', $child->id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" class="form-control me-2" value="{{ old('name', $child->name) }}" required>
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('categories.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">Xóa</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Không có danh mục con nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection