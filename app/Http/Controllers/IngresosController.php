<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;

class IngresosController extends Controller
{
    public function getPersona(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $numDocumento = $request->id;

        $personabyID = Persona::where('numero_documento', $numDocumento)->get();

        return $personabyID;
    }
}
