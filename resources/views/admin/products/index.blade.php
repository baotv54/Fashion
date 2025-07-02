@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold">📦 Danh Sách Sản Phẩm</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Sản Phẩm
        </a>
    </div>

    <!-- Import sản phẩm -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                @csrf
                <div class="col-auto">
                    <input type="file" name="file" class="form-control" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-success">
                        <i data-feather="upload-cloud" class="me-1"></i> Import sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form tìm kiếm -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="🔍 Tìm kiếm sản phẩm..." value="{{ request('search') }}">
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

    <!-- Bảng sản phẩm -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th style="width: 20%;">Tên</th>
                        <th style="width: 10%;">Giá</th>
                        <th style="width: 15%;">Danh Mục</th>
                        <th style="width: 15%;">Thương Hiệu</th>
                        <th style="width: 30%;">Hình Ảnh</th>
                        <th style="width: 10%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td class="text-end text-nowrap">{{ number_format($product->price) }} VND</td>
                        <td class="text-center">{{ $product->category->name }}</td>
                        <td class="text-center">{{ $product->brand->name ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <!-- Ảnh chính -->
                                <img src="{{ asset($product->image) }}" alt="Ảnh chính" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">

                                <!-- Hiển thị tối đa 3 ảnh phụ -->
                                @php
                                $extraCount = $product->images->count() - 2;
                                @endphp

                                @foreach($product->images->take(2) as $image)
                                <img src="{{ asset($image->image_path) }}" alt="Ảnh phụ" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                                @endforeach

                                @if($extraCount > 0)
                                <div class="d-flex align-items-center justify-content-center rounded border bg-light" style="width: 60px; height: 60px;">
                                    <span class="text-muted small">+{{ $extraCount }}</span>
                                </div>
                                @endif
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning" title="Sửa">
                                    <i data-feather="edit"></i>
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>

                                <a href="{{ route('product_variants.index', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Quản lý biến thể">
                                    <i data-feather="layers"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Không tìm thấy sản phẩm nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if ($products->hasPages())
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">‹</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">›</a></li>
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
