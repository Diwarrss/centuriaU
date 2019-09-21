<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $fillable = [
        'nombre',
        'estado_periodo',
        'universidad_id'
    ];
}
