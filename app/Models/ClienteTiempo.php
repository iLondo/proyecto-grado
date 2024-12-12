<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteTiempo extends Model
{
    protected $table = 'clientes_tiempo';

    protected $fillable = ['vehiculo_id', 'tipo', 'hora_entrada', 'hora_salida', 'total_tiempo_estadia', 'total_a_pagar'];

    // Relación con el modelo Vehiculo
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
