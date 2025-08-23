<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // Tên mạng xã hội
            $table->string('url')->nullable(); // Link mạng xã hội
            $table->string('image')->nullable(); // Lưu icon (path ảnh hoặc tên icon)
            $table->timestamps();

           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
