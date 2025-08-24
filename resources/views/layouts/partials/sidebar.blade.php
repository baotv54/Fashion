<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <div class="app-brand demo ">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="currentColor" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3">QUẢN TRỊ</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>



    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Request::routeIs('admin.statistics') ? 'active' : '' }}">
            <a href="{{ route('admin.statistics') }}" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Thống Kê">Thống Kê</div>
                <!-- <div class="badge text-bg-danger rounded-pill ms-auto">3</div> -->
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('admin.statistics') ? 'active' : '' }}">
                    <a href="{{ route('admin.statistics') }}" class="menu-link">
                        <div data-i18n="Thống Kê">Thống Kê</div>
                    </a>
                </li>
                <!-- <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Quản lý khách hàng">Quản lý khách hàng</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Thương mại điện tử">Thương mại điện tử</div>
                    </a>
                </li> -->
            </ul>
        </li>

        <!-- Apps & Pages -->
         <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Tổng Quan">Tổng Quan</span>
        </li>
        <li class="menu-item {{ Request::routeIs(['orders.index']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-sharp fa-solid fa-newspaper me-2"></i>
                <div data-i18n="Quản Lý Đơn Hàng">Quản Lý Đơn Hàng </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('orders.index') ? 'active' : '' }}">
                    <a href="{{ route('orders.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh Sách Đơn Hàng">Danh Sách Đơn Hàng</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{ Request::routeIs(['products.index', 'products.create', 'products.edit', 'product_variants.index', 'product_variants.create', 'categories.index', 'categories.edit', 'brands.index', 'brands.edit', 'attributes.index', 'attributes.edit', 'attribute_values.index', 'attribute_values.edit','sizes.index', 'sizes.edit']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-box-open me-2"></i>
                <div data-i18n="Quản Lý Sản Phẩm">Quản Lý Sản Phẩm </div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs(['products.index','products.edit','product_variants.index', 'product_variants.create']) ? 'active' : '' }}">
                    <a href="{{ route('products.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh Sách Sản Phẩm">Danh Sách Sản Phẩm</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs(['categories.index', 'categories.edit']) ? 'active' : '' }}">
                    <a href="{{ route('categories.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh Mục">Danh Mục</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs(['brands.index', 'brands.edit']) ? 'active' : '' }}">
                    <a href="{{ route('brands.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Thương Hiệu"> Thương Hiệu </div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs(['attributes.index', 'attributes.edit', 'attribute_values.index', 'attribute_values.edit']) ? 'active' : '' }}">
                    <a href="{{ route('attributes.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Thuộc Tính">Thuộc Tính </div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs(['sizes.index', 'sizes.edit']) ? 'active' : '' }}">
                    <a href="{{ route('sizes.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Bảng Chọn Size">Bảng Chọn Size </div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- e-commerce-app menu start -->
        <li class="menu-item {{ Request::routeIs(['admin.statistics','admin.reviews.index', 'coupons.index', 'coupons.create','banners.index', 'banners.create', 'banners.edit','social-links.index', 'social-links.create', 'social-links.edit', 'logo.create', 'logo.edit','popups.index', 'popups.create', 'popups.edit']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-shopping-cart"></i>
                <div data-i18n="Thương mại điện tử">Thương mại điện tử</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('admin.statistics') ? 'active' : '' }}">
                    <a href="{{ route('admin.statistics') }}" class="menu-link">
                        <div data-i18n="Thống kê">Thống kê</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('admin.reviews.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.reviews.index') }}" class="menu-link">
                        <div data-i18n="Quản lý đánh giá">Quản lý đánh giá</div>
                    </a>
                </li>

                <li class="menu-item {{ Request::routeIs(['coupons.index', 'coupons.create']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Mã giảm giá">Mã giảm giá</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs('coupons.index') ? 'active' : '' }}">
                            <a href="{{ route('coupons.index') }}" class="menu-link">
                                <div data-i18n="Danh sách mã giảm giá">Danh sách mã giảm giá</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('coupons.create') ? 'active' : '' }}">
                            <a href="{{ route('coupons.create') }}" class="menu-link">
                                <div data-i18n="Thêm mã giảm giá">Thêm mã giảm giá</div>
                            </a>
                        </li>
                    </ul>
                </li>
               <li class="menu-item {{ Request::routeIs(['banners.index', 'banners.create', 'banners.edit', 'logo.create', 'logo.edit']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Banner">Banner</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs(['banners.index', 'logo.create']) ? 'active' : '' }}">
                            <a href="{{ route('banners.index') }}" class="menu-link">
                                <div data-i18n="Danh sách Banner">Danh sách Banner</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('banners.create') ? 'active' : '' }}">
                            <a href="{{ route('banners.create') }}" class="menu-link">
                                <div data-i18n="Thêm Banner">Thêm Banner</div>
                            </a>
                        </li>
                    </ul>
                </li>
                   <li class="menu-item {{ Request::routeIs(['social-links.index', 'social-links.create', 'social-links.edit', 'logo.create', 'logo.edit']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Mạng xã hội">Mạng xã hội</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs(['social-links.index', 'logo.create']) ? 'active' : '' }}">
                            <a href="{{ route('social-links.index') }}" class="menu-link">
                                <div data-i18n="Danh sách social links">Danh sách mạng xã hội</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('social-links.create') ? 'active' : '' }}">
                            <a href="{{ route('social-links.create') }}" class="menu-link">
                                <div data-i18n="Thêm social links">Thêm mạng xã hội</div>
                            </a>
                        </li>
                    </ul>
                </li>
                 <li class="menu-item {{ Request::routeIs(['popups.index', 'popups.create','popups.edit']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Popup">Popup</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs(['popups.index','popups.edit']) ? 'active' : '' }}">
                            <a href="{{ route('popups.index') }}" class="menu-link">
                                <div data-i18n="Danh sách Popup">Danh sách Popup</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('popups.create') ? 'active' : '' }}">
                            <a href="{{ route('popups.create') }}" class="menu-link">
                                <div data-i18n="Thêm Popup">Thêm Popup</div>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>

        <li class="menu-item {{ Request::routeIs(['warehouse.index', 'warehouse.import_creater', 'warehouse.supplier', 'suppliers.index','warehouse.trashed','returns.list']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-warehouse me-2"></i>
                <div data-i18n="Quản Lý Kho">Quản Lý Kho</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('warehouse.index') ? 'active' : '' }}">
                    <a href="{{ route('warehouse.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Tồn Kho">Tồn Kho</div>
                    </a>
                </li>
                <!-- <li class="menu-item {{ Request::routeIs('warehouse.import_creater') ? 'active' : '' }}">
                    <a href="{{ route('warehouse.import_creater', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Nhập Hàng">Nhập Hàng</div>
                    </a>
                </li> -->
                <li class="menu-item {{ Request::routeIs('warehouse.list') ? 'active' : '' }}">
                    <a href="{{ route('warehouse.list', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Nhập Hàng">Nhập Hàng</div>
                    </a>
                </li>
                 <li class="menu-item {{ Request::routeIs('returns.list') ? 'active' : '' }}">
                    <a href="{{ route('returns.list', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Trả Hàng">Trả Hàng</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('suppliers.index') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Nhà Cung Cấp">Nhà Cung Cấp</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('warehouse.trashed') ? 'active' : '' }}">
                    <a href="{{ route('warehouse.trashed', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Đơn Hàng Đã Xóa">Đơn Hàng Đã Xóa</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- e-commerce-app menu end -->
        <li class="menu-item {{ Request::routeIs(['users.index', 'users.create']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="Người dùng">Người dùng</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('users.index') ? 'active' : '' }}">
                    <a href="{{ route('users.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh sách">Danh sách</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- e-commerce-app menu end -->
        <li class="menu-item {{ Request::routeIs(['products.trashed','suppliers.trash']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-trash me-2"></i>
                <div data-i18n="Thùng Rác">Thùng Rác</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('products.trashed') ? 'active' : '' }}">
                    <a href="{{ route('products.trashed', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Sản Phẩm">Sản Phẩm</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('suppliers.trash') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.trash', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Nhà cung cấp">Nhà cung cấp </div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Giao Tiếp  -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Giao Tiếp"> Giao Tiếp</span>
        </li>
        <li class="menu-item {{ Request::routeIs('contacts.index') ? 'active' : '' }}">
            <a href="{{ route('contacts.index', ['review' => 1]) }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-mail"></i>
                <div data-i18n="Email">Email</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="{{ route('admin.plc.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-messages"></i>
                <div data-i18n="Live Chat sản phẩm">Live Chat sản phẩm</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs(['posts.index', 'post-categories.index']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-sharp fa-solid fa-newspaper me-2"></i>
                <div data-i18n="Tin Tức">Tin Tức</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('posts.index') ? 'active' : '' }}">
                    <a href="{{ route('posts.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh Sách Bài Viết">Danh Sách Bài Viết</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('post-categories.index') ? 'active' : '' }}">
                    <a href="{{ route('post-categories.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh Mục">Danh Mục</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-kanban"></i>
                <div data-i18n="Kanban">Kanban</div>
            </a>
        </li>
        <!-- Hệ Thống -->
         <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Hệ Thống">Hệ Thống</span>
        </li>
        <li class="menu-item {{ Request::routeIs('banners.index') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-settings"></i>
                <div data-i18n="Cấu Hình Hệ Thống">Cấu Hình Hệ Thống</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('banners.index') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Quản Lý Baner">Quản Lý Baner</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
