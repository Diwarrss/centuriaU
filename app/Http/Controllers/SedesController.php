<?php

namespace App\Http\Controllers;

use App\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SedesController extends Controller
{
    public function getSedes(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $sedes_id = Auth::user()->sedes_id;

        if ($sedes_id) {
            $sedes = Sede::where('id', $sedes_id)->get();

            return $sedes;
        } else {
            $sedes = Sede::all();

            return $sedes;
        }
    }
}
