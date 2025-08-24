<!-- Modal viết/sửa đánh giá cho nhiều sản phẩm -->
<div id="reviewModal" class="modal">
    <div class="modal-content max-w-4xl">
        <div class="p-6 border-b">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">Đánh giá đơn hàng #{{ $order->order_number ?? $order->id }}</h3>
                <button class="text-gray-400 hover:text-gray-600" id="closeModal">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <form id="reviewForm" enctype="multipart/form-data" class="p-6">
            <!-- Danh sách sản phẩm để đánh giá -->
            <div id="productsList" class="space-y-6">
                <!-- Products sẽ được load bằng AJAX -->
            </div>

            <div class="flex items-center justify-between pt-4 border-t mt-6">
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

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 2% auto;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.star-rating {
    display: flex;
    gap: 4px;
}

.star {
    font-size: 20px;
    color: #d1d5db;
    cursor: pointer;
    transition: color 0.2s;
}

.star:hover,
.star.active {
    color: #fbbf24;
}

.product-review-card {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 16px;
    background: #fafafa;
}

.product-review-card.reviewed {
    border-color: #10b981;
    background: #f0fdf4;
}

.notification {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Khởi tạo biến
        let orderId = {{ $order->id }};
        let orderProducts = [];

        // Thiết lập CSRF token cho AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Mở modal đánh giá
        $('#writeReviewBtn, #editUserReviewBtn').on('click', function() {
            if (!{{ Auth::check() ? 'true' : 'false' }}) {
                showNotification('Vui lòng đăng nhập để viết đánh giá.', 'error');
                return;
            }
            loadOrderProducts();
        });

        // Load danh sách sản phẩm trong đơn hàng
        function loadOrderProducts() {
            $.ajax({
                url: `/orders/${orderId}/products`,
                method: 'GET',
                beforeSend: function() {
                    $('#reviewModal').show();
                    $('#productsList').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i>Đang tải...</div>');
                },
                success: function(response) {
                    if (response.success && response.products) {
                        orderProducts = response.products;
                        console.log('Products:', orderProducts); // Debug dữ liệu trả về
                        renderProductsList();
                    } else {
                        showNotification('Không thể tải danh sách sản phẩm', 'error');
                        $('#reviewModal').hide();
                    }
                },
                error: function(xhr) {
                    console.error('Error loading products:', xhr);
                    showNotification(xhr.responseJSON?.message || 'Không thể tải danh sách sản phẩm', 'error');
                    $('#reviewModal').hide();
                }
            });
        }

        // Render danh sách sản phẩm
        function renderProductsList() {
            const container = $('#productsList');
            container.empty();

            if (!orderProducts || orderProducts.length === 0) {
                container.html('<p class="text-gray-500 text-center py-4">Không có sản phẩm để đánh giá.</p>');
                return;
            }

            orderProducts.forEach((product, index) => {
                const productCard = renderProductCard(product, index);
                container.append(productCard);
            });
        }

        // Render card sản phẩm
        function renderProductCard(product, index) {
            const hasReview = product.has_review;
            const review = product.review;
            const cardClass = hasReview ? 'product-review-card reviewed' : 'product-review-card';
            
            // Xử lý đường dẫn ảnh
            let imageUrl = product.product.image || '/images/default-product.jpg';
            if (imageUrl && !imageUrl.startsWith('http') && !imageUrl.startsWith('/')) {
                imageUrl = '/' + imageUrl; // Thêm dấu / nếu cần
            }

            return `
                <div class="${cardClass}" data-product-index="${index}">
                    <div class="flex items-start space-x-4 mb-4">
                        <img src="${imageUrl}" 
                             alt="${product.product.name}" 
                             class="w-16 h-16 object-cover rounded">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">${product.product.name}</h4>
                            ${product.variant ? `<p class="text-sm text-gray-600">Phân loại: ${product.variant.name}</p>` : ''}
                            <p class="text-sm text-gray-600">Số lượng: ${product.quantity}</p>
                            <p class="text-sm text-gray-600">Giá: ${formatPrice(product.product.price)}</p>
                            ${hasReview ? '<span class="inline-block mt-1 px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Đã đánh giá</span>' : ''}
                        </div>
                    </div>

                    ${hasReview ? renderExistingReview(review, index) : renderReviewForm(product, index)}
                </div>
            `;
        }

        // Render form đánh giá cho sản phẩm
        function renderReviewForm(product, index) {
            return `
                <div class="review-form-section">
                    <input type="hidden" name="reviews[${index}][order_detail_id]" value="${product.order_detail_id}">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Đánh giá sản phẩm <span class="text-red-500">*</span>
                        </label>
                        <div class="star-rating mb-2" data-product-index="${index}">
                            <i class="fas fa-star star" data-rating="1"></i>
                            <i class="fas fa-star star" data-rating="2"></i>
                            <i class="fas fa-star star" data-rating="3"></i>
                            <i class="fas fa-star star" data-rating="4"></i>
                            <i class="fas fa-star star" data-rating="5"></i>
                        </div>
                        <p class="text-sm text-gray-500 rating-text">Chọn số sao để đánh giá sản phẩm này</p>
                        <input type="hidden" name="reviews[${index}][rating]" class="rating-value" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nhận xét về sản phẩm
                        </label>
                        <textarea
                            name="reviews[${index}][comment]"
                            rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 comment-field"
                            placeholder="Chia sẻ cảm nhận của bạn về sản phẩm này..."
                            maxlength="1000"></textarea>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>Tối đa 1000 ký tự</span>
                            <span class="comment-counter">0/1000</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Hình ảnh/Video cho sản phẩm này
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition-colors">
                            <input type="file" name="reviews[${index}][media][]" multiple accept="image/*,video/*" class="hidden media-input">
                            <label class="cursor-pointer media-label">
                                <div class="text-gray-400 mb-2">
                                    <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                </div>
                                <p class="text-sm text-gray-600">
                                    Chọn hình ảnh/video
                                </p>
                            </label>
                        </div>
                        <div class="media-preview mt-2 hidden">
                            <div class="media-container flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render đánh giá đã tồn tại
        function renderExistingReview(review, index) {
            const stars = Array.from({ length: 5 }, (_, i) =>
                `<i class="fas fa-star ${i < review.rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`
            ).join('');

            let mediaHtml = '';
            if (review.media && review.media.length > 0) {
                const mediaItems = review.media.map(media => {
                    if (media.type === 'image') {
                        return `<img src="${media.url}" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="openMediaViewer('${media.url}', 'image')">`;
                    } else if (media.type === 'video') {
                        return `<video src="${media.url}" class="w-12 h-12 object-cover rounded cursor-pointer" onclick="openMediaViewer('${media.url}', 'video')"></video>`;
                    }
                    return '';
                }).join('');
                mediaHtml = `<div class="flex gap-2 mt-2">${mediaItems}</div>`;
            }

            return `
                <div class="existing-review">
                    <div class="flex items-center mb-2">
                        <div class="flex space-x-1 mr-2">${stars}</div>
                        <span class="text-sm text-gray-500">${new Date(review.created_at).toLocaleString('vi-VN')}</span>
                    </div>
                    ${review.comment ? `<p class="text-gray-700 mb-2">${review.comment}</p>` : ''}
                    ${mediaHtml}
                    <div class="flex space-x-2 mt-2">
                        <button type="button" class="text-blue-600 hover:underline text-sm edit-product-review" data-review-id="${review.id}">
                            Chỉnh sửa
                        </button>
                    </div>
                </div>
            `;
        }

        // Xử lý click sao đánh giá
        $(document).on('click', '.star-rating .star', function() {
            const rating = $(this).data('rating');
            const productIndex = $(this).closest('.star-rating').data('product-index');
            const container = $(this).closest('.product-review-card');
            
            container.find('.rating-value').val(rating);
            
            // Update stars
            $(this).closest('.star-rating').find('.star').each(function(index) {
                $(this).toggleClass('active', index < rating);
            });
            
            // Update text
            const texts = {
                1: 'Rất không hài lòng',
                2: 'Không hài lòng', 
                3: 'Bình thường',
                4: 'Hài lòng',
                5: 'Rất hài lòng'
            };
            container.find('.rating-text').text(texts[rating] || 'Chọn số sao để đánh giá sản phẩm này');
        });

        // Đếm ký tự comment
        $(document).on('input', '.comment-field', function() {
            const length = $(this).val().length;
            $(this).closest('.mb-4').find('.comment-counter').text(`${length}/1000`);
        });

        // Xử lý upload file
        $(document).on('change', '.media-input', function() {
            const files = Array.from(this.files);
            const container = $(this).closest('.mb-4');
            const preview = container.find('.media-preview');
            const mediaContainer = container.find('.media-container');
            
            files.forEach(file => {
                if (file.size > 10 * 1024 * 1024) {
                    showNotification(`File ${file.name} quá lớn. Vui lòng chọn file nhỏ hơn 10MB.`, 'error');
                    return;
                }
                
                if (file.type.startsWith('image/') || file.type.startsWith('video/')) {
                    const filePreview = $('<div class="relative w-16 h-16"></div>');
                    const removeBtn = $('<span class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer text-xs">&times;</span>');
                    
                    if (file.type.startsWith('image/')) {
                        const img = $('<img class="w-full h-full object-cover rounded">');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                        filePreview.append(img);
                    } else {
                        const video = $('<video class="w-full h-full object-cover rounded" controls></video>');
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            video.attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                        filePreview.append(video);
                    }
                    
                    filePreview.append(removeBtn);
                    mediaContainer.append(filePreview);
                    preview.removeClass('hidden');
                    
                    // Handle remove
                    removeBtn.on('click', function() {
                        filePreview.remove();
                        if (mediaContainer.children().length === 0) {
                            preview.addClass('hidden');
                        }
                        // Reset file input
                        $(this).closest('.mb-4').find('.media-input').val('');
                    });
                }
            });
        });

        // Click vào label upload
        $(document).on('click', '.media-label', function() {
            $(this).closest('.mb-4').find('.media-input').click();
        });

        // Đóng modal
        $('#closeModal, #cancelBtn').on('click', function() {
            $('#reviewModal').hide();
        });

        // Submit form đánh giá
        $('#reviewForm').on('submit', function(e) {
            e.preventDefault();
            
            // Validation
            let hasValidReview = false;
            $('.review-form-section').each(function() {
                const rating = $(this).find('.rating-value').val();
                if (rating && parseInt(rating) > 0) {
                    hasValidReview = true;
                    return false; // break
                }
            });
            
            if (!hasValidReview) {
                showNotification('Vui lòng đánh giá ít nhất một sản phẩm', 'error');
                return;
            }

            const formData = new FormData(this);
            
            $('#submitLoading').removeClass('hidden');
            $('#submitBtn').prop('disabled', true);

            $.ajax({
                url: `/orders/${orderId}/reviews`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('#reviewModal').hide();
                        showNotification(response.message, 'success');
                        setTimeout(() => {
                            location.reload(); // Reload để cập nhật trạng thái
                        }, 1000);
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

        // Xử lý chỉnh sửa đánh giá sản phẩm
        $(document).on('click', '.edit-product-review', function() {
            const reviewId = $(this).data('review-id');
            editSingleReview(reviewId);
        });

        // Xử lý xóa đánh giá sản phẩm  
        $(document).on('click', '.delete-product-review', function() {
            const reviewId = $(this).data('review-id');
            if (confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) {
                deleteSingleReview(reviewId);
            }
        });

        // Chỉnh sửa đánh giá đơn lẻ
        function editSingleReview(reviewId) {
            $.ajax({
                url: `/order-reviews/${reviewId}/edit`,
                method: 'GET',
                success: function(review) {
                    // Tạo modal chỉnh sửa đánh giá đơn lẻ
                    showEditSingleReviewModal(review);
                },
                error: function(xhr) {
                    showNotification(xhr.responseJSON?.message || 'Không thể tải thông tin đánh giá', 'error');
                }
            });
        }

        // Hiển thị modal chỉnh sửa đánh giá đơn lẻ
        function showEditSingleReviewModal(review) {
            const stars = Array.from({length: 5}, (_, i) => 
                `<i class="fas fa-star star ${i < review.rating ? 'active' : ''}" data-rating="${i+1}"></i>`
            ).join('');

            let existingMediaHtml = '';
            if (review.media && review.media.length > 0) {
                const mediaItems = review.media.map(media => `
                    <div class="relative w-16 h-16">
                        ${media.type === 'image' ? 
                            `<img src="${media.url}" class="w-full h-full object-cover rounded">` :
                            `<video src="${media.url}" class="w-full h-full object-cover rounded" controls></video>`
                        }
                        <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer text-xs remove-existing-media" data-media-id="${media.id}">&times;</span>
                    </div>
                `).join('');
                existingMediaHtml = `<div class="flex flex-wrap gap-2 mb-2">${mediaItems}</div>`;
            }

            const modalHtml = `
                <div id="editSingleReviewModal" class="modal" style="display: block;">
                    <div class="modal-content">
                        <div class="p-6 border-b">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Chỉnh sửa đánh giá</h3>
                                <button class="text-gray-400 hover:text-gray-600" onclick="$('#editSingleReviewModal').remove()">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                        <form id="editSingleReviewForm" enctype="multipart/form-data" class="p-6">
                            <input type="hidden" name="review_id" value="${review.id}">
                            <input type="hidden" name="_method" value="PUT">
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá <span class="text-red-500">*</span></label>
                                <div class="star-rating mb-2" id="editRatingStars">
                                    ${stars}
                                </div>
                                <input type="hidden" name="rating" id="editRatingValue" value="${review.rating}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nhận xét</label>
                                <textarea name="comment" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" maxlength="1000">${review.comment || ''}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh/Video</label>
                                ${existingMediaHtml}
                                <input type="file" name="media[]" multiple accept="image/*,video/*" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            </div>

                            <div class="flex justify-between pt-4 border-t">
                                <button type="button" onclick="$('#editSingleReviewModal').remove()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Hủy</button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                    <i class="fas fa-spinner fa-spin mr-2 hidden" id="editSubmitLoading"></i>
                                    Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            `;

            $('body').append(modalHtml);

            // Xử lý click sao trong modal edit
            $('#editRatingStars .star').on('click', function() {
                const rating = $(this).data('rating');
                $('#editRatingValue').val(rating);
                $('#editRatingStars .star').each(function(index) {
                    $(this).toggleClass('active', index < rating);
                });
            });

            // Xử lý xóa media cũ
            $('.remove-existing-media').on('click', function() {
                const mediaId = $(this).data('media-id');
                $('#editSingleReviewForm').append(`<input type="hidden" name="remove_media[]" value="${mediaId}">`);
                $(this).parent().remove();
            });

            // Submit form edit
            $('#editSingleReviewForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const reviewId = formData.get('review_id');

                $('#editSubmitLoading').removeClass('hidden');

                $.ajax({
                    url: `/order-reviews/${reviewId}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $('#editSingleReviewModal').remove();
                            showNotification(response.message, 'success');
                        } else {
                            showNotification(response.message || 'Không thể cập nhật đánh giá', 'error');
                        }
                    },
                    error: function(xhr) {
                        showNotification(xhr.responseJSON?.message || 'Có lỗi xảy ra', 'error');
                    },
                    complete: function() {
                        $('#editSubmitLoading').addClass('hidden');
                    }
                });
            });
        }

        // Xóa đánh giá đơn lẻ
        function deleteSingleReview(reviewId) {
            $.ajax({
                url: `/order-reviews/${reviewId}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        showNotification(response.message, 'success');
                        // Reload trang để cập nhật trạng thái
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showNotification(response.message || 'Không thể xóa đánh giá', 'error');
                    }
                },
                error: function(xhr) {
                    showNotification(xhr.responseJSON?.message || 'Có lỗi xảy ra', 'error');
                }
            });
        }

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

        // Format giá tiền
        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(price);
        }

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

        // Make functions global
        window.editSingleReview = editSingleReview;
        window.deleteSingleReview = deleteSingleReview;

        // Đóng modal khi click outside
        $('.modal').on('click', function(e) {
            if (e.target === this) {
                $(this).hide();
            }
        });

        // Xử lý phím tắt
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.modal').hide();
            }
        });
    });
</script>