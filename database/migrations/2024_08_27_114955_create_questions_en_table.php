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
        Schema::create('questions_en', function (Blueprint $table) {
            $table->id(); 
            $table->integer('level');
            $table->string('question', 250);
            $table->string('option_a', 150);
            $table->string('option_b', 150);
            $table->string('option_c', 150); 
            $table->string('option_d', 150);
            $table->string('explanation', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions_en');
    }
};
