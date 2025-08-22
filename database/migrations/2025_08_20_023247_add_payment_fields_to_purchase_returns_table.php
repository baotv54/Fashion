<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_returns', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('id'); // cho phép null
            $table->dateTime('payment_date')->nullable()->after('payment_method'); // cho phép null
        });
    }

    public function down(): void
    {
        Schema::table('purchase_returns', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_date']);
        });
    }
};
