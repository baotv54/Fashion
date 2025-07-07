<!doctype html>
<html class="no-js" lang="vi">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
	@include('Frontend.partials.head')
	<style>
		.main-cart-breadcrumb {
			background-image: url("{{asset('images/main_cart_breadcrumb_bge889.jpg')}}")
		}

		.main-cart-breadcrumb * {
			color: #333333 !important;
		}

		:root {
			--main-color: #FF3B00;
			--hover-color: #FFD600;
			--text-color: #222;
			--gray: #999;
			--radius: 10px;
			--shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			--transition: 0.3s ease;
		}

		.favorites-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
			gap: 20px;
			margin-top: 30px;
		}

		.favorite-card {
			background: #fff;
			border-radius: var(--radius);
			box-shadow: var(--shadow);
			overflow: hidden;
			display: flex;
			flex-direction: column;
			transition: transform var(--transition);
		}

		.favorite-card:hover {
			transform: translateY(-4px);
		}

		.favorite-card img {
			width: 100%;
			height: 200px;
			object-fit: cover;
		}

		.favorite-card-body {
			padding: 15px;
			display: flex;
			flex-direction: column;
			gap: 10px;
		}

		.favorite-card-body h3 {
			font-size: 1.1rem;
			font-weight: 600;
			color: var(--text-color);
			margin: 0;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}

		.favorite-card-body p.price {
			color: var(--main-color);
			font-weight: 700;
			margin: 0;
		}

		.favorite-card-body .options {
			font-size: 0.9rem;
			color: var(--gray);
			display: flex;
			flex-wrap: wrap;
			gap: 6px 12px;
		}

		.favorite-card-body .actions {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-top: 10px;
		}

		.favorite-card-body .actions form {
			display: inline-block;
		}

		.favorite-card-body button {
			padding: 8px 14px;
			font-size: 0.9rem;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-weight: 600;
			transition: background var(--transition);
		}

		.favorite-card-body .add-to-cart {
			background: var(--main-color);
			color: white;
		}

		.favorite-card-body .add-to-cart:hover {
			background: var(--hover-color);
			color: black;
		}

		.favorite-card-body .delete-btn {
			background: #f5f5f5;
			color: var(--gray);
			font-size: 1rem;
			padding: 8px;
			border-radius: 50%;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: background var(--transition);
		}

		.favorite-card-body .delete-btn:hover {
			background: #eee;
			color: #d00;
		}
	</style>



	<link rel="preload stylesheet" as="style"
		href="{{asset('css/cart.scsse889.css')}}">
	<script fetchpriority="low" defer

		src="{{asset('js/carte889.js')}}"></script>

</head>

