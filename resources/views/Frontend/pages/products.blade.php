<!doctype html>
<html class="no-js" lang="vi">

<!-- Mirrored from f1genz-shoes.mysapo.net/converse-all by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Apr 2025 10:00:07 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
	@include('Frontend.partials.head')
	<style>
		.main-collection-breadcrumb *,
		.main-collection-breadcrumb *:after,
		.main-collection-breadcrumb *:before {
			color: #333333 !important;
		}
		
		/* Styles cho search result info */
		.search-result-info {
			margin: 20px 0 30px 0;
			padding: 0;
		}
		
		.search-result-count {
			font-size: 16px;
			color: #ff6b35;
			font-weight: 500;
			display: flex;
			align-items: center;
		}
		
		.search-result-count .fa {
			color: #ff6b35;
			margin-right: 8px;
			font-size: 18px;
		}
		
		.search-result-count strong {
			color: #ff6b35;
			font-weight: 600;
		}
	</style>
	<link rel="preload stylesheet" as="style"
		href="{{asset('css/collection.scsse889.css')}}">

	<link rel="preload"
		href="{{asset('images/shop_logo_imagee889.png')}}"
		as="image">

	<link rel="preload" fetchpriority="high"
		href="{{asset('images/main_collection_breadcrumb_bge889.jpg')}}"
		as="image">
	<!-- PRODUCT -->

</head>

