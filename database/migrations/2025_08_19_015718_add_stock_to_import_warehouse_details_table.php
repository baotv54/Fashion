<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('import_warehouse_details', function (Blueprint $table) {
            $table->integer('stock')->default(0)->after('quantity');
            // after('quantity') để thêm ngay sau cột quantity, có thể thay đổi
        });
    }

    public function down(): void
    {
        Schema::table('import_warehouse_details', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
