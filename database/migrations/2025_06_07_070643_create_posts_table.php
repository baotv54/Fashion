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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // id tự tăng
            $table->unsignedBigInteger('post_category_id');
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('author', 11);
            $table->boolean('is_visible')->default(1);

            $table->foreign('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
