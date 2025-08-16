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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained()->onDelete('cascade'); // Liên kết với bảng attributes
            $table->string('value'); // Giá trị thuộc tính như "Đỏ", "Xanh", "S", "M"
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
    
};
