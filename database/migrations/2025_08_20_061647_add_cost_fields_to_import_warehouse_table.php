<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('import_warehouse', function (Blueprint $table) {
            $table->string('name_cost')->nullable()->after('quantity'); // tên chi phí
            $table->decimal('additional_cost', 15, 2)->default(0)->after('name_cost'); // chi phí thêm
            $table->decimal('discount', 15, 2)->default(0)->after('additional_cost'); // giảm giá
        });
    }

    public function down(): void
    {
        Schema::table('import_warehouse', function (Blueprint $table) {
            $table->dropColumn(['name_cost', 'additional_cost', 'discount']);
        });
    }
};
