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

                    <a href="#" class="home-policy-item"
                        aria-label="F1GENZ Shoes - Giao hàng nhanh, miễn phí">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_1e889.png') }}"
                                title="Giao hàng nhanh, miễn phí"
                                alt="F1GENZ Shoes - Giao hàng nhanh, miễn phí" /></span>
                        <h3>Giao hàng nhanh, miễn phí</h3>
                        <p>Đơn hàng > 900k hoặc đăng ký tài khoản được giao hàng miễn phí</p>
                    </a>

                    <a href="#" class="home-policy-item"
                        aria-label="F1GENZ Shoes - Trả hàng, Bảo hành">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_2e889.png') }}" title="Trả hàng, Bảo hành"
                                alt="F1GENZ Shoes - Trả hàng, Bảo hành" /></span>
                        <h3>Trả hàng, Bảo hành</h3>
                        <p>Không thích? Trả lại hoặc đổi hàng của bạn miễn phí trong vòng 30 ngày.</p>
                    </a>

                    <a href="#" class="home-policy-item" aria-label="F1GENZ Shoes - Thành viên">
                        <span><img loading="lazy" decoding="async" width="64" height="64"
                                src="{{ asset('images/home_policy_item_image_3e889.png') }}" title="Thành viên"
                                alt="F1GENZ Shoes - Thành viên" /></span>
                        <h3>Thành viên</h3>
                        <p>Ưu đãi theo từng cấp bậc hạng thành viên. Sinh nhật quà tặng thành viên</p>
                    </a>

                    <a href="#" class="home-policy-item" aria-label="F1GENZ Shoes - Chính hãng">
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
                        <!-- <h2>
                            <img loading="lazy" decoding="async" title="F1GENZ Shoes - Flash Sale"
                                src="{{ asset('images/home_fsale_imagee889.png') }}" alt="F1GENZ Shoes - Flash Sale">
                        </h2> -->
                        <br>
                        <div class="home-fSale-head-countdown">
                            <label>Sản Phẩm Hot</label>
                            <div data-time="1/4/2025 24:00:00" class="countdownLoop"></div>
                        </div>
                        <br>

                    </div>
                    <div class="home-fSale-body">
                        <div class="home-fSale-body-data">
                            @foreach ($topViewed as $product)
                            <div class="product-item special" data-id="{{ $product->id }}"
                                data-handle="{{ Str::slug($product->name) }}">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge" data-id="{{ $product->id }}"></div>

                                        @if($product->discount_percentage > 0)
                                        <span class="product-item-discount">-{{ $product->discount_percentage }}%</span>
                                        @endif

                                        <a class="product-item-link"
                                            href="{{ route('product.show', $product->id) }}"
                                            title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                        </a>
                                        <ul class="product-item-thumbs">
                                            @foreach($product->images->take(3) as $image)
                                            <li>
                                                <a href="{{ route('product.show', $product->id) }}" aria-label="{{ $product->name }}">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50"
                                                        title="{{ $product->name }}"
                                                        src="{{ asset($image->image_path) }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </li>
                                            @endforeach
                                            @if($product->images->count() == 0)
                                            <li>
                                                <a href="{{ route('product.show', $product->id) }}" aria-label="{{ $product->name }}">
                                                    <img class="w-auto" loading="lazy" decoding="async" width="50" height="50"
                                                        title="{{ $product->name }}"
                                                        src="{{ asset('images/default.jpg') }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </li>
                                            @endif
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
                                                aria-label="{{ $product->name }}"
                                                title="{{ $product->name }}"
                                                tabindex="0">{{ $product->name }}</a>
                                        </h3>

                                        <div class="product-item-detail-price">
                                            @if($product->has_discount)
                                            <span class="original-price" style="text-decoration: line-through; color: #999; font-size: 14px;">
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            </span>
                                            <span class="discount-price" style="color: #e74c3c; font-weight: bold;">
                                                {{ number_format($product->discount_price, 0, ',', '.') }}₫
                                            </span>
                                            @else
                                            <span>{{ number_format($product->display_price, 0, ',', '.') }}₫</span>
                                            @endif
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">Đã Bán :
                                                    {{ shortNumber($product->sold_count) }} </span>
                                                <span class="product-item-detail-info-tag">Yêu Thích :
                                                    {{ shortNumber($product->favorites_count) }} </span>
                                                <span class="product-item-detail-info-tag" style="color: #555555; background-color: #f0f0f0; padding: 2px 6px; border-radius: 4px;">
                                                    Lượt Xem: {{ shortNumber($product->view_count) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="product-item-detail-info">

                                            <div class="product-reviews-display">
                                                @if($product->reviews_count > 0)
                                                <div class="product-rating-stars" style="display: flex; align-items: center; gap: 5px; font-size: 14px;">
                                                    <div class="stars-container" style="display: flex; gap: 1px;">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <=floor($product->average_rating))
                                                            <span style="color: #ffbe00; font-size: 16px;">★</span>
                                                            @elseif($i - 0.5 <= $product->average_rating)
                                                                <span style="color: #ffbe00; font-size: 16px; position: relative; display: inline-block; width: 16px; overflow: hidden;">
                                                                    <span style="position: absolute; left: 0; width: 50%; overflow: hidden; color: #ffbe00;">★</span>
                                                                    <span style="color: #ddd;">★</span>
                                                                </span>
                                                                @else
                                                                <span style="color: #ddd; font-size: 16px;">★</span>
                                                                @endif
                                                                @endfor
                                                    </div>
                                                    <span class="rating-text" style="color: #666; font-size: 12px;">
                                                        ({{ $product->reviews_count }})
                                                    </span>
                                                </div>
                                                @else
                                                <div class="no-rating" style="color: #999; font-size: 12px;">
                                                    Chưa có đánh giá
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if($product->variants && $product->variants->count() > 0)
                                        <form method="GET" action="{{ route('product.show', $product->id) }}">
                                            <button type="submit" title="Xem chi tiết"
                                                class="shop-addLoop-button view-detail"
                                                tabindex="0">Xem chi tiết</button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" title="Thêm vào giỏ"
                                                class="shop-addLoop-button cart"
                                                tabindex="0">Thêm vào giỏ</button>
                                        </form>
                                        @endif
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
                <div class="home-gallery-wrap-header">
                    <div class="section-title-all">
                        <div>
                            <h2>Mã giảm giá săn giá hời</h2>
                        </div>
                        <a href="\couponList" title="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                    </div>
                </div>
                @if (session('success'))
                <div class="alert alert-success" id="flash-message" style="margin: 15px;">
                    {{ session('success') }}
                </div>
                @endif
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

                                {{-- Nút lưu mã --}}
                                @auth
                                @php $isSaved = Auth::user()->savedCoupons->contains($coupon->id); @endphp

                                <button
                                    class="btn {{ $isSaved ? 'btn-danger' : 'btn-outline-primary' }} btn-save-coupon"
                                    data-coupon-id="{{ $coupon->id }}" {{ $isSaved ? 'disabled' : '' }}
                                    style="margin-left: 10px;">
                                    {{ $isSaved ? 'Đã lưu' : 'Lưu mã giảm giá' }}
                                </button>
                                @else
                                <button href="{{ route('login') }}" class="btn btn-outline-secondary"
                                    style="margin-left: 10px;">Đăng nhập để lưu mã</button>
                                @endauth

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
        

        @php
        function shortNumber($num)
        {
        if ($num >= 1000000) {
        return number_format($num / 1000000, 2) . 'M';
        } elseif ($num >= 1000) {
        return number_format($num / 1000, 1) . 'K';
        }
        return $num;
        }
        @endphp
        <section class="home-product-slider">
            <div class="container">
                <div class="home-product-slider-wrap">
                    <div class="home-product-slider-wrap-header">
                        <div class="section-title-all">
                            <div>
                                <span>Converse</span>
                                <h2>Sản Phẩm Được Yêu Thích Nhiều Nhất</h2>
                            </div>
                            <a href="/products" aria-label="Xem thêm" data-hover="Xem thêm">Xem thêm <i
                                    class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="home-product-slider-wrap-body">
                        @foreach ($topFavorites as $product)
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679987"
                                data-handle="converse-chuck-taylor-all-star-mono-leather-low-top">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge " data-id="33445638"></div>
                                        <a class="product-item-link"
                                            href="{{ route('product.show', $product->id) }}"
                                            title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                        </a>
                                        @if ($product->images->count())
                                        <ul class="product-item-thumbs">
                                            @foreach ($product->images->take(3) as $image)
                                            <li>
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    aria-label="{{ $product->name }}">
                                                    <img class="w-auto" loading="lazy" decoding="async"
                                                        width="50" height="50"
                                                        title="{{ $product->name }}"
                                                        src="{{ asset($image->image_path) }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
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
                                        <h3 class="product-item-detail-name">
                                            <a href="{{ route('product.show', $product->id) }}"
                                                title="{{ $product->name }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            @if($product->has_discount)
                                            <span class="original-price" style="text-decoration: line-through; color: #999; font-size: 14px;">
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            </span>
                                            <span class="discount-price" style="color: #e74c3c; font-weight: bold;">
                                                {{ number_format($product->discount_price, 0, ',', '.') }}₫
                                            </span>
                                            @else
                                            <span>{{ number_format($product->display_price, 0, ',', '.') }}₫</span>
                                            @endif
                                        </div>

                                        <div class="product-item-detail-info">
                                            <div class="product-reviews-display">
                                                @if($product->reviews_count > 0)
                                                <div class="product-rating-stars" style="display: flex; align-items: center; gap: 5px; font-size: 14px;">
                                                    <div class="stars-container" style="display: flex; gap: 1px;">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <=floor($product->average_rating))
                                                            <span style="color: #ffbe00; font-size: 16px;">★</span>
                                                            @elseif($i - 0.5 <= $product->average_rating)
                                                                <span style="color: #ffbe00; font-size: 16px; position: relative; display: inline-block; width: 16px; overflow: hidden;">
                                                                    <span style="position: absolute; left: 0; width: 50%; overflow: hidden; color: #ffbe00;">★</span>
                                                                    <span style="color: #ddd;">★</span>
                                                                </span>
                                                                @else
                                                                <span style="color: #ddd; font-size: 16px;">★</span>
                                                                @endif
                                                                @endfor
                                                    </div>
                                                    <span class="rating-text" style="color: #666; font-size: 12px;">
                                                        ({{ $product->reviews_count }})
                                                    </span>
                                                </div>
                                                @else
                                                <div class="no-rating" style="color: #999; font-size: 12px;">
                                                    Chưa có đánh giá
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">Đã Bán :
                                                    {{ shortNumber($product->sold_count) }} </span>
                                                <span class="product-item-detail-info-tag">Yêu Thích :
                                                    {{ shortNumber($product->favorites_count) }} </span>
                                                <span class="product-item-detail-info-tag" style="color: #555555; background-color: #f0f0f0; padding: 2px 6px; border-radius: 4px;">
                                                    Lượt Xem: {{ shortNumber($product->view_count) }}
                                                </span>
                                            </div>
                                            <!-- <div class="sapo-product-reviews-badge" data-id="{{ $product->id }}"></div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @for ($i = count($topFavorites); $i < 5; $i++)
                            <div class="home-product-slider-wrap-body-item" style="visibility:hidden;">
                    </div>
                    @endfor
                </div>
            </div>
            </div>
        </section>

        <!-- Recently Viewed Products Section -->
        <section class="home-recently-viewed" id="recently-viewed-section" style="display: none;">
            <div class="container">
                <div class="home-recently-viewed-wrap">
                    <div class="home-recently-viewed-header">
                        <div class="section-title-all">
                            <div>
                                <span>F1GENZ</span>
                                <h2>Sản phẩm vừa xem</h2>
                            </div>
                            <button type="button" onclick="clearRecentlyViewed()" class="clear-recently-viewed">
                                Xóa tất cả <i class="fal fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="home-recently-viewed-body">
                        <div id="recently-viewed-products" class="recently-viewed-products-list">
                            <!-- Sản phẩm sẽ được render bằng JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
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

        <section class="home-product-slider">
            <div class="container">
                <div class="home-product-slider-wrap">
                    <div class="home-product-slider-wrap-header">
                        <div class="section-title-all">
                            <div>
                                <span>Converse</span>
                                <h2>Sản Phẩm Bán Chạy Nhất</h2>
                            </div>
                            <a href="/products" aria-label="Xem thêm" data-hover="Xem thêm">Xem thêm <i
                                    class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="home-product-slider-wrap-body">
                        @foreach ($topSelling as $product)
                        <div class="home-product-slider-wrap-body-item">
                            <div class="product-item" data-id="102679987"
                                data-handle="converse-chuck-taylor-all-star-mono-leather-low-top">
                                <div class="product-item-wrap">
                                    <div class="product-item-image hasThumbs hasThumbsIcon">
                                        <div class="sapo-buyxgety-badge " data-id="33445638"></div>
                                        <a class="product-item-link"
                                            href="{{ route('product.show', $product->id) }}"
                                            title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                            <img class="w-auto" loading="lazy" width="480" height="480"
                                                src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                                alt="{{ $product->name }}" title="{{ $product->name }}">
                                        </a>
                                        @if ($product->images->count())
                                        <ul class="product-item-thumbs">
                                            @foreach ($product->images->take(3) as $image)
                                            <li>
                                                <a href="{{ route('product.show', $product->id) }}"
                                                    aria-label="{{ $product->name }}">
                                                    <img class="w-auto" loading="lazy" decoding="async"
                                                        width="50" height="50"
                                                        title="{{ $product->name }}"
                                                        src="{{ asset($image->image_path) }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
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
                                        <h3 class="product-item-detail-name">
                                            <a href="{{ route('product.show', $product->id) }}"
                                                title="{{ $product->name }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="product-item-detail-price">
                                            @if($product->has_discount)
                                            <span class="original-price" style="text-decoration: line-through; color: #999; font-size: 14px;">
                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                            </span>
                                            <span class="discount-price" style="color: #e74c3c; font-weight: bold;">
                                                {{ number_format($product->discount_price, 0, ',', '.') }}₫
                                            </span>
                                            @else
                                            <span>{{ number_format($product->display_price, 0, ',', '.') }}₫</span>
                                            @endif
                                        </div>

                                        <div class="product-item-detail-info">
                                            <div class="product-reviews-display">
                                                @if($product->reviews_count > 0)
                                                <div class="product-rating-stars" style="display: flex; align-items: center; gap: 5px; font-size: 14px;">
                                                    <div class="stars-container" style="display: flex; gap: 1px;">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <=floor($product->average_rating))
                                                            <span style="color: #ffbe00; font-size: 16px;">★</span>
                                                            @elseif($i - 0.5 <= $product->average_rating)
                                                                <span style="color: #ffbe00; font-size: 16px; position: relative; display: inline-block; width: 16px; overflow: hidden;">
                                                                    <span style="position: absolute; left: 0; width: 50%; overflow: hidden; color: #ffbe00;">★</span>
                                                                    <span style="color: #ddd;">★</span>
                                                                </span>
                                                                @else
                                                                <span style="color: #ddd; font-size: 16px;">★</span>
                                                                @endif
                                                                @endfor
                                                    </div>
                                                    <span class="rating-text" style="color: #666; font-size: 12px;">
                                                        ({{ $product->reviews_count }})
                                                    </span>
                                                </div>
                                                @else
                                                <div class="no-rating" style="color: #999; font-size: 12px;">
                                                    Chưa có đánh giá
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-item-detail-info">
                                            <div class="product-item-detail-info-data">
                                                <span class="product-item-detail-info-tag">Đã Bán :
                                                    {{ shortNumber($product->sold_count) }} </span>
                                                <span class="product-item-detail-info-tag">Yêu Thích :
                                                    {{ shortNumber($product->favorites_count) }} </span>
                                                <span class="product-item-detail-info-tag" style="color: #555555; background-color: #f0f0f0; padding: 2px 6px; border-radius: 4px;">
                                                    Lượt Xem: {{ shortNumber($product->view_count) }}
                                                </span>
                                            </div>
                                            <!-- <div class="sapo-product-reviews-badge" data-id="{{ $product->id }}"></div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @for ($i = count($topSelling); $i < 5; $i++)
                            <div class="home-product-slider-wrap-body-item" style="visibility:hidden;">
                    </div>
                    @endfor
                </div>
            </div>
            </div>
        </section>




        <!-- <section class="home-gallery">
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
        </section> -->

        <section class="home-product">
            <div class="container">
                <div class="home-product-wrap">
                    <div class="home-product-wrap-header">
                        <div class="section-title-all">
                            <div>
                                <span>Converse</span>
                                <h2>Sản Phẩm Nổi Bật</h2>
                            </div>
                            <a href="/products" aria-label="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="home-product-wrap-body">
                        @foreach ($products as $product)
                        <div class="product-item" data-id="102679987"
                            data-handle="converse-chuck-taylor-all-star-mono-leather-low-top">
                            <div class="product-item-wrap">
                                <div class="product-item-image hasThumbs hasThumbsIcon">
                                    <div class="sapo-buyxgety-badge " data-id="33445638"></div>
                                    <!-- <span class="product-item-discount">-11%</span> -->
                                    <a class="product-item-link"
                                        href="{{ route('product.show', $product->id) }}"
                                        title="{{ $product->name }}">
                                        <img class="w-auto" loading="lazy" width="480" height="480"
                                            src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                            alt="{{ $product->name }}" title="{{ $product->name }}">
                                        <img class="w-auto" loading="lazy" width="480" height="480"
                                            src="{{ asset($product->image ?? 'images/default.jpg') }}"
                                            alt="{{ $product->name }}" title="{{ $product->name }}">
                                    </a>
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
                                    <h3 class="product-item-detail-name">
                                        <a href="{{ route('product.show', $product->id) }}"
                                            title="{{ $product->name }}">{{ $product->name }}</a>
                                    </h3>
                                    <div class="product-item-detail-price">
                                        @if($product->has_discount)
                                        <span class="original-price" style="text-decoration: line-through; color: #999; font-size: 14px;">
                                            {{ number_format($product->price, 0, ',', '.') }}₫
                                        </span>
                                        <span class="discount-price" style="color: #e74c3c; font-weight: bold;">
                                            {{ number_format($product->discount_price, 0, ',', '.') }}₫
                                        </span>
                                        @else
                                        <span>{{ number_format($product->display_price, 0, ',', '.') }}₫</span>
                                        @endif
                                    </div>

                                    <div class="product-item-detail-info">
                                        <div class="product-reviews-display">
                                            @if($product->reviews_count > 0)
                                            <div class="product-rating-stars" style="display: flex; align-items: center; gap: 5px; font-size: 14px;">
                                                <div class="stars-container" style="display: flex; gap: 1px;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <=floor($product->average_rating))
                                                        <span style="color: #ffbe00; font-size: 16px;">★</span>
                                                        @elseif($i - 0.5 <= $product->average_rating)
                                                            <span style="color: #ffbe00; font-size: 16px; position: relative; display: inline-block; width: 16px; overflow: hidden;">
                                                                <span style="position: absolute; left: 0; width: 50%; overflow: hidden; color: #ffbe00;">★</span>
                                                                <span style="color: #ddd;">★</span>
                                                            </span>
                                                            @else
                                                            <span style="color: #ddd; font-size: 16px;">★</span>
                                                            @endif
                                                            @endfor
                                                </div>
                                                <span class="rating-text" style="color: #666; font-size: 12px;">
                                                    ({{ $product->reviews_count }})
                                                </span>
                                            </div>
                                            @else
                                            <div class="no-rating" style="color: #999; font-size: 12px;">
                                                Chưa có đánh giá
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-item-detail-info">
                                        <div class="product-item-detail-info-data">
                                            <span class="product-item-detail-info-tag">Đã Bán :
                                                {{ shortNumber($product->sold_count) }} </span>
                                            <span class="product-item-detail-info-tag">Yêu Thích :
                                                {{ shortNumber($product->favorites_count) }} </span>
                                            <span class="product-item-detail-info-tag" style="color: #555555; background-color: #f0f0f0; padding: 2px 6px; border-radius: 4px;">
                                                Lượt Xem: {{ shortNumber($product->view_count) }}
                                            </span>
                                        </div>
                                        <!-- <div class="sapo-product-reviews-badge" data-id="{{ $product->id }}"></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
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
                            <h2>Tin Tức Và Bài Viết</h2>
                        </div>
                        <a href="/posts" title="Xem thêm">Xem thêm <i class="fal fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="home-blog-body">
                    @foreach ($posts as $post)
                    <article class="article-item " data-index="1">
                        <div class="article-item-top">
                            <a href="{{ route('posts.show', $post->id) }}" title="{{ $post->title }}" rel="nofollow">
                                <img loading="lazy" decoding="async" width="600" height="400"
                                    src="{{ asset($post->image ?? 'images/default.jpg') }}"
                                    alt="{{ $post->title }}" title="{{ $post->title }}">
                                <i class="fal fa-search fa-fw"></i>
                            </a>
                        </div>
                        <div class="article-item-bottom">
                            <h3 class="article-item-bottom-name"><a href="{{ route('posts.show', $post->id) }}" title="{{ $post->title }}" rel="nofollow">{{ $post->title }}</a></h3>
                            <span class="article-item-bottom-date">
                                <i class="far fa-calendar-alt fa-fw"></i>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                            </span>
                            <span class="article-item-bottom-author">
                                <i class="fal fa-newspaper fa-fw"></i> {{ $post->author }}
                            </span>
                            <p class="article-item-bottom-des">
                                {{ Str::limit(html_entity_decode(strip_tags($post->content)), 200, '...') }}
                            </p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- <section class="home-insta">
            <div class="home-insta-top">
                <div class="container">
                    <i class="fab fa-instagram"></i>
                    <span>Xem Thêm</span>
                    <h2>Các Thương Hiệu</h2>
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
        </section> -->

        <section class="home-newletter">
            <div class="container">
                <div class="home-newletter-wrap">
                    <div class="home-newletter-wrap-left">
                        <h2> Nhận ưu đãi và coupon mới nhất!</h2>
                        <p>Chúng tôi cam kết bảo mật không lộ thông tin của bạn.</p>
                        <form id="mc-form10"
                            action="https://gmail.us21.list-manage.com/subscribe/post?u=ddd0880c66f534593afa12e75&amp;id=fe6449bc79&amp;f_id=00cd9be1f0">
                            <input aria-label="Địa chỉ Email" type="email" placeholder="Nhập địa chỉ email của bạn"
                                name="EMAIL" required autocomplete="off">
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
        @php
        $popups = \App\Models\Popup::where('status', 1)
        ->orderByRaw("CASE WHEN media_type = 'image' THEN 0 ELSE 1 END") // ảnh trước, video sau
        ->latest()
        ->get();
        @endphp

        @foreach ($popups as $popup)
        <div class="modal fade" id="myModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-3 overflow-hidden shadow-lg animate-zoom">

                    <div class="row g-0">
                        {{-- Media --}}
                        <div class="col-md-6">
                            {{-- Nút đóng --}}
                            @if ($popup->media_type === 'image')
                            <a href="{{ url('/products') }}">
                                <img src="{{ asset('storage/' . $popup->media_path) }}" alt="Popup Image"
                                    class="w-100 h-100" style="object-fit: cover; cursor: pointer;">
                            </a>
                            @elseif ($popup->media_type === 'video')
                            <video autoplay muted controls class="w-100 h-100" style="object-fit: cover;">
                                <source src="{{ asset('storage/' . $popup->media_path) }}" type="video/mp4">
                            </video>
                            @endif
                        </div>

                        {{-- Nội dung --}}
                        <div
                            class="col-md-6 d-flex flex-column justify-content-center p-4 bg-light position-relative">

                            {{-- Nút đóng --}}
                            <button type="button" class="btn-close-custom" data-dismiss="modal"
                                aria-label="Close">
                                &times;
                            </button>

                            {{-- Tiêu đề --}}
                            @if ($popup->title)
                            <h3 class="fw-bold text-uppercase mb-3" style="color: #ff9800;">
                                {{ $popup->title }}
                            </h3>
                            @endif

                            {{-- Mô tả --}}
                            @if ($popup->description)
                            <p class="mb-4 text-secondary" style="line-height: 1.6;">
                                {{ $popup->description }}
                            </p>
                            @endif

                            {{-- Form --}}

                            <div class="input-group mb-3">
                                <input placeholder="Nhập email của bạn" class="form-control">
                                <button type="button" class="btn btn-warning text-white px-4"
                                    onclick="window.location.href='/Register'">
                                    Đăng ký
                                </button>
                            </div>


                            <small class="text-muted">
                                🎁 Nhận ngay coupon giảm <b class="text-danger">15%</b> khi đăng ký
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       

