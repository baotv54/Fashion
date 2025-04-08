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
							<li class="breadcrumb-item"><a href="index.html" aria-label="Trang chủ"
									title="Trang chủ">Trang chủ</a></li>

							<li class="breadcrumb-item active"><span>Giỏ hàng</span></li>
						</ol>
					</div>
				</div>
			</div>
			<div class="main-cart-wrap">
				<div class="container">
					<div class="main-cart-data">
						<div class="main-cart-data-none">
							<div class="section-title-all">
								<h2>Bạn chưa lựa chọn được sản phẩm nào.?</h2>
								<p>Tìm kiếm ngay sản phẩm mà bạn mong muốn với bộ sưu tập rộng lớn của chúng tôi!</p>
								<form action="https://f1genz-shoes.mysapo.net/search">
									<input type="hidden" name="type" value="product">
									<input type="text" name="q" placeholder="Tìm kiếm sản phẩm" value="">
									<button type="submit" title="Tìm kiếm"><svg xmlns="http://www.w3.org/2000/svg"
											version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512"
											height="512" x="0" y="0" viewBox="0 0 612.01 612.01"
											style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
											<path
												d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z"
												fill="#000000" data-original="#000000" class=""></path>
										</svg></button>
								</form>
							</div>
							<span>
								<img width="1666" height="1000" title="Tìm kiếm" class="w-100 lazyload"
									src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
									data-src="https://file.hstatic.net/200000584705/file/37578_dae02aa6e03e4230b958e97100__1___1__db746ec851754034b04b27f8690072c7.jpg"
									alt="Cart none">
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="sapo-buyxgety-module-cart-v2 container"></div>
		<div class="sapo-buyxgety-module-cart-v2 container"></div>
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
</body>

</html>