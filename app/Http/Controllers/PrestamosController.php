<?php

namespace App\Http\Controllers;

use App\Computadore;
use App\Prestamo;
use DB;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
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
}
