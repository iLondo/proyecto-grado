<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVehiculoIdToMensualidadesTable extends Migration
{
    public function up()
    {
        Schema::table('mensualidades', function (Blueprint $table) {
            // Agregar la columna vehiculo_id
            $table->unsignedBigInteger('vehiculo_id')->nullable();

            // Definir la llave foránea
            $table->foreign('vehiculo_id')
                  ->references('id')->on('vehiculos')  // Suponiendo que la tabla de vehículos se llama 'vehiculos'
                  ->onDelete('set null');  // Si el vehículo se elimina, la columna vehiculo_id se pone en null
        });
    }

    public function down()
    {
        Schema::table('mensualidades', function (Blueprint $table) {
            // Eliminar la llave foránea y la columna
            $table->dropForeign(['vehiculo_id']);
            $table->dropColumn('vehiculo_id');
        });
    }
}
