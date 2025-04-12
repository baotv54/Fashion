<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Gloudemans\Shoppingcart\Facades\Cart;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Inject biến $carts vào tất cả view
        View::composer('*', function ($view) {
            $carts = Cart::content(); // Lấy giỏ hàng từ package
            $view->with('carts', $carts);
        });
    }

    public function register()
    {
        //
    }
}
