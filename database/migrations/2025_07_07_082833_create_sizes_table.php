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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size', 50); // SIZE (ví dụ: S (29))
            $table->string('height_range', 50)->nullable(); // Chiều cao (cm)
            $table->string('weight_range', 50)->nullable(); // Cân nặng (kg)
            $table->string('chest_range', 50)->nullable(); // Rộng ngực (cm)
            $table->string('hip_range', 50)->nullable(); // Rộng mông (cm)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
