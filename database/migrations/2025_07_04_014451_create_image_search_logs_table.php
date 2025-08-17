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
        Schema::create('image_search_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('uploaded_image'); // Đường dẫn hình ảnh đã upload
            $table->text('ai_description'); // Mô tả từ AI
            $table->json('search_filters')->nullable(); // Bộ lọc tìm kiếm
            $table->json('search_results')->nullable(); // Kết quả tìm kiếm (array product IDs)
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_search_logs');
    }
};
