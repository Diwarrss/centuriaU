<?php

namespace App\Http\Controllers;

use App\Sede;
use Illuminate\Http\Request;

class SedesController extends Controller
{
    public function getSedes(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        $sedes = Sede::all();

        return $sedes;
    }
}
