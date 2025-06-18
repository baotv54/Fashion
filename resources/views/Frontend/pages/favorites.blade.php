<!doctype html>
<html class="no-js" lang="vi">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
	@include('Frontend.partials.head')
	<style>
		:root {
			--main-color: #FF3B00;
			--hover-color: #FFD600;
			--text-color: #333;
			--gray-color: #666;
			--bg-light: #fefefe;
			--border-radius: 10px;
			--shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
			--transition: 0.3s ease;
		}

		.main-cart-breadcrumb {
			background-image: url("{{asset('images/main_cart_breadcrumb_bge889.jpg')}}");
			background-size: cover;
			padding: 20px 0;
			text-align: center;
		}

		.main-cart-breadcrumb h1 {
			color: var(--main-color);
			font-size: 2rem;
			margin: 0;
		}

		.favorites-list {
			display: flex;
			flex-direction: column;
			gap: 20px;
		}

		.favorite-item {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 25px;
			border-radius: 12px;
			background-color: var(--bg-light);
			font-size: 1rem;
			/* tăng cỡ chữ */
			box-shadow: var(--shadow);
			transition: box-shadow var(--transition);
			flex-wrap: nowrap;
		}

		.favorite-item:hover {
			box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
		}

		.favorite-item img {
			width: 120px;
			height: 120px;
			border-radius: var(--border-radius);
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			object-fit: cover;
			flex-shrink: 0;
		}

		.favorite-item .info {
			flex-grow: 1;
			margin-left: 20px;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		.favorite-item .info a {
			font-size: 1.3rem;
			font-weight: 600;
			color: var(--text-color);
			margin-bottom: 6px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.favorite-item .info p {
			font-size: 1.1rem;
			color: var(--main-color);
			font-weight: 700;
			margin: 0;
		}

		/* phần actions, nút thêm giỏ hàng và chọn size, số lượng */
		.favorite-item .actions {
			display: flex;
			align-items: center;
			gap: 12px 30px;
			font-size: 1rem;
			flex-wrap: wrap;
		}

		.favorite-item .actions select,
		.favorite-item .actions input[type="text"] {
			padding: 6px 10px;
			border: 1px solid #ccc;
			border-radius: 6px;
			font-size: 1rem;
			min-width: 60px;
			text-align: center;
		}

		.favorite-item .actions button.qty-btn,
		.favorite-item .actions button.shop-addLoop-button {
			padding: 8px 14px;
			border: 1px solid #ccc;
			background: #eee;
			font-weight: bold;
			cursor: pointer;
			transition: background var(--transition);
			font-size: 1rem;
			border-radius: 6px;
		}

		.favorite-item .actions button.qty-btn:hover,
		.favorite-item .actions button.shop-addLoop-button:hover {
			background: #ddd;
		}

		/* Nút thêm vào giỏ hàng lớn màu chính */
		.shop-addLoop-button {
			width: 150px;
			padding: 10px 0;
			font-size: 1rem;
			border-radius: 6px;
			background-color: var(--main-color);
			color: white;
			border: none;
			cursor: pointer;
			font-weight: 600;
			transition: background-color var(--transition), color var(--transition);
		}

		.shop-addLoop-button:hover {
			background-color: var(--hover-color);
			color: black;
		}

		/* Nút xóa yêu thích */
		.favorite-item .actions form button[title="Xoá yêu thích"] {
			background: none;
			border: none;
			color: var(--gray-color);
			cursor: pointer;
			font-size: 20px;
			padding: 0;
		}

		.empty-favorites {
			text-align: center;
			padding: 50px;
		}

		.empty-favorites h2 {
			color: var(--main-color);
			font-weight: 700;
		}

		.empty-favorites p {
			color: var(--gray-color);
		}

		.empty-favorites form button {
			padding: 10px 20px;
			background-color: var(--main-color);
			color: white;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			font-weight: 600;
			transition: background-color var(--transition);
		}

		.empty-favorites form button:hover {
			background-color: var(--hover-color);
			color: black;
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
			<div class="container">
				<h2 style="margin-bottom: 20px;">Danh sách sản phẩm yêu thích</h2>
				<div class="favorites-list">
					@foreach ($favorites as $favorite)
					@php $product = $favorite->product; @endphp
					@if ($product)
					<div class="favorite-item">
						{{-- Ảnh sản phẩm --}}
						<a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">
							<img src="{{ $product->image }}" alt="{{ $product->name }}">
						</a>

						{{-- Thông tin sản phẩm --}}
						<div class="info">
							{{-- Tên sản phẩm --}}
							<a href="{{ route('product.show', $product->id) }}"
								style="color: #333; font-weight: 600; font-size: 1.1rem; text-decoration: none;">
								{{ $product->name }}
							</a>

							{{-- Giá --}}
							<p style="color: #d00; font-weight: 700; margin-top: 5px;">
								{{ number_format($product->price, 0, ',', '.') }}₫
							</p>
						</div>

						{{-- Hành động: Thêm giỏ + Xóa --}}
						<div style="display: flex; flex-wrap: wrap; column-gap: 40px; row-gap: 8px; font-size: 0.9rem; color: #555; margin-top: 8px;">
							{{-- Size chọn --}}
							<div>
								Size:
								<select style="padding: 4px 8px; border: 1px solid #ccc; border-radius: 4px;">
									<option>38</option>
									<option>39</option>
									<option selected>42</option>
									<option>43</option>
								</select>
							</div>

							{{-- Màu chọn --}}
							<div>
								Màu:
								<select style="padding: 4px 8px; border: 1px solid #ccc; border-radius: 4px;">
									<option>Trắng</option>
									<option selected>Đen Tím</option>
									<option>Đỏ</option>
								</select>
							</div>

							{{-- Phân loại cố định --}}
							<div>Phân loại: Giày thể thao</div>

							{{-- Số lượng --}}
							<div style="display: flex; align-items: center;">
								Số lượng:
								<button type="button" style="margin-left: 8px; padding: 2px 8px; border: 1px solid #ccc; background: #eee; font-weight: bold;">-</button>
								<input type="text" value="1" style="width: 40px; text-align: center; margin: 0 4px; border: 1px solid #ccc; border-radius: 4px;">
								<button type="button" style="padding: 2px 8px; border: 1px solid #ccc; background: #eee; font-weight: bold;">+</button>
							</div>
							{{-- Thêm vào giỏ --}}
							<form action="{{ route('cart.add') }}" method="POST">
								@csrf
								<input type="hidden" name="product_id" value="{{ $product->id }}">
								<input type="hidden" name="quantity" value="1">
								<button type="submit" class="shop-addLoop-button" title="Thêm vào giỏ hàng">Thêm vào giỏ</button>
							</form>

							{{-- Xóa yêu thích --}}
							<form action="{{ route('favorites.destroy', ['product_id' => $product->id]) }}" method="POST"
								onsubmit="return confirm('Xoá sản phẩm này khỏi danh sách yêu thích?')"
								style="text-align: center;">
								@csrf
								@method('DELETE')
								<button type="submit" title="Xoá yêu thích"
									style="background: none; border: none; color: #888; cursor: pointer; font-size: 18px;">
									<i class="fas fa-trash-alt"></i>
								</button>
							</form>
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