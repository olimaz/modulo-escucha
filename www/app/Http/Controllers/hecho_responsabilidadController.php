<?php

namespace App\Http\Controllers;

use App\Models\hecho_responsabilidad;
use App\Models\hecho_violencia;
use App\Models\hecho_violencia_mecanismo;
use App\Models\tipo_aa;
use App\Models\tipo_tc;
use App\Models\tipo_violencia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class hecho_responsabilidadController extends Controller
{
    //
    public function agregar(Request $request)
    {
        $exito = false;
        if (isset($request->id_hecho)) {
            //Actor armado
            $actor = false;
            if (isset($request->id_subtipo_aa)) {
                $actor = tipo_aa::find($request->id_subtipo_aa);
            } else {
                $actor = tipo_aa::where('codigo', $request->codigo_aa)->first();
            }

            //grabarlo en la BD
            if ($actor) {
                //Ver que no esté ya metido
                $existe = hecho_responsabilidad::where('id_hecho', $request->id_hecho)->where('aa_id_subtipo', $actor->id_geo)->first();
                if (!$existe) {
                    $input = $request->all(); //nombre, floque, frente, unidad, otro grupo
                    $input['aa_id_tipo'] = $actor->id_padre;
                    $input['aa_id_subtipo'] = $actor->id_geo;

                    $nuevo = new hecho_responsabilidad();
                    $nuevo->fill($input);
                    $nuevo->save();
                    $exito = true;
                } else {
                    $exito = false;
                }
            }
            else {
                $exito = false;
            }

            //Tercero civil
            $actor = false;
            if (isset($request->id_subtipo_tc)) {
                $actor = tipo_tc::find($request->id_subtipo_tc);
            } else {
                $actor = tipo_tc::where('codigo', $request->codigo_tc)->first();
            }

            //grabarlo en la BD
            if ($actor) {
                //Ver que no esté ya metido
                $existe = hecho_responsabilidad::where('id_hecho', $request->id_hecho)->where('tc_id_subtipo', $actor->id_geo)->first();
                if (!$existe) {
                    $input = $request->all(); //detalle, ¿cual?
                    $input['tc_id_tipo'] = $actor->id_padre;
                    $input['tc_id_subtipo'] = $actor->id_geo;
                    $nuevo = new hecho_responsabilidad();
                    $nuevo->fill($input);
                    $nuevo->save();
                    $exito = true;
                } else {
                    $exito = false;
                }
            }
            else {
                $exito = false;
            }

        } else {
            $exito = false;
        }

        //dd($exito);
        return redirect()->back();
    }

    public function quitar($id)
    {

        $quitar = hecho_responsabilidad::find($id);
        //dd($id);
        if ($quitar) {
            $quitar->delete();
        }
        return redirect()->back();

    }
}
