# 🤖 ChatBot Nâng Cao - F1GENZ Shoes

## 📋 Tổng quan

ChatBot của F1GENZ Shoes đã được nâng cấp với các tính năng thông minh và cá nhân hóa để cung cấp trải nghiệm tư vấn tốt nhất cho khách hàng.

## ✨ Các tính năng mới

### 1. 🎯 Tư vấn theo nhu cầu nâng cao

#### Phân tích ý định người dùng
- **FAQ**: Câu hỏi thông thường
- **Product Search**: Tìm kiếm sản phẩm
- **Style Advice**: Tư vấn phong cách
- **Size Help**: Hỗ trợ chọn size
- **Comparison**: So sánh sản phẩm

#### Phân tích mục đích sử dụng
- Thể thao (chạy bộ, bóng đá, bóng rổ...)
- Công sở (đi làm, dự tiệc...)
- Dạo phố (casual, street style...)

#### Phân tích đối tượng
- Giới tính (nam/nữ)
- Độ tuổi (18-35, 35+)
- Phong cách (sporty, casual, formal, luxury)

### 2. 🔍 Bộ lọc thông minh nâng cao

#### Bộ lọc cơ bản
- **Category**: Danh mục sản phẩm
- **Brand**: Thương hiệu
- **Price**: Giá (min/max)
- **Rating**: Đánh giá (từ 1-5 sao)

#### Bộ lọc nâng cao
- **Size**: Kích thước giày
- **Color**: Màu sắc
- **Purpose**: Mục đích sử dụng
- **Gender**: Giới tính
- **Status**: Tình trạng hàng

#### Sắp xếp thông minh
- Theo số lượng đánh giá
- Theo số lượt yêu thích
- Theo giá (tăng/giảm)
- Theo độ phổ biến

### 3. 🎁 Gợi ý sản phẩm thông minh

#### Gợi ý cá nhân hóa
- Dựa trên lịch sử mua hàng
- Dựa trên sản phẩm yêu thích
- Dựa trên phong cách người dùng
- Dựa trên ngân sách

#### Gợi ý theo xu hướng
- Sản phẩm bán chạy nhất
- Sản phẩm được yêu thích nhất
- Sản phẩm đánh giá cao nhất

#### Gợi ý theo mùa
- Mùa xuân: Nhẹ, thoáng, màu sắc
- Mùa hè: Thoáng khí, mát, nhẹ
- Mùa thu: Ấm, cổ điển, tối màu
- Mùa đông: Ấm, chống nước, dày

### 4. 📊 Phân tích xu hướng và tư vấn cá nhân hóa

#### Phân tích profile người dùng
- Giới tính dựa trên lịch sử mua hàng
- Độ tuổi dựa trên sở thích
- Phong cách dựa trên danh mục đã mua
- Ngân sách dựa trên giá trị đơn hàng

#### Tư vấn outfit
- Gợi ý quần áo phù hợp với giày
- Gợi ý phụ kiện đi kèm
- Tư vấn phối đồ theo phong cách

#### So sánh sản phẩm
- So sánh tính năng
- So sánh giá cả
- So sánh đánh giá
- Phân tích ưu/nhược điểm

## 🚀 API Endpoints

### ChatBot Chính
```bash
# Gửi tin nhắn
POST /chat
{
    "message": "Tôi muốn tìm giày thể thao cho nam dưới 2 triệu"
}

# Lấy lịch sử chat
GET /chat/history

# Thêm vào giỏ hàng
POST /chat/add-to-cart
{
    "product_id": 1,
    "quantity": 1
}
```

### Demo API
```bash
# Phân tích xu hướng
GET /chatbot-demo/trends

# Gợi ý cá nhân hóa
GET /chatbot-demo/personalized?user_id=1

# Phân tích phong cách
GET /chatbot-demo/style-analysis?user_id=1

# Gợi ý outfit
GET /chatbot-demo/outfit-suggestions?product_id=1

# Phân tích ngân sách
GET /chatbot-demo/budget-analysis?user_id=1

# Gợi ý theo mùa
GET /chatbot-demo/seasonal

# Tìm kiếm thông minh
POST /chatbot-demo/smart-search
{
    "query": "giày thể thao",
    "filters": {
        "category": "thể thao",
        "price_max": 2000000,
        "rating_min": 4
    }
}

# So sánh sản phẩm
POST /chatbot-demo/compare
{
    "product_ids": [1, 2, 3]
}

# Hướng dẫn size
GET /chatbot-demo/size-guide

# Tất cả tính năng
GET /chatbot-demo/all-features?user_id=1
```

