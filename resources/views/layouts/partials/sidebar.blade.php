<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('admin.statistics') }}">
            <span class="align-middle">AdminKit</span>
        </a>

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
            <li class="sidebar-item has-sub {{ request()->routeIs('warehouse.*') || request()->routeIs('purchase-orders.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="#!" data-bs-toggle="collapse" data-bs-target="#submenu-warehouse" aria-expanded="{{ request()->routeIs('warehouse.*') || request()->routeIs('purchase-orders.*') ? 'true' : 'false' }}">
                    <i class="fa-solid fa-warehouse"></i>
                    <span class="align-middle">Quản Lý Kho</span>
                </a>
                <ul id="submenu-warehouse" class="collapse sidebar-dropdown list-unstyled {{ request()->routeIs('warehouse.*') || request()->routeIs('purchase-orders.*') ? 'show' : '' }}">
                    <li class="sidebar-item {{ request()->routeIs('warehouse.index') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('warehouse.index') }}">Tồn kho</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('warehouse.import_creater') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('warehouse.import_creater') }}">Tạo đơn nhập hàng</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('warehouse.history') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('warehouse.history') }}">Nhập Hàng</a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('warehouse.supplier') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('warehouse.supplier') }}">Nhà Cung Cấp</a>
                    </li>

                </ul>
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

            <li class="sidebar-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('contacts.index') }}">
                    <i class="align-middle" data-feather="message-circle"></i>
                    <span class="align-middle">Quản lý liên hệ</span>
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
    </div>
</nav>
