<header class="headers2">
    <div class="container">
        <div class="headers2-wrap">
            <div class="headers2-left">
                <a href="/" aria-label="F1GENZ Shoes">
                    <img src="{{ asset('images/shop_logo_imagee889.png') }}" alt="F1GENZ Shoes" title="F1GENZ Shoes">
                </a>
            </div>
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
                            <a href="/" title="Trang chủ" aria-label="Trang chủ">Trang chủ</a>
                        </li>
                        <li class="hasChild {{ Request::is('products') || Request::is('product/*') ? 'active' : '' }}">
                            <a href="/products" title="Converse All" aria-label="Converse All">Tất cả sản phẩm<span></span></a>
                            <!-- <ul class="menu1">
                                <li><a href="converse-allfc2c.html?view=vertical" title="Converse All Style 1" aria-label="Converse All Style 1">Converse All Style 1</a></li>
                                <li><a href="converse-allc267.html?view=horizontal" title="Converse All Style 2" aria-label="Converse All Style 2">Converse All Style 2</a></li>
                            </ul> -->
                        </li>
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
                        <li><a href="news.html" title="Tin tức" aria-label="Tin tức">Tin tức</a></li>
                        <!-- <li><a href="lien-he.html" title="Liên hệ" aria-label="Liên hệ">Liên hệ</a></li> -->
                        <li class="{{ Request::is('posts') ? 'active' : '' }}">
                            <a href="{{ url('/posts') }}" title="Tin tức" aria-label="Tin tức">Tin tức</a>
                        </li>
                        <li class="{{ Request::is('lien-he') ? 'active' : '' }}"><a href="lien-he" title="Liên hệ" aria-label="Liên hệ">Liên hệ</a></li>
                        <li class="{{ Request::is('gioi-thieu') ? 'active' : '' }}"><a href="{{ route('about') }}" title="Giới thiệu" aria-label="Giới thiệu">Giới thiệu</a></li>
                        @auth
                        {{-- Nút Trang Quản Trị nếu là admin --}}
                        @if(Auth::user()->role === 'admin')
                        <li><a href="admin/statistics">Quản Trị</a></li>
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
                                    <a href="https://www.facebook.com/" target="_blank" aria-label="F1GENZ Shoes - Facebook" title="F1GENZ Shoes - Facebook">
                                        <img width="30" height="30" loading="lazy" title="F1GENZ Shoes - Facebook" src="{{ asset('images/facebook__6__53aaa8d352524d3eb025af5203eaa437_icon.png') }}" alt="F1GENZ Shoes - Facebook">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.youtube.com/" target="_blank" aria-label="F1GENZ Shoes - Youtube" title="F1GENZ Shoes - Youtube">
                                        <img width="30" height="30" loading="lazy" title="F1GENZ Shoes - Youtube" src="{{ asset('images/youtube__5__4f04522e10494557a651f53a33ad4d76_icon.png') }}" alt="F1GENZ Shoes - Youtube">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.pinterest.com/" target="_blank" aria-label="F1GENZ Shoes - Pinterest" title="F1GENZ Shoes - Pinterest">
                                        <img width="30" height="30" loading="lazy" title="F1GENZ Shoes - Pinterest" src="{{ asset('images/pinterest_a1a15995132a4275845412deba5f1193_icon.png') }}" alt="F1GENZ Shoes - Pinterest">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.tiktok.com/" target="_blank" aria-label="F1GENZ Shoes - TikTok" title="F1GENZ Shoes - TikTok">
                                        <img width="30" height="30" loading="lazy" title="F1GENZ Shoes - TikTok" src="{{ asset('images/tik-tok_d85bb4e7468c43ac9ed5437649b7405c_icon.png') }}" alt="F1GENZ Shoes - TikTok">
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank" aria-label="F1GENZ Shoes - Instagram" title="F1GENZ Shoes - Instagram">
                                        <img width="30" height="30" loading="lazy" title="F1GENZ Shoes - Instagram" src="{{ asset('images/instagram__3__7de3ebbce1f24003b516ca6c1d7c24d5_icon.png') }}" alt="F1GENZ Shoes - Instagram">
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
                <form class="tool-search" action="https://f1genz-shoes.mysapo.net/search">
                    <input type="hidden" name="type" value="product">
                    <input required name="q" autocomplete="off" type="text" placeholder="Tìm kiếm sản phẩm...">
                    <button type="submit" title="Tìm kiếm"><i class="fal fa-search"></i></button>
                    <button class="tool-search-overplay" title="Đóng"></button>
                    <div class="tool-search-smart"></div>
                </form>
                @auth
                <button class="shop-tool" type="button" data-type="shop-customer-header" data-toggle="modal"
                    title="Tài khoản">
                    <a href="/account"><i class="fal fa-user"></i></a>
                </button>
                @else
                <button class="shop-tool" type="button" data-type="shop-customer-header" data-toggle="modal"
                    title="Tài khoản">
                    <a href="/Login"><i class="fal fa-user"></i></a>
                </button>
                @endauth
                <button class="shop-tool" type="button" data-type="shop-menu-mobile-header" title="Menu">
                    <i class="fal fa-bars"></i>
                </button>
                <button class="shop-tool has-count" type="button" data-type="shop-wishlist-header" title="Yêu thích">
                    <i class="fal fa-heart"></i>
                    <span class="shop-wishlist-count">0</span>
                </button>
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