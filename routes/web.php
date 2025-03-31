<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\FaceBookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
            Route::get('/', [ProductController::class, 'index'])->name('products.index'); // Hiển thị danh sách sản phẩm
            Route::get('/create', [ProductController::class, 'create'])->name('products.create'); // Form thêm sản phẩm
            Route::post('/', [ProductController::class, 'store'])->name('products.store'); // Xử lý thêm sản phẩm
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // Form chỉnh sửa
            Route::put('/{id}', [ProductController::class, 'update'])->name('products.update'); // Cập nhật sản phẩm
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // Xóa sản phẩm
            Route::delete('/delete-image/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage'); // Xóa ảnh sản phẩm
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
            Route::get('/', [ColorController::class, 'index'])->name('index'); // Danh sách màu sắc
            Route::get('/create', [ColorController::class, 'create'])->name('create'); // Form thêm mới
            Route::post('/store', [ColorController::class, 'store'])->name('store'); // Xử lý thêm mới
            Route::get('/{color}/edit', [ColorController::class, 'edit'])->name('edit'); // Form chỉnh sửa
            Route::put('/{color}', [ColorController::class, 'update'])->name('update'); // Xử lý cập nhật
            Route::delete('/{color}', [ColorController::class, 'destroy'])->name('destroy'); // Xóa màu
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
    });
});

require __DIR__ . '/auth.php';
