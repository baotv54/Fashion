<!doctype html>
<html class="no-js" lang="vi">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    @include('Frontend.partials.head')
    <style>
        .main-collection-breadcrumb *,
        .main-collection-breadcrumb *:after,
        .main-collection-breadcrumb *:before {
            color: #333333 !important;
        }
        .coupon-tabs .nav-link {
            color: #555;
            font-weight: 500;
            padding: 0.5rem 1rem;
            position: relative;
            border: none;
        }
        .coupon-tabs .nav-link.active {
            color: #ee4d2d;
            font-weight: bold;
        }
        .coupon-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #ee4d2d;
        }
        .coupon-tabs .nav-tabs {
            gap: 10px;
            display: flex;
            flex-wrap: wrap;
        }
        .coupon-tabs .nav-link {
            padding: 0.5rem 1rem;
            margin: 0 !important;
            border-radius: 4px;
        }
        .hidden-coupons {
            display: none;
        }
        .show-all-coupons .hidden-coupons {
            display: block;
        }
    </style>
    <link rel="preload stylesheet" as="style" href="{{ asset('css/collection.scsse889.css') }}">
</head>
<body class="">
    @include('Frontend.partials.header')
    <div class="main-collection" data-id="3229426">
        <div title="CONVERSE ALL" class="main-collection-breadcrumb lazyload"
            data-bg="//bizweb.dktcdn.net/100/493/370/themes/940719/assets/main_collection_breadcrumb_bg.jpg?1713464283843">
            <div class="container">
                <div class="section-title-all">
                    <h1>Tất cả sản phẩm</h1>
                </div>
                <div class="breadcrumb-wrap">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html" aria-label="Trang chủ" title="Trang chủ">Trang chủ</a></li>
                        <li class="breadcrumb-item active"><span>Tất cả Mã giảm giá</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="home-coupon">
        <div class="container">
            <div>
                <h2>Mã giảm giá dành cho bạn</h2>
            </div>
            <div class="coupon-tabs my-4">
                <ul class="nav nav-tabs border-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="?type=all">Tất cả </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?type=shopee">Shopee </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?type=shopeevip">ShopeeVIP </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?type=shop">Shop </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?type=service">Nạp thẻ & Dịch vụ </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?type=scanpay">Scan & Pay </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">More</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Khác</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="home-coupon-wrap">
                @foreach ($coupons as $index => $coupon)
                    <div class="home-coupon-item {{ $index > 3 ? 'hidden-coupons' : '' }}">
                        <img loading="lazy" decoding="async"
                            src="{{ asset('images/background-coupon_d5a81f5bc7ea49_ec6d59fdd17c4a718809792590ed9455.png') }}"
                            alt="Mã : {{ $coupon->code }}">
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
                                <button data-type="coupon-copy" data-coupon="{{ $coupon->code }}">Sao chép mã</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <button id="showMoreCoupons" class="btn btn-primary">Xem thêm mã giảm giá</button>
            </div>
        </div>
    </section>
    <section class="home-fSale">
        <div class="container">
            <div class="home-blog-header">
                <div class="section-title-all">
                    <div>
                        <h2>Sản phẩm dành cho bạn</h2>
                    </div>
                </div>
            </div>
            <div class="home-fSale-wrap">
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
                                            <li><a href="#"><img class="w-auto" loading="lazy" width="50"
                                                    height="50"
                                                    src="{{ asset($product->thumb1 ?? 'images/default.jpg') }}"
                                                    alt=""></a></li>
                                            <li><a href="#"><img class="w-auto" loading="lazy" width="50"
                                                    height="50"
                                                    src="{{ asset($product->thumb2 ?? 'images/default.jpg') }}"
                                                    alt=""></a></li>
                                            <li><a href="#"><img class="w-auto" loading="lazy" width="50"
                                                    height="50"
                                                    src="{{ asset($product->thumb3 ?? 'images/default.jpg') }}"
                                                    alt=""></a></li>
                                        </ul>
                                    </div>
                                    <div class="product-item-action">
                                        <button type="button" title="Yêu thích" class="shop-wishlist-button-add"
                                            data-type="shop-wishlist-button-add">
                                            <!-- SVG Icon -->
                                        </button>
                                        <button type="button" title="Xem nhanh" class="shop-quickview-button"
                                            data-type="shop-quickview-button">
                                            <!-- SVG Icon -->
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
                                            <div class="sapo-product-reviews-badge" data-id="{{ $product->id }}">
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" value="{{ $product->id }}" name="product_id" />
                                            <input type="hidden" value="1" name="quantity" />
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
    <script>
        function copyCode(button) {
            const couponCode = button.closest('.coupon').querySelector('.coupon-code-text').innerText;
            navigator.clipboard.writeText(couponCode).then(function() {
                alert('Đã sao chép mã: ' + couponCode);
            }, function(err) {
                alert('Không thể sao chép mã: ' + err);
            });
        }

        document.getElementById('showMoreCoupons').addEventListener('click', function() {
            const couponWrap = document.querySelector('.home-coupon-wrap');
            couponWrap.classList.add('show-all-coupons');
            this.style.display = 'none';
        });
    </script>
    @include('Frontend.partials.footer')
    @include('Frontend.partials.modal')
</body>
@include('Frontend.partials.scrip')
</html>