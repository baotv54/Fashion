<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảnh báo đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 20px;
            border: 1px solid #dee2e6;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .footer {
            background-color: #6c757d;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>⚠️ Cảnh báo bảo mật</h1>
    </div>
    
    <div class="content">
        <p>Xin chào <strong>{{ $user->name }}</strong>,</p>
        
        <div class="warning">
            <h3>🔒 Phát hiện đăng nhập không thành công</h3>
            <p>Chúng tôi phát hiện có {{ $loginAttempts }} lần đăng nhập không thành công vào tài khoản của bạn.</p>
        </div>
        
        <div class="info">
            <h4>📋 Thông tin chi tiết:</h4>
            <ul>
                <li><strong>Thời gian:</strong> {{ now()->format('d/m/Y H:i:s') }}</li>
                <li><strong>Địa chỉ IP:</strong> {{ $ipAddress }}</li>
                <li><strong>Thiết bị:</strong> {{ $userAgent }}</li>
                <li><strong>Email tài khoản:</strong> {{ $user->email }}</li>
            </ul>
        </div>
        
        <p>Nếu đây là bạn, vui lòng:</p>
        <ul>
            <li>Kiểm tra lại mật khẩu</li>
            <li>Đảm bảo Caps Lock không được bật</li>
            <li>Thử đăng nhập lại sau vài phút</li>
        </ul>
        
        <p>Nếu đây không phải là bạn, vui lòng:</p>
        <ul>
            <li>Thay đổi mật khẩu ngay lập tức</li>
            <li>Bật xác thực 2 yếu tố nếu có</li>
            <li>Liên hệ với chúng tôi nếu cần hỗ trợ</li>
        </ul>
        
        <div style="text-align: center; margin: 20px 0;">
            <a href="{{ route('password.request') }}" class="btn">Đặt lại mật khẩu</a>
        </div>
        
        <p><strong>Lưu ý:</strong> Tài khoản của bạn sẽ bị khóa tạm thời nếu có quá nhiều lần đăng nhập sai.</p>
    </div>
    
    <div class="footer">
        <p>Email này được gửi tự động từ hệ thống bảo mật.</p>
        <p>Vui lòng không trả lời email này.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tất cả quyền được bảo lưu.</p>
    </div>
</body>
</html> 