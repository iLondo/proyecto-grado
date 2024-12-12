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
        Schema::table('mensualidades', function (Blueprint $table) {
            $table->enum('estado', ['pagado', 'pendiente'])->default('pendiente');
        });
    }
    
    public function down()
    {
        Schema::table('mensualidades', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
    
};
