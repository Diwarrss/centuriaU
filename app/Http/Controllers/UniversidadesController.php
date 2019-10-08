<?php

namespace App\Http\Controllers;

use App\Universidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UniversidadesController extends Controller
{
    public function getUniversidad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $universidad = Universidade::all();

        return $universidad;
    }

    public function updateUniversidad(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try {
            //usaremos transacciones
            DB::beginTransaction();

            $request->validate([
                'nombre' => 'required|max:255',
                'siglas' => 'required|max:15',
                'direccion' => 'required|max:200',
                'telefonos' => 'required|max:200',
            ]);
            //buscar primero el id universidad
            $universidad = Universidade::findOrFail($request->id);
            $universidad->nombre = $request->nombre;
            $universidad->siglas = $request->siglas;
            $universidad->direccion = $request->direccion;
            $universidad->telefonos = $request->telefonos;
            $universidad->save(); //guardamos en la tabla universidad

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }



        return $request->all();
    }
    public function updateImagen(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        //Creamos variable qque contendra la imagen
        $imagenFile = $request->imagen;
        $nombreImagen = time() . '.' . $request->imagen->getClientOriginalExtension();
        //la imagen anterior
        $imagenAnterior = $request->imagenAnterior;

        $imagenFile->move(public_path('/storage/'), $nombreImagen);

        //Buscamos la imagen q coincida para borrarla siempre q se actualice
        if (\File::exists(public_path('/'), $imagenAnterior)) { //buscamos la imagen
            \File::delete(public_path('/'), $imagenAnterior); //borrar la imagen

            //tenemos el id de la universidad para actualizar
            $universidad = Universidade::findOrFail($request->idUniversidad);
            $universidad->url_imagen = 'storage/' . $nombreImagen;
            $universidad->save();
        } else {
            $universidad = Universidade::findOrFail($request->idUniversidad);
            $universidad->url_imagen = 'storage/' . $nombreImagen;
            $universidad->save();
        }
        //return $request->all(); //asi mostramos lo q recibimos
    }
}
