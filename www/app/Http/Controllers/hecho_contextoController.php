<?php

namespace App\Http\Controllers;

use App\Models\hecho_contexto;
use Illuminate\Http\Request;

class hecho_contextoController extends Controller
{
    //
    public function grabar(Request $request) {
        if(isset($request->id_hecho)) {
            $id_hecho = $request->id_hecho;
            hecho_contexto::where('id_hecho', $id_hecho)->delete();
            if(is_array($request->id_contexto)) {
                foreach ($request->id_contexto as $id_contexto) {
                    if($id_contexto > 0) {
                        $nuevo = new hecho_contexto();
                        $nuevo->id_hecho = $id_hecho;
                        $nuevo->id_contexto = $id_contexto;
                        $nuevo->save();
                    }
                }
            }
        }
        return redirect()->back();
    }

}

