<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('purchase_returns')->onDelete('cascade'); // đơn trả hàng
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // sản phẩm
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade'); // biến thể sản phẩm
            $table->integer('quantity'); // số lượng trả
            $table->decimal('price', 10, 0); // đơn giá
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_details');
    }
};
