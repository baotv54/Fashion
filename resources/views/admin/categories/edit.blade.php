@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Chỉnh sửa danh mục</h3>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i data-feather="arrow-left"></i> Quay lại
        </a>
    </div>

    <!-- Thông báo lỗi -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form chỉnh sửa danh mục -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin danh mục</h5>
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
                    <label class="form-label">Danh mục cha</label>
                    <input type="text" class="form-control" value="{{ $category->parent ? $category->parent->name : 'Không có' }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" {{ $category->status ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ !$category->status ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i data-feather="save" class="me-1"></i> Cập nhật danh mục
                </button>
            </form>
        </div>
    </div>

    <!-- Form thêm danh mục con -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Thêm danh mục con</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" class="row g-3 align-items-center">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $category->id }}">
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" placeholder="Tên danh mục con" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100">
                        <i data-feather="plus" class="me-1"></i> Thêm danh mục con
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Danh sách danh mục con -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Danh mục con</h5>
        </div>
        <div class="card-body">
            @if ($category->children->count() > 0)
                <div class="list-group">
                    @foreach ($category->children as $child)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <form action="{{ route('categories.update', $child->id) }}" method="POST" class="d-flex flex-grow-1 me-3">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" class="form-control me-2" value="{{ old('name', $child->name) }}" required>
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i data-feather="check"></i>
                                </button>
                            </form>
                            <form action="{{ route('categories.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted">Không có danh mục con nào.</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();
    });
</script>
@endpush
@endsection
