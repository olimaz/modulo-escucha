<?php

namespace App\Http\Controllers;

use App\Models\hecho_victima;
use App\Models\hecho_violencia;
use App\Models\hecho_violencia_mecanismo;
use App\Models\tipo_violencia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Flash;

class hecho_violenciaController extends Controller
{
    //
    public function agregar(Request $request)
    {
        $exito = false;
        if (isset($request->id_hecho)) {
            $violencia = false;
            if (isset($request->id_subtipo_violencia)) {
                $violencia = tipo_violencia::find($request->id_subtipo_violencia);
            } else {
                $violencia = tipo_violencia::where('codigo', $request->codigo_violencia)->first();
            }

            //dd($violencia);

            //detectar el id_tipo_violencia
            if ($violencia) {
                //Ver que no combinen Homicidio con desplazamiento o exilio
                $a_id_contrarios = array();
                if(substr($violencia->codigo,0,2)=='05') {
                    $a_id_contrarios = tipo_violencia::wherein('codigo',['2101','2201'])->pluck('id_geo')->toArray();
                }
                elseif(in_array(substr($violencia->codigo,0,2),['21','22'])) {
                    $a_id_contrarios = tipo_violencia::where('codigo','ilike','05%')->pluck('id_geo')->toArray();
                }
                if(count($a_id_contrarios)>0) {
                    $hay = hecho_violencia::where('id_hecho', $request->id_hecho)->wherein('id_subtipo_violencia', $a_id_contrarios)->count();
                    if($hay > 0) {
                        $error = "No tiene sentido combinar Homicidio con desplazamiento o exilio en el mismo hecho";
                        if(isset($request->ajax)) {  //Leido por ajax en agregar simple
                            return response()->json($error,401);
                        }
                        else { //leido por un post desde formulario de personalizacion
                            \Flash::warning("Violencia NO agregada:  $error");
                            return redirect()->back();
                        }



                    }
                }


                //Ver que no esté ya metido
                $existe = hecho_violencia::where('id_hecho', $request->id_hecho)->where('id_subtipo_violencia', $violencia->id_geo)->first();

                if (empty($existe)) {

                    $input = $request->all();
                    //Por si dejan el lugar de segunda llegada a nivel de depto o municipio
                    if (isset($request->id_lugar_llegada_2)) {
                        if ($request->id_lugar_llegada_2 < 1) {
                            if ($request->id_lugar_llegada_2_muni > 0) {
                                $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_muni;
                            } elseif ($request->id_lugar_llegada_2_depto > 0) {
                                $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_depto;
                            }
                        }
                    }
                    //Lugar de salida
                    if (isset($request->id_lugar_salida)) {
                        if ($request->id_lugar_salida < 1) {
                            if ($request->id_lugar_salida_muni > 0) {
                                $input['id_lugar_salida'] = $request->id_lugar_salida_muni;
                            } elseif ($request->id_lugar_salida_depto > 0) {
                                $input['id_lugar_salida'] = $request->id_lugar_salida_depto;
                            }
                        }
                    }
                    //Lugar de llegada
                    if (isset($request->id_lugar_llegada)) {
                        if ($request->id_lugar_llegada < 1) {
                            if ($request->id_lugar_llegada_muni > 0) {
                                $input['id_lugar_llegada'] = $request->id_lugar_llegada_muni;
                            } elseif ($request->id_lugar_salida_depto > 0) {
                                $input['id_lugar_llegada'] = $request->id_lugar_llegada_depto;
                            }
                        }
                    }
                    //dd($input);
                    $input['id_tipo_violencia'] = $violencia->id_padre;
                    $input['id_subtipo_violencia'] = $violencia->id_geo; //por si venia con el codigo
                    $nuevo = new hecho_violencia();
                    $nuevo->fill($input);
                    $nuevo->save();
                    $exito = true;
                } else {
                    $exito = false;
                }
            } else {
                $exito = false;
            }

        } else {
            $exito = false;
        }
        if ($exito) {
            if (isset($request->id_mecanismo)) {
                foreach ($request->id_mecanismo as $id) {
                    $detalle = new hecho_violencia_mecanismo();
                    $detalle->id_hecho_violencia = $nuevo->id_hecho_violencia;
                    $detalle->id_mecanismo = $id;
                    $detalle->created_at = Carbon::now();
                    $detalle->save();
                }
            }
            //Flash::success('Violencia agregada.');
        }
        else {
            Flash::warning('Violencia NO agregada.');
        }
        //dd($exito);
        return redirect()->back();
        //$error = "No tiene sentido combinar Homicidio con desplazamiento o exilio";
        //return response()->json($exito);
    }

    public function quitar($id)
    {


        $quitar = hecho_violencia::find($id);
        //dd($id);
        //dd("Quitar $id");
        if ($quitar) {
            $quitar->delete();
            //Flash::success('Violencia removida');
        }
        return redirect()->back();

    }
}

