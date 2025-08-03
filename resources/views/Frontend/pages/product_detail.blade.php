<!doctype html>
<html class="no-js" lang="vi">

<head>
    @include('Frontend.partials.head')
    <title>{{ $product->name }} - F1GENZ Shoes</title>
</head>

<body class="">
    @include('Frontend.partials.header')
<main class="main-layout">
    <!-- Breadcrumb -->
    <div class="main-product-breadcrumb">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.all') }}">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Product Detail -->
    <div class="main-product">
        <div class="container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="product-images">
                        <div class="main-image">
                            @if($product->image)
                                <img id="main-product-image" src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                            @endif
                        </div>
                        
                        @if($images && $images->count() > 0)
                        <div class="thumbnail-images mt-3">
                            <div class="row">
                                @foreach($images as $image)
                                <div class="col-3">
                                    <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}" 
                                         class="img-fluid thumbnail-img" onclick="changeMainImage(this.src)">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6">
                    <div class="product-info">
                        <h1 class="product-title">{{ $product->name }}</h1>
                        
                        <div class="product-price">
                            <span class="current-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        </div>

                        <div class="product-description">
                            {!! $product->description !!}
                        </div>

                        <!-- Product Variants -->
                        @if($colors && $colors->count() > 0)
                        <div class="product-variants">
                            <h5>Màu sắc:</h5>
                            <div class="color-options">
                                @foreach($colors as $color)
                                <button type="button" class="color-option" data-color-id="{{ $color->id }}">
                                    {{ $color->value }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($sizes && $sizes->count() > 0)
                        <div class="product-variants">
                            <h5>Kích thước:</h5>
                            <div class="size-options">
                                @foreach($sizes as $size)
                                <button type="button" class="size-option" data-size-id="{{ $size->id }}">
                                    {{ $size->value }}
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Add to Cart -->
                        <form method="POST" action="{{ route('cart.add') }}" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                            <div class="quantity-controls">
                                <label>Số lượng:</label>
                                <div class="quantity-input">
                                    <button type="button" onclick="decreaseQuantity()">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                                    <button type="button" onclick="increaseQuantity()">+</button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary add-to-cart-btn">
                                Thêm vào giỏ hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Reviews -->
            <div class="product-reviews mt-5">
                <h3>Đánh giá sản phẩm</h3>
                
                @php
                    $reviews = $product->reviews ?? collect();
                    $totalReviews = $reviews->count();
                    $averageRating = $reviews->avg('rating') ?? 0;
                @endphp

                <div class="reviews-summary">
                    <div class="rating-average">
                        <span class="rating-score">{{ number_format($averageRating, 1) }}</span>
                        <span>/5</span>
                        <div class="stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $averageRating ? 'star-on' : 'star-off' }}">★</i>
                            @endfor
                        </div>
                        <p>({{ $totalReviews }} đánh giá)</p>
                    </div>

                    @auth
                        @if ($hasPurchased)
                            <button type="button" class="btn btn-outline-primary" onclick="openReviewModal()">
                                Gửi đánh giá
                            </button>
                        @else
                            <div class="alert alert-warning">
                                ⚠️ Bạn cần <strong>mua sản phẩm</strong> để có thể đánh giá.
                            </div>
                        @endif
                    @else
                        <p><a href="{{ route('login') }}" class="btn btn-outline-primary">Đăng nhập</a> để gửi đánh giá</p>
                    @endauth
                </div>

                <!-- Reviews List -->
                <div class="reviews-list">
                    @foreach ($reviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <span class="reviewer-name">{{ $review->user->name ?? 'Ẩn danh' }}</span>
                                <div class="review-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'star-on' : 'star-off' }}">★</i>
                                    @endfor
                                </div>
                            </div>
                            <div class="review-content">
                                <p>{{ $review->comment }}</p>
                            </div>
                            <div class="review-date">
                                {{ $review->created_at->format('H:i d/m/Y') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recently Viewed Products -->
            <div class="recently-viewed-products mt-5" id="product-page-recently-viewed" style="display: none;">
                <h3>Sản phẩm vừa xem</h3>
                <div id="product-page-recently-viewed-list" class="row">
                    <!-- Sản phẩm sẽ được render bằng JavaScript -->
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts && $relatedProducts->count() > 0)
            <div class="related-products mt-5">
                <h3>Sản phẩm liên quan</h3>
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product-card">
                            <a href="{{ route('product.show', $relatedProduct->id) }}">
                                <img src="{{ asset($relatedProduct->image ?? 'images/default.jpg') }}" 
                                     alt="{{ $relatedProduct->name }}" class="img-fluid">
                                <h5>{{ $relatedProduct->name }}</h5>
                                <p class="price">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</p>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</main>

<!-- Review Modal -->
<div id="reviewModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closeReviewModal()">&times;</span>
        <h4>Đánh giá sản phẩm</h4>
        <form method="POST" action="{{ route('reviews.store', $product->id) }}">
            @csrf
            <div class="form-group">
                <label>Đánh giá:</label>
                <div class="star-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-rating="{{ $i }}">★</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="selected-rating" value="5">
            </div>
            <div class="form-group">
                <label>Nội dung:</label>
                <textarea name="comment" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
        </form>
    </div>
</div>

	<style>
<<<<<<< HEAD
		/* Rating Star Styling */
		.star-on-png {
			color: #ffc107;
		}
		.star-off-png {
			color: #ddd;
		}

		/* Button Styling */
		.btn-new-review,
		.bpr-button-submit {
			background-color: #80BB35;
			border: none;
			color: white;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 4px;
			font-weight: 500;
			transition: background-color 0.2s;
		}

		.btn-new-review:hover,
		.bpr-button-submit:hover {
			background-color: #6ca028;
		}

		/* Modal Base Styling */
		.popup-bpr-form.jquerymodal {
			display: none;
			position: fixed !important;
			z-index: 9999 !important;
			top: 0 !important;
			left: 0 !important;
			right: 0 !important;
			bottom: 0 !important;
			width: 100% !important;
			height: 100% !important;
			background-color: rgba(0, 0, 0, 0.5) !important;
			opacity: 0;
			visibility: hidden;
			transition: opacity 0.3s ease;
			overflow: hidden !important;

			/* Flexbox centering */
			align-items: center !important;
			justify-content: center !important;
		}

		/* Modal Active State */
		.popup-bpr-form.jquerymodal.modal-active,
		.popup-bpr-form.jquerymodal[style*="display: flex"],
		.popup-bpr-form.jquerymodal[style*="display:flex"] {
			opacity: 1 !important;
			visibility: visible !important;
			display: flex !important;
		}

		/* Ensure block display is overridden with flex */
		.popup-bpr-form.jquerymodal[style*="display: block"],
		.popup-bpr-form.jquerymodal[style*="display:block"] {
			display: flex !important;
		}

		/* Modal Content Styling */
		.jquerymodal-content {
			background-color: #fff !important;
			border-radius: 8px !important;
			box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2) !important;
			width: 90% !important;
			max-width: 500px !important;
			position: relative !important;
			margin: auto !important;
			animation: modalFadeIn 0.3s ease;
		}

		/* Modal Body Styling */
		.jquerymodal-body {
			padding: 24px;
		}

		/* Close Button Styling */
		.close-modal {
			position: absolute;
			right: 15px;
			top: 15px;
			width: 24px;
			height: 24px;
			opacity: 0.6;
			cursor: pointer;
			transition: opacity 0.2s;
			z-index: 1;
		}

		.close-modal:hover {
			opacity: 1;
		}

		/* Form Elements Styling */
		.sapo-product-reviews-form {
			padding: 10px 0;
		}

		.title-form {
			margin-top: 0;
			margin-bottom: 15px;
			font-size: 20px;
=======
/* Product Detail Styles */
.main-product {
    padding: 40px 0;
}

.product-title {
    font-size: 28px;
>>>>>>> feature/order-cancellation
			font-weight: 600;
			margin-bottom: 20px;
}

.product-price .current-price {
    font-size: 24px;
    font-weight: 700;
    color: #e74c3c;
}

.product-variants {
    margin: 20px 0;
}

.color-options, .size-options {
			display: flex;
    gap: 10px;
    margin-top: 10px;
}

.color-option, .size-option {
    padding: 8px 15px;
			border: 1px solid #ddd;
    background: white;
    cursor: pointer;
			border-radius: 4px;
}

<<<<<<< HEAD
		.form-control:focus {
			border-color: #80BB35;
			outline: none;
		}

		/* Animation */
		@keyframes modalFadeIn {
			from {
				opacity: 0;
				transform: translateY(-20px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		/* Prevent conflicts with parent containers */
		#popup-bpr-form {
			text-align: left !important;
		}

		#popup-bpr-form * {
			box-sizing: border-box !important;
		}

		/* Prevent parent containers from affecting modal positioning */
		.main-layout #popup-bpr-form,
		.main-product #popup-bpr-form,
		.container #popup-bpr-form,
		.main-product-wrap #popup-bpr-form,
		#sapo-product-reviews #popup-bpr-form {
			position: fixed !important;
			top: 0 !important;
			left: 0 !important;
			right: 0 !important;
			bottom: 0 !important;
		}

		/* Mobile Responsiveness */
		@media (max-width: 576px) {
			.jquerymodal-content {
				width: 95% !important;
			}

			.jquerymodal-body {
				padding: 16px;
			}

			.title-form {
				font-size: 18px;
			}
		}
	</style>

	<style>
		.chat-bubble.bot-bubble.typing {
			font-style: italic;
			opacity: 0.7;
		}

		.chat-toggle-btn {
			position: fixed;
			bottom: 20px;
			left: 20px; /* đổi từ right: 20px */
			width: 50px;
			height: 50px;
			border-radius: 50%;
			background: #007bff;
=======
.color-option:hover, .size-option:hover,
.color-option.active, .size-option.active {
    border-color: #007bff;
    background-color: #007bff;
>>>>>>> feature/order-cancellation
			color: white;
}

.quantity-controls {
    margin: 20px 0;
}

.quantity-input {
			display: flex;
			align-items: center;
			gap: 10px;
    margin-top: 10px;
}

.quantity-input button {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
}

.quantity-input input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    padding: 5px;
}

.add-to-cart-btn {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
}

.thumbnail-img {
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 4px;
}

.thumbnail-img:hover {
    border-color: #007bff;
}

/* Reviews */
.reviews-summary {
				display: flex;
				justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #f8f9fa;
				border-radius: 8px;
    margin-bottom: 30px;
}

.rating-average {
    text-align: center;
}

.rating-score {
				font-size: 32px;
				font-weight: bold;
				color: #333;
			}

.stars {
				color: #ffc107;
				font-size: 20px;
    margin: 10px 0;
}

.star-on {
    color: #ffc107;
}

.star-off {
    color: #ddd;
}

.review-item {
				border-bottom: 1px solid #eee;
    padding: 20px 0;
			}

.review-header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 10px;
			}

.reviewer-name {
				font-weight: bold;
}

.review-rating {
    color: #ffc107;
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
				display: flex;
				align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 30px;
				border-radius: 8px;
    width: 90%;
    max-width: 500px;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
}

.star-rating {
				display: flex;
    gap: 5px;
    font-size: 24px;
    margin: 10px 0;
			}

.star-rating .star {
				cursor: pointer;
    color: #ddd;
			}

.star-rating .star:hover,
.star-rating .star.active {
				color: #ffc107;
			}

/* Related Products */
.product-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.product-card img {
    height: 200px;
    object-fit: cover;
    margin-bottom: 15px;
}

.product-card h5 {
    font-size: 16px;
    margin-bottom: 10px;
}

.product-card .price {
    font-size: 18px;
    font-weight: 600;
    color: #e74c3c;
		}
	</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const product = {
        id: {{ $product->id }},
        name: @json($product->name),
        slug: @json($product->slug),
        price: {{ $product->price }},
        image: @json(asset($product->image)),
        viewed_at: new Date().toISOString()
    };
    
    if (typeof addToRecentlyViewed === 'function') {
        addToRecentlyViewed(product);
    }
    
    setTimeout(() => {
        displayRecentlyViewedInProductPage();
    }, 100);
});

