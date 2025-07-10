@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-datatable">
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6"><input type="search" class="form-control ms-0" id="dt-search-0" placeholder="Search coupon" aria-controls="DataTables_Table_0"><label for="dt-search-0"></label></div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-4">
                        <a href="{{ route('coupons.create') }}" class="btn add-new btn-primary">
                            <i class="icon-base ti tabler-plus me-1 icon-16px"></i>
                            <span class="d-none d-sm-inline-block">Thêm mã giảm giá</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-coupons table dataTable dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
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
                                <th>Mã</th>
                                <th>Loại</th>
                                <th>Giá trị</th>
                                <th>Ngày bắt đầu/kết thúc</th>
                                <th>Lượt sử dụng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#couponModal{{ $coupon->id }}" title="Chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="couponModal{{ $coupon->id }}" tabindex="-1" aria-labelledby="couponModalLabel{{ $coupon->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết: {{ $coupon->code }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Mã</th>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ asset($coupon->image) }}" alt="" class="rounded me-3" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    <div>
                                                                        <strong>{{ $coupon->code }}</strong>
                                                                        <br>
                                                                        <small>{{ Str::limit($coupon->description, 50) }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Loại</th>
                                                            <td> <span class="badge bg-{{ $coupon->type === 'percent' ? 'info' : 'secondary' }} text-white">
                                                                    {{ $coupon->type === 'percent' ? 'Phần trăm' : 'Số tiền cố định' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Giá trị</th>
                                                            <td>
                                                                {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value) . 'đ' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Đơn hàng tối thiểu</th>
                                                            <td>{{ number_format($coupon->min_cart_value) }}₫</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ngày bắt đầu/kết thúc</th>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <small>{{ $coupon->start_date ? $coupon->start_date->format('d/m/Y') : 'Không có' }}</small>
                                                                        <br>
                                                                        <strong>{{ $coupon->end_date ? $coupon->end_date->format('d/m/Y') : 'Không có' }}</strong>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hành động</th>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                            <path d="M16 5l3 3" />
                                                                        </svg>
                                                                    </a>

                                                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center coupon-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary"><img src="{{ asset($coupon->image) }}" alt="{{ $coupon->name }}" class="rounded"></div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">{{ $coupon->code }}</h6>
                                            <small class="text-truncate d-none d-sm-block">{!! Str::limit(strip_tags($coupon->description ), 50) !!}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $coupon->type === 'percent' ? 'info' : 'secondary' }} text-white">
                                        {{ $coupon->type === 'percent' ? 'Phần trăm' : 'Số tiền cố định' }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value) . '₫' }}</td>
                                <td class="text-center">
                                    <div class="d-flex flex-column">
                                        <small class="text-nowrap mb-0">{{ $coupon->start_date ? $coupon->start_date->format('d/m/Y') : 'Không có' }}</small>
                                        <h6 class="text-truncate d-none d-sm-block">{{ $coupon->end_date ? $coupon->end_date->format('d/m/Y') : 'Không có' }}</h6>
                                    </div>
                                </td>
                                <td>{{ $coupon->used }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-icon btn-outline-warning" title="Sửa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
            @if ($coupons->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $coupons->firstItem() }} đến {{ $coupons->lastItem() }} trong tổng số {{ $coupons->total() }} sản phẩm
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $coupons->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $coupons->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $coupons->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $coupons->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($coupons->getUrlRange(
                                max(1, $coupons->currentPage() - 2),
                                min($coupons->lastPage(), $coupons->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $coupons->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($coupons->lastPage() > $coupons->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $coupons->url($coupons->lastPage()) }}">{{ $coupons->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$coupons->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $coupons->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$coupons->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $coupons->url($coupons->lastPage()) }}">
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