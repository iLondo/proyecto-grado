<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMensualidadIdForeignToPagosTable extends Migration
{
    public function up()
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Agregar la llave foránea en la columna mensualidad_id
            $table->foreign('mensualidad_id')->references('id')->on('mensualidades')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pagos', function (Blueprint $table) {
            // Eliminar la llave foránea en caso de revertir la migración
            $table->dropForeign(['mensualidad_id']);
        });
    }
}