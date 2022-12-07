<?php

namespace App\Http\Controllers;

use App\Models\diagnostico_comunitario;
use App\Models\diagnostico_comunitario_adjunto;
use App\Models\traza_actividad;
use Illuminate\Http\Request;
use Flash;

class diagnostico_comunitario_adjuntoController extends Controller
{
    //
    public function quitar(Request $request)
    {
        $id=$request->id;
        $entrevista_adjunto = diagnostico_comunitario_adjunto::find($id);
        if (empty($entrevista_adjunto)) {
            Flash::error('Adjunto no existe');
            return redirect(action('diagnostico_comunitarioController@index'));
        }
        $id_entrevista = $entrevista_adjunto->id_diagnostico_comunitario;
        $id_adjunto    = $entrevista_adjunto->id_adjunto;

        $entrevista_adjunto->delete();

        Flash::success('Archivo adjunto eliminado.');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>diagnostico_comunitario::find($id_entrevista)->entrevista_codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_entrevista:$id_entrevista"]);

        return response()->json(true);
    }
}
