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
        Schema::rename('product_images', 'images');
    
        Schema::table('images', function (Blueprint $table) {
            // Xoá foreign key trước
            $table->dropForeign('product_images_product_id_foreign');
    
            // Sau đó mới được xoá cột
            $table->dropColumn('product_id');
        });
    }
    
    
    public function down()
    {
        Schema::rename('images', 'product_images');
    
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['imageable_id', 'imageable_type']);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
