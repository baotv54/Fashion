
@extends('layouts.admin')

@section('content')
<!-- Review Statistics Widget -->
<div class="card mb-6">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                        <div>
                            <p class="mb-1">Tổng đánh giá</p>
                            <h4 class="mb-1">{{ number_format($totalReviews ?? 0) }}</h4>
                            <p class="mb-0">
                                <span class="me-2">Tất cả sản phẩm</span>
                                <span class="badge bg-label-success">+{{ $newReviewsToday ?? 0 }} hôm nay</span>
                            </p>
                        </div>
                        <span class="avatar me-sm-6">
                            <span class="avatar-initial rounded">
                                <i class="icon-base ti tabler-star icon-28px text-heading"></i>
                            </span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-6">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                        <div>
                            <p class="mb-1">Chờ duyệt</p>
                            <h4 class="mb-1">{{ number_format($pendingReviews ?? 0) }}</h4>
                            <p class="mb-0">
                                <span class="me-2">Cần xử lý</span>
                                @if(($pendingReviews ?? 0) > 0)
                                <span class="badge bg-label-warning">Cần duyệt</span>
                                @else
                                <span class="badge bg-label-success">Đã xử lý</span>
                                @endif
                            </p>
                        </div>
                        <span class="avatar p-2 me-lg-6">
                            <span class="avatar-initial rounded">
                                <i class="icon-base ti tabler-clock icon-28px text-heading"></i>
                            </span>
                        </span>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                        <div>
                            <p class="mb-1">Điểm trung bình</p>
                            <h4 class="mb-1">{{ number_format($averageRating ?? 0, 1) }}/5</h4>
                            <p class="mb-0">
                            <div class="d-flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($averageRating ?? 0))
                                    <i class="icon-base ti tabler-star-filled text-warning icon-16px"></i>
                                    @elseif($i - 0.5 <= ($averageRating ?? 0))
                                        <i class="icon-base ti tabler-star-half-filled text-warning icon-16px"></i>
                                        @else
                                        <i class="icon-base ti tabler-star text-muted icon-16px"></i>
                                        @endif
                                @endfor
                            </div>
                            </p>
                        </div>
                        <span class="avatar p-2 me-sm-6">
                            <span class="avatar-initial rounded">
                                <i class="icon-base ti tabler-medal icon-28px text-heading"></i>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">Có media</p>
                            <h4 class="mb-1">{{ number_format($reviewsWithMedia ?? 0) }}</h4>
                            <p class="mb-0">
                                <span class="me-2">Có hình/video</span>
                                <span class="badge bg-label-info">{{ number_format((($reviewsWithMedia ?? 0) / max($totalReviews ?? 1, 1)) * 100, 1) }}%</span>
                            </p>
                        </div>
                        <span class="avatar p-2">
                            <span class="avatar-initial rounded">
                                <i class="icon-base ti tabler-photo icon-28px text-heading"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews List Table -->
