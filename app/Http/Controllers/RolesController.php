<?php

namespace App\Http\Controllers;

use App\Role;
use Auth;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function getRoles(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $roles = Role::where('id', '!=', 1)->get();

            return $roles;
        } else {
            $roles = Role::all();

            return $roles;
        }
    }
}
