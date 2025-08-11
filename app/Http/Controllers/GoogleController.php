<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function googlepage()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googlecallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // 1. Tìm user theo google_id
            $user = User::where('google_id', $googleUser->id)->first();

            // 2. Nếu chưa có, thử tìm theo email
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();

                // Nếu tìm thấy qua email, cập nhật google_id
                if ($user) {
                    $user->update([
                        'google_id' => $googleUser->id
                    ]);
                }
            }

            // 3. Nếu vẫn chưa có => tạo mới
            if (!$user) {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => bcrypt(Str::random(16)) // tạo mật khẩu ngẫu nhiên
                ]);
            }

            // 4. Đăng nhập
            Auth::login($user);

            return redirect()->intended('/');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
