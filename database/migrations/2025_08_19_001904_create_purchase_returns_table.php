<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_code')->unique(); // mã đơn trả hàng
            $table->enum('return_status', ['Đang Xử Lý', 'Đã Hoàn Hàng'])->default('Đang Xử Lý'); // trạng thái hoàn hàng
            $table->enum('refund_status', ['Đang Xử Lý', 'Đã Hoàn Tiền'])->default('Đang Xử Lý'); // trạng thái hoàn tiền
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // nhân viên tạo
            $table->integer('total_quantity')->default(0); // tổng số lượng trả
            $table->decimal('total_amount', 20, 2)->default(0); // tổng giá trị hoàn trả
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