<body>
	@include('Frontend.partials.header')
	<main class="main-layout">
		<div class="main-cart">
			<div class="main-cart-breadcrumb" title="Yêu thích">
				<div class="container">
					<h1>Yêu Thích</h1>
					<div class="breadcrumb-wrap">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="/home" aria-label="Trang chủ" title="Trang chủ">Trang chủ</a></li>
							<li class="breadcrumb-item active"><span>Yêu Thích</span></li>
						</ol>
					</div>
				</div>
			</div>
			@if ($favorites->count() > 0)
			<div class="container favorites-container">
				<h2 style="margin-top: 20px;">Danh sách sản phẩm yêu thích</h2>
				<div class="favorites-grid">
					<!-- <div style="grid-column: 1 / -1; margin-bottom: 10px;">
						<label>
							<input type="checkbox" id="select-all-favorites" />
							Chọn tất cả
						</label>
						<button id="delete-all-favorites" style="background:#d00; color:#fff; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;">
							Xóa tất cả yêu thích
						</button>
					</div> -->
					@foreach ($favorites as $favorite)
					@php $product = $favorite->product; @endphp
					@if ($product)
					<div class="favorite-card">
						<!-- <label style="position:absolute; top:10px; left:10px; z-index:10;">
							<input type="checkbox" class="favorite-checkbox" value="{{ $product->id }}">
						</label> -->
						<a href="{{ route('product.show', $product->id) }}">
							<img src="{{ $product->image }}" alt="{{ $product->name }}">
						</a>
						<div class="favorite-card-body">
							<h3>{{ $product->name }}</h3>
							<p class="price">{{ number_format($product->price, 0, ',', '.') }}₫</p>
							<div class="options">
								Size: 42 |
								Màu: Đen Tím |
								Phân loại: Giày thể thao
							</div>
							<div class="actions">
								<form action="{{ route('cart.add') }}" method="POST">
									@csrf
									<input type="hidden" name="product_id" value="{{ $product->id }}">
									<input type="hidden" name="quantity" value="1">
									<button type="submit" class="add-to-cart">Thêm vào giỏ</button>
								</form>
								<form action="{{ route('favorites.destroy', ['product_id' => $product->id]) }}"
									method="POST"
									class="favorite-delete-form"
									data-product-id="{{ $product->id }}">
									@csrf
									@method('DELETE')
									<button type="submit" class="delete-btn" title="Xóa yêu thích">
										<i class="fas fa-heart-broken"></i>
									</button>
								</form>
							</div>
						</div>
					</div>
					@endif
					@endforeach
				</div>
			</div>

			@else
			<div class="main-cart-wrap">
				<div class="container">
					<div class="main-cart-data">
						<div class="main-cart-data-none">
							<div class="section-title-all">
								<h2>Bạn chưa lựa chọn được sản phẩm yêu thích nào.?</h2>
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
	</main>
	@include('Frontend.partials.footer')


	@include('Frontend.partials.modal')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function() {
			// Bật/tắt nút xóa khi checkbox thay đổi
			function toggleDeleteSelectedBtn() {
				let anyChecked = $('.favorite-checkbox:checked').length > 0;
				$('#delete-selected').prop('disabled', !anyChecked);
			}

			// Chọn tất cả / bỏ chọn tất cả
			$('#select-all-favorites').on('change', function() {
				let checked = $(this).is(':checked');
				$('.favorite-checkbox').prop('checked', checked);
				toggleDeleteSelectedBtn();
			});

			// Khi checkbox từng sản phẩm thay đổi
			$(document).on('change', '.favorite-checkbox', function() {
				let allChecked = $('.favorite-checkbox').length === $('.favorite-checkbox:checked').length;
				$('#select-all-favorites').prop('checked', allChecked);
				toggleDeleteSelectedBtn();
			});	

			$('.favorite-delete-form').on('submit', function(e) {
				e.preventDefault(); // Chặn reload trang

				var form = $(this);
				var url = form.attr('action');

				$.ajax({
					url: url,
					method: 'POST', // Dùng POST để Laravel nhận DELETE qua _method
					data: form.serialize(),
					success: function(response) {
						if (response.success) {
							form.closest('.favorite-card').remove();
							if ($('.favorite-card').length === 0) {
								$('.favorites-grid').remove();
								$('.favorites-container').html(`
								<div class="main-cart-wrap">
									<div class="container">
										<div class="main-cart-data">
											<div class="main-cart-data-none">
												<div class="section-title-all">
													<h2>Bạn chưa lựa chọn được sản phẩm yêu thích nào.?</h2>
													<p>Tìm kiếm ngay sản phẩm mà bạn mong muốn với bộ sưu tập rộng lớn của chúng tôi!</p>
													                <form action="{{ route('products.search') }}">
														<input type="hidden" name="type" value="product">
														<input type="text" name="q" placeholder="Tìm kiếm sản phẩm" value="">
														<button type="submit" title="Tìm kiếm">
															<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
																<path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
															</svg>
														</button>
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
								`);
							}
						} else {
							alert('Xóa yêu thích thất bại!');
						}
					},
					error: function() {
						alert('Lỗi server, vui lòng thử lại.');
					}
				});
			});
		});
	</script>

</body>

</html>