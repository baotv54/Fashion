@extends('layouts.admin')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<div class="container mt-4">
    @if(session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Chỉnh Sửa Danh Mục</h2>
    </div>

    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-6">
            <div class="card mb-4">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="card-body">
                        <h5 class="card-title">Thông tin danh mục</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ $category->status ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ !$category->status ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cột phải: Thêm danh mục con & danh sách danh mục con -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Danh mục con hiện có</h5>
                    @if ($category->children->count() > 0)
                    <div class="list-group">
                        @foreach ($category->children as $child)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <form action="{{ route('categories.update', $child->id) }}" method="POST" class="d-flex flex-grow-1 me-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" class="form-control me-2" value="{{ old('name', $child->name) }}" required>
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-upload">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M12 11v6" />
                                        <path d="M9.5 13.5l2.5 -2.5l2.5 2.5" />
                                    </svg>
                                </button>
                            </form>

                            <form action="{{ route('categories.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted">Chưa có danh mục con nào.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        feather.replace();
    });
</script>
@endpush
@endsection