<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FaceBookController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FavoriteController;

use Illuminate\Support\Facades\Route;


Route::get('/', [ProductController::class, 'homepage'])->name('Frontend.index');

Route::get('/Login', function () {
    return view('Frontend.pages.account.login');
});
Route::get('/Register', function () {
    return view('Frontend.pages.account.register');
});

Route::get('/db', function () {
    return view('layouts.Dashboard');
});

Route::get('/faq', function () {
    return view('Frontend.pages.pages.faq');
});

Route::get('/lien-he', function () {
    return view('Frontend.pages.pages.lien-he');
});



Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/products', [ProductController::class, 'allProducts'])->name('products.all');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
Route::get('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Thêm sản phẩm vào favorites
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');

// Xoá sản phẩm khỏi favorites
Route::delete('/favorites/{product_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

// Hiển thị danh sách favorites (nếu có)
// Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

Route::get('/address/province', [AddressController::class, 'getProvince']);
Route::get('/address/district/{provinceId}', [AddressController::class, 'getDistrict']);
Route::get('/address/ward/{districtId}', [AddressController::class, 'getWard']);

Route::get('/auth/google', [GoogleController::class, 'googlepage'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'googlecallback'])->name('google.callback');

Route::get('/auth/facebook', [FaceBookController::class, 'FaceBookPage'])->name('facebook.login');
Route::get('/auth/facebook/callback', [FaceBookController::class, 'FaceBookCallback'])->name('facebook.callback');


Route::get('/checkout/success/{order_id}', [OrderController::class, 'orderSuccess'])->name('checkout.success');

Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/remove-coupon', [CouponController::class, 'removeCoupon'])->name('remove.coupon');

Route::get('/address/province', [AddressController::class, 'getProvince'])->name('address.province');
Route::get('/address/district/{provinceId}', [AddressController::class, 'getDistrict'])->name('address.district');
Route::get('/address/ward/{districtId}', [AddressController::class, 'getWard'])->name('address.ward');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/checkout/vnpay', [CheckoutController::class, 'vnpay_payment'])->name('checkout.vnpay');
Route::get('/checkout/vnpay-return', [CheckoutController::class, 'vnpay_return'])->name('checkout.vnpay_return');


Route::get('/checkout/momo-return', [CheckoutController::class, 'momo_return'])->name('checkout.momo-return');
Route::post('/checkout/momo-ipn', [CheckoutController::class, 'momo_ipn'])->name('checkout.momo-ipn');


Route::post('/chat', [ChatBotController::class, 'sendMessage']);
Route::get('/chat/history', [ChatBotController::class, 'getHistory']);
Route::post('/chat/add-to-cart', [ChatBotController::class, 'addToCart'])->name('chat.addToCart');

Route::post('/get-variant-id', [ProductController::class, 'getVariant'])->name('product.getVariant');

Route::post('/calculate-shipping', [ShippingController::class, 'calculate']);


Route::post('/shipping/calculate', [ShippingController::class, 'calculate'])->name('shipping.calculate');

Route::get('/gioi-thieu', [ProductController::class, 'aboutPage'])->name('about');

Route::get('/posts', [PostController::class, 'postpage'])->name('posts.postpage');
Route::get('/post/{id}', [PostController::class, 'show'])->name('posts.show');

Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Account routes
    Route::get('/account', function () {
        return view('Frontend.pages.account.index');
    });
    Route::get('/account/changepassword', function () {
        return view('Frontend.pages.account.changepassword');
    });

    Route::get('/account/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::post('/account/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/account/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::post('/account/addresses/{id}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');
    Route::delete('/account/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    // Order routes
    Route::get('/order-history', [OrderController::class, 'userOrderHistory'])->name('user.orders.history');
    Route::get('/order-history/{id}', [OrderController::class, 'userOrderDetails'])->name('user.orders.details');
    Route::post('/order/{id}/update-address', [OrderController::class, 'updateAddress'])->name('user.orders.updateAddress');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/orders/{id}/reorder', [OrderController::class, 'reorder'])->name('orders.reorder');

    // Routes cho đánh giá sản phẩm
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


Route::middleware(['auth'])->group(function () {
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
            Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
        });
        // Routes quản lý sản phẩm biến thể
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

        // Routes quản lý danh mục sản phẩm
        Route::prefix('post-categories')->group(function () {
            Route::get('/', [PostCategoryController::class, 'index'])->name('post-categories.index');
            Route::get('/create', [PostCategoryController::class, 'create'])->name('post-categories.create');
            Route::post('/', [PostCategoryController::class, 'store'])->name('post-categories.store');
            Route::get('/{id}/edit', [PostCategoryController::class, 'edit'])->name('post-categories.edit');
            Route::put('/{id}', [PostCategoryController::class, 'update'])->name('post-categories.update');
            Route::delete('/{id}', [PostCategoryController::class, 'destroy'])->name('post-categories.destroy');
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
        // Routes quản mã giảm giá
        Route::prefix('coupons')->group(function () {
            Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
            Route::get('/create', [CouponController::class, 'create'])->name('coupons.create');
            Route::post('/', [CouponController::class, 'store'])->name('coupons.store');
            Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
            Route::put('/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
            Route::delete('/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
        });
        // Routes quản lý đơn hàng
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('orders.index');
            Route::get('/{id}', [OrderController::class, 'show'])->name('orders.details');
            Route::post('/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        });

        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index'])->name('posts.index');
            Route::get('/create', [PostController::class, 'create'])->name('posts.create');
            Route::post('/', [PostController::class, 'store'])->name('posts.store');
            Route::get('/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::put('/{id}', [PostController::class, 'update'])->name('posts.update');
            Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
        });

        Route::get('/admin/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics');
    });
});

// Route::get('/posts', function () {
//     return view('Frontend.pages.blogs.posts');
// });

// Route::get('/post_detail', function () {
//     return view('Frontend.pages.post_detail');
// });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/cart', function () {
//     return view('Frontend.pages.cart');
// });
// Route::get('/view', function () {
//     return view('Frontend.pages.converse-all');
// });

// Route::get('/', function () {
//     return view('Frontend.index');
// });
// Route::get('/home', function () {
//     return view('Frontend.index');
// });

// Route::get('/checkout/success', function () {
//     return view('Frontend.pages.checkout_success');
// })->name('checkout.success');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/order-history', [OrderController::class, 'userOrderHistory'])->name('user.orders.history');
//     Route::get('/order-history/{id}', [OrderController::class, 'userOrderDetails'])->name('user.orders.details');
//     Route::post('/order/{id}/update-address', [OrderController::class, 'updateAddress'])->name('user.orders.updateAddress');
// });

// Route::get('/address', function () {
//     return view('Frontend.pages.account.address');
// });
// Route::get('/order-detail', function () {
//     return view('Frontend.pages.account.order-detail');
// });
require __DIR__ . '/auth.php';
