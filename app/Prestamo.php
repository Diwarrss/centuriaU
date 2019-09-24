<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    protected $fillable = [
        'estado_prestamo',
        'users_id',
        'computadores_id',
        'ingresos_id',
        'sedes_id'
    ];
}
