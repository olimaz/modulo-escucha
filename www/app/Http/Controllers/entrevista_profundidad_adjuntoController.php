<?php

namespace App\Http\Controllers;


use App\Models\entrevista_profundidad;
use App\Models\entrevista_profundidad_adjunto;
use App\Models\traza_actividad;
use Flash;
use Illuminate\Http\Request;

class entrevista_profundidad_adjuntoController extends Controller
{
    //
    public function quitar(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = entrevista_profundidad_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('entrevista_profundidadController@index'));
        }
        $id_entrevista = $entrevista_adjunto->id_entrevista_profundidad;
        $id_adjunto    = $entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>entrevista_profundidad::find($id_entrevista)->entrevista_codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_entrevista:$id_entrevista"]);

        return response()->json(true);
    }

    //Transcribir con google
    //envía a cola de transcripción
    public function trans($id) {
        $cual=entrevista_profundidad_adjunto::find($id);
        $respuesta = $cual->transcribir();
        return response()->json($respuesta);
    }
    //Revisa la cola de transcripcion
    public function trans_revisar($id) {
        $cual=entrevista_profundidad_adjunto::find($id);
        $respuesta = $cual->transcribir_revisar();
        return response()->json($respuesta);
    }
}
