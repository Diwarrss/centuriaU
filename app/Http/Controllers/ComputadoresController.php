<?php

namespace App\Http\Controllers;

use App\Computadore;
use Auth;
use Illuminate\Http\Request;

class ComputadoresController extends Controller
{
    public function getComputadorlibre(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $compulibres = Computadore::select(
            'id',
            'nombre',
            'descripcion',
            'estado_computador',
            'sedes_id'
        )->where(
            [
                ['sedes_id', Auth::user()->sedes_id],
                ['estado_computador', '=', '1']
            ]
        )->get();

        return $compulibres;
    }
}
