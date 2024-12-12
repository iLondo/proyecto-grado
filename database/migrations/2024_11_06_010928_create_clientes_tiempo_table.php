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
        Schema::create('clientes_tiempo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehiculo_id');
            $table->string('tipo');
            $table->time('hora_entrada');
            $table->time('hora_salida')->nullable();
            $table->time('total_tiempo_estadia')->nullable();
            $table->decimal('total_a_pagar', 10, 2)->nullable();
            $table->timestamps();
    
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
        });
    }          

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes_tiempo');
    }
};
