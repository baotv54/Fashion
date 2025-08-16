<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_live_chat_threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_token', 64)->index();
            $table->string('status', 20)->default('open');
            $table->timestamps();

            $table->index(['product_id', 'session_token']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_live_chat_threads');
    }
};
