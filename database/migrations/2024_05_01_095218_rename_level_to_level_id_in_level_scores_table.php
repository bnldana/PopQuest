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
        Schema::table('level_scores', function (Blueprint $table) {
            $table->renameColumn('level', 'level_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('level_scores', function (Blueprint $table) {
            $table->renameColumn('level_id', 'level');
        });
    }
};
