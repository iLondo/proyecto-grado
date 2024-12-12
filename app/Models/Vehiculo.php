<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $fillable = ['cliente_id', 'placa', 'tipo'];

    // Relación con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function mensualidades()
    {
        return $this->hasMany(Mensualidad::class);
    }
}
