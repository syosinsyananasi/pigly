<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightTargetTable extends Migration
{
    public function up()
    {
        Schema::create('weight_target', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('target_weight', 4, 1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weight_target');
    }
}
