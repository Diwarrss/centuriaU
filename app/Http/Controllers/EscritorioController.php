<?php

namespace App\Http\Controllers;

use App\Computadore;
use App\Ingreso;
use App\Prestamo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function countUsers(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //obtenemos el id de la sede del usuario q ingresa
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $users = User::where('sedes_id', $sedes_id)
                ->count();

            return $users;
        } else {
            $users = User::count();

            return $users;
        }
    }

    public function getIngresoPrograma(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $sedes_id = Auth::user()->sedes_id;
        $fechahoy = Carbon::now()->format('Y-m-d');

        if ($sedes_id) {
            $ingresosP = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->select('personas.programa as x', DB::raw('SUM(ingresos.id) as y'))
                ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
                ->where('ingresos.sedes_id', $sedes_id)
                ->get();

            return $ingresosP;
        } else {
            $ingresosP = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->select('personas.programa as x', DB::raw('count(ingresos.id) as y'))
                ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
                ->groupBy('personas.programa')
                ->get();

            return $ingresosP;
        }
    }
}
