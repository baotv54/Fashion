@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-datatable">
        @if(session('success'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        @endif

        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6">

                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-6">
                        <button class="btn add-new btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommerceCategoryList"><span><i class="icon-base ti tabler-plus icon-16px me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Thêm Danh Mục</span></span></button>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table border-top">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-category-list table dataTable dtr-column" id="DataTables_Table_0" style="width: 100%;">
                        <colgroup>
                            <col style="width: 40px;">
                            <col>
                            <col style="width: 200px;">
                            <col style="width: 150px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="dt-select dt-orderable-none">
                                    <input class="form-check-input" type="checkbox" aria-label="Chọn tất cả">
                                </th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <td>
                                    <input class="form-check-input" type="checkbox" aria-label="Chọn danh mục {{ $category->name }}">
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if ($category->children->count() > 0)
                                    <ul class="mt-1 ps-3 small text-muted mb-0">
                                        @foreach ($category->children as $child)
                                        <li>{{ $child->name }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </td>
                                <td>{{ $category->parent ? $category->parent->name : 'Danh mục gốc' }}</td>
                                <td>
                                    <span class="badge {{ $category->status ? 'bg-label-success' : 'bg-label-secondary' }}">
                                        {{ $category->status ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Không có danh mục nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($categories->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $categories->firstItem() }} đến {{ $categories->lastItem() }} trong tổng số {{ $categories->total() }} danh mục
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $categories->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $categories->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($categories->getUrlRange(
                                max(1, $categories->currentPage() - 2),
                                min($categories->lastPage(), $categories->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $categories->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($categories->lastPage() > $categories->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $categories->url($categories->lastPage()) }}">{{ $categories->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$categories->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $categories->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$categories->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $categories->url($categories->lastPage()) }}">
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCategoryList" aria-labelledby="offcanvasEcommerceCategoryListLabel" aria-modal="true" role="dialog">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header py-6">
        <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">Thêm danh mục</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <!-- Offcanvas Body -->
    <div class="offcanvas-body border-top">
        <form action="{{ route('categories.store') }}" method="POST" id="eCommerceCategoryListForm" class="pt-0 fv-plugins-bootstrap5 fv-plugins-framework">
            @csrf
            <!-- Tên danh mục -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="category-title">Tên danh mục</label>
                <input type="text" class="form-control" id="category-title" name="name" placeholder="Nhập tên danh mục" aria-label="category title">
                @error('name')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <!-- Danh mục cha -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="category-parent">Danh mục cha</label>
                <select id="category-parent" name="parent_id" class="form-select">
                    <option value="">-- Không có --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Trạng thái -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="category-status">Trạng thái</label>
                <select id="category-status" name="status" class="form-select">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
            <!-- Submit -->
            <div class="mb-6">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Thêm danh mục</button>
            </div>
        </form>
    </div>
</div>
@endsection