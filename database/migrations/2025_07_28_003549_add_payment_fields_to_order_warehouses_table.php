<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('order_warehouses', function (Blueprint $table) {
        $table->string('payment_status')->nullable()->after('status'); // thêm trạng thái thanh toán
        $table->string('payment_method')->nullable()->after('payment_status');
        $table->decimal('payment_amount', 15, 2)->nullable()->after('payment_method');
        $table->date('payment_date')->nullable()->after('payment_amount');
        $table->string('payment_reference')->nullable()->after('payment_date');
    });
}

public function down()
{
    Schema::table('order_warehouses', function (Blueprint $table) {
        $table->dropColumn([
            'payment_status',
            'payment_method',
            'payment_amount',
            'payment_date',
            'payment_reference'
        ]);
    });
}

};
