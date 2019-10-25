<?php

namespace App\Http\Controllers;

use App\Exports\FormatoExport;
use App\Exports\PersonasExport;
use App\Imports\PersonasImport;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class PersonasController extends Controller
{
    //consultar la persona en mi BD
    public function getPersona(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $numDocumento = $request->documento;

        //para validar los formularios
        $request->validate([
            'documento' => 'required'
        ]);

        $infoPersona = Persona::where('numero_documento', $numDocumento)->get();

        return ['Persona' => $infoPersona];
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
                $persona->periodos_id = $request->id_periodo;
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
                $persona->periodos_id = $request->id_periodo;
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
            'numero_documento' => 'required|max:20',
            'nombre1' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'nombre2' => 'max:50|regex:/^[\pL\s\-]+$/u|nullable',
            'apellido1' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'apellido2' => 'max:50|regex:/^[\pL\s\-]+$/u|nullable',
            'estado_persona' => 'required|max:50',
            'tipo_persona' => 'required|max:100',
            'programa' => 'required|max:255',
            'sede' => 'required|max:100',
            'cargo' => 'max:255',
            'id_periodo' => 'required'
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
            $persona->cargo = $request->cargo;
            $persona->periodos_id = $request->id_periodo;
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
                'numero_documento' => 'required|max:20',
                'nombre1' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'nombre2' => 'max:50|regex:/^[\pL\s\-]+$/u|nullable',
                'apellido1' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
                'apellido2' => 'max:50|regex:/^[\pL\s\-]+$/u|nullable',
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
        //ojo se parametrizo por periodo activo global
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $cantidad = $request->cantidad;

        //cuando hay otros parametros y hacemos or where para solo mostrar esos datos
        $personas = Persona::select(
            'personas.id',
            'personas.tipo_documento',
            'personas.numero_documento',
            'personas.nombre1',
            'personas.nombre2',
            'personas.apellido1',
            'personas.apellido2',
            'personas.estado_persona',
            'personas.tipo_persona',
            'personas.programa',
            'personas.sede',
            'personas.cargo',
            'periodos.nombre'
        )->join('periodos', 'periodos.id', '=', 'personas.periodos_id')
            ->orWhere('personas.tipo_documento', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.numero_documento', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.nombre1', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.nombre2', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.apellido1', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.apellido2', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.estado_persona', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.tipo_persona', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.programa', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.cargo', 'LIKE', '%' . $buscar . '%')
            ->orWhere('periodos.nombre', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.sede', 'LIKE', '%' . $buscar . '%')->paginate($cantidad);

        return $personas;
    }

    //realizar export de excel
    public function exportPersonas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        return Excel::download(new PersonasExport, 'Personas.xlsx');
    }

    //realizar un import de Datos excel
    public function importPersonas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'archivo' => 'required|mimes:xls,xlsx,csv'
        ]);

        $path = $request->file('archivo')->getRealPath();

        $import = new PersonasImport();
        $import->import($path);

        if ($import->errors()) {
            return ['errores' => $import->errors('errorInfo')]; //retornamos los errores si los hay o alertas
        }

        //$import = Excel::import(new PersonasImport, $path);
        //Excel::import(new PersonasImport, $path);
    }

    public function descargarFormato(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //usamos response para descargar el archivo cargado en el servidor
        return response()->download(public_path('/storage/Formato_Personas.xlsx'));

        //este es para usar un archivo creado desde laravel-excel
        /* return Excel::download(new FormatoExport, 'Formato_Personas.xlsx'); */
    }
}
