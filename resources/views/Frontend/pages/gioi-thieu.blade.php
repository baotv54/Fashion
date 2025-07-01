<!doctype html>
<html class="no-js" lang="vi">

<head>
    @include('Frontend.partials.head')
    {{-- Thêm CSS dành riêng cho trang giới thiệu tại đây nếu cần --}}
    <style>
      
        .about-section {
            padding: 60px 0; 
        }

       
        .banner-section,
        .product-intro-section,
        .shop-intro-section,
        .footer-contact-social {
            background-color: transparent; 
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px; 
            font-size: 2rem; 
            font-weight: bold;
            color: #333; 
        }

        .product-item {
             margin-bottom: 30px;
        }

        .product-item-wrap {
            border: 1px solid #eee; 
            padding: 15px;
            text-align: center;
        }

        .product-item-image img {
             width: 100%;
             height: auto;
             margin-bottom: 10px;
        }

         .product-item-detail-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
         }

        .product-item-detail-name a {
            color: #333;
            text-decoration: none;
        }

        .product-item-detail-price span {
            font-size: 1rem;
            color: #e74c3c; 
            font-weight: bold;
        }


        .social-icons a {
            margin: 0 10px;
            color: inherit; 
            font-size: 1.5rem;
            text-decoration: none;
        }

         .footer-contact-social h3 {
            margin-bottom: 20px;
         }

         .footer-contact-social p {
            margin-bottom: 10px;
         }

    </style>
</head>

<body class="">
    @include('Frontend.partials.header')

    <main class="main-layout">
        <!-- Banner Section -->
        <section id="home-slider">
            <div class="home-slider-main">
                <div class="home-slider-main-item">
                    <a href="collections/all.html" aria-label="<b>CONVERSE</b> <br />  Sale tất cả sản phẩm">
                        <picture>
                            <source width="600" height="800" media="(max-width: 600px)" srcset="{{asset('images/slider_xs_1e889.jpg.jpg')}}">
                            <source width="1920" height="700" media="(min-width: 601px)" srcset="{{asset('images/slider_lg_1e889.jpg')}}">
                            <img width="1920" height="700" loading="eager" fetchpriority="high" decoding="sync"
                                src="{{asset('images/slider_lg_1e889.jpg')}}" class="w-100" title="<b>CONVERSE</b> <br />  Sale tất cả sản phẩm" alt="<b>CONVERSE</b> <br />  Sale tất cả sản phẩm" />
                        </picture>
                        <div class="home-slider-item-content">
                            <div class="container">
                                <h2><b>CONVERSE</b> <br /> Sale tất cả sản phẩm</h2>
                                <p>Giảm 10% cho tất cả sản phẩm</p>
                                <span>Mua ngay</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="home-slider-main-item">
                    <a href="collections/all.html" aria-label="<b>CONVERSE</b> <br /> Mùa hè năng động">
                        <picture>
                            <source width="600" height="800" media="(max-width: 600px)" srcset="{{asset('images/slider_xs_2.jpg')}}">
                            <source width="1920" height="700" media="(min-width: 601px)" srcset="{{asset('images/slider_lg_2e889.jpg')}}">
                            <img width="1920" height="700" loading="lazy" decoding="async"
                                src="{{asset('images/slider_lg_2e889.jpg')}}" class="w-100" title="<b>CONVERSE</b> <br /> Mùa hè năng động" alt="<b>CONVERSE</b> <br /> Mùa hè năng động" />
                        </picture>
                        <div class="home-slider-item-content">
                            <div class="container">
                                <h2><b>CONVERSE</b> <br /> Mùa hè năng động</h2>
                                <p>Nhâp ngay mã F1CHAOHE</p>
                                <span>Mua ngay</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="home-slider-main-item">
                    <a href="collections/all.html" aria-label="<b>CONVERSE</b> <br />Bộ sưu tập mới">
                        <picture>
                            <source width="600" height="800" media="(max-width: 600px)" srcset="{{asset('images/slider_xs_3.jpg')}}">
                            <source width="1920" height="700" media="(min-width: 601px)" srcset="{{asset('images/slider_lg_3e889.jpg')}}">
                            <img width="1920" height="700" loading="lazy" decoding="async"
                                src="{{asset('images/slider_lg_3e889.jpg')}}" class="w-100" title="<b>CONVERSE</b> <br />Bộ sưu tập mới" alt="<b>CONVERSE</b> <br />Bộ sưu tập mới" />
                        </picture>
                        <div class="home-slider-item-content">
                            <div class="container">
                                <h2><b>CONVERSE</b> <br />Bộ sưu tập mới</h2>
                                <p>Chuck 70 luôn tươi</p>
                                <span>Xem ngay</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- New Products Introduction Section -->
        <section class="about-section product-intro-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h2 class="section-title text-md-left">SẢN PHẨM MỚI<br>VUI LÒNG CHỌN SẢN PHẨM</h2>
                        <a href="{{ route('products.all') }}" class="btn btn-secondary">XEM THÊM</a>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-md-4">
                                <div class="product-item">
                                    <div class="product-item-wrap">
                                        <div class="product-item-image">
                                            <a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">
                                                <img class="w-auto" loading="lazy" width="480" height="480"
                                                    src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                    alt="{{ $product->name }}" title="{{ $product->name }}">
                                            </a>
                                        </div>
                                        <div class="product-item-detail">
                                            <h3 class="product-item-detail-name">
                                                <a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                            </h3>
                                            <div class="product-item-detail-price">
                                                <span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Shop Introduction Section -->
        <section class="home-about">
            <div class="container">
                <div class="home-about-top">
                    <span><img loading="lazy" decoding="async" title="Giới thiệu Shop" src="{{ asset('images/slider_lg_1e889.jpg')}}" alt="Hình ảnh banner 1" /></span>
                    <div class="section-title-all">
                        <div>
                            <span>VỀ CHÚNG TÔI</span>
                            <h2>Giới thiệu về Shop</h2>
                        </div>
                        <p>Chào mừng bạn đến với cửa hàng giày F1GENZ Shoes! Chúng tôi tự hào mang đến những mẫu giày thời trang và chất lượng nhất, phù hợp với mọi phong cách và nhu cầu của bạn. Với sứ mệnh mang đến sự thoải mái và tự tin trên từng bước chân, chúng tôi luôn cập nhật những bộ sưu tập mới nhất từ các thương hiệu uy tín. Khám phá ngay bộ sưu tập của chúng tôi và tìm đôi giày hoàn hảo cho bạn!</p>
                    </div>
                </div>
                <div class="home-about-bot">
                    <span><img loading="lazy" decoding="async" title="Giới thiệu Shop" src="{{ asset('images/slider_lg_2e889.jpg')}}" alt="Hình ảnh banner 2" /></span>
                </div>
            </div>
        </section>

    </main>

    @include('Frontend.partials.footer')

</body>

</html> 