@extends('Frontend.layouts.app') {{-- Giả định có một layout chính tên là app.blade.php trong Frontend/layouts --}}

@section('title', 'Điều khoản và Điều kiện sử dụng')

@section('content')
<style>
    .terms-page {
        padding: 50px 0;
        background-color: #f8f8f8;
    }
    .terms-page h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 36px;
        color: #333;
    }
    .terms-content {
        max-width: 900px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .terms-content h3 {
        font-size: 24px;
        color: #555;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-top: 30px;
        margin-bottom: 20px;
    }
    .terms-content p {
        line-height: 1.6;
        margin-bottom: 15px;
        color: #666;
    }
    .terms-content ul {
        list-style: decimal;
        padding-left: 20px;
        margin-bottom: 15px;
    }
    .terms-content ul li {
        margin-bottom: 10px;
        line-height: 1.6;
        color: #666;
    }
    .last-updated {
        text-align: center;
        margin-top: -20px;
        margin-bottom: 40px;
        color: #999;
        font-size: 14px;
    }
</style>

<div class="terms-page">
    <div class="container">
        <h2>Điều khoản và Điều kiện sử dụng</h2>
        <p class="last-updated">Cập nhật lần cuối: 12 tháng 6, 2024</p>

        <div class="terms-content">
            <h3>1. Giới thiệu</h3>
            <p>Chào mừng bạn đến với F1GENZ SHOES. Các điều khoản và điều kiện này quy định việc sử dụng trang web của chúng tôi. Bằng cách truy cập hoặc sử dụng trang web của chúng tôi, bạn đồng ý tuân thủ và bị ràng buộc bởi các điều khoản và điều kiện này.</p>

            <h3>2. Định nghĩa</h3>
            <ul>
                <li><strong>"Chúng tôi"</strong>, <strong>"Của chúng tôi"</strong> và <strong>"F1GENZ SHOES"</strong> đề cập đến công ty sở hữu và điều hành trang web này.</li>
                <li><strong>"Bạn"</strong> và <strong>"Người dùng"</strong> đề cập đến cá nhân hoặc tổ chức truy cập hoặc sử dụng trang web của chúng tôi.</li>
                <li><strong>"Sản phẩm"</strong> đề cập đến các mặt hàng giày dép và phụ kiện được bán trên trang web của chúng tôi.</li>
                <li><strong>"Dịch vụ"</strong> đề cập đến các dịch vụ được cung cấp thông qua trang web của chúng tôi, bao gồm nhưng không giới hạn ở việc duyệt sản phẩm, đặt hàng, thanh toán và hỗ trợ khách hàng.</li>
            </ul>

            <h3>3. Quyền và Trách nhiệm của Người dùng</h3>
            <p>Khi sử dụng trang web của chúng tôi, bạn đồng ý:</p>
            <ul>
                <li>Cung cấp thông tin chính xác và đầy đủ khi đăng ký tài khoản hoặc đặt hàng.</li>
                <li>Bảo mật thông tin đăng nhập của bạn và chịu trách nhiệm về mọi hoạt động diễn ra dưới tài khoản của bạn.</li>
                <li>Không sử dụng trang web cho bất kỳ mục đích bất hợp pháp hoặc trái phép nào.</li>
                <li>Không can thiệp vào hoạt động của trang web hoặc các dịch vụ liên quan.</li>
            </ul>

            <h3>4. Quyền và Trách nhiệm của F1GENZ SHOES</h3>
            <ul>
                <li>Chúng tôi có quyền sửa đổi hoặc chấm dứt dịch vụ bất cứ lúc nào mà không cần thông báo trước.</li>
                <li>Chúng tôi không đảm bảo rằng trang web sẽ không bị gián đoạn, không có lỗi hoặc an toàn.</li>
                <li>Chúng tôi có quyền từ chối dịch vụ, đóng tài khoản hoặc hủy đơn hàng theo quyết định riêng của mình.</li>
            </ul>

            <h3>5. Chính sách Bảo mật</h3>
            <p>Việc sử dụng trang web của bạn cũng chịu sự điều chỉnh của Chính sách Bảo mật của chúng tôi, vui lòng đọc để hiểu các hoạt động của chúng tôi về thu thập, sử dụng và tiết lộ thông tin cá nhân của bạn. <a href="chinh-sach-bao-mat.html" title="Chính sách Bảo mật">Xem Chính sách Bảo mật</a>.</p>

            <h3>6. Chính sách Đổi trả & Hoàn tiền</h3>
            <p>Đối với thông tin về việc đổi trả và hoàn tiền sản phẩm, vui lòng tham khảo Chính sách Đổi trả của chúng tôi. <a href="chinh-sach-doi-tra.html" title="Chính sách Đổi trả">Xem Chính sách Đổi trả</a>.</p>

            <h3>7. Quyền sở hữu trí tuệ</h3>
            <p>Tất cả nội dung trên trang web này, bao gồm văn bản, đồ họa, logo, hình ảnh, video, biểu tượng và phần mềm, là tài sản của F1GENZ SHOES hoặc các nhà cung cấp nội dung của nó và được bảo vệ bởi luật bản quyền và các luật sở hữu trí tuệ khác.</p>

            <h3>8. Giải quyết tranh chấp</h3>
            <p>Mọi tranh chấp phát sinh từ hoặc liên quan đến việc sử dụng trang web này sẽ được giải quyết thông qua đàm phán thiện chí. Nếu không thể đạt được thỏa thuận, tranh chấp sẽ được đưa ra giải quyết tại tòa án có thẩm quyền tại Việt Nam.</p>

            <h3>9. Thay đổi Điều khoản</h3>
            <p>Chúng tôi có thể cập nhật các điều khoản và điều kiện này theo thời gian. Mọi thay đổi sẽ có hiệu lực ngay lập tức sau khi chúng được đăng trên trang web. Việc bạn tiếp tục sử dụng trang web sau khi các thay đổi được đăng sẽ cấu thành sự chấp nhận của bạn đối với các điều khoản đã sửa đổi.</p>

            <h3>10. Liên hệ</h3>
            <p>Nếu bạn có bất kỳ câu hỏi nào về các Điều khoản và Điều kiện này, vui lòng liên hệ với chúng tôi qua email: <a href="mailto:support@sapo.vn">support@sapo.vn</a>.</p>
        </div>
    </div>
</div>
@endsection 