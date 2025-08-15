@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ request('stock_filter') == null ? 'active' : '' }}"
                href="{{ route('warehouse.index') }}">
                Tất cả
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('stock_filter') == 'in_stock' ? 'active' : '' }}"
                href="{{ route('warehouse.index', ['stock_filter' => 'in_stock']) }}">
                Còn hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('stock_filter') == 'out_of_stock' ? 'active' : '' }}"
                href="{{ route('warehouse.index', ['stock_filter' => 'out_stock']) }}">
                Hết hàng
            </a>
        </li>
    </ul>
    <!-- Form tìm kiếm -->
    <form action="{{ route('warehouse.index') }}" method="GET" class="mb-3">
        <div class="row g-2">
            <!-- Tìm kiếm -->
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="🔍 Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i data-feather="search"></i>
                    </button>
                </div>
            </div>

            <!-- Lọc danh mục -->
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">-- Tất cả danh mục --</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Nút lọc -->
            <div class="col-md-3">
                <button class="btn btn-secondary w-100" type="submit">
                    <i data-feather="filter"></i> Lọc
                </button>
            </div>
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
                        <th style="width: 10%;">Hình Ảnh</th>
                        <th style="width: 30%;">Tên</th>
                        <th style="width: 15%;">Mã Sản Phẩm</th>
                        <th style="width: 15%;">Tồn Kho</th>
                        <th style="width: 15%;">Có Thể Bán</th>
                        <th style="width: 20%;">Giá Nhập</th>
                        <th style="width: 20%;">Giá Bán</th>



                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset($product->image) }}" alt="Ảnh chính" class="text-center" style="width: 80px; height: 80px; object-fit: cover;">
                        </td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td class="text-center">{{ $product->slug }}</td>
                        <td class="text-center">{{ $product->quantity }}</td>
                        <td class="text-center">{{ $product->quantity }}</td>
                        <td class="text-center">{{ $product->import_price }}</td>
                        <td class="text-center">{{ $product->price }}</td>
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
                    @php
                    $queryParams = request()->except('page'); // giữ lại các filter khác
                    @endphp

                    @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() . '&' . http_build_query($queryParams) }}" rel="prev">‹</a>
                    </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @php
                    $fullUrl = $url . '&' . http_build_query($queryParams);
                    @endphp
                    @if ($page == $products->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $fullUrl }}">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() . '&' . http_build_query($queryParams) }}" rel="next">›</a>
                    </li>
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
