<?php

namespace App\Http\Controllers;

use App\Models\hecho_responsable;

use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class hecho_responsableController extends Controller
{
    //
    //
    function agregar(Request $request) {
        $valores = $request->all();
        $nuevo = new hecho_responsable();
        $nuevo->fill($valores);
        try {
            $nuevo->save();
        }
        catch(\Exception $e) {
            //no pasa nada, seguro era un duplicado
        }

        //return response()->json($nuevo);
        return $nuevo;
    }
    function quitar($id) {
        $quitar=hecho_responsable::find($id);
        //dd($id);
        if($quitar) {
            $quitar->delete();
        }
        return redirect()->back();

    }
}
