<?php

namespace App\Http\Controllers;

use App\Models\acceso_edicion;
use App\Models\adjunto;
use App\Models\reservado_acceso;
use App\Models\traza_actividad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class reservado_accesoController extends Controller
{
    function index(Request $request) {
        $listado = reservado_acceso::paginate();
        return view("reportes.acceso_r3");
    }
    //
    function store(Request $request) {
        //dd($request);

        //$this->authorize('nivel-1');
        //Me sirve para validar
        $asignacion = new acceso_edicion();
        $asignacion->id_subserie = $request->id_subserie;
        $asignacion->id_entrevista = $request->id_primaria;
        $asignacion->id_autoriza = \Auth::user()->id_entrevistador;
        if(!$asignacion->puede_conceder_acceso) {
            Flash::error("No puede autorizar acceso a los adjuntos de la entrevista $asignacion->codigo_entrevista");
            return redirect()->back();
        }


        $datos['id_autorizador']=\Auth::user()->id_entrevistador;
        $datos['id_autorizado']=$request->id_autorizado;
        $datos['id_subserie']=$request->id_subserie;
        $datos['id_primaria']=$request->id_primaria;
        //Adjunto
        if($request->hasFile('archivo_20')) {
            $nombre_original=$request->file('archivo_20')->getClientOriginalName();
            $datos['id_adjunto'] = adjunto::crear_adjunto($request->archivo_20_filename, $nombre_original);
        }

        //Rango de fechas

        $fecha_rango=explode(" - ",$request->fecha_rango);
        try {
            $fh_del = Carbon::createFromFormat("d/m/Y",$fecha_rango[0])->format("Y-m-d");
            $fh_al = Carbon::createFromFormat("d/m/Y",$fecha_rango[1])->format("Y-m-d");
        }
        catch(\Exception $e) {
            Flash::error("Fecha de los hechos inválida, favor de revisar este dato");
            return redirect()->back()->withInput($request->all());
        }
        $datos['fh_del']=$fh_del;
        $datos['fh_al']=$fh_al;
        $nuevo = reservado_acceso::create($datos);
        //Traza de actividad
        $e = $nuevo->entrevista->entrevista;
        $id_objeto   = traza_actividad::de_subserie_a_traza($nuevo->id_subserie);
        $id_primaria = $nuevo->id_primaria;
        $referencia = $nuevo->fmt_id_autorizado;
        traza_actividad::create(['id_objeto'=>$id_objeto, 'id_accion'=>11, 'codigo'=>$e->entrevista_codigo, 'referencia'=>$referencia , 'id_primaria'=>$id_primaria]);
        //Fin de la traza
        return redirect()->back();
    }

    function destroy($id) {
        $existe=reservado_acceso::find($id);
        if($existe) {
            $existe->id_activo=2;
            $existe->id_denegador=\Auth::user()->id_entrevistador;
            $existe->fh_update = Carbon::now();
            $existe->save();
            //Traza de actividad
            $clase = traza_actividad::cual_clase($existe->id_subserie);
            $codigo='desconocido';
            if($clase) {
                $objeto = new $clase;
                $registro = $objeto->find($existe->id_primaria);
                if(in_array($existe->id_subserie,[config('expedientes.nes'),config('expedientes.nev'),config('expedientes.ci')])) {
                    $codigo = $registro->codigo;
                }
                else {
                    $codigo = $registro->entrevista_codigo;
                }
            }
            traza_actividad::create(['id_objeto'=>traza_actividad::cual_objeto($existe->id_subserie), 'id_accion'=>12, 'codigo'=>$codigo, 'id_primaria'=>$existe->id_primaria,'referencia'=>$existe->fmt_id_autorizado]);
            //Fin de la traza
        }
        return redirect()->back();
    }
}
