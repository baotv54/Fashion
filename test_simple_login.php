<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Simple Login...\n";

try {
    // Tạo user test nếu chưa có
    $user = User::where('email', 'test@example.com')->first();
    
    if (!$user) {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123')
        ]);
        echo "Created test user: " . $user->email . "\n";
    } else {
        echo "Found existing user: " . $user->email . "\n";
    }
    
    // Test đăng nhập sai
    echo "Testing failed login...\n";
    
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'wrongpassword'
    ];
    
    // Tìm user theo email
    $user = User::where('email', $credentials['email'])->first();
    
    if ($user) {
        echo "User found: " . $user->name . "\n";
        
        // Trigger Failed event manually
        event(new \Illuminate\Auth\Events\Failed('web', $user, $credentials));
        
        echo "✅ Failed event triggered successfully!\n";
    } else {
        echo "❌ User not found!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
} 