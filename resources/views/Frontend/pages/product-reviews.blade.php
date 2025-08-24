<!-- resources/views/Frontend/reviews/index.blade.php -->
<div class="product-reviews mt-8">
    <!-- Thống kê đánh giá sản phẩm -->
    <div class="mb-6">
        <div class="section-title-all">
            <h2 class="text-xl font-bold">Đánh giá sản phẩm</h2>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-between">
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

            <div class="flex-1 mx-0 md:mx-8 mt-4 md:mt-0">
                <div class="space-y-2">
                    @for ($i = 5; $i >= 1; $i--)
                        <div class="flex items-center">
                            <span class="w-8 text-sm">{{ $i }}★</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $ratingStats[$i]['percentage'] ?? 0 }}%"></div>
                            </div>
                            <span class="w-8 text-sm text-gray-500">{{ $ratingStats[$i]['count'] ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Bộ lọc và sắp xếp -->
    <div class="flex flex-col md:flex-row items-center justify-between border-t pt-4">
        <div class="flex items-center space-x-4 mb-4 md:mb-0">
            <span class="text-sm font-medium">Sắp xếp:</span>
            <select id="reviewSort" class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                <option value="latest">Mới nhất</option>
                <option value="oldest">Cũ nhất</option>
                <option value="rating_high">Đánh giá cao</option>
                <option value="rating_low">Đánh giá thấp</option>
            </select>
        </div>

        <div class="flex items-center space-x-2 flex-wrap gap-2">
            <span class="text-sm text-gray-500">Lọc theo:</span>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn active" data-rating="all" aria-label="Lọc tất cả đánh giá">
                Tất cả
            </button>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="5" aria-label="Lọc đánh giá 5 sao">
                5★
            </button>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="4" aria-label="Lọc đánh giá 4 sao">
                4★
            </button>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="3" aria-label="Lọc đánh giá 3 sao">
                3★
            </button>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="2" aria-label="Lọc đánh giá 2 sao">
                2★
            </button>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="1" aria-label="Lọc đánh giá 1 sao">
                1★
            </button>
            <button class="px-3 py-1 text-xs border border-gray-300 rounded-full hover:bg-gray-100 transition-colors filter-btn" data-rating="media" aria-label="Lọc đánh giá có hình ảnh">
                <i class="fas fa-image mr-1"></i>Có hình ảnh
            </button>
        </div>
    </div>

    <!-- Danh sách đánh giá -->
    <div class="bg-white rounded-lg shadow-sm mt-6">
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

    <!-- Modal xem ảnh/video lớn -->
    <div id="mediaModal" class="modal">
        <div class="modal-content max-w-4xl">
            <div class="p-4 text-right">
                <button class="text-white hover:text-gray-300" id="closeMediaModal" aria-label="Đóng modal">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="mediaViewer" class="p-4 text-center"></div>
        </div>
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
    transition: color 0.2s;
}

.star.active {
    color: #fbbf24;
}

.section-title-all h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 16px;
    color: #374151;
}

.review-item:last-child {
    border-bottom: none;
}

.filter-btn.active {
    background-color: #dbeafe;
    color: #1d4ed8;
    border-color: #3b82f6;
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

/* Media preview layout - Căn chỉnh media gần nhau */
.media-preview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
    gap: 4px; /* Giảm gap từ 10px xuống 4px */
    margin-top: 8px;
    max-width: 340px; /* Giới hạn chiều rộng để media không bị dàn quá rộng */
}

.media-preview .media-item {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border-radius: 6px; /* Giảm border-radius để tiết kiệm không gian */
    position: relative;
}

.media-preview img,
.media-preview video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.2s, opacity 0.2s;
    border: none;
    margin: 0;
    padding: 0;
}

.media-preview img:hover,
.media-preview video:hover {
    transform: scale(1.05);
    opacity: 0.9;
}

/* Responsive adjustments for media layout */
@media (max-width: 640px) {
    .media-preview {
        grid-template-columns: repeat(4, 1fr);
        gap: 3px; /* Giảm gap hơn nữa trên mobile */
        max-width: 100%;
    }
    
    .media-preview .media-item {
        width: 70px;
        height: 70px;
    }
}

