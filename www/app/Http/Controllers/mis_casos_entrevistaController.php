<?php

namespace App\Http\Controllers;

use App\Models\mis_casos;
use App\Models\mis_casos_entrevista;
use App\Models\traza_actividad;
use Flash;
use Illuminate\Http\Request;

class mis_casos_entrevistaController extends Controller
{
    //Recibe id_mis_casos y un listado de código
    public function agregar(Request $request) {
        $res = mis_casos_entrevista::agregar_entrevistas($request);
        $misCasos = mis_casos::find($request->id_mis_casos);
        if($misCasos) {
            $misCasos->actualizar_nivel_avance();
        }


        if($res->no <> null ) {
            $texto = "No se agregaron algunos códigos de entrevista: $res->no. ";
            Flash::error($texto);
        }
        if($res->si<>null) {
            $texto = "Se agregaron las siguientes entrevistas: $res->si. ";
            Flash::success($texto);
            //Traza de actividad
            traza_actividad::create(['id_objeto'=>16, 'id_accion'=>3, 'codigo'=>$misCasos->entrevista_codigo,'referencia'=>$res->si, 'id_primaria'=>$request->id_mis_casos]);
        }

        //dd($res);
        if($res->id_mis_casos == null) {
            return redirect()->back();
        }
        else {
            $url = action('mis_casosController@show',$res->id_mis_casos);
            return redirect($url."?activar=e");
        }

    }
    //Quitar caso usando la llave primaria
    public function quitar($id) {
        if($id>0) {
            $cual = mis_casos_entrevista::find($id);
            $caso = $cual->rel_id_mis_casos;
            if($caso) {
                $caso->actualizar_nivel_avance();
            }

            if($cual) {
                $url=action('mis_casosController@show',$cual->id_mis_casos)."?activar=e";
                //Traza de actividad
                traza_actividad::create(['id_objeto'=>16, 'id_accion'=>10, 'codigo'=>$caso->entrevista_codigo,'referencia'=>$cual->codigo, 'id_primaria'=>$cual->id_mis_casos]);
                $cual->delete();
                return redirect($url);
            }
            else {
                return redirect()->back();
            }
        }
        else {
            return redirect()->back();
        }

    }
}
