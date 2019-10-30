<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getUserAuth(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $userAuth = User::select('id', 'estado_user', 'name', 'url_imagen', 'roles_id', 'sedes_id')->where('id', Auth::user()->id)->get();

        return $userAuth;
    }

    public function getPerfil(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $perfil = User::join('roles', 'roles.id', '=', 'users.roles_id')
            ->leftJoin('sedes', 'sedes.id', '=', 'users.sedes_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.updated_at as actualizado',
                'users.url_imagen',
                'users.estado_user',
                'roles.nombre as nombreRol',
                'sedes.nombre as nombreSede'
            )
            ->where('users.id', Auth::user()->id)->get();

        return $perfil;
    }

    public function updatePerfil(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            //usaremos transacciones
            DB::beginTransaction();

            $user = User::findOrFail($request->id);

            $request->validate([
                'nombre' => 'required|max:120',
                'email' => 'email|required|max:200|unique:users,email,' . $user->id,
            ]);

            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function updateAvatar(Request $request)
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

            //tenemos el id de la user para actualizar
            $user = User::findOrFail($request->id);
            $user->url_imagen = 'storage/' . $nombreImagen;
            $user->save();
        } else {
            $user = User::findOrFail($request->id);
            $user->url_imagen = 'storage/' . $nombreImagen;
            $user->save();
        }
        //return $request->all(); //asi mostramos lo q recibimos
    }

    public function updatePass(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $request->validate([
            'password' => ['required', 'string', 'max:255', 'min:8'],
            'passwordV' => ['required', 'string', 'max:255', 'min:8']
        ]);

        $pass = User::findOrFail($request->id);
        $pass->password =  Hash::make($request->password);
        $pass->save();
    }

    public function getUsers(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $cantidad = $request->cantidad;
        $criterio = $request->criterio;
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $users = User::leftJoin('sedes',  'sedes.id', '=', 'users.sedes_id')
                ->join('roles', 'roles.id', '=', 'users.roles_id')
                ->select(
                    'users.id',
                    'users.sedes_id',
                    'users.roles_id',
                    'users.name',
                    'users.email',
                    'users.estado_user',
                    'users.created_at',
                    'roles.nombre as nombreRol',
                    'sedes.nombre as nombreSede'
                )
                ->where('users.sedes_id', $sedes_id)
                ->where('users.' . $criterio, 'LIKE', '%' . $buscar . '%')
                ->paginate($cantidad);
            return $users;
        } else {
            $users = User::leftJoin('sedes',  'sedes.id', '=', 'users.sedes_id')
                ->join('roles', 'roles.id', '=', 'users.roles_id')
                ->select(
                    'users.id',
                    'users.sedes_id',
                    'users.roles_id',
                    'users.name',
                    'users.email',
                    'users.estado_user',
                    'users.created_at',
                    'roles.nombre as nombreRol',
                    'sedes.nombre as nombreSede'
                )
                ->where('users.' . $criterio, 'LIKE', '%' . $buscar . '%')->paginate($cantidad);
            return $users;
        }
    }

    public function saveUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $request->validate([
            'nombre' => 'required|max:120',
            'email' => 'email|required|max:200|unique:users',
            'password' => 'required|min:8|max:200',
            'verificacion' => 'required|min:8|max:200',
            'estado' => 'required',
            'rol' => 'required',
            'sede' => 'required',
        ]);

        try {
            //usaremos transacciones
            DB::beginTransaction();

            $user =  new User();
            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->estado_user = $request->estado;
            $user->roles_id = $request->rol;
            $user->sedes_id = $request->sede;
            $user->save(); //guardamos en la tabla users

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }

    public function updateUser(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            //usaremos transacciones
            DB::beginTransaction();

            $user = User::findOrFail($request->id);

            $request->validate([
                'nombre' => 'required|max:120',
                'email' => 'email|required|max:200|unique:users,email,' . $user->id,
                'password' => 'max:200',
                'verificacion' => 'max:200',
                'estado' => 'required',
                'rol' => 'required',
                'sede' => 'required',
            ]);

            $user->name = $request->nombre;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->estado_user = $request->estado;
            $user->roles_id = $request->rol;
            $user->sedes_id = $request->sede;
            $user->save();

            DB::commit(); //commit de la transaccion
        } catch (Exception $e) {
            DB::rollBack(); //si hay error no ejecute la transaccion
        }
    }
}
