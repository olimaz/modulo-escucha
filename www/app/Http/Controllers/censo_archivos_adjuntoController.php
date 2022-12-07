<?php

namespace App\Http\Controllers;

use App\Models\adjunto;
use App\Models\censo_archivos_adjunto;
use App\Models\mis_casos_adjunto;
use App\Models\traza_actividad;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class censo_archivos_adjuntoController extends Controller
{
    //
    public function edit($id) {
        $adjuntado = censo_archivos_adjunto::find($id);
        $censoArchivo = $adjuntado->rel_id_censo_archivos;
        //dd($adjuntado);
        return view("censo_archivos.editar_adjunto",compact('adjuntado','censoArchivo'));
    }

    public function update($id_censo_archivos_adjunto, Request $request) {
        $adjuntado = censo_archivos_adjunto::find($id_censo_archivos_adjunto);
        if(!$adjuntado) {
            Flash::error("No existe el adjuntado $id_censo_archivos_adjunto");
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

        //Actualizar la BD
        $adjuntado->fill($input);
        $adjuntado->save();
        $descripcion = $adjuntado->descripcion;

        $e = $adjuntado->rel_id_censo_archivos;

        traza_actividad::create(['id_objeto'=>26, 'id_accion'=>4, 'codigo'=>$e->entrevista_codigo, 'id_primaria'=>$e->id_censo_archivos, 'referencia'=>"id_adjunto=$adjuntado->id_adjunto. $descripcion"]);
        //$url=action("mis_casosController@show",$adjuntado->id_mis_casos);
        //Flash::message('Archivo anexado exitosamente');
        $url = action("censo_archivosController@show",$adjuntado->id_censo_archivos)."?activar=a";

        return redirect($url);
    }
}
