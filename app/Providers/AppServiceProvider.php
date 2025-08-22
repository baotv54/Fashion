<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Contact;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View composer cho navbar notifications
        View::composer('layouts.partials.navbar', function ($view) {
            // Lọc orders chỉ lấy status = 'ordered' (đơn hàng mới)
            $orders = Order::where('status', 'ordered')->get();

            // Lọc contacts chỉ lấy những trạng thái cần thông báo (chưa hoàn thành)
            $pendingContacts = Contact::where('status', 'pending')->get();
            $processingContacts = Contact::where('status', 'processing')->get();

            $view->with([
                'orders' => $orders,
                'pendingContacts' => $pendingContacts,
                'processingContacts' => $processingContacts
            ]);
        });
    }
}
