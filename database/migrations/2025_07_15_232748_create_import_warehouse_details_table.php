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
        Schema::create('import_warehouse_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_warehouse_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 0)->default(0);
            $table->timestamps();

            $table->foreign('import_warehouse_id')->references('id')->on('order_warehouses')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->foreign('variant_id')->references('id')->on('product_variants')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_warehouse_details');
    }
};
