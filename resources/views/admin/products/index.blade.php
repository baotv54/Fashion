<!-- filepath: c:\xampp\htdocs\php3\shoe-store\resources\views\admin\products\index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Danh Sách Sản Phẩm</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Sản Phẩm
        </a>
    </div>

    <!-- Form tìm kiếm -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </div>
    </form>

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Bảng danh sách sản phẩm -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Tên</th>
                    <th style="width: 10%;">Giá</th>
                    <th style="width: 10%;">Danh Mục</th>
                    <th style="width: 10%;">Thương Hiệu</th>
                    <th style="width: 40%;">Hình Ảnh</th>
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
                        @if ($product->images->count() > 0)
                            <div class="d-flex flex-wrap">
                                @foreach($product->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="Ảnh sản phẩm" 
                                         class="img-thumbnail me-1 mb-1 shadow-sm rounded" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">Không có hình ảnh</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" 
                              class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Không tìm thấy sản phẩm nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection