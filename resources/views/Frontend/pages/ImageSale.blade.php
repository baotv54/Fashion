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
        <div class="modal" tabindex="-1" role="dialog" id="shop-modal-contact">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="modal-contact">
                        <div class="modal-contact-wrap">
                            <div class="modal-contact-wrap-right">
                                <div class="modal-contact-wrap-right-content">
                                    <div class="section-title-all">
                                        <span>Đăng ký nhận tin</span>
                                        <p>Để lại thông tin, để nhận ngay khuyến mãi từ chúng tôi nhé!</p>
                                    </div>
                                    <form id="mc-form2"
                                        action="https://gmail.us21.list-manage.com/subscribe/post?u=ddd0880c66f534593afa12e75&amp;id=fe6449bc79&amp;f_id=00cd9be1f0">
                                        <input title="Địa chỉ Email" type="email" placeholder="Nhập email ưu đãi"
                                            name="EMAIL" required autocomplete="off">
                                        <button type="submit" title="Đăng ký nhận tin" name="subscribe">Đăng
                                            ký</button>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-contact-wrap-left">
                                <img width="480" height="480" loading="lazy"
                                    src="../bizweb.dktcdn.net/thumb/large/100/493/370/themes/940719/assets/shop_modal_contact_imagee889.png?1713464283843"
                                    alt=" - Contact">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    title="{{ $product->name }}">
                                                    <img class="w-auto" loading="lazy" width="480" height="480"
                                                        src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                        alt="{{ $product->name }}" title="{{ $product->name }}">
                                                </a>
                                            </div>
                                            <div class="product-item-detail">
                                                <h3 class="product-item-detail-name">
                                                    <a href="{{ route('product.show', $product->id) }}"
                                                        title="{{ $product->name }}">{{ $product->name }}</a>
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
                    <span><img loading="lazy" decoding="async" title="Giới thiệu Shop"
                            src="{{ asset('images/slider_lg_1e889.jpg') }}" alt="Hình ảnh banner 1" /></span>
                    <div class="section-title-all">
                        <div>
                            <span>VỀ CHÚNG TÔI</span>
                            <h2>Giới thiệu về Shop</h2>
                        </div>
                        <p>Chào mừng bạn đến với cửa hàng giày F1GENZ Shoes! Chúng tôi tự hào mang đến những mẫu giày
                            thời trang và chất lượng nhất, phù hợp với mọi phong cách và nhu cầu của bạn. Với sứ mệnh
                            mang đến sự thoải mái và tự tin trên từng bước chân, chúng tôi luôn cập nhật những bộ sưu
                            tập mới nhất từ các thương hiệu uy tín. Khám phá ngay bộ sưu tập của chúng tôi và tìm đôi
                            giày hoàn hảo cho bạn!</p>
                    </div>
                </div>
                <div class="home-about-bot">
                    <span><img loading="lazy" decoding="async" title="Giới thiệu Shop"
                            src="{{ asset('images/slider_lg_2e889.jpg') }}" alt="Hình ảnh banner 2" /></span>
                </div>
            </div>
        </section>

    </main>

    @include('Frontend.partials.footer')

</body>

</html>
