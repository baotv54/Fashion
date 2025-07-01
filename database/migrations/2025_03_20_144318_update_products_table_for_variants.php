<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Cho phép giá và giá khuyến mãi có thể null nếu sản phẩm có biến thể
            $table->decimal('price', 10, 2)->nullable()->change();
            $table->decimal('discount_price', 10, 2)->nullable()->change();

            // Thêm cột xác định sản phẩm có biến thể hay không
            $table->boolean('has_variants')->default(0)->after('status');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Quay lại trạng thái cũ
            $table->decimal('price', 10, 2)->nullable(false)->change();
            $table->decimal('discount_price', 10, 2)->nullable()->change();
            $table->dropColumn('has_variants');
        });
    }
};
