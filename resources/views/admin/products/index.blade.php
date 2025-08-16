@extends('layouts.admin')

@section('content')
<!-- Product List Widget -->
<div class="card mb-6">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                        <div>
                            <p class="mb-1">In-store Sales</p>
                            <h4 class="mb-1">$5,345.43</h4>
                            <p class="mb-0"><span class="me-2">5k orders</span><span class="badge bg-label-success">+5.7%</span></p>
                        </div>
                        <span class="avatar me-sm-6">
                            <span class="avatar-initial rounded"><i class="icon-base ti tabler-smart-home icon-28px text-heading"></i></span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-6">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                        <div>
                            <p class="mb-1">Website Sales</p>
                            <h4 class="mb-1">$674,347.12</h4>
                            <p class="mb-0"><span class="me-2">21k orders</span><span class="badge bg-label-success">+12.4%</span></p>
                        </div>
                        <span class="avatar p-2 me-lg-6">
                            <span class="avatar-initial rounded"><i class="icon-base ti tabler-device-laptop icon-28px text-heading"></i></span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                        <div>
                            <p class="mb-1">Discount</p>
                            <h4 class="mb-1">$14,235.12</h4>
                            <p class="mb-0">6k orders</p>
                        </div>
                        <span class="avatar p-2 me-sm-6">
                            <span class="avatar-initial rounded"><i class="icon-base ti tabler-gift icon-28px text-heading"></i></span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Affiliate</p>
                            <h4 class="mb-1">$8,345.23</h4>
                            <p class="mb-0"><span class="me-2">150 orders</span><span class="badge bg-label-danger">-3.5%</span></p>
                        </div>
                        <span class="avatar p-2">
                            <span class="avatar-initial rounded"><i class="icon-base ti tabler-wallet icon-28px text-heading"></i></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product List Table -->
