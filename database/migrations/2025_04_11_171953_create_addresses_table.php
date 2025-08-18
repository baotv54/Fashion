<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Liên kết với bảng users
            $table->string('address'); // Địa chỉ chi tiết
            $table->string('province'); // Tỉnh/Thành
            $table->string('district'); // Quận/Huyện
            $table->string('ward'); // Phường/Xã
            $table->boolean('is_default')->default(false); // Địa chỉ mặc định
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
