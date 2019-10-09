<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormatoExport implements WithHeadings, ShouldAutoSize
{
    //se coloca el heading de las columnas
    public function headings(): array
    {
        return [
            'tipo_documento',
            'numero_documento',
            'nombre1',
            'nombre2',
            'apellido1',
            'apellido2',
            'estado_persona',
            'tipo_persona',
            'programa',
            'sede'
        ];
    }
}
