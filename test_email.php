<?php

require_once 'vendor/autoload.php';

use App\Mail\FailedLoginMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Email Functionality...\n";

try {
    // Tìm user đầu tiên để test
    $user = User::first();
    
    if (!$user) {
        echo "No users found in database. Please create a user first.\n";
        exit(1);
    }
    
    echo "Testing with user: " . $user->email . "\n";
    
    // Test gửi email
    Mail::to($user->email)->send(new FailedLoginMail(
        $user,
        3, // số lần đăng nhập sai
        '127.0.0.1', // IP address
        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36' // User Agent
    ));
    
    echo "✅ Email sent successfully!\n";
    echo "Check your email: " . $user->email . "\n";
    
} catch (Exception $e) {
    echo "❌ Error sending email: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} 