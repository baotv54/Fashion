<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $carts = Cart::content();

            // Luôn khởi tạo là collection rỗng
            $favorites = collect([]);

            // Nếu có đăng nhập
            if (Auth::check()) {
                $favorites = Favorite::with('product')
                    ->where('user_id', Auth::id())
                    ->get();
            }

            logger('User ID: ' . (Auth::check() ? Auth::id() : 'guest'));
            logger('Favorites count: ' . $favorites->count());

            $view->with([
                'carts' => $carts,
                'favorites' => $favorites,
            ]);
        });
    }

    public function register()
    {
        //
    }
}
