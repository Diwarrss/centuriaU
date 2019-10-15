<?php

namespace App\Http\Controllers;

use App\Exports\ReporteAvanzado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    //realizar export de excel
    public function exportAvanzado(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        //validamos si hay un periodo y validamos si existe si no solo las fechas
        if ($request->periodo) {
            //para validar los formularios
            $request->validate([
                'periodo' => 'required',
            ]);

            //enviamos el $request obtenido al controlador de ReporteAvanzado
            return Excel::download(new ReporteAvanzado($request), 'Avanzado.xlsx');
        } else {
            //para validar los formularios
            $request->validate([
                'fechaInicial' => 'required',
                'fechaFinal' => 'required',
            ]);

            //enviamos el $request obtenido al controlador de ReporteAvanzado
            return Excel::download(new ReporteAvanzado($request), 'Avanzado.xlsx');
        }
    }
}
