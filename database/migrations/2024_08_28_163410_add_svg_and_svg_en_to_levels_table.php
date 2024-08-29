<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->text('svg')->nullable();
            $table->text('svg_en')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('svg');
            $table->dropColumn('svg_en');
        });
    }    
};
