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

<<<<<<< HEAD
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
=======
        <ul class="sidebar-nav">
            <li class="sidebar-header">Quản lý</li>

            <li class="sidebar-item {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('admin.statistics') }}">
                    <i class="align-middle" data-feather="sliders"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('products.index') }}">
                    <i class="align-middle" data-feather="shopping-bag"></i>
                    <span class="align-middle">Products</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('categories.index') }}">
                    <i class="align-middle" data-feather="tag"></i>
                    <span class="align-middle">Categories</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('post-categories.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('post-categories.index') }}">
                    <i class="align-middle" data-feather="tag"></i>
                    <span class="align-middle">Post Categories</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('posts.index') }}">
                    <i class="align-middle" data-feather="layers"></i>
                    <span class="align-middle">Posts</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('brands.index') }}">
                    <i class="align-middle" data-feather="briefcase"></i>
                    <span class="align-middle">Brands</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('coupons.index') }}">
                    <i class="align-middle" data-feather="percent"></i>
                    <span class="align-middle">Coupons</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('banners.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('banners.index') }}">
                    <i class="align-middle" data-feather="file-text"></i>
                    <span class="align-middle">Banner</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('users.index') }}">
                    <i class="align-middle" data-feather="file-text"></i>
                    <span class="align-middle">User</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('orders.index') }}">
                    <i class="align-middle" data-feather="file-text"></i>
                    <span class="align-middle">Orders</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('attributes.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('attributes.index') }}">
                    <i class="align-middle" data-feather="layers"></i>
                    <span class="align-middle">Attributes</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('sizes.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('sizes.index') }}">
                    <i class="align-middle" data-feather="maximize-2"></i>
                    <span class="align-middle">Size</span>
                </a>
            </li>

            <li class="sidebar-header">Tài khoản</li>

            <li class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('profile.edit') }}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <a href="#" class="sidebar-link"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="align-middle" data-feather="log-out"></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </form>
            </li>
        </ul>