function displayRecentlyViewedInProductPage() {
    let recentlyViewed = [];
    try {
        const stored = localStorage.getItem('recently_viewed_products');
        recentlyViewed = stored ? JSON.parse(stored) : [];
    } catch (e) {
        return;
    }
    
    const currentProductId = {{ $product->id }};
    const filteredProducts = recentlyViewed
        .filter(p => p.id !== currentProductId)
        .slice(0, 4);
    
    const container = document.getElementById('product-page-recently-viewed-list');
    const section = document.getElementById('product-page-recently-viewed');
    
    if (!container || !section) return;
    
    if (filteredProducts.length > 0) {
        container.innerHTML = filteredProducts.map(product => `
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="product-card">
                    <a href="/product/${product.id}">
                        <img src="${product.image}" alt="${product.name}" class="img-fluid">
                        <h5>${product.name}</h5>
                        <p class="price">${formatPrice(product.price)}</p>
                    </a>
					</div>
					</div>
        `).join('');
        
        section.style.display = 'block';
                } else {
        section.style.display = 'none';
    }
}

function formatPrice(price) {
    try {
        return new Intl.NumberFormat('vi-VN').format(price) + '₫';
    } catch (e) {
        return price + '₫';
    }
}



// Quantity controls
function increaseQuantity() {
    const input = document.getElementById('quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Change main image
function changeMainImage(src) {
    document.getElementById('main-product-image').src = src;
}

// Variants selection
document.querySelectorAll('.color-option').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.color-option').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});

document.querySelectorAll('.size-option').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.size-option').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
			});
		});

