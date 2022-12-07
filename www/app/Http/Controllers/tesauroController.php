<?php

namespace App\Http\Controllers;

use App\Models\entrevista_individual;
use App\Models\etiqueta_entrevista;
use App\Models\tesauro;
use Illuminate\Http\Request;

class tesauroController extends Controller
{
    //PAra el JSON del control dependiente
    public function mostrar_hijos(Request $request) {
        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\tesauro::json_select($id_padre,$default);
        //return  \App\Models\geo::json_select();
    }

    //Permitir agregar otro en el tercer nivel
    public function mostrar_hijos_otro_cual(Request $request) {
        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\tesauro::json_select($id_padre,$default,"",true);
        //return  \App\Models\geo::json_select();
    }

    public function mostrar_hijos_con_todo(Request $request) {
        $id_padre = isset($request->depdrop_parents[0]) ? $request->depdrop_parents[0] : 0 ;
        $default = isset($request->depdrop_params[0]) ? $request->depdrop_params[0] : 0;
        return  \App\Models\tesauro::json_select($id_padre,$default,"(Mostrar todos)");
    }

    public function reporte_completo(Request $request) {
        $txt_titulo = "Tesauro";
        $tesauro = tesauro::estructura_completa();
        // Incluir gráfica
        $quitar_entidades = isset($request->quitar_entidades);
        $json_datos = json_encode(etiqueta_entrevista::json_jerarquico($quitar_entidades));
        $quitar = isset($request->quitar) ? $request->quitar : '';
        $poner = isset($request->poner) ? $request->poner : '';

        return view('tesauro.completo',compact('tesauro','txt_titulo',"json_datos","quitar_entidades",'quitar','poner'));
    }
    public function reporte_comparativo(Request $request) {
        $filtros = entrevista_individual::filtros_default($request);
        $txt_titulo = "Tesauro - comparación";

        $conteos = tesauro::conteo_comparado($filtros);
        $tesauro = tesauro::estructura_completa_comparada($conteos);
        // Incluir gráfica
        //$quitar_entidades = isset($request->quitar_entidades);
        $json_datos = json_encode(etiqueta_entrevista::json_jerarquico_comparado(true,$conteos));

        return view('tesauro.comparativo',compact('txt_titulo','tesauro',"json_datos","filtros"));
    }
}
