<?php

namespace App\Http\Controllers;

use App\Models\adjunto;
use App\Models\mis_casos_adjunto;
use App\Models\traza_actividad;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class mis_casos_adjuntoController extends Controller
{
    //
    public function edit($id_mis_casos_adjunto) {
        $adjuntado = mis_casos_adjunto::find($id_mis_casos_adjunto);
        $miCaso = $adjuntado->rel_id_mis_casos;
        return view("mis_casos.editar_adjunto",compact('adjuntado','miCaso'));
    }

    public function update($id_mis_casos_adjunto, Request $request) {
        $adjuntado = mis_casos_adjunto::find($id_mis_casos_adjunto);
        if(!$adjuntado) {
            Flash::error("No existe el adjuntado $id_mis_casos_adjunto");
            return redirect()->back();
        }

        $input = $request->all();
        $archivo = str_replace("/storage/","/",$request->archivo_4_filename);  //Quitar /storage/ al inicio que pone el contro
        $existe = adjunto::where('ubicacion',$archivo)->first();
        if(!$existe) {
            //dd($request);
            $nombre = $request->file('archivo_4')->getClientOriginalName();
            $input['id_adjunto'] = adjunto::crear_adjunto($request->archivo_4_filename,$nombre);
        }
        //Por si acaso
        unset($input['id_mis_casos_adjunto']);
        unset($input['id_mis_casos']);
        //Actualizar la BD
        $adjuntado->fill($input);
        $adjuntado->save();
        $descripcion = $adjuntado->descripcion;

        $caso = $adjuntado->rel_id_mis_casos;
        $caso->actualizar_nivel_avance();
        traza_actividad::create(['id_objeto'=>20, 'id_accion'=>4, 'codigo'=>$caso->entrevista_codigo, 'id_primaria'=>$caso->id_mis_casos, 'referencia'=>"id_adjunto=$existe->id_adjunto. $descripcion"]);
        //$url=action("mis_casosController@show",$adjuntado->id_mis_casos);
        //Flash::message('Archivo anexado exitosamente');
        $url = action("mis_casosController@show",$adjuntado->id_mis_casos)."?activar=s$adjuntado->id_seccion";

        return redirect($url);
    }

}
