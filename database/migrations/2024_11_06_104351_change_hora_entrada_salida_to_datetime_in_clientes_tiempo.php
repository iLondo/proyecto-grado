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
        Schema::table('clientes_tiempo', function (Blueprint $table) {
            $table->dateTime('hora_entrada')->nullable()->change();
            $table->dateTime('hora_salida')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('clientes_tiempo', function (Blueprint $table) {
            $table->time('hora_entrada')->nullable()->change();
            $table->time('hora_salida')->nullable()->change();
        });
    }
    
};
