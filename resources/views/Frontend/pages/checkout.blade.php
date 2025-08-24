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
    <!-- <link rel="stylesheet" href="{{ asset('css/flag-icons.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/checkout.vendor.min.css') }}"> -->


    <link rel="stylesheet" href="{{ asset('css/checkout.min.css') }}">


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
    <aside>
        <button class="order-summary-toggle" data-toggle="#order-summary"
            data-toggle-class="order-summary--is-collapsed">
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

                            <!-- <h1 class="shop__name">
                                <a href="/">F1GENZ Shoes</a>
                            </h1> -->

                        </div>
                    </header>
                    <div class="main__content">
                        <article class="animate-floating-labels row">
                            <div class="col col--two">
                                <section class="section">
                                    <div class="section__header">
                                        <div class="layout-flex">
                                            <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                                <i
                                                    class="fa fa-id-card-o fa-lg section__title--icon hide-on-desktop"></i>
                                                Thông tin nhận hàng
                                            </h2>

                                            @if (Auth::check())
                                                <a href="{{ route('logout') }}">
                                                    <i class="fa fa-user-circle-o fa-lg"></i>
                                                    <span>Đăng xuất</span>
                                                </a>
                                            @else
                                                <a href="{{ route('login') }}">
                                                    <i class="fa fa-user-circle-o fa-lg"></i>
                                                    <span>Đăng nhập</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="section__content">
                                        <div class="fieldset">

                                            {{-- Chọn địa chỉ đã lưu --}}
                                            @if (isset($addresses) && $addresses->count() > 0)
                                                <div class="field mb-3">
                                                    <label for="selectSavedAddress">Chọn địa chỉ đã lưu</label>
                                                    <div class="field__input-wrapper field__input-wrapper--select2">
                                                        <select id="selectSavedAddress"
                                                            class="field__input field__input--select">
                                                            <option value="">-- Chọn địa chỉ --</option>
                                                            @foreach ($addresses as $address)
                                                                <option value="{{ $address->id }}"
                                                                    data-name="{{ $address->name }}"
                                                                    data-phone="{{ $address->phone }}"
                                                                    data-address="{{ $address->address }}"
                                                                    data-province="{{ $address->province }}"
                                                                    data-district="{{ $address->district }}"
                                                                    data-ward="{{ $address->ward }}">
                                                                    {{ $address->name }} - {{ $address->address }},
                                                                    {{ $address->ward }}, {{ $address->district }},
                                                                    {{ $address->province }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Form nhập thông tin --}}
                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="email">Email</label>
                                                    <input name="email" id="email" type="email"
                                                        class="field__input" value="{{ Auth::user()->email ?? '' }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="billingName">Họ và tên</label>
                                                    <input name="billingName" id="billingName" type="text"
                                                        class="field__input" value="{{ Auth::user()->name ?? '' }}"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="billingPhone">Số điện thoại</label>
                                                    <input name="billingPhone" id="billingPhone" type="tel"
                                                        class="field__input" value="" required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="field__input-wrapper">
                                                    <label for="billingAddress">Địa chỉ chi tiết</label>
                                                    <input name="billingAddress" id="billingAddress" type="text"
                                                        class="field__input" value="" required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label for="billingProvince">Tỉnh / Thành phố</label>
                                                <div class="field__input-wrapper field__input-wrapper--select2">
                                                    <select name="billingProvince" id="billingProvince"
                                                        class="field__input field__input--select" required>
                                                        <option value="">-- Chọn tỉnh / thành phố --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label for="billingDistrict">Quận / Huyện</label>
                                                <div class="field__input-wrapper field__input-wrapper--select2">
                                                    <select name="billingDistrict" id="billingDistrict"
                                                        class="field__input field__input--select" required>
                                                        <option value="">-- Chọn quận / huyện --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <label for="billingWard">Phường / Xã</label>
                                                <div class="field__input-wrapper field__input-wrapper--select2">
                                                    <select name="billingWard" id="billingWard"
                                                        class="field__input field__input--select" required>
                                                        <option value="">-- Chọn phường / xã --</option>
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
                                <section class="section" id="shippingSection">
                                    <div class="section__header">
                                        <div class="layout-flex">
                                            <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                                <i class="fa fa-truck fa-lg section__title--icon hide-on-desktop"></i>
                                                Vận chuyển
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="section__content" id="shippingMethodList">
                                        <div class="alert alert--loader spinner spinner--active hide">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="spinner-loader">
                                                <use href="#spinner"></use>
                                            </svg>
                                        </div>

                                        <div class="alert alert--danger hide">
                                            Khu vực không hỗ trợ vận chuyển
                                        </div>

                                        <div class="alert alert-retry alert--danger hide">
                                            <span id="loadingShippingErrorMessage">Lỗi khi tính phí vận chuyển</span>
                                            <i class="fa fa-refresh"></i>
                                        </div>

                                        <div class="content-box hide"></div>

                                        <div class="alert alert--info">
                                            Vui lòng nhập thông tin giao hàng
                                        </div>
                                    </div>
                                </section>


                                <section class="section">
                                    <div class="section__header">
                                        <div class="layout-flex">
                                            <h2 class="section__title layout-flex__item layout-flex__item--stretch">
                                                <i
                                                    class="fa fa-credit-card fa-lg section__title--icon hide-on-desktop"></i>
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
                                                            type="radio" class="input-radio" value="bank_transfer"
                                                            required>
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
                                                            type="radio" class="input-radio" value="cod"
                                                            required checked>
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
                                                            type="radio" class="input-radio" value="vnpay" 
                                                            required>
                                                            
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
                                            <!-- Phương thức thanh toán: Momo -->
                                            <div class="content-box__row">
                                                <div class="radio-wrapper">
                                                    <div class="radio__input">
                                                        <input name="paymentMethod" id="paymentMethod-momo"
                                                            type="radio" class="input-radio" value="momo"
                                                            required>
                                                    </div>
                                                    <label for="paymentMethod-momo" class="radio__label">
                                                        <span class="radio__label__primary">Thanh toán qua Momo</span>
                                                        <span class="radio__label__accessory">
                                                            <span class="radio__label__icon">
                                                                <i class="payment-icon payment-icon--momo"></i>
                                                            </span>
                                                        </span>
                                                    </label>
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
                                    <div
                                        class="order-summary__section order-summary__section--product-list order-summary__section--is-scrollable order-summary--collapse-element">
                                        <table class="product-table" id="product-table"
                                            data-tg-refresh="refreshDiscount">
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
                                                                <img src="{{ $cart->options->image }}" alt=""
                                                                    class="product-thumbnail__image" />
                                                            </div>
                                                            <span
                                                                class="product-thumbnail__quantity">{{ $cart->qty }}</span>
                                                        </div>
                                                    </td>
                                                    <th class="product__description">
                                                        <span class="product__description__name">
                                                            {{ $cart->name }}
                                                        </span>

                                                        @if (isset($cart->variant) && $cart->variant)
                                                            <div class="product__description__variants">
                                                                @foreach ($cart->variant->attributeValues as $attributeValue)
                                                                    <span class="product__description__property">
                                                                        {{ $attributeValue->attribute->name }}:
                                                                        {{ $attributeValue->value }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </th>
                                                    <td class="product__quantity visually-hidden"><em>Số lượng:</em> 1
                                                    </td>
                                                    <td class="product__price">

                                                        <span>{{ number_format($cart->price * $cart->qty, 0, ',', '.') }}₫</span>

                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                                <!-- Modal Hiển thị Danh sách Voucher -->
                                <div class="order-summary__section order-summary__section--discount-code"
                                    id="discountCode">
                                    <h3 class="visually-hidden">Mã khuyến mại</h3>
                                    <div class="edit_checkout animate-floating-labels">
                                        <div class="fieldset">
                                            <div class="field">
                                                <label for="reductionCode">Nhập mã giảm giá</label>
                                                <div class="voucher-row">
                                                    <input name="coupon_code" id="reductionCode" type="text"
                                                        class="field__input" autocomplete="off">
                                                    <button class="btn-voucher" type="button" id="applyCoupon">Áp
                                                        dụng</button>
                                                    <button class="btn-voucher" type="button"
                                                        id="chooseVoucherBtn">Chọn Voucher</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Chỗ riêng để hiển thị thông tin coupon --}}

                                    <div id="appliedCouponWrapper"
                                        class="card border-0 shadow-sm mt-3 coupon-card animate__animated animate__fadeIn"
                                        style="border-left: 5px solid #28a745; background: linear-gradient(90deg, #ffffff, #ffffff);">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            @if (Session::has('coupon'))
                                                <div>
                                                    <h6 class="mb-1 text-success fw-bold">
                                                        <i class="fas fa-ticket-alt me-1"></i>
                                                        Mã giảm giá:
                                                        <span
                                                            class="text-dark">{{ Session::get('coupon.code') }}</span>
                                                    </h6>
                                                    <p class="mb-0 text-muted">
                                                        <i class="fas fa-tag me-1"></i> Giảm giá:
                                                        <span class="fw-bold text-danger">
                                                            -{{ number_format(Session::get('coupon.discount', 0), 0, ',', '.') }}₫
                                                        </span>
                                                    </p>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm rounded ms-2"
                                                    id="removeCoupon" title="Xóa mã">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <!-- Modal Hiển thị Danh sách Voucher -->
                                <div id="voucherModal" class="modal" style="display: none;">
                                    <div class="voucher-modal-content">
                                        <h5 class="voucher-title">Chọn Mã Giảm Giá</h5>

                                        <section class="voucher-list">
                                            @foreach ($coupons as $coupon)
                                                <label class="voucher-item">
                                                    <div class="voucher-left">
                                                        <img src="{{ asset($coupon->image) }}" alt="icon"
                                                            class="voucher-icon">
                                                    </div>
                                                    <div class="voucher-right">
                                                        <div class="voucher-text-top">
                                                            <strong>
                                                                @if ($coupon->type == 'percent')
                                                                    Giảm {{ $coupon->value }}%
                                                                @else
                                                                    Giảm
                                                                    {{ number_format($coupon->value, 0, ',', '.') }}₫
                                                                @endif
                                                            </strong>
                                                            <span>Đơn tối thiểu
                                                                {{ number_format($coupon->min_cart_value ?? 0, 0, ',', '.') }}₫</span>
                                                        </div>
                                                        <div class="voucher-meta">
                                                            <small>HSD:
                                                                {{ \Carbon\Carbon::parse($coupon->expiry_date)->format('d.m.Y') }}</small>
                                                            <a href="javascript:void(0)">Điều kiện</a>
                                                        </div>
                                                    </div>
                                                    <input type="radio" name="selected_coupon"
                                                        class="voucher-radio" value="{{ $coupon->code }}"
                                                        data-min-cart-value="{{ $coupon->min_cart_value ?? 0 }}"
                                                        data-expiry="{{ \Carbon\Carbon::parse($coupon->expiry_date)->toDateString() }}"
                                                        data-type="{{ $coupon->type }}"
                                                        data-value="{{ $coupon->value }}">
                                                </label>
                                            @endforeach
                                        </section>

                                        <div class="voucher-modal-footer">
                                            <button class="btn btn-secondary" id="closeVoucherModal">Trở lại</button>
                                            <button class="btn btn-danger" id="confirmVoucher">OK</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="couponMessage" class="alert d-none mt-3"></div>

                                <style>
                                    #removeCoupon {
                                        border-radius: 6px;
                                        /* bo góc nhẹ, không quá tròn */
                                        padding: 4px 8px;
                                        /* chỉnh khoảng cách icon */
                                        transition: all 0.3s ease;
                                    }

                                    #removeCoupon:hover {
                                        background-color: #dc3545;
                                        color: #fff;
                                    }

                                    /* Hiệu ứng mượt khi hover nút xóa */
                                    #removeCoupon {
                                        transition: all 0.3s ease;
                                    }

                                    #removeCoupon:hover {
                                        background-color: #dc3545;
                                        color: #fff;
                                    }

                                    /* Nếu dùng Animate.css thì thêm class fadeIn */
                                    .coupon-card {
                                        animation-duration: 0.6s;
                                    }

                                    .voucher-row {
                                        display: flex;
                                        gap: 10px;
                                        align-items: stretch;
                                        margin-top: 6px;
                                    }

                                    .field__input {
                                        flex: 1;
                                        padding: 10px 12px;
                                        border-radius: 6px;
                                        border: 1px solid #ccc;
                                        font-size: 15px;
                                        height: 42px;
                                    }

                                    .btn-voucher {
                                        background-color: #2d8dd6;
                                        color: #fff;
                                        border: none;
                                        padding: 0 16px;
                                        font-size: 15px;
                                        border-radius: 6px;
                                        white-space: nowrap;
                                        height: 42px;
                                        transition: background 0.3s ease;
                                        font-weight: 600;
                                    }

                                    .btn-voucher:hover {
                                        background-color: #1b6fb3;
                                    }

                                    .modal {
                                        position: fixed;
                                        z-index: 9999;
                                        left: 460px;
                                        top: 120px;
                                        width: 590px;
                                        height: 570px;
                                        overflow: hidden;
                                        background-color: #ffffff;
                                        animation: fadeIn 0.3s ease;
                                    }

                                    @keyframes fadeIn {
                                        from {
                                            opacity: 0;
                                            transform: translateY(-20px);
                                        }

                                        to {
                                            opacity: 1;
                                            transform: translateY(0);
                                        }
                                    }

                                    .voucher-modal-content {
                                        max-width: 650px;
                                        background: #ffffff;
                                        border-radius: 12px;
                                        margin: 5% auto;
                                        padding: 25px 20px;
                                        position: relative;
                                        animation: slideUp 0.4s ease;
                                    }

                                    @keyframes slideUp {
                                        from {
                                            opacity: 0;
                                            transform: translateY(50px);
                                        }

                                        to {
                                            opacity: 1;
                                            transform: translateY(0);
                                        }
                                    }

                                    .voucher-title {
                                        font-weight: bold;
                                        font-size: 22px;
                                        margin-bottom: 20px;
                                        color: #333;
                                    }

                                    .voucher-list {
                                        max-height: 400px;
                                        overflow-y: auto;
                                        border-top: 1px solid #ddd;
                                        border-bottom: 1px solid #ddd;
                                        margin-bottom: 20px;
                                        padding-right: 5px;
                                    }

                                    .voucher-item {
                                        display: flex;
                                        align-items: center;
                                        justify-content: space-between;
                                        padding: 15px 12px;
                                        border-bottom: 1px solid #eee;
                                        position: relative;
                                        background: #decfdb;
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                        border-radius: 8px;
                                    }

                                    .voucher-item:hover {
                                        background: #f6d076;
                                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
                                        transform: translateY(-1px);
                                    }

                                    .voucher-icon {
                                        width: 80px;
                                        height: 80px;
                                        object-fit: contain;
                                        border-radius: 8px;
                                        border: 1px solid #eee;
                                        background-color: #f9f9f9;
                                    }

                                    .voucher-left {
                                        margin-right: 15px;
                                    }

                                    .voucher-right {
                                        flex: 1;
                                    }

                                    .voucher-text-top {
                                        font-size: 15px;
                                        font-weight: 600;
                                        color: #d32f2f;
                                    }

                                    .voucher-text-top span {
                                        display: block;
                                        color: #666;
                                        font-size: 13px;
                                        margin-top: 5px;
                                    }

                                    .voucher-meta {
                                        font-size: 12px;
                                        color: #888;
                                        display: flex;
                                        justify-content: space-between;
                                        margin-top: 8px;
                                    }

                                    .voucher-radio {
                                        transform: scale(1.3);
                                        margin-left: 15px;
                                        accent-color: #ff5722;
                                    }

                                    .voucher-modal-footer {
                                        display: flex;
                                        justify-content: flex-end;
                                        gap: 10px;
                                    }

                                    .voucher-modal-footer .btn {
                                        padding: 8px 20px;
                                        font-size: 15px;
                                        border-radius: 8px;
                                        transition: background 0.3s ease;
                                    }

                                    .voucher-modal-footer .btn-secondary:hover {
                                        background: #c5c5c5;
                                    }

                                    .voucher-modal-footer .btn-danger {
                                        background: #ff5722;
                                        border: none;
                                    }

                                    .voucher-modal-footer .btn-danger:hover {
                                        background: #e64a19;
                                    }

                                    /* Mobile responsive (max-width <= 768px) */
                                    @media (max-width: 768px) {
                                        .modal {
                                            left: 0 !important;
                                            top: 0 !important;
                                            width: 100% !important;
                                            height: 100% !important;
                                            border-radius: 0;
                                        }

                                        .voucher-modal-content {
                                            width: 95%;
                                            margin: 20px auto;
                                            padding: 20px 15px;
                                        }

                                        .voucher-list {
                                            max-height: 300px;
                                            padding-right: 0;
                                        }

                                        .voucher-item {
                                            flex-direction: column;
                                            align-items: flex-start;
                                        }

                                        .voucher-meta {
                                            flex-direction: column;
                                            gap: 4px;
                                        }

                                        .voucher-radio {
                                            margin-left: 0;
                                            margin-top: 8px;
                                        }

                                        .voucher-row {
                                            flex-direction: column;
                                            align-items: stretch;
                                        }

                                        .btn-voucher {
                                            width: 100%;
                                            text-align: center;
                                        }

                                        .field__input {
                                            width: 100%;
                                        }

                                        .voucher-modal-footer {
                                            flex-direction: column;
                                            gap: 8px;
                                        }

                                        .voucher-modal-footer .btn {
                                            width: 100%;
                                        }
                                    }
                                </style>

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
                                            {{-- Tạm tính --}}
                                            <tr class="total-line total-line--subtotal">
                                                <th class="total-line__name">Tạm tính</th>
                                                <td class="total-line__price" id="checkout_subtotal_price">
                                                    {{ Cart::subtotal(0, 0, '') }}₫</td>
                                            </tr>

                                            {{-- Giảm giá --}}
                                            @if (Session::has('coupon'))
                                                <tr class="total-line total-line--discount" id="discountRow">
                                                    <th class="total-line__name">
                                                        Giảm giá ({{ Session::get('coupon.code') }})
                                                    </th>
                                                    <td class="total-line__price" id="checkout_discount_price">
                                                        -{{ number_format(Session::get('coupon.discount', 0), 0, ',', '.') }}₫
                                                    </td>
                                                </tr>
                                            @endif

                                            {{-- Phí vận chuyển --}}
                                            <tr class="total-line total-line--shipping-fee">
                                                <th class="total-line__name">Phí vận chuyển</th>
                                                <td class="total-line__price" id="checkout_shipping_fee">Đang tính...
                                                </td>
                                            </tr>
                                        </tbody>

                                        {{-- Tổng cộng --}}
                                        <tfoot class="total-line-table__footer">
                                            <tr class="total-line payment-due">
                                                <th class="total-line__name">
                                                    <span class="payment-due__label-total">Tổng cộng</span>
                                                </th>
                                                <td class="total-line__price">
                                                    <span class="payment-due__price" id="checkout_total_price">
                                                        {{ number_format(Cart::subtotal(0, 0, '') - Session::get('coupon.discount', 0), 0, ',', '.') }}₫
                                                    </span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    {{-- Input ẩn để lưu phí vận chuyển --}}
                                    <input type="hidden" name="shipping_fee" id="shipping_fee_hidden"
                                        value="0">

                                </div>
                                <div
                                    class="order-summary__nav field__input-btn-wrapper hide-on-mobile layout-flex--row-reverse">
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
                    <circle stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                        stroke-dasharray="85%" cx="50%" cy="50%" r="40%">
                        <animateTransform attributeName="transform" type="rotate" from="0 15 15" to="360 15 15"
                            dur="0.7s" repeatCount="indefinite" />
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
            const shippingMethodList = document.getElementById('shippingMethodList');

            let selectedDistrict = '';
            let selectedWard = '';

            // Load province
            fetch('/address/province')
                .then(res => res.json())
                .then(data => {
                    provinceSelect.innerHTML = '<option value="">-- Chọn tỉnh / thành phố --</option>';
                    data.forEach(p => {
                        provinceSelect.innerHTML +=
                            `<option value="${p.ProvinceID}">${p.ProvinceName}</option>`;
                    });
                });

            // Load district
            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;
                resetShippingInfo();
                districtSelect.innerHTML = '<option value="">-- Chọn quận / huyện --</option>';
                wardSelect.innerHTML = '<option value="">-- Chọn phường / xã --</option>';

                if (provinceId) {
                    fetch(`/address/district/${provinceId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(d => {
                                districtSelect.innerHTML +=
                                    `<option value="${d.DistrictID}">${d.DistrictName}</option>`;
                            });
                        });
                }
            });

            // Load ward
            districtSelect.addEventListener('change', function() {
                selectedDistrict = this.value;
                resetShippingInfo();
                wardSelect.innerHTML = '<option value="">-- Chọn phường / xã --</option>';

                if (selectedDistrict) {
                    fetch(`/address/ward/${selectedDistrict}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(w => {
                                wardSelect.innerHTML +=
                                    `<option value="${w.WardCode}">${w.WardName}</option>`;
                            });
                        });
                }
            });

            // Trigger shipping fee calculation
            wardSelect.addEventListener('change', function() {
                selectedWard = this.value;
                if (selectedDistrict && selectedWard) {
                    calculateShippingFee(selectedDistrict, selectedWard);
                } else {
                    resetShippingInfo();
                }
            });

            function calculateShippingFee(districtId, wardCode) {
                showLoader();

                fetch('/shipping/calculate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            district_id: districtId,
                            ward_code: wardCode,
                            weight: getCartWeight()
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        hideLoader();
                        if (data.success) {
                            updateShippingMethodUI(data.fee, data.formatted_fee);
                            updateOrderTotalDynamic(data.fee, null);
                        } else {
                            showShippingError(data.message);
                        }
                    })
                    .catch(() => {
                        hideLoader();
                        showShippingError('Lỗi kết nối. Vui lòng thử lại sau.');
                    });
            }

            function getCartWeight() {
                return 500; // Sửa lại nếu giỏ hàng có trọng lượng động
            }

            function showLoader() {
                shippingMethodList.querySelector('.alert--loader').classList.remove('hide');
                shippingMethodList.querySelectorAll('.alert:not(.alert--loader)').forEach(el => el.classList.add(
                    'hide'));
            }

            function hideLoader() {
                shippingMethodList.querySelector('.alert--loader').classList.add('hide');
            }

            function showShippingError(msg) {
                const el = shippingMethodList.querySelector('.alert--danger:not(.alert-retry)');
                el.textContent = msg;
                el.classList.remove('hide');
            }

            function resetShippingInfo() {
                const contentBox = shippingMethodList.querySelector('.content-box');
                contentBox.innerHTML = '';
                contentBox.classList.add('hide');
                shippingMethodList.querySelectorAll('.alert').forEach(el => el.classList.add('hide'));
                shippingMethodList.querySelector('.alert--info').classList.remove('hide');
                updateOrderTotalDynamic(0, null);
            }

            function updateShippingMethodUI(fee, formattedFee) {
                const contentBox = shippingMethodList.querySelector('.content-box');
                contentBox.classList.remove('hide');
                contentBox.innerHTML = `
                <div class="content-box__row">
                    <div class="radio-wrapper">
                        <div class="radio__input">
                            <input type="radio" class="input-radio" name="shipping_method" id="shipping_method_ghn" value="ghn" checked>
                        </div>
                        <label for="shipping_method_ghn" class="radio__label">
                            <span class="radio__label__primary">Giao hàng nhanh</span>
                            <span class="radio__label__accessory">
                                <span class="content-box__emphasis">${formattedFee}</span>
                            </span>
                        </label>
                    </div>
                </div>`;

                let feeInput = document.getElementById('shipping_fee_hidden');
                if (!feeInput) {
                    feeInput = document.createElement('input');
                    feeInput.type = 'hidden';
                    feeInput.name = 'shipping_fee';
                    feeInput.id = 'shipping_fee_hidden';
                    document.querySelector('form').appendChild(feeInput);
                }
                feeInput.value = fee;
                document.getElementById('checkout_shipping_fee').textContent = formattedFee;
            }

            // ======================= MÃ GIẢM GIÁ ========================== //
            document.getElementById('applyCoupon').addEventListener('click', function() {
                const code = document.getElementById('reductionCode').value;
                if (!code) return showMessage('Vui lòng nhập mã giảm giá!', 'danger');

                fetch('/apply-coupon', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            coupon_code: code
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showMessage('Áp dụng mã giảm giá thành công!', 'success');
                            updateCouponDisplay(data.code, data.discount);
                            updateOrderTotalDynamic(null, data.discount);
                        } else {
                            showMessage(data.message || 'Mã giảm giá không hợp lệ!', 'danger');
                        }
                    })
                    .catch(() => showMessage('Đã xảy ra lỗi khi áp dụng mã!', 'danger'));
            });

            document.addEventListener('click', function(e) {
                // Support clicks on the button or its child elements (like the <i> icon)
                const target = e.target;
                const removeBtn = target && (target.id === 'removeCoupon' ? target : (target.closest ?
                    target.closest('#removeCoupon') : null));
                if (removeBtn) {
                    fetch('/remove-coupon', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                showMessage(data.message, 'success');
                                removeCouponDisplay();
                                updateOrderTotalDynamic(null, 0);
                            } else {
                                showMessage(data.message || 'Không thể xóa mã!', 'danger');
                            }
                        })
                        .catch(() => showMessage('Đã xảy ra lỗi khi xóa mã giảm giá!', 'danger'));
                }
            });

            function updateCouponDisplay(code, discount) {
                const wrapper = document.getElementById('appliedCouponWrapper');
                wrapper.innerHTML = `
        <div class="card border-0 shadow-sm mt-3" style="border-left: 5px solid #28a745; border-radius: 12px;">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-1 text-success fw-bold">
                <i class="fas fa-ticket-alt"></i> Mã giảm giá: <span class="text-dark">${code}</span>
            </h6>
            <p class="mb-0 text-muted">
                <i class="fas fa-tag"></i> Giảm giá:
                <span class="fw-bold text-danger">-${new Intl.NumberFormat('vi-VN').format(discount)}₫</span>
            </p>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" id="removeCoupon" title="Xóa mã">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
    `;
                addDiscountRow(code, discount);
            }

            function addDiscountRow(code, discount) {
                const tbody = document.querySelector('.total-line-table__tbody');
                const existingRow = tbody.querySelector('.total-line--discount');
                if (existingRow) existingRow.remove();

                const row = document.createElement('tr');
                row.className = 'total-line total-line--discount';
                row.innerHTML = `
                <th class="total-line__name">Giảm giá (${code})</th>
                <td class="total-line__price" id="checkout_discount_price">-${new Intl.NumberFormat('vi-VN').format(discount)}₫</td>
            `;
                tbody.querySelector('.total-line--subtotal').after(row);
            }

            function removeCouponDisplay() {
                const wrapper = document.getElementById('appliedCouponWrapper');
                wrapper.innerHTML = ''; // chỉ xoá phần alert thôi
                const row = document.querySelector('.total-line--discount');
                if (row) row.remove();
            }

            function updateOrderTotalDynamic(shippingFee = null, discount = null) {
                const subtotalText = document.getElementById('checkout_subtotal_price').textContent.replace(
                    /[^\d]/g, '');
                const subtotal = parseInt(subtotalText, 10) || 0;

                let discountVal = discount !== null ? discount : 0;
                const discountElement = document.getElementById('checkout_discount_price');
                if (discountElement && discount === null) {
                    discountVal = parseInt(discountElement.textContent.replace(/[^\d]/g, ''), 10) || 0;
                }

                let shippingVal = shippingFee !== null ? shippingFee : 0;
                const shippingElement = document.getElementById('shipping_fee_hidden');
                if (shippingElement && shippingFee === null) {
                    shippingVal = parseInt(shippingElement.value) || 0;
                }

                const total = subtotal - discountVal + shippingVal;
                const totalElement = document.getElementById('checkout_total_price');
                if (totalElement) {
                    totalElement.textContent = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(total);
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const savedAddressSelect = document.getElementById('selectSavedAddress');
            const provinceSelect = document.getElementById('billingProvince');
            const districtSelect = document.getElementById('billingDistrict');
            const wardSelect = document.getElementById('billingWard');

            if (!savedAddressSelect) return;

            savedAddressSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                if (!selected || !selected.value) return;

                // Điền các input cơ bản
                document.getElementById('billingName').value = selected.dataset.name || '';
                document.getElementById('billingPhone').value = selected.dataset.phone || '';
                document.getElementById('billingAddress').value = selected.dataset.address || '';

                const provinceText = selected.dataset.province.trim();
                const districtText = selected.dataset.district.trim();
                const wardText = selected.dataset.ward.trim();

                // Chọn tỉnh
                const provinceOption = Array.from(provinceSelect.options).find(opt => opt.text.trim()
                    .toLowerCase() === provinceText.toLowerCase());
                if (provinceOption) {
                    provinceOption.selected = true;
                    provinceSelect.dispatchEvent(new Event('change'));

                    // Đợi quận load xong rồi chọn quận
                    const waitForDistrictLoad = () => {
                        const districtOption = Array.from(districtSelect.options).find(opt => opt.text
                            .trim().toLowerCase() === districtText.toLowerCase());
                        if (districtOption) {
                            districtOption.selected = true;
                            districtSelect.dispatchEvent(new Event('change'));

                            // Đợi phường load xong rồi chọn phường
                            const waitForWardLoad = () => {
                                const wardOption = Array.from(wardSelect.options).find(opt => opt
                                    .text.trim().toLowerCase() === wardText.toLowerCase());
                                if (wardOption) {
                                    wardOption.selected = true;
                                } else {
                                    // Thử lại nếu phường chưa load kịp
                                    setTimeout(waitForWardLoad, 300);
                                }
                            };
                            setTimeout(waitForWardLoad, 500); // delay chờ ward load
                        } else {
                            // Thử lại nếu quận chưa load kịp
                            setTimeout(waitForDistrictLoad, 300);
                        }
                    };
                    setTimeout(waitForDistrictLoad, 500); // delay chờ district load
                }
            });
        });
    </script>
    <script>
        // Mở modal
        document.getElementById('chooseVoucherBtn').addEventListener('click', function() {
            document.getElementById('voucherModal').style.display = 'block';
        });

        // Đóng modal
        document.getElementById('closeVoucherModal').addEventListener('click', function() {
            document.getElementById('voucherModal').style.display = 'none';
        });

        // Xác nhận chọn mã
        document.getElementById('confirmVoucher').addEventListener('click', function() {
            const selected = document.querySelector('input[name="selected_coupon"]:checked');
            if (selected) {
                document.getElementById('reductionCode').value = selected.value;
                document.getElementById('applyCoupon').click(); // Gọi áp dụng mã
                document.getElementById('voucherModal').style.display = 'none';
            } else {
                showMessage('Vui lòng chọn 1 mã giảm giá!', 'danger'); // ✅ Thay vì alert()
            }
        });
        // Highlight mã đang chọn
        document.querySelectorAll('.voucher-item input[type="radio"]').forEach((radio) => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.voucher-item').forEach(item => {
                    item.classList.remove('active');
                });
                this.closest('.voucher-item').classList.add('active');
            });
        });

        function showMessage(message, type = 'success') {
            const msgDiv = document.getElementById('couponMessage');
            msgDiv.classList.remove('d-none', 'alert-success', 'alert-danger');
            msgDiv.classList.add('alert', `alert-${type}`);
            msgDiv.innerHTML = `<strong>${message}</strong>`;

            setTimeout(() => {
                msgDiv.classList.add('d-none');
            }, 4000);
        }
    </script>

    <script>
        // Auto-apply best eligible coupon on page load
        (function() {
            function parseDate(d) {
                return new Date(d + 'T23:59:59');
            }

            function getNumericSubtotal() {
                const el = document.getElementById('checkout_subtotal_price');
                if (!el) return 0;
                const digits = el.textContent.replace(/[^\d]/g, '');
                return parseInt(digits, 10) || 0;
            }

            function computeCouponValue(type, value, subtotal) {
                if (type === 'percent') {
                    return Math.floor(subtotal * (parseFloat(value) / 100));
                }
                return parseInt(value, 10) || 0;
            }

            function findBestCoupon() {
                const radios = Array.from(document.querySelectorAll('.voucher-radio'));
                if (!radios.length) return null;
                const subtotal = getNumericSubtotal();
                const now = new Date();
                let best = null;

                radios.forEach(r => {
                    const minCart = parseInt(r.dataset.minCartValue || r.getAttribute('data-min-cart-value') ||
                        0, 10);
                    const expiry = r.dataset.expiry || r.getAttribute('data-expiry');
                    const type = r.dataset.type || r.getAttribute('data-type');
                    const value = r.dataset.value || r.getAttribute('data-value');

                    if (expiry && parseDate(expiry) < now) return; // expired
                    if (subtotal < (minCart || 0)) return; // not meet min

                    const saving = computeCouponValue(type, value, subtotal);

                    if (!best || saving > best.saving) {
                        best = {
                            radio: r,
                            saving
                        };
                    }
                });

                return best;
            }

            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const best = findBestCoupon();
                    if (best && best.radio) {
                        // select radio visually
                        best.radio.checked = true;
                        const item = best.radio.closest('.voucher-item');
                        if (item) item.classList.add('active');

                        // Fill reduction input and trigger apply
                        const code = best.radio.value;
                        if (code) {
                            const reductionInput = document.getElementById('reductionCode');
                            if (reductionInput) reductionInput.value = code;
                            // call apply coupon flow
                            document.getElementById('applyCoupon').click();
                        }
                    }
                } catch (e) {
                    // fail silently
                    console.error('Auto-apply coupon error', e);
                }
            });
        })();
    </script>

    <script>
        // Polling tồn kho ở trang checkout: gọi /cart/validate mỗi 10s, khóa nút đặt hàng khi có lỗi
        (function() {
            const FORM_SELECTOR = '#checkoutForm';
            const SUBMIT_SELECTOR = '#checkoutForm button[type="submit"]';
            const WARNING_ID = 'checkout-stock-warning';

            function ensureWarningContainer() {
                let el = document.getElementById(WARNING_ID);
                if (!el) {
                    el = document.createElement('div');
                    el.id = WARNING_ID;
                    el.className = 'alert alert-danger';
                    el.style.display = 'none';
                    const sidebar = document.querySelector('.sidebar__content') || document.querySelector(
                        '.main__content') || document.body;
                    sidebar.prepend(el);
                }
                return el;
            }

            function setSubmitDisabled(disabled, message) {
                const btn = document.querySelector(SUBMIT_SELECTOR);
                const form = document.querySelector(FORM_SELECTOR);
                const warn = ensureWarningContainer();
                if (!btn || !form) return;
                if (disabled) {
                    btn.classList.add('disabled');
                    btn.setAttribute('aria-disabled', 'true');
                    btn.addEventListener('click', blockClick, {
                        passive: false
                    });
                    warn.textContent = message ||
                        'Một số sản phẩm đã hết hoặc không đủ hàng. Vui lòng cập nhật giỏ hàng trước khi đặt.';
                    warn.style.display = '';
                } else {
                    btn.classList.remove('disabled');
                    btn.removeAttribute('aria-disabled');
                    btn.removeEventListener('click', blockClick);
                    const warn = document.getElementById(WARNING_ID);
                    if (warn) warn.style.display = 'none';
                }
            }

            function blockClick(e) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            function applyValidation(payload) {
                if (!payload || !Array.isArray(payload.items)) return;
                const hasIssue = payload.items.some(it => !it.ok);
                setSubmitDisabled(hasIssue, 'Một số sản phẩm trong đơn không đủ tồn. Vui lòng kiểm tra lại.');
            }

            async function pollValidate() {
                try {
                    const res = await fetch('/cart/validate', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) return;
                    const json = await res.json();
                    applyValidation(json);
                } catch (err) {
                    // im lặng, không hiển thị lỗi mạng
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                pollValidate();
                setInterval(pollValidate, 10000);
            });
        })();
    </script>

</body>

</html>
