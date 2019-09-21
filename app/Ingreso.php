<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'personas_id',
        'periodos_id',
        'users_id',
        'sedes_id'
    ];
}
