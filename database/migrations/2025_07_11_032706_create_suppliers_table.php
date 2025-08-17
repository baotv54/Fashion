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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_code')->unique(); // Mã nhà cung cấp
            $table->string('name'); // Tên nhà cung cấp
            $table->string('phone')->nullable(); // Số điện thoại
            $table->string('tax_code')->nullable(); // Mã số thuế
            $table->string('fax')->nullable(); // Số fax
            $table->string('email')->nullable(); // Email
            $table->unsignedBigInteger('user_id')->nullable(); // ID người phụ trách
            $table->string('province')->nullable(); // Tỉnh
            $table->string('district')->nullable(); // Huyện
            $table->string('ward')->nullable(); // Phường/xã
            $table->string('address_detail')->nullable(); // Địa chỉ cụ thể
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
