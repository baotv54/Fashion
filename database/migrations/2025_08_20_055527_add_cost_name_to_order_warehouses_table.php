<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_warehouses', function (Blueprint $table) {
            $table->string('cost_name')->nullable()->after('additional_cost');
            // thêm sau cột additional_cost (nếu bạn có cột đó)
        });
    }

    public function down(): void
    {
        Schema::table('order_warehouses', function (Blueprint $table) {
            $table->dropColumn('cost_name');
        });
    }
};
