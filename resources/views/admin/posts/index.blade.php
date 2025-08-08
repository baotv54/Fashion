@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-datatable">
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6"><input type="search" class="form-control ms-0" id="dt-search-0" placeholder="Search post" aria-controls="DataTables_Table_0"><label for="dt-search-0"></label></div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-4">
                        <a href="{{ route('posts.create') }}" class="btn add-new btn-primary">
                            <i class="icon-base ti tabler-plus me-1 icon-16px"></i>
                            <span class="d-none d-sm-inline-block">Thêm sản phẩm</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-posts table dataTable dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
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
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Tác giả</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#postModal{{ $post->id }}" title="Chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1" aria-labelledby="postModalLabel{{ $post->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content modal-body px-4 py-3">
                                                <div class="modal-body px-4 py-3">
                                                    <div class="mb-4 text-center">
                                                        @if ($post->image)
                                                        <img src="{{ asset($post->image) }}" alt="Ảnh bài viết" class="img-fluid rounded shadow-sm" style="max-height: 250px; object-fit: cover;">
                                                        @endif
                                                    </div>

                                                    <h5 class="fw-bold text-center mb-3">{{ $post->title }}</h5>

                                                    <div class="text-muted mb-2 text-center">
                                                        <small>
                                                            <i class="fas fa-user-edit"></i> {{ $post->author }} |
                                                            <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                                                        </small>
                                                    </div>

                                                    <p class="mb-2"><strong>Danh mục:</strong> {{ $post->postCategory ? $post->postCategory->name : '-' }}</p>

                                                    <hr>

                                                    <div class="main-article-content" style="text-align: left;">
                                                        {!! $post->content !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center post-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="{{ asset($post->image) }}" alt="{{ $post->name }}" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">{{ Str::limit($post->title, 40) }}</h6>
                                            <small class="text-truncate d-none d-sm-block">{!! Str::limit(strip_tags($post->content), 100) !!}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $post->postCategory ? $post->postCategory->name : '-' }}
                                </td>
                                <td class="text-center">{{ $post->author}}</td>
                                <td class="text-center">
                                    <span class="badge {{ $post->is_visible ? 'bg-label-success' : 'bg-label-danger' }}">
                                        {{ $post->is_visible ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
            @if ($posts->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $posts->firstItem() }} đến {{ $posts->lastItem() }} trong tổng số {{ $posts->total() }} sản phẩm
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $posts->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $posts->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $posts->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($posts->getUrlRange(
                                max(1, $posts->currentPage() - 2),
                                min($posts->lastPage(), $posts->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $posts->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($posts->lastPage() > $posts->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $posts->url($posts->lastPage()) }}">{{ $posts->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$posts->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $posts->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$posts->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $posts->url($posts->lastPage()) }}">
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
