@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold">📝 Danh Sách Bài Viết</h3>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Bài Viết
        </a>
    </div>

    <!-- Tìm kiếm bài viết -->
    <form action="{{ route('posts.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="🔍 Tìm kiếm bài viết..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">
                <i data-feather="search"></i>
            </button>
        </div>
    </form>

    <!-- Alert -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Bảng bài viết -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 20%;">Tiêu Đề</th>
                        <th style="width: 15%;">Tác Giả</th>
                        <th style="width: 20%;">Hình Ảnh</th>
                        <th style="width: 25%;">Tóm Tắt</th>
                        <th style="width: 15%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td class="text-center">{{ $post->id }}</td>
                        <td><strong>{{ $post->title }}</strong></td>
                        <td class="text-center">{{ $post->author }}</td>
                        <td class="text-center">
                            <img src="{{ asset($post->image) }}" alt="Ảnh bài viết" class="rounded border" style="width: 100px; height: 70px; object-fit: cover;">
                        </td>
                        <td>{!! Str::limit(strip_tags($post->content), 100) !!}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa">
                                    <i data-feather="edit"></i>
                                </a>

                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Không có bài viết nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Phân trang -->
            @if ($posts->hasPages())
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($posts->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">‹</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">‹</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($posts->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">›</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">›</span></li>
                    @endif
                </ul>
            </nav>
            @endif
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
