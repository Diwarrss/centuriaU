<?php

namespace App\Http\Controllers;

use App\Periodo;
use Illuminate\Http\Request;

class PeriodosController extends Controller
{
    public function getPeriodo(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $periodoActivo = Periodo::where('estado_periodo', 1)->get();

        return $periodoActivo;
    }
}