<div class="card">
    <div class="card-header border-bottom">
        <h5 class="card-title">Bộ lọc</h5>
        <div class="d-flex justify-content-between align-items-center row pt-4 gap-6 gap-md-0 g-md-6">
            <div class="col-md-3 review_status">
                <select id="ReviewStatus" class="form-select text-capitalize">
                    <option value="">Trạng thái duyệt</option>
                    <option value="approved">Đã duyệt</option>
                    <option value="pending">Chờ duyệt</option>
                    <option value="rejected">Từ chối</option>
                </select>
            </div>
            <div class="col-md-3 review_rating">
                <select id="ReviewRating" class="form-select text-capitalize">
                    <option value="">Điểm đánh giá</option>
                    <option value="5">5 sao</option>
                    <option value="4">4 sao</option>
                    <option value="3">3 sao</option>
                    <option value="2">2 sao</option>
                    <option value="1">1 sao</option>
                </select>
            </div>
            <div class="col-md-3 review_media">
                <select id="ReviewMedia" class="form-select text-capitalize">
                    <option value="">Media</option>
                    <option value="with_media">Có hình/video</option>
                    <option value="no_media">Chỉ văn bản</option>
                </select>
            </div>
            <div class="col-md-3 review_date">
                <input type="date" id="ReviewDate" class="form-control" placeholder="Ngày tạo">
            </div>
        </div>
    </div>
    <div class="card-datatable">
        <div id="DataTables_Table_0_wrapper" class="dt-container dt-bootstrap5 dt-empty-footer">
            <div class="row m-3 my-0 justify-content-between">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-search mb-0 mb-md-6">
                        <input type="search" class="form-control ms-0" id="dt-search-0" placeholder="Tìm đánh giá theo tên sản phẩm, khách hàng..." aria-controls="DataTables_Table_0">
                        <label for="dt-search-0"></label>
                    </div>
                </div>
                <!-- <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-md-0 mb-4">
                        <button class="btn btn-primary" onclick="bulkApproveReviews()">
                            <i class="icon-base ti tabler-check me-1 icon-16px"></i>
                            <span class="d-none d-sm-inline-block">Duyệt hàng loạt</span>
                        </button>
                    </div>
                </div> -->
            </div>
            <div class="justify-content-between dt-layout-table">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-full table-responsive">
                    <table class="datatables-reviews table dataTable dtr-column collapsed" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                        <thead class="border-top">
                            <tr>
                                <th></th>
                                <th class="dt-select dt-orderable-none">
                                    <input class="form-check-input" type="checkbox" aria-label="Select all rows" id="selectAll">
                                </th>
                                <th>Sản phẩm</th>
                                <th>Khách hàng</th>
                                <th>Đánh giá</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $review->id }}" title="Chi tiết">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </button>

                                    <!-- Review Detail Modal -->
                                    <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $review->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết đánh giá #{{ $review->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>Thông tin sản phẩm</h6>
                                                            <div class="d-flex align-items-center mb-3">
                                                                <img src="{{ asset($review->product->image) }}" alt="" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                                <div>
                                                                    <strong>{{ $review->product->name }}</strong>
                                                                    <br>
                                                                    <small class="text-muted">{{ $review->product->category->name }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>Thông tin khách hàng</h6>
                                                            <div class="d-flex align-items-center mb-3">
                                                                <div class="avatar avatar-sm me-3">
                                                                    <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($review->user->name, 0, 1) }}</span>
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $review->user->name }}</strong>
                                                                    <br>
                                                                    <small class="text-muted">{{ $review->user->email }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="mb-3">
                                                        <h6>Đánh giá</h6>
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="me-3">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    @if($i <= $review->rating)
                                                                    <i class="icon-base ti tabler-star-filled text-warning"></i>
                                                                    @else
                                                                    <i class="icon-base ti tabler-star text-muted"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <span class="badge bg-primary">{{ $review->rating }}/5</span>
                                                        </div>
                                                        @if($review->comment)
                                                        <div class="alert alert-light">
                                                            <strong>Nhận xét:</strong><br>
                                                            {{ $review->comment }}
                                                        </div>
                                                        @endif
                                                    </div>

                                                    @if($review->media->count() > 0)
                                                    <div class="mb-3">
                                                        <h6>Media đính kèm</h6>
                                                        <div class="row">
                                                            @foreach($review->media as $media)
                                                            <div class="col-md-4 col-sm-6 mb-3">
                                                                @if($media->type == 'image')
                                                                <img src="{{ Storage::url($media->file_path) }}" alt="Review media" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                                                @else
                                                                <video controls class="w-100 rounded" style="max-height: 150px;">
                                                                    <source src="{{ Storage::url($media->file_path) }}" type="{{ $media->mime_type }}">
                                                                    Trình duyệt không hỗ trợ video.
                                                                </video>
                                                                @endif
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="mb-3">
                                                        <h6>Trạng thái hiển thị</h6>
                                                        <div class="alert {{ $review->is_approved ? 'alert-success' : 'alert-warning' }} d-flex align-items-center">
                                                            <i class="icon-base ti {{ $review->is_approved ? 'tabler-eye' : 'tabler-eye-off' }} me-2"></i>
                                                            <span>
                                                                {{ $review->is_approved ? 'Đánh giá đang được hiển thị công khai' : 'Đánh giá đang bị ẩn khỏi khách hàng' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">
                                                                <i class="icon-base ti tabler-clock me-1"></i>
                                                                Tạo: {{ $review->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                        </div>
                                                        <div class="col-md-6 text-end">
                                                            @if($review->is_approved)
                                                            <span class="badge bg-success">
                                                                <i class="icon-base ti tabler-eye me-1"></i>Hiển thị
                                                            </span>
                                                            @else
                                                            <span class="badge bg-warning">
                                                                <i class="icon-base ti tabler-eye-off me-1"></i>Ẩn
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    @if($review->is_approved)
                                                    <button type="button" class="btn btn-warning" onclick="hideReview({{ $review->id }})">
                                                        <i class="icon-base ti tabler-eye-off me-1"></i>Ẩn đánh giá
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-success" onclick="showReview({{ $review->id }})">
                                                        <i class="icon-base ti tabler-eye me-1"></i>Hiển thị đánh giá
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-outline-danger" onclick="deleteReview({{ $review->id }})">
                                                        <i class="icon-base ti tabler-trash me-1"></i>Xóa
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="dt-select">
                                    <input aria-label="Select row" class="form-check-input row-checkbox" type="checkbox" value="{{ $review->id }}">
                                </td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar me-2 me-sm-4 rounded-2 bg-label-secondary">
                                                <img src="{{ asset($review->product->image) }}" alt="{{ $review->product->name }}" class="rounded">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="text-nowrap mb-0">{{ Str::limit($review->product->name, 30) }}</h6>
                                            <small class="text-truncate d-none d-sm-block text-muted">{{ $review->product->category->name }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($review->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0">{{ Str::limit($review->user->name, 20) }}</h6>
                                            <small class="text-muted">{{ Str::limit($review->user->email, 25) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                <i class="icon-base ti tabler-star-filled text-warning icon-sm"></i>
                                                @else
                                                <i class="icon-base ti tabler-star text-muted icon-sm"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-2">{{ $review->rating }}/5</span>
                                        </div>
                                        @if($review->comment)
                                        <small class="text-muted">{{ Str::limit($review->comment, 50) }}</small>
                                        @endif
                                        @if($review->media->count() > 0)
                                        <small class="text-info">
                                            <i class="icon-base ti tabler-photo me-1"></i>{{ $review->media->count() }} media
                                        </small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($review->is_approved)
                                    <span class="badge bg-success">
                                        <i class="icon-base ti tabler-eye me-1"></i>Hiển thị
                                    </span>
                                    @else
                                    <span class="badge bg-warning">
                                        <i class="icon-base ti tabler-eye-off me-1"></i>Ẩn
                                    </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="text-muted">{{ $review->created_at->format('d/m/Y') }}</span>
                                    <br>
                                    <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger" onclick="deleteReview({{ $review->id }})" title="Xóa">
                                            <i class="icon-base ti tabler-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="icon-base ti tabler-star icon-48px text-muted mb-3"></i>
                                        <h6 class="text-muted">Chưa có đánh giá nào</h6>
                                        <small class="text-muted">Các đánh giá từ khách hàng sẽ hiển thị ở đây</small>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if (isset($reviews) && $reviews->hasPages())
            <div class="row mx-3 justify-content-between mt-4">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <div class="dt-info">
                        Hiển thị {{ $reviews->firstItem() }} đến {{ $reviews->lastItem() }} trong tổng số {{ $reviews->total() }} đánh giá
                    </div>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto gap-md-2 gap-0 mt-0">
                    <div class="dt-paging">
                        <nav aria-label="pagination">
                            <ul class="pagination">
                                <li class="dt-paging-button page-item {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link first" href="{{ $reviews->url(1) }}">
                                        <i class="icon-base ti tabler-chevrons-left icon-18px"></i>
                                    </a>
                                </li>
                                <li class="dt-paging-button page-item {{ $reviews->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link previous" href="{{ $reviews->previousPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-left icon-18px"></i>
                                    </a>
                                </li>
                                @foreach ($reviews->getUrlRange(
                                max(1, $reviews->currentPage() - 2),
                                min($reviews->lastPage(), $reviews->currentPage() + 2)
                                ) as $page => $url)
                                <li class="dt-paging-button page-item {{ $reviews->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach
                                @if ($reviews->lastPage() > $reviews->currentPage() + 2)
                                <li class="dt-paging-button page-item disabled">
                                    <span class="page-link ellipsis">…</span>
                                </li>
                                <li class="dt-paging-button page-item">
                                    <a class="page-link" href="{{ $reviews->url($reviews->lastPage()) }}">{{ $reviews->lastPage() }}</a>
                                </li>
                                @endif
                                <li class="dt-paging-button page-item {{ !$reviews->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link next" href="{{ $reviews->nextPageUrl() }}">
                                        <i class="icon-base ti tabler-chevron-right icon-18px"></i>
                                    </a>
                                </li>
                                <li class="dt-paging-button page-item {{ !$reviews->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link last" href="{{ $reviews->url($reviews->lastPage()) }}">
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
        // Select all functionality
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allChecked = Array.from(rowCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            });
        });
    });

    // Show review (set is_approved = true)
    function showReview(reviewId) {
        if (confirm('Bạn có chắc muốn hiển thị đánh giá này cho khách hàng?')) {
            fetch(`/admin/reviews/${reviewId}/hide`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Lỗi HTTP! Trạng thái: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showAlert('danger', 'Có lỗi xảy ra: ' + error.message);
            });
        }
    }

    // Hide review (set is_approved = false)
    function hideReview(reviewId) {
        if (confirm('Bạn có chắc muốn ẩn đánh giá này khỏi khách hàng?')) {
            fetch(`/admin/reviews/${reviewId}/hide`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Lỗi HTTP! Trạng thái: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showAlert('danger', 'Có lỗi xảy ra: ' + error.message);
            });
        }
    }

    // Delete single review
    function deleteReview(reviewId) {
        if (confirm('Bạn có chắc muốn xóa đánh giá này? Hành động này không thể hoàn tác!')) {
            fetch(`/admin/reviews/${reviewId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Lỗi HTTP! Trạng thái: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showAlert('danger', 'Có lỗi xảy ra: ' + error.message);
            });
        }
    }

    // Bulk approve reviews
    function bulkApproveReviews() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length === 0) {
            showAlert('warning', 'Vui lòng chọn ít nhất một đánh giá!');
            return;
        }

        const reviewIds = Array.from(checkedBoxes).map(checkbox => checkbox.value);

        if (confirm(`Bạn có chắc muốn hiển thị ${reviewIds.length} đánh giá đã chọn?`)) {
            fetch('/admin/reviews/bulk-approve', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    review_ids: reviewIds
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Lỗi HTTP! Trạng thái: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert('danger', data.message);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showAlert('danger', 'Có lỗi xảy ra: ' + error.message);
            });
        }
    }

    // Show alert function
    function showAlert(type, message) {
        const existingAlerts = document.querySelectorAll('.alert-notification');
        existingAlerts.forEach(alert => alert.remove());

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-notification`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.style.minWidth = '300px';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('ReviewStatus');
        const ratingFilter = document.getElementById('ReviewRating');
        const mediaFilter = document.getElementById('ReviewMedia');
        const dateFilter = document.getElementById('ReviewDate');
        const searchInput = document.getElementById('dt-search-0');

        [statusFilter, ratingFilter, mediaFilter, dateFilter, searchInput].forEach(element => {
            if (element) {
                element.addEventListener('change', applyFilters);
                if (element === searchInput) {
                    element.addEventListener('input', debounce(applyFilters, 300));
                }
            }
        });

        function applyFilters() {
            const params = new URLSearchParams();
            if (statusFilter.value) params.append('status', statusFilter.value);
            if (ratingFilter.value) params.append('rating', ratingFilter.value);
            if (mediaFilter.value) params.append('media', mediaFilter.value);
            if (dateFilter.value) params.append('date', dateFilter.value);
            if (searchInput.value) params.append('search', searchInput.value);

            const url = new URL(window.location.href);
            url.search = params.toString();
            window.location.href = url.toString();
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    });
</script>
@endpush
@endsection