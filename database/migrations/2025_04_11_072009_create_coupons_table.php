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
    Schema::create('coupons', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();                     // Mã coupon
        $table->enum('type', ['fixed', 'percent']);           // Loại giảm: số tiền hoặc %
        $table->decimal('value', 10, 0);                      // Giá trị giảm
        $table->decimal('min_cart_value', 10, 0)->default(0); // Đơn tối thiểu để áp dụng
        $table->date('start_date')->nullable();               // Ngày bắt đầu hiệu lực
        $table->date('end_date')->nullable();                 // Ngày kết thúc hiệu lực
        $table->integer('usage_limit')->nullable();           // Giới hạn số lượt sử dụng
        $table->integer('used')->default(0);                  // Số lượt đã sử dụng
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
