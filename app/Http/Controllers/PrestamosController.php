<?php

namespace App\Http\Controllers;

use App\Computadore;
use App\Prestamo;
use Auth;
use DB;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public function getPrestamos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $cantidad = $request->cantidad;
        $criterio = $request->criterio;
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $prestamos = Prestamo::join('computadores', 'computadores.id', '=', 'prestamos.computadores_id')
                ->join('ingresos', 'ingresos.id', '=', 'prestamos.ingresos_id')
                ->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->join('sedes', 'sedes.id', '=', 'prestamos.sedes_id')
                ->select(
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC',
                    'computadores.descripcion',
                    'prestamos.observacion',
                    'prestamos.estado_prestamo',
                    'prestamos.id as prestamoID',
                    'prestamos.sedes_id',
                    'prestamos.created_at as fechaPrestamo',
                    'prestamos.updated_at as fechaFin',
                    'sedes.nombre as nombreSede',
                    'personas.nombre1',
                    'personas.nombre2',
                    'personas.apellido1',
                    'personas.apellido2',
                    'personas.tipo_documento',
                    'personas.numero_documento'
                )->where('prestamos.sedes_id', $sedes_id)
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                ->paginate($cantidad);

            return $prestamos;
        } else {
            $prestamos = Prestamo::join('computadores', 'computadores.id', '=', 'prestamos.computadores_id')
                ->join('ingresos', 'ingresos.id', '=', 'prestamos.ingresos_id')
                ->join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->join('sedes', 'sedes.id', '=', 'prestamos.sedes_id')
                ->select(
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC',
                    'computadores.descripcion',
                    'prestamos.observacion',
                    'prestamos.estado_prestamo',
                    'prestamos.id as prestamoID',
                    'ingresos.id as ingresosID',
                    'prestamos.created_at as fechaPrestamo',
                    'prestamos.updated_at as fechaFin',
                    'sedes.nombre as nombreSede',
                    'personas.nombre1',
                    'personas.nombre2',
                    'personas.apellido1',
                    'personas.apellido2',
                    'personas.tipo_documento',
                    'personas.numero_documento'
                )->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                ->paginate(5);

            return $prestamos;
        }
    }

    public function crearPrestamo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            //usaremos transacciones
            DB::beginTransaction();

            //para validar los formularios
            $request->validate([
                'ingresosID' => 'required',
                'estado_prestamo' => 'required',
                'users_id' => 'required',
                'sedes_id' => 'required',
                'computadores_id' => 'required'
            ]);
            $prestamo =  new Prestamo();
            $prestamo->estado_prestamo = $request->estado_prestamo;
            $prestamo->users_id = $request->users_id;
            $prestamo->computadores_id = $request->computadores_id;
            $prestamo->ingresos_id = $request->ingresosID;
            $prestamo->sedes_id = $request->sedes_id;
            $prestamo->save(); //guardamos en la tabla prestamo

            $updateCompu = Computadore::findOrFail($request->computadores_id);
            $updateCompu->estado_computador = '2';
            $updateCompu->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function finalizarPrestamo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            //usaremos transacciones
            DB::beginTransaction();
            //para validar los formularios
            $request->validate([
                'computadorID' => 'required',
                'prestamoID' => 'required'
            ]);
            $updateCompu = Computadore::findOrFail($request->computadorID);
            $updateCompu->estado_computador = '1';
            $updateCompu->save();

            $updatePrestamo = Prestamo::findOrFail($request->prestamoID);
            $updatePrestamo->estado_prestamo = '0';
            $updatePrestamo->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function reportarObservacion(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            //usaremos transacciones
            DB::beginTransaction();

            //para validar los formularios
            $request->validate([
                'observacion' => 'required|max:250'
            ]);

            $observacion = Prestamo::findOrFail($request->prestamoID);
            $observacion->estado_prestamo = '0';
            $observacion->observacion = $request->observacion;
            $observacion->save(); //guardamos en la tabla prestamo

            $updateCompu = Computadore::findOrFail($observacion->computadores_id);
            $updateCompu->estado_computador = '0';
            $updateCompu->observacion = $request->observacion;
            $updateCompu->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }
}
