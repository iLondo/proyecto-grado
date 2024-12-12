<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTiempoTable extends Migration
{
    public function up()
    {
        Schema::create('servicios_tiempo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('documento', 20)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('placa', 20);
            $table->enum('tipo', ['Moto', 'Carro']);
            $table->dateTime('fecha_hora_ingreso');
            $table->dateTime('fecha_hora_salida')->nullable();
            $table->string('tiempo_estadia')->nullable();
            $table->decimal('total_a_pagar', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicios_tiempo');
    }
}