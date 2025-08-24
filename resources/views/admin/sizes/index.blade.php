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
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6">

                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-6">
                        <button class="btn add-new btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommercesizeList"><span><i class="icon-base ti tabler-plus icon-16px me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Thêm</span></span></button>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table border-top">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-size-list table dataTable dtr-column" id="DataTables_Table_0" style="width: 100%;">
                        <colgroup>
                            <col>
                            <col>
                            <col>
                            <col>
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Size</th>
                                <th>Chiều cao (cm)</th>
                                <th>Cân nặng (kg)</th>
                                <th>Rộng ngực (cm)</th>
                                <th>Rộng mông (cm)</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sizes as $index => $size)
                            <tr>
                                <td>

                                </td>
                                <td>{{ $size->size }}</td>
                                <td>{{ $size->height_range }}</td>
                                <td>{{ $size->weight_range }}</td>
                                <td>{{ $size->chest_range }}</td>
                                <td>{{ $size->hip_range }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('sizes.edit', $size->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('sizes.destroy', $size->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                                <td colspan="5" class="text-center text-muted">Không có bảng nào nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($sizes->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $sizes->firstItem() }} đến {{ $sizes->lastItem() }} trong tổng số {{ $sizes->total() }} danh mục
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $sizes->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $sizes->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $sizes->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $sizes->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($sizes->getUrlRange(
                                max(1, $sizes->currentPage() - 2),
                                min($sizes->lastPage(), $sizes->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $sizes->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($sizes->lastPage() > $sizes->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $sizes->url($sizes->lastPage()) }}">{{ $sizes->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$sizes->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $sizes->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$sizes->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $sizes->url($sizes->lastPage()) }}">
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommercesizeList" aria-labelledby="offcanvasEcommercesizeListLabel" aria-modal="true" role="dialog">
    <!-- Offcanvas Header -->
    <div class="offcanvas-header py-6">
        <h5 id="offcanvasEcommercesizeListLabel" class="offcanvas-title">Thêm</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <!-- Offcanvas Body -->
    <div class="offcanvas-body border-top">
        <form action="{{ route('sizes.store') }}" method="POST" id="eCommercesizeListForm" class="pt-0 fv-plugins-bootstrap5 fv-plugins-framework">
            @csrf
            <!-- Size -->
            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="size-title">Size</label>
                <input type="text" class="form-control" id="size-title" value="{{ old('size') }}" name="size" placeholder="Nhập Size" aria-label="size title">
                @error('size')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="height_range">Chiều cao (cm)</label>
                <input type="text" class="form-control" id="height_range" value="{{ old('height_range') }}" name="height_range" placeholder="Nhập Chiều cao (cm)" aria-label="Chiều cao (cm) title">
                @error('height_range')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="weight_range">Cân nặng (kg)</label>
                <input type="text" class="form-control" id="weight_range" value="{{ old('weight_range') }}" name="weight_range" placeholder="Nhập Cân nặng (kg)" aria-label="Cân nặng (kg) title">
                @error('weight_range')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="chest_range">Rộng ngực (cm)</label>
                <input type="text" class="form-control" id="chest_range" value="{{ old('chest_range') }}" name="chest_range" placeholder="Nhập Rộng ngực (cm)" aria-label="Rộng ngực (cm) title">
                @error('chest_range')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-6 form-control-validation fv-plugins-icon-container">
                <label class="form-label" for="hip_range">Rộng mông (cm)</label>
                <input type="text" class="form-control" id="hip_range" value="{{ old('hip_range') }}" name="hip_range" placeholder="Nhập Rộng mông (cm)" aria-label="Rộng mông (cm) title">
                @error('hip_range')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit -->
            <div class="mb-6">
                <button type="submit" class="btn btn-primary me-sm-3 me-1 waves-effect waves-light">Thêm</button>
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
