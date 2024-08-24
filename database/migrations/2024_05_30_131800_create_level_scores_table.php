<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelScoresTable extends Migration
{
    public function up()
    {
        Schema::create('level_scores', function (Blueprint $table) {
            $table->id();
            $table->string('pseudo');
            $table->integer('level');
            $table->integer('score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('level_scores');
    }
}