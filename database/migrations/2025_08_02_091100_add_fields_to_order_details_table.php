<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('variant_id')->nullable()->after('product_id'); // Thêm variant_id
            $table->json('variant_details')->nullable()->after('price'); // Thêm variant_details

            // Thêm khóa ngoại
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');

            // Thêm index để tối ưu truy vấn
            $table->index('product_id');
            $table->index('variant_id');
        });
    }

    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['variant_id']);
            $table->dropColumn(['variant_id', 'variant_details']);
            $table->dropIndex(['product_id']);
            $table->dropIndex(['variant_id']);
        });
    }
};