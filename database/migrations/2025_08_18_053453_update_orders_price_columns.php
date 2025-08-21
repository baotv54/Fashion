<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 0)->default(0)->change();
            $table->decimal('discount', 10, 0)->default(0)->change();
            $table->decimal('shipping_fee', 10, 0)->default(0)->change();
            $table->decimal('total', 10, 0)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('subtotal')->change();
            $table->integer('discount')->change();
            $table->integer('shipping_fee')->change();
            $table->integer('total')->change();
        });
    }
};
