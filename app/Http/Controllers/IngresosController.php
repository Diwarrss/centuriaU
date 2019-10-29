<?php

namespace App\Http\Controllers;

use App\Ingreso;
use App\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IngresosController extends Controller
{
    /* public function crearIngreso(Request $request)
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
    } */

    //metodo para crear las Personas o Actualizar, crear el ingreso despues de crear las Personas
    public function crearIngreso(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $datos = $request->getContent();
        $jsonDatos = json_decode($datos, true);

        $documentoPersona = $jsonDatos['data'][0]['pege_documentoidentidad'];
        $documentoPersona = $jsonDatos['arrayPersona'][0]['numero_documento'];

        if ($jsonDatos) {
            //dd($jsonDatos['data'][0]['pege_documentoidentidad']);
            //realizamos una consulta en BD para verificar si ya existe
            $getPersona = Persona::where('numero_documento', $documentoPersona)->get();
            //creamos el formato json el resultado de la consulta
            $jsonPersona = json_decode($getPersona, true);

            if ($jsonPersona) {
                dd($jsonDatos['data']);
                //comparamos la cantidad de datos si son iguales para realizar el update
                if (count($jsonPersona) == count($jsonDatos['data'])) {
                    //dd($jsonDatos['data']);
                    //realizaremos las transacciones respectivas
                    /* try {
                        //usaremos transacciones
                        DB::beginTransaction();
                        //recorremos el array y actualizamos por id encontrado
                        foreach ($jsonPersona as $a => $value) {
                            //realizamos validacion dependiendo de tipo_persona
                            if ($value['tipo_persona'] == 'Estudiante') {
                                //buscar primero el User a modificar o actualizar
                                $persona = Persona::findOrFail($value['id']); //envio el Id de la persona encontrada en mi BD a actualizar
                                //recorremos el array de los datos recibidos de la otra BD
                                foreach ($jsonDatos['data'] as $b => $valueD) {
                                    if ($valueD['cargo'] == 'ESTUDIANTE') {
                                        $persona->tipo_documento = $valueD['tidg_abreviatura'];
                                        $persona->numero_documento = $valueD['pege_documentoidentidad'];
                                        $persona->nombre1 = $valueD['peng_primernombre'];
                                        $persona->nombre2 = $valueD['peng_segundonombre'];
                                        $persona->apellido1 = $valueD['peng_primerapellido'];
                                        $persona->apellido2 = $valueD['peng_segundoapellido'];
                                        $persona->estado_persona = $valueD['estadoestudiante'];
                                        $persona->tipo_persona = 'Estudiante';
                                        $persona->programa = $valueD['programa'];
                                        $persona->sede = $valueD['ciudad'];
                                        $persona->save();
                                    }
                                }
                            } else {
                                //si no es estudiante realizamos la siguiente sentecia igual q la anterior con parametros diferentes
                                $persona = Persona::findOrFail($value['id']);

                                foreach ($jsonDatos['data'] as $b => $valueD) {
                                    if ($valueD['cargo'] != 'ESTUDIANTE') {
                                        $persona->tipo_documento = $valueD['tidg_abreviatura'];
                                        $persona->numero_documento = $valueD['pege_documentoidentidad'];
                                        $persona->nombre1 = $valueD['peng_primernombre'];
                                        $persona->nombre2 = $valueD['peng_segundonombre'];
                                        $persona->apellido1 = $valueD['peng_primerapellido'];
                                        $persona->apellido2 = $valueD['peng_segundoapellido'];
                                        $persona->estado_persona = $valueD['estado'];
                                        $persona->tipo_persona = 'Administrativo';
                                        $persona->programa = $valueD['programa'];
                                        $persona->sede = $valueD['ciudad'];
                                        $persona->cargo = $valueD['cargo'];
                                        $persona->save();
                                    }
                                }
                            }
                        }
                        DB::commit(); //
                    } catch (Exception $e) {
                        DB::rollBack(); //si hay error no ejecute la transaccion
                    } */

                    /* //Primero actualizar los datos
                    foreach ($jsonPersona as $a => $valueP) {
                        foreach ($jsonDatos['data'] as $b => $valueD) {

                            if ($valueD['tidg_abreviatura'] == $valueP['tipo_documento'] && $valueD['pege_documentoidentidad'] == $valueP['numero_documento'] && $valueD['peng_primerapellido'] == $valueP['apellido1'] && $valueD['peng_segundoapellido'] == $valueP['apellido2'] && $valueD['peng_primernombre'] == $valueP['nombre1'] && $valueD['peng_segundonombre'] == $valueP['nombre2'] && $valueD['estado'] == $valueP['estado_persona'] && $valueD['cargo'] == $valueP['cargo'] && $valueD['ciudad'] == $valueP['sede'] && $valueD['programa'] == $valueP['programa']) {
                                # code...
                            } else {
                                # code...
                            }
                        }
                    } */
                    //realizamos un ingresos por cada id obtenido
                    foreach ($jsonPersona as $key => $value) {
                        try {
                            //usaremos transacciones
                            DB::beginTransaction();
                            //creamos el Ingreso al crear la persona
                            $ingreso = new Ingreso();
                            $ingreso->personas_id = $value['id'];
                            $ingreso->periodos_id = $request->id_periodo;
                            $ingreso->users_id = Auth::user()->id;
                            $ingreso->sedes_id = Auth::user()->sedes_id;
                            $ingreso->save();

                            DB::commit(); //commit de la transaccion
                        } catch (Exception $e) {
                            DB::rollBack(); //si hay error no ejecute la transaccion
                        }
                    }
                } else {

                    dd('No coinciden los valores');
                }
                //dd(count($jsonPersona) . ' ' . count($jsonDatos['data']));
            } else {
                try {
                    //usaremos transacciones
                    DB::beginTransaction();
                    //vamos a crear un foreach para guardar y validamos dependiendo del cargo por formato de campos
                    foreach ($jsonDatos['data'] as $key => $value) {
                        if ($value['cargo'] == 'ESTUDIANTE') {
                            $persona =  new Persona();
                            $persona->tipo_documento = $value['tidg_abreviatura'];
                            $persona->numero_documento = $value['pege_documentoidentidad'];
                            $persona->nombre1 = $value['peng_primernombre'];
                            $persona->nombre2 = $value['peng_segundonombre'];
                            $persona->apellido1 = $value['peng_primerapellido'];
                            $persona->apellido2 = $value['peng_segundoapellido'];
                            $persona->estado_persona = $value['estadoestudiante'];
                            $persona->tipo_persona = 'Estudiante';
                            $persona->programa = $value['programa'];
                            $persona->sede = $value['ciudad'];
                            $persona->periodos_id = $request->id_periodo;
                            $persona->registroComo = '2';
                            $persona->save();

                            //creamos el Ingreso al crear la persona
                            $ingreso = new Ingreso();
                            $ingreso->personas_id = $persona->id;
                            $ingreso->periodos_id = $request->id_periodo;
                            $ingreso->users_id = Auth::user()->id;
                            $ingreso->sedes_id = Auth::user()->sedes_id;
                            $ingreso->save();
                        } else {
                            $persona =  new Persona();
                            $persona->tipo_documento = $value['tidg_abreviatura'];
                            $persona->numero_documento = $value['pege_documentoidentidad'];
                            $persona->nombre1 = $value['peng_primernombre'];
                            $persona->nombre2 = $value['peng_segundonombre'];
                            $persona->apellido1 = $value['peng_primerapellido'];
                            $persona->apellido2 = $value['peng_segundoapellido'];
                            $persona->estado_persona = $value['estado'];
                            $persona->tipo_persona = 'Administrativo';
                            $persona->programa = $value['programa'];
                            $persona->sede = $value['ciudad'];
                            $persona->cargo = $value['cargo'];
                            $persona->periodos_id = $request->id_periodo;
                            $persona->registroComo = '2';
                            $persona->save();

                            //creamos el ingreso al crear la persona en la bd
                            $ingreso = new Ingreso();
                            $ingreso->personas_id = $persona->id;
                            $ingreso->periodos_id = $request->id_periodo;
                            $ingreso->users_id = Auth::user()->id;
                            $ingreso->sedes_id = Auth::user()->sedes_id;
                            $ingreso->save();
                        }
                    }
                    DB::commit(); //commit de la transaccion
                } catch (Exception $e) {
                    DB::rollBack(); //si hay error no ejecute la transaccion
                }
            }
        }
    }
    public function getIngresosActuales(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $fechahoy = Carbon::now()->format('Y-m-d');
        $buscar = $request->buscar;
        $cantidad = $request->cantidad;
        $criterio = $request->criterio;
        $sedes_id = Auth::user()->sedes_id; //optenemos el id de la sede del user logueado

        if ($sedes_id) {
            $ingresosActuales = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->leftJoin('prestamos', 'ingresos.id', '=', 'prestamos.ingresos_id')
                ->leftJoin('computadores', 'prestamos.computadores_id', '=', 'computadores.id')
                ->select(
                    'ingresos.created_at',
                    'personas.id as personaID',
                    'ingresos.id as ingresosID',
                    'ingresos.sedes_id as ingresosSede',
                    'personas.tipo_documento',
                    'personas.numero_documento',
                    'personas.nombre1',
                    'personas.nombre2',
                    'personas.apellido1',
                    'personas.apellido2',
                    'prestamos.id as prestamoID',
                    'prestamos.estado_prestamo',
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC'
                )
                ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
                ->where('ingresos.sedes_id', $sedes_id)
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                /* ->orWhere('personas.nombre1', 'LIKE', '%' . $buscar . '%')
                ->orWhere('personas.apellido1', 'LIKE', '%' . $buscar . '%')
                ->orWhere('computadores.nombre', 'LIKE', '%' . $buscar . '%') */
                ->orderBy('ingresos.created_at', 'desc')
                ->paginate($cantidad);

            return $ingresosActuales;
        } else {
            $ingresosActuales = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->leftJoin('prestamos', 'ingresos.id', '=', 'prestamos.ingresos_id')
                ->leftJoin('computadores', 'prestamos.computadores_id', '=', 'computadores.id')
                ->select(
                    'ingresos.created_at',
                    'personas.id as personaID',
                    'ingresos.id as ingresosID',
                    'personas.tipo_documento',
                    'personas.numero_documento',
                    'personas.nombre1',
                    'personas.nombre2',
                    'personas.apellido1',
                    'personas.apellido2',
                    'prestamos.id as prestamoID',
                    'prestamos.estado_prestamo',
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC'
                )
                ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
                ->where('personas.numero_documento', 'LIKE', '%' . $buscar . '%')
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                ->orderBy('ingresos.created_at', 'desc')
                ->paginate($cantidad);

            return $ingresosActuales;
        }
    }

    public function getIngresos(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $cantidad = $request->cantidad;
        $criterio = $request->criterio;
        $sedes_id = Auth::user()->sedes_id; //optenemos el id de la sede del user logueado

        if ($sedes_id) {
            $ingresos = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                ->leftJoin('prestamos', 'ingresos.id', '=', 'prestamos.ingresos_id')
                ->leftJoin('computadores', 'prestamos.computadores_id', '=', 'computadores.id')
                ->select(
                    'ingresos.created_at',
                    'personas.id as personaID',
                    'ingresos.id as ingresosID',
                    'personas.tipo_documento',
                    'personas.numero_documento',
                    'personas.nombre1',
                    'personas.nombre2',
                    'personas.apellido1',
                    'personas.apellido2',
                    'personas.programa',
                    'prestamos.id as prestamoID',
                    'prestamos.estado_prestamo',
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC',
                    'sedes.nombre as nombre_sede'
                )
                ->where('ingresos.sedes_id', $sedes_id)
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                /* ->orWhere('personas.nombre1', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.apellido1', 'LIKE', '%' . $buscar . '%')
            ->orWhere('computadores.nombre', 'LIKE', '%' . $buscar . '%') */
                ->orderBy('ingresos.id', 'asc')
                ->paginate($cantidad);

            return $ingresos;
        } else {
            $ingresos = Ingreso::join('personas', 'personas.id', '=', 'ingresos.personas_id')
                ->join('sedes', 'sedes.id', '=', 'ingresos.sedes_id')
                ->leftJoin('prestamos', 'ingresos.id', '=', 'prestamos.ingresos_id')
                ->leftJoin('computadores', 'prestamos.computadores_id', '=', 'computadores.id')
                ->select(
                    'ingresos.created_at',
                    'personas.id as personaID',
                    'ingresos.id as ingresosID',
                    'personas.tipo_documento',
                    'personas.numero_documento',
                    'personas.nombre1',
                    'personas.nombre2',
                    'personas.apellido1',
                    'personas.apellido2',
                    'personas.programa',
                    'prestamos.id as prestamoID',
                    'prestamos.estado_prestamo',
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC',
                    'sedes.nombre as nombre_sede'
                )
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                /* ->orWhere('personas.nombre1', 'LIKE', '%' . $buscar . '%')
            ->orWhere('personas.apellido1', 'LIKE', '%' . $buscar . '%')
            ->orWhere('computadores.nombre', 'LIKE', '%' . $buscar . '%') */
                ->orderBy('ingresos.id', 'asc')
                ->paginate($cantidad);

            return $ingresos;
        }
    }
}
