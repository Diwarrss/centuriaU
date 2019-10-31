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

    public function getIngresoTipoPersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $sedes_id = Auth::user()->sedes_id;
        $fechaRecibida = $request->fecha;
        //$fechahoy = $fechaRecibida->format('Y-m-d');

        if ($sedes_id) {
            $ingresosP = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->select('personas.tipo_persona as x', DB::raw('count(ingresos.id) as y'))
                ->where('ingresos.created_at', 'like', '%' . $fechaRecibida . '%')
                ->where('ingresos.sedes_id', $sedes_id)
                ->groupBy('personas.tipo_persona')
                ->get();

            return $ingresosP;
        } else {
            $ingresosP = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->select('personas.tipo_persona as x', DB::raw('count(ingresos.id) as y'))
                ->where('ingresos.created_at', 'like', '%' . $fechaRecibida . '%')
                ->groupBy('personas.tipo_persona')
                ->get();

            return $ingresosP;
        }
    }

    //ingresos totales por mes y año actual
    public function getIngresosMes(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        DB::statement("SET lc_time_names = 'es_ES'"); //para que sea en español las salidas sql
        $sedes_id = Auth::user()->sedes_id;
        $year = Carbon::now()->format('Y');

        if ($sedes_id) {
            $ingresosM = Ingreso::select(
                DB::raw('DATE_FORMAT(created_at, "%M") as x'),
                DB::raw('count(id) as y')
            )->whereYear('created_at', $year)
                ->where('sedes_id', $sedes_id)
                ->orderBy('created_at', 'asc')
                ->groupBy('x')
                ->get();

            return $ingresosM;
        } else {
            $ingresosM = Ingreso::select(
                DB::raw('DATE_FORMAT(created_at, "%M") as x'),
                DB::raw('count(id) as y')
            )->whereYear('created_at', $year)
                ->orderBy('created_at', 'asc')
                ->groupBy('x')
                ->get();

            return $ingresosM;
        }
    }
}
