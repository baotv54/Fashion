<header class="headers2">
    <div class="container">
        <div class="headers2-wrap">
            @foreach ($logos as $logo)
            <div class="headers2-left">
                <a href="/" aria-label="S7 STUDIO">
                    @if (!empty($logo->images))
                    <img src="/logo/{{ $logo->images }}" alt="S7 STUDIO" title="S7 STUDIO">
                    @else
                    <img src="/logo/image.png" alt="No Logo" title="No Logo">
                    @endif
                </a>
            </div>
            @endforeach
            <div class="headers2-center">
                <nav class="headers2-center-menu">
                    <ul class="menu0">
                        <li class="headers2-center-menu-mob-head">
                            <label>Danh mục</label>
                            <button type="button" data-type="close-menu-mobile" title="Đóng">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                                    <g>
                                        <path d="m4.59 59.41a2 2 0 0 0 2.83 0l24.58-24.58 24.59 24.58a2 2 0 0 0 2.83-2.83l-24.59-24.58 24.58-24.59a2 2 0 0 0 -2.83-2.83l-24.58 24.59-24.59-24.58a2 2 0 0 0 -2.82 2.82l24.58 24.59-24.58 24.59a2 2 0 0 0 0 2.82z" fill="#000000"></path>
                                    </g>
                                </svg>
                            </button>
                        </li>
                        <li class="{{ Request::is('/') ? 'active' : '' }}">
                            <a href="/" title="Trang chủ" aria-label="Trang chính">Trang chủ</a>
                        </li>
                        @include('components.menu-category', ['categories' => $headerCategories])

                        <!-- <li class="hasChild">
                            <a href="collections/allfc2c.html?view=vertical" title="Classic" aria-label="Classic">Classic<span>›</span></a>
                            <ul class="menu1">
                                <li class="hasChild">
                                    <a href="collections/all.html" title="Chuck Taylor" aria-label="Chuck Taylor">Chuck Taylor<span>›</span></a>
                                    <ul class="menu2">
                                        <li><a href="collections/all.html" title="Jimmy Choo" aria-label="Jimmy Choo">Jimmy Choo</a></li>
                                        <li><a href="collections/all.html" title="Manolo Blahnik" aria-label="Manolo Blahnik">Manolo Blahnik</a></li>
                                        <li><a href="collections/all.html" title="GAFA" aria-label="GAFA">GAFA</a></li>
                                        <li><a href="collections/all.html" title="Sergio Rossi" aria-label="Sergio Rossi">Sergio Rossi</a></li>
                                        <li><a href="collections/all.html" title="Valentino" aria-label="Valentino">Valentino</a></li>
                                        <li><a href="collections/all.html" title="Roger Vivier" aria-label="Roger Vivier">Roger Vivier</a></li>
                                        <li class="hasChild">
                                            <a href="collections/all.html" title="Miu Miu" aria-label="Miu Miu">Miu Miu<span>›</span></a>
                                            <ul class="menu3">
                                                <li class="active"><a href="index.html" title="ABV" aria-label="ABV">ABV</a></li>
                                            </ul>
                                        </li>
                                        <li class="active"><a href="index.html" title="Kate Spade" aria-label="Kate Spade">Kate Spade</a></li>
                                    </ul>
                                </li>
                                <li class="hasChild">
                                    <a href="collections/all.html" title="Giày" aria-label="Giày">Giày<span>›</span></a>
                                    <ul class="menu2">
                                        <li><a href="collections/all.html" title="Giày Cao Gót" aria-label="Giày Cao Gót">Giày Cao Gót</a></li>
                                        <li class="active"><a href="index.html" title="Giày Bít" aria-label="Giày Bít">Giày Bít</a></li>
                                        <li><a href="collections/all.html" title="Giày Sandals" aria-label="Giày Sandals">Giày Sandals</a></li>
                                        <li><a href="collections/all.html" title="Giày Búp Bê" aria-label="Giày Búp Bê">Giày Búp Bê</a></li>
                                        <li><a href="collections/all.html" title="Giày Sneaker" aria-label="Giày Sneaker">Giày Sneaker</a></li>
                                        <li><a href="collections/all.html" title="Giày Boots" aria-label="Giày Boots">Giày Boots</a></li>
                                        <li><a href="collections/all.html" title="Giày Da Thật" aria-label="Giày Da Thật">Giày Da Thật</a></li>
                                    </ul>
                                </li>
                                <li class="hasChild">
                                    <a href="collections/all.html" title="Túi xách" aria-label="Túi xách">Túi xách<span>›</span></a>
                                    <ul class="menu2">
                                        <li><a href="collections/all.html" title="Túi Xách Tay" aria-label="Túi Xách Tay">Túi Xách Tay</a></li>
                                        <li><a href="collections/all.html" title="Túi Đeo Chéo" aria-label="Túi Đeo Chéo">Túi Đeo Chéo</a></li>
                                        <li><a href="collections/all.html" title="Túi Xách Da Thật" aria-label="Túi Xách Da Thật">Túi Xách Da Thật</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="hasChild">
                            <a href="collections/all.html" title="Accessories - Phụ trang" aria-label="Accessories - Phụ trang">Accessories - Phụ trang<span>›</span></a>
                            <ul class="menu1">
                                <li class="hasChild">
                                    <a href="collections/all.html" title="Thắt lưng" aria-label="Thắt lưng">Thắt lưng<span>›</span></a>
                                    <ul class="menu2">
                                        <li class="active"><a href="index.html" title="Thắt lưng cao cấp" aria-label="Thắt lưng cao cấp">Thắt lưng cao cấp</a></li>
                                        <li class="active"><a href="index.html" title="Thắt lưng cho nam" aria-label="Thắt lưng cho nam">Thắt lưng cho nam</a></li>
                                        <li class="active"><a href="index.html" title="Thắt lưng cho nữ" aria-label="Thắt lưng cho nữ">Thắt lưng cho nữ</a></li>
                                    </ul>
                                </li>
                                <li class="hasChild">
                                    <a href="collections/all.html" title="Mắt kính" aria-label="Mắt kính">Mắt kính<span>›</span></a>
                                    <ul class="menu2">
                                        <li><a href="collections/all.html" title="Kính thời trang" aria-label="Kính thời trang">Kính thời trang</a></li>
                                        <li><a href="collections/all.html" title="Kính mát" aria-label="Kính mát">Kính mát</a></li>
                                        <li><a href="collections/all.html" title="Kính cho nam" aria-label="Kính cho nam">Kính cho nam</a></li>
                                        <li class="active"><a href="index.html" title="Kính cho nữ" aria-label="Kính cho nữ">Kính cho nữ</a></li>
                                    </ul>
                                </li>
                                <li><a href="collections/all.html" title="Trang sức" aria-label="Trang sức">Trang sức</a></li>
                                <li><a href="collections/all.html" title="Khăn choàng" aria-label="Khăn choàng">Khăn choàng</a></li>
                                <li><a href="collections/all.html" title="Mũ nón" aria-label="Mũ nón">Mũ nón</a></li>
                                <li><a href="collections/all.html" title="Phụ kiện khác" aria-label="Phụ kiện khác">Phụ kiện khác</a></li>
                            </ul>
                        </li> -->
                        <li class="{{ Request::is('posts') ? 'active' : '' }}">
                            <a href="{{ url('/posts') }}" title="Tin tức" aria-label="Tin tức">Tin tức</a>
                        </li>
                        <li class="{{ Request::is('lien-he') ? 'active' : '' }}"><a href="lien-he" title="Liên hệ" aria-label="Liên hệ">Liên hệ</a></li>
                        <li class="{{ Request::is('gioi-thieu') ? 'active' : '' }}"><a href="{{ route('about') }}" title="Giới thiệu" aria-label="Giới thiệu">Giới thiệu</a></li>
                        <li class="{{ Request::is('faq') ? 'active' : '' }}"><a href="faq" title="Câu hỏi thường gặp" aria-label="Câu hỏi thường gặp">Câu hỏi thường gặp</a></li>
                        @auth
                        {{-- Nút Trang Quản Trị nếu là admin --}}
                        @if(Auth::user()->role === 'admin')
                        <li class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.statistics') }}">Quản Trị</a>
                        </li>
                        @endif
                        @endauth
                        @auth
                        {{-- Nút Trang Nhân Viên  --}}
                        @if(Auth::user()->role === 'manage')
                        <li class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.statistics') }}">Nhân Viên</a>
                        </li>
                        @endif
                        @endauth
                        <li class="headers2-center-menu-mob-foot">
                            <div class="section-title-all">
                                <span>Hổ trợ 24/7</span>
                                <p>Đừng ngừng ngại liên hệ chúng tôi, hổ trợ 24/7 từ thứ 2 - thứ 7. Hotline: 1900.63.60.99</p>
                            </div>
                            <form id="mc-form3" action="https://gmail.us21.list-manage.com/subscribe/post?u=ddd0880c66f534593afa12e75&amp;id=fe6449bc79&amp;f_id=00cd9be1f0">
                                <input aria-label="Địa chỉ Email" type="email" placeholder="Nhập email ưu đãi" name="EMAIL" required autocomplete="off">
                                <button type="submit" title="Đăng ký nhận tin" name="subscribe">Đăng ký</button>
                            </form>
                            <ul class="shop-social">
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank" aria-label="S7 STUDIO - Facebook" title="S7 STUDIO - Facebook">
                                        <img width="30" height="30" loading="lazy" title="S7 STUDIO - Facebook" src="{{ asset('images/facebook__6__53aaa8d352524d3eb025af5203eaa437_icon.png') }}" alt="S7 STUDIO - Facebook">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/" target="_blank" aria-label="S7 STUDIO - Youtube" title="S7 STUDIO - Youtube">
                                        <img width="30" height="30" loading="lazy" title="S7 STUDIO - Youtube" src="{{ asset('images/youtube__5__4f04522e10494557a651f53a33ad4d76_icon.png') }}" alt="S7 STUDIO - Youtube">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.pinterest.com/" target="_blank" aria-label="S7 STUDIO - Pinterest" title="S7 STUDIO - Pinterest">
                                        <img width="30" height="30" loading="lazy" title="S7 STUDIO - Pinterest" src="{{ asset('images/pinterest_a1a15995132a4275845412deba5f1193_icon.png') }}" alt="S7 STUDIO - Pinterest">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.tiktok.com/" target="_blank" aria-label="S7 STUDIO - TikTok" title="S7 STUDIO - TikTok">
                                        <img width="30" height="30" loading="lazy" title="S7 STUDIO - TikTok" src="{{ asset('images/tik-tok_d85bb4e7468c43ac9ed5437649b7405c_icon.png') }}" alt="S7 STUDIO - TikTok">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank" aria-label="S7 STUDIO - Instagram" title="S7 STUDIO - Instagram">
                                        <img width="30" height="30" loading="lazy" title="S7 STUDIO - Instagram" src="{{ asset('images/instagram__3__7de3ebbce1f24003b516ca6c1d7c24d5_icon.png') }}" alt="S7 STUDIO - Instagram">
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div class="header-menu-arrow">
                    <button type="button" class="header-menu-arrow-prev" title="Trước" data-action="prev"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="header-menu-arrow-next" title="Sau" data-action="next"><i class="fa fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="headers2-right">
                <form class="tool-search" action="{{ route('products.all') }}" method="GET">
                    <input type="hidden" name="type" value="product">
                    <input required name="search" id="product-search" autocomplete="off" type="text" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                    <button type="submit" title="Tìm kiếm"><i class="fal fa-search"></i></button>
                    <button class="tool-search-overplay" title="Đóng"></button>
                    <!-- <div class="tool-search-smart"></div> -->
                    <ul id="search-suggestions" class="list-group position-absolute"></ul>
                </form>
                @auth
                <button class="shop-tool" type="button" data-type="shop-customer-header" data-toggle="modal"
                    title="Tài khoản">
                    <a href="/account"><i class="fal fa-user"></i></a>
                </button>
                <!-- Nút này KHÔNG nằm trong form -->
                <button class="has-count" type="button" title="Yêu thích" onclick="window.location.href='{{ route('favorites.index') }}'">
                    <i class="fal fa-heart"></i>
                    <span id="wishlist-count">{{ isset($favorites) ? $favorites->count() : 0 }}</span>
                </button>
                <!-- Nút So sánh sản phẩm -->
                <button class="shop-tool has-count" type="button" title="So sánh sản phẩm" data-type="shop-compare-header">
                    <i class="fas fa-balance-scale"></i>
                    <span class="shop-compare-count">0</span>
                </button>
                @else
                <button class="shop-tool" type="button" data-type="shop-customer-header" data-toggle="modal"
                    title="Tài khoản">
                    <a href="/Login"><i class="fal fa-user"></i></a>
                </button>
                @endauth
                <!-- <button class="shop-tool" type="button" data-type="shop-menu-mobile-header" title="Menu">
                    <i class="fal fa-bars"></i>
                </button> -->
                <button class="shop-tool has-count" type="button"
                    data-type="shop-cart-header" title="Giỏ hàng"
                    onclick="window.location.href='{{ route('cart.index') }}';">
                    <i class="fal fa-shopping-bag"></i>
                    <span class="shop-cart-count">{{ $carts->count() }}</span>
                </button>
            </div>

        </div>
    </div>
