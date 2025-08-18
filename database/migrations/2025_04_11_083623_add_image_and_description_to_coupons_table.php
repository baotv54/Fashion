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
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('image')->nullable()->after('used');       // Thêm cột hình ảnh
            $table->text('description')->nullable()->after('image'); // Thêm cột mô tả
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('image');       // Xóa cột hình ảnh
            $table->dropColumn('description'); // Xóa cột mô tả
        });
    }
};