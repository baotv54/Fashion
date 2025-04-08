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
        Schema::create('variant_attribute_values', function (Blueprint $table) {
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade'); // Liên kết với bảng product_variants
            $table->foreignId('attribute_value_id')->constrained('attribute_values')->onDelete('cascade'); // Liên kết với bảng attribute_values
            $table->primary(['variant_id', 'attribute_value_id']); // Khoá chính cho sự liên kết giữa variant và attribute_value
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('variant_attribute_values');
    }
    
};
