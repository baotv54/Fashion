<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_review_media', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_review_id');
            $table->string('file_path');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('original_name')->nullable();
            $table->timestamps();

            $table->index('order_review_id');
            $table->index('type');

            $table->foreign('order_review_id')->references('id')->on('order_reviews')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_review_media');
    }
};
