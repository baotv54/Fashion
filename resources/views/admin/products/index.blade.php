@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Danh Sách Sản Phẩm</h3>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i data-feather="plus" class="me-1"></i> Thêm Sản Phẩm
        </a>
    </div>

    <!-- Form tìm kiếm -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
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
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr class="text-center">
                        <th style="width: 5%;">ID</th>
                        <th style="width: 15%;">Tên</th>
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
                        <td class="text-center">{{ $product->id }}</td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td class="text-end">{{ number_format($product->price) }} VND</td>
                        <td class="text-center">{{ $product->category->name }}</td>
                        <td class="text-center">{{ $product->brand->name ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <img src="{{ asset($product->image) }}" alt="Ảnh chính" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                                @forelse($product->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="Ảnh phụ" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                                @empty
                                    <span class="text-muted small">Không có hình ảnh phụ</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning me-1" title="Sửa">
                                <i data-feather="edit"></i>
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger me-1" title="Xóa">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>

                            <a href="{{ route('product_variants.index', $product->id) }}" class="btn btn-sm btn-outline-primary" title="Quản lý biến thể">
                                <i data-feather="layers"></i>
                            </a>
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
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
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
