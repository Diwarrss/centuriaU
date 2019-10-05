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
        //if (!$request->ajax()) return redirect('/');

        $userAuth = User::select('id', 'estado_user', 'name', 'roles_id', 'sedes_id')->where('id', Auth::user()->id)->get();

        return $userAuth;
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
            'email' => 'required|max:200|unique:users',
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
        //if (!$request->ajax()) return redirect('/');
        try {
            //usaremos transacciones
            DB::beginTransaction();

            $user = User::findOrFail($request->id);

            $request->validate([
                'nombre' => 'required|max:120',
                'email' => 'required|max:200|unique:users,email,' . $user->id,
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
