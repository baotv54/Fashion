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
        Schema::create('order_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // mã đơn nhập
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // người tạo
            $table->text('note')->nullable();
            $table->date('import_date')->nullable();
            $table->string('status')->default('Đang Giao Dịch'); // trạng thái xử lý
            $table->string('import_type')->default('Chưa Nhập'); // loại nhập hàng
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_warehouses'); // sửa đúng tên bảng
    }
};
