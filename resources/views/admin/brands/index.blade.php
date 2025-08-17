@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-4 text-center">Danh sách Thương Hiệu</h1>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Nút thêm mới --}}
    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('brands.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Thương Hiệu
        </a>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th> Ảnh </th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->slug }}</td>
                            <td class="text-center">
                            <img src="{{ asset($brand->image) }}" alt="Ảnh bài viết" class="rounded border" style="width: 100px; height: 70px; object-fit: cover;">
                        </td>
                            <td>
                                <span class="badge bg-{{ $brand->status ? 'success' : 'secondary' }}">
                                    {{ $brand->status ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Chỉnh sửa">
                                    <i data-feather="edit">Sửa</i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $brand->id }})" title="Xoá">
                                    <i data-feather="trash-2">Xoá</i>
                                </button>
                                <form id="delete-form-{{ $brand->id }}" action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Không có thương hiệu nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Nhúng script trực tiếp --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });

    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa thương hiệu này không?")) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