## 💡 Ví dụ sử dụng

### 1. Tìm kiếm sản phẩm thông minh
```
User: "Tôi muốn tìm giày chạy bộ cho nam, giá dưới 3 triệu, đánh giá từ 4 sao trở lên"

Bot: "Tôi đã tìm thấy những sản phẩm phù hợp với yêu cầu của bạn:
- Nike Air Max (Nike) - 2,500,000đ ⭐⭐⭐⭐⭐ (15 đánh giá)
- Adidas Ultraboost (Adidas) - 2,800,000đ ⭐⭐⭐⭐⭐ (12 đánh giá)
..."
```

### 2. Tư vấn phong cách
```
User: "Tôi nên mặc gì với giày Nike Air Max này?"

Bot: "Với giày Nike Air Max thể thao, tôi gợi ý bạn:
- Quần short thể thao
- Áo thun thể thao
- Tất thể thao
- Mũ lưỡi trai

Phong cách này sẽ tạo vẻ năng động và thoải mái cho bạn."
```

### 3. So sánh sản phẩm
```
User: "So sánh Nike Air Max và Adidas Ultraboost"

Bot: "Đây là so sánh chi tiết:

Nike Air Max:
✅ Đánh giá cao từ khách hàng
✅ Nhiều đánh giá
✅ Giá hợp lý
❌ Ít tính năng đặc biệt

Adidas Ultraboost:
✅ Đánh giá cao từ khách hàng
✅ Nhiều đánh giá
✅ Đế mềm, thoáng khí
❌ Giá cao hơn"
```

## 🔧 Cấu hình

### Environment Variables
```env
GEMINI_API_KEY=your_gemini_api_key_here
```

### Database Requirements
- Bảng `products` với các trường: name, price, brand_id, category_id, status
- Bảng `product_reviews` với các trường: product_id, user_id, rating, comment
- Bảng `favorites` với các trường: user_id, product_id
- Bảng `orders` và `order_details` để theo dõi lịch sử mua hàng

## 📈 Hiệu suất

### Tối ưu hóa
- Cache kết quả phân tích xu hướng
- Lazy loading cho relationships
- Index database cho các trường tìm kiếm
- Giới hạn kết quả trả về (8-10 sản phẩm)

### Monitoring
- Log lỗi API calls
- Track thời gian phản hồi
- Monitor tỷ lệ thành công
- Analytics về các loại câu hỏi

## 🎯 Roadmap

### Phase 1 (Đã hoàn thành)
- ✅ Tư vấn theo nhu cầu cơ bản
- ✅ Bộ lọc thông minh
- ✅ Gợi ý sản phẩm
- ✅ Phân tích xu hướng

### Phase 2 (Đang phát triển)
- 🔄 Tích hợp AI vision để phân tích ảnh
- 🔄 Chatbot voice
- 🔄 Tích hợp với social media
- 🔄 A/B testing cho responses

### Phase 3 (Kế hoạch)
- 📋 Tích hợp với CRM
- 📋 Predictive analytics
- 📋 Multi-language support
- 📋 Advanced sentiment analysis

## 🤝 Đóng góp

Để đóng góp vào dự án, vui lòng:
1. Fork repository
2. Tạo feature branch
3. Commit changes
4. Push to branch
5. Tạo Pull Request

## 📞 Hỗ trợ

Nếu có vấn đề hoặc câu hỏi, vui lòng liên hệ:
- Email: support@f1genz.com
- Phone: 1800-67-50
- Website: https://f1genz-shoes.com

---

**F1GENZ Shoes** - Nâng tầm trải nghiệm mua sắm với AI thông minh! 🚀 