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
        Schema::table('images', function (Blueprint $table) {
            $table->morphs('imageable'); // thêm imageable_id và imageable_type
        });
    }
    
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropMorphs('imageable');
        });
    }
    
};
