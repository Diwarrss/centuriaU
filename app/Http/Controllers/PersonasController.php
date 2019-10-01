<?php

namespace App\Http\Controllers;

use App\Persona;
use Faker\Provider\ro_MD\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonasController extends Controller
{
    public function getPersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $numDocumento = $request->id;

        $personabyID = Persona::where('numero_documento', $numDocumento)->get();

        return $personabyID;
    }

    public function crearPersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //para validar los formularios
        $request->validate([
            'tipo_documento' => 'required',
            'numero_documento' => 'required',
            'nombre1' => 'required',
            'apellido1' => 'required',
            'programa' => 'required',
            'sede' => 'required'
        ]);

        $documento = $request->numero_documento;
        $tipoDoc = $request->tipo_documento;
        $tipo_persona = $request->tipo_persona;
        $estado_persona = $request->estado_persona;
        $maac_estado = $request->maac_estado;

        //valido el tipo de datos y lo convierto a formato especifico
        if ($tipoDoc == 1) {
            $tipoDocumento = "CC";
        } else {
            $tipoDocumento = "TI";
        }

        //cambiamos el valor de tipo persona dependiendo del q aparezca
        if ($estado_persona == 'Inactivo' && $maac_estado == null) {
            $tipo_persona = 'Estudiante';
            $estado_persona = 'Inactivo';
        } else if ($maac_estado == null && $tipo_persona != 'CONTINUIDAD ACADEMICA - EGRESADO') {
            $estado_persona = 'Inactivo';
            $tipo_persona = 'Estudiante';
        } else if ($tipo_persona == 'CONTINUIDAD ACADEMICA - EGRESADO') {
            $estado_persona = 'Activo';
            $tipo_persona = 'Egresado';
        } else {
            $estado_persona = 'Activo';
            $tipo_persona = 'Estudiante';
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
                $persona->estado_persona = $estado_persona;
                $persona->tipo_persona = $tipo_persona;
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
                $persona->estado_persona = $estado_persona;
                $persona->tipo_persona = $tipo_persona;
                $persona->programa = $request->programa;
                $persona->sede = $request->sede;
                $persona->save(); //guardamos en la tabla users con el metodo save en la BD

                DB::commit(); //
            } catch (Exception $e) {
                DB::rollBack(); //si hay error no ejecute la transaccion
            }
        }
    }

    public function savePersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $request->validate([
            'tipo_documento' => 'required|max:6',
            'numero_documento' => 'required|unique:personas|max:20',
            'nombre1' => 'required|max:50',
            'apellido1' => 'required|max:50',
            'estado_persona' => 'required|max:50',
            'tipo_persona' => 'required|max:100',
            'programa' => 'required|max:255',
            'sede' => 'required|max:100'
        ]);
        try {
            //usaremos transacciones
            DB::beginTransaction();

            $persona =  new Persona();
            $persona->tipo_documento = $request->tipo_documento;
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
    }

    public function updatePersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            //usaremos transacciones
            DB::beginTransaction();
            //buscar primero el Persona a modificar
            $persona = Persona::findOrFail($request->id);

            $request->validate([
                'tipo_documento' => 'required|max:6',
                'numero_documento' => 'required|max:20|string|unique:personas,numero_documento,' . $persona->id,
                'nombre1' => 'required|max:50',
                'apellido1' => 'required|max:50',
                'estado_persona' => 'required|max:50',
                'tipo_persona' => 'required|max:100',
                'programa' => 'required|max:255',
                'sede' => 'required|max:100'
            ]);

            $persona->tipo_documento = $request->tipo_documento;
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
    }

    public function getPersonas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $id = $request->id;
        $buscar = $request->buscar;
        if ($id) {
            $personasid = Persona::select(
                'id',
                'tipo_documento',
                'numero_documento',
                'nombre1',
                'nombre2',
                'apellido1',
                'apellido2',
                'estado_persona',
                'tipo_persona',
                'programa',
                'sede'
            )->where('id', $id)->get();

            return $personasid;
        } else {
            //cuando hay otros parametros y hacemos or where para solo mostrar esos datos
            $personas = Persona::select(
                'id',
                'tipo_documento',
                'numero_documento',
                'nombre1',
                'nombre2',
                'apellido1',
                'apellido2',
                'estado_persona',
                'tipo_persona',
                'programa',
                'sede'
            )->orWhere('id', 'LIKE', '%' . $buscar . '%')
                ->orWhere('tipo_documento', 'LIKE', '%' . $buscar . '%')
                ->orWhere('numero_documento', 'LIKE', '%' . $buscar . '%')
                ->orWhere('nombre1', 'LIKE', '%' . $buscar . '%')
                ->orWhere('nombre2', 'LIKE', '%' . $buscar . '%')
                ->orWhere('apellido1', 'LIKE', '%' . $buscar . '%')
                ->orWhere('apellido2', 'LIKE', '%' . $buscar . '%')
                ->orWhere('estado_persona', 'LIKE', '%' . $buscar . '%')
                ->orWhere('tipo_persona', 'LIKE', '%' . $buscar . '%')
                ->orWhere('programa', 'LIKE', '%' . $buscar . '%')
                ->orWhere('sede', 'LIKE', '%' . $buscar . '%')->paginate(8);

            return $personas;
        }
    }
}
