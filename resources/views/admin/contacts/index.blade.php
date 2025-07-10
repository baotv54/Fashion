@extends('layouts.admin')

@section('content')
<!-- contact List Widget -->
<div class="card mb-6">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                        <div>
                            <p class="mb-1">Tổng liên hệ</p>
                            <h4 class="mb-1">{{ $stats['total'] }}</h4>
                        </div>
                        <span class="avatar me-sm-6">
                            <span class="avatar-initial rounded">
                                <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                </svg>
                            </span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-6">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                        <div>
                            <p class="mb-1">Chờ xử lý</p>
                            <h4 class="mb-1">{{ $stats['pending'] }}</h4>
                        </div>
                        <span class="avatar p-2 me-lg-6">
                            <span class="avatar-initial rounded">
                                <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 7v5l3 3" />
                                </svg>
                            </span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                        <div>
                            <p class="mb-1">Đang xử lý</p>
                            <h4 class="mb-1">{{ $stats['processing'] }}</h4>
                        </div>
                        <span class="avatar p-2 me-sm-6">
                            <span class="avatar-initial rounded">
                                <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-loader">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 6l0 -3" />
                                    <path d="M16.25 7.75l2.15 -2.15" />
                                    <path d="M18 12l3 0" />
                                    <path d="M16.25 16.25l2.15 2.15" />
                                    <path d="M12 18l0 3" />
                                    <path d="M7.75 16.25l-2.15 2.15" />
                                    <path d="M6 12l-3 0" />
                                    <path d="M7.75 7.75l-2.15 -2.15" />
                                </svg>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Đã phản hồi</p>
                            <h4 class="mb-1">{{ $stats['replied'] }}</h4>
                        </div>
                        <span class="avatar p-2">
                            <span class="avatar-initial rounded">
                                <svg style="color: black;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M9 12l2 2l4 -4" />
                                </svg>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- contact List Table -->
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-title">Bộ lọc</h5>
        <form method="GET" action="{{ route('contacts.index') }}" class="pt-4">
            <div class="row g-3">
                <!-- Ô tìm kiếm -->
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên, email, SĐT..." value="{{ request('search') }}">
                </div>

                <!-- Trạng thái -->
                <div class="col-md-4">
                    <select name="status" class="form-select text-capitalize">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                    </select>
                </div>

                <!-- Nút lọc -->
                <div class="col-md-4 d-flex align-items-center">
                    <button type="submit" class="btn btn-primary w-100">
                        <i data-feather="search" class="me-1"></i> Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-datatable">
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-contacts table dataTable dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                        <colgroup>
                            <col data-dt-column="0" style="width: 49.775px;">
                            <col data-dt-column="1" style="width: 55.9875px;">
                            <col data-dt-column="2" style="width: 49.775px;">
                            <col data-dt-column="3" style="width: 83.9625px;">
                            <col data-dt-column="4" style="width: 83.9625px;">
                            <col data-dt-column="5" style="width: 166.838px;">
                            <col data-dt-column="6" style="width: 113.675px;">
                            <col data-dt-column="7" style="width: 79.825px;">
                            <col data-dt-column="8" style="width: 129.775px;">
                        </colgroup>
                        <thead class="border-top">
                            <tr>
                                <th></th>
                                <th data-dt-column="1" rowspan="1" colspan="1" class="dt-select dt-orderable-none" aria-label=""><span class="dt-column-title"></span><span class="dt-column-order"></span><input class="form-check-input" type="checkbox" aria-label="Select all rows"></th>
                                <th>STT</th>
                                <th>Thông tin liên hệ</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $index => $contact)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#contactModal{{ $contact->id }}" title="Chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="contactModal{{ $contact->id }}" tabindex="-1" aria-labelledby="contactModalLabel{{ $contact->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="contactModalLabel{{ $contact->id }}">Chi tiết liên hệ: {{ $contact->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <table class="table table-bordered mb-4">
                                                        <tbody>
                                                            <tr>
                                                                <th style="width: 180px;">Họ & Tên</th>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="avatar avatar-sm me-3">
                                                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($contact->name ?? 'K', 0, 1)) }}</span>
                                                                        </div>
                                                                        <div>
                                                                            <strong>{{ $contact->name }}</strong><br>
                                                                            <small class="text-muted">{{ $contact->email }}</small><br>
                                                                            @php
                                                                            $map = [
                                                                            'pending' => ['text' => 'Chờ xử lý', 'color' => 'primary'],
                                                                            'processing' => ['text' => 'Đang xử lý', 'color' => 'info'],
                                                                            'replied' => ['text' => 'Đã phản hồi', 'color' => 'success'],
                                                                            'closed' => ['text' => 'Đã đóng', 'color' => 'warning'],
                                                                            ];
                                                                            $status = $map[$contact->status] ?? ['text' => 'Không xác định', 'color' => 'secondary'];
                                                                            @endphp
                                                                            <span class="badge bg-label-{{ $status['color'] }} text-{{ $status['color'] }}">
                                                                                {{ $status['text'] }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th>SĐT</th>
                                                                <td>{{ $contact->phone }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th>Thời gian</th>
                                                                <td>
                                                                    <small class="text-muted">
                                                                        <p class="mb-1"><strong>Thời gian gửi:</strong> {{ $contact->created_at->format('d/m/Y H:i:s') }}</p>
                                                                        <p class="mb-0"><strong>Lần cập nhật cuối:</strong> {{ $contact->updated_at->format('d/m/Y H:i:s') }}</p>
                                                                    </small>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th>Nội dung tin nhắn</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="border-top-0">
                                                                    <div class="border rounded p-3 bg-light w-100 text-break" style="white-space: pre-wrap; word-break: break-word; min-height: 100px;">
                                                                        {{ $contact->message }}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="row g-4">
                                                        <div class="col-md-3">
                                                            <form method="POST" action="{{ route('contacts.updateStatus', $contact->id) }}">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="status{{ $contact->id }}" class="form-label">Cập nhật trạng thái:</label>
                                                                    <select class="form-select" id="status{{ $contact->id }}" name="status" required>
                                                                        <option value="pending" {{ $contact->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                                                        <option value="processing" {{ $contact->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                                                        <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Đã phản hồi</option>
                                                                        <option value="closed" {{ $contact->status == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary w-100">
                                                                    <i data-feather="refresh-cw" class="me-1"></i> Cập nhật
                                                                </button>
                                                            </form>
                                                        </div>

                                                        <div class="col-md-9">
                                                            <form method="POST" action="{{ route('contacts.reply', $contact->id) }}">
                                                                @csrf
                                                                <div class="form-floating mb-3">
                                                                    <textarea
                                                                        class="form-control @error('admin_reply') is-invalid @enderror"
                                                                        placeholder="Nhập nội dung phản hồi cho khách hàng..."
                                                                        id="admin_reply{{ $contact->id }}"
                                                                        name="admin_reply"
                                                                        style="height: 140px"
                                                                        required>{{ old('admin_reply', $contact->admin_reply ?? '') }}</textarea>
                                                                    <label for="admin_reply{{ $contact->id }}">Nội dung phản hồi <span class="text-danger">*</span></label>
                                                                    @error('admin_reply')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" class="btn btn-success">
                                                                        <i data-feather="send" class="me-1"></i> Gửi phản hồi
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-select"><input aria-label="Select row" class="form-check-input" type="checkbox"></td>
                                <td>{{ $contacts->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex justify-content-start align-items-center contact-name text-nowrap">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr($contact->name ?? 'K', 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="m-0">
                                                <a href="#" class="text-heading">{{ $contact->name }}</a>
                                            </h6>
                                            <small>{{ $contact->email }}</small>
                                            <small>{{ $contact->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                    $map = [
                                    'pending' => ['text' => 'Chờ xử lý', 'color' => 'primary'],
                                    'processing' => ['text' => 'Đang xử lý', 'color' => 'info'],
                                    'replied' => ['text' => 'Đã phản hồi', 'color' => 'success'],
                                    'closed' => ['text' => 'Đã đóng', 'color' => 'warning'],
                                    ];
                                    $status = $map[$contact->status] ?? ['text' => 'Không xác định', 'color' => 'secondary'];
                                    @endphp
                                    <span class="badge px-2 bg-label-{{ $status['color'] }}">
                                        {{ $status['text'] }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ $contact->created_at->format('d/m/Y H:i') }}<br>
                                        <span class="text-muted">{{ $contact->created_at->diffForHumans() }}</span>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
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
            @if ($contacts->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $contacts->firstItem() }} đến {{ $contacts->lastItem() }} trong tổng số {{ $contacts->total() }} sản phẩm
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                {{-- First --}}
                                <li class="dt-paging-button page-item {{ $contacts->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $contacts->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Previous --}}
                                <li class="dt-paging-button page-item {{ $contacts->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $contacts->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Page numbers --}}
                                @foreach ($contacts->getUrlRange(
                                max(1, $contacts->currentPage() - 2),
                                min($contacts->lastPage(), $contacts->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $contacts->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Dấu 3 chấm nếu có --}}
                                @if ($contacts->lastPage() > $contacts->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $contacts->url($contacts->lastPage()) }}">{{ $contacts->lastPage() }}</a>
                                </li>
                                @endif

                                {{-- Next --}}
                                <li class="dt-paging-button page-item {{ !$contacts->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $contacts->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>

                                {{-- Last --}}
                                <li class="dt-paging-button page-item {{ !$contacts->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $contacts->url($contacts->lastPage()) }}">
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