// Review modal
function openReviewModal() {
    document.getElementById('reviewModal').style.display = 'flex';
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
}

// Star rating
document.querySelectorAll('.star-rating .star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        document.getElementById('selected-rating').value = rating;
        
        document.querySelectorAll('.star-rating .star').forEach((s, index) => {
            s.classList.toggle('active', index < rating);
        });
		});
	});
</script>

<<<<<<< HEAD
							<div class="sapo-product-reviews-filter">
								<p><i class="fa fa-filter"></i><span>Bộ lọc</span></p>
								<div class="list-filter">
									@for ($i = 5; $i >= 1; $i--)
									<label>
										<input type="radio" name="filter" value="{{ $i }}" style="display:none;" onchange="filterReviews({{ $i }})">
										<span class="checkmark"><span>{{ $i }} Điểm</span> ({{ $reviews->where('rating', $i)->count() }})</span>
									</label>
									@endfor
									<label>
										<input type="radio" name="filter" value="all" checked style="display:none;" onchange="filterReviews('all')">
										<span class="checkmark"><span>Tất cả</span></span>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div id="bpr-list" class="sapo-product-reviews-list mt-4">
						@foreach ($reviews as $review)
							<div class="sapo-review review-rating-{{ $review->rating }}">
								<div class="sapo-review-header">
									<span class="sapo-review-author">{{ $review->user->name ?? 'Ẩn danh' }}</span>
									<div class="sapo-product-reviews-star" data-score="{{ $review->rating }}">
										@for ($i = 1; $i <= 5; $i++)
											<i data-alt="{{ $i }}" class="{{ $i <= $review->rating ? 'star-on-png' : 'star-off-png' }}"></i>
										@endfor
									</div>
								</div>
								<div class="sapo-review-body">
									<div class="sapo-review-verified">
										<i class="fa fa-check-circle text-success"></i> Đã mua hàng tại F1GENZ Shoes
									</div>
									<span class="sapo-review-content-body">{{ $review->comment }}</span>
								</div>
								<div class="sapo-review-actions">
									<ul>
										<li><span class="sapo-review-time">{{ $review->created_at->format('H:i d/m/Y') }}</span></li>
									</ul>
								</div>
							</div>
						@endforeach
					</div>
				</div>

				{{-- Popup Form --}}
				<div id="popup-bpr-form" class="popup-bpr-form" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 9999;">
					<div class="popup-inner" style="background: #fff; padding: 20px; margin: 10% auto; width: 400px; position: relative;">
						<a href="javascript:;" class="close-modal" onclick="document.getElementById('popup-bpr-form').style.display='none'" style="position: absolute; top: 10px; right: 10px;">&times;</a>
						<div class="sapo-product-reviews-form">
							<form method="POST" id="review-form">
								@csrf
								<input type="hidden" name="_method" id="review-method" value="POST">
								<input type="hidden" name="rating" id="review_rate" value="5">

								<h4 class="title-form" id="review-modal-title">Đánh giá sản phẩm</h4>
								<div class="review-product-name">{{ $product->name }}</div>

								<div class="form-group">
									<label>Đánh giá của bạn:</label>
									<div id="dvRating" class="sapo-product-reviews-star">
										@for ($i = 1; $i <= 5; $i++)
											<i data-alt="{{ $i }}" class="star-on-png" onclick="selectRating({{ $i }})"></i>
										@endfor
									</div>
								</div>

								<div class="form-group">
									<textarea name="comment" id="review_comment" rows="4" placeholder="Nội dung đánh giá..." required class="form-control"></textarea>
								</div>

								<div class="form-group">
									<button type="submit" class="bpr-button-submit">Gửi đánh giá</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- sản phẩm liên quan -->
			<div class="main-product-relate">
				<div class="section-title-all">
					<h2>Sản phẩm liên quan</h2>
				</div>
				<div class="main-product-relate-data">
					@foreach($relatedProducts as $product)
					<div class="product-item" data-id="{{ $product->id }}" data-handle="{{ Str::slug($product->name) }}">
						<div class="product-item-wrap">
							<div class="product-item-image hasThumbs hasThumbsIcon">
								<div class="sapo-buyxgety-badge" data-id="{{ $product->id }}"></div>
								@if($product->discount)
									<span class="product-item-discount">-{{ $product->discount }}%</span>
								@endif
								<a class="product-item-link" href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">
									<img class="w-auto" loading="lazy" width="480" height="480" src="{{ asset($product->image ?? 'images/default.jpg') }}" alt="{{ $product->name }}">
									<img class="w-auto" loading="lazy" width="480" height="480" src="{{ asset($product->image2 ?? $product->image ?? 'images/default.jpg') }}" alt="{{ $product->name }}">
								</a>
								<ul class="product-item-thumbs">
									@if($product->thumb1)<li><a href="#"><img loading="lazy" width="50" height="50" src="{{ asset($product->thumb1) }}"></a></li>@endif
									@if($product->thumb2)<li><a href="#"><img loading="lazy" width="50" height="50" src="{{ asset($product->thumb2) }}"></a></li>@endif
									@if($product->thumb3)<li><a href="#"><img loading="lazy" width="50" height="50" src="{{ asset($product->thumb3) }}"></a></li>@endif
								</ul>
							</div>

							<div class="product-item-action">
								<button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add">❤</button>
								<button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button">👁</button>
								<form method="POST" action="{{ route('cart.add') }}">
									@csrf
									<input type="hidden" value="{{ $product->id }}" name="product_id" />
									<input type="hidden" value="1" name="quantity" />
									<button type="submit" title="Thêm vào giỏ" class="shop-addLoop-button">🛒</button>
								</form>
							</div>

							<div class="product-item-detail">
								<h3 class="product-item-detail-name">
									<a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">{{ $product->name }}</a>
								</h3>
								<div class="product-item-detail-price">
									<span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
									@if($product->original_price)
										<del>{{ number_format($product->original_price, 0, ',', '.') }}₫</del>
									@endif
								</div>
								<div class="product-item-detail-info">
									<div class="product-item-detail-info-data">
										@if($product->is_new)<span class="product-item-detail-info-tag">new</span>@endif
										@if($product->is_freeship)<span class="product-item-detail-info-tag">freeship</span>@endif
										@if($product->is_hot)<span class="product-item-detail-info-tag">hot</span>@endif
									</div>
									<div class="sapo-product-reviews-badge" data-id="{{ $product->id }}"></div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

</main>
=======
>>>>>>> feature/order-cancellation
@include('Frontend.partials.footer')
@include('Frontend.partials.scrip')

<<<<<<< HEAD
<script>

    let colorId = null;
    let sizeId = null;

    document.querySelectorAll('[data-color-id]').forEach(el => {
        el.addEventListener('click', () => {
            colorId = el.getAttribute('data-color-id');
            fetchVariant();
        });
    });

    document.querySelectorAll('[data-size-id]').forEach(el => {
        el.addEventListener('click', () => {
            sizeId = el.getAttribute('data-size-id');
            fetchVariant();
        });
    });

    function fetchVariant() {
        const productId = document.getElementById('product_id').value;
        if (colorId && sizeId) {
            fetch('{{ route("product.getVariant") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('variant-price').innerText = data.variant.price;
                    document.getElementById('variant-stock').innerText = data.variant.stock;
                    document.getElementById('variant-image').src = data.variant.image;
                } else {
                    document.getElementById('variant-price').innerText = 'Không tìm thấy';
                    document.getElementById('variant-stock').innerText = '—';
                    document.getElementById('variant-image').src = '';
                }
            });
        }
    }
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Xử lý sao trong form tĩnh (nếu có)
		const staticStars = document.querySelectorAll('.star-item');
		const staticRatingInput = document.getElementById('selected-rating');
		if (staticStars.length && staticRatingInput) {
			let selectedRating = staticRatingInput.value || 5;

			function updateStaticStars(rating) {
				staticStars.forEach(s => {
					s.style.color = '#ddd';
					if (parseInt(s.getAttribute('data-rating')) <= rating) {
						s.style.color = '#ffc107';
					}
				});
			}

			staticStars.forEach(star => {
				star.addEventListener('click', function () {
					selectedRating = this.getAttribute('data-rating');
					staticRatingInput.value = selectedRating;
					updateStaticStars(selectedRating);
				});
			});

			updateStaticStars(selectedRating);
		}
	});
