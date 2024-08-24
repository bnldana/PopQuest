<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalScoresTable extends Migration
{
    public function up()
    {
        Schema::create('global_scores', function (Blueprint $table) {
            $table->id();
            $table->string('pseudo')->unique();
            $table->integer('total_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_scores');
    }
}
