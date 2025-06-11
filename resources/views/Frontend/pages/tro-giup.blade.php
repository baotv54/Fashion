@extends('Frontend.layouts.app') {{-- Giả định có một layout chính tên là app.blade.php trong Frontend/layouts --}}

@section('title', 'Trợ giúp & Câu hỏi thường gặp')

@section('content')
<style>
    .help-page {
        padding: 50px 0;
        background-color: #f8f8f8;
    }
    .help-page h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 36px;
        color: #333;
    }
    .search-bar {
        text-align: center;
        margin-bottom: 50px;
    }
    .search-bar input {
        width: 60%;
        padding: 12px 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }
    .search-bar button {
        padding: 12px 25px;
        background-color: #f0c040;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        margin-left: 10px;
    }
    .faq-section {
        max-width: 900px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .faq-category h3 {
        font-size: 24px;
        color: #555;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .faq-item {
        margin-bottom: 15px;
    }
    .faq-question {
        font-weight: bold;
        cursor: pointer;
        padding: 10px 0;
        color: #333;
    }
    .faq-answer {
        display: none; /* Hidden by default */
        padding: 10px 0 10px 20px;
        color: #666;
        border-top: 1px dashed #eee;
    }
    .contact-section {
        text-align: center;
        margin-top: 50px;
        padding: 30px;
        background-color: #eee;
        border-radius: 8px;
    }
    .contact-section p {
        font-size: 18px;
        margin-bottom: 20px;
    }
    .contact-section a {
        background-color: #007bff;
        color: white;
        padding: 12px 30px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 18px;
    }
</style>

<div class="help-page">
    <div class="container">
        <h2>Trợ giúp & Câu hỏi thường gặp</h2>
        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm câu hỏi của bạn...">
            <button>Tìm kiếm</button>
        </div>

        <div class="faq-section">
            <div class="faq-category">
                <h3>Đặt hàng & Thanh toán</h3>
                <div class="faq-item">
                    <div class="faq-question">Làm thế nào để đặt hàng?</div>
                    <div class="faq-answer">Bạn có thể đặt hàng trực tuyến thông qua trang web của chúng tôi bằng cách thêm sản phẩm vào giỏ hàng và tiến hành thanh toán.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Các phương thức thanh toán được chấp nhận là gì?</div>
                    <div class="faq-answer">Chúng tôi chấp nhận thanh toán bằng thẻ tín dụng/ghi nợ (Visa, Mastercard, Amex), PayPal, và chuyển khoản ngân hàng.</div>
                </div>
                 <div class="faq-item">
                    <div class="faq-question">Làm cách nào để kiểm tra trạng thái đơn hàng của tôi?</div>
                    <div class="faq-answer">Bạn có thể kiểm tra trạng thái đơn hàng trong phần 'Tài khoản của tôi' hoặc bằng cách sử dụng liên kết theo dõi đơn hàng được gửi đến email của bạn.</div>
                </div>
            </div>

            <div class="faq-category">
                <h3>Vận chuyển & Giao hàng</h3>
                <div class="faq-item">
                    <div class="faq-question">Thời gian giao hàng là bao lâu?</div>
                    <div class="faq-answer">Thời gian giao hàng tiêu chuẩn là 3-5 ngày làm việc. Thời gian cụ thể có thể thay đổi tùy thuộc vào địa điểm.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Chi phí vận chuyển được tính như thế nào?</div>
                    <div class="faq-answer">Chi phí vận chuyển được tính dựa trên trọng lượng đơn hàng và địa điểm giao hàng. Bạn sẽ thấy chi phí chính xác khi thanh toán.</div>
                </div>
            </div>

            <div class="faq-category">
                <h3>Đổi trả & Hoàn tiền</h3>
                <div class="faq-item">
                    <div class="faq-question">Chính sách đổi trả sản phẩm của bạn là gì?</div>
                    <div class="faq-answer">Chúng tôi chấp nhận đổi trả sản phẩm trong vòng 7 ngày kể từ ngày nhận hàng, với điều kiện sản phẩm còn nguyên vẹn và chưa qua sử dụng.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Làm thế nào để yêu cầu hoàn tiền?</div>
                    <div class="faq-answer">Để yêu cầu hoàn tiền, vui lòng liên hệ bộ phận hỗ trợ khách hàng của chúng tôi với số đơn hàng của bạn.</div>
                </div>
            </div>
        </div>

        <div class="contact-section">
            <p>Không tìm thấy câu trả lời bạn cần?</p>
            <a href="contact.html">Liên hệ với chúng tôi</a> {{-- Thay đổi 'contact.html' bằng đường dẫn thực tế đến trang liên hệ của bạn --}}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                } else {
                    answer.style.display = 'block';
                }
            });
        });

        // Client-side validation for search bar
        const searchInput = document.querySelector('.search-bar input');
        const searchButton = document.querySelector('.search-bar button');

        searchButton.addEventListener('click', (event) => {
            if (searchInput.value.trim() === '') {
                event.preventDefault(); // Ngăn chặn gửi form nếu trống
                alert('Vui lòng nhập từ khóa tìm kiếm.');
                searchInput.focus();
            }
        });
    });
</script>
@endsection 