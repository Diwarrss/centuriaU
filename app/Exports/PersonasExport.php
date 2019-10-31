<?php

namespace App\Exports;

use App\Persona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PersonasExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Persona::all();
    }

    //elegir los datos y dar un formato a los mismo por medio de MAP, elegimos lo q queremos exportar
    public function map($invoice): array
    {
        return [
            $invoice->tipo_documento,
            $invoice->numero_documento,
            $invoice->nombre1,
            $invoice->nombre2,
            $invoice->apellido1,
            $invoice->apellido2,
            $invoice->estado_persona,
            $invoice->tipo_persona,
            $invoice->programa,
            $invoice->sede,
            $invoice->cargo,
            $invoice->periodos_id,
            Date::dateTimeToExcel($invoice->created_at)
        ];
    }
    //se coloca el heading de las columnas
    public function headings(): array
    {
        return [
            'Tipo_Documento',
            'Documento',
            'Primer_Nombre',
            'Segundo_Nombre',
            'Primer_Apellido',
            'Segundo_Apellido',
            'Estado',
            'Tipo_Persona',
            'Programa',
            'Sede',
            'Cargo',
            '# Periodo',
            'Creación'
        ];
    }

    //es necesario cuando se dara un formato de fecha especifico
    public function columnFormats(): array
    {
        return [
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}
