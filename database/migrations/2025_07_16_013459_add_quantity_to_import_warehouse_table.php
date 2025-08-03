<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('import_warehouse', function (Blueprint $table) {
            $table->integer('quantity')->default(0)->after('variant_id'); // hoặc sau cột phù hợp
        });
    }

    public function down(): void
    {
        Schema::table('import_warehouse', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
