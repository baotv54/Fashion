<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên chi phí
            $table->decimal('additional_cost', 15, 2)->default(0); // Chi phí thêm
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('costs');
    }
};
