<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Super Admin',
    'email' => 'superadmin@admin.com',
    'password' => Hash::make('123456'),
    'role' => 'admin',
]);

echo "Admin account created successfully!\n"; 