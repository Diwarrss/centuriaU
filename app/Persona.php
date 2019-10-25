<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombre1',
        'nombre2',
        'apellido1',
        'apellido2',
        'estado_persona',
        'tipo_persona',
        'programa',
        'sede',
        'cargo',
        'periodos_id'
    ];
}
