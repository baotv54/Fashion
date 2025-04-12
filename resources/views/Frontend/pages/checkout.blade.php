<!DOCTYPE html>
<html class="floating-labels">

<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="F1GENZ Shoes - Thanh toán đơn hàng" />
    <title>F1GENZ Shoes - Thanh toán đơn hàng</title>


    @include('Frontend.partials.head')

    <link rel="shortcut icon" href="//bizweb.dktcdn.net/assets/sapo_favicon.png" type="image/x-icon" />
    <!-- <link rel="stylesheet" href="{{asset('css/flag-icons.min.css')}}" />

    <link rel="stylesheet" href="{{asset('css/checkout.vendor.min.css')}}"> -->


    <link rel="stylesheet" href="{{asset('css/checkout.min.css')}}">


</head>

<body data-no-turbolink>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @include('Frontend.partials.header')
    <aside>
        <button class="order-summary-toggle" data-toggle="#order-summary" data-toggle-class="order-summary--is-collapsed">
            <span class="wrap">
                <span class="order-summary-toggle__inner">
                    <span class="order-summary-toggle__text expandable">
                        Đơn hàng ({{ $carts->count() }} sản phẩm)
                    </span>
                    <span class="order-summary-toggle__total-recap" data-bind="getTextTotalPrice()"></span>
                </span>
            </span>
        </button>
    </aside>




    <div data-tg-refresh="checkout" id="checkout" class="content">
        <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}">
            @csrf
            <!-- <input type="hidden" name="_method" value="patch" /> -->
            <div class="wrap">
                <main class="main">
                    <header class="main__header">
                        <div class="logo logo--left">

                            <h1 class="shop__name">
                                <a href="/">F1GENZ Shoes</a>
                            </h1>

                        </div>
                    </header>
                    <div class="main__content">
                        <article class="animate-floating-labels row">
                            <div class="col col--two">
                                <section class="section">
                                    <div class="section__header">
                                        <div class="layout-flex">
                                            <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                                <i class="fa fa-id-card-o fa-lg section__title--icon hide-on-desktop"></i>

                                                Thông tin nhận hàng

                                            </h2>

                                            @if (Auth::check())
                                            <a href="{{route('logout')}}">
                                                <i class="fa fa-user-circle-o fa-lg"></i>
                                                <span>Đăng xuất</span>
                                            </a>
                                            @else
                                            <a href="{{route('login')}}">
                                                <i class="fa fa-user-circle-o fa-lg"></i>
                                                <span>Đăng nhập</span>
                                            </a>
                                            @endif



                                        </div>
                                    </div>
                                    <div class="section__content">
                                        <div class="fieldset">
                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="email" class="">Email</label>
                                                    <input name="email" id="email" type="email" class="field__input" value="" required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="billingName" class="">Họ và tên</label>
                                                    <input name="billingName" id="billingName" type="text" class="field__input" value="" required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper ">
                                                    <label for="billingPhone" class="">Số điện thoại</label>
                                                    <input name="billingPhone" id="billingPhone" type="tel" class="field__input" value="" required>

                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="billingAddress" class="">Địa chỉ (tùy chọn)</label>
                                                    <input name="billingAddress" id="billingAddress" type="text" class="field__input" value="" required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper field__input-wrapper--select2">
                                                    <label for="billingProvince" class="">Tỉnh thành</label>
                                                    <select name="billingProvince" id="billingProvince" class="field__input field__input--select" required>
                                                        <option value="">Chọn tỉnh/thành</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper field__input-wrapper--select2">
                                                    <label for="billingDistrict" class="">Quận huyện (tùy chọn)</label>
                                                    <select name="billingDistrict" id="billingDistrict" class="field__input field__input--select" required>
                                                        <option value="">Chọn quận/huyện</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper field__input-wrapper--select2">
                                                    <label for="billingWard" class="">Phường xã (tùy chọn)</label>
                                                    <select name="billingWard" id="billingWard" class="field__input field__input--select" required>
                                                        <option value="">Chọn phường/xã</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <div class="fieldset">
                                    <h3 class="visually-hidden">Ghi chú</h3>
                                    <div class="field">
                                        <div class="field__input-wrapper">
                                            <label for="note" class="">Ghi chú (tùy chọn)</label>
                                            <textarea name="note" id="note" class="field__input"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="">
                                <!-- <section class="section" data-define="{shippingMethod: ''}">
                                    <div class="section__header">
                                        <div class="layout-flex">
                                            <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                                <i class="fa fa-truck fa-lg section__title--icon hide-on-desktop"></i>
                                                Vận chuyển
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="section__content" data-tg-refresh="refreshShipping" id="shippingMethodList"
                                        data-define="{isAddressSelecting: true, shippingMethods: []}">
                                        <div class="alert alert--loader spinner spinner--active" data-bind-show="isLoadingShippingMethod">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="spinner-loader">
                                                <use href="#spinner"></use>
                                            </svg>
                                        </div>


                                        <div class="alert alert--danger" data-bind-show="!isLoadingShippingMethod && !isAddressSelecting && !isLoadingShippingError">
                                            Khu vực không hỗ trợ vận chuyển
                                        </div>

                                        <div class="alert alert-retry alert--danger hide"
                                            data-bind-event-click="handleShippingMethodErrorRetry()"
                                            data-bind-show="!isLoadingShippingMethod && !isAddressSelecting && isLoadingShippingError">
                                            <span data-bind="loadingShippingErrorMessage"></span> <i class="fa fa-refresh"></i>
                                        </div>


                                        <div class="content-box" data-bind-show="!isLoadingShippingMethod && !isAddressSelecting && !isLoadingShippingError">


                                        </div>

                                        <div class="alert alert--info hide" data-bind-show="!isLoadingShippingMethod && isAddressSelecting">
                                            Vui lòng nhập thông tin giao hàng
                                        </div>
                                    </div>
                                </section> -->

                                <section class="section">
                                    <div class="section__header">
                                        <div class="layout-flex">
                                            <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                                <i class="fa fa-credit-card fa-lg section__title--icon hide-on-desktop"></i>
                                                Thanh toán
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="section__content">
                                        <div class="content-box" data-define="{paymentMethod: undefined}">
                                            <!-- Phương thức thanh toán: Chuyển khoản -->
                                            <div class="content-box__row">
                                                <div class="radio-wrapper">
                                                    <div class="radio__input">
                                                        <input name="paymentMethod" id="paymentMethod-bank_transfer"
                                                            type="radio" class="input-radio"
                                                            value="bank_transfer" required>
                                                    </div>
                                                    <label for="paymentMethod-bank_transfer" class="radio__label">
                                                        <span class="radio__label__primary">Chuyển khoản</span>
                                                        <span class="radio__label__accessory">
                                                            <span class="radio__label__icon">
                                                                <i class="payment-icon payment-icon--bank"></i>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- Phương thức thanh toán: Thu hộ (COD) -->
                                            <div class="content-box__row">
                                                <div class="radio-wrapper">
                                                    <div class="radio__input">
                                                        <input name="paymentMethod" id="paymentMethod-cod"
                                                            type="radio" class="input-radio"
                                                            value="cod" required>
                                                    </div>
                                                    <label for="paymentMethod-cod" class="radio__label">
                                                        <span class="radio__label__primary">Thu hộ (COD)</span>
                                                        <span class="radio__label__accessory">
                                                            <span class="radio__label__icon">
                                                                <i class="payment-icon payment-icon--cod"></i>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Phương thức thanh toán: VNPAY -->
                                            <div class="content-box__row">
                                                <div class="radio-wrapper">
                                                    <div class="radio__input">
                                                        <input name="paymentMethod" id="paymentMethod-vnpay"
                                                            type="radio" class="input-radio"
                                                            value="vnpay" required>
                                                    </div>
                                                    <label for="paymentMethod-vnpay" class="radio__label">
                                                        <span class="radio__label__primary">Thanh toán qua VNPAY</span>
                                                        <span class="radio__label__accessory">
                                                            <span class="radio__label__icon">
                                                                <i class="payment-icon payment-icon--vnpay"></i>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </article>
                        <div class="field__input-btn-wrapper field__input-btn-wrapper--vertical hide-on-desktop">
                            <button type="submit" class="btn btn-checkout spinner">
                                <span class="spinner-label">ĐẶT HÀNG</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="spinner-loader">
                                    <use href="#spinner"></use>
                                </svg>
                            </button>

                            <a href="/cart" class="previous-link">
                                <i class="previous-link__arrow">❮</i>
                                <span class="previous-link__content">Quay về giỏ hàng</span>
                            </a>

                        </div>

                        <div id="common-alert" data-tg-refresh="refreshError">


                            <div class="alert alert--danger hide-on-desktop"
                                data-bind-show="!isSubmitingCheckout && isSubmitingCheckoutError"
                                data-bind="submitingCheckoutErrorMessage">
                            </div>
                        </div>
                    </div>

                </main>
                <aside class="">
                    <div class="sidebar__header">
                        <h2 class="sidebar__title">
                            Đơn hàng ({{ $carts->count() }} sản phẩm)
                        </h2>
                    </div>
                    <div class="sidebar__content">
                        <div id="order-summary" class="order-summary order-summary--is-collapsed">
                            <div class="order-summary__sections">
                                @foreach ($carts as $cart)
                                <div class="order-summary__section order-summary__section--product-list order-summary__section--is-scrollable order-summary--collapse-element">
                                    <table class="product-table" id="product-table" data-tg-refresh="refreshDiscount">
                                        <caption class="visually-hidden">Chi tiết đơn hàng</caption>
                                        <thead class="product-table__header">
                                            <tr>
                                                <th>
                                                    <span class="visually-hidden">Hình ảnh sản phẩm</span>
                                                </th>
                                                <th>
                                                    <span class="visually-hidden">Mô tả</span>
                                                </th>
                                                <th>
                                                    <span class="visually-hidden">Sổ lượng</span>
                                                </th>
                                                <th>
                                                    <span class="visually-hidden">Đơn giá</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr class="product">
                                                <td class="product__image">
                                                    <div class="product-thumbnail">
                                                        <div class="product-thumbnail__wrapper" data-tg-static>
                                                            <img src="{{$cart->options->image}}" alt="" class="product-thumbnail__image" />
                                                        </div>
                                                        <span class="product-thumbnail__quantity">{{$cart->qty}}</span>
                                                    </div>
                                                </td>
                                                <th class="product__description">
                                                    <span class="product__description__name">
                                                        {{$cart->name}}
                                                    </span>

                                                    <!-- <span class="product__description__property">
                                                        35
                                                    </span> -->



                                                </th>
                                                <td class="product__quantity visually-hidden"><em>Số lượng:</em> 1</td>
                                                <td class="product__price">

                                                    <span>{{ number_format($cart->price * $cart->qty, 0, ',', '.') }}₫</span>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                @endforeach
                                <div class="order-summary__section order-summary__section--discount-code" id="discountCode">
                                    <h3 class="visually-hidden">Mã khuyến mại</h3>
                                    <div class="edit_checkout animate-floating-labels">
                                        <div class="fieldset">
                                            <div class="field">
                                                <div class="field__input-btn-wrapper">
                                                    <div class="field__input-wrapper">
                                                        <label for="reductionCode" class="">Nhập mã giảm giá</label>
                                                        <input name="coupon_code" id="reductionCode" type="text" class="field__input" autocomplete="off">
                                                    </div>
                                                    <button class="field__input-btn btn spinner" type="button" id="applyCoupon">
                                                        <span class="spinner-label">Áp dụng</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(Session::has('coupon'))
                                    <div class="alert alert-success mt-3">
                                        <strong>Mã giảm giá:</strong> {{ Session::get('coupon.code') }}<br>
                                        <strong>Giảm giá:</strong>
                                        -{{ number_format(Session::get('coupon.discount', 0), 0, ',', '.') }}₫
                                        <button type="button" class="btn btn-danger btn-sm float-end" id="removeCoupon">Xóa mã</button>
                                    </div>
                                    @endif
                                </div>

                                <div class="order-summary__section order-summary__section--total-lines order-summary--collapse-element"
                                    data-define="{subTotalPriceText: '1.900.000₫'}"
                                    data-tg-refresh="refreshOrderTotalPrice" id="orderSummary">
                                    <table class="total-line-table">
                                        <caption class="visually-hidden">Tổng giá trị</caption>
                                        <thead>
                                            <tr>
                                                <td><span class="visually-hidden">Mô tả</span></td>
                                                <td><span class="visually-hidden">Giá tiền</span></td>
                                            </tr>
                                        </thead>
                                        <tbody class="total-line-table__tbody">
                                            <tr class="total-line total-line--subtotal">
                                                <th class="total-line__name">
                                                    Tạm tính
                                                </th>
                                                <td class="total-line__price">{{ Cart::subtotal() }}₫</td>
                                            </tr>

                                            @if(Session::has('coupon'))
                                            <tr class="total-line total-line--discount">
                                                <th class="total-line__name">
                                                    Giảm giá ({{ Session::get('coupon.code') }})
                                                </th>
                                                <td class="total-line__price">
                                                    -{{ number_format(Session::get('coupon.discount', 0), 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                            @endif

                                            <tr class="total-line total-line--shipping-fee">
                                                <th class="total-line__name">
                                                    Phí vận chuyển
                                                </th>
                                                <td class="total-line__price">
                                                    <span class="origin-price" data-bind="getTextShippingPriceOriginal()"></span>
                                                    <span data-bind="getTextShippingPriceFinal()"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="total-line-table__footer">
                                            <tr class="total-line payment-due">
                                                <th class="total-line__name">
                                                    <span class="payment-due__label-total">
                                                        Tổng cộng
                                                    </span>
                                                </th>
                                                <td class="total-line__price">
                                                    <span class="payment-due__price">

                                                        <span class="payment-due__price">
                                                            {{ number_format($total, 0, ',', '.') }}₫
                                                        </span> </span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="order-summary__nav field__input-btn-wrapper hide-on-mobile layout-flex--row-reverse">
                                    <button type="submit" class="btn btn-checkout spinner">
                                        <span class="spinner-label">ĐẶT HÀNG</span>
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" class="spinner-loader">
                                            <use href="#spinner"></use>
                                        </svg> -->
                                    </button>


                                    <a href="/cart" class="previous-link">
                                        <i class="previous-link__arrow">❮</i>
                                        <span class="previous-link__content">Quay về giỏ hàng</span>
                                    </a>

                                </div>
                                <div id="common-alert-sidebar" data-tg-refresh="refreshError">


                                    <div class="alert alert--danger hide-on-mobile hide"
                                        data-bind-show="!isSubmitingCheckout && isSubmitingCheckoutError"
                                        data-bind="submitingCheckoutErrorMessage">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </form>


        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="spinner">
                <svg viewBox="0 0 30 30">
                    <circle stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-dasharray="85%"
                        cx="50%" cy="50%" r="40%">
                        <animateTransform attributeName="transform"
                            type="rotate"
                            from="0 15 15"
                            to="360 15 15"
                            dur="0.7s"
                            repeatCount="indefinite" />
                    </circle>
                </svg>
            </symbol>
        </svg>
    </div>
    @include('Frontend.partials.footer')
    @include('Frontend.partials.scrip')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('billingProvince');
            const districtSelect = document.getElementById('billingDistrict');
            const wardSelect = document.getElementById('billingWard');

            // Load provinces
            fetch('/address/province')
                .then(response => response.json())
                .then(data => {
                    provinceSelect.innerHTML = '<option value="">Chọn tỉnh/thành</option>';
                    data.forEach(province => {
                        provinceSelect.innerHTML += `<option value="${province.ProvinceID}">${province.ProvinceName}</option>`;
                    });
                });

            // Load districts when a province is selected
            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;
                districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>'; // Reset wards

                if (provinceId) {
                    fetch(`/address/district/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(district => {
                                districtSelect.innerHTML += `<option value="${district.DistrictID}">${district.DistrictName}</option>`;
                            });
                        });
                }
            });

            // Load wards when a district is selected
            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';

                if (districtId) {
                    fetch(`/address/ward/${districtId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(ward => {
                                wardSelect.innerHTML += `<option value="${ward.WardCode}">${ward.WardName}</option>`;
                            });
                        });
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('applyCoupon').addEventListener('click', function() {
                const couponCode = document.getElementById('reductionCode').value;

                if (!couponCode) {
                    alert('Vui lòng nhập mã giảm giá!');
                    return;
                }

                fetch('/apply-coupon', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            coupon_code: couponCode
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Có lỗi xảy ra khi áp dụng mã giảm giá!');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Áp dụng mã giảm giá thành công!');
                            location.reload();
                        } else {
                            alert(data.message || 'Mã giảm giá không hợp lệ!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã xảy ra lỗi khi áp dụng mã giảm giá!');
                    });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('removeCoupon').addEventListener('click', function() {
                fetch('/remove-coupon', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Có lỗi xảy ra khi xóa mã giảm giá!');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            location.reload(); // Reload lại trang để cập nhật giá trị
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã xảy ra lỗi khi xóa mã giảm giá!');
                    });
            });
        });
    </script>
</body>

</html>