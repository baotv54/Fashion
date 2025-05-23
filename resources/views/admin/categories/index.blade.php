@extends('layouts.admin')

@section('title', 'Danh mục sản phẩm')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Danh sách danh mục sản phẩm</h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Danh Mục
        </a>
    </div>

    <!-- Hiển thị thông báo -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Danh mục cha</th>
                        <th>Trạng thái</th>
                        <th width="20%">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr>
                        <td class="text-center">{{ $category->id }}</td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            @if ($category->children->count() > 0)
                                <ul class="mt-2 ps-3 small text-muted">
                                    @foreach ($category->children as $child)
                                        <li>{{ $child->name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $category->parent ? $category->parent->name : 'Danh mục gốc' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-{{ $category->status ? 'success' : 'secondary' }}">
                                {{ $category->status ? 'Hiển thị' : 'Ẩn' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i data-feather="edit"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Không có danh mục nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
