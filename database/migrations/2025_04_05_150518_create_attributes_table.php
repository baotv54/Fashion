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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên thuộc tính như "Màu sắc", "Kích thước"
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
    
};
