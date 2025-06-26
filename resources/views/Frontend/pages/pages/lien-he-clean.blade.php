<!doctype html>
<html class="no-js" lang="vi">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    @include('Frontend.partials.head')
    
    <!-- Additional styles for contact page -->
    <link href="{{ asset('css/page.scsse889.css') }}" rel="stylesheet" type="text/css" media="all">
    
    <style>
        /* Alert Messages */
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert ul {
            margin: 10px 0 0 20px;
        }
        
        /* Mobile responsive for form */
        @media (max-width: 768px) {
            .page-about-new .page-about-new-main .page-about-new-contact form textarea {
                width: 100% !important;
                margin-bottom: 15px;
            }
            
            .page-about-new .page-about-new-main .page-about-new-contact form button {
                width: 100% !important;
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="">
    @include('Frontend.partials.header')

    <main class="main-layout">
        <div class="page-about-new" data-page-id="2404016">
            <div class="container">
                <div class="page-about-new-main">
                    
                    <!-- About Section -->
                    <div class="page-about-new-main-item">
                        <div class="page-about-new-main-item-left">
                            <img loading="eager" decoding="sync" fetchpriotrity="high" title="Về Chúng Tôi"
                                src="{{asset('images/page-about-new-image-1e889.jpg')}}"
                                alt="Về Chúng Tôi">
                        </div>
                        <div class="page-about-new-main-item-right">
                            <div class="section-title-all">
                                <span>Về Chúng Tôi</span>
                                <p>F1GENZ BABIE chính là nơi hội tụ những thương hiệu uy tín, những sản phẩm dành cho mẹ
                                    và bé chính hãng, chất lượng hàng đầu tại Việt Nam. Không những thế, F1GENZ BABIE
                                    mang đến cho Ba/mẹ những trải nghiệm mua sắm tuyệt vời, đáng tin cậy và cam kết cung
                                    cấp các dịch vụ chăm sóc khách hàng, tư vấn bán hàng, tư vấn sử dụng sản phẩm và các
                                    dịch vụ giao nhận hàng tốt nhất.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Info Section -->
                    <div class="page-about-new-main-item">
                        <div class="page-about-new-main-item-left">
                            <img loading="lazy" decoding="async" title="Liên hệ"
                                src="{{asset('images/page-about-new-image-2e889.jpg')}}"
                                alt="Liên hệ">
                        </div>
                        <div class="page-about-new-main-item-right">
                            <div class="section-title-all">
                                <span>Liên hệ</span>
                                <p>Chúng tôi luôn sẵn sàng lắng nghe bạn! Nếu bạn có bất kỳ câu hỏi nào về sản phẩm, đơn hàng, chính sách đổi trả hay chỉ đơn giản là muốn góp ý để chúng tôi phục vụ tốt hơn, đừng ngần ngại liên hệ. Đội ngũ chăm sóc khách hàng của chúng tôi hoạt động 24/7 để đảm bảo mọi thắc mắc của bạn được giải đáp nhanh chóng và tận tình.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Form Section -->
                    <div class="page-about-new-contact">
                        <div class="section-title-all" style="width: 100%; text-align: center; margin-bottom: 40px;">
                            <span>Kết nối ngay với chúng tôi</span>
                            <h1 hidden>Liên hệ</h1>
                        </div>
                        
                        <!-- Messages -->
                        @if(session('success'))
                            <div class="alert alert-success" style="width: 100%; margin-bottom: 20px;">
                                <strong>✅ Thành công!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-error" style="width: 100%; margin-bottom: 20px;">
                                <strong>❌ Có lỗi!</strong> {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-error" style="width: 100%; margin-bottom: 20px;">
                                <strong>❌ Lỗi validation:</strong>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Contact Form -->
                        <form method="POST" action="{{ route('contact.store') }}" id="main-contact-form">
                            @csrf
                            
                            <input type="text" name="name" placeholder="Họ và tên *" 
                                   value="{{ old('name') }}" required>
                            
                            <input type="tel" name="phone" placeholder="Số điện thoại *" 
                                   value="{{ old('phone') }}" required>
                            
                            <input type="email" name="email" placeholder="Email *" 
                                   value="{{ old('email') }}" required>
                                   
                            <input type="text" name="subject" placeholder="Chủ đề *" 
                                   value="{{ old('subject') }}" required>
                            
                            <textarea name="message" placeholder="Nội dung tin nhắn *" required>{{ old('message') }}</textarea>
                            
                            <button type="submit" id="main-submit-btn">
                                <span id="main-btn-text">Gửi thông tin</span>
                                <span id="main-btn-loading" style="display: none;">Đang gửi...</span>
                            </button>
                        </form>

                        <!-- Contact Map -->
                        <div class="page-about-new-contact-map">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.5430080343493!2d106.62715921533359!3d10.852776492269906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752bee0b0ef9e5%3A0x5b4da59e47aa97a8!2zQ29sZWdlIG9mIEVkdWNhdGlvbiAtIEhVTUc!5e0!3m2!1sen!2s!4v1645145145145!5m2!1sen!2s"
                                allowfullscreen="" 
                                loading="lazy"
                                title="Bản đồ F1GENZ Shoes">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('Frontend.partials.footer')

    <!-- Contact Form JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Contact form loaded successfully');
        
        const form = document.getElementById('main-contact-form');
        const submitBtn = document.getElementById('main-submit-btn');
        const btnText = document.getElementById('main-btn-text');
        const btnLoading = document.getElementById('main-btn-loading');

        if (!form || !submitBtn) {
            console.error('❌ Form elements not found');
            return;
        }

        form.addEventListener('submit', function(e) {
            console.log('📤 Form submitting...');
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            
            // Basic validation
            const name = form.querySelector('input[name="name"]').value.trim();
            const phone = form.querySelector('input[name="phone"]').value.trim();
            const email = form.querySelector('input[name="email"]').value.trim();
            const subject = form.querySelector('input[name="subject"]').value.trim();
            const message = form.querySelector('textarea[name="message"]').value.trim();
            
            if (!name || !phone || !email || !subject || !message) {
                e.preventDefault();
                alert('❌ Vui lòng điền đầy đủ thông tin!');
                
                // Reset button state
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('❌ Email không hợp lệ!');
                
                // Reset button state
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                return;
            }
            
            // Phone validation (basic)
            const phoneRegex = /^[0-9+\-\s()]{10,15}$/;
            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                alert('❌ Số điện thoại không hợp lệ!');
                
                // Reset button state
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                return;
            }
            
            console.log('✅ Form validation passed, submitting...');
        });

        // Reset button state if form submission fails
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            }
        });
    });
    </script>

</body>
</html> 