</script>

<script>
	function openReviewModal(review = null) {
		const form = document.getElementById('review-form');
		const methodInput = document.getElementById('review-method');
		const commentInput = document.getElementById('review_comment');
		const ratingInput = document.getElementById('review_rate');
		const modalTitle = document.getElementById('review-modal-title');
		const modal = document.getElementById('popup-bpr-form');

		if (review) {
			form.action = '/reviews/' + review.id;
			methodInput.value = 'PUT';
			commentInput.value = review.comment;
			ratingInput.value = review.rating;
			modalTitle.innerText = 'Chỉnh sửa đánh giá';
			updateModalStars(review.rating);
		} else {
			form.action = '{{ route('reviews.store', $product->id) }}';
			methodInput.value = 'POST';
			commentInput.value = '';
			ratingInput.value = 5;
			modalTitle.innerText = 'Gửi đánh giá';
			updateModalStars(5);
		}

		// Chỉ sử dụng một cách để hiển thị modal
		modal.style.display = 'flex';
		modal.classList.add('modal-active');
		document.body.style.overflow = 'hidden';
	}

	function closeReviewModal() {
		const modal = document.getElementById('popup-bpr-form');
		modal.style.display = 'none';
		modal.classList.remove('modal-active');
		document.body.style.overflow = '';
	}

	// Cập nhật event listener cho nút đóng
	document.addEventListener('DOMContentLoaded', function() {
		const closeButton = document.querySelector('.close-modal');
		if (closeButton) {
			closeButton.onclick = function(e) {
				e.preventDefault();
				closeReviewModal();
				return false;
			};
		}
	});
		function selectRating(rating) {
			document.getElementById('review_rate').value = rating;
			updateModalStars(rating);
		}

		function updateModalStars(rating) {
			document.querySelectorAll('#dvRating i').forEach((star, index) => {
				star.className = (index < rating) ? 'star-on-png' : 'star-off-png';
			});
		}

		function filterReviews(score) {
			document.querySelectorAll('.sapo-review').forEach(el => {
				if (score === 'all' || el.classList.contains('review-rating-' + score)) {
					el.style.display = 'block';
				} else {
					el.style.display = 'none';
				}
			});
		}

		// Close modal when clicking outside of it
		document.addEventListener('DOMContentLoaded', function() {
		// Đảm bảo nút đóng hoạt động
		const closeButtons = document.querySelectorAll('.close-modal');
		closeButtons.forEach(button => {
			button.addEventListener('click', function(e) {
				e.preventDefault();
				closeReviewModal();
			});
		});

		// Đóng modal khi click bên ngoài
		const modal = document.getElementById('popup-bpr-form');
		if (modal) {
			modal.addEventListener('click', function(e) {
				if (e.target === this) {
					closeReviewModal();
				}
			});
		}

		// Đóng modal khi nhấn ESC
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && modal && modal.classList.contains('modal-active')) {
				closeReviewModal();
			}
		});
	});
</script>



</body>


</html>
=======
</body>
</html>
>>>>>>> feature/order-cancellation
