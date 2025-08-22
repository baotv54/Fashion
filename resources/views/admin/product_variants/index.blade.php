@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-datatable">
        <div id="DataTables_Variants_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6">
                        <input type="search" class="form-control ms-0" id="dt-search-variants" placeholder="Tìm kiếm biến thể" aria-controls="DataTables_Variants">
                        <label for="dt-search-variants"></label>
                    </div>
                </div>
                <!-- <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-6">
                        <a href="{{ route('product_variants.create', $product->id) }}" class="btn btn-primary">
                            <i class="icon-base ti tabler-plus icon-16px me-2"></i> Thêm biến thể
                        </a>
                    </div>
                </div> -->
            </div>

            <div class="justify-content-between dt-layout-table border-top">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-variants-list table dataTable dtr-column" id="DataTables_Variants" style="width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">Thuộc tính</th>
                                <th class="text-center">Tồn kho</th>
                                <th class="text-center">Giá</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($variants as $variant)
                            <tr>
                                <td class="text-center">
                                    @if ($variant->image && file_exists(public_path($variant->image)))
                                    <img src="{{ asset($variant->image) }}" alt="Ảnh biến thể" class="rounded border shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                    <span class="text-muted">Không có ảnh</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($variant->attributeValues->isNotEmpty())
                                    @foreach ($variant->attributeValues as $value)
                                    <span class="badge bg-secondary me-1">
                                        {{ $value->attributeValue->value ?? 'N/A' }}
                                    </span>
                                    @endforeach
                                    @else
                                    <span class="text-muted">Không có thuộc tính</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $variant->stock }}</td>
                                <td class="text-center">{{ number_format($variant->price) }} VNĐ</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('product_variants.destroy', [$product->id, $variant->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa biến thể này?');">
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
                                <td colspan="5" class="text-center text-muted">Chưa có biến thể nào cho sản phẩm này.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($variants->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $variants->firstItem() }} đến {{ $variants->lastItem() }} trong tổng số {{ $variants->total() }} biến thể
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $variants->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $variants->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $variants->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $variants->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($variants->getUrlRange(
                                max(1, $variants->currentPage() - 2),
                                min($variants->lastPage(), $variants->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $variants->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($variants->lastPage() > $variants->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $variants->url($variants->lastPage()) }}">{{ $variants->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$variants->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $variants->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$variants->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $variants->url($variants->lastPage()) }}">
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
@endsection
