@extends('layouts.admin')

@section('content')
@include('admin.check_admin.check')

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
        @if(session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
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
                        <div class="dt-search-input">
                            <h3 class="mb-0">Giá Trị Thuộc Tính: <span class="text-primary">{{ $attribute->name }}</span></h3>
                        </div>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-6">
                        <a href="{{ route('attributes.index') }}" class="btn btn-outline-primary">Quay lại</a>
                        <button class="btn add-new btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommerceattributeValuesList"><span><i class="icon-base ti tabler-plus icon-16px me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Thêm Giá Trị</span></span></button>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table border-top">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-attributeValues-list table dataTable dtr-column" id="DataTables_Table_0" style="width: 100%;">
                        <colgroup>
                            <col style="width: 40px;">
                            <col>
                            <col style="width: 200px;">
                            <col style="width: 150px;">
                            <col style="width: 120px;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Tên giá trị</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attributeValues as $value)
                            <td>

                            </td>
                            <td>
                                <strong>{{ $value->value }}</strong>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('attribute_values.edit', [$attribute->id, $value->id]) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('attribute_values.destroy', [$attribute->id, $value->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                                <td colspan="5" class="text-center text-muted">Không có thuộc tính nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($attributeValues->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $attributeValues->firstItem() }} đến {{ $attributeValues->lastItem() }} trong tổng số {{ $attributeValues->total() }} danh mục
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $attributeValues->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $attributeValues->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $attributeValues->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $attributeValues->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($attributeValues->getUrlRange(
                                max(1, $attributeValues->currentPage() - 2),
                                min($attributeValues->lastPage(), $attributeValues->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $attributeValues->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($attributeValues->lastPage() > $attributeValues->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $attributeValues->url($attributeValues->lastPage()) }}">{{ $attributeValues->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$attributeValues->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $attributeValues->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$attributeValues->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $attributeValues->url($attributeValues->lastPage()) }}">
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceattributeValuesList" aria-labelledby="offcanvasEcommerceattributeValuesListLabel" aria-modal="true" role="dialog">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header py-6">
        <h5 id="offcanvasEcommerceattributeValuesListLabel" class="offcanvas-title">Thêm thuộc tính</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <!-- Offcanvas Body -->
    <div class="offcanvas-body border-top">
        <form action="{{ route('attribute_values.store', $attribute->id) }}" method="POST" id="eCommerceattributeValuesListForm" class="pt-0 fv-plugins-bootstrap5 fv-plugins-framework">
            @csrf
            <!-- Tên thương hiệu -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="attributeValues-title">Tên thuộc tính</label>
                <input type="text" class="form-control" id="attributeValues-title" name="value" placeholder="Nhập tên thuộc tính" aria-label="attributeValues title" required>
                @error('value')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit -->
            <div class="mb-6">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Thêm thuộc tính</button>
            </div>
        </form>
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
