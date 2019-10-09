<?php

namespace App\Exports;

use App\Persona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonasExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Persona::all();
    }

    public function headings(): array //se coloca el heading de las columnas
    {
        return [
            '#',
            'Tipo Documento',
            'Documento',
            'Primer Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Estado',
            'Tipo Persona',
            'Programa',
            'Sede',
            'Creación',
            'Actualizado'
        ];
    }
}
