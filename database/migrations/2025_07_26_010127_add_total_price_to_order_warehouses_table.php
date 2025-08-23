<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('order_warehouses', function (Blueprint $table) {
            $table->decimal('total_price', 10, 0)->after('note')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('order_warehouses', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};