<body class="">
	@include('Frontend.partials.header')

	<main class="main-layout">
		<div class="main-collection" data-id="3229426">
			<div title="CONVERSE ALL" class="main-collection-breadcrumb lazyload" data-bg="//bizweb.dktcdn.net/100/493/370/themes/940719/assets/main_collection_breadcrumb_bg.jpg?1713464283843">
				<div class="container">
					<div class="section-title-all">
						<h1>Tất cả sản phẩm</h1>
					</div>
					<div class="breadcrumb-wrap">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="index.html" aria-label="Trang chủ" title="Trang chủ">Trang chủ</a></li>


							<li class="breadcrumb-item active"><span>Tất cả sản phẩm</span></li>
						</ol>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="main-collection-wrap vertical">
					<div class="main-collection-left">
						<form method="GET" action="{{ route('products.all') }}" id="product-filter-form">
							<div class="shop-filter-wrap shop-filter-mobile">
								<div class="head-for-mobile">
									<strong>Bộ lọc</strong>
									<button type="button" data-type="close-filter-mobile" title="Đóng">✕</button>
								</div>

								<div class="shop-filter-choose">
									<label>
										Bạn chọn:
										<button type="submit" title="Bỏ hết" onclick="window.location.href='{{ route('products.all') }}'; return false;">
											Bỏ hết
										</button>
									</label>
								</div>

								{{-- Thương hiệu --}}
								<div class="shop-filter" data-type="vendor">
									<h4>Thương hiệu sản phẩm</h4>
									<div class="shop-filter-list">
										@foreach($brands as $brand)
										<div class="shop-filter-item">
											<input
												type="checkbox"
												name="brand[]"
												id="brand-{{ $brand->id }}"
												value="{{ $brand->id }}"
												{{ in_array($brand->id, request()->input('brand', [])) ? 'checked' : '' }}>
											<label for="brand-{{ $brand->id }}">{{ $brand->name }}</label>
										</div>
										@endforeach
									</div>
								</div>

								{{-- Loại sản phẩm --}}
								<div class="shop-filter" data-type="type">
									<h4>Loại sản phẩm</h4>
									<div class="shop-filter-list">
										@foreach($categories as $category)
										<div class="shop-filter-item">
											<input
												type="checkbox"
												name="category[]"
												id="category-{{ $category->id }}"
												value="{{ $category->id }}"
												{{ in_array($category->id, request()->input('category', [])) ? 'checked' : '' }}>
											<label for="category-{{ $category->id }}">{{ $category->name }}</label>
										</div>
										@endforeach
									</div>
								</div>

								{{-- Kích thước --}}
								<div class="shop-filter" data-type="variant1">
									<h4>Kích thước</h4>
									<div class="shop-filter-list">
										@foreach($sizes as $size)
										<div class="shop-filter-item">
											<input
												type="checkbox"
												name="size[]"
												id="size-{{ $size->id }}"
												value="{{ $size->value }}"
												{{ in_array($size->value, request()->input('size', [])) ? 'checked' : '' }}>
											<label for="size-{{ $size->id }}">{{ $size->value }}</label>
										</div>
										@endforeach
									</div>
								</div>

								{{-- Màu sắc --}}
								<div class="shop-filter" data-type="variant3">
									<h4>Màu sắc</h4>
									<div class="shop-filter-list color">
										@foreach($colors as $color)
										<div class="shop-filter-item color {{ Str::slug($color->value) }}">
											<input
												type="checkbox"
												name="color[]"
												id="color-{{ $color->id }}"
												value="{{ $color->value }}"
												{{ in_array($color->value, request()->input('color', [])) ? 'checked' : '' }}>
											<label for="color-{{ $color->id }}">{{ $color->value }}</label>
										</div>
										@endforeach
									</div>
								</div>

								{{-- Giá --}}
								<div class="shop-filter" data-type="price">
									<h4>Giá sản phẩm</h4>
									<div class="shop-filter-list">
										@php
										$priceOptions = [
										'<1000000'=> 'Dưới 1.000.000₫',
											'>=1000000<=3000000'=> 'Từ 1.000.000₫ - 3.000.000₫',
												'>=3000000<=5000000'=> 'Từ 3.000.000₫ - 5.000.000₫',
													'>=5000000<=10000000'=> 'Từ 5.000.000₫ - 10.000.000₫',
														'>10000000' => 'Trên 10.000.000₫',
														];
														@endphp
														@foreach($priceOptions as $value => $label)
														<div class="shop-filter-item">
															<input
																type="checkbox"
																name="price[]"
																id="price-{{ md5($value) }}"
																value="{{ $value }}"
																{{ in_array($value, request()->input('price', [])) ? 'checked' : '' }}>
															<label for="price-{{ md5($value) }}">{{ $label }}</label>
														</div>
														@endforeach
									</div>
								</div>
							</div>
						</form>
					</div>

					<div class="main-collection-right ">
						<div class="main-collection-head">
							<div class="shop-sort-style">
								<strong>Hiển thị</strong>
								<div class="shop-filter-mobile-btn">
									<button type="button" data-type="shop-filter-mobile-btn" title="Bộ lọc">
										<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
											<g>
												<path d="m486.585 243.429-15.502-8.401c-1.179-.639-1.82-1.981-1.596-3.339 1.048-6.346 1.58-12.843 1.58-19.309 0-6.467-.532-12.963-1.58-19.308-.225-1.359.417-2.701 1.596-3.34l15.502-8.4c4.266-2.311 7.376-6.145 8.757-10.796 1.382-4.65.87-9.561-1.441-13.825l-17.226-31.788c-4.772-8.804-15.817-12.085-24.621-7.314l-15.518 8.409c-1.178.64-2.641.453-3.637-.461-12.001-11.015-25.858-19.283-41.188-24.576-1.341-.463-2.242-1.679-2.242-3.025v-17.615c0-10.015-8.148-18.162-18.162-18.162h-36.154c-10.014 0-18.162 8.147-18.162 18.162v17.615c0 1.346-.901 2.562-2.241 3.025-15.331 5.293-29.189 13.562-41.188 24.576-.997.915-2.459 1.1-3.638.461l-15.518-8.41c-8.805-4.771-19.849-1.488-24.621 7.316l-17.225 31.787c-2.311 4.265-2.823 9.175-1.441 13.825.563 1.896 1.427 3.646 2.525 5.222h-95.46c-4.143 0-7.502 3.358-7.502 7.502 0 4.143 3.359 7.502 7.502 7.502h237.64c.436 0 .791.355.791.791v42.447h-325.714v-42.446c0-.437.355-.791.791-.791h52.484c4.143 0 7.502-3.358 7.502-7.502 0-4.143-3.359-7.502-7.502-7.502h-52.484c-8.709 0-15.794 7.085-15.794 15.794v49.948c0 .053.007.104.008.156.002.085.008.168.013.253.014.267.042.531.084.79.01.062.017.124.028.185.061.325.141.642.242.95.013.041.03.081.044.121.097.279.21.55.338.812.026.055.051.11.079.164.15.291.316.571.502.839.03.043.064.084.095.127.171.236.356.461.553.675.029.032.051.068.081.099l134.961 141.809c1.399 1.47 2.169 3.397 2.169 5.425v76.002c0 4.577 2.475 8.82 6.457 11.072l51.878 29.35c1.967 1.113 4.118 1.669 6.267 1.668 2.204 0 4.406-.584 6.407-1.75 3.953-2.305 6.313-6.413 6.313-10.99v-36.555c0-4.143-3.359-7.502-7.502-7.502s-7.502 3.358-7.502 7.502v32.643l-47.316-26.769v-74.671c0-5.896-2.239-11.496-6.305-15.768l-122.898-129.135h305.726l-15.143 15.912c-.015.016-.03.032-.045.048l-107.713 113.178c-4.065 4.271-6.304 9.871-6.304 15.767v33.79c0 4.143 3.359 7.502 7.502 7.502s7.502-3.358 7.502-7.502v-33.79c0-2.029.77-3.955 2.169-5.424l66.857-70.25c4.322 2.116 8.773 3.983 13.304 5.547 1.341.463 2.242 1.679 2.242 3.025v17.615c0 10.015 8.148 18.162 18.162 18.162h36.154c10.014 0 18.162-8.147 18.162-18.162v-17.615c0-1.346.901-2.562 2.242-3.025 15.332-5.294 29.19-13.562 41.188-24.576.998-.914 2.459-1.098 3.638-.461l15.518 8.41c8.804 4.771 19.849 1.489 24.621-7.316l17.224-31.788c2.311-4.265 2.823-9.175 1.441-13.825-1.381-4.652-4.491-8.485-8.756-10.796zm-5.876 17.473-17.225 31.786c-.83 1.532-2.75 2.103-4.283 1.274l-15.516-8.409c-6.806-3.688-15.218-2.646-20.932 2.598-10.473 9.614-22.565 16.831-35.939 21.449-7.386 2.55-12.348 9.465-12.348 17.206v17.615c0 1.742-1.417 3.159-3.159 3.159h-36.154c-1.742 0-3.159-1.417-3.159-3.159v-17.615c0-7.741-4.962-14.655-12.349-17.207-2.456-.848-4.881-1.809-7.274-2.846l26.897-28.262c4.571.961 9.249 1.446 13.962 1.446 11.949 0 23.695-3.164 33.968-9.148 3.579-2.085 4.791-6.678 2.705-10.258s-6.678-4.788-10.259-2.706c-7.982 4.65-17.115 7.109-26.414 7.109-.348 0-.695-.011-1.043-.018l17.362-18.243c.03-.031.052-.067.081-.099.197-.214.382-.439.553-.675.031-.043.065-.084.095-.127.186-.267.352-.548.502-.839.028-.054.052-.109.079-.164.128-.263.241-.533.338-.812.014-.041.031-.08.044-.121.101-.308.182-.625.242-.95.012-.061.018-.123.028-.185.042-.259.07-.523.084-.79.005-.084.011-.168.013-.253.001-.053.008-.104.008-.156v-49.948c0-8.709-7.085-15.794-15.794-15.794h-40.281c9.773-10.043 23.314-15.931 37.688-15.931 28.978 0 52.554 23.575 52.554 52.553 0 8.256-1.857 16.154-5.52 23.476-1.853 3.705-.353 8.212 3.352 10.065 1.078.539 2.223.795 3.351.795 2.751-.001 5.4-1.52 6.715-4.147 4.715-9.424 7.105-19.58 7.105-30.188 0-37.251-30.306-67.556-67.557-67.556-23.022 0-44.383 11.746-56.777 30.934h-55.375l-14.056-7.618c-1.001-.542-1.383-1.409-1.522-1.876-.139-.469-.292-1.404.251-2.405l17.225-31.786c.83-1.532 2.752-2.102 4.283-1.274l15.516 8.409c6.807 3.689 15.219 2.647 20.932-2.598 10.474-9.614 22.566-16.831 35.94-21.449 7.386-2.549 12.348-9.465 12.348-17.206v-17.617c0-1.742 1.417-3.159 3.159-3.159h36.154c1.742 0 3.159 1.417 3.159 3.159v17.615c0 7.741 4.962 14.655 12.348 17.206 13.373 4.618 25.465 11.835 35.94 21.449 5.712 5.244 14.124 6.287 20.931 2.598l15.517-8.408c1.532-.831 3.453-.26 4.283 1.272l17.225 31.787c.543 1.001.39 1.936.251 2.405-.139.468-.522 1.334-1.523 1.877l-15.503 8.401c-6.799 3.684-10.516 11.31-9.25 18.976.915 5.539 1.379 11.212 1.379 16.862s-.464 11.323-1.38 16.863c-1.266 7.665 2.451 15.29 9.25 18.975l15.503 8.402c1.001.542 1.383 1.409 1.522 1.876.14.469.293 1.404-.25 2.405z" fill="#000000" data-original="#000000" class=""></path>
												<path d="m23.399 75.926c4.143 0 7.502-3.358 7.502-7.502v-33.162c0-4.143-3.359-7.502-7.502-7.502s-7.502 3.358-7.502 7.502v33.162c.001 4.144 3.359 7.502 7.502 7.502z" fill="#000000" data-original="#000000" class=""></path>
												<path d="m148.977 154.757c4.143 0 7.502-3.358 7.502-7.502v-33.163c0-4.143-3.359-7.502-7.502-7.502s-7.502 3.358-7.502 7.502v33.163c0 4.144 3.359 7.502 7.502 7.502z" fill="#000000" data-original="#000000" class=""></path>
												<path d="m117.03 48.165c4.143 0 7.502-3.358 7.502-7.502v-33.161c0-4.143-3.359-7.502-7.502-7.502s-7.502 3.358-7.502 7.502v33.162c0 4.143 3.359 7.501 7.502 7.501z" fill="#000000" data-original="#000000" class=""></path>
												<path d="m269.664 64.747c4.143 0 7.502-3.358 7.502-7.502v-33.162c0-4.143-3.359-7.502-7.502-7.502s-7.502 3.358-7.502 7.502v33.162c.001 4.144 3.359 7.502 7.502 7.502z" fill="#000000" data-original="#000000" class=""></path>
												<path d="m82.593 119.291c14.073 0 25.522-11.449 25.522-25.521s-11.449-25.521-25.522-25.521c-14.072 0-25.521 11.449-25.521 25.521s11.449 25.521 25.521 25.521zm0-36.039c5.8 0 10.518 4.718 10.518 10.518s-4.718 10.518-10.518 10.518-10.518-4.718-10.518-10.518 4.719-10.518 10.518-10.518z" fill="#000000" data-original="#000000" class=""></path>
												<path d="m198.079 99.711c14.072 0 25.521-11.449 25.521-25.521 0-14.073-11.449-25.522-25.521-25.522-14.073 0-25.522 11.449-25.522 25.522.001 14.072 11.45 25.521 25.522 25.521zm0-36.04c5.8 0 10.518 4.719 10.518 10.519s-4.718 10.518-10.518 10.518-10.518-4.718-10.518-10.518 4.718-10.519 10.518-10.519z" fill="#000000" data-original="#000000" class=""></path>
											</g>
										</svg>
									</button>
								</div>
								<div class="shop-sort-item" data-show="two"></div>
								<div class="shop-sort-item" data-show="three"></div>
								<div class="shop-sort-item" data-show="four"></div>
							</div>
							<form method="GET" action="{{ route('products.all') }}" class="shop-sort-by">
								<label for="sort">Sắp xếp theo</label>
								<select name="sort" id="sort" onchange="this.form.submit()">
									<option value="">Mặc định</option>
									<option value="name:asc" {{ request('sort') == 'name:asc' ? 'selected' : '' }}>A &rarr; Z</option>
									<option value="name:desc" {{ request('sort') == 'name:desc' ? 'selected' : '' }}>Z &rarr; A</option>
									<option value="price:asc" {{ request('sort') == 'price:asc' ? 'selected' : '' }}>Giá tăng dần</option>
									<option value="price:desc" {{ request('sort') == 'price:desc' ? 'selected' : '' }}>Giá giảm dần</option>
									<option value="created_at:desc" {{ request('sort') == 'created_at:desc' ? 'selected' : '' }}>Hàng mới nhất</option>
									<option value="created_at:asc" {{ request('sort') == 'created_at:asc' ? 'selected' : '' }}>Hàng cũ nhất</option>
								</select>
							</form>
						</div>

						<!-- Hiển thị kết quả tìm kiếm -->
						@if(isset($searchTerm) && !empty($searchTerm))
						<div class="search-result-info">
							<div class="search-result-count">
								<span class="fa fa-exclamation-triangle" aria-hidden="true"></span>
								Có {{ $products->total() }} kết quả tìm kiếm cho '<strong>{{ $searchTerm }}</strong>'.
							</div>
						</div>
						@endif

						<!-- Hiển thị sản phẩm -->
						<div class="main-collection-data four">
							@foreach($products as $product)
							<div class="product-item" data-id="{{ $product->id }}" data-handle="{{ $product->slug }}">
								<div class="product-item-wrap">
									<div class="product-item-image hasThumbs hasThumbsIcon">
										<div class="sapo-buyxgety-badge" data-id="{{ $product->id }}"></div>
										@if($product->discount_percent)
										<span class="product-item-discount">-{{ $product->discount_percent }}%</span>
										@endif
										<a class="product-item-link" href="{{ route('product.show', $product->id) }}"
											aria-label="{{ $product->name }}" title="{{ $product->name }}">
											<img class="w-auto" loading="lazy" width="480" height="480"
												src="{{ asset($product->image) }}"
												alt="{{ $product->name }}" title="{{ $product->name }}">
											@if($product->images->first())
											<img class="w-auto" loading="lazy" width="480" height="480"
												src="{{ asset($product->images->first()->image_path) }}"
												alt="{{ $product->name }}" title="{{ $product->name }}">
											@endif
										</a>
										@if($product->images->count())
										<ul class="product-item-thumbs">
											@foreach($product->images->take(3) as $image)
											<li>
												<a href="{{ route('product.show', $product->id) }}" aria-label="{{ $product->name }}">
													<img class="w-auto" loading="lazy" decoding="async" width="50" height="50"
														title="{{ $product->name }}"
														src="{{ asset($image->image_path) }}"
														alt="{{ $product->name }}">
												</a>
											</li>
											@endforeach
										</ul>
										@endif
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
											<a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">
												{{ $product->name }}
											</a>
										</h3>
										<div class="product-item-detail-price">
											<span>{{ number_format($product->price) }}₫</span>
											@if($product->original_price && $product->original_price > $product->price)
											<del>{{ number_format($product->original_price) }}₫</del>
											@endif
										</div>
										<div class="product-item-detail-info">
											<div class="product-item-detail-info-data">
												<span class="product-item-detail-info-tag">freeship</span>
												<span class="product-item-detail-info-tag">new</span>
											</div>
											<div class="sapo-product-reviews-badge" data-id="{{ $product->id }}"></div>
										</div>
									</div>
								</div>
							</div>
							@endforeach



							@if ($products->hasPages())
								<div class="shop-pagination">
									{{-- Nút Previous --}}
									@if ($products->onFirstPage())
										<span class="disabled" aria-disabled="true" aria-label="Trang trước">
											&laquo;
										</span>
									@else
										<a href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="Trang trước">
											&laquo;
										</a>
									@endif

									{{-- Các trang --}}
									@foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
										@if ($page == $products->currentPage())
											<span class="current">{{ $page }}</span>
										@else
											<a href="{{ $url }}" aria-label="Trang {{ $page }}">{{ $page }}</a>
										@endif
									@endforeach

									{{-- Nút Next --}}
									@if ($products->hasMorePages())
										<a href="{{ $products->nextPageUrl() }}" rel="next" aria-label="Trang sau">
											&raquo;
										</a>
									@else
										<span class="disabled" aria-disabled="true" aria-label="Trang sau">
											&raquo;
										</span>
									@endif
								</div>
							@endif

						</div>
						<!-- Hết hiển thị sản phẩm -->

					</div>
				</div>
			</div>
		</div>
	</main>
	@include('Frontend.partials.footer')

	@include('Frontend.partials.modal')
	<script>
		$("body").removeClass("preload");
		document.addEventListener('lazybeforeunveil', function(e) {
			var bg = e.target.getAttribute('data-bg');
			if (bg) e.target.style.backgroundImage = 'url(' + bg + ')';
		});
		if (window.noPS) {
			window.addEventListener("load", (event) => {
				if ($('input[name="Token"]').length > 0) {
					$.getScript('../www.google.com/recaptcha/apif78f.js?render=6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK').done(function(s, r) {
						$('head').append(s);
						$('input[name="Token"]').each(function() {
							var flagId = $(this).attr('id');
							grecaptcha.ready(function() {
								grecaptcha.execute('6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK', {
										action: 'submit'
									})
									.then(function(token) {
										document.getElementById(flagId).value = token;
									});
							});
						})
					});
				}

				$('img[loading="lazy"]').each(function() {
					$(this).removeAttr('loading');
				})
			});
		} else {
			// Jquery touch
			jQuery.event.special.touchstart = {
				setup: function(e, t, n) {
					this.addEventListener("touchstart", n, {
						passive: !t.includes("noPreventDefault")
					})
				}
			}, jQuery.event.special.touchmove = {
				setup: function(e, t, n) {
					this.addEventListener("touchmove", n, {
						passive: !t.includes("noPreventDefault")
					})
				}
			};
		}
	</script> <button class="overplay-all" title="Đóng"></button>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const checkboxes = document.querySelectorAll('#product-filter-form input[type="checkbox"]');
			checkboxes.forEach(function(checkbox) {
				checkbox.addEventListener('change', function() {
					document.getElementById('product-filter-form').submit();
				});
			});
		});
	</script>


</body>

</html>