</header>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <a href="/product/${item.id}">${item.name}</a> -->

<script>
    $(document).ready(function() {
        $('#product-search').on('input', function() {
            let query = $(this).val();
            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('product.search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#search-suggestions').empty();

                        if (data.length > 0) {
                            let html = `<div class="search-title"><strong>Sản phẩm (${data.length})</strong></div>`;
                            data.forEach(function(item) {
                                html += `
                <div class="search-item" data-id="${item.id}">
                    <img src="${item.image_url}" alt="${item.name}">
                    <a href="/product/${item.id}">${item.name}</a>
                </div>
            `;
                            });
                            $('#search-suggestions').html(html);
                        } else {
                            $('#search-suggestions').html(`<div class="search-empty">Không tìm thấy sản phẩm</div>`);
                        }
                    }
                });
            } else {
                $('#search-suggestions').empty();
            }
        });

        // Ẩn gợi ý khi click ngoài
        $(document).click(function(e) {
            if (!$(e.target).closest('#product-search').length) {
                $('#search-suggestions').empty();
            }
        });
    });
</script>
<style>
    #search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #fff;
        /* Bỏ border */
        border: none;
        border-radius: 6px;
        max-height: 300px;
        overflow-y: auto;
        padding: 0;
        z-index: 999;

        /* Thêm hiệu ứng bóng */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .search-title {
        padding: 10px 15px;
        border-bottom: 1px solid #eee;
        font-weight: bold;
        font-size: 15px;
        color: #222;
    }

    .search-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 15px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .search-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 5px;
    }

    .search-item span {
        font-size: 14px;
        color: #000;
    }

    .search-item:hover {
        background-color: #f8f8f8;
    }

    .search-empty {
        padding: 10px 15px;
        color: #999;
        font-style: italic;
    }
</style>
