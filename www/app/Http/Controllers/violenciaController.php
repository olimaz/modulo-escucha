<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class violenciaController extends Controller
{
    //Listado de referencia
    public function index(Request $request)
    {
        return view('cev.index');
    }
    //PAra el JSON del control dependiente
    public function mostrar_hijos(Request $request) {

        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\tipo_violencia::json_select($id_padre,$default );
        //return  \App\Models\geo::json_select();
    }

    public function mostrar_hijos_con_todo(Request $request) {
        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\tipo_violencia::json_select($id_padre, $default,"(Mostrar todos)");
    }
}
