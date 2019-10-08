<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado_periodo',
        'universidad_id'
    ];
}
