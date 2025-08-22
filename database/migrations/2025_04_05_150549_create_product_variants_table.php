<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Liên kết với bảng products
            $table->decimal('price', 10, 0); // Giá cho biến thể
            $table->integer('stock'); // Số lượng hàng còn lại
            $table->string('image')->nullable(); // Hình ảnh của biến thể
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
    
};
