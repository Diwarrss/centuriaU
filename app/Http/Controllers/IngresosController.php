<?php

namespace App\Http\Controllers;

use App\Ingreso;
use App\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngresosController extends Controller
{
    public function getPersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $numDocumento = $request->id;

        $personabyID = Persona::where('numero_documento', $numDocumento)->get();

        return $personabyID;
    }



    public function crearIngreso(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            //usaremos transacciones
            DB::beginTransaction();

            //para validar los formularios
            $request->validate([
                'personas_id' => 'required',
                'periodos_id' => 'required',
                'users_id' => 'required',
                'sedes_id' => 'required',
            ]);
            $ingreso =  new Ingreso();
            $ingreso->personas_id = $request->personas_id;
            $ingreso->periodos_id = $request->periodos_id;
            $ingreso->users_id = $request->users_id;
            $ingreso->sedes_id = $request->sedes_id;
            $ingreso->save(); //guardamos en la tabla ingresos

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function getIngresosActuales(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $fechahoy = Carbon::now()->format('Y-m-d');

        $ingresosActuales = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
            ->leftJoin('prestamos', 'ingresos.id', '=', 'prestamos.ingresos_id')
            ->leftJoin('computadores', 'prestamos.computadores_id', '=', 'computadores.id')
            ->select(
                'ingresos.created_at',
                'personas.id as personaID',
                'ingresos.id as ingresosID',
                'personas.numero_documento',
                'personas.nombre1',
                'personas.nombre2',
                'personas.apellido1',
                'personas.apellido2',
                'prestamos.id as prestamoID',
                'computadores.id as computadorID',
                'computadores.nombre as nombrePC'
            )
            ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
            ->orderBy('ingresos.created_at', 'desc')
            ->get();

        return $ingresosActuales;
    }
}