@media (max-width: 480px) {
    .media-preview {
        gap: 2px;
    }
    
    .media-preview .media-item {
        width: 65px;
        height: 65px;
        border-radius: 4px;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Khởi tạo biến
        let currentPage = 1;
        let isLoading = false;
        let currentFilter = 'all';
        let productId = {{ isset($product) && $product ? $product->id : 0 }};

        // Hàm helper để tạo đường dẫn storage
        function getStorageUrl(path) {
            if (!path) return null;
            // Nếu đã có đầy đủ URL, trả về nguyên bản
            if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/storage/')) {
                return path;
            }
            // Nếu chỉ có tên file hoặc đường dẫn tương đối, thêm /storage/
            return '/storage/' + path.replace(/^\//, ''); // Loại bỏ / đầu nếu có
        }

        // Hàm helper để tạo đường dẫn uploads cho product
        function getUploadsUrl(path) {
            if (!path) return null;
            // Nếu đã có đầy đủ URL, trả về nguyên bản
            if (path.startsWith('http://') || path.startsWith('https://')) {
                return path;
            }
            // Nếu đã có /uploads/ ở đầu
            if (path.startsWith('/uploads/')) {
                return path;
            }
            // Nếu có uploads/ ở đầu (không có /)
            if (path.startsWith('uploads/')) {
                return '/' + path;
            }
            // Các trường hợp khác, thêm /uploads/ vào đầu
            return '/uploads/' + path.replace(/^\//, '');
        }

        // Thiết lập CSRF token cho AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load danh sách đánh giá
        function loadReviews(page = 1, append = false) {
            if (isLoading || productId === 0) {
                $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Không thể tải đánh giá: ID sản phẩm không hợp lệ.</p>');
                $('#loadMoreBtn').hide();
                isLoading = false;
                showNotification('Không thể tải đánh giá: ID sản phẩm không hợp lệ', 'error');
                return;
            }

            isLoading = true;
            const sort = $('#reviewSort').val() || 'latest';

            if (!append) {
                $('#loadingIcon').removeClass('hidden');
                $('#reviewsList').empty();
            }

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
                    if (response.success && response.data && Array.isArray(response.data.reviews)) {
                        const reviews = response.data.reviews;
                        const pagination = response.data.pagination;

                        // Cập nhật thống kê
                        if (response.data.avgRating) {
                            $('#avgRating').text(response.data.avgRating.toFixed(1));
                            $('#totalReviews').text(response.data.totalReviews);
                            const avgStars = $('#avgStars');
                            avgStars.empty();
                            for (let i = 1; i <= 5; i++) {
                                avgStars.append(`<i class="fas fa-star star ${i <= Math.floor(response.data.avgRating) ? 'active' : ''}"></i>`);
                            }
                            for (let i = 5; i >= 1; i--) {
                                const percentage = response.data.ratingStats[i]?.percentage || 0;
                                const count = response.data.ratingStats[i]?.count || 0;
                                $(`.flex.items-center:contains('${i}★') .bg-yellow-400`).css('width', `${percentage}%`);
                                $(`.flex.items-center:contains('${i}★') .text-gray-500`).text(count);
                            }
                        }

                        if (!append) {
                            $('#reviewsList').empty();
                            currentPage = 1;
                        }

                        if (reviews.length === 0) {
                            $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Chưa có đánh giá nào.</p>');
                            $('#loadMoreBtn').hide();
                        } else {
                            reviews.forEach(review => {
                                $('#reviewsList').append(renderReviewItem(review));
                            });
                            if (pagination.has_more) {
                                $('#loadMoreBtn').show();
                            } else {
                                $('#loadMoreBtn').hide();
                            }
                        }
                    } else {
                        showNotification('Không có đánh giá để hiển thị', 'info');
                        $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Chưa có đánh giá nào.</p>');
                        $('#loadMoreBtn').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading reviews:', xhr.status, xhr.responseText);
                    showNotification(`Không thể tải đánh giá: ${xhr.status} - ${xhr.responseJSON?.message || error}`, 'error');
                    $('#reviewsList').html('<p class="text-gray-500 text-center py-4">Lỗi khi tải đánh giá.</p>');
                    $('#loadMoreBtn').hide();
                },
                complete: function() {
                    isLoading = false;
                    $('#loadingIcon').addClass('hidden');
                }
            });
        }

        // Render một item đánh giá
        function renderReviewItem(review) {
            const stars = Array.from({ length: 5 }, (_, i) =>
                `<i class="fas fa-star ${i < review.rating ? 'text-yellow-400' : 'text-gray-300'}"></i>`
            ).join('');

            let mediaHtml = '';
            if (review.media && Array.isArray(review.media) && review.media.length > 0) {
                const mediaItems = review.media.map(media => {
                    const mediaUrl = getStorageUrl(media.url || media.path);
                    const defaultImage = '/storage/images/default-review-image.jpg';
                    const defaultVideo = '/storage/images/default-review-video.jpg';
                    
                    return `
                        <div class="media-item">
                            ${media.type === 'image' ? 
                                `<img src="${mediaUrl}" class="w-full h-full object-cover rounded" onerror="this.src='${defaultImage}'" onclick="openMediaViewer('${mediaUrl}', 'image')" alt="Ảnh đánh giá">` :
                                `<video src="${mediaUrl}" class="w-full h-full object-cover rounded" onerror="this.poster='${defaultVideo}'" onclick="openMediaViewer('${mediaUrl}', 'video')"></video>`
                            }
                        </div>
                    `;
                }).join('');
                mediaHtml = `<div class="media-preview mt-2">${mediaItems}</div>`;
            }

            let productInfo = '';
            if (review.reviewed_product) {
                const product = review.reviewed_product;
                const productImage = getUploadsUrl(product.image) || '/uploads/default-product.jpg';
                productInfo = `
                    <div class="flex items-center space-x-2 mb-2 text-sm text-gray-600">
                        <img src="${productImage}" alt="${product.name}" class="w-16 h-16 rounded object-cover" onerror="this.src='/uploads/default-product.jpg'">
                        <span class="font-medium">${product.name}</span>
                    </div>
                `;
            }

            const userAvatar = getStorageUrl(review.user.avatar) || '/storage/images/default-avatar.jpg';

            return `
                <div class="review-item border-b py-4">
                    <div class="flex items-start space-x-3">
                        <img src="${userAvatar}" alt="${review.user.name || 'Ẩn danh'}" class="w-10 h-10 rounded-full object-cover" onerror="this.src='/storage/images/default-avatar.jpg'">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-medium text-gray-900">${review.user.name || 'Ẩn danh'}</h4>
                                <span class="text-sm text-gray-500">${new Date(review.created_at).toLocaleString('vi-VN')}</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <div class="flex space-x-1 mr-2">${stars}</div>
                                ${review.order_id ? '<span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded ml-2">Đã mua hàng</span>' : ''}
                                ${review.is_approved ? '' : '<span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded ml-2">Đang chờ duyệt</span>'}
                            </div>
                            ${productInfo}
                            ${review.comment ? `<p class="text-gray-700 mb-2">${review.comment}</p>` : ''}
                            ${mediaHtml}
                        </div>
                    </div>
                </div>
            `;
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
                        <button class="ml-4 text-current hover:opacity-70" onclick="$(this).parent().parent().remove()" aria-label="Đóng thông báo">
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

        // Mở viewer cho media
        window.openMediaViewer = function(url, type) {
            const viewer = $('#mediaViewer');
            viewer.empty();

            const defaultImage = '/storage/images/default-review-image.jpg';
            const defaultVideo = '/storage/images/default-review-video.jpg';

            if (type === 'image') {
                viewer.append(`<img src="${url}" class="max-w-full max-h-[80vh] object-contain" alt="Ảnh đánh giá lớn" onerror="this.src='${defaultImage}'">`);
            } else if (type === 'video') {
                viewer.append(`<video src="${url}" controls class="max-w-full max-h-[80vh]" onerror="this.poster='${defaultVideo}'"></video>`);
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

        // Load reviews ban đầu
        loadReviews();

        // Sắp xếp đánh giá
        $('#reviewSort').on('change', function() {
            currentPage = 1;
            loadReviews();
        });

        // Lọc đánh giá
        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            currentFilter = $(this).data('rating') || 'all';
            currentPage = 1;
            loadReviews();
        });

        // Load thêm đánh giá
        $('#loadMoreBtn').on('click', function() {
            currentPage++;
            loadReviews(currentPage, true);
        });

        // Xử lý phím tắt
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.modal').hide();
            }
        });
    });
</script>