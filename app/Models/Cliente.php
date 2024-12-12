<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
    protected $fillable = ['nombre', 'documento', 'telefono'];

    public function vehiculos()
{
    return $this->hasMany(Vehiculo::class);
}

public function mensualidades()
{
    return $this->hasMany(Mensualidad::class);

}

}