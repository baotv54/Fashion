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
                        <div class="dt-search-input">
                            <h1 class="h3 mb-4 text-center">Danh sách Popup</h1>
                        </div>
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-6">
                        <a href="{{ route('popups.create') }}" class="btn add-new btn-primary">
                            <i class="icon-base ti tabler-plus me-1 icon-16px"></i>
                            <span class="d-none d-sm-inline-block">Thêm Popup</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table border-top">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-brand-list table dataTable dtr-column" id="DataTables_Table_0" style="width: 100%;">
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
                                <th>Tiêu đề</th>
                                <th>Mô tả</th>
                                <th>Ảnh / Video</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($popups as $popup)
                            <td>

                            </td>
                            <td>{{ $popup->title }}</td>
                            <td>{{ $popup->description }}</td>
                            <td>
                                @if($popup->media_type === 'image')
                                <img src="{{ asset('storage/' . $popup->media_path) }}" alt="Ảnh popup"
                                    class="rounded border" style="width:100px; height:70px; object-fit:cover;">
                                @elseif($popup->media_type === 'video')
                                <video autoplay muted controls class="rounded border" style="width:100px; height:70px; object-fit:cover;">
                                    <source src="{{ asset('storage/' . $popup->media_path) }}" type="video/mp4">
                                </video>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $popup->status ? 'success' : 'secondary' }}">
                                    {{ $popup->status ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('popups.edit', $popup->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('popups.destroy', $popup->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                                <td colspan="5" class="text-center text-muted">Không có Banner nào nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($popups->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $popups->firstItem() }} đến {{ $popups->lastItem() }} trong tổng số {{ $popups->total() }} danh mục
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $popups->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $popups->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $popups->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $popups->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($popups->getUrlRange(
                                max(1, $popups->currentPage() - 2),
                                min($popups->lastPage(), $popups->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $popups->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($popups->lastPage() > $popups->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $popups->url($popups->lastPage()) }}">{{ $popups->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$popups->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $popups->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$popups->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $popups->url($popups->lastPage()) }}">
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