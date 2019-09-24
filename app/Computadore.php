<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computadore extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado_computador',
        'sedes_id'
    ];
}