>>>>>>> feature/order-cancellation
    </div>

    <div class="menu-inner-shadow"></div>



    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Bảng điều khiển">Bảng điều khiển</div>
                <div class="badge text-bg-danger rounded-pill ms-auto">3</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Phân tích">Phân tích</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Quản lý khách hàng">Quản lý khách hàng</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Thương mại điện tử">Thương mại điện tử</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Ứng dụng & Trang">Ứng dụng &amp; Trang</span>
        </li>
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-mail"></i>
                <div data-i18n="Email">Email</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-messages"></i>
                <div data-i18n="Trò chuyện">Trò chuyện</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="#" class="menu-link">
                <i class="menu-icon icon-base ti tabler-layout-kanban"></i>
                <div data-i18n="Kanban">Kanban</div>
            </a>
        </li>
        <!-- e-commerce-app menu start -->
        <li class="menu-item {{ Request::routeIs(['admin.statistics', 'orders.index', 'contacts.index', 'products.index', 'products.create', 'categories.index', 'categories.create', 'post-categories.index', 'post-categories.create', 'brands.index', 'brands.create', 'posts.index', 'posts.create', 'coupons.index', 'coupons.create', 'banners.index', 'banners.create']) ? 'active open' : '' }}">
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
                <li class="menu-item {{ Request::routeIs('orders.index') ? 'active' : '' }}">
                    <a href="{{ route('orders.index') }}" class="menu-link">
                        <div data-i18n="Danh sách đơn hàng">Danh sách đơn hàng</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('contacts.index') ? 'active' : '' }}">
                    <a href="{{ route('contacts.index') }}" class="menu-link">
                        <div data-i18n="Danh sách liên hệ">Danh sách liên hệ</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('reviews.approve') ? 'active' : '' }}">
                    <a href="{{ route('reviews.approve', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Quản lý đánh giá">Quản lý đánh giá</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs(['categories.index', 'categories.create', 'post-categories.index', 'post-categories.create', 'brands.index', 'brands.create']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Danh mục & Thương hiệu">Danh mục & Thương hiệu</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs(['categories.index', 'categories.create']) ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div data-i18n="Sản phẩm">Sản phẩm</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('categories.index') ? 'active' : '' }}">
                                    <a href="{{ route('categories.index') }}" class="menu-link">
                                        <div data-i18n="Danh mục sản phẩm">Danh mục sản phẩm</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('categories.create') ? 'active' : '' }}">
                                    <a href="{{ route('categories.create') }}" class="menu-link">
                                        <div data-i18n="Thêm danh mục sản phảm">Thêm danh mục sản phảm</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ Request::routeIs(['post-categories.index', 'post-categories.create']) ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div data-i18n="Bài viết">Bài viết</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('post-categories.index') ? 'active' : '' }}">
                                    <a href="{{ route('post-categories.index') }}" class="menu-link">
                                        <div data-i18n="Danh mục bài viết">Danh mục bài viết</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('post-categories.create') ? 'active' : '' }}">
                                    <a href="{{ route('post-categories.create') }}" class="menu-link">
                                        <div data-i18n="Thêm danh mục bài viết">Thêm danh mục bài viết</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item {{ Request::routeIs(['brands.index', 'brands.create']) ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div data-i18n="Thương hiệu">Thương hiệu</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item {{ Request::routeIs('brands.index') ? 'active' : '' }}">
                                    <a href="{{ route('brands.index') }}" class="menu-link">
                                        <div data-i18n="Danh mục thương hiệu">Danh mục thương hiệu</div>
                                    </a>
                                </li>
                                <li class="menu-item {{ Request::routeIs('brands.create') ? 'active' : '' }}">
                                    <a href="{{ route('brands.create') }}" class="menu-link">
                                        <div data-i18n="Thêm danh mục thương hiệu">Thêm danh mục thương hiệu</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ Request::routeIs(['products.index', 'products.create']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Sản phẩm">Sản phẩm</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs('products.index') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}" class="menu-link">
                                <div data-i18n="Danh sách sản phẩm">Danh sách sản phẩm</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('products.create') ? 'active' : '' }}">
                            <a href="{{ route('products.create') }}" class="menu-link">
                                <div data-i18n="Thêm sản phẩm">Thêm sản phẩm</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ Request::routeIs(['posts.index', 'posts.create']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Bài viết">Bài viết</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs('posts.index') ? 'active' : '' }}">
                            <a href="{{ route('posts.index') }}" class="menu-link">
                                <div data-i18n="Danh sách bài viết">Danh sách bài viết</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::routeIs('posts.create') ? 'active' : '' }}">
                            <a href="{{ route('posts.create') }}" class="menu-link">
                                <div data-i18n="Thêm bài viết">Thêm bài viết</div>
                            </a>
                        </li>
                    </ul>
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
                <li class="menu-item {{ Request::routeIs(['banners.index', 'banners.create']) ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Banner">Banner</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs('banners.index') ? 'active' : '' }}">
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
            </ul>
        </li>

        <li class="menu-item {{ Request::routeIs(['warehouse.index', 'warehouse.import_creater', 'warehouse.supplier', 'suppliers.index']) ? 'active open' : '' }}">
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
                <!-- <li class="menu-item {{ Request::routeIs('warehouse.list') ? 'active' : '' }}">
                    <a href="{{ route('warehouse.list', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Danh Sách Nhập Hàng">Danh Sách Nhập Hàng</div>
                    </a>
                </li> -->
                <li class="menu-item {{ Request::routeIs('suppliers.index') ? 'active' : '' }}">
                    <a href="{{ route('suppliers.index', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Nhà Cung Cấp">Nhà Cung Cấp</div>
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
                <li class="menu-item {{ Request::routeIs('users.create') ? 'active' : '' }}">
                    <a href="{{ route('users.create', ['review' => 1]) }}" class="menu-link">
                        <div data-i18n="Thêm người dùng">Thêm người dùng</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-settings"></i>
                <div data-i18n="Vai trò & Quyền hạn">Vai trò & Quyền hạn</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Vai trò">Vai trò</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Quyền">Quyền</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
