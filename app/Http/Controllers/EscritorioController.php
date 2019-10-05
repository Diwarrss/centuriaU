<?php

namespace App\Http\Controllers;

use App\Computadore;
use App\Ingreso;
use App\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EscritorioController extends Controller
{
    public function countIngresos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //obtenemos el id de la sede del usuario q ingresa
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $ingresos = Ingreso::where('sedes_id', $sedes_id)
                ->count();

            return $ingresos;
        } else {
            $ingresos = Ingreso::count();

            return $ingresos;
        }
    }

    public function countComputadores(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //obtenemos el id de la sede del usuario q ingresa
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $compu = Computadore::where('sedes_id', $sedes_id)
                ->count();

            return $compu;
        } else {
            $compu = Computadore::count();

            return $compu;
        }
    }

    public function countPrestamos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //obtenemos el id de la sede del usuario q ingresa
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $compu = Prestamo::where('sedes_id', $sedes_id)
                ->count();

            return $compu;
        } else {
            $compu = Prestamo::count();

            return $compu;
        }
    }
}
