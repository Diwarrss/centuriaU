<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $fillable = [
        'nombre',
        'estado',
        'universidad_id',
    ];
}
