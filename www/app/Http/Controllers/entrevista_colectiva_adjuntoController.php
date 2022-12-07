<?php

namespace App\Http\Controllers;

use App\Models\entrevista_colectiva;
use App\Models\entrevista_colectiva_adjunto;
use App\Models\entrevista_individual;
use App\Models\entrevista_individual_adjunto;
use App\Models\traza_actividad;
use Flash;
use Illuminate\Http\Request;

class entrevista_colectiva_adjuntoController extends Controller
{
    //
    public function quitar(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = entrevista_colectiva_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('entrevista_colectivaController@index'));
        }
        $id_entrevista = $entrevista_adjunto->id_entrevista_colectiva;
        $id_adjunto    = $entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>entrevista_colectiva::find($id_entrevista)->entrevista_codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_entrevista:$id_entrevista"]);


        return response()->json(true);
    }

}
