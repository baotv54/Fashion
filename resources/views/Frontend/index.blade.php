<!doctype html>
<html class="no-js" lang="vi">


<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    @include('Frontend.partials.head')
</head>

<body class="">
    @include('Frontend.partials.header')

    <main class="main-layout">
        <h1 class="d-none">F1GENZ Shoes</h1>
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
        <section class="home-policy">
            <div class="container">
                <div class="home-policy-wrap">

                    <a href="collections/all.html" class="home-policy-item" aria-label="F1GENZ Shoes - Giao hàng nhanh, miễn phí">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_1e889.png') }}" title="Giao hàng nhanh, miễn phí" alt="F1GENZ Shoes - Giao hàng nhanh, miễn phí" /></span>
                        <h3>Giao hàng nhanh, miễn phí</h3>
                        <p>Đơn hàng > 900k hoặc đăng ký tài khoản được giao hàng miễn phí</p>
                    </a>

                    <a href="collections/all.html" class="home-policy-item" aria-label="F1GENZ Shoes - Trả hàng, Bảo hành">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_2e889.png') }}" title="Trả hàng, Bảo hành" alt="F1GENZ Shoes - Trả hàng, Bảo hành" /></span>
                        <h3>Trả hàng, Bảo hành</h3>
                        <p>Không thích? Trả lại hoặc đổi hàng của bạn miễn phí trong vòng 30 ngày.</p>
                    </a>

                    <a href="collections/all.html" class="home-policy-item" aria-label="F1GENZ Shoes - Thành viên">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_3e889.png') }}" title="Thành viên" alt="F1GENZ Shoes - Thành viên" /></span>
                        <h3>Thành viên</h3>
                        <p>Ưu đãi theo từng cấp bậc hạng thành viên. Sinh nhật quà tặng thành viên</p>
                    </a>

                    <a href="collections/all.html" class="home-policy-item" aria-label="F1GENZ Shoes - Chính hãng">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_4e889.png') }}" title="Chính hãng" alt="F1GENZ Shoes - Chính hãng" /></span>
                        <h3>Chính hãng</h3>
                        <p>Sản phẩm chính hãng. Được nhập khẩu 100% từ hãng.</p>
                    </a>
                </div>
            </div>
        </section>

        <section class="home-fSale">
            <div class="container">
                <div class="home-fSale-wrap">
                    <div class="home-fSale-head">
                        <h2>
                            <img loading="lazy" decoding="async" title="F1GENZ Shoes - Flash Sale"
                                src="{{ asset('images/home_fsale_imagee889.png')}}" alt="F1GENZ Shoes - Flash Sale">
                        </h2>
                        <div class="home-fSale-head-countdown">
                            <label>Kết thúc sau</label>
                            <div data-time="1/4/2025 24:00:00" class="countdownLoop"></div>
                        </div>
                    </div>
                    <div class="home-fSale-body">
                        <div class="home-fSale-body-data">
                            @foreach ($products as $product)
                            <div class="product-item special" data-id="{{ $product->id }}" data-handle="{{ Str::slug($product->name) }}">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge" data-id="{{ $product->id }}"></div>
                                        <span class="product-item-discount">-{{ $product->discount ?? '11' }}%</span>
                                        <a class="product-item-link" href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            <li><a href="#"><img class="w-auto" loading="lazy" width="50" height="50" src="{{ asset($product->thumb1 ?? 'images/default.jpg') }}" alt=""></a></li>
                                            <li><a href="#"><img class="w-auto" loading="lazy" width="50" height="50" src="{{ asset($product->thumb2 ?? 'images/default.jpg') }}" alt=""></a></li>
                                            <li><a href="#"><img class="w-auto" loading="lazy" width="50" height="50" src="{{ asset($product->thumb3 ?? 'images/default.jpg') }}" alt=""></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <form method="POST" action="{{ route('favorites.store') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" title="Yêu thích">❤</button>
                                        </form>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                                            </svg></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <div class="product-item-sold">
                                            <label class="fSale_chayhang">
                                                <img loading="lazy" decoding="async" src="{{ asset('images/imager_8176_d244203aa9cf4dfbb410e1377abdac72_compact.gif') }}" alt="pro-loop-sold" />
                                                <span></span>
                                            </label>
                                            <div class="product-item-sold-wrap">
                                                <span style="--percent: 50%"></span>
                                            </div>
                                        </div>
                                        <h3 class="product-item-detail-name">
                                            <a href="{{ route('product.show', $product->id) }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            <span>{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data"></div>
                                            <div class="sapo-product-reviews-badge" data-id="{{ $product->id }}"></div>
                                        </div>
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                            <input type="hidden" value="1" name="quantity" />
                                            <button type="submit" title="Thêm vào giỏ" class="shop-addLoop-button cart">Thêm vào giỏ</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-coupon">
            <div class="container">
                <div class="home-coupon-wrap">
                    @foreach ($coupons as $coupon)
                    <div class="home-coupon-item">
                        <img loading="lazy" decoding="async" src="{{ asset('images/background-coupon_d5a81f5bc7ea49_ec6d59fdd17c4a718809792590ed9455.png')}}" alt="Mã : F1SHOES">
                        <div class="home-coupon-content">
                            <div class="home-coupon-content-head">
                                <h3>Mã : {{ $coupon->code }}</h3>
                                <img loading="lazy" decoding="async" src="{{ asset($coupon->image) }}" title="Mã : {{ $coupon->code }}" alt="Mã : {{ $coupon->code }}">
                                <p>{{ Str::limit($coupon->description ?? 'Không có mô tả', 50, '...') }}</p>
                            </div>
                            <div class="home-coupon-content-foot">
                                <button data-type="coupon-policy" data-coupon="{{ $coupon->code }}" title="Điều kiện áp dụng">
                                    Điều kiện áp dụng
                                    <span class="home-coupon-content-info">
                                        - {{ $coupon->description ?? 'Không có điều kiện cụ thể' }} <br>
                                        - Giá trị giảm: {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . '₫' }} <br>
                                        - Áp dụng cho đơn hàng tối thiểu: {{ $coupon->min_cart_value ? number_format($coupon->min_cart_value, 0, ',', '.') . '₫' : 'Không yêu cầu' }} <br>
                                        - Hạn sử dụng: {{ $coupon->end_date ? $coupon->end_date->format('d/m/Y') : 'Không giới hạn' }}
                                    </span>
                                </button>
                                <button data-type="coupon-copy" data-coupon="{{ $coupon->code }}">Sao chép mã</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="modal fade" id="modal-coupon" tabindex="-1" role="dialog" aria-labelledby="modal-coupon" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content "></div>
            </div>
        </div>
        <section class="home-about">
            <div class="container">
                <div class="home-about-top">
                    <span><img loading="lazy" decoding="async" title="Phong cách của bạn"
                            src="{{ asset('images/home_about_tope889.jpg')}}" alt="Phong cách của bạn" /></span>
                    <div class="section-title-all">
                        <div>
                            <span>CHO CHÚNG TÔI THẤY</span>
                            <h2>Phong cách của bạn</h2>
                        </div>
                        <p>Mở khóa phong cách và doanh số bán hàng độc quyền, giảm sản phẩm và những lần hợp tác mới nhất của chúng tôi với cộng đồng Converse - tất cả đều được gửi thẳng đến hộp thư đến của bạn.</p>
                    </div>
                </div>
                <div class="home-about-bot">
                    <span><img loading="lazy" decoding="async" title="Phong cách của bạn"
                            src="{{ asset('images/home_about_bote889.jpg')}}" alt="Phong cách của bạn" /></span>
                </div>
            </div>
        </section>
        <!-- <section class="home-product-slider">
            <div class="container">
                <div class="home-product-slider-wrap">
                    <div class="home-product-slider-wrap-header">
                        <div class="section-title-all">
                            <div>
                                <span>Converse</span>
                                <h2>Sản phẩm nổi bật</h2>
                            </div>
                            <a href="converse-all.html" aria-label="Xem thêm" data-hover="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="home-product-slider-wrap-body">
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679987" data-handle="converse-chuck-taylor-all-star-mono-leather-low-top">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge " data-id="33445638"></div>
                                        <span class="product-item-discount">-11%</span> <a class="product-item-link" href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top" title="Converse Chuck Taylor All Star Mono Leather Low Top">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/136823c-5-650x650-15ff91e141be424b95a2892abf3fe169-jpege39c.jpg?v=1699864035783"
                                                alt="Converse Chuck Taylor All Star Mono Leather Low Top"
                                                title="Converse Chuck Taylor All Star Mono Leather Low Top">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/136823c-2-650x650-a1096454688d47c693bad810d9321f85-jpege39c.jpg?v=1699864035783"
                                                alt="Converse Chuck Taylor All Star Mono Leather Low Top"
                                                title="Converse Chuck Taylor All Star Mono Leather Low Top">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            <li>
                                                <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Converse Chuck Taylor All Star Mono Leather Low Top"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/136823c-2-650x650-a1096454688d47c693bad810d9321f85-jpege39c.jpg?v=1699864035783" alt="Converse Chuck Taylor All Star Mono Leather Low Top">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Converse Chuck Taylor All Star Mono Leather Low Top"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/136823c-1-650x650-f30ba8e6f4ca46e593e49c10cf33e7dd-jpege39c.jpg?v=1699864035783" alt="Converse Chuck Taylor All Star Mono Leather Low Top">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Converse Chuck Taylor All Star Mono Leather Low Top"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/136823c-3-650x650-ca3915e0f3f844de85221ac1eeecd853-jpege39c.jpg?v=1699864035783" alt="Converse Chuck Taylor All Star Mono Leather Low Top">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M359.511,37.984c-38.907,0-75.282,14.653-103.511,41.478c-28.229-26.825-64.605-41.478-103.511-41.478 C68.406,37.984,0,108.033,0,194.135c0,49.918,42.543,112.126,126.449,184.895c61.346,53.204,123.555,93.023,124.176,93.419 c1.639,1.045,3.507,1.567,5.375,1.567c1.868,0,3.736-0.523,5.376-1.568c0.621-0.396,62.83-40.215,124.176-93.419 C469.457,306.26,512,244.052,512,194.135C512,108.033,443.594,37.984,359.511,37.984z M372.62,363.771 c-49.885,43.284-100.379,77.567-116.62,88.301c-16.216-10.715-66.578-44.903-116.448-88.153C61.34,296.089,20,237.378,20,194.135 C20,119.06,79.435,57.984,152.489,57.984c36.726,0,70.877,15.094,96.161,42.501c1.893,2.052,4.558,3.219,7.35,3.219 s5.457-1.167,7.35-3.219c25.285-27.406,59.435-42.5,96.161-42.5C432.565,57.984,492,119.06,492,194.135 C492,237.344,450.719,296.003,372.62,363.771z" fill="#000000" data-original="#000000"></path>
                                                <path d="M347.379,93.307l-0.376,0.065c-5.438,0.966-9.063,6.157-8.097,11.595c0.861,4.846,5.078,8.252,9.834,8.252 c0.581,0,1.17-0.051,1.76-0.156l0.199-0.034c5.446-0.917,9.118-6.075,8.201-11.521C357.983,96.06,352.82,92.393,347.379,93.307z" fill="#000000" data-original="#000000"></path>
                                                <path d="M439.056,131.382c-12.278-16.867-29.718-29.43-49.106-35.375c-5.281-1.621-10.873,1.349-12.492,6.629 c-1.619,5.28,1.349,10.873,6.629,12.492c31.959,9.8,54.279,41.078,54.279,76.063c0,5.523,4.477,10,10,10s10-4.477,9.999-10.001 C458.365,169.416,451.688,148.735,439.056,131.382z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                                            </svg></button>
                                        <button type="button" title="Thêm vào giỏ" class="shop-addLoop-button" data-type="shop-addLoop-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 459.361 459.361" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M371.2,325.731c19.1-0.2,35.8-13.1,40.7-31.6l47.1-175.4c1.5-5.7-1.8-11.5-7.5-13.1c-0.9-0.2-1.8-0.4-2.7-0.4H94.5 l-24.1-89c-1.2-4.6-5.4-7.9-10.2-7.9H0v21.3h51.8l23.3,87c-0.1,0.7-0.1,1.4,0,2.1l48,176c0.3,1.4,0.8,2.9,1.3,4.3l16.2,59 c-15.6,8.3-26.2,24.7-26.2,43.6c0,27.3,22.1,49.4,49.4,49.4c27.3,0,49.4-22.1,49.4-49.4c0-8.5-2.2-16.6-6-23.6 c-0.9-1.6-1.8-3.2-2.9-4.8H330c-5.6,8-9,17.8-9,28.4c0,27.3,22.1,49.4,49.4,49.4s49.4-22.1,49.4-49.4c0-12.9-4.9-24.6-13-33.4 c-8.7-9.9-21.5-16.2-35.8-16.3H161.9l-7.5-27.5c3.2,0.8,6.5,1.3,9.8,1.3H371.2z M370.5,373.231c15.7,0,28.4,12.7,28.4,28.4 s-12.7,28.4-28.4,28.4c-15.7,0-28.4-12.7-28.4-28.4S354.8,373.231,370.5,373.231z M163.8,373.231c15.7,0,28.3,12.8,28.3,28.4 c0,15.7-12.7,28.4-28.4,28.4c-15.7,0-28.3-12.7-28.3-28.4S148.1,373.231,163.8,373.231z M144.8,290.931l-23.9-87.4l-21.3-76.8 h334.9l-43.3,162.6c-2.4,9.3-10.7,15.8-20.3,16H164C155.3,304.831,147.7,299.231,144.8,290.931z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <h3 class="product-item-detail-name">
                                            <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top" title="Converse Chuck Taylor All Star Mono Leather Low Top">Converse Chuck Taylor All Star Mono Leather Low Top</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            <span>1.900.000₫</span>
                                            <del>2.139.000₫</del>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                            </div>
                                            <div class="sapo-product-reviews-badge" data-id="33445638"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679983" data-handle="chuck-taylor-all-star-classic">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge " data-id="33445637"></div>
                                        <span class="product-item-discount">-13%</span> <a class="product-item-link" href="chuck-taylor-all-star-classic.html" aria-label="Chuck Taylor All Star Classic" title="Chuck Taylor All Star Classic">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/121176-drake-650x650-65cdda7193cb40b9977bfd6379e567c5-jpeg92f9.jpg?v=1699864033743"
                                                alt="Chuck Taylor All Star Classic"
                                                title="Chuck Taylor All Star Classic">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/121176-drake2-650x650-b62837853a4d4d739ba4f556c2cd82bb-jpeg92f9.jpg?v=1699864033743"
                                                alt="Chuck Taylor All Star Classic"
                                                title="Chuck Taylor All Star Classic">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            <li>
                                                <a href="chuck-taylor-all-star-classic.html" aria-label="Chuck Taylor All Star Classic">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/121176-drake2-650x650-b62837853a4d4d739ba4f556c2cd82bb-jpeg92f9.jpg?v=1699864033743" alt="Chuck Taylor All Star Classic">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic.html" aria-label="Chuck Taylor All Star Classic">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/121176-drake4-650x650-fdf7ea31c9444facbe9574aac96d2594-jpeg92f9.png?v=1699864033743" alt="Chuck Taylor All Star Classic">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic.html" aria-label="Chuck Taylor All Star Classic">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/121176-drake5-650x650-0c86d0e9e2014659a3f9c87acbf6dbb5-jpeg92f9.jpg?v=1699864033743" alt="Chuck Taylor All Star Classic">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M359.511,37.984c-38.907,0-75.282,14.653-103.511,41.478c-28.229-26.825-64.605-41.478-103.511-41.478 C68.406,37.984,0,108.033,0,194.135c0,49.918,42.543,112.126,126.449,184.895c61.346,53.204,123.555,93.023,124.176,93.419 c1.639,1.045,3.507,1.567,5.375,1.567c1.868,0,3.736-0.523,5.376-1.568c0.621-0.396,62.83-40.215,124.176-93.419 C469.457,306.26,512,244.052,512,194.135C512,108.033,443.594,37.984,359.511,37.984z M372.62,363.771 c-49.885,43.284-100.379,77.567-116.62,88.301c-16.216-10.715-66.578-44.903-116.448-88.153C61.34,296.089,20,237.378,20,194.135 C20,119.06,79.435,57.984,152.489,57.984c36.726,0,70.877,15.094,96.161,42.501c1.893,2.052,4.558,3.219,7.35,3.219 s5.457-1.167,7.35-3.219c25.285-27.406,59.435-42.5,96.161-42.5C432.565,57.984,492,119.06,492,194.135 C492,237.344,450.719,296.003,372.62,363.771z" fill="#000000" data-original="#000000"></path>
                                                <path d="M347.379,93.307l-0.376,0.065c-5.438,0.966-9.063,6.157-8.097,11.595c0.861,4.846,5.078,8.252,9.834,8.252 c0.581,0,1.17-0.051,1.76-0.156l0.199-0.034c5.446-0.917,9.118-6.075,8.201-11.521C357.983,96.06,352.82,92.393,347.379,93.307z" fill="#000000" data-original="#000000"></path>
                                                <path d="M439.056,131.382c-12.278-16.867-29.718-29.43-49.106-35.375c-5.281-1.621-10.873,1.349-12.492,6.629 c-1.619,5.28,1.349,10.873,6.629,12.492c31.959,9.8,54.279,41.078,54.279,76.063c0,5.523,4.477,10,10,10s10-4.477,9.999-10.001 C458.365,169.416,451.688,148.735,439.056,131.382z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                                            </svg></button>
                                        <button type="button" title="Thêm vào giỏ" class="shop-addLoop-button" data-type="shop-addLoop-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 459.361 459.361" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M371.2,325.731c19.1-0.2,35.8-13.1,40.7-31.6l47.1-175.4c1.5-5.7-1.8-11.5-7.5-13.1c-0.9-0.2-1.8-0.4-2.7-0.4H94.5 l-24.1-89c-1.2-4.6-5.4-7.9-10.2-7.9H0v21.3h51.8l23.3,87c-0.1,0.7-0.1,1.4,0,2.1l48,176c0.3,1.4,0.8,2.9,1.3,4.3l16.2,59 c-15.6,8.3-26.2,24.7-26.2,43.6c0,27.3,22.1,49.4,49.4,49.4c27.3,0,49.4-22.1,49.4-49.4c0-8.5-2.2-16.6-6-23.6 c-0.9-1.6-1.8-3.2-2.9-4.8H330c-5.6,8-9,17.8-9,28.4c0,27.3,22.1,49.4,49.4,49.4s49.4-22.1,49.4-49.4c0-12.9-4.9-24.6-13-33.4 c-8.7-9.9-21.5-16.2-35.8-16.3H161.9l-7.5-27.5c3.2,0.8,6.5,1.3,9.8,1.3H371.2z M370.5,373.231c15.7,0,28.4,12.7,28.4,28.4 s-12.7,28.4-28.4,28.4c-15.7,0-28.4-12.7-28.4-28.4S354.8,373.231,370.5,373.231z M163.8,373.231c15.7,0,28.3,12.8,28.3,28.4 c0,15.7-12.7,28.4-28.4,28.4c-15.7,0-28.3-12.7-28.3-28.4S148.1,373.231,163.8,373.231z M144.8,290.931l-23.9-87.4l-21.3-76.8 h334.9l-43.3,162.6c-2.4,9.3-10.7,15.8-20.3,16H164C155.3,304.831,147.7,299.231,144.8,290.931z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <h3 class="product-item-detail-name">
                                            <a href="chuck-taylor-all-star-classic.html" aria-label="Chuck Taylor All Star Classic" title="Chuck Taylor All Star Classic">Chuck Taylor All Star Classic</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            <span>1.309.000₫</span>
                                            <del>1.500.000₫</del>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">new</span>
                                                <span class="product-item-detail-info-tag">freeship</span>
                                            </div>
                                            <div class="sapo-product-reviews-badge" data-id="33445637"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679979" data-handle="chuck-taylor-all-star-classic-121184">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge noSale" data-id="33445636"></div>
                                        <a class="product-item-link" href="chuck-taylor-all-star-classic-121184.html" aria-label="Chuck Taylor All Star Classic - 121184" title="Chuck Taylor All Star Classic - 121184">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/121184-drake-650x650-3be016cc519b40a09093df5718bdbaf9-jpeg2a24.jpg?v=1699864031380"
                                                alt="Chuck Taylor All Star Classic - 121184"
                                                title="Chuck Taylor All Star Classic - 121184">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/121184-drake1-650x650-21b3c20f79d8491a993fc5a0744756b2-jpeg2a24.png?v=1699864031380"
                                                alt="Chuck Taylor All Star Classic - 121184"
                                                title="Chuck Taylor All Star Classic - 121184">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-121184.html" aria-label="Chuck Taylor All Star Classic - 121184">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic - 121184"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/121184-drake1-650x650-21b3c20f79d8491a993fc5a0744756b2-jpeg2a24.jpg?v=1699864031380" alt="Chuck Taylor All Star Classic - 121184">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-121184.html" aria-label="Chuck Taylor All Star Classic - 121184">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic - 121184"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/121184-drake2-650x650-e8371211b05e47dfa5d17f7db84c2f01-jpeg2a24.jpg?v=1699864031380" alt="Chuck Taylor All Star Classic - 121184">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-121184.html" aria-label="Chuck Taylor All Star Classic - 121184">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic - 121184"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/121184-drake3-650x650-d31f396223b14739862640b120cb26db-jpeg2a24.jpg?v=1699864031380" alt="Chuck Taylor All Star Classic - 121184">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M359.511,37.984c-38.907,0-75.282,14.653-103.511,41.478c-28.229-26.825-64.605-41.478-103.511-41.478 C68.406,37.984,0,108.033,0,194.135c0,49.918,42.543,112.126,126.449,184.895c61.346,53.204,123.555,93.023,124.176,93.419 c1.639,1.045,3.507,1.567,5.375,1.567c1.868,0,3.736-0.523,5.376-1.568c0.621-0.396,62.83-40.215,124.176-93.419 C469.457,306.26,512,244.052,512,194.135C512,108.033,443.594,37.984,359.511,37.984z M372.62,363.771 c-49.885,43.284-100.379,77.567-116.62,88.301c-16.216-10.715-66.578-44.903-116.448-88.153C61.34,296.089,20,237.378,20,194.135 C20,119.06,79.435,57.984,152.489,57.984c36.726,0,70.877,15.094,96.161,42.501c1.893,2.052,4.558,3.219,7.35,3.219 s5.457-1.167,7.35-3.219c25.285-27.406,59.435-42.5,96.161-42.5C432.565,57.984,492,119.06,492,194.135 C492,237.344,450.719,296.003,372.62,363.771z" fill="#000000" data-original="#000000"></path>
                                                <path d="M347.379,93.307l-0.376,0.065c-5.438,0.966-9.063,6.157-8.097,11.595c0.861,4.846,5.078,8.252,9.834,8.252 c0.581,0,1.17-0.051,1.76-0.156l0.199-0.034c5.446-0.917,9.118-6.075,8.201-11.521C357.983,96.06,352.82,92.393,347.379,93.307z" fill="#000000" data-original="#000000"></path>
                                                <path d="M439.056,131.382c-12.278-16.867-29.718-29.43-49.106-35.375c-5.281-1.621-10.873,1.349-12.492,6.629 c-1.619,5.28,1.349,10.873,6.629,12.492c31.959,9.8,54.279,41.078,54.279,76.063c0,5.523,4.477,10,10,10s10-4.477,9.999-10.001 C458.365,169.416,451.688,148.735,439.056,131.382z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                                            </svg></button>
                                        <button type="button" title="Thêm vào giỏ" class="shop-addLoop-button" data-type="shop-addLoop-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 459.361 459.361" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M371.2,325.731c19.1-0.2,35.8-13.1,40.7-31.6l47.1-175.4c1.5-5.7-1.8-11.5-7.5-13.1c-0.9-0.2-1.8-0.4-2.7-0.4H94.5 l-24.1-89c-1.2-4.6-5.4-7.9-10.2-7.9H0v21.3h51.8l23.3,87c-0.1,0.7-0.1,1.4,0,2.1l48,176c0.3,1.4,0.8,2.9,1.3,4.3l16.2,59 c-15.6,8.3-26.2,24.7-26.2,43.6c0,27.3,22.1,49.4,49.4,49.4c27.3,0,49.4-22.1,49.4-49.4c0-8.5-2.2-16.6-6-23.6 c-0.9-1.6-1.8-3.2-2.9-4.8H330c-5.6,8-9,17.8-9,28.4c0,27.3,22.1,49.4,49.4,49.4s49.4-22.1,49.4-49.4c0-12.9-4.9-24.6-13-33.4 c-8.7-9.9-21.5-16.2-35.8-16.3H161.9l-7.5-27.5c3.2,0.8,6.5,1.3,9.8,1.3H371.2z M370.5,373.231c15.7,0,28.4,12.7,28.4,28.4 s-12.7,28.4-28.4,28.4c-15.7,0-28.4-12.7-28.4-28.4S354.8,373.231,370.5,373.231z M163.8,373.231c15.7,0,28.3,12.8,28.3,28.4 c0,15.7-12.7,28.4-28.4,28.4c-15.7,0-28.3-12.7-28.3-28.4S148.1,373.231,163.8,373.231z M144.8,290.931l-23.9-87.4l-21.3-76.8 h334.9l-43.3,162.6c-2.4,9.3-10.7,15.8-20.3,16H164C155.3,304.831,147.7,299.231,144.8,290.931z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <h3 class="product-item-detail-name">
                                            <a href="chuck-taylor-all-star-classic-121184.html" aria-label="Chuck Taylor All Star Classic - 121184" title="Chuck Taylor All Star Classic - 121184">Chuck Taylor All Star Classic - 121184</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            <span>4.399.000₫</span>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">freeship</span>
                                                <span class="product-item-detail-info-tag">new</span>
                                            </div>
                                            <div class="sapo-product-reviews-badge" data-id="33445636"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679975" data-handle="chuck-taylor-all-star-classic-r">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge " data-id="33445635"></div>
                                        <span class="product-item-discount">-18%</span> <a class="product-item-link" href="chuck-taylor-all-star-classic-r.html" aria-label="Chuck Taylor All Star Classic R" title="Chuck Taylor All Star Classic R">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/126196-002-650x650-115fc0e823304481a9e282f4c63c4e42-jpeg2172.jpg?v=1699864029033"
                                                alt="Chuck Taylor All Star Classic R"
                                                title="Chuck Taylor All Star Classic R">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/126196-drake1-1-650x650-92cc0a3ce2b94489b7d9c2b7879e8964-jpeg2172.png?v=1699864029033"
                                                alt="Chuck Taylor All Star Classic R"
                                                title="Chuck Taylor All Star Classic R">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-r.html" aria-label="Chuck Taylor All Star Classic R">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic R"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/126196-drake1-1-650x650-92cc0a3ce2b94489b7d9c2b7879e8964-jpeg2172.jpg?v=1699864029033" alt="Chuck Taylor All Star Classic R">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-r.html" aria-label="Chuck Taylor All Star Classic R">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic R"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/126196-drake2-1-650x650-db9dd9d3dc3d4ae4aa590fff4f81ea5b-jpeg2172.jpg?v=1699864029033" alt="Chuck Taylor All Star Classic R">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-r.html" aria-label="Chuck Taylor All Star Classic R">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic R"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/126196-drake3-1-650x650-bfd60a5f8e55446182efb0ef519d28bf-jpeg2172.jpg?v=1699864029033" alt="Chuck Taylor All Star Classic R">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M359.511,37.984c-38.907,0-75.282,14.653-103.511,41.478c-28.229-26.825-64.605-41.478-103.511-41.478 C68.406,37.984,0,108.033,0,194.135c0,49.918,42.543,112.126,126.449,184.895c61.346,53.204,123.555,93.023,124.176,93.419 c1.639,1.045,3.507,1.567,5.375,1.567c1.868,0,3.736-0.523,5.376-1.568c0.621-0.396,62.83-40.215,124.176-93.419 C469.457,306.26,512,244.052,512,194.135C512,108.033,443.594,37.984,359.511,37.984z M372.62,363.771 c-49.885,43.284-100.379,77.567-116.62,88.301c-16.216-10.715-66.578-44.903-116.448-88.153C61.34,296.089,20,237.378,20,194.135 C20,119.06,79.435,57.984,152.489,57.984c36.726,0,70.877,15.094,96.161,42.501c1.893,2.052,4.558,3.219,7.35,3.219 s5.457-1.167,7.35-3.219c25.285-27.406,59.435-42.5,96.161-42.5C432.565,57.984,492,119.06,492,194.135 C492,237.344,450.719,296.003,372.62,363.771z" fill="#000000" data-original="#000000"></path>
                                                <path d="M347.379,93.307l-0.376,0.065c-5.438,0.966-9.063,6.157-8.097,11.595c0.861,4.846,5.078,8.252,9.834,8.252 c0.581,0,1.17-0.051,1.76-0.156l0.199-0.034c5.446-0.917,9.118-6.075,8.201-11.521C357.983,96.06,352.82,92.393,347.379,93.307z" fill="#000000" data-original="#000000"></path>
                                                <path d="M439.056,131.382c-12.278-16.867-29.718-29.43-49.106-35.375c-5.281-1.621-10.873,1.349-12.492,6.629 c-1.619,5.28,1.349,10.873,6.629,12.492c31.959,9.8,54.279,41.078,54.279,76.063c0,5.523,4.477,10,10,10s10-4.477,9.999-10.001 C458.365,169.416,451.688,148.735,439.056,131.382z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                                            </svg></button>
                                        <button type="button" title="Thêm vào giỏ" class="shop-addLoop-button" data-type="shop-addLoop-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 459.361 459.361" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M371.2,325.731c19.1-0.2,35.8-13.1,40.7-31.6l47.1-175.4c1.5-5.7-1.8-11.5-7.5-13.1c-0.9-0.2-1.8-0.4-2.7-0.4H94.5 l-24.1-89c-1.2-4.6-5.4-7.9-10.2-7.9H0v21.3h51.8l23.3,87c-0.1,0.7-0.1,1.4,0,2.1l48,176c0.3,1.4,0.8,2.9,1.3,4.3l16.2,59 c-15.6,8.3-26.2,24.7-26.2,43.6c0,27.3,22.1,49.4,49.4,49.4c27.3,0,49.4-22.1,49.4-49.4c0-8.5-2.2-16.6-6-23.6 c-0.9-1.6-1.8-3.2-2.9-4.8H330c-5.6,8-9,17.8-9,28.4c0,27.3,22.1,49.4,49.4,49.4s49.4-22.1,49.4-49.4c0-12.9-4.9-24.6-13-33.4 c-8.7-9.9-21.5-16.2-35.8-16.3H161.9l-7.5-27.5c3.2,0.8,6.5,1.3,9.8,1.3H371.2z M370.5,373.231c15.7,0,28.4,12.7,28.4,28.4 s-12.7,28.4-28.4,28.4c-15.7,0-28.4-12.7-28.4-28.4S354.8,373.231,370.5,373.231z M163.8,373.231c15.7,0,28.3,12.8,28.3,28.4 c0,15.7-12.7,28.4-28.4,28.4c-15.7,0-28.3-12.7-28.3-28.4S148.1,373.231,163.8,373.231z M144.8,290.931l-23.9-87.4l-21.3-76.8 h334.9l-43.3,162.6c-2.4,9.3-10.7,15.8-20.3,16H164C155.3,304.831,147.7,299.231,144.8,290.931z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <h3 class="product-item-detail-name">
                                            <a href="chuck-taylor-all-star-classic-r.html" aria-label="Chuck Taylor All Star Classic R" title="Chuck Taylor All Star Classic R">Chuck Taylor All Star Classic R</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            <span>1.359.000₫</span>
                                            <del>1.659.000₫</del>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">new</span>
                                                <span class="product-item-detail-info-tag">freeship</span>
                                            </div>
                                            <div class="sapo-product-reviews-badge" data-id="33445635"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679971" data-handle="chuck-taylor-all-star-classic-127440">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge " data-id="33445634"></div>
                                        <span class="product-item-discount">-14%</span> <a class="product-item-link" href="chuck-taylor-all-star-classic-127440.html" aria-label="Chuck Taylor All Star Classic - 127440" title="Chuck Taylor All Star Classic - 127440">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/127440-drake-650x650-ac03230c5cb64fe481d19063beee86a8-jpeg3699.jpg?v=1699864026270"
                                                alt="Chuck Taylor All Star Classic - 127440"
                                                title="Chuck Taylor All Star Classic - 127440">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/127440-drake1-1-650x650-b62ac2b96214438c9b4030bbbb361359-jpeg3699.jpg?v=1699864026270"
                                                alt="Chuck Taylor All Star Classic - 127440"
                                                title="Chuck Taylor All Star Classic - 127440">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-127440.html" aria-label="Chuck Taylor All Star Classic - 127440">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic - 127440"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/127440-drake1-1-650x650-b62ac2b96214438c9b4030bbbb361359-jpeg3699.jpg?v=1699864026270" alt="Chuck Taylor All Star Classic - 127440">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-127440.html" aria-label="Chuck Taylor All Star Classic - 127440">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic - 127440"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/127440-drake2-1-650x650-fb92f6e486904261a4e6b372195be5d5-jpeg3699.png?v=1699864026270" alt="Chuck Taylor All Star Classic - 127440">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="chuck-taylor-all-star-classic-127440.html" aria-label="Chuck Taylor All Star Classic - 127440">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Chuck Taylor All Star Classic - 127440"
                                                        src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/127440-drake3-1-650x650-f7c3d13070a44458b47e2280c6d70a72-jpeg3699.jpg?v=1699864026270" alt="Chuck Taylor All Star Classic - 127440">
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M359.511,37.984c-38.907,0-75.282,14.653-103.511,41.478c-28.229-26.825-64.605-41.478-103.511-41.478 C68.406,37.984,0,108.033,0,194.135c0,49.918,42.543,112.126,126.449,184.895c61.346,53.204,123.555,93.023,124.176,93.419 c1.639,1.045,3.507,1.567,5.375,1.567c1.868,0,3.736-0.523,5.376-1.568c0.621-0.396,62.83-40.215,124.176-93.419 C469.457,306.26,512,244.052,512,194.135C512,108.033,443.594,37.984,359.511,37.984z M372.62,363.771 c-49.885,43.284-100.379,77.567-116.62,88.301c-16.216-10.715-66.578-44.903-116.448-88.153C61.34,296.089,20,237.378,20,194.135 C20,119.06,79.435,57.984,152.489,57.984c36.726,0,70.877,15.094,96.161,42.501c1.893,2.052,4.558,3.219,7.35,3.219 s5.457-1.167,7.35-3.219c25.285-27.406,59.435-42.5,96.161-42.5C432.565,57.984,492,119.06,492,194.135 C492,237.344,450.719,296.003,372.62,363.771z" fill="#000000" data-original="#000000"></path>
                                                <path d="M347.379,93.307l-0.376,0.065c-5.438,0.966-9.063,6.157-8.097,11.595c0.861,4.846,5.078,8.252,9.834,8.252 c0.581,0,1.17-0.051,1.76-0.156l0.199-0.034c5.446-0.917,9.118-6.075,8.201-11.521C357.983,96.06,352.82,92.393,347.379,93.307z" fill="#000000" data-original="#000000"></path>
                                                <path d="M439.056,131.382c-12.278-16.867-29.718-29.43-49.106-35.375c-5.281-1.621-10.873,1.349-12.492,6.629 c-1.619,5.28,1.349,10.873,6.629,12.492c31.959,9.8,54.279,41.078,54.279,76.063c0,5.523,4.477,10,10,10s10-4.477,9.999-10.001 C458.365,169.416,451.688,148.735,439.056,131.382z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                                            </svg></button>
                                        <button type="button" title="Thêm vào giỏ" class="shop-addLoop-button" data-type="shop-addLoop-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 459.361 459.361" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                                                <path d="M371.2,325.731c19.1-0.2,35.8-13.1,40.7-31.6l47.1-175.4c1.5-5.7-1.8-11.5-7.5-13.1c-0.9-0.2-1.8-0.4-2.7-0.4H94.5 l-24.1-89c-1.2-4.6-5.4-7.9-10.2-7.9H0v21.3h51.8l23.3,87c-0.1,0.7-0.1,1.4,0,2.1l48,176c0.3,1.4,0.8,2.9,1.3,4.3l16.2,59 c-15.6,8.3-26.2,24.7-26.2,43.6c0,27.3,22.1,49.4,49.4,49.4c27.3,0,49.4-22.1,49.4-49.4c0-8.5-2.2-16.6-6-23.6 c-0.9-1.6-1.8-3.2-2.9-4.8H330c-5.6,8-9,17.8-9,28.4c0,27.3,22.1,49.4,49.4,49.4s49.4-22.1,49.4-49.4c0-12.9-4.9-24.6-13-33.4 c-8.7-9.9-21.5-16.2-35.8-16.3H161.9l-7.5-27.5c3.2,0.8,6.5,1.3,9.8,1.3H371.2z M370.5,373.231c15.7,0,28.4,12.7,28.4,28.4 s-12.7,28.4-28.4,28.4c-15.7,0-28.4-12.7-28.4-28.4S354.8,373.231,370.5,373.231z M163.8,373.231c15.7,0,28.3,12.8,28.3,28.4 c0,15.7-12.7,28.4-28.4,28.4c-15.7,0-28.3-12.7-28.3-28.4S148.1,373.231,163.8,373.231z M144.8,290.931l-23.9-87.4l-21.3-76.8 h334.9l-43.3,162.6c-2.4,9.3-10.7,15.8-20.3,16H164C155.3,304.831,147.7,299.231,144.8,290.931z" fill="#000000" data-original="#000000"></path>
                                            </svg></button>
                                    </div>
                                    <div class="product-item-detail">
                                        <h3 class="product-item-detail-name">
                                            <a href="chuck-taylor-all-star-classic-127440.html" aria-label="Chuck Taylor All Star Classic - 127440" title="Chuck Taylor All Star Classic - 127440">Chuck Taylor All Star Classic - 127440</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            <span>1.459.000₫</span>
                                            <del>1.690.000₫</del>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">freeship</span>
                                                <span class="product-item-detail-info-tag">được yêu thích</span>
                                            </div>
                                            <div class="sapo-product-reviews-badge" data-id="33445634"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <section class="home-gallery">
            <div class="container">
                <div class="home-gallery-wrap">
                    <div class="home-gallery-wrap-header">
                        <div class="section-title-all">
                            <div>
                                <span>Converse</span>
                                <h2>Bộ sưu tập</h2>
                            </div>
                            <a href="collections/all.html" title="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="home-gallery-wrap-body">
                        <div class="home-gallery-wrap-body-item">
                            <a href="{{ asset('images/home_gallery_item_image_one_1e889.jpg')}}" data-fancybox="gallery" aria-label="Bộ sưu tập mùa xuân">
                                <img loading="lazy" decoding="async" src="{{ asset('images/home_gallery_item_image_one_1e889.jpg')}}"
                                    alt="F1GENZ Shoes - Bộ sưu tập mùa xuân" title="Bộ sưu tập mùa xuân" />
                                <span>Bộ sưu tập mùa xuân</span>
                            </a>
                            <a href="{{ asset('images/home_gallery_item_image_two_1e889.jpg')}}" data-fancybox="gallery" aria-label="Bộ sưu tập mùa hè">
                                <img loading="lazy" decoding="async" title="Bộ sưu tập mùa hè"
                                    src="{{ asset('images/home_gallery_item_image_two_1e889.jpg')}}" alt="F1GENZ Shoes - Bộ sưu tập mùa hè" />
                                <span>Bộ sưu tập mùa hè</span>
                            </a>
                        </div>
                        <div class="home-gallery-wrap-body-item">
                            <a href="{{ asset('images/home_gallery_item_image_one_2e889.jpg')}}" data-fancybox="gallery" aria-label="Bộ sưu tập mùa thu">
                                <img loading="lazy" decoding="async" src="{{ asset('images/home_gallery_item_image_one_2e889.jpg')}}"
                                    alt="F1GENZ Shoes - Bộ sưu tập mùa thu" title="Bộ sưu tập mùa thu" />
                                <span>Bộ sưu tập mùa thu</span>
                            </a>
                            <a href="{{ asset('images/home_gallery_item_image_two_2e889.jpg')}}" data-fancybox="gallery" aria-label="Bộ sưu tập mùa đông">
                                <img loading="lazy" decoding="async" title="Bộ sưu tập mùa đông"
                                    src="{{ asset('images/home_gallery_item_image_two_2e889.jpg')}}" alt="F1GENZ Shoes - Bộ sưu tập mùa đông" />
                                <span>Bộ sưu tập mùa đông</span>
                            </a>
                        </div>
                        <div class="home-gallery-wrap-body-item">
                            <a href="{{ asset('images/home_gallery_item_image_one_3e889.jpg')}}" data-fancybox="gallery" aria-label="Bộ sưu tập TS">
                                <img loading="lazy" decoding="async" src="{{ asset('images/home_gallery_item_image_one_3e889.jpg')}}"
                                    alt="F1GENZ Shoes - Bộ sưu tập TS" title="Bộ sưu tập TS" />
                                <span>Bộ sưu tập TS</span>
                            </a>
                            <a href="{{ asset('images/home_gallery_item_image_two_3e889.jpg')}}" data-fancybox="gallery" aria-label="Bộ sưu tập LST">
                                <img loading="lazy" decoding="async" title="Bộ sưu tập LST"
                                    src="{{ asset('images/home_gallery_item_image_two_3e889.jpg')}}" alt="F1GENZ Shoes - Bộ sưu tập LST" />
                                <span>Bộ sưu tập LST</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- <section class="home-product">
            <div class="container">
            <div class="home-product-wrap">
                <div class="home-product-wrap-header">
                <div class="section-title-all">
                    <div>
                    <span>Converse</span>
                    <h2>Sản phẩm khuyến mãi</h2>
                    </div>
                    <a href="#" aria-label="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                </div>
                </div>
                <div class="home-product-wrap-body">
                <div class="product-item" data-id="102679987" data-handle="converse-chuck-taylor-all-star-mono-leather-low-top">
                    <div class="product-item-wrap">
                    <div class="product-item-image hasThumbs hasThumbsIcon">
                        <div class="sapo-buyxgety-badge " data-id="33445638"></div>
                        <span class="product-item-discount">-11%</span> 
                        <a class="product-item-link" href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top" title="Converse Chuck Taylor All Star Mono Leather Low Top">
                        <img class="w-auto" loading="lazy" width="480" height="480"
                            src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/136823c-5-650x650-15ff91e141be424b95a2892abf3fe169-jpege39c.jpg?v=1699864035783"
                            alt="Converse Chuck Taylor All Star Mono Leather Low Top"
                            title="Converse Chuck Taylor All Star Mono Leather Low Top">
                        <img class="w-auto" loading="lazy" width="480" height="480"
                            src="../bizweb.dktcdn.net/thumb/large/100/493/370/products/136823c-2-650x650-a1096454688d47c693bad810d9321f85-jpege39c.jpg?v=1699864035783"
                            alt="Converse Chuck Taylor All Star Mono Leather Low Top"
                            title="Converse Chuck Taylor All Star Mono Leather Low Top">
                        </a>
                        <ul class="product-item-thumbs">
                        <li>
                            <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top">
                            <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Converse Chuck Taylor All Star Mono Leather Low Top"
                                src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/136823c-2-650x650-a1096454688d47c693bad810d9321f85-jpege39c.jpg?v=1699864035783" alt="Converse Chuck Taylor All Star Mono Leather Low Top">
                            </a>
                        </li>
                        <li>
                            <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top">
                            <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Converse Chuck Taylor All Star Mono Leather Low Top"
                                src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/136823c-1-650x650-f30ba8e6f4ca46e593e49c10cf33e7dd-jpege39c.jpg?v=1699864035783" alt="Converse Chuck Taylor All Star Mono Leather Low Top">
                            </a>
                        </li>
                        <li>
                            <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top">
                            <img class="w-auto" loading="lazy" decoding="async" width="50" height="50" title="Converse Chuck Taylor All Star Mono Leather Low Top"
                                src="../bizweb.dktcdn.net/thumb/thumb/100/493/370/products/136823c-3-650x650-ca3915e0f3f844de85221ac1eeecd853-jpege39c.jpg?v=1699864035783" alt="Converse Chuck Taylor All Star Mono Leather Low Top">
                            </a>
                        </li>
                        </ul>
                    </div>
                    <div class="product-item-action">
                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add" data-type="shop-wishlist-button-add"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 512 512" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                            <path d="M359.511,37.984c-38.907,0-75.282,14.653-103.511,41.478c-28.229-26.825-64.605-41.478-103.511-41.478 C68.406,37.984,0,108.033,0,194.135c0,49.918,42.543,112.126,126.449,184.895c61.346,53.204,123.555,93.023,124.176,93.419 c1.639,1.045,3.507,1.567,5.375,1.567c1.868,0,3.736-0.523,5.376-1.568c0.621-0.396,62.83-40.215,124.176-93.419 C469.457,306.26,512,244.052,512,194.135C512,108.033,443.594,37.984,359.511,37.984z M372.62,363.771 c-49.885,43.284-100.379,77.567-116.62,88.301c-16.216-10.715-66.578-44.903-116.448-88.153C61.34,296.089,20,237.378,20,194.135 C20,119.06,79.435,57.984,152.489,57.984c36.726,0,70.877,15.094,96.161,42.501c1.893,2.052,4.558,3.219,7.35,3.219 s5.457-1.167,7.35-3.219c25.285-27.406,59.435-42.5,96.161-42.5C432.565,57.984,492,119.06,492,194.135 C492,237.344,450.719,296.003,372.62,363.771z" fill="#000000" data-original="#000000"></path>
                            <path d="M347.379,93.307l-0.376,0.065c-5.438,0.966-9.063,6.157-8.097,11.595c0.861,4.846,5.078,8.252,9.834,8.252 c0.581,0,1.17-0.051,1.76-0.156l0.199-0.034c5.446-0.917,9.118-6.075,8.201-11.521C357.983,96.06,352.82,92.393,347.379,93.307z" fill="#000000" data-original="#000000"></path>
                            <path d="M439.056,131.382c-12.278-16.867-29.718-29.43-49.106-35.375c-5.281-1.621-10.873,1.349-12.492,6.629 c-1.619,5.28,1.349,10.873,6.629,12.492c31.959,9.8,54.279,41.078,54.279,76.063c0,5.523,4.477,10,10,10s10-4.477,9.999-10.001 C458.365,169.416,451.688,148.735,439.056,131.382z" fill="#000000" data-original="#000000"></path>
                        </svg></button>
                        <button type="button" title="Xem nhanh" class="shop-quickview-button" data-type="shop-quickview-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 612.01 612.01" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                            <path d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z" fill="#000000" data-original="#000000" class=""></path>
                        </svg></button>
                        <button type="button" title="Thêm vào giỏ" class="shop-addLoop-button" data-type="shop-addLoop-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="128" height="128" x="0" y="0" viewBox="0 0 459.361 459.361" style="enable-background: new 0 0 512 512" xml:space="preserve" class="">
                            <path d="M371.2,325.731c19.1-0.2,35.8-13.1,40.7-31.6l47.1-175.4c1.5-5.7-1.8-11.5-7.5-13.1c-0.9-0.2-1.8-0.4-2.7-0.4H94.5 l-24.1-89c-1.2-4.6-5.4-7.9-10.2-7.9H0v21.3h51.8l23.3,87c-0.1,0.7-0.1,1.4,0,2.1l48,176c0.3,1.4,0.8,2.9,1.3,4.3l16.2,59 c-15.6,8.3-26.2,24.7-26.2,43.6c0,27.3,22.1,49.4,49.4,49.4c27.3,0,49.4-22.1,49.4-49.4c0-8.5-2.2-16.6-6-23.6 c-0.9-1.6-1.8-3.2-2.9-4.8H330c-5.6,8-9,17.8-9,28.4c0,27.3,22.1,49.4,49.4,49.4s49.4-22.1,49.4-49.4c0-12.9-4.9-24.6-13-33.4 c-8.7-9.9-21.5-16.2-35.8-16.3H161.9l-7.5-27.5c3.2,0.8,6.5,1.3,9.8,1.3H371.2z M370.5,373.231c15.7,0,28.4,12.7,28.4,28.4 s-12.7,28.4-28.4,28.4c-15.7,0-28.4-12.7-28.4-28.4S354.8,373.231,370.5,373.231z M163.8,373.231c15.7,0,28.3,12.8,28.3,28.4 c0,15.7-12.7,28.4-28.4,28.4c-15.7,0-28.3-12.7-28.3-28.4S148.1,373.231,163.8,373.231z M144.8,290.931l-23.9-87.4l-21.3-76.8 h334.9l-43.3,162.6c-2.4,9.3-10.7,15.8-20.3,16H164C155.3,304.831,147.7,299.231,144.8,290.931z" fill="#000000" data-original="#000000"></path>
                        </svg></button>
                    </div>
                    <div class="product-item-detail">
                        <h3 class="product-item-detail-name">
                        <a href="converse-chuck-taylor-all-star-mono-leather-low-top.html" aria-label="Converse Chuck Taylor All Star Mono Leather Low Top" title="Converse Chuck Taylor All Star Mono Leather Low Top">Converse Chuck Taylor All Star Mono Leather Low Top</a>
                        </h3>
                        <div class="product-item-detail-price">
                        <span>1.900.000₫</span>
                        <del>2.139.000₫</del>
                        </div>
                        <div class="product-item-detail-info">
                        <div class="product-item-detail-info-data">
                        </div>
                        <div class="sapo-product-reviews-badge" data-id="33445638"></div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section> -->

        <section class="home-banner">
            <div class="container">
                <div class="home-banner-wrap">
                    <div class="home-banner-wrap-left">
                        <h2>Nhìn đã ấn tượng</h2>
                        <p>Converse Chuck 70 Archive Paint Splatter

                        </p>
                        <a title="Mua ngay" href="collections/all.html">Mua ngay</a>
                    </div>
                    <div class="home-banner-wrap-right">
                        <img loading="lazy" decoding="async" title="Nhìn đã ấn tượng"
                            src="{{ asset('images/banner_bottom_imge889.jpg')}}" alt="Nhìn đã ấn tượng" />
                    </div>
                </div>
            </div>
        </section>

        <section class="home-blog">
            <div class="container">
                <div class="home-blog-header">
                    <div class="section-title-all">
                        <div>
                            <span>Kiến thức</span>
                            <h2>Kiến thức mua hàng</h2>
                        </div>
                        <a href="news.html" title="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="home-blog-body">


                    <article class="article-item " data-index="1">
                        <div class="article-item-top">
                            <a href="converse-renew-crater-va-su-chuyen-doi-phat-trien-voi-ben-vung.html" title="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG" rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/fila-ray-white-pink-fs1sia3063x-401996e480134a9b82dd56e0012283e8295e.jpg')}}" alt="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG" title="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a href="converse-renew-crater-va-su-chuyen-doi-phat-trien-voi-ben-vung.html" title="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG">CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                    <article class="article-item " data-index="2">
                        <div class="article-item-top">
                            <a href="bat-tay-cung-hai-nhan-streetwear-lon-tho-miffy-xuat-hien-trong-hanh-trinh-doi-moi-cho-van-hoa-truot-van.html" title="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN" rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/nike-adapt-bb-2-0-nike-mag-bq539-59c1bcee8e5f4e9bada9d6143473f0ecb498.jpg')}}" alt="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN" title="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a href="bat-tay-cung-hai-nhan-streetwear-lon-tho-miffy-xuat-hien-trong-hanh-trinh-doi-moi-cho-van-hoa-truot-van.html" title="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN">BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                    <article class="article-item " data-index="3">
                        <div class="article-item-top">
                            <a href="converse-x-kim-jones.html" title="CONVERSE X KIM JONES" rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/chuck-70-beat-the-world-ig-2-7df-abea22e0824c4c09a6fd5ed757bd85f7d5a0.jpg')}}" alt="CONVERSE X KIM JONES" title="CONVERSE X KIM JONES">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a href="converse-x-kim-jones.html" title="CONVERSE X KIM JONES">CONVERSE X KIM JONES</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                    <article class="article-item " data-index="4">
                        <div class="article-item-top">
                            <a href="trai-nghiem-con-duong-mau-sac-day-hoa-dai-vo-tan-cua-converse-pride.html" title="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE" rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/01-thumb-6a26040630f8411eafc114dfa2c1bfc23be6.jpg')}}" alt="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE" title="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a href="trai-nghiem-con-duong-mau-sac-day-hoa-dai-vo-tan-cua-converse-pride.html" title="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE">TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
        <section class="home-insta">
            <div class="home-insta-top">
                <div class="container">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                    <h2>#ConnectUs</h2>
                </div>
            </div>
            <div class="home-insta-mid-wrap">
                <div class="container">
                    <div class="home-insta-mid">
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 1">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-1e889.jpg')}}" title="Instagram 1" alt="Instagram 1" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 2">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-2e889.jpg')}}" title="Instagram 2" alt="Instagram 2" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 3">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-3e889.jpg')}}" title="Instagram 3" alt="Instagram 3" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 4">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-4e889.jpg')}}" title="Instagram 4" alt="Instagram 4" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 5">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-5e889.jpg')}}" title="Instagram 5" alt="Instagram 5" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 6">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-6e889.jpg')}}" title="Instagram 6" alt="Instagram 6" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 7">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-7e889.jpg')}}" title="Instagram 7" alt="Instagram 7" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="home-newletter">
            <div class="container">
                <div class="home-newletter-wrap">
                    <div class="home-newletter-wrap-left">
                        <h2> Nhận ưu đãi và coupon mới nhất!</h2>
                        <p>Chúng tôi cam kết bảo mật không lộ thông tin của bạn.</p>
                        <form id="mc-form10" action="https://gmail.us21.list-manage.com/subscribe/post?u=ddd0880c66f534593afa12e75&amp;id=fe6449bc79&amp;f_id=00cd9be1f0">
                            <input aria-label="Địa chỉ Email" type="email" placeholder="Nhập địa chỉ email của bạn" name="EMAIL" required autocomplete="off">
                            <button type="submit" aria-label="Đăng ký nhận tin" name="subscribe">Đăng ký</button>
                        </form>
                        <p>Nhận ngay coupon giảm <b>15%</b> khi đăng ký ngay</p>
                    </div>
                    <div class="home-newletter-wrap-right">
                        <img class="lazyload" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
                            data-src="//bizweb.dktcdn.net/100/493/370/themes/940719/assets/home-newletter-image.png?1713464283843" alt="home-newletter-image" />
                    </div>
                </div>
            </div>
        </section>

    </main>
    @include('Frontend.partials.footer')
    @include('Frontend.partials.modal')
</body>
@include('Frontend.partials.scrip')

</html>