<script>
document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll("button[data-type='coupon-policy']");

    buttons.forEach(btn => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const infoBox = btn.querySelector(".home-coupon-content-info");

            // Ẩn tất cả box khác trước
            document.querySelectorAll(".home-coupon-content-info").forEach(box => {
                if (box !== infoBox) box.style.display = "none";
            });

            // Toggle box hiện tại
            infoBox.style.display = infoBox.style.display === "block" ? "none" : "block";
        });
    });

    // Click ra ngoài thì đóng
    document.addEventListener("click", function (e) {
        if (!e.target.closest("button[data-type='coupon-policy']")) {
            document.querySelectorAll(".home-coupon-content-info").forEach(box => {
                box.style.display = "none";
            });
        }
    });
});
</script>

        {{-- CSS & Animation --}}
        <style>
            @keyframes zoomIn {
                from {
                    transform: scale(0.8);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .animate-zoom {
                animation: zoomIn 0.4s ease;
            }

            .modal-dialog {
                max-width: 900px;
            }

            .modal-content .btn-close-custom {
                position: absolute;
                top: 10px;
                right: 15px;
                background: #fff;
                border: none;
                border-radius: 50%;
                width: 35px;
                height: 35px;
                font-size: 1.5rem;
                line-height: 1;
                color: #333;

                z-index: 9999;
                cursor: pointer;
            }

            .modal-content .btn-close-custom:hover {
                background: #ffb400;
                color: #ffffff;
            }
        </style>
        @endforeach

    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-save-coupon').forEach(button => {
                button.addEventListener('click', function() {
                    const couponId = this.dataset.couponId;

                    fetch(`/coupon/save/${couponId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Lỗi khi lưu mã.');
                            return response.json();
                        })
                        .then(data => {
                            // Chỉ cập nhật nút sang trạng thái "Đã lưu"
                            this.classList.remove('btn-outline-primary');
                            this.classList.add('btn-danger');
                            this.innerText = 'Đã lưu';
                            this.disabled = true; // khóa nút

                            showToast(data.message || 'Lưu mã thành công');
                        })
                        .catch(err => {
                            console.error(err);
                            showToast('Có lỗi xảy ra khi xử lý.', true);
                        });
                });
            });

            function showToast(message, isError = false) {
                const toast = document.createElement('div');
                toast.className = `alert ${isError ? 'alert-danger' : 'alert-success'}`;
                toast.innerText = message;
                toast.style.position = 'fixed';
                toast.style.bottom = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.style.minWidth = '200px';
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lấy ngày hiện tại dạng YYYY-MM-DD
            let today = new Date().toISOString().slice(0, 10);

            // Kiểm tra xem đã lưu ngày hiển thị popup chưa
            if (localStorage.getItem('popupShownDate') !== today) {
                setTimeout(function() {
                    $('#popupModal').modal('show');
                    // Lưu ngày hôm nay để không hiển thị lại
                    localStorage.setItem('popupShownDate', today);
                }, 1000);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (!localStorage.getItem('popupShown')) {
                setTimeout(function() {
                    $('#myModal').modal('show');
                    localStorage.setItem('popupShown', 'yes');
                }, 1000);
            }
        });
    </script>
    @include('Frontend.partials.footer')
    @include('Frontend.partials.modal')
    @include('Frontend.partials.chatbot')


    <style>
        /* Recently Viewed Products Styling */
        .home-recently-viewed {
            padding: 60px 0;
            background: #f8f9fa;
        }

        .home-recently-viewed-header .section-title-all {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .clear-recently-viewed {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .clear-recently-viewed:hover {
            background: #c82333;
        }

        .recently-viewed-products-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .recently-viewed-item {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .recently-viewed-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .recently-viewed-item-image {
            position: relative;
            padding-bottom: 100%;
            overflow: hidden;
        }

        .recently-viewed-item-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .recently-viewed-item:hover .recently-viewed-item-image img {
            transform: scale(1.05);
        }

        .recently-viewed-item-content {
            padding: 15px;
        }

        .recently-viewed-item-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .recently-viewed-item-title:hover {
            color: #007bff;
            text-decoration: none;
        }

        .recently-viewed-item-price {
            font-size: 18px;
            font-weight: 700;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .recently-viewed-item-actions {
            display: flex;
            gap: 8px;
        }

        .recently-viewed-btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .recently-viewed-btn-primary {
            background: #007bff;
            color: white;
        }

        .recently-viewed-btn-primary:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
        }

        .recently-viewed-btn-remove {
            background: #6c757d;
            color: white;
            flex: 0 0 auto;
            width: 40px;
        }

        .recently-viewed-btn-remove:hover {
            background: #5a6268;
        }

        .recently-viewed-empty {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
            font-size: 16px;
        }

        .recently-viewed-empty i {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }

        @media (max-width: 768px) {
            .recently-viewed-products-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }

            .home-recently-viewed {
                padding: 40px 0;
            }

            .home-recently-viewed-header .section-title-all {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>

    <script src="{{ asset('js/recently-viewed.js') }}"></script>

</body>
@include('Frontend.partials.scrip')

</html>
