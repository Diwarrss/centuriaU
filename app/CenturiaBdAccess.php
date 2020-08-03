<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CenturiaBdAccess extends Model
{
  public $fillable = [
    'cargo',
    'ciudad',
    'estado',
    'maac_fechamatricula',
    'matriculaestado',
    'pege_documentoidentidad',
    'peng_primerapellido',
    'peng_primernombre',
    'peng_segundoapellido',
    'peng_segundonombre',
    'programa',
    'tidg_abreviatura',
    'tidg_id',
    'tipo_persona',
    'tipoestudiante'
  ];
}
