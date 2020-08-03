<?php

namespace App\Http\Controllers;

use App\CenturiaBdAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CenturiaBdAccessController extends Controller
{
  public function create(Request $request){
    if (!$request->ajax()) return redirect('/');
    try {
      DB::beginTransaction();

      $data = $request->all();
      $bdAccess = CenturiaBdAccess::create($data);

      DB::commit(); //commit de la transaccion

      if ($bdAccess) {
        return response()->json([
          'type' => 'success',
          'message' => 'Creado con éxito',
          'data' => $bdAccess
        ], 201);
      }else{
        return response()->json([
          'type' => 'error',
          'message' => 'Error al guardar',
          'data' => []
        ], 204);
      }
    } catch (Exception $e) {
      return response()->json([
        'type' => 'error',
        'message' => 'Error al guardar',
        'data' => []
      ], 204);
      DB::rollBack(); //si hay error no ejecute la transaccion
    }
  }
}
