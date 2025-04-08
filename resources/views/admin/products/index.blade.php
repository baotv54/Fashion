@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Tiêu đề và nút thêm sản phẩm -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Danh Sách Sản Phẩm</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success btn-lg">
            <i class="fas fa-plus"></i> Thêm Sản Phẩm
        </a>
    </div>

    <!-- Form tìm kiếm -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control form-control-lg" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </div>
    </form>

    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Bảng danh sách sản phẩm -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-light text-center">
                <tr>
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
                        <!-- Hiển thị hình ảnh chính -->
                        <div class="d-flex flex-wrap mb-2">
                            <img src="{{ asset($product->image) }}" alt="Ảnh chính của sản phẩm" 
                                 class="img-thumbnail me-2 shadow-sm rounded" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        
                        <!-- Hiển thị hình ảnh phụ -->
                        @if ($product->images->count() > 0)
                            <div class="d-flex flex-wrap">
                                @foreach($product->images as $image)
                                    <img src="{{ asset($image->image_path) }}" alt="Ảnh phụ của sản phẩm" 
                                         class="img-thumbnail me-2 shadow-sm rounded" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted">Không có hình ảnh phụ</span>
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
