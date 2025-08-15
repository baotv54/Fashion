<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ID người dùng (nếu có)
            $table->string('email'); // Email khách hàng
            $table->string('name'); // Tên khách hàng
            $table->string('phone'); // Số điện thoại
            $table->string('address'); // Địa chỉ giao hàng
            $table->string('province')->nullable(); // Tỉnh/Thành phố
            $table->string('district')->nullable(); // Quận/Huyện
            $table->string('ward')->nullable(); // Phường/Xã
            $table->text('note')->nullable(); // Ghi chú
            $table->decimal('subtotal', 10, 2); // Tổng giá trị giỏ hàng
            $table->decimal('discount', 10, 2)->default(0); // Giảm giá
            $table->decimal('total', 10, 2); // Tổng giá trị đơn hàng
            $table->string('payment_method'); // Phương thức thanh toán
            $table->string('status')->default('pending'); // Trạng thái đơn hàng
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};