<div class="card">

    <div class="card-header border-bottom">
        <h5 class="card-title">Bộ lọc</h5>
        <form method="GET" action="{{ route('products.index') }}" id="filter-form">
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">

                {{-- Ngày tạo --}}
                <div class="col-md-4 product_status">
                    <input type="date" name="created_date"
                        value="{{ old('created_date', $createdDate) }}"
                        class="form-control"
                        onchange="document.getElementById('filter-form').submit()">
                </div>

                {{-- Danh mục --}}
                <div class="col-md-4 product_category">
                    <select name="category" class="form-select text-capitalize"
                        onchange="document.getElementById('filter-form').submit()">
                        <option value="">Danh Mục</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $cat->id == $categoryId ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tình trạng tồn kho --}}
                <div class="col-md-4 product_stock">
                    <select name="stock_status" class="form-select text-capitalize"
                        onchange="document.getElementById('filter-form').submit()">
                        <option value="">Tồn Kho</option>
                        <option value="out_of_stock" {{ $stockStatus == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                        <option value="low_stock" {{ $stockStatus == 'low_stock' ? 'selected' : '' }}>Sắp hết</option>
                        <option value="in_stock" {{ $stockStatus == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                    </select>
                </div>

            </div>
        </form>
    </div>


    <div class="card-datatable">
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6">
                        <form method="GET" action="{{ route('products.index') }}">
                            <input type="text" name="search" value="{{ old('search', $search) }}"
                                class="form-control ms-0" id="dt-search-0" aria-controls="DataTables_Table_0" placeholder="Nhập tên sản phẩm ...">
                            <label for="dt-search-0"></label>
                        </form>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-4">
                        <!-- Form import sản phẩm -->
                        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center gap-2">
                            @csrf

                            <!-- Input chọn file -->
                            <div>
                                <input type="file" name="file" class="form-control" required>
                            </div>

                            <!-- Nút submit -->
                            <div>
                                <button type="submit" class="btn buttons-collection btn-label-secondary dropdown-toggle me-3">
                                    <i class="icon-base ti tabler-upload icon-xs"></i>
                                    <span class="d-none d-sm-inline-block">Import sản phẩm</span>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('products.create') }}" class="btn add-new btn-primary">
                            <i class="icon-base ti tabler-plus me-1 icon-16px"></i>
                            <span class="d-none d-sm-inline-block">Thêm sản phẩm</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-products table dataTable dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                        <colgroup>
                            <col data-dt-column="0" style="width: 49.775px;">
                            <col data-dt-column="1" style="width: 55.9875px;">
                            <col data-dt-column="2" style="width: 446.55px;">
                            <col data-dt-column="3" style="width: 166.838px;">
                            <col data-dt-column="4" style="width: 83.9625px;">
                            <col data-dt-column="5" style="width: 86.4125px;">
                            <col data-dt-column="6" style="width: 113.675px;">
                            <col data-dt-column="7" style="width: 79.825px;">
                            <col data-dt-column="8" style="width: 129.775px;">
                        </colgroup>
                        <thead class="border-top">
                            <tr>
                                <th></th>
                                <th data-dt-column="1" rowspan="1" colspan="1" class="dt-select dt-orderable-none" aria-label=""><span class="dt-column-title"></span><span class="dt-column-order"></span><input class="form-check-input" type="checkbox" aria-label="Select all rows"></th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}" title="Chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết: {{ $product->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Tên sản phẩm</th>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset($product->image) }}" alt="" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                                    <div>
                                                                        <strong>{{ $product->name }}</strong>
                                                                        <br>
                                                                        <small>{{ Str::limit($product->description, 100) }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Danh mục</th>
                                                            <td>{{ $product->category->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Thương hiệu</th>
                                                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <th>SKU</th>
                                                            <td>{{ $product->sku }}</td>
                                                        </tr> -->
                                                        <tr>
                                                            <th>Giá</th>
                                                            <td>{{ number_format($product->price) }} VND</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tồn kho</th>
                                                            <td>{{ $product->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Số lượng</th>
                                                            <td>{{ $product->quantity ?? '0' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Trạng thái</th>
                                                            <td>
                                                                <span class="badge {{ $product->status == 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                                                    {{ $product->status == 'Active' ? 'Hiển thị' : 'Ẩn' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hành động</th>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                            <path d="M16 5l3 3" />
                                                                        </svg>
                                                                    </a>

                                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Xóa">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                <path d="M4 7l16 0" />
                                                                                <path d="M10 11l0 6" />
                                                                                <path d="M14 11l0 6" />
                                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                            </svg>
                                                                        </button>
                                                                    </form>

                                                                    <a href="{{ route('product_variants.index', $product->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Biến thể">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library-plus">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                                            <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                                                            <path d="M11 10h6" />
                                                                            <path d="M14 7v6" />
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">{{ Str::limit($product->name, 40) }}</h6>
                                            <small class="text-truncate d-none d-sm-block">{{ Str::limit($product->description, 60) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center text-heading">

                                        <span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-success me-4">
                                            <i class="icon-base ti tabler-shoe icon-18px"></i>
                                        </span>{{ $product->category->name }}
                                    </span>
                                </td>
                                <!-- <td>
                                    <span class="text-truncate">

                                        <label class="switch switch-primary switch-sm">
                                            <input type="checkbox" class="switch-input" id="switch">
                                            <span class="switch-toggle-slider">
                                                <span class="switch-off"></span>
                                            </span>
                                        </label>
                                        <span class="d-none">Out_of_Stock</span>
                                    </span>
                                </td> -->
                                <td class="text-center">{{ $product->brand->name}}</td>
                                <td class="text-end">{{ number_format($product->price, 0) }} VND</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Xóa">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                            </button>
                                        </form>

                                        <a href="{{ route('product_variants.index', $product->id) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Biến thể">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-library-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 3m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                <path d="M4.012 7.26a2.005 2.005 0 0 0 -1.012 1.737v10c0 1.1 .9 2 2 2h10c.75 0 1.158 -.385 1.5 -1" />
                                                <path d="M11 10h6" />
                                                <path d="M14 7v6" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
            @if ($products->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $products->firstItem() }} đến {{ $products->lastItem() }} trong tổng số {{ $products->total() }} sản phẩm
                    </div>
                </div>
                
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $products->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $products->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($products->getUrlRange(
                                max(1, $products->currentPage() - 2),
                                min($products->lastPage(), $products->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($products->lastPage() > $products->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $products->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $products->url($products->lastPage()) }}">
                                        <i class="icon-base ti tabler-chevrons-right icon-18px"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
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
