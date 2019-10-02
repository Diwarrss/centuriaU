<?php

namespace App\Http\Controllers;

use App\Computadore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComputadoresController extends Controller
{
    public function getComputadorlibre(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sedes_id = Auth::user()->sedes_id;

        $compulibres = Computadore::select(
            'id',
            'nombre',
            'descripcion',
            'estado_computador',
            'sedes_id'
        )->where(
            [
                ['sedes_id', $sedes_id],
                ['estado_computador', '=', '1']
            ]
        )->get();

        return $compulibres;
    }

    public function getCompu(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $cantidad = $request->cantidad;
        $criterio = $request->criterio;
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $computadores = Computadore::join('sedes', 'computadores.sedes_id', '=', 'sedes.id')->select(
                'computadores.id as compuId',
                'computadores.nombre as nombreCompu',
                'computadores.descripcion',
                'computadores.estado_computador',
                'computadores.sedes_id',
                'computadores.created_at',
                'sedes.nombre as nombreSede'
            )->where('computadores.sedes_id', $sedes_id)
                ->where('computadores.' . $criterio, 'LIKE', '%' . $buscar . '%')->paginate($cantidad);

            return $computadores;
        } else {
            $computadores = Computadore::join('sedes', 'computadores.sedes_id', '=', 'sedes.id')->select(
                'computadores.id as compuId',
                'computadores.nombre as nombreCompu',
                'computadores.descripcion',
                'computadores.estado_computador',
                'computadores.sedes_id',
                'computadores.created_at',
                'sedes.nombre as nombreSede'
            )->where('computadores.' . $criterio, 'LIKE', '%' . $buscar . '%')->paginate($cantidad);

            return $computadores;
        }
    }

    public function saveCompu(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $request->validate([
            'nombre' => 'required|max:20',
            //'nombre' => 'required|max:150|unique:computadores',
            'descripcion' => 'max:200',
            'estado' => 'required',
            'sede' => 'required'
        ]);
        try {
            //usaremos transacciones
            DB::beginTransaction();

            $computador =  new Computadore();
            $computador->nombre = $request->nombre;
            $computador->descripcion = $request->descripcion;
            $computador->estado_computador = $request->estado;
            $computador->sedes_id = $request->sede;
            $computador->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function updateCompu(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el Persona a modificar
            $computador = Computadore::findOrFail($request->compuId);

            $request->validate([
                'nombre' => 'required|max:150',
                //'nombre' => 'required|max:150|unique:computadores,nombre,' . $computador->id,
                'descripcion' => 'max:200',
                'estado' => 'required',
                'sede' => 'required'
            ]);

            $computador->nombre = $request->nombre;
            $computador->descripcion = $request->descripcion;
            $computador->estado_computador = $request->estado;
            $computador->sedes_id = $request->sede;
            $computador->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }
}
