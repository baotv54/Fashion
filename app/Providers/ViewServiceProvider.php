<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Logo;
use App\Models\Category;
use App\Models\SocialLink; //

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
                'logos' => Logo::all(),
                'socialLinks' => SocialLink::all(), //
            ]);
        });

        View::composer('*', function ($view) {
            $carts = Cart::content();
            $favorites = collect([]);
            if (Auth::check()) {
                $favorites = Favorite::with('product')
                    ->where('user_id', Auth::id())
                    ->get();
            }

            // Thêm menu danh mục
            $headerCategories = Category::whereNull('parent_id')
                ->with('children') // load đệ quy tất cả cấp con
                ->get();

            $view->with([
                'carts' => $carts,
                'favorites' => $favorites,
                'logos' => Logo::all(),
                'headerCategories' => $headerCategories, // truyền ra view
            ]);
        });
    }

    public function register()
    {
        //
    }
}
