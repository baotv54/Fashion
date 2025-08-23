<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('import_price', 10, 0)->nullable()->after('price'); // sau cột price
            $table->decimal('discount_price', 10, 0)->nullable()->after('import_price');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn(['import_price', 'discount_price']);
        });
    }
};
