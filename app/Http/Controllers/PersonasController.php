<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonasController extends Controller
{
    public function crearPersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //para validar los formularios
        $request->validate([
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'nombre1' => 'required',
            'nombre2' => 'required',
            'apellido1' => 'required',
            'apellido2' => 'required',
            'estado_persona' => 'required',
            'tipo_persona' => 'required',
            'programa' => 'required',
            'sede' => 'required'
        ]);

        $documento = $request->numero_documento;
        $tipoDoc = $request->tipo_documento;

        //valido el tipo de datos y lo convierto a formato especifico
        if ($tipoDoc == 1) {
            $tipoDocumento = "CC";
        } else {
            $tipoDocumento = "TI";
        }

        $personabyID = Persona::where('numero_documento', $documento)->first();

        if (!$personabyID) {
            try {
                //usaremos transacciones
                DB::beginTransaction();

                $persona =  new Persona();
                $persona->tipo_documento = $tipoDocumento;
                $persona->numero_documento = $request->numero_documento;
                $persona->nombre1 = $request->nombre1;
                $persona->nombre2 = $request->nombre2;
                $persona->apellido1 = $request->apellido1;
                $persona->apellido2 = $request->apellido2;
                $persona->estado_persona = $request->estado_persona;
                $persona->tipo_persona = $request->tipo_persona;
                $persona->programa = $request->programa;
                $persona->sede = $request->sede;
                $persona->save(); //guardamos en la tabla personas

                DB::commit(); //commit de la transaccion
            } catch (Exception $e) {
                DB::rollBack(); //si hay error no ejecute la transaccion
            }
        } else {
            try {
                //usaremos transacciones
                DB::beginTransaction();
                //buscar primero el User a modificar o actualizar
                $persona = Persona::findOrFail($personabyID->id); //envio el Id de la persona encontrada en mi BD a actualizar
                $persona->tipo_documento = $tipoDocumento;
                $persona->numero_documento = $request->numero_documento;
                $persona->nombre1 = $request->nombre1;
                $persona->nombre2 = $request->nombre2;
                $persona->apellido1 = $request->apellido1;
                $persona->apellido2 = $request->apellido2;
                $persona->estado_persona = $request->estado_persona;
                $persona->tipo_persona = $request->tipo_persona;
                $persona->programa = $request->programa;
                $persona->sede = $request->sede;
                $persona->save(); //guardamos en la tabla users con el metodo save en la BD

                DB::commit(); //
            } catch (Exception $e) {
                DB::rollBack(); //si hay error no ejecute la transaccion
            }
        }
    }
}
