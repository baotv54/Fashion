<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // ID đơn hàng
            $table->unsignedBigInteger('product_id'); // ID sản phẩm
            $table->string('product_name'); // Tên sản phẩm
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->decimal('price', 10, 2); // Giá sản phẩm
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade'); // Liên kết với bảng orders
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};