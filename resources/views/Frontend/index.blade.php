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
                @foreach ($banners as $banner)
                    <div class="home-slider-main-item">
                        <a href="{{ $banner->link ?? '#' }}"
                            aria-label="{!! $banner->title !!} <br /> {!! $banner->subtitle !!}">
                            <picture>
                                {{-- Ảnh cho màn hình nhỏ --}}
                                <source width="600" height="800" media="(max-width: 600px)"
                                    srcset="{{ asset('imgBanner/' . $banner->image) }}">

                                {{-- Ảnh cho màn hình lớn --}}
                                <source width="1920" height="700" media="(min-width: 601px)"
                                    srcset="{{ asset('imgBanner/' . $banner->image) }}">

                                {{-- Ảnh chính hiển thị --}}
                                <img width="1920" height="700" loading="lazy" decoding="async"
                                    src="{{ asset('imgBanner/' . $banner->image) }}" class="w-100"
                                    title="{!! $banner->title !!} <br /> {!! $banner->subtitle !!}"
                                    alt="{!! $banner->title !!} <br /> {!! $banner->subtitle !!}" />
                            </picture>

                            <div class="home-slider-item-content">
                                <div class="container">
                                    <h2>{!! $banner->title !!} <br /> Sale tất cả sản phẩm</h2>

                                    <p>{{ $banner->subtitle }}</p>
                                    <span>Xem ngay</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="home-policy">
            <div class="container">
                <div class="home-policy-wrap">

                    <a href="collections/all.html" class="home-policy-item"
                        aria-label="F1GENZ Shoes - Giao hàng nhanh, miễn phí">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_1e889.png') }}"
                                title="Giao hàng nhanh, miễn phí"
                                alt="F1GENZ Shoes - Giao hàng nhanh, miễn phí" /></span>
                        <h3>Giao hàng nhanh, miễn phí</h3>
                        <p>Đơn hàng > 900k hoặc đăng ký tài khoản được giao hàng miễn phí</p>
                    </a>

                    <a href="collections/all.html" class="home-policy-item"
                        aria-label="F1GENZ Shoes - Trả hàng, Bảo hành">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_2e889.png') }}" title="Trả hàng, Bảo hành"
                                alt="F1GENZ Shoes - Trả hàng, Bảo hành" /></span>
                        <h3>Trả hàng, Bảo hành</h3>
                        <p>Không thích? Trả lại hoặc đổi hàng của bạn miễn phí trong vòng 30 ngày.</p>
                    </a>

                    <a href="collections/all.html" class="home-policy-item" aria-label="F1GENZ Shoes - Thành viên">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_3e889.png') }}" title="Thành viên"
                                alt="F1GENZ Shoes - Thành viên" /></span>
                        <h3>Thành viên</h3>
                        <p>Ưu đãi theo từng cấp bậc hạng thành viên. Sinh nhật quà tặng thành viên</p>
                    </a>

                    <a href="collections/all.html" class="home-policy-item" aria-label="F1GENZ Shoes - Chính hãng">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_4e889.png') }}" title="Chính hãng"
                                alt="F1GENZ Shoes - Chính hãng" /></span>
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
                        src="{{ asset('images/home_fsale_imagee889.png') }}" alt="F1GENZ Shoes - Flash Sale">
                </h2>
                <div class="home-fSale-head-countdown">
                    <label>Kết thúc sau</label>
                    <div data-time="1/4/2025 24:00:00" class="countdownLoop"></div>
                </div>
            </div>
            <div class="home-fSale-body">
                <div class="home-fSale-body-data">
                    @foreach ($products as $product)
                        <div class="product-item special" data-id="{{ $product->id }}"
                            data-handle="{{ Str::slug($product->name) }}">
                            <div class="product-item-wrap">
                                <div class="product-item-image hasThumbs hasThumbsIcon">
                                    <div class="sapo-buyxgety-badge" data-id="{{ $product->id }}"></div>
                                    <span class="product-item-discount">-{{ $product->discount ?? '11' }}%</span>
                                    <a class="product-item-link" href="{{ route('product.show', $product->id) }}"
                                        title="{{ $product->name }}">
                                        <img class="w-auto" loading="lazy" width="480" height="480"
                                            src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                            alt="{{ $product->name }}" title="{{ $product->name }}">
                                        <img class="w-auto" loading="lazy" width="480" height="480"
                                            src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                            alt="{{ $product->name }}" title="{{ $product->name }}">
                                    </a>
                                    <ul class="product-item-thumbs">
                                        <li><a href="#"><img class="w-auto" loading="lazy" width="50" height="50"
                                                    src="{{ asset($product->thumb1 ?? 'images/default.jpg') }}"
                                                    alt=""></a></li>
                                        <li><a href="#"><img class="w-auto" loading="lazy" width="50" height="50"
                                                    src="{{ asset($product->thumb2 ?? 'images/default.jpg') }}"
                                                    alt=""></a></li>
                                        <li><a href="#"><img class="w-auto" loading="lazy" width="50" height="50"
                                                    src="{{ asset($product->thumb3 ?? 'images/default.jpg') }}"
                                                    alt=""></a></li>
                                    </ul>
                                </div>

                                <div class="product-item-action">
                                    <form class="favorite-form" method="POST"
                                        action="{{ route('favorites.toggle') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="favorite-btn"
                                            data-product-id="{{ $product->id }}"
                                            style="color: {{ $favorites->contains('product_id', $product->id) ? 'red' : 'gray' }};">
                                            ❤
                                        </button>
                                    </form>
                                    <button type="button" title="Xem nhanh" class="shop-quickview-button"
                                        data-type="shop-quickview-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 612.01 612.01"
                                            width="20" height="20">
                                            <path
                                                d="M606.209,578.714L448.198,423.228C489.576,378.272,515,318.817,515,253.393C514.98,113.439,399.704,0,257.493,0 C115.282,0,0.006,113.439,0.006,253.393s115.276,253.393,257.487,253.393c61.445,0,117.801-21.253,162.068-56.586 l158.624,156.099c7.729,7.614,20.277,7.614,28.006,0C613.938,598.686,613.938,586.328,606.209,578.714z M257.493,467.8 c-120.326,0-217.869-95.993-217.869-214.407S137.167,38.986,257.493,38.986c120.327,0,217.869,95.993,217.869,214.407 S377.82,467.8,257.493,467.8z"
                                                fill="#000000" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="product-item-detail">
                                    <div class="product-item-sold">
                                        <label class="fSale_chayhang">
                                            <img loading="lazy" decoding="async"
                                                src="{{ asset('images/imager_8176_d244203aa9cf4dfbb410e1377abdac72_compact.gif') }}"
                                                alt="pro-loop-sold" />
                                            <span></span>
                                        </label>
                                        <div class="product-item-sold-wrap">
                                            <span style="--percent: 50%"></span>
                                        </div>
                                    </div>
                                    <h3 class="product-item-detail-name">
                                        <a href="{{ route('product.show', $product->id) }}"
                                            title="{{ $product->name }}">{{ $product->name }}</a>
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
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" title="Thêm vào giỏ"
                                            class="shop-addLoop-button cart">Thêm vào giỏ</button>
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
                            <img loading="lazy" decoding="async"
                                src="{{ asset('images/background-coupon_d5a81f5bc7ea49_ec6d59fdd17c4a718809792590ed9455.png') }}"
                                alt="Mã : F1SHOES">
                            <div class="home-coupon-content">
                                <div class="home-coupon-content-head">
                                    <h3>Mã : {{ $coupon->code }}</h3>
                                    <img loading="lazy" decoding="async" src="{{ asset($coupon->image) }}"
                                        title="Mã : {{ $coupon->code }}" alt="Mã : {{ $coupon->code }}">
                                    <p>{{ Str::limit($coupon->description ?? 'Không có mô tả', 50, '...') }}</p>
                                </div>
                                <div class="home-coupon-content-foot">
                                    <button data-type="coupon-policy" data-coupon="{{ $coupon->code }}"
                                        title="Điều kiện áp dụng">
                                        Điều kiện áp dụng
                                        <span class="home-coupon-content-info">
                                            - {{ $coupon->description ?? 'Không có điều kiện cụ thể' }} <br>
                                            - Giá trị giảm:
                                            {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . '₫' }}
                                            <br>
                                            - Áp dụng cho đơn hàng tối thiểu:
                                            {{ $coupon->min_cart_value ? number_format($coupon->min_cart_value, 0, ',', '.') . '₫' : 'Không yêu cầu' }}
                                            <br>
                                            - Hạn sử dụng:
                                            {{ $coupon->end_date ? $coupon->end_date->format('d/m/Y') : 'Không giới hạn' }}
                                        </span>
                                    </button>
                                    <button data-type="coupon-copy" data-coupon="{{ $coupon->code }}">Sao chép
                                        mã</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="modal fade" id="modal-coupon" tabindex="-1" role="dialog" aria-labelledby="modal-coupon"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content "></div>
            </div>
        </div>
        <section class="home-about">
            <div class="container">
                <div class="home-about-top">
                    <span><img loading="lazy" decoding="async" title="Phong cách của bạn"
                            src="{{ asset('images/home_about_tope889.jpg') }}" alt="Phong cách của bạn" /></span>
                    <div class="section-title-all">
                        <div>
                            <span>CHO CHÚNG TÔI THẤY</span>
                            <h2>Phong cách của bạn</h2>
                        </div>
                        <p>Mở khóa phong cách và doanh số bán hàng độc quyền, giảm sản phẩm và những lần hợp tác mới
                            nhất của chúng tôi với cộng đồng Converse - tất cả đều được gửi thẳng đến hộp thư đến của
                            bạn.</p>
                    </div>
                </div>
                <div class="home-about-bot">
                    <span><img loading="lazy" decoding="async" title="Phong cách của bạn"
                            src="{{ asset('images/home_about_bote889.jpg') }}" alt="Phong cách của bạn" /></span>
                </div>
            </div>
        </section>
        <section class="home-gallery">
            <div class="container">
                <div class="home-gallery-wrap">
                    <div class="home-gallery-wrap-header">
                        <div class="section-title-all">
                            <div>
                                <span>Converse</span>
                                <h2>Bộ sưu tập</h2>
                            </div>
                            <a href="collections/all.html" title="Xem thêm">Xem thêm <i
                                    class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="home-gallery-wrap-body">
                        <div class="home-gallery-wrap-body-item">
                            <a href="{{ asset('images/home_gallery_item_image_one_1e889.jpg') }}"
                                data-fancybox="gallery" aria-label="Bộ sưu tập mùa xuân">
                                <img loading="lazy" decoding="async"
                                    src="{{ asset('images/home_gallery_item_image_one_1e889.jpg') }}"
                                    alt="F1GENZ Shoes - Bộ sưu tập mùa xuân" title="Bộ sưu tập mùa xuân" />
                                <span>Bộ sưu tập mùa xuân</span>
                            </a>
                            <a href="{{ asset('images/home_gallery_item_image_two_1e889.jpg') }}"
                                data-fancybox="gallery" aria-label="Bộ sưu tập mùa hè">
                                <img loading="lazy" decoding="async" title="Bộ sưu tập mùa hè"
                                    src="{{ asset('images/home_gallery_item_image_two_1e889.jpg') }}"
                                    alt="F1GENZ Shoes - Bộ sưu tập mùa hè" />
                                <span>Bộ sưu tập mùa hè</span>
                            </a>
                        </div>
                        <div class="home-gallery-wrap-body-item">
                            <a href="{{ asset('images/home_gallery_item_image_one_2e889.jpg') }}"
                                data-fancybox="gallery" aria-label="Bộ sưu tập mùa thu">
                                <img loading="lazy" decoding="async"
                                    src="{{ asset('images/home_gallery_item_image_one_2e889.jpg') }}"
                                    alt="F1GENZ Shoes - Bộ sưu tập mùa thu" title="Bộ sưu tập mùa thu" />
                                <span>Bộ sưu tập mùa thu</span>
                            </a>
                            <a href="{{ asset('images/home_gallery_item_image_two_2e889.jpg') }}"
                                data-fancybox="gallery" aria-label="Bộ sưu tập mùa đông">
                                <img loading="lazy" decoding="async" title="Bộ sưu tập mùa đông"
                                    src="{{ asset('images/home_gallery_item_image_two_2e889.jpg') }}"
                                    alt="F1GENZ Shoes - Bộ sưu tập mùa đông" />
                                <span>Bộ sưu tập mùa đông</span>
                            </a>
                        </div>
                        <div class="home-gallery-wrap-body-item">
                            <a href="{{ asset('images/home_gallery_item_image_one_3e889.jpg') }}"
                                data-fancybox="gallery" aria-label="Bộ sưu tập TS">
                                <img loading="lazy" decoding="async"
                                    src="{{ asset('images/home_gallery_item_image_one_3e889.jpg') }}"
                                    alt="F1GENZ Shoes - Bộ sưu tập TS" title="Bộ sưu tập TS" />
                                <span>Bộ sưu tập TS</span>
                            </a>
                            <a href="{{ asset('images/home_gallery_item_image_two_3e889.jpg') }}"
                                data-fancybox="gallery" aria-label="Bộ sưu tập LST">
                                <img loading="lazy" decoding="async" title="Bộ sưu tập LST"
                                    src="{{ asset('images/home_gallery_item_image_two_3e889.jpg') }}"
                                    alt="F1GENZ Shoes - Bộ sưu tập LST" />
                                <span>Bộ sưu tập LST</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                            src="{{ asset('images/banner_bottom_imge889.jpg') }}" alt="Nhìn đã ấn tượng" />
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
                            <a href="converse-renew-crater-va-su-chuyen-doi-phat-trien-voi-ben-vung.html"
                                title="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG"
                                rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/fila-ray-white-pink-fs1sia3063x-401996e480134a9b82dd56e0012283e8295e.jpg') }}"
                                    alt="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG"
                                    title="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a
                                    href="converse-renew-crater-va-su-chuyen-doi-phat-trien-voi-ben-vung.html"
                                    title="CONVERSE RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG">CONVERSE
                                    RENEW CRATER VÀ SỰ CHUYỂN ĐỔI PHÁT TRIỂN VỚI BỀN VỮNG</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản
                                ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều
                                khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                    <article class="article-item " data-index="2">
                        <div class="article-item-top">
                            <a href="bat-tay-cung-hai-nhan-streetwear-lon-tho-miffy-xuat-hien-trong-hanh-trinh-doi-moi-cho-van-hoa-truot-van.html"
                                title="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN"
                                rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/nike-adapt-bb-2-0-nike-mag-bq539-59c1bcee8e5f4e9bada9d6143473f0ecb498.jpg') }}"
                                    alt="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN"
                                    title="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a
                                    href="bat-tay-cung-hai-nhan-streetwear-lon-tho-miffy-xuat-hien-trong-hanh-trinh-doi-moi-cho-van-hoa-truot-van.html"
                                    title="BẮT TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO VĂN HÓA TRƯỢT VÁN">BẮT
                                    TAY CÙNG HAI NHÃN STREETWEAR LỚN, THỎ MIFFY XUẤT HIỆN TRONG HÀNH TRÌNH ĐỔI MỚI CHO
                                    VĂN HÓA TRƯỢT VÁN</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản
                                ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều
                                khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                    <article class="article-item " data-index="3">
                        <div class="article-item-top">
                            <a href="converse-x-kim-jones.html" title="CONVERSE X KIM JONES" rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/chuck-70-beat-the-world-ig-2-7df-abea22e0824c4c09a6fd5ed757bd85f7d5a0.jpg') }}"
                                    alt="CONVERSE X KIM JONES" title="CONVERSE X KIM JONES">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a href="converse-x-kim-jones.html"
                                    title="CONVERSE X KIM JONES">CONVERSE X KIM JONES</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản
                                ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều
                                khách hàng trên thế giới.
                                Chuck Taylor Classic có thiết kế giống như dòng Converse All Star được cho ra mắt...
                            </p>
                        </div>
                    </article>
                    <article class="article-item " data-index="4">
                        <div class="article-item-top">
                            <a href="trai-nghiem-con-duong-mau-sac-day-hoa-dai-vo-tan-cua-converse-pride.html"
                                title="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE"
                                rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset('images/01-thumb-6a26040630f8411eafc114dfa2c1bfc23be6.jpg') }}"
                                    alt="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE"
                                    title="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a
                                    href="trai-nghiem-con-duong-mau-sac-day-hoa-dai-vo-tan-cua-converse-pride.html"
                                    title="TRẢI NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE">TRẢI
                                    NGHIỆM CON ĐƯỜNG MÀU SẮC ĐẦY HOA DÀI VÔ TẬN CỦA CONVERSE PRIDE</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i> 04.11.2021
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> Công Ty TNHH KTCN F1GENZ
                            </span>
                            <p class="article-item-bottom-des">
                                Chuck Taylor Classic là dòng giày truyền thống của Converse được giữ đúng với nguyên bản
                                ban đầu. Từ lúc xuất hiện cho đến nay dòng Classic vẫn nhận được sự quan tâm của nhiều
                                khách hàng trên thế giới.
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
                                    src="{{ asset('images/home-insta-mid-image-1e889.jpg') }}" title="Instagram 1"
                                    alt="Instagram 1" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 2">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-2e889.jpg') }}" title="Instagram 2"
                                    alt="Instagram 2" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 3">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-3e889.jpg') }}" title="Instagram 3"
                                    alt="Instagram 3" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 4">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-4e889.jpg') }}" title="Instagram 4"
                                    alt="Instagram 4" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 5">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-5e889.jpg') }}" title="Instagram 5"
                                    alt="Instagram 5" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 6">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-6e889.jpg') }}" title="Instagram 6"
                                    alt="Instagram 6" />
                                <span><i class="fal fa-eye"></i></span>
                            </a>
                        </div>
                        <div class="home-insta-mid-item">
                            <a href="collections/all.html" title="Instagram 7">
                                <img width="600" height="600" loading="lazy" decoding="async"
                                    src="{{ asset('images/home-insta-mid-image-7e889.jpg') }}" title="Instagram 7"
                                    alt="Instagram 7" />
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
                        <form id="mc-form10"
                            action="https://gmail.us21.list-manage.com/subscribe/post?u=ddd0880c66f534593afa12e75&amp;id=fe6449bc79&amp;f_id=00cd9be1f0">
                            <input aria-label="Địa chỉ Email" type="email"
                                placeholder="Nhập địa chỉ email của bạn" name="EMAIL" required
                                autocomplete="off">
                            <button type="submit" aria-label="Đăng ký nhận tin" name="subscribe">Đăng ký</button>
                        </form>
                        <p>Nhận ngay coupon giảm <b>15%</b> khi đăng ký ngay</p>
                    </div>
                    <div class="home-newletter-wrap-right">
                        <img class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="
                            data-src="//bizweb.dktcdn.net/100/493/370/themes/940719/assets/home-newletter-image.png?1713464283843"
                            alt="home-newletter-image" />
                    </div>
                </div>
            </div>
            
        </section>

    </main>
    @include('Frontend.partials.footer')
    @include('Frontend.partials.modal')
    @include('Frontend.partials.chatbot')
</body>
@include('Frontend.partials.scrip')

</html>
