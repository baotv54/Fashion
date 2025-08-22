# Cấu hình Email cho Thông báo Đăng nhập Sai

## Tổng quan
Hệ thống đã được cập nhật để gửi email thông báo khi có người đăng nhập sai mật khẩu nhiều lần.

## Tóm tắt những gì đã được cải thiện:

### ✅ **Đã hoàn thành:**

1. **Tạo Mail Class** (`FailedLoginMail.php`):
   - Gửi email thông báo khi đăng nhập sai
   - Bao gồm thông tin chi tiết: IP, User Agent, số lần thử

2. **Tạo Email Template** (`failed-login.blade.php`):
   - Template HTML đẹp mắt
   - Thông tin chi tiết về lần đăng nhập sai
   - Hướng dẫn bảo mật cho người dùng

3. **Tạo Event Listener** (`FailedLoginListener.php`):
   - Xử lý sự kiện đăng nhập sai
   - Đếm số lần đăng nhập sai
   - Gửi email khi có từ 3 lần trở lên

4. **Tạo Event Service Provider** (`EventServiceProvider.php`):
   - Đăng ký listener cho sự kiện Failed

5. **Cập nhật Login Request**:
   - Trigger sự kiện Failed khi đăng nhập sai
   - Giữ nguyên rate limiting hiện tại

6. **Cập nhật thông báo lỗi**:
   - Chuyển sang tiếng Việt
   - Thông báo rõ ràng hơn

7. **Tạo file hướng dẫn** (`EMAIL_CONFIGURATION.md`):
   - Hướng dẫn cấu hình Gmail
   - Cách test chức năng
   - Troubleshooting

### 🔧 **Cách hoạt động:**

1. **Khi đăng nhập sai**: Hệ thống trigger sự kiện `Failed`
2. **Listener xử lý**: Đếm số lần đăng nhập sai và gửi email khi có từ 3 lần
3. **Rate Limiting**: Khóa tài khoản sau 5 lần đăng nhập sai
4. **Email thông báo**: Gửi email với thông tin chi tiết

###  **Để sử dụng:**

1. **Cấu hình email trong `.env`**:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

2. **Test chức năng**: Thử đăng nhập sai 3 lần để nhận email thông báo

Hệ thống bây giờ đã có đầy đủ chức năng gửi email thông báo khi đăng nhập sai mật khẩu với bảo mật cao! 