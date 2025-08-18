<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('popups', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('media_type')->default('image'); // image | video
            $table->string('media_path')->nullable(); // link file ảnh/video
            $table->boolean('status')->default(1); // 1: hiển thị, 0: ẩn
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('popups');
    }
};
