<?php

namespace App\Listeners;

use App\Mail\FailedLoginMail;
use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class FailedLoginListener
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        Log::info('FailedLoginListener triggered', [
            'event' => 'Failed',
            'user' => $event->user ? $event->user->email : 'null',
            'credentials' => $event->credentials
        ]);

        $user = $event->user;
        $credentials = $event->credentials;
        
        if (!$user) {
            // Nếu không tìm thấy user, không gửi email
            Log::warning('Failed login attempt for non-existent user', [
                'email' => $credentials['email'] ?? 'unknown',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            return;
        }

        // Tạo throttle key để đếm số lần đăng nhập sai
        $throttleKey = 'failed_login_' . $user->id . '_' . request()->ip();
        
        // Tăng số lần đăng nhập sai
        RateLimiter::hit($throttleKey, 300); // 5 phút
        
        // Lấy số lần đăng nhập sai hiện tại
        $attempts = RateLimiter::attempts($throttleKey);
        
        Log::info('Failed login attempt detected', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'attempts' => $attempts
        ]);

        // Gửi email cảnh báo khi có từ 3 lần đăng nhập sai trở lên
        if ($attempts >= 3) {
            try {
                Mail::to($user->email)->send(new FailedLoginMail(
                    $user,
                    $attempts,
                    request()->ip(),
                    request()->userAgent()
                ));
                
                Log::info('Failed login notification email sent', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'attempts' => $attempts
                ]);
                
            } catch (\Exception $e) {
                Log::error('Failed to send failed login notification email', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
} 