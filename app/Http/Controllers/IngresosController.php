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

    //metodo para crear las Personas o Actualizar, crear el ingreso despues de crear las Personas cuando estan en BD UNISANGIL
    public function crearIngreso(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $datos = $request->getContent();
        $jsonDatos = json_decode($datos, true);

        $documentoPersona = $jsonDatos['data'][0]['pege_documentoidentidad'];

        //array para llenar los datos cuando es mayor la data de Unisangil a mi BD
        $arrayNuevos = [];

        if ($jsonDatos) {
            //realizamos una consulta en BD para verificar si ya existe
            $getPersona = Persona::where([['numero_documento', $documentoPersona], ['periodos_id', $request->id_periodo]])->get();
            //creamos el formato json el resultado de la consulta
            $jsonPersonaLocal = json_decode($getPersona, true);

            //si hay datos en la consulta realizada
            if ($jsonPersonaLocal) {
                //comparamos la cantidad de datos si son iguales para realizar el update y registro de ingreso
                if (count($jsonPersonaLocal) == count($jsonDatos['data'])) {
                    //recorremos creando los ingresos deacuerdo al id de cada persona
                    foreach ($jsonPersonaLocal as $a => $value) {
                        //print_r($value['id']);
                        try {
                            //usaremos transacciones
                            DB::beginTransaction();
                            //realizamos un ingreso por cada id obtenido
                            $ingreso = new Ingreso();
                            $ingreso->personas_id = $value['id'];
                            $ingreso->periodos_id = $request->id_periodo;
                            $ingreso->users_id = Auth::user()->id;
                            $ingreso->sedes_id = Auth::user()->sedes_id;
                            $ingreso->save();

                            DB::commit(); //
                        } catch (Exception $e) {
                            DB::rollBack();
                        }
                    }
                } //si son diferentes
                else {
                    //si la data recibida de UNISANGIL es mayor que mi bd crear las personas con cargo DOCENTE y crear ingresos de las encontradas
                    if (count($jsonDatos['data']) > count($jsonPersonaLocal)) {
                        //print_r($jsonDatos['data']);
                        //recorremos creando los ingresos deacuerdo al id de cada persona
                        foreach ($jsonPersonaLocal as $a => $value) {
                            //print_r($value['id']);
                            try {
                                //usaremos transacciones
                                DB::beginTransaction();
                                //realizamos un ingreso por cada id obtenido
                                $ingreso = new Ingreso();
                                $ingreso->personas_id = $value['id'];
                                $ingreso->periodos_id = $request->id_periodo;
                                $ingreso->users_id = Auth::user()->id;
                                $ingreso->sedes_id = Auth::user()->sedes_id;
                                $ingreso->save();

                                DB::commit(); //
                            } catch (Exception $e) {
                                DB::rollBack();
                            }
                        }

                        //recorremos el objeto en busqueda de los datos que se llamen docente
                        foreach ($jsonDatos['data'] as $a => $value1) {
                            if ($value1['cargo'] == 'DOCENTE') {
                                //llenamos el array creado con cada resultado de la iteraccion
                                array_push($arrayNuevos, $value1);
                            }
                        }

                        //print_r(json_encode($arrayNuevos));
                        //la idea es recorrer el objeto que se obtiene anteriormente
                        foreach ($arrayNuevos as $b => $value) {
                            try {
                                //usaremos transacciones
                                DB::beginTransaction();
                                $persona =  new Persona();
                                $persona->tipo_documento = $value['tidg_abreviatura'];
                                $persona->numero_documento = $value['pege_documentoidentidad'];
                                $persona->nombre1 = $value['peng_primernombre'];
                                $persona->nombre2 = $value['peng_segundonombre'];
                                $persona->apellido1 = $value['peng_primerapellido'];
                                $persona->apellido2 = $value['peng_segundoapellido'];
                                $persona->estado_persona = $value['estado'];
                                $persona->tipo_persona = $value['tipo_persona'];
                                $persona->cargo = $value['cargo'];
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
                                DB::commit(); //
                            } catch (Exception $e) {
                                DB::rollBack();
                            }
                        }
                    } else {
                        //recorremos creando los ingresos deacuerdo al id de cada persona
                        foreach ($jsonPersonaLocal as $ab => $value) {
                            //print_r($value['id']);
                            try {
                                //usaremos transacciones
                                DB::beginTransaction();
                                //realizamos un ingreso por cada id obtenido
                                $ingreso = new Ingreso();
                                $ingreso->personas_id = $value['id'];
                                $ingreso->periodos_id = $request->id_periodo;
                                $ingreso->users_id = Auth::user()->id;
                                $ingreso->sedes_id = Auth::user()->sedes_id;
                                $ingreso->save();

                                DB::commit(); //
                            } catch (Exception $e) {
                                DB::rollBack();
                            }
                        }
                        //print_r('Valores de datos UNISANGIL menores que mi BD, Registro creado');
                    }
                }
            }
            //si no estan en la BD Local crea personas y los ingresa
            else {
                try {
                    //usaremos transacciones
                    DB::beginTransaction();
                    //vamos a crear un foreach para guardar y validamos dependiendo del cargo por formato de campos
                    foreach ($jsonDatos['data'] as $key => $value) {
                        $persona =  new Persona();
                        $persona->tipo_documento = $value['tidg_abreviatura'];
                        $persona->numero_documento = $value['pege_documentoidentidad'];
                        $persona->nombre1 = $value['peng_primernombre'];
                        $persona->nombre2 = $value['peng_segundonombre'];
                        $persona->apellido1 = $value['peng_primerapellido'];
                        $persona->apellido2 = $value['peng_segundoapellido'];
                        $persona->estado_persona = $value['estado'];
                        $persona->tipo_persona = $value['tipo_persona'];
                        $persona->cargo = $value['cargo'];
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
                    }
                    DB::commit(); //commit de la transaccion
                } catch (Exception $e) {
                    DB::rollBack(); //si hay error no ejecute la transaccion
                }
            }
        }
    }

    //metodo para crear ingreso de personas que estan en mi BD
    public function crearIngresoBD(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $datos = $request->getContent();
        $jsonDatos = json_decode($datos, true);

        if ($jsonDatos) {
            //dd($jsonDatos['data']);
            //realizamos los ingresos por cada id obtenido
            foreach ($jsonDatos['data'] as $key => $value) {
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
                    'computadores.nombre as nombrePC',
                    DB::raw("GROUP_CONCAT(personas.tipo_persona SEPARATOR '-') as tipo_persona"),
                    DB::raw("GROUP_CONCAT(personas.programa SEPARATOR '-') as programas")
                )
                ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
                ->where('ingresos.sedes_id', $sedes_id)
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                /* ->orWhere('personas.nombre1', 'LIKE', '%' . $buscar . '%')
                ->orWhere('personas.apellido1', 'LIKE', '%' . $buscar . '%')
                ->orWhere('computadores.nombre', 'LIKE', '%' . $buscar . '%') */
                ->orderBy('ingresos.created_at', 'desc')
                ->groupBy('ingresos.created_at')
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
                    'personas.tipo_persona',
                    'prestamos.id as prestamoID',
                    'prestamos.estado_prestamo',
                    'computadores.id as computadorID',
                    'computadores.nombre as nombrePC',
                    DB::raw("GROUP_CONCAT(personas.tipo_persona SEPARATOR '-') as tipo_persona"),
                    DB::raw("GROUP_CONCAT(personas.programa SEPARATOR '-') as programas")
                )
                ->where('ingresos.created_at', 'like', '%' . $fechahoy . '%')
                ->where('personas.numero_documento', 'LIKE', '%' . $buscar . '%')
                ->where('personas.' . $criterio, 'LIKE', '%' . $buscar . '%')
                ->orderBy('ingresos.created_at', 'desc')
                ->groupBy('ingresos.created_at')
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
