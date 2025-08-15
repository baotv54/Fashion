<div class="max-w-8xl mx-auto p-7">
    <!-- Thống kê đánh giá -->
    <div class="">
        <div class="section-title-all">
            <h2>Đánh giá sản phẩm</h2>
        </div>
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-500" id="avgRating">{{ $avgRating ? number_format($avgRating, 1) : '0.0' }}</div>
                    <div class="star-rating justify-center" id="avgStars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star star {{ $i <= floor($avgRating) ? 'active' : '' }}"></i>
                        @endfor
                    </div>
                    <div class="text-sm text-gray-500 mt-1">
                        <span id="totalReviews">{{ $totalReviews }}</span> đánh giá
                    </div>
                </div>
            </div>

            <div class="flex-1 mx-8">
                <div class="space-y-2">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="flex items-center">
                            <span class="w-8 text-sm">{{ $i }}★</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                <div class="bg-yellow-400 h-2 rounded-full"
                                    style="width: {{ $ratingStats[$i]['percentage'] ?? 0 }}%"></div>
                            </div>
                            <span class="w-8 text-sm text-gray-500">{{ $ratingStats[$i]['count'] ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>

             <div>
        @if($canReview)
            <button id="writeReviewBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-edit mr-2"></i>Viết đánh giá
            </button>
        @elseif(Auth::check() && $userReview)
            <span class="text-sm text-gray-500">Bạn đã đánh giá sản phẩm này.</span>
        @elseif(Auth::check())
            <span class="text-sm text-gray-500">Bạn cần mua và nhận hàng để đánh giá.</span>
        @else
            <button id="writeReviewBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors" disabled>
                <i class="fas fa-edit mr-2"></i>Đăng nhập để đánh giá
            </button>
        @endif
    </div>
        </div>

        <!-- Bộ lọc và sắp xếp -->
        <div class="flex items-center justify-between border-t pt-4">
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium">Sắp xếp:</span>
                <select id="reviewSort" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                    <option value="latest">Mới nhất</option>
                    <option value="oldest">Cũ nhất</option>
                    <option value="rating_high">Đánh giá cao</option>
                    <option value="rating_low">Đánh giá thấp</option>
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Lọc theo:</span>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn active" data-rating="all">
                    Tất cả
                </button>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="5">
                    5★
                </button>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="4">
                    4★
                </button>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="3">
                    3★
                </button>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="2">
                    2★
                </button>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="1">
                    1★
                </button>
                <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="media">
                    <i class="fas fa-image mr-1"></i>Có hình ảnh
                </button>
            </div>
        </div>
    </div>

    <!-- Danh sách đánh giá -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6">
            <div id="reviewsList">
                <!-- Review items sẽ được load bằng AJAX -->
            </div>

            <!-- Load more button -->
            <div class="text-center mt-6">
                <button id="loadMoreBtn" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-spinner fa-spin mr-2 hidden" id="loadingIcon"></i>
                    Xem thêm đánh giá
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal viết/sửa đánh giá -->
<div id="reviewModal" class="modal">
    <div class="modal-content">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Đánh giá sản phẩm</h3>
                <button class="text-gray-400 hover:text-gray-600" id="closeModal">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <form id="reviewForm" enctype="multipart/form-data" class="p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Đánh giá của bạn <span class="text-red-500">*</span>
                </label>
                <div class="star-rating mb-2" id="ratingStars">
                    <i class="fas fa-star star" data-rating="1"></i>
                    <i class="fas fa-star star" data-rating="2"></i>
                    <i class="fas fa-star star" data-rating="3"></i>
                    <i class="fas fa-star star" data-rating="4"></i>
                    <i class="fas fa-star star" data-rating="5"></i>
                </div>
                <p class="text-sm text-gray-500" id="ratingText">Chọn số sao để đánh giá</p>
                <input type="hidden" name="rating" id="ratingValue" required>
            </div>

            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Nhận xét của bạn
                </label>
                <textarea
                    id="comment"
                    name="comment"
                    rows="4"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."
                    maxlength="1000"></textarea>
                <div class="flex justify-between text-xs text-gray-500 mt-1">
                    <span>Tối đa 1000 ký tự</span>
                    <span id="commentCounter">0/1000</span>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Hình ảnh/Video (tùy chọn)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                    <input type="file" id="mediaFiles" name="media[]" multiple accept="image/*,video/*" class="hidden">
                    <label for="mediaFiles" class="cursor-pointer">
                        <div class="text-gray-400 mb-2">
                            <i class="fas fa-cloud-upload-alt text-3xl"></i>
                        </div>
                        <p class="text-sm text-gray-600 mb-1">
                            Chọn hoặc kéo thả hình ảnh/video vào đây
                        </p>
                        <p class="text-xs text-gray-500">
                            Hỗ trợ: JPG, PNG, WebP, MP4 (tối đa 10MB mỗi file)
                        </p>
                    </label>
                </div>

                <!-- Preview media -->
                <div id="mediaPreview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">File đã chọn:</p>
                    <div id="mediaContainer" class="flex flex-wrap gap-2"></div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t">
                <button type="button" id="cancelBtn" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    Hủy
                </button>
                <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-spinner fa-spin mr-2 hidden" id="submitLoading"></i>
                    Gửi đánh giá
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal xem ảnh/video lớn -->
<div id="mediaModal" class="modal">
    <div class="modal-content max-w-4xl">
        <div class="p-4 text-right">
            <button class="text-white hover:text-gray-300" id="closeMediaModal">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div id="mediaViewer" class="p-4 text-center"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Khởi tạo biến
        let currentRating = 0;
        let currentPage = 1;
        let isLoading = false;
        let selectedFiles = [];
        let existingMedia = []; // Mảng cho media từ server: [{id, type, url}]
        let currentFilter = 'all'; // Lọc: 'all', '5', '4', '3', '2', '1', 'media'
        let productId = {{ $product->id }};

        // Debug productId
        console.log('Product ID:', productId);

        // Thiết lập CSRF token cho AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Xử lý đánh giá sao
        $('#ratingStars .star').on('click', function() {
            currentRating = $(this).data('rating');
            $('#ratingValue').val(currentRating);
            updateStars();
            updateRatingText();
        });

        // Cập nhật giao diện sao
        function updateStars() {
            $('#ratingStars .star').each(function(index) {
                $(this).toggleClass('active', index < currentRating);
            });
        }

        // Cập nhật văn bản đánh giá
        function updateRatingText() {
            const texts = {
                1: 'Rất không hài lòng',
                2: 'Không hài lòng',
                3: 'Bình thường',
                4: 'Hài lòng',
                5: 'Rất hài lòng'
            };
            $('#ratingText').text(texts[currentRating] || 'Chọn số sao để đánh giá');
        }

        // Đếm ký tự comment
        $('#comment').on('input', function() {
            const length = $(this).val().length;
            $('#commentCounter').text(`${length}/1000`);
        });

        // Xử lý upload file
        $('#mediaFiles').on('change', function() {
            const files = Array.from(this.files);
            files.forEach(file => {
                if (file.size > 10 * 1024 * 1024) {
                    showNotification(`File ${file.name} quá lớn. Vui lòng chọn file nhỏ hơn 10MB.`, 'error');
                    return;
                }
                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    selectedFiles.push(file);
                } else {
                    showNotification(`File ${file.name} không được hỗ trợ.`, 'error');
                }
            });
            updateMediaPreview();
        });

        // Cập nhật preview media
        function updateMediaPreview() {
            const container = $('#mediaContainer');
            container.empty();

            let hasMedia = selectedFiles.length > 0 || existingMedia.length > 0;

            if (hasMedia) {
                $('#mediaPreview').removeClass('hidden');

                // Hiển thị existing media từ server
                existingMedia.forEach((media, index) => {
                    const preview = $('<div class="media-preview relative w-16 h-16"></div>');
                    const removeBtn = $('<span class="remove-media absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer" data-type="existing" data-index="' + index + '" data-media-id="' + media.id + '">&times;</span>');

                    if (media.type === 'image') {
                        const img = $('<img class="w-full h-full object-cover rounded">').attr('src', media.url);
                        preview.append(img);
                    } else if (media.type === 'video') {
                        const video = $('<video class="w-full h-full object-cover rounded" controls></video>').attr('src', media.url);
                        preview.append(video);
                    }

                    preview.append(removeBtn);
                    container.append(preview);
                });

                // Hiển thị selected files mới
                selectedFiles.forEach((file, index) => {
                    const preview = $('<div class="media-preview relative w-16 h-16"></div>');
                    const removeBtn = $('<span class="remove-media absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer" data-type="new" data-index="' + index + '">&times;</span>');

                    if (file.type.startsWith('image/')) {
                        const img = $('<img class="w-full h-full object-cover rounded">');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                        preview.append(img);
                    } else if (file.type.startsWith('video/')) {
                        const video = $('<video class="w-full h-full object-cover rounded" controls></video>');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            video.attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                        preview.append(video);
                    }

                    preview.append(removeBtn);
                    container.append(preview);
                });
            } else {
                $('#mediaPreview').addClass('hidden');
            }
        }

        // Xóa media preview
        $(document).on('click', '.remove-media', function() {
            const type = $(this).data('type');
            const index = $(this).data('index');

            if (type === 'existing') {
                // Lưu ID để remove ở backend
                const mediaId = $(this).data('media-id');
                // Thêm hidden input cho remove_media[] nếu chưa có
                if (!$('#reviewForm input[name="remove_media[]"][value="' + mediaId + '"]').length) {
                    $('#reviewForm').append('<input type="hidden" name="remove_media[]" value="' + mediaId + '">');
                }
                existingMedia.splice(index, 1);
            } else {
                selectedFiles.splice(index, 1);
            }

            updateMediaPreview();
        });

        // Mở modal đánh giá
        $('#writeReviewBtn').on('click', function() {
            if (!{{ Auth::check() ? 'true' : 'false' }}) {
                showNotification('Vui lòng đăng nhập để viết đánh giá.', 'error');
                return;
            }
            $('#reviewModal').show();
            resetReviewForm();
        });

        // Đóng modal
        $('#closeModal, #cancelBtn').on('click', function() {
            $('#reviewModal').hide();
        });

        // Đóng modal khi click outside
        $('#reviewModal').on('click', function(e) {
            if (e.target === this) {
                $(this).hide();
            }
        });

        // Reset form đánh giá
        function resetReviewForm() {
            currentRating = 0;
            selectedFiles = [];
            existingMedia = []; // Reset existing media
            $('#ratingValue').val('');
            $('#comment').val('');
            $('#commentCounter').text('0/1000');
            $('#ratingStars .star').removeClass('active');
            $('#ratingText').text('Chọn số sao để đánh giá');
            $('#mediaPreview').addClass('hidden');
            $('#mediaContainer').empty();
            $('#mediaFiles').val('');
            $('#reviewForm').removeAttr('data-review-id data-action');
            // Xóa các hidden input remove_media nếu có
            $('#reviewForm input[name="remove_media[]"]').remove();
        }

        // Gửi hoặc chỉnh sửa đánh giá
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();

            if (currentRating === 0) {
                showNotification('Vui lòng chọn số sao đánh giá', 'error');
                return;
            }

            const reviewId = $(this).attr('data-review-id');
            const isEdit = $(this).attr('data-action') === 'update' && reviewId;

            const formData = new FormData();
            formData.append('rating', currentRating);
            formData.append('comment', $('#comment').val());
            if (isEdit) {
                formData.append('_method', 'PUT');
            }

            selectedFiles.forEach((file, index) => {
                formData.append('media[]', file);
            });

            // Các remove_media[] đã được thêm qua hidden inputs

            $('#submitLoading').removeClass('hidden');
            $('#submitBtn').prop('disabled', true);

            const url = isEdit ? `/reviews/${reviewId}` : `/products/${productId}/reviews`;

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#reviewModal').hide();
                        showNotification(response.message, 'success');
                        loadReviews();
                        resetReviewForm();
                    } else {
                        showNotification(response.message || 'Không thể gửi đánh giá', 'error');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    let message = 'Có lỗi xảy ra';
                    if (xhr.status === 422 && response.errors) {
                        message = Object.values(response.errors).flat().join('<br>');
                    } else if (response?.message) {
                        message = response.message;
                    }
                    showNotification(message, 'error');
                },
                complete: function() {
                    $('#submitLoading').addClass('hidden');
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });

        // Load danh sách đánh giá
        function loadReviews(page = 1, append = false) {
            if (isLoading) return;

            isLoading = true;
            const sort = $('#reviewSort').val() || 'latest';

            if (!append) {
                $('#loadingIcon').removeClass('hidden');
                $('#reviewsList').empty();
            }

            console.log('Loading reviews:', {
                url: `/products/${productId}/reviews`,
                page: page,
                sort: sort,
                filter: currentFilter,
                per_page: 5
            });

            $.ajax({
                url: `/products/${productId}/reviews`,
                method: 'GET',
                data: {
                    page: page,
                    sort: sort,
                    filter: currentFilter,
                    per_page: 5
                },
                success: function(response) {
                    console.log('Reviews response:', response);
                    if (response.success && response.data && Array.isArray(response.data.reviews)) {
                        const reviews = response.data.reviews;
                        const pagination = response.data.pagination;

                        if (!append) {
                            $('#reviewsList').empty();
                            currentPage = 1;
                        }

                        if (reviews.length === 0) {
                            $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Chưa có đánh giá nào.</p>');
                        } else {
                            reviews.forEach(review => {
                                $('#reviewsList').append(renderReviewItem(review));
                            });
                        }

                        if (pagination.has_more) {
                            $('#loadMoreBtn').show();
                        } else {
                            $('#loadMoreBtn').hide();
                        }
                    } else {
                        showNotification('Không có đánh giá để hiển thị', 'info');
                        $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Chưa có đánh giá nào.</p>');
                    }
                },
                error: function(xhr) {
                    console.error('Error loading reviews:', xhr.status, xhr.responseText);
                    showNotification(`Không thể tải đánh giá: ${xhr.status} ${xhr.responseText}`, 'error');
                    $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Lỗi khi tải đánh giá.</p>');
                },
                complete: function() {
                    isLoading = false;
                    $('#loadingIcon').addClass('hidden');
                }
            });
        }

        // Render một item đánh giá
        function renderReviewItem(review) {
            console.log('Rendering review:', review);
            const stars = Array.from({ length: 5 }, (_, i) =>
                `<i class="fas fa-star ${i < review.rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`
            ).join('');

            let mediaHtml = '';
            if (review.media && Array.isArray(review.media) && review.media.length > 0) {
                const mediaItems = review.media.map(media => {
                    if (media.type === 'image') {
                        return `<img src="${media.url}" alt="Media"
                                   class="w-16 h-16 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                   onclick="openMediaViewer('${media.url}', 'image')">`;
                    } else if (media.type === 'video') {
                        return `<video src="${media.url}"
                                   class="w-16 h-16 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity"
                                   onclick="openMediaViewer('${media.url}', 'video')"></video>`;
                    }
                    return '';
                }).filter(Boolean).join('');
                mediaHtml = `<div class="flex flex-wrap gap-2 mt-3">${mediaItems}</div>`;
            }
            // ...existing code...

            return `
                <div class="review-item border-b py-4">
                    <div class="flex items-start space-x-3">
                        <img src="${review.user.avatar || '/images/default-avatar.jpg'}" alt="${review.user.name || 'User'}" 
                             class="w-10 h-10 rounded-full object-cover">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-medium text-gray-900">${review.user.name || 'Ẩn danh'}</h4>
                                <span class="text-sm text-gray-500">${new Date(review.created_at).toLocaleString('vi-VN')}</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="flex space-x-1 mr-2">${stars}</div>
                                ${review.is_approved ? '' : '<span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Đang chờ duyệt</span>'}
                            </div>
                            ${review.comment ? `<p class="text-gray-700 mb-2">${review.comment}</p>` : ''}
                            ${mediaHtml}
                            ${review.user_id === {{ Auth::id() ?? 0 }} ? `
                                <div class="flex space-x-2 mt-2">
                                    <button class="text-blue-600 hover:underline" onclick="editReview(${review.id})">Chỉnh sửa</button>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
        }

        // Load thêm đánh giá
        $('#loadMoreBtn').on('click', function() {
            currentPage++;
            loadReviews(currentPage, true);
        });

        // Sắp xếp đánh giá
        $('#reviewSort').on('change', function() {
            currentPage = 1;
            loadReviews();
        });

        // Lọc đánh giá
        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('active bg-blue-100 text-blue-700');
            $(this).addClass('active bg-blue-100 text-blue-700');
            currentFilter = $(this).data('rating') || 'all';
            currentPage = 1;
            loadReviews();
        });

        // Mở viewer cho media
        window.openMediaViewer = function(url, type) {
            const viewer = $('#mediaViewer');
            viewer.empty();

            if (type === 'image') {
                viewer.append(`<img src="${url}" class="max-w-full max-h-[80vh] object-contain">`);
            } else if (type === 'video') {
                viewer.append(`<video src="${url}" controls class="max-w-full max-h-[80vh]"></video>`);
            }

            $('#mediaModal').show();
        };

        // Đóng media modal
        $('#closeMediaModal').on('click', function() {
            $('#mediaModal').hide();
        });

        $('#mediaModal').on('click', function(e) {
            if (e.target === this) {
                $(this).hide();
            }
        });

        // Hiển thị thông báo
        function showNotification(message, type = 'info') {
            const colors = {
                success: 'bg-green-100 border-green-400 text-green-700',
                error: 'bg-red-100 border-red-400 text-red-700',
                info: 'bg-blue-100 border-blue-400 text-blue-700'
            };

            const notification = $(`
                <div class="fixed top-4 right-4 z-50 p-4 border-l-4 rounded shadow-lg ${colors[type]} notification" style="min-width: 300px;">
                    <div class="flex justify-between items-center">
                        <span>${message}</span>
                        <button class="ml-4 text-current hover:opacity-70" onclick="$(this).parent().parent().remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `);

            $('body').append(notification);
            setTimeout(() => {
                notification.fadeOut(() => notification.remove());
            }, 5000);
        }

        // Xử lý xóa đánh giá
        window.deleteReview = function(reviewId) {
            if (!confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) {
                return;
            }

            $.ajax({
                url: `/reviews/${reviewId}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        loadReviews();
                    } else {
                        showNotification(response.message || 'Không thể xóa đánh giá', 'error');
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    showNotification(response?.message || 'Có lỗi xảy ra', 'error');
                }
            });
        };

        // Xử lý chỉnh sửa đánh giá
        window.editReview = function(reviewId) {
            $.ajax({
                url: `/reviews/${reviewId}/edit`,
                method: 'GET',
                success: function(review) {
                    currentRating = review.rating || 0;
                    $('#ratingValue').val(review.rating || '');
                    $('#comment').val(review.comment || '');
                    $('#commentCounter').text(`${(review.comment || '').length}/1000`);
                    updateStars();
                    updateRatingText();

                    selectedFiles = [];  // Reset file mới
                    existingMedia = review.media || [];  // Load media từ server
                    updateMediaPreview();  // Gọi để hiển thị cả existing và selected

                    $('#reviewForm').attr('data-review-id', reviewId);
                    $('#reviewForm').attr('data-action', 'update');
                    $('#reviewModal').show();
                },
                error: function(xhr) {
                    showNotification(xhr.responseJSON?.message || 'Không thể tải thông tin đánh giá', 'error');
                }
            });
        };

        // Drag & Drop media
        const dropZone = $('.border-dashed').parent();
        dropZone.on('dragover dragenter', function(e) {
            e.preventDefault();
            $(this).find('.border-dashed').addClass('border-blue-400 bg-blue-50');
        });

        dropZone.on('dragleave dragend', function(e) {
            e.preventDefault();
            $(this).find('.border-dashed').removeClass('border-blue-400 bg-blue-50');
        });

        dropZone.on('drop', function(e) {
            e.preventDefault();
            $(this).find('.border-dashed').removeClass('border-blue-400 bg-blue-50');

            const files = Array.from(e.originalEvent.dataTransfer.files);
            files.forEach(file => {
                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    if (file.size <= 10 * 1024 * 1024) {
                        selectedFiles.push(file);
                    } else {
                        showNotification(`File ${file.name} quá lớn`, 'error');
                    }
                } else {
                    showNotification(`File ${file.name} không được hỗ trợ`, 'error');
                }
            });
            updateMediaPreview();
        });

        // Lazy loading cho reviews
        function initInfiniteScroll() {
            let loading = false;
            $(window).scroll(function() {
                if (loading || isLoading) return;
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    const hasMore = $('#loadMoreBtn').is(':visible');
                    if (hasMore) {
                        loading = true;
                        currentPage++;
                        loadReviews(currentPage, true).always(() => {
                            loading = false;
                        });
                    }
                }
            });
        }

        // Load reviews ban đầu
        loadReviews();

        // Bật infinite scroll
        initInfiniteScroll();

        // Xử lý phím tắt
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.modal').hide();
            }
            if (e.ctrlKey && e.key === 'Enter' && $('#reviewModal').is(':visible')) {
                $('#reviewForm').submit();
            }
        });
    });
</script>