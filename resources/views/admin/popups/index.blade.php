@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-4 text-center">Quản lý Popup</h1>

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
        <a href="{{ route('popups.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Popup
        </a>
    </div>

    {{-- Bảng danh sách --}}
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Ảnh / Video</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($popups as $popup)
                        <tr>
                            <td>{{ $popup->id }}</td>
                            <td>{{ $popup->title }}</td>
                            <td>{{ $popup->description }}</td>
                            <td class="text-center">
                                @if ($popup->media_type === 'image')
                                    <img src="{{ asset('storage/' . $popup->media_path) }}" 
                                         alt="Ảnh popup" 
                                         class="rounded border" 
                                         style="width: 100px; height: 70px; object-fit: cover;">
                                @elseif ($popup->media_type === 'video')
                                    <video autoplay muted controls 
                                           class="rounded border" 
                                           style="width: 100px; height: 70px; object-fit: cover;">
                                        <source src="{{ asset('storage/' . $popup->media_path) }}" type="video/mp4">
                                    </video>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $popup->status ? 'success' : 'secondary' }}">
                                    {{ $popup->status ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('popups.edit', $popup->id) }}" 
                                   class="btn btn-sm btn-outline-warning me-1" 
                                   title="Chỉnh sửa">
                                    <i data-feather="edit">Sửa</i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="confirmDelete({{ $popup->id }})" 
                                        title="Xoá">
                                    <i data-feather="trash-2">Xoá</i>
                                </button>
                                <form id="delete-form-{{ $popup->id }}" 
                                      action="{{ route('popups.destroy', $popup->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted">Không có popup nào.</td>
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
        if (confirm("Bạn có chắc chắn muốn xóa popup này không?")) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection
