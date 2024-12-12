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
        Schema::table('servicios_tiempo', function (Blueprint $table) {
            $table->string('estado')->default('En Proceso'); // 'En Proceso' será el valor por defecto
        });
    }
    
    public function down()
    {
        Schema::table('servicios_tiempo', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
    
};
