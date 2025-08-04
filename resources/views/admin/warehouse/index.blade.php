@extends('layouts.admin')

@section('content')
    <div class="container-fluid p-0">
        <!-- Tabs lọc -->
        <ul class="nav nav-pills mb-3 small">
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
                <a class="nav-link {{ request('stock_filter') == 'out_stock' ? 'active' : '' }}"
                    href="{{ route('warehouse.index', ['stock_filter' => 'out_stock']) }}">
                    Hết hàng
                </a>
            </li>
        </ul>

        <!-- Form tìm kiếm -->
        <form action="{{ route('warehouse.index') }}" method="GET" class="mb-3">
            <div class="row g-2 align-items-end">
                <!-- Tìm kiếm -->
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                        <input type="text" name="search" class="form-control"
                            placeholder="Tìm kiếm theo mã SKU, tên sản phẩm, barcode" value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Lọc danh mục -->
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">-- Tất cả danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
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
                <table class="table table-bordered table-hover align-middle small">
                    <thead style="background-color: #e5e5ea;" class="text-center fw-bold text-uppercase">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên</th>
                            <th>Mã sản phẩm</th>
                            <th>Tồn kho</th>
                            <th>Có thể bán</th>
                            <th>Giá nhập</th>
                            <th>Giá bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset($product->image) }}" alt="Ảnh sản phẩm"
                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd;">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td class="text-center">{{ $product->slug }}</td>
                                <td class="text-center">{{ $product->quantity }}</td>
                                <td class="text-center">{{ $product->quantity }}</td>
                                <td class="text-center">{{ number_format($product->import_price) }}₫</td>
                                <td class="text-center">{{ number_format($product->price) }}₫</td>
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
                            @php $queryParams = request()->except('page'); @endphp

                            {{-- Previous --}}
                            @if ($products->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">‹</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $products->previousPageUrl() . '&' . http_build_query($queryParams) }}">‹</a>
                                </li>
                            @endif

                            {{-- Page numbers --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @php $fullUrl = $url . '&' . http_build_query($queryParams); @endphp
                                <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $fullUrl }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Next --}}
                            @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $products->nextPageUrl() . '&' . http_build_query($queryParams) }}">›</a>
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
