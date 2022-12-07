<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmis_casosRequest;
use App\Models\mis_casos;
use App\Models\mis_casos_tareas;
use App\Models\traza_actividad;
use Flash;
use Illuminate\Http\Request;

class mis_casos_tareasController extends Controller
{
    //
    public function store(Request $request) {
        $tarea = new mis_casos_tareas();
        $tarea->realizado=2;
        $tarea->descripcion = $request->descripcion;
        $tarea->id_mis_casos = $request->id_mis_casos;
        $tarea->save();
        //Registrar traza
        $entrevista = $tarea->rel_id_mis_casos;
        traza_actividad::create(['id_objeto'=>18, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$tarea->id_mis_casos_tareas]);
        $url=action('mis_casosController@show',$tarea->id_mis_casos);
        $url.="?activar=t";
        return redirect($url);
    }
    public function update($id, Request $request) {
        //dd($request->realizado);
        $tarea = mis_casos_tareas::find($id);
        if($tarea) {
            $tarea->realizado = isset($request->realizado) ? 1 : 2;
            $tarea->save();
            $entrevista = $tarea->rel_id_mis_casos;
            traza_actividad::create(['id_objeto'=>18, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$tarea->id_mis_casos_tareas]);
        }
        $url=action('mis_casosController@show',$tarea->id_mis_casos);
        $url.="?activar=t";
        return redirect($url);
        //return redirect()->back();
    }
    public function destroy($id) {
        $tarea = mis_casos_tareas::find($id);
        if($tarea) {
            $tarea->id_activo = 2; //softdelete
            $tarea->save();
            $entrevista = $tarea->rel_id_mis_casos;
            traza_actividad::create(['id_objeto'=>18, 'id_accion'=>10, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$tarea->id_mis_casos_tareas]);
        }
        $url=action('mis_casosController@show',$tarea->id_mis_casos);
        $url.="?activar=t";
        return redirect($url);
    }
}
