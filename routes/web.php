<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\FaceBookController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/home', function () {
//     return view('Frontend.index');
// });

Route::get('/home', [ProductController::class, 'homepage'])->name('Frontend.index');

// Route::get('/cart', function () {
//     return view('Frontend.pages.cart');
// });
Route::get('/view', function () {
    return view('Frontend.pages.converse-all');
});
Route::get('/testlogin', function () {
    return view('Frontend.pages.account.login');
});
Route::get('/product-detail', function () {
    return view('Frontend.pages.product_detail');
});
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
Route::get('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/auth/google', [GoogleController::class, 'googlepage'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'googlecallback'])->name('google.callback');

Route::get('/auth/facebook', [FaceBookController::class, 'FaceBookPage'])->name('facebook.login');
Route::get('/auth/facebook/callback', [FaceBookController::class, 'FaceBookCallback'])->name('facebook.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'is_admin'])->group(function () {
    //group routes
    Route::prefix('admin')->group(function () {

        // Routes quản lý sản phẩm
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('products.index');
            Route::get('/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('/', [ProductController::class, 'store'])->name('products.store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
            Route::delete('/delete-image/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
            Route::get('/admin/products/{productId}/set-primary-image/{imageId}', [ProductController::class, 'setPrimaryImage'])->name('products.setPrimaryImage');
        });

        Route::prefix('products/{productId}/variants')->group(function () {
            Route::get('/', [ProductVariantController::class, 'index'])->name('product_variants.index');
            Route::get('/create', [ProductVariantController::class, 'create'])->name('product_variants.create');
            Route::post('/store', [ProductVariantController::class, 'store'])->name('product_variants.store');
            Route::get('{variantId}/edit', [ProductVariantController::class, 'edit'])->name('product_variants.edit');
            Route::put('{variantId}', [ProductVariantController::class, 'update'])->name('product_variants.update');
            Route::delete('{variantId}', [ProductVariantController::class, 'destroy'])->name('product_variants.destroy');
        });

        // Routes cho Attribute
        Route::prefix('attributes')->group(function () {
            Route::get('/', [AttributeController::class, 'index'])->name('attributes.index');
            Route::get('/create', [AttributeController::class, 'create'])->name('attributes.create');
            Route::post('/', [AttributeController::class, 'store'])->name('attributes.store');
            Route::get('/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
            Route::put('/{id}', [AttributeController::class, 'update'])->name('attributes.update');
            Route::delete('/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');
        });

        // Routes cho Attribute Value
        Route::prefix('attributes/{attributeId}/attribute_values')->group(function () {
            Route::get('/', [AttributeValueController::class, 'index'])->name('attribute_values.index');
            Route::get('/create', [AttributeValueController::class, 'create'])->name('attribute_values.create');
            Route::post('/', [AttributeValueController::class, 'store'])->name('attribute_values.store');
            Route::get('/{id}/edit', [AttributeValueController::class, 'edit'])->name('attribute_values.edit');
            Route::put('/{id}', [AttributeValueController::class, 'update'])->name('attribute_values.update');
            Route::delete('/{id}', [AttributeValueController::class, 'destroy'])->name('attribute_values.destroy');
        });
        // Routes quản lý danh mục sản phẩm
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
            Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        });

        // Routes quản lý thương hiệu
        Route::prefix('brands')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('brands.index');
            Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
            Route::post('/', [BrandController::class, 'store'])->name('brands.store');
            Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
            Route::put('/{id}', [BrandController::class, 'update'])->name('brands.update');
            Route::delete('/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
        });
        // Routes cho màu sắc (Colors)
        Route::prefix('colors')->name('colors.')->group(function () {
            Route::get('/', [ColorController::class, 'index'])->name('index');
            Route::get('/create', [ColorController::class, 'create'])->name('create');
            Route::post('/store', [ColorController::class, 'store'])->name('store');
            Route::get('/{color}/edit', [ColorController::class, 'edit'])->name('edit');
            Route::put('/{color}', [ColorController::class, 'update'])->name('update');
            Route::delete('/{color}', [ColorController::class, 'destroy'])->name('destroy');
        });

        // Routes cho kích thước (Sizes)
        Route::prefix('sizes')->name('sizes.')->group(function () {
            Route::get('/', [SizeController::class, 'index'])->name('index');
            Route::get('/create', [SizeController::class, 'create'])->name('create');
            Route::post('/store', [SizeController::class, 'store'])->name('store');
            Route::get('/{size}/edit', [SizeController::class, 'edit'])->name('edit');
            Route::put('/{size}', [SizeController::class, 'update'])->name('update');
            Route::delete('/{size}', [SizeController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('coupons')->group(function () {
            Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
            Route::get('/create', [CouponController::class, 'create'])->name('coupons.create');
            Route::post('/', [CouponController::class, 'store'])->name('coupons.store');
            Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
            Route::put('/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
            Route::delete('/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
        });
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('orders.details');
            Route::post('/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        });
    });
});

Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/remove-coupon', [CouponController::class, 'removeCoupon'])->name('remove.coupon');

Route::get('/address/province', [AddressController::class, 'getProvince'])->name('address.province');
Route::get('/address/district/{provinceId}', [AddressController::class, 'getDistrict'])->name('address.district');
Route::get('/address/ward/{districtId}', [AddressController::class, 'getWard'])->name('address.ward');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/checkout/vnpay', [CheckoutController::class, 'vnpay_payment'])->name('checkout.vnpay');
Route::get('/checkout/vnpay-return', [CheckoutController::class, 'vnpay_return'])->name('checkout.vnpay_return');
Route::get('/checkout/success/{order_id}', [OrderController::class, 'orderSuccess'])->name('checkout.success');
// Route::get('/checkout/success', function () {
//     return view('Frontend.pages.checkout_success');
// })->name('checkout.success');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/order-history', [OrderController::class, 'userOrderHistory'])->name('user.orders.history');
//     Route::get('/order-history/{id}', [OrderController::class, 'userOrderDetails'])->name('user.orders.details');
//     Route::post('/order/{id}/update-address', [OrderController::class, 'updateAddress'])->name('user.orders.updateAddress');
// });
Route::get('/address/province', [AddressController::class, 'getProvince']);
Route::get('/address/district/{provinceId}', [AddressController::class, 'getDistrict']);
Route::get('/address/ward/{districtId}', [AddressController::class, 'getWard']);
Route::get('/acc', function () {
    return view('Frontend.pages.account.index');
});
// Route::get('/address', function () {
//     return view('Frontend.pages.account.address');
// });
// Route::get('/order-detail', function () {
//     return view('Frontend.pages.account.order-detail');
// });

Route::middleware('auth')->group(function () {
    Route::get('/account/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/account/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/account/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update'); // Thêm route cập nhật
    Route::post('/account/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
    Route::delete('/account/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::get('/order-history', [OrderController::class, 'userOrderHistory'])->name('user.orders.history');
    Route::get('/order-history/{id}', [OrderController::class, 'userOrderDetails'])->name('user.orders.details');
    Route::post('/order/{id}/update-address', [OrderController::class, 'updateAddress'])->name('user.orders.updateAddress');
});

require __DIR__ . '/auth.php';
