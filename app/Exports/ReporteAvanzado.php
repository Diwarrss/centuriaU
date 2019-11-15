<?php

namespace App\Exports;

use App\Ingreso;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReporteAvanzado implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    /* public function collection(Request $request)
    {
        $reporte = Ingreso::all();

        return $reporte;
    } */

    use Exportable;

    //se coloca el heading de las columnas
    public function headings(): array
    {
        return [
            '#',
            'Fecha_Ingreso',
            'Sede_Ingreso',
            'Tipo_Documento',
            'Documento',
            'Primer_Nombre',
            'Segundo_Nombre',
            'Primer_Apellido',
            'Segundo_Apellido',
            'Estado',
            'Tipo_Persona',
            'Programa',
            'Cargo',
            'Periodo',
            'Sede_Persona'
        ];
    }

    //elegir los datos y dar un formato a los mismo por medio de MAP, elegimos lo q queremos exportar
    public function map($invoice): array
    {
        return [
            $invoice->id,
            Date::dateTimeToExcel($invoice->created_at), //DAR FORMATO
            $invoice->sedeIngreso,
            $invoice->tipo_documento,
            $invoice->numero_documento,
            $invoice->nombre1,
            $invoice->nombre2,
            $invoice->apellido1,
            $invoice->apellido2,
            $invoice->estado_persona,
            $invoice->tipo_persona,
            $invoice->programa,
            $invoice->cargo,
            $invoice->periodo,
            $invoice->sedePersona
        ];
    }

    //es necesario cuando se dara un formato de fecha especifico
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DATETIME
            //FORMATO ESPECIFICO https://docs.laravel-excel.com/2.1/reference-guide/formatting.html
        ];
    }

    //obtenemos el request enviado desde el controlador de reportes
    public function __construct($request)
    {
        //creamos variables para generar consulta optimizada delo solicitado
        $this->periodo = $request->periodo;
        $this->fechaInicial = $request->fechaInicial;
        $this->fechaFinal = $request->fechaFinal;
        $this->tipo_persona = $request->tipo_persona;
        $this->programa = $request->programa;
        $this->sede = $request->sedes_id;
    }

    public function query()
    {
        if ($this->periodo) {
            if ($this->tipo_persona && $this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->where('personas.programa', $this->programa)
                    ->where('ingresos.sedes_id', $this->sede);

                return $reporte;
            } elseif ($this->tipo_persona && $this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->where('personas.programa', $this->programa);

                return $reporte;
            } elseif ($this->tipo_persona && !$this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->where('ingresos.sedes_id', $this->sede);

                return $reporte;
            } elseif (!$this->tipo_persona && $this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('personas.programa', $this->programa)
                    ->where('ingresos.sedes_id', $this->sede);

                return $reporte;
            } elseif (!$this->tipo_persona && !$this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('ingresos.sedes_id', $this->sede);

                return $reporte;
            } elseif (!$this->tipo_persona && !$this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo);

                return $reporte;
            } elseif ($this->tipo_persona && !$this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('personas.tipo_persona', $this->tipo_persona);

                return $reporte;
            } elseif (!$this->tipo_persona && $this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('personas.programa', $this->programa);

                return $reporte;
            }
        } else {
            if ($this->fechaFinal && $this->tipo_persona && $this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->where('personas.programa', $this->programa)
                    ->where('ingresos.sedes_id', $this->sede)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && $this->tipo_persona && $this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->where('personas.programa', $this->programa)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && $this->tipo_persona && !$this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->where('ingresos.sedes_id', $this->sede)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && !$this->tipo_persona && $this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('personas.programa', $this->programa)
                    ->where('ingresos.sedes_id', $this->sede)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && !$this->tipo_persona && !$this->programa && $this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('ingresos.periodos_id', $this->periodo)
                    ->where('ingresos.sedes_id', $this->sede)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && !$this->tipo_persona && !$this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && $this->tipo_persona && !$this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('personas.tipo_persona', $this->tipo_persona)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            } elseif ($this->fechaFinal && !$this->tipo_persona && $this->programa && !$this->sede) {
                $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                    ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                    ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                    ->select('ingresos.id', 'ingresos.created_at', 'sedes.nombre as sedeIngreso', 'personas.tipo_documento', 'personas.numero_documento', 'personas.nombre1', 'personas.nombre2', 'personas.apellido1', 'personas.apellido2', 'personas.estado_persona', 'personas.tipo_persona', 'personas.programa', 'personas.cargo', 'periodos.nombre as periodo', 'personas.sede as sedePersona')
                    ->where('personas.programa', $this->programa)
                    ->whereBetween('ingresos.created_at', [$this->fechaInicial . ' 00:00:00', $this->fechaFinal . ' 23:59:59']);

                return $reporte;
            }
        }
    }
}
