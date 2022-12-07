<?php

namespace App\Http\Controllers;

use App\Models\entrevista_profundidad;
use App\Models\entrevista_profundidad_adjunto;
use App\Models\historia_vida;
use App\Models\historia_vida_adjunto;
use App\Models\traza_actividad;
use Flash;
use Illuminate\Http\Request;

class historia_vida_adjuntoController extends Controller
{
    //
    public function quitar(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = historia_vida_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('historia_vidaController@index'));
        }
        $id_entrevista = $entrevista_adjunto->id_historia_vida;
        $id_adjunto    = $entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>historia_vida::find($id_entrevista)->entrevista_codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_entrevista:$id_entrevista"]);

        return response()->json(true);
    }
}
