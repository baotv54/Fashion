# Laravel S7 studio
Dự án này là một website bán hàng sử dụng Laravel Framework, hỗ trợ đầy đủ tính năng quản lý sản phẩm, đặt hàng, giỏ hàng, mã giảm giá, thanh toán, chatbot và giao diện quản trị.

---
## ⚙️ Cài đặt dự án

```bash
git clone <repository> (https://github.com/baotv54/Du-An-Tot-Nghiep-2025.git)
cd <project-folder>
composer install (Nếu gặp lỗi không cài đươc thư viện thì tham khảo để fix: https://chatgpt.com/share/68302e28-5e54-8010-bb53-2df219e7416b)
cp .env.example .env (cấu hình database và các API cần thiết, sẽ gửi sau)
php artisan key:generate
npm install && npm run dev
php artisan serve
```

## Phần giao diện của admin nằm trong thư mục admin, phần giao diện trang web nằm trong thư mục Frontend
## 🔥 Chức năng chính

### 👤 Người dùng (Frontend)

- Trang chủ hiển thị sản phẩm
- Danh sách sản phẩm và tìm kiếm
- Xem chi tiết sản phẩm
- Lựa chọn biến thể sản phẩm (màu, kích thước)
- Giỏ hàng: xem, thêm, xóa, cập nhật số lượng
- Thanh toán đơn hàng (checkout)
- Tính phí vận chuyển tự động
- Thanh toán bằng:
  - VNPay
  - Momo
  - COD
- Áp dụng / xóa mã giảm giá
- Đăng nhập bằng:
  - Google
  - Facebook
- Đăng nhập / Đăng ký frontend
- Quản lý tài khoản người dùng:
  - Hồ sơ cá nhân
  - Đổi mật khẩu
  - Quản lý địa chỉ: thêm, sửa, xoá, đặt mặc định
- Xem lịch sử đơn hàng
- Xem chi tiết đơn hàng
- Cập nhật địa chỉ giao hàng cho đơn đã đặt
- Hủy đơn hàng
- Đặt lại đơn hàng (Reorder)
- Đánh giá sản phẩm:
  - Gửi đánh giá
  - Sửa / xóa đánh giá

---

### 🤖 Chatbot

- Gửi câu hỏi và tin nhắn
- Gợi ý sản phẩm
- Lấy lịch sử hội thoại
- Thêm sản phẩm vào giỏ hàng từ khung chat

---

### 🛠️ Quản trị (Admin Panel)

- Quản lý sản phẩm
  - Tạo / sửa / xoá
  - Cập nhật hình ảnh chính / phụ
  - Import sản phẩm từ file Excel
- Quản lý biến thể sản phẩm
- Quản lý danh mục sản phẩm
- Quản lý thương hiệu
- Quản lý thuộc tính sản phẩm (Attribute)
- Quản lý giá trị thuộc tính (Attribute Value)
- Quản lý mã giảm giá (Coupon)
- Quản lý đơn hàng
  - Xem chi tiết đơn
  - Cập nhật trạng thái
- Phê duyệt đánh giá sản phẩm
- Thống kê tổng quan (dashboard)

---

