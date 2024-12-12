<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clientes_tiempo', function (Blueprint $table) {
            $table->date('fecha_ingreso')->default(DB::raw('CURRENT_DATE')); // La fecha por defecto será la fecha actual
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes_tiempo', function (Blueprint $table) {
            //
        });
    }
};