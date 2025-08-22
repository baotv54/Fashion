<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('socialLinks', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Tên mạng xã hội
            $table->string('url')->nullable(); // Link mạng xã hội
            $table->string('image')->nullable(); // Lưu icon (path ảnh hoặc tên icon)
            $table->timestamps();

            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socialLinks');
    }
};
