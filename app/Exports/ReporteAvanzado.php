<?php

namespace App\Exports;

use App\Ingreso;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class ReporteAvanzado implements FromQuery
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
            $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                ->where('ingresos.periodos_id', $this->periodo)
                ->where('personas.tipo_persona', $this->tipo_persona)
                ->where('personas.programa', $this->programa)
                ->where('ingresos.sedes_id', $this->sede);

            return $reporte;
        } else {
            $reporte = Ingreso::query()->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->join('periodos', 'periodos.id', '=', 'ingresos.periodos_id')
                ->whereBetween('ingresos.created_at', [$this->fechaInicial, $this->fechaFinal])
                ->where('personas.tipo_persona', $this->tipo_persona)
                ->where('personas.programa', $this->programa)
                ->where('ingresos.sedes_id', $this->sede);

            return $reporte;
        }
    }
}
