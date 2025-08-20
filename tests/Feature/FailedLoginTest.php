<?php

namespace Tests\Feature;

use App\Mail\FailedLoginMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FailedLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_failed_login_triggers_event()
    {
        // Tạo user test
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Mock Mail facade
        Mail::fake();

        // Thử đăng nhập sai 3 lần
        for ($i = 0; $i < 3; $i++) {
            $response = $this->from('/login')->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
                '_token' => csrf_token()
            ]);

            $response->assertSessionHasErrors('email');
        }

        // Kiểm tra xem email có được gửi không
        Mail::assertSent(FailedLoginMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_failed_login_for_nonexistent_user()
    {
        // Mock Mail facade
        Mail::fake();

        // Thử đăng nhập với email không tồn tại
        $response = $this->from('/login')->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
            '_token' => csrf_token()
        ]);

        $response->assertSessionHasErrors('email');

        // Kiểm tra xem email không được gửi cho user không tồn tại
        Mail::assertNotSent(FailedLoginMail::class);
    }

    public function test_rate_limiting_after_multiple_failed_attempts()
    {
        // Tạo user test
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Thử đăng nhập sai 6 lần (vượt quá giới hạn 5 lần)
        for ($i = 0; $i < 6; $i++) {
            $response = $this->from('/login')->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
                '_token' => csrf_token()
            ]);

            if ($i < 5) {
                $response->assertSessionHasErrors('email');
            } else {
                // Lần thứ 6 sẽ bị rate limit
                $response->assertSessionHasErrors('email');
                $response->assertSee('Quá nhiều lần đăng nhập sai');
            }
        }
    }

    public function test_successful_login_clears_rate_limit()
    {
        // Tạo user test
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // Thử đăng nhập sai 2 lần
        for ($i = 0; $i < 2; $i++) {
            $this->from('/login')->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
                '_token' => csrf_token()
            ]);
        }

        // Đăng nhập thành công
        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            '_token' => csrf_token()
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }
}
