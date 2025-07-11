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
/* Product Detail Styles */
.main-product {
    padding: 40px 0;
}

.product-title {
    font-size: 28px;
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

.color-option:hover, .size-option:hover,
.color-option.active, .size-option.active {
    border-color: #007bff;
    background-color: #007bff;
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

@include('Frontend.partials.footer')
@include('Frontend.partials.scrip')

</body>
</html>