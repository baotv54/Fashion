<!doctype html>
<html class="no-js" lang="vi">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
	@include('Frontend.partials.head')
	<style>
		.main-cart-breadcrumb {
			background-image: url("{{asset('images/main_cart_breadcrumb_bge889.jpg')}}")
		}

		.main-cart-breadcrumb * {
			color: #333333 !important;
		}
	</style>
	<style>
		.variant-modal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.8);
			z-index: 9999;
			align-items: center;
			justify-content: center;
		}

		.variant-modal.show {
			display: flex;
		}

		.variant-modal-content {
			background: white;
			border-radius: 12px;
			max-width: 900px;
			width: 90%;
			max-height: 90vh;
			overflow-y: auto;
			position: relative;
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
		}

		.variant-modal-close {
			position: absolute;
			top: 15px;
			right: 20px;
			background: none;
			border: none;
			font-size: 24px;
			cursor: pointer;
			z-index: 10;
			color: #666;
			width: 32px;
			height: 32px;
			display: flex;
			align-items: center;
			justify-content: center;
			border-radius: 50%;
			transition: all 0.3s ease;
		}

		.variant-modal-close:hover {
			background: #f0f0f0;
			color: #333;
		}

		.variant-popup-body {
			display: flex;
			min-height: 500px;
		}

		.variant-popup-left {
			flex: 1;
			padding: 30px;
			background: #f8f9fa;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.variant-popup-right {
			flex: 1;
			padding: 30px;
		}

		.variant-image-container {
			max-width: 100%;
			text-align: center;
		}

		.variant-image-slider {
			position: relative;
		}

		.main-image-link {
			display: block;
			text-decoration: none;
		}

		.main-image-link img {
			max-width: 100%;
			height: auto;
			border-radius: 8px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			transition: transform 0.3s ease;
		}

		.main-image-link:hover img {
			transform: scale(1.05);
		}

		.variant-popup-title {
			font-size: 24px;
			font-weight: 600;
			color: #333;
			margin-bottom: 15px;
			line-height: 1.3;
		}

		.variant-popup-info {
			margin-bottom: 20px;
		}

		.variant-popup-info-item {
			display: flex;
			align-items: center;
			margin-bottom: 8px;
			font-size: 14px;
		}

		.variant-popup-info-item strong {
			min-width: 120px;
			color: #666;
			font-weight: 500;
		}

		.variant-popup-info-item span {
			color: #333;
		}

		.variant-popup-price {
			margin-bottom: 25px;
		}

		.price-wrapper {
			display: flex;
			align-items: center;
			gap: 12px;
			flex-wrap: wrap;
		}

		.price-current {
			font-size: 24px;
			font-weight: 700;
			color: #e74c3c;
		}

		.price-compare {
			font-size: 16px;
			color: #999;
			text-decoration: line-through;
		}

		.price-discount {
			background: #e74c3c;
			color: white;
			padding: 4px 8px;
			border-radius: 4px;
			font-size: 12px;
			font-weight: 600;
		}

		.main-product-swatch {
			margin-bottom: 25px;
		}

		.product-sw-line {
			margin-bottom: 20px;
		}

		.product-sw-title {
			font-size: 16px;
			font-weight: 600;
			color: #333;
			margin-bottom: 12px;
		}

		.product-sw-select {
			display: flex;
			flex-wrap: wrap;
			gap: 10px;
		}

		.product-sw-select-item {
			position: relative;
		}

		.product-sw-select-item input[type="radio"] {
			display: none;
		}

		.product-sw-select-item-span {
			display: inline-block;
			padding: 10px 16px;
			border: 2px solid #ddd;
			border-radius: 6px;
			cursor: pointer;
			transition: all 0.3s ease;
			background: white;
			color: #333;
			font-weight: 500;
			min-width: 45px;
			text-align: center;
		}

		.product-sw-select-item-span:hover {
			border-color: #333;
			background: #f8f9fa;
		}



		.variant-popup-buttons {
			display: flex;
			gap: 12px;
			margin-top: 30px;
		}

		.btn-primary {
			background: #333;
			border: 2px solid #333;
			color: white;
			padding: 12px 24px;
			border-radius: 6px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			flex: 1;
		}

		.btn-primary:hover {
			background: white;
			color: #333;
		}

		.btn-secondary {
			background: white;
			border: 2px solid #ddd;
			color: #666;
			padding: 12px 24px;
			border-radius: 6px;
			font-weight: 600;
			cursor: pointer;
			transition: all 0.3s ease;
			flex: 1;
		}

		.btn-secondary:hover {
			border-color: #333;
			color: #333;
		}

		@media (max-width: 768px) {
			.variant-popup-body {
				flex-direction: column;
			}

			.variant-popup-left,
			.variant-popup-right {
				flex: none;
				padding: 20px;
			}

			.variant-popup-title {
				font-size: 20px;
			}

			.price-current {
				font-size: 20px;
			}

			.variant-popup-buttons {
				flex-direction: column;
			}
		}

		.loading-overlay {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(255, 255, 255, 0.9);
			display: none;
			align-items: center;
			justify-content: center;
			z-index: 10;
		}

		.loading-spinner {
			width: 40px;
			height: 40px;
			border: 4px solid #f3f3f3;
			border-top: 4px solid #333;
			border-radius: 50%;
			animation: spin 1s linear infinite;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>
	<link rel="preload stylesheet" as="style"
		href="{{asset('css/cart.scsse889.css')}}">
	<script fetchpriority="low" defer

		src="{{asset('js/carte889.js')}}"></script>

</head>

<body class="">
	@include('Frontend.partials.header')
	<main class="main-layout">
		<div class="main-cart">
			<div class="main-cart-breadcrumb" title="Giỏ hàng">
				<div class="container">
					<div class="section-title-all">
						<h1>Giỏ hàng</h1>
					</div>
					<div class="breadcrumb-wrap">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="/home" aria-label="Trang chủ" title="Trang chủ">Trang chủ</a></li>

							<li class="breadcrumb-item active"><span>Giỏ hàng</span></li>
						</ol>
					</div>
				</div>
			</div>
			@if ($carts->count() > 0)
			<div class="main-cart-wrap">
				<div class="container">
					<div class="main-cart-data">
						<div class="section-title-all">
							<span>Giỏ hàng của bạn</span>
							<p>Bạn đang có <strong>{{$carts->count()}}</strong> sản phẩm trong giỏ hàng</p>
						</div>
						<div class="main-cart-data-full">
							<div class="main-cart-data-full-list">
								@foreach ($carts as $cart)
								<div class="main-cart-data-full-item" data-id="{{ $cart->rowId }}">
									<div class="main-cart-data-full-item-image">
										<a href="#">
											<img title="{{ $cart->name }}" src="{{ $cart->options->image }}" alt="{{ $cart->name }}" />
										</a>
									</div>
									<div class="main-cart-data-full-item-info">
										<h3 class="main-cart-data-full-item-info-title"><a href="#" title="{{ $cart->name }}">{{ $cart->name }}</a></h3>
										@if ($cart->options->has('variant_attributes') && is_array($cart->options->variant_attributes))
										<div class="cart-item-attributes" style="font-size: 14px; color: #666;">
											Biến thể:
											{{ implode(', ', array_map(function ($key, $value) {
                    return "$key: $value";
                }, array_keys($cart->options->variant_attributes), $cart->options->variant_attributes)) }}
											<!-- Button to open variant selection popup -->
											<a href="#" class="update-variant-btn" data-row-id="{{ $cart->rowId }}" data-product-id="{{ $cart->options->product_id }}" title="Thay đổi biến thể">Thay đổi</a>
										</div>
										@endif

										<div class="main-cart-data-full-item-info-price">
											<label>Giá: </label>
											{{ number_format($cart->price, 0, ',', '.') }}₫
										</div>

										<div class="main-cart-data-full-item-info-quantity shop-quantity-wrap">
											<label>Số lượng</label>
											<div class="shop-quantity">
												<button type="button" data-type="shop-quantity-minus" title="Giảm">-</button>
												<input type="number" name="quantity_{{ $cart->rowId }}" value="{{ $cart->qty }}" min="1" readonly>
												<button type="button" data-type="shop-quantity-plus" title="Tăng">+</button>
											</div>
										</div>

										<div class="main-cart-data-full-item-info-total">
											<label>Thành tiền: </label>
											<span>{{ number_format($cart->price * $cart->qty, 0, ',', '.') }}₫</span>
										</div>
										<div class="main-cart-data-full-item-action">
											<a href="{{ route('cart.remove', ['rowId' => $cart->rowId]) }}" title="Xóa sản phẩm">
												<svg version="1.1" x="0px" y="0px" viewBox="0 0 325.284 325.284" style="enable-background:new 0 0 325.284 325.284;" xml:space="preserve">
													<g>
														<path d="M289.782,63.456H35.502c-7.04,0-12.768,5.732-12.768,12.768s5.732,12.768,12.768,12.768h2.828l25.856,206.644 c0,16.348,13.3,29.648,29.648,29.648h137.62c16.348,0,29.648-13.3,29.616-29.192l25.888-207.1h2.824 c7.04,0,12.768-5.732,12.768-12.768S296.822,63.456,289.782,63.456z M253.738,295.64c0,12.288-9.996,22.284-22.284,22.284H93.834 c-12.288,0-22.284-9.996-22.316-22.74L45.742,88.996h233.796L253.738,295.64z M289.782,81.632H35.502 c-2.98,0-5.404-2.424-5.404-5.404c0-2.98,2.424-5.404,5.404-5.404h254.28c2.98,0,5.404,2.424,5.404,5.404 C295.186,79.208,292.762,81.632,289.782,81.632z" />
														<path d="M91.67,110.828c5.976,0,10.836,4.512,10.848,10.312l15.568,162.288c0,5.556-4.864,10.068-10.836,10.068 c-2.4,0-4.716-0.772-6.688-2.232c-1.148-0.86-2.76-0.616-3.6,0.536c-0.848,1.14-0.608,2.756,0.536,3.6 c2.864,2.128,6.236,3.244,9.752,3.244c8.82,0,15.992-6.824,15.98-15.46l-15.568-162.288c0-8.392-7.172-15.22-15.992-15.22 c-1.424,0-2.576,1.152-2.576,2.58C89.094,109.676,90.246,110.828,91.67,110.828z" />
														<path d="M95.254,259.668c0.072,0,0.14-0.004,0.216-0.012c1.42-0.112,2.476-1.352,2.356-2.776l-7.976-98.652 c-0.112-1.42-1.4-2.448-2.776-2.356c-1.42,0.112-2.476,1.352-2.36,2.772l7.98,98.652 C92.798,258.648,93.926,259.668,95.254,259.668z" />
														<path d="M176.058,177.516c-1.424,0-2.576,1.152-2.576,2.576v103.336c0,5.556-4.864,10.068-10.84,10.068 c-2.4,0-4.72-0.772-6.692-2.232c-1.14-0.856-2.76-0.612-3.6,0.54c-0.848,1.14-0.608,2.752,0.54,3.6 c2.864,2.124,6.24,3.24,9.752,3.24c8.82,0,15.992-6.824,15.992-15.22V180.088C178.634,178.664,177.482,177.516,176.058,177.516z" />
														<path d="M154.418,254.94c1.424,0,2.576-1.152,2.576-2.576V112.368c1.724-1.008,3.656-1.54,5.652-1.54 c5.976,0,10.836,4.512,10.836,10.064v25.44c0,1.428,1.152,2.576,2.58,2.576c1.424,0,2.576-1.148,2.576-2.576v-25.44 c0-8.392-7.172-15.22-15.992-15.22c-3.516,0-6.892,1.12-9.76,3.248c-0.656,0.48-1.044,1.252-1.044,2.068v141.376 C151.842,253.788,152.994,254.94,154.418,254.94z" />
														<path d="M219.05,132.444c1.432,0.156,2.636-1.012,2.708-2.436l0.948-17.592c1.744-1.044,3.704-1.588,5.72-1.588 c5.972,0,10.836,4.512,10.844,9.908l-10.392,162.692c0,5.552-4.864,10.064-10.836,10.064c-1.428,0-2.58,1.152-2.58,2.58 c0,1.424,1.152,2.576,2.58,2.576c8.82,0,15.988-6.828,15.984-15.06l10.392-162.692c0-8.392-7.172-15.22-15.992-15.22 c-3.516,0-6.892,1.12-9.76,3.248c-0.616,0.456-1,1.168-1.04,1.932l-1.016,18.88C216.538,131.156,217.63,132.368,219.05,132.444z" />
														<path d="M210.754,275.728c0.052,0.004,0.1,0.004,0.152,0.004c1.356,0,2.488-1.056,2.572-2.424l6.436-109.056 c0.084-1.42-0.996-2.64-2.42-2.724c-1.36-0.092-2.636,1-2.72,2.42l-6.44,109.056 C208.246,274.428,209.334,275.648,210.754,275.728z" />
														<path d="M43.614,56.54c2.032,0,3.684-1.648,3.684-3.684c0-12.288,9.996-22.288,22.284-22.288H255.71 c12.288,0,22.284,9.996,22.284,22.288c0,2.032,1.648,3.684,3.684,3.684c2.036,0,3.684-1.648,3.684-3.684 c0-16.348-13.3-29.648-29.648-29.648h-61.692C194.018,10.408,183.61,0,170.81,0h-16.336c-12.796,0-23.208,10.408-23.212,23.208 H69.578c-16.348,0-29.648,13.3-29.648,29.648C39.93,54.892,41.578,56.54,43.614,56.54z M154.474,7.364h16.336 c8.736,0,15.844,7.108,15.848,15.844h-48.032C138.63,14.472,145.738,7.364,154.474,7.364z" />
														<path d="M258.734,41.384c-1.284-0.608-2.824-0.064-3.432,1.224c-0.608,1.284-0.06,2.82,1.224,3.432 c3.032,1.44,5.016,3.536,6.068,6.4c0.384,1.044,1.372,1.688,2.42,1.688c0.296,0,0.596-0.052,0.888-0.156 c1.34-0.492,2.024-1.972,1.532-3.308C265.91,46.528,262.982,43.404,258.734,41.384z" />
														<path d="M220.206,38.056c-3.748,0.056-7.324,0.112-10.616,0.112c-1.424,0-2.576,1.152-2.576,2.58 c0,1.424,1.152,2.576,2.576,2.576c3.312,0,6.92-0.056,10.692-0.112c8.472-0.124,18.056-0.264,27.016,0.18 c0.044,0.004,0.092,0.004,0.132,0.004c1.364,0,2.504-1.072,2.572-2.444c0.08-1.42-1.02-2.632-2.44-2.704 C238.422,37.784,228.746,37.932,220.206,38.056z" />
													</g>
												</svg>
											</a>
										</div>
									</div>
								</div>
								@endforeach
								<div class="main-cart-data-full-note">
									<label>Ghi chú đơn hàng</label>
									<textarea id="main-cart-data-full-note" name="note" rows="4" placeholder="Nhập thông tin ghi chú của bạn ..."></textarea>
								</div>
							</div>
							<div class="main-cart-data-full-total">
								<h2>Thông tin đơn hàng</h2>
								<div class="main-cart-data-full-total-sub">
									<div class="main-cart-data-full-total-sub-price">
										<label>Tổng tiền:</label>
										<span id="cart-total-price">{{ Cart::subtotal() }}₫</span>
									</div>
									<div class="main-cart-data-full-total-text">Phí vận chuyển sẽ được tính ở trang thanh toán.
										</br>
										Bạn cũng có thể nhập mã giảm giá ở trang thanh toán.</div>
								</div>
								<div class="main-cart-data-full-total-action">
				   <a href="/home" title="Tiếp tục mua hàng">Tiếp tục mua hàng</a>
				   @auth
					   <a href="{{ route('cart.checkout') }}" title="Thanh toán">Thanh toán</a>
				   @else
					   <a href="{{ route('login') }}" title="Đăng nhập để thanh toán">Thanh toán</a>
				   @endauth
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@else
			<div class="main-cart-wrap">
				<div class="container">
					<div class="main-cart-data">
						<div class="main-cart-data-none">
							<div class="section-title-all">
								<h2>Bạn chưa lựa chọn được sản phẩm nào.?</h2>
								<p>Tìm kiếm ngay sản phẩm mà bạn mong muốn với bộ sưu tập rộng lớn của chúng tôi!</p>
								<form action="/search">
									<input type="hidden" name="type" value="product">
									<input type="text" name="q" placeholder="Tìm kiếm sản phẩm" value="">
									<button type="submit" title="Tìm kiếm"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
											<path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
										</svg></button>
								</form>
							</div>
							<span>
								<img width="1666" height="1000" title="Tìm kiếm"
									class="w-100 lazyload"
									src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
									data-src="https://file.hstatic.net/200000584705/file/37578_dae02aa6e03e4230b958e97100__1___1__db746ec851754034b04b27f8690072c7.jpg" alt="Cart none">
							</span>
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
		<div class="sapo-buyxgety-module-cart-v2 container"></div>
		<div class="sapo-buyxgety-module-cart-v2 container"></div>
		<div id="variantModal" class="variant-modal">
			<div class="variant-modal-content">
				<button type="button" class="variant-modal-close" data-dismiss="modal">×</button>

				<div class="loading-overlay">
					<div class="loading-spinner"></div>
				</div>

				<div class="variant-popup-body">
					<div class="variant-popup-left">
						<div class="variant-image-container">
							<div id="variant-image-slider" class="variant-image-slider">
								<!-- Images will be loaded dynamically -->
							</div>
						</div>
					</div>

					<div class="variant-popup-right">
						<h2 id="variant-product-title" class="variant-popup-title">
							Converse Chuck Taylor All Star Mono Leather Low Top
						</h2>

						<div class="variant-popup-info">
							<div class="variant-popup-info-item">
								<strong>Mã sản phẩm:</strong>
								<span id="variant-product-sku">Đang cập nhật</span>
							</div>
							<div class="variant-popup-info-item">
								<strong>Thương hiệu:</strong>
								<span id="variant-product-vendor">Converse</span>
							</div>
							<div class="variant-popup-info-item">
								<strong>Dòng sản phẩm:</strong>
								<span id="variant-product-type">Giày cổ thấp</span>
							</div>
						</div>

						<div class="variant-popup-price">
							<div class="price-wrapper">
								<span id="variant-price" class="price-current">1.900.000₫</span>
								<span id="variant-compare-price" class="price-compare">2.139.000₫</span>
								<span id="variant-discount" class="price-discount">Tiết kiệm 11%</span>
							</div>
						</div>

						<div id="variant-selection-content" class="main-product-swatch">
							<!-- Variant options will be loaded dynamically -->
							<div class="product-sw-line">
								<div class="product-sw-title">Size</div>
								<div class="product-sw-select">
									<span class="product-sw-select-item">
										<input type="radio" name="size" id="size-35" value="35">
										<label for="size-35" class="product-sw-select-item-span">35</label>
									</span>
									<span class="product-sw-select-item">
										<input type="radio" name="size" id="size-36" value="36">
										<label for="size-36" class="product-sw-select-item-span">36</label>
									</span>
									<span class="product-sw-select-item">
										<input type="radio" name="size" id="size-37" value="37">
										<label for="size-37" class="product-sw-select-item-span">37</label>
									</span>
									<span class="product-sw-select-item">
										<input type="radio" name="size" id="size-38" value="38">
										<label for="size-38" class="product-sw-select-item-span">38</label>
									</span>
								</div>
							</div>
						</div>

						<div class="variant-popup-buttons">
							<button type="button" id="update-variant-submit" class="btn-primary">
								Cập nhật biến thể
							</button>
							<button type="button" class="btn-secondary" data-dismiss="modal">
								Hủy
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>

	</main>
	@include('Frontend.partials.footer')

	@include('Frontend.partials.modal')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
			// Lưu trữ dữ liệu mặc định của sản phẩm
			let defaultProductData = {
				price: 0,
				compare_at_price: 0,
				discount: '',
				sku: 'Đang cập nhật'
			};

			// Dữ liệu hiện tại của modal
			let currentModalData = {
				rowId: null,
				productId: null,
				currentVariantId: null,
				attributes: {},
				variantMapping: {},
				variants: []
			};

			// Hàm hiển thị loading
			function showLoading() {
				$('.loading-overlay').css('display', 'flex');
			}

			// Hàm ẩn loading
			function hideLoading() {
				$('.loading-overlay').hide();
			}

			// Hàm hiển thị modal
			function showModal() {
				$('#variantModal').addClass('show');
				$('body').css('overflow', 'hidden');
			}

			// Hàm ẩn modal
			function hideModal() {
				$('#variantModal').removeClass('show');
				$('body').css('overflow', '');
				resetModalData();
			}

			// Reset dữ liệu modal
			function resetModalData() {
				$('.attribute-option').prop('checked', false);
				resetToDefaultData();
				currentModalData = {
					rowId: null,
					productId: null,
					currentVariantId: null,
					attributes: {},
					variantMapping: {},
					variants: []
				};
			}

			// Hàm reset về dữ liệu mặc định
			function resetToDefaultData() {
				$('#variant-price').text(formatPrice(defaultProductData.price));
				$('#variant-compare-price').text(defaultProductData.compare_at_price ? formatPrice(defaultProductData.compare_at_price) : '');
				$('#variant-discount').text(defaultProductData.discount || '');
				$('#variant-product-sku').text(defaultProductData.sku);

				// Hiển thị lại hình ảnh chính
				$('#variant-image-slider .main-image-link').removeClass('active');
				$('#variant-image-slider .main-image-link[data-index="0"]').addClass('active');
				$('#variant-image-slider img').hide();
				$('#variant-image-slider .main-image-link.active img').show();
			}

			// Hàm format giá
			function formatPrice(price) {
				return new Intl.NumberFormat('vi-VN').format(price) + '₫';
			}

			// Hàm tạo HTML cho variant options
			function generateVariantOptionsHTML(attributes) {
				let html = '';

				// Sắp xếp attributes theo tên để đảm bảo thứ tự nhất quán
				const sortedAttributeNames = Object.keys(attributes).sort();

				sortedAttributeNames.forEach(function(attributeName) {
					const values = attributes[attributeName];
					html += '<div class="product-sw-line">';
					html += '<div class="product-sw-title">' + attributeName + '</div>';
					html += '<div class="product-sw-select">';

					values.forEach(function(value) {
						const inputId = 'attribute-' + attributeName.replace(/\s+/g, '-') + '-' + value.id;
						html += '<span class="product-sw-select-item">';
						html += '<input type="radio" name="attributes[' + attributeName + ']" id="' + inputId + '" class="attribute-option" value="' + value.id + '" data-attribute-name="' + attributeName + '" data-value-id="' + value.id + '">';
						html += '<label for="' + inputId + '" class="product-sw-select-item-span">' + value.value + '</label>';
						html += '</span>';
					});

					html += '</div></div>';
				});
				return html;
			}

			// Hàm tạo HTML cho hình ảnh
			function generateImageHTML(product, variants) {
				let html = '';

				// Thêm hình ảnh chính của sản phẩm
				if (product.image) {
					html += `
					<a href="#" onclick="return false;" aria-label="${product.name}" title="${product.name}" data-index="0" class="main-image-link active">
						<picture>
							<source media="(max-width: 480px)" srcset="${product.image}">
							<source media="(min-width: 481px)" srcset="${product.image}">
							<img class="main-product-image" width="600" height="600" loading="lazy" src="${product.image}" title="${product.name}" alt="${product.name}">
						</picture>
					</a>
				`;
				}

				// Thêm hình ảnh của các variants
				if (variants && variants.length) {
					variants.forEach((variant, index) => {
						if (variant.image && variant.image !== product.image) {
							html += `
							<a href="#" onclick="return false;" aria-label="${product.name} - ${variant.sku ?? variant.id}" title="${product.name} - ${variant.sku ?? variant.id}" data-variant="${variant.id}" class="main-image-link variant-image">
								<picture>
									<source media="(max-width: 480px)" srcset="${variant.image}">
									<source media="(min-width: 481px)" srcset="${variant.image}">
									<img class="main-product-image" width="600" height="600" loading="lazy" src="${variant.image}" title="${product.name} - ${variant.sku ?? variant.id}" alt="${product.name} - ${variant.sku ?? variant.id}" style="display: none;">
								</picture>
							</a>
						`;
						}
					});
				}

				return html;
			}

			// Cập nhật thông tin sản phẩm
			function updateProductInfo(product) {
				$('#variant-product-title').text(product.name);
				$('#variant-product-vendor').text(product.vendor || '');
				$('#variant-product-type').text(product.type || '');
				$('#variant-price').text(formatPrice(product.price));
				$('#variant-compare-price').text(product.compare_at_price ? formatPrice(product.compare_at_price) : '');
				$('#variant-discount').text(product.discount ? 'Tiết kiệm ' + product.discount + '%' : '');
				$('#variant-product-sku').text(product.sku || 'Đang cập nhật');
			}

			// Kiểm tra có đủ thuộc tính được chọn không
			function hasAllAttributesSelected(attributes) {
				const attributeNames = Object.keys(attributes);
				let selectedCount = 0;

				attributeNames.forEach(function(attrName) {
					if ($('input[name="attributes[' + attrName + ']"]:checked').length > 0) {
						selectedCount++;
					}
				});

				return selectedCount === attributeNames.length;
			}

			// Lấy variant ID hiện tại đã được chọn từ cart item
			function getCurrentVariantId(cartItem) {
				if (cartItem && cartItem.options && cartItem.options.variant_id) {
					return parseInt(cartItem.options.variant_id);
				}
				return null;
			}

			// Pre-select variant đã được chọn trong cart - FIXED VERSION
			function preselectCurrentVariant(cartItem, attributes, variantMapping) {
				if (!cartItem || !cartItem.options || !cartItem.options.variant_id) {
					console.log('No cart item or variant_id found');
					return false;
				}

				const currentVariantId = parseInt(cartItem.options.variant_id);
				console.log('Looking for variant ID:', currentVariantId);

				// Tìm variant key từ variant mapping
				let selectedVariantKey = null;
				let selectedVariantData = null;

				Object.keys(variantMapping).forEach(key => {
					if (variantMapping[key].id === currentVariantId) {
						selectedVariantKey = key;
						selectedVariantData = variantMapping[key];
					}
				});

				if (!selectedVariantKey) {
					console.warn('Cannot find variant key for variant ID:', currentVariantId);
					console.log('Available variant mappings:', variantMapping);
					return false;
				}

				console.log('Found variant key:', selectedVariantKey, 'with data:', selectedVariantData);

				// Parse attribute IDs từ key (format: "id1-id2-id3")
				const attributeIds = selectedVariantKey.split('-').map(id => parseInt(id));
				console.log('Attribute IDs to select:', attributeIds);

				// Pre-select các radio buttons
				let selectedCount = 0;
				attributeIds.forEach(attrId => {
					const $input = $(`.attribute-option[value="${attrId}"]`);
					if ($input.length) {
						$input.prop('checked', true);
						selectedCount++;
						console.log('Selected attribute:', attrId, 'for', $input.data('attribute-name'));
					} else {
						console.warn('Cannot find input for attribute ID:', attrId);
					}
				});

				console.log('Pre-selected variant:', {
					variantId: currentVariantId,
					variantKey: selectedVariantKey,
					attributeIds: attributeIds,
					selectedCount: selectedCount,
					expectedCount: attributeIds.length
				});

				return selectedCount === attributeIds.length;
			}

			// Cập nhật thông tin variant khi thay đổi selection - IMPROVED VERSION
			function updateVariantInfo(selectedAttributes) {
				console.log('updateVariantInfo called with:', selectedAttributes);

				if (!hasAllAttributesSelected(currentModalData.attributes)) {
					console.log('Not all attributes selected');
					resetToDefaultData();
					$('#update-variant-submit').prop('disabled', true).text('Cập nhật biến thể');
					return;
				}

				// Tạo key với cách sắp xếp giống như PHP (tăng dần)
				const sortedAttributeIds = selectedAttributes.map(id => parseInt(id)).sort((a, b) => a - b);
				const variantKey = sortedAttributeIds.join('-');

				console.log('Generated variant key:', variantKey);
				console.log('Available variant keys:', Object.keys(currentModalData.variantMapping));

				const variant = currentModalData.variantMapping[variantKey];

				if (!variant) {
					console.error('Variant not found for key:', variantKey);
					console.log('Available variants:', currentModalData.variantMapping);
					resetToDefaultData();
					$('#update-variant-submit').prop('disabled', true).text('Biến thể không tồn tại');
					return;
				}

				console.log('Found variant:', variant);

				// Kiểm tra nếu là variant hiện tại
				if (variant.id === currentModalData.currentVariantId) {
					$('#update-variant-submit').prop('disabled', true).text('Đang chọn variant này');
					return;
				}

				// Cập nhật thông tin variant
				$('#variant-price').text(formatPrice(variant.price));

				let discountText = '';
				if (variant.compare_at_price && variant.compare_at_price > variant.price) {
					$('#variant-compare-price').text(formatPrice(variant.compare_at_price));
					discountText = 'Tiết kiệm ' + variant.discount + '%';
				} else {
					$('#variant-compare-price').text('');
				}
				$('#variant-discount').text(discountText);
				$('#variant-product-sku').text(variant.sku || 'Đang cập nhật');

				// Cập nhật hình ảnh
				$('#variant-image-slider .main-image-link').removeClass('active');
				$('#variant-image-slider img').hide();

				const $variantImageLink = $(`#variant-image-slider .variant-image[data-variant="${variant.id}"]`);
				if ($variantImageLink.length && variant.image) {
					$variantImageLink.addClass('active').find('img').show();
				} else {
					$('#variant-image-slider .main-image-link[data-index="0"]').addClass('active').find('img').show();
				}

				// Cập nhật trạng thái nút submit
				if (variant.stock === 0) {
					$('#update-variant-submit').prop('disabled', true).text('Hết hàng');
				} else {
					$('#update-variant-submit').prop('disabled', false).text('Cập nhật biến thể');
				}
			}

			// Xử lý response từ server khi cập nhật thành công
			function handleUpdateSuccess(response) {
				hideLoading();
				hideModal();

				// Hiển thị thông báo
				alert(response.success);

				const oldRowId = response.old_rowId;
				const newItem = response.item;
				const newRowId = newItem.rowId;

				if (response.merged) {
					// Trường hợp merge: xóa row cũ, cập nhật row đã tồn tại
					$(`tr[data-row-id="${oldRowId}"]`).remove();

					const $existingRow = $(`tr[data-row-id="${newRowId}"]`);
					if ($existingRow.length) {
						updateCartRow($existingRow, newItem);
					} else {
						console.warn('Cannot find existing row for merged item, reloading page...');
						window.location.reload();
					}
				} else {
					// Trường hợp cập nhật: có thể rowId thay đổi
					const $currentRow = $(`tr[data-row-id="${oldRowId}"]`);
					if ($currentRow.length) {
						// Cập nhật rowId mới nếu khác
						if (oldRowId !== newRowId) {
							$currentRow.attr('data-row-id', newRowId);
							console.log('RowId changed from', oldRowId, 'to', newRowId);
						}
						updateCartRow($currentRow, newItem);
					} else {
						// Nếu không tìm thấy row cũ, tìm row mới
						const $newRow = $(`tr[data-row-id="${newRowId}"]`);
						if ($newRow.length) {
							updateCartRow($newRow, newItem);
						} else {
							console.warn('Cannot find current row to update, reloading page...');
							window.location.reload();
						}
					}
				}

				// Cập nhật tổng giá và số lượng giỏ hàng
				$('.cart-total-price').text(response.cart.total_price + '₫');
				$('.cart-count').text(response.cart.count);
			}

			// Cập nhật thông tin row trong bảng giỏ hàng
			function updateCartRow($row, item) {
				$row.find('.cart-item-image').attr('src', item.image);
				$row.find('.cart-item-attributes').text(item.variant_attributes);
				$row.find('.cart-item-price').text(item.price + '₫');
				$row.find('.cart-item-subtotal').text(item.subtotal + '₫');
				$row.find('.cart-item-qty').text(item.qty);

				// Cập nhật data attributes cho các buttons
				$row.find('.update-variant-btn').data('row-id', item.rowId);
				$row.find('.quantity-btn, .remove-btn').each(function() {
					$(this).data('row-id', item.rowId);
				});
			}

			// Event: Mở modal chọn variant
			$(document).on('click', '.update-variant-btn', function(e) {
				e.preventDefault();

				const rowId = $(this).data('row-id');
				const productId = $(this).data('product-id');

				if (!rowId || !productId) {
					alert('Thông tin sản phẩm không hợp lệ.');
					return;
				}

				// Reset và lưu dữ liệu hiện tại
				currentModalData.rowId = rowId;
				currentModalData.productId = productId;

				showModal();
				showLoading();

				// Gọi API lấy dữ liệu variant
				$.ajax({
					url: `/cart/product-variants/${productId}`,
					method: 'GET',
					timeout: 15000,
					success: function(response) {
						try {
							if (!response.product || !response.attributes || !response.variants) {
								throw new Error('Dữ liệu trả về không đầy đủ');
							}

							console.log('API Response:', response);

							// Lưu dữ liệu
							defaultProductData = {
								price: response.product.price || 0,
								compare_at_price: response.product.compare_at_price || 0,
								discount: response.product.discount || '',
								sku: response.product.sku || 'Đang cập nhật'
							};

							currentModalData.attributes = response.attributes;
							currentModalData.variantMapping = response.variantMapping;
							currentModalData.variants = response.variants;
							currentModalData.currentVariantId = getCurrentVariantId(response.cartItem);

							console.log('Current variant ID:', currentModalData.currentVariantId);
							console.log('Variant mapping keys:', Object.keys(response.variantMapping));

							// Cập nhật giao diện
							const imageHTML = generateImageHTML(response.product, response.variants);
							$('#variant-image-slider').html(imageHTML);

							const optionsHTML = generateVariantOptionsHTML(response.attributes);
							$('#variant-selection-content').html(optionsHTML);

							updateProductInfo(response.product);

							// Pre-select variant hiện tại
							const preselected = preselectCurrentVariant(
								response.cartItem,
								response.attributes,
								response.variantMapping
							);

							console.log('Preselection result:', preselected);

							if (preselected) {
								// Trigger change để cập nhật giao diện
								setTimeout(() => {
									$('.attribute-option:checked').first().trigger('change');
								}, 100);
							} else {
								resetToDefaultData();
								$('#update-variant-submit').prop('disabled', true).text('Cập nhật biến thể');
							}

						} catch (error) {
							console.error('Error processing response:', error);
							hideLoading();
							hideModal();
							alert('Có lỗi xảy ra khi xử lý dữ liệu: ' + error.message);
						}
					},
					error: function(xhr, status, error) {
						hideLoading();
						hideModal();

						let errorMessage = 'Không thể tải dữ liệu biến thể.';
						if (xhr.responseJSON && xhr.responseJSON.error) {
							errorMessage = xhr.responseJSON.error;
						} else if (status === 'timeout') {
							errorMessage = 'Yêu cầu quá thời gian chờ. Vui lòng thử lại.';
						}

						alert(errorMessage);
						console.error('Load variants error:', {
							xhr,
							status,
							error
						});
					},
					complete: function() {
						hideLoading();
					}
				});
			});

			// Event: Cập nhật variant
			$(document).on('click', '#update-variant-submit', function(e) {
				e.preventDefault();

				if (!currentModalData.rowId) {
					alert('Thông tin giỏ hàng không hợp lệ.');
					return;
				}

				// Kiểm tra có đủ thuộc tính được chọn không
				if (!hasAllAttributesSelected(currentModalData.attributes)) {
					alert('Vui lòng chọn đầy đủ thuộc tính.');
					return;
				}

				const selectedAttributes = [];
				$('.attribute-option:checked').each(function() {
					selectedAttributes.push($(this).val());
				});

				// Tạo key giống như trong updateVariantInfo
				const sortedAttributeIds = selectedAttributes.map(id => parseInt(id)).sort((a, b) => a - b);
				const variantKey = sortedAttributeIds.join('-');
				const variant = currentModalData.variantMapping[variantKey];

				if (!variant) {
					alert('Biến thể không hợp lệ. Vui lòng chọn lại.');
					console.error('Variant not found for key:', variantKey);
					console.log('Available variants:', currentModalData.variantMapping);
					console.log('Selected attributes:', selectedAttributes);
					console.log('Sorted attribute IDs:', sortedAttributeIds);
					return;
				}

				// Kiểm tra tồn kho
				if (variant.stock === 0) {
					alert('Biến thể này hiện đã hết hàng.');
					return;
				}

				// Disable button và hiển thị loading
				const $button = $(this);
				const originalText = $button.text();
				$button.prop('disabled', true).text('Đang cập nhật...');
				showLoading();

				$.ajax({
					url: '/cart/update-variant',
					method: 'POST',
					data: {
						rowId: currentModalData.rowId,
						variant_id: variant.id,
						_token: $('meta[name="csrf-token"]').attr('content')
					},
					timeout: 15000,
					success: function(response) {
						try {
							if (!response.success || !response.item) {
								throw new Error('Phản hồi không hợp lệ từ server');
							}

							handleUpdateSuccess(response);

						} catch (error) {
							console.error('Error processing update response:', error);
							hideLoading();
							alert('Có lỗi xảy ra khi cập nhật: ' + error.message);
						}
					},
					error: function(xhr, status, error) {
						hideLoading();

						let errorMessage = 'Có lỗi xảy ra khi cập nhật biến thể.';
						let debugInfo = null;

						// Parse response nếu có
						try {
							if (xhr.responseText) {
								const response = JSON.parse(xhr.responseText);
								if (response.error) {
									errorMessage = response.error;
								}
								debugInfo = response.debug_info;
							}
						} catch (e) {
							console.warn('Could not parse error response:', xhr.responseText);
						}

						// Xử lý các trường hợp lỗi cụ thể
						if (status === 'timeout') {
							errorMessage = 'Yêu cầu quá thời gian chờ. Vui lòng thử lại.';
						} else if (xhr.status === 419) {
							errorMessage = 'Phiên làm việc đã hết hạn. Vui lòng làm mới trang và thử lại.';
						} else if (xhr.status === 422) {
							errorMessage = 'Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.';
						} else if (xhr.status === 500) {
							errorMessage = 'Lỗi server. Vui lòng thử lại sau hoặc liên hệ hỗ trợ.';
						} else if (xhr.status === 0) {
							errorMessage = 'Không thể kết nối đến server. Vui lòng kiểm tra kết nối mạng.';
						}

						alert(errorMessage);

						// Log chi tiết lỗi để debug
						console.error('Update variant error:', {
							xhr: {
								status: xhr.status,
								statusText: xhr.statusText,
								responseText: xhr.responseText,
								readyState: xhr.readyState
							},
							status: status,
							error: error,
							debugInfo: debugInfo,
							requestData: {
								rowId: currentModalData.rowId,
								variant_id: variant.id
							}
						});

						// Nếu có debug info và đang ở môi trường development
						if (debugInfo) {
							console.error('Server debug info:', debugInfo);
						}
					},
					complete: function() {
						$button.prop('disabled', false).text(originalText);
					}
				});
			});

			// Event: Thay đổi attribute selection - IMPROVED VERSION
			$(document).on('change', '.attribute-option', function() {
				console.log('Attribute selection changed');

				const selectedAttributes = [];
				$('.attribute-option:checked').each(function() {
					const value = $(this).val();
					selectedAttributes.push(value);
					console.log('Selected attribute:', value, 'for', $(this).data('attribute-name'));
				});

				console.log('All selected attributes:', selectedAttributes);
				updateVariantInfo(selectedAttributes);
			});

			// Event: Đóng modal
			$(document).on('click', '.variant-modal-close, .btn-secondary', function(e) {
				e.preventDefault();
				hideModal();
			});

			// Đóng modal khi click outside
			$(document).on('click', '#variantModal', function(e) {
				if (e.target === this) {
					hideModal();
				}
			});

			// Xử lý phím ESC để đóng modal
			$(document).on('keydown', function(e) {
				if (e.key === 'Escape' && $('#variantModal').hasClass('show')) {
					hideModal();
				}
			});

			// Prevent modal content click from closing modal
			$(document).on('click', '.variant-modal-content', function(e) {
				e.stopPropagation();
			});

			// Event: Click thumbnail để chuyển đổi hình ảnh (nếu có)
			$(document).on('click', '.variant-thumbnail', function(e) {
				e.preventDefault();
				const targetImageSrc = $(this).attr('src');
				const $mainImage = $('#variant-image-slider .main-image-link.active img');

				if ($mainImage.length && targetImageSrc) {
					$mainImage.attr('src', targetImageSrc);
				}
			});

			// Event: Hover effect cho variant options (optional enhancement)
			$(document).on('mouseenter', '.product-sw-select-item-span', function() {
				$(this).addClass('hover');
			});

			$(document).on('mouseleave', '.product-sw-select-item-span', function() {
				$(this).removeClass('hover');
			});

			// Utility function: Debounce để tránh spam request
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

			// Enhanced error handling với retry logic
			function makeAjaxRequest(options, maxRetries = 2) {
				let attempts = 0;

				function attemptRequest() {
					attempts++;

					return $.ajax(options).fail(function(xhr, status, error) {
						if (attempts < maxRetries && (status === 'timeout' || xhr.status === 0)) {
							console.log(`Request failed, retrying... (${attempts}/${maxRetries})`);
							setTimeout(attemptRequest, 1000 * attempts); // Exponential backoff
						} else {
							// Final failure
							if (options.error) {
								options.error(xhr, status, error);
							}
						}
					});
				}

				return attemptRequest();
			}

			// Enhanced logging cho production
			function logDebug(message, data = null) {
				if (console && console.log && (window.location.hostname === 'localhost' || window.location.hostname.includes('dev'))) {
					console.log('[Variant Debug]', message, data);
				}
			}

			function logError(message, error = null) {
				if (console && console.error) {
					console.error('[Variant Error]', message, error);
				}
			}

			// Validation helpers
			function validateVariantData(data) {
				if (!data) return false;
				if (!data.product || !data.attributes || !data.variantMapping) return false;
				if (Object.keys(data.variantMapping).length === 0) return false;
				return true;
			}

			function validateCartItem(item) {
				if (!item) return false;
				if (!item.rowId || !item.item) return false;
				return true;
			}

			// Accessibility improvements
			function updateAriaLabels() {
				$('.attribute-option').each(function() {
					const $this = $(this);
					const isChecked = $this.is(':checked');
					const attributeName = $this.data('attribute-name');
					const value = $this.next('label').text();

					$this.attr('aria-label', `${attributeName}: ${value}${isChecked ? ' (đã chọn)' : ''}`);
				});
			}

			// Call updateAriaLabels when attributes change
			$(document).on('change', '.attribute-option', function() {
				updateAriaLabels();
			});

			// Performance optimization: Cache jQuery objects
			const $body = $('body');
			const $loadingOverlay = $('.loading-overlay');
			const $variantModal = $('#variantModal');

			// Override some functions to use cached objects
			function showModalOptimized() {
				$variantModal.addClass('show');
				$body.css('overflow', 'hidden');
			}

			function hideModalOptimized() {
				$variantModal.removeClass('show');
				$body.css('overflow', '');
				resetModalData();
			}

			function showLoadingOptimized() {
				$loadingOverlay.css('display', 'flex');
			}

			function hideLoadingOptimized() {
				$loadingOverlay.hide();
			}

			// Initialize tooltips if using Bootstrap
			if (typeof $().tooltip === 'function') {
				$(document).on('mouseenter', '[data-toggle="tooltip"]', function() {
					$(this).tooltip('show');
				});
			}

			logDebug('Variant selection script initialized successfully');
		});
	</script>
	<script>
		$(document).ready(function() {
			// Tăng số lượng
			$('.shop-quantity button[data-type="shop-quantity-plus"]').on('click', function() {
				let $row = $(this).closest('.main-cart-data-full-item');
				let input = $row.find('input[type="number"]');
				let quantity = parseInt(input.val()) + 1;
				updateCart($row.data('id'), quantity, $row);
			});

			// Giảm số lượng
			$('.shop-quantity button[data-type="shop-quantity-minus"]').on('click', function() {
				let $row = $(this).closest('.main-cart-data-full-item');
				let input = $row.find('input[type="number"]');
				let quantity = parseInt(input.val()) - 1;
				if (quantity >= 1) {
					updateCart($row.data('id'), quantity, $row);
				}
			});

			function updateCart(rowId, quantity, $row) {
				$.ajax({
					url: '{{ route("cart.update") }}',
					type: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						rowId: rowId,
						quantity: quantity
					},
					success: function(res) {
						$row.find('input[type="number"]').val(res.qty);
						$row.find('.main-cart-data-full-item-info-total span').text(res.subtotal + '₫');
						$('.main-cart-data-head p strong').text(res.total_items);
						$('#cart-total-price').text(res.total_price + '₫'); // nếu bạn có tổng tiền hiển thị
					},
					error: function() {
						alert('Cập nhật giỏ hàng thất bại!');
					}
				});
			}
		});
	</script>

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
</body>

</html>