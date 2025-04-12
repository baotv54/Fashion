<!doctype html>
<html class="no-js" lang="vi">


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
	@include('Frontend.partials.head')
</head>

<body class="">
	@include('Frontend.partials.header')
	<main class="main-layout">
		<div class="my-account-wrap">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-sm-6 col-md-4 offset-sm-3 offset-md-4">
						<div id="auth-form" class="login-layout">
							<div class="auth-heading">
								<i class="lar la-user"></i>
								<h1>
									<span class="login-form-heading">Đăng nhập</span>
									<span class="recover-form-heading">Quên mật khẩu</span>
								</h1>
							</div>
							<div class="auth-form-body">
								<div class="login-form-body">
									<form method="post" action="{{ route('login') }}"
										id="customer_login" accept-charset="UTF-8"><input name="FormType" type="hidden"
											value="customer_login" /><input name="utf8" type="hidden" value="true" />
										<div>
											<x-input-label for="email" :value="__('Email')" />
											<x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
											<x-input-error :messages="$errors->get('email')" class="mt-2" />
										</div>
										<div class="mt-4">
											<x-input-label for="password" :value="__('Password')" />

											<x-text-input id="password" class="block mt-1 w-full form-control"
												type="password"
												name="password"
												required autocomplete="current-password" />

											<x-input-error :messages="$errors->get('password')" class="mt-2" />
										</div>
										<div class="auth-recover-btn">
											<a href="#" data-layout="recover-layout" class="auth-layout-trigger"
												title="Quên mật khẩu">Quên mật khẩu?</a>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary" title="Đăng nhập">
												ĐĂNG NHẬP
											</button>
											<a title="Đăng nhập Facebook" href="{{ route('facebook.login') }}"
												class="social-login--facebook"><img
													width="129" height="37" alt="facebook-login-button"
													src="http://bizweb.dktcdn.net/assets/admin/images/login/fb-btn.svg"></a>
											<a title="Đăng nhập Google" href="{{ route('google.login') }}"
												class="social-login--google"><img width="129"
													height="37" alt="google-login-button"
													src="http://bizweb.dktcdn.net/assets/admin/images/login/gp-btn.svg"></a>
										</div>
										<div class="auth-back-btn">
											<a title="Đăng ký" href="register.html" title="Đăng ký">Đăng ký</a>
										</div>
									</form>
								</div>
								<div class="recover-form-body">
									<form method="post" action="https://f1genz-shoes.mysapo.net/account/recover"
										id="recover_customer_password" accept-charset="UTF-8"><input name="FormType"
											type="hidden" value="recover_customer_password" /><input name="utf8"
											type="hidden" value="true" />

										<div class="form-group">
											<label for="recover-email">Email*</label>
											<input type="email" id="recover-email" class="form-control" name="Email"
												required>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary" title="Gửi">
												Gửi
											</button>
										</div>
										<div class="auth-back-btn">
											<a href="#" data-layout="login-layout" class="auth-layout-trigger">Đăng
												nhập</a>
										</div>
									</form>
								</div>
							</div>
						</div>
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
					$.getScript('../../www.google.com/recaptcha/apif78f.js?render=6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK').done(function(s, r) {
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