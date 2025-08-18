<!doctype html>
<html class="no-js" lang="vi">

<head>
    @include('Frontend.partials.head')
    <title>Liên hệ&ndash; F1GENZ Shoes</title>

    <style>
        :root{
            --color_bg: #FFF;
            --color_bg_item: #F9F9F9;
            --color_main: #fcc419;
            --color_main2:  #2e3192;
            --color_main3: #fce3ea;
            --color1: #333;
            --color2: #FFF;
            --border_radius: 10px;
            --image_title: url("//bizweb.dktcdn.net/100/493/370/themes/940719/assets/image_title_all.png?1713464283843");
        }
        body, html{
            font-family: 'Oswald', sans-serif !important;
            background-color: var(--color_bg) !important;
        }
        .preload * { -webkit-transition: none !important; -moz-transition: none !important; -ms-transition: none !important;	-o-transition: none !important; }
        .w-100{ width: 100% !important; }

        .home-main-slider .home-main-slider-items:not(.slick-slider){ display: flex; overflow: hidden; }
        .home-main-slider .home-main-slider-items:not(.slick-slider) .home-main-slider-item{ min-width: 100%; }
        
        .lazyload{ opacity: 0; visibility: hidden }
        .lazyload.loaded{ opacity: 1; visibility: visible }
        
        @media(max-width: 1024px){
            footer.footer,
            footer.footers2{ padding-bottom: 50px; }
        }
        
        /* Page Contact Layout */
        .page-contact-main {
            padding: 80px 0;
        }
        
        .contact-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            align-items: center;
            margin-bottom: 80px;
            min-height: 400px;
        }
        
        .contact-section:nth-child(even) .contact-content {
            order: 2;
        }
        
        .contact-section:nth-child(even) .contact-image {
            order: 1;
        }
        
        .contact-content {
            padding: 60px;
            background: #f8f9fa;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .contact-content h2 {
            color: var(--color_main);
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 30px;
            position: relative;
        }
        
        .contact-content h2:before {
            content: "👤";
            margin-right: 15px;
        }
        
        .contact-section:nth-child(even) .contact-content h2:before {
            content: "📞";
        }
        
        .contact-content p {
            color: #666;
            font-size: 16px;
            line-height: 1.8;
            text-align: justify;
        }
        
        .contact-image {
            height: 400px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
        }
        
        .contact-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Contact Form Section */
        .contact-form-section {
            padding: 89px 0;
            background: #f8f9fa;
        }
        
                 .contact-form-wrapper {
             display: grid;
             grid-template-columns: 1fr 1fr;
             gap: 60px;
             align-items: stretch;
             height: 630px;
         }
        
        .contact-form-left h2 {
            color: var(--color_main);
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 40px;
            position: relative;
        }
        
        .contact-form-left h2:before {
            content: "👋";
            margin-right: 15px;
        }
        
                 .contact-form {
             background: white;
             padding: 40px;
             border-radius: 15px;
             box-shadow: 0 10px 30px rgba(0,0,0,0.1);
             height: 67%;
             display: flex;
             flex-direction: column;
         }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--color_main);
            background: white;
            box-shadow: 0 0 0 3px rgba(252, 196, 25, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .btn-submit {
            background: linear-gradient(45deg, var(--color_main), #e67e22);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(252, 196, 25, 0.4);
        }
        
                 .contact-map {
             border-radius: 15px;
             overflow: hidden;
             box-shadow: 0 10px 30px rgba(0,0,0,0.1);
             height: 100%;
         }
        
        .contact-map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            border: none;
        }
        
        .alert-success {
            background: linear-gradient(45deg, #d4edda, #c3e6cb);
            color: #155724;
        }
        
        .alert-danger {
            background: linear-gradient(45deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--color_main);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(252, 196, 25, 0.4);
        }
        
        .social-icon img {
            width: 30px;
            height: 30px;
        }
        
        /* Responsive */
        @media (max-width: 968px) {
            .contact-section,
            .contact-form-wrapper {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .contact-section:nth-child(even) .contact-content,
            .contact-section:nth-child(even) .contact-image {
                order: 0;
            }
            
            .contact-content {
                padding: 40px 30px;
            }
            
            .contact-content h2,
            .contact-form-left h2 {
                font-size: 28px;
            }
            
            .contact-image {
                height: 300px;
            }
        }
        
                 @media (max-width: 576px) {
             .contact-content {
                 padding: 30px 20px;
             }
             
             .contact-form {
                 padding: 30px 20px;
             }
             
             .contact-form-section {
                 padding: 60px 0;
             }
             
             .page-contact-main {
                 padding: 60px 0;
             }
         }
         

    </style>


</head>

<body class="">
    @include('Frontend.partials.header')
    
    <main class="main-layout">
        <div class="page-contact-main">
            <div class="container">
                <!-- Section 1: Về Chúng Tôi -->
                <div class="contact-section">
                    <div class="contact-content">
                        <h2>VỀ CHÚNG TÔI</h2>
                        <p>F1GENZ BABIE chính là nơi hội tụ những thương hiệu uy tín, những sản phẩm dành cho mẹ và bé chính hãng, chất lượng hàng đầu tại Việt Nam. Không những thế, F1GENZ BABIE mang đến cho Ba/mẹ những trải nghiệm mua sắm tuyệt vời, đáng tin cậy và cam kết cung cấp các dịch vụ chăm sóc khách hàng, tư vấn bán hàng, tư vấn sử dụng sản phẩm và các dịch vụ giao nhận hàng tốt nhất.</p>
                    </div>
                    <div class="contact-image">
                        <img src="{{asset('images/page-about-new-image-1e889.jpg')}}" alt="Về Chúng Tôi">
                    </div>
                </div>

                <!-- Section 2: Liên Hệ -->
                <div class="contact-section">
                    <div class="contact-content">
                        <h2>LIÊN HỆ</h2>
                        <p>Chúng tôi luôn sẵn sàng lắng nghe bạn! Nếu bạn có bất kỳ câu hỏi nào về sản phẩm, đơn hàng, chính sách đổi trả hay chỉ đơn giản là muốn góp ý để chúng tôi phục vụ tốt hơn, đừng ngần ngại liên hệ. Đội ngũ chăm sóc khách hàng của chúng tôi hoạt động 24/7 để đảm bảo mọi thắc mắc của bạn được giải đáp nhanh chóng và tận tình. Hãy liên hệ với chúng tôi qua form bên dưới hoặc thông qua thông tin liên hệ.</p>
                    </div>
                    <div class="contact-image">
                        <img src="{{asset('images/page-about-new-image-2e889.jpg')}}" alt="Liên Hệ">
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="contact-form-section">
            <div class="container">
                <div class="contact-form-wrapper">
                    <div class="contact-form-left">
                        <h2>KẾT NỐI NGAY VỚI CHÚNG TÔI</h2>
                        
                        <!-- Thông báo success/error -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('contact.store') }}" accept-charset="UTF-8" class="contact-form">
                            @csrf
                            
                            <div class="form-group">
                                <input required type="text" class="form-control"
                                    name="name" placeholder="Tên của bạn" autocapitalize="words"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <input required type="text" class="form-control"
                                    name="phone" placeholder="Số điện thoại của bạn" autocapitalize="words"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <input required type="email" name="email" placeholder="Email của bạn"
                                    class="form-control" autocapitalize="off"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <textarea required rows="6" name="message" class="form-control" placeholder="Viết bình luận">{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn-submit" title="Gửi thông tin">Gửi thông tin</button>
                        </form>

                                                 <div style="flex-grow: 1;"></div>
                         
                         <div class="social-icons">
                            <a href="#" class="social-icon" target="_blank"
                                aria-label="F1GENZ Shoes - Facebook" title="F1GENZ Shoes - Facebook">
                                <img src="{{asset('images/facebook__6__53aaa8d352524d3eb025af5203eaa437_icon.png')}}"
                                    alt="Facebook">
                            </a>

                            <a href="#" class="social-icon" target="_blank"
                                aria-label="F1GENZ Shoes - Youtube" title="F1GENZ Shoes - Youtube">
                                <img src="{{asset('images/youtube__5__4f04522e10494557a651f53a33ad4d76_icon.png')}}"
                                    alt="Youtube">
                            </a>

                            <a href="#" class="social-icon" target="_blank"
                                aria-label="F1GENZ Shoes - Pinterest" title="F1GENZ Shoes - Pinterest">
                                <img src="{{asset('images/pinterest_a1a15995132a4275845412deba5f1193_icon.png')}}"
                                    alt="Pinterest">
                            </a>

                            <a href="#" class="social-icon" target="_blank"
                                aria-label="F1GENZ Shoes - Tik Tok" title="F1GENZ Shoes - Tik Tok">
                                <img src="{{asset('images/tik-tok_d85bb4e7468c43ac9ed5437649b7405c_icon.png')}}"
                                    alt="Tik Tok">
                            </a>

                            <a href="#" class="social-icon" target="_blank"
                                aria-label="F1GENZ Shoes - Instagram" title="F1GENZ Shoes - Instagram">
                                <img src="{{asset('images/instagram__3__7de3ebbce1f24003b516ca6c1d7c24d5_icon.png')}}"
                                    alt="Instagram">
                            </a>
                        </div>
                    </div>
                    
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.665969128456!2d106.6917421147778!3d10.759621192336068!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1c06f4e1dd%3A0x43900f1d4539408b!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBGUFQgVFAuSENN!5e0!3m2!1svi!2s!4v1614677435123!5m2!1svi!2s" 
                                allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('Frontend.partials.footer')

    <script src="/js/plugin.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/page.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto scroll to alert if exists
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.add('show');
                alert.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                
                // Auto hide after 8 seconds
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                }, 8000);
            }
            
            // Clear form after successful submission
            @if(session('success'))
                const form = document.querySelector('.contact-form form');
                if (form) {
                    setTimeout(function() {
                        form.reset();
                    }, 1000);
                }
            @endif
            
            // Form submit animation
            const submitBtn = document.querySelector('.btn-submit');
            if (submitBtn) {
                submitBtn.addEventListener('click', function() {
                    this.innerHTML = 'Đang gửi...';
                    this.disabled = true;
                });
            }
            
            // Enhanced form validation feedback
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() !== '') {
                        this.style.borderColor = '#28a745';
                        this.style.backgroundColor = '#f8fff9';
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.style.borderColor === 'rgb(220, 53, 69)') {
                        this.style.borderColor = '#e9ecef';
                        this.style.backgroundColor = '#f8f9fa';
                    }
                });
            });
        });
    </script>
</body>
</html> 