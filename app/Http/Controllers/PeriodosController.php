<?php

namespace App\Http\Controllers;

use App\Periodo;
use App\Universidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeriodosController extends Controller
{
    public function getPeriodo(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $periodoActivo = Periodo::where('estado_periodo', 1)->get();

        return $periodoActivo;
    }

    public function getPeriodosAll(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $criterio = $request->criterio;
        $buscar = $request->buscar;
        $cantidad = $request->cantidad;

        $periodos = Periodo::where($criterio, 'LIKE', '%' . $buscar . '%')->paginate($cantidad);;

        return $periodos;
    }

    public function savePeriodo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            //usaremos transacciones
            DB::beginTransaction();

            $request->validate([
                'nombre' => 'required|max:150|unique:periodos',
                'descripcion' => 'max:200',
                'estado_periodo' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $encontrar = Periodo::where([
                            ['estado_periodo', '=', $value]
                        ])->count();
                        if ($encontrar == 1) {
                            $fail('Ya hay periodo Activado');
                        }
                    },
                ],
            ]);

            //buscar primero el Persona a modificar
            $periodo = new Periodo();
            $periodo->nombre = $request->nombre;
            $periodo->descripcion = $request->descripcion;
            $periodo->estado_periodo = $request->estado_periodo;
            $periodo->universidad_id = 1;
            $periodo->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function updatePeriodo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            //usaremos transacciones
            DB::beginTransaction();

            //buscar primero el Persona a modificar
            $periodo = Periodo::findOrFail($request->id);

            $request->validate([
                'nombre' => 'required|max:150|unique:periodos,nombre,' . $periodo->id,
                'descripcion' => 'max:200',
                //validacion poderosa para saber si ya hay un periodo activado
                'estado_periodo' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $encontrar = Periodo::where([
                            ['estado_periodo', '=', $value]
                        ])->count();
                        if ($encontrar == 1) {
                            $fail('Ya hay periodo Activado');
                        }
                    }
                ],
            ]);

            $periodo->nombre = $request->nombre;
            $periodo->descripcion = $request->descripcion;
            $periodo->estado_periodo = $request->estado_periodo;
            $periodo->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }
}
