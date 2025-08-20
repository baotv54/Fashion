@php($color = '#111827')
<!doctype html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Đặt lại mật khẩu</title>
	<style>
		/* Mobile-first resets */
		body { margin:0; padding:0; background:#f6f7fb; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif; color:#111827 }
		.container { max-width: 560px; margin: 0 auto; padding: 16px }
		.card { background:#ffffff; border-radius:16px; box-shadow:0 4px 20px rgba(0,0,0,.06); padding:24px }
		.h1 { font-size:22px; font-weight:700; margin:0 0 8px }
		.p { font-size:15px; line-height:1.6; margin:0 0 16px; color:#4b5563 }
		.btn { display:inline-block; background:#111827; color:#fff !important; text-decoration:none; padding:12px 18px; border-radius:10px; font-weight:600 }
		.footer { font-size:12px; color:#6b7280; margin-top:24px; border-top:1px solid #e5e7eb; padding-top:16px }
		@media (min-width: 420px) { .h1 { font-size:24px } .btn { padding:12px 22px } }
	</style>
</head>
<body>
	<div class="container">
		<div class="card">
			<!-- <div style="text-align:center; margin-bottom:12px">
				<img src="http://127.0.0.1:8000/images/shop_logo_imagee889.png" alt="F1GENZ Shoes" title="F1GENZ Shoes" height="40" style="height:40px;">
			</div> -->

			<h1 class="h1">Xin chào</h1>
			<p class="p">Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>

			<div style="text-align:center; margin:22px 0">
				<a class="btn" href="{{ $resetUrl }}" target="_blank">Đặt lại mật khẩu</a>
			</div>

			<p class="p">Liên kết đặt lại mật khẩu này sẽ hết hạn sau 60 phút.</p>
			<p class="p">Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>

			<div class="footer">
				<p class="p" style="margin:0">Trân trọng,<br>{{ $appName }}</p>
				<p style="margin:12px 0 0; line-height:1.6">Nếu bạn gặp vấn đề khi bấm nút "Đặt lại mật khẩu", hãy sao chép liên kết sau và dán vào trình duyệt của bạn:<br>
					<a href="{{ $resetUrl }}" style="color:#2563eb; word-break:break-all" target="_blank">{{ $resetUrl }}</a>
				</p>
			</div>
		</div>
	</div>
</body>
</html> 