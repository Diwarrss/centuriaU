<?php

namespace App\Imports;

use App\Persona;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PersonasImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors; //si hay errores los omitimos y se capturan en el controlador al final de la transaccion

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Persona([
            'tipo_documento'     => $row['tipo_documento'],
            'numero_documento'    => $row['numero_documento'],
            'nombre1'     => $row['nombre1'],
            'nombre2'    => $row['nombre2'],
            'apellido1'     => $row['apellido1'],
            'apellido2'    => $row['apellido2'],
            'estado_persona'     => $row['estado_persona'],
            'tipo_persona'    => $row['tipo_persona'],
            'programa'     => $row['programa'],
            'sede'    => $row['sede']
        ]);
    }
}
