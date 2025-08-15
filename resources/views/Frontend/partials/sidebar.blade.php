<div class="col-md-3 mb-4">
    <div class="card border-0 shadow-sm text-center p-3">
        <img width="80" height="80" class="rounded-circle mb-3"
            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&font-size=.5"
            alt="{{ $user->name }}" />
        <h5 class="mb-3 fw-semibold">{{ $user->name }}</h5>
        <ul class="list-group list-group-flush text-start small">
            <li class="list-group-item border-0 px-0 py-2">
                <a href="/account" class="text-decoration-none fw-semibold text-primary">Thông tin tài khoản</a>
            </li>
            <li class="list-group-item border-0 px-0 py-2">
                <a href="/order-history" class="text-decoration-none text-dark">Đơn hàng của bạn</a>
            </li>
            <li class="list-group-item border-0 px-0 py-2">
                <a href="/account/addresses" class="text-decoration-none text-dark">Danh sách địa chỉ</a>
            </li>
            <li class="list-group-item border-0 px-0 py-2">
                <a href="/account/changepassword" class="text-decoration-none text-dark">Đổi mật khẩu</a>
            </li>
            <!-- Logout Form -->
            <li class="list-group-item border-0 px-0 py-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none text-danger p-0 m-0 align-baseline">
                        Đăng xuất
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>