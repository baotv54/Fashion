@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-4 text-center">Danh sách Banner</h1>

        {{-- Thông báo --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Nút thêm mới --}}
        <div class="mb-3 d-flex justify-content-end">
            <a href="{{ route('banners.create') }}" class="btn btn-primary">
                <i data-feather="plus" class="me-1"></i> Thêm Banner
            </a>
        </div>

        {{-- Bảng danh sách --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Link</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banners as $banner)
                            <tr>
                                <td>{{ $banner->id }}</td>
                                <td>{{ $banner->title }}</td>
                                <td>{{ $banner->subtitle }}</td>
                                <td> {{ $banner->link}} </td>
                                <td>
                                    <a href="{{ $banner->link ?? '#' }}">
                                        <img src="/imgBanner/{{ $banner->image }}" width="100px"
                                            style="max-height: 80px; object-fit: cover;" />
                                    </a>
                                </td>


                                <td>
                                    <a href="{{ route('banners.edit', $banner->id) }}"
                                        class="btn btn-sm btn-outline-warning me-1" title="Chỉnh sửa" onclick="return confirm ('bạn có muốn thực hiện hành động này không')">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete({{ $banner->id }})" title="Xoá">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                    <form id="delete-form-{{ $banner->id }}"
                                        action="{{ route('banners.destroy', $banner->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">Không có banner nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Nhúng script trực tiếp --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
