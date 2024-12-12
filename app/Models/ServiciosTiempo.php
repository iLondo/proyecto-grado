<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosTiempo extends Model
{
    use HasFactory;

    protected $table = 'servicios_tiempo';

    const ESTADO_TERMINADO = 'terminado';
    const ESTADO_EN_CURSO = 'en_curso';
    const ESTADO_CANCELADO = 'cancelado';

    protected $fillable = [
        'nombre',
        'documento',
        'telefono',
        'placa',
        'tipo',
        'fecha_hora_ingreso',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');  // Ajusta el campo 'cliente_id' según sea necesario
    }

    /**
     * Relación con el modelo Vehiculo
     */
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');  // Asegúrate de que 'vehiculo_id' sea el campo correcto
    }
}

