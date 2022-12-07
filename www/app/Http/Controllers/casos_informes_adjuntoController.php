<?php

namespace App\Http\Controllers;

use App\Models\casos_informes;
use App\Models\casos_informes_adjunto;
use App\Models\traza_actividad;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class casos_informes_adjuntoController extends Controller
{
    //
    public function destroy($id)
    {
        $adjunto = casos_informes_adjunto::find($id);
        $id_caso = $adjunto->id_casos_informes;
        $id_adjunto=$adjunto->id_adjunto;

        if (empty($adjunto)) {
            Flash::error('Adjunto not found');
            return redirect(action('casos_informesController@gestionar_adjuntos',$id_caso));
        }

        $adjunto->delete();

        Flash::success('Adjunto eliminado');
        traza_actividad::create(['id_objeto'=>2, 'id_accion'=>10, 'codigo'=>casos_informes::find($id_caso)->codigo, 'id_primaria'=>$id_adjunto,'referencia'=>"id_caso_informe:$id_caso"]);

        return redirect(action('casos_informesController@gestionar_adjuntos',$id_caso));
    }
}
