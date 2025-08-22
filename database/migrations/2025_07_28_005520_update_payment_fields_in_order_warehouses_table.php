<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentFieldsInOrderWarehousesTable extends Migration
{
    public function up()
    {
        Schema::table('order_warehouses', function (Blueprint $table) {
            $table->string('payment_status')->nullable()->change();
            $table->string('payment_method')->nullable()->change();
            $table->decimal('payment_amount', 10, 0)->nullable()->change();
            $table->date('payment_date')->nullable()->change();
            $table->string('payment_reference')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('order_warehouses', function (Blueprint $table) {
            // Ví dụ rollback nếu cần – sửa lại đúng kiểu cũ
            $table->string('payment_status')->change();
            $table->string('payment_method')->change();
            $table->decimal('payment_amount', 10, 0)->change(); // ví dụ trước là 8,0
            $table->date('payment_date')->change();
            $table->string('payment_reference')->change();
        });
    }
}
