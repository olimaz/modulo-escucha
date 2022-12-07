<?php

namespace App\Http\Controllers;

use App\Models\entrevista_etnica;
use App\Models\entrevista_impacto;
use App\Models\entrevista_individual;
use App\Models\entrevista_justicia;
use App\Models\justicia_institucion;
use App\Models\justicia_objetivo;
use App\Models\justicia_porque;
use Illuminate\Http\Request;

class entrevista_impactoController extends Controller
{
    //
    //Muestra el formulario para indicar los impactos
    public function especificar($id_e_ind_fvt) {

        $tipo_entrevista = 'individual';

        $entrevista = entrevista_individual::find($id_e_ind_fvt);

        if (isset($_GET['tipo'])) {
            $tipo_entrevista = 'etnica';
            $entrevista = entrevista_etnica::find($id_e_ind_fvt); 
        }
        
        $hay_justicia = entrevista_justicia::entrevista($id_e_ind_fvt, $tipo_entrevista)->first();

        if($hay_justicia) {
            $entrevista_justicia = $hay_justicia;
        }
        else {
            $entrevista_justicia = new entrevista_justicia();
        }

        $hay_encabezado = entrevista_impacto::entrevista($id_e_ind_fvt, $tipo_entrevista)->wherenull('id_impacto')->first();
        if($hay_encabezado) {
            $impacto =$hay_encabezado;
        }
        else {
            $impacto=new \stdClass();
            $impacto->transgeneracionales="";
            $impacto->afrentamiento_proceso="";
            $impacto->id_reparacion_etnica="";
        }

        if($entrevista) {
            return view('entrevista_individuals.ficha_impactos',compact('entrevista','entrevista_justicia','impacto', 'tipo_entrevista'));
            // if ($tipo_entrevista=='individual') {

            //     return view('entrevista_individuals.ficha_impactos',compact('entrevista','entrevista_justicia','impacto', 'tipo_entrevista'));
            // } else {

            //     return view('entrevista_individuals.ficha_impactos',compact('entrevista','entrevista_justicia','impacto', 'tipo_entrevista'));
            // }
            
        }
        else {
            abort(403,"No existe la entrevista con el id especificado: $id_e_ind_fvt");
        }

    }

    //Recibe los datos del formulario
    public function grabar($id, Request $request) {

        $tipo_entrevista = 'individual';

        if ($request->tipo_entrevista=='etnica')
        {
            $tipo_entrevista = 'etnica';
        }

        $request->transgeneracionales = isset($request->transgeneracionales) ? $request->transgeneracionales : null;
        $request->afrentamiento_proceso = isset($request->afrentamiento_proceso) ? $request->afrentamiento_proceso : null;

        // Por si dejan en blanco
        if(!isset($request->id_impacto)) {
            $request->id_impacto=array();
        }

        $request->id_j_institucion_1 = isset($request->id_j_institucion_1) ? $request->id_j_institucion_1 : array();
        $request->id_j_institucion_2 = isset($request->id_j_institucion_2) ? $request->id_j_institucion_2 : array();
        $request->id_j_institucion_3 = isset($request->id_j_institucion_3) ? $request->id_j_institucion_3 : array();
        $request->id_j_porque_1 = isset($request->id_j_porque_1) ? $request->id_j_porque_1 : array();
        $request->id_j_porque_2 = isset($request->id_j_porque_2) ? $request->id_j_porque_2 : array();
        $request->id_j_porque_3 = isset($request->id_j_porque_3) ? $request->id_j_porque_3 : array();
        $request->id_j_objetivo_1 = isset($request->id_j_objetivo_1) ? $request->id_j_objetivo_1 : array();
        $request->id_j_objetivo_2 = isset($request->id_j_objetivo_2) ? $request->id_j_objetivo_2 : array();
        $request->id_j_objetivo_3 = isset($request->id_j_objetivo_3) ? $request->id_j_objetivo_3 : array();



        $id_entrevista = $id;            
        $campo_id_entrevista = 'id_e_ind_fvt';

        if ($tipo_entrevista == 'individual') {

            entrevista_impacto::where('id_e_ind_fvt', $id_entrevista)->delete();
        } else {

            entrevista_impacto::where('id_entrevista_etnica', $id_entrevista)->delete();
            $campo_id_entrevista = 'id_entrevista_etnica';
        }
        
        foreach ($request->id_impacto as $id_impacto) {

            if($id_impacto > 0) {
                $nuevo = new entrevista_impacto();
                // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                $nuevo->$campo_id_entrevista = $id_entrevista;
                $nuevo->id_impacto = $id_impacto;
                $nuevo->id_entrevistador = \Auth::user()->id_entrevistador;
                //$nuevo->transgeneracionales = $request->transgeneracionales ;
                //$nuevo->afrentamiento_proceso = $request->afrentamiento_proceso ;
                $nuevo->save();
            }
        }

        if(!empty($request->transgeneracionales) || !empty($request->afrentamiento_proceso) || !empty($request->id_reparacion_etnica)) {
            $nuevo = new entrevista_impacto();
            // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
            $nuevo->$campo_id_entrevista = $id_entrevista;
            $nuevo->id_impacto = null;
            $nuevo->transgeneracionales = $request->transgeneracionales ;
            $nuevo->afrentamiento_proceso = $request->afrentamiento_proceso ;
            $nuevo->id_reparacion_etnica = $request->id_reparacion_etnica ;
            $nuevo->save();
        }


        //procesar el acceso a la justicia
        if ($tipo_entrevista == 'individual') {

            entrevista_justicia::where('id_e_ind_fvt', $id_entrevista)->delete();
        } else {

            entrevista_justicia::where('id_entrevista_etnica', $id_entrevista)->delete();
        }
        
        $nuevo= new entrevista_justicia();
        // $nuevo->id_e_ind_fvt=$id_e_ind_fvt;
        $nuevo->$campo_id_entrevista = $id_entrevista;
        $nuevo->id_denuncio = $request->id_denuncio;
        $nuevo->porque_no = $request->porque_no;
        $nuevo->id_apoyo = $request->id_apoyo;
        $nuevo->id_adecuado = $request->id_adecuado;
        $nuevo->id_entrevistador = \Auth::user()->id_entrevistador;
        $nuevo->save();

        //Procesar las instituciones
        if ($tipo_entrevista == 'individual') {
            justicia_institucion::where('id_e_ind_fvt',$id_entrevista)->delete();
        } else {
            justicia_institucion::where('id_entrevista_etnica',$id_entrevista)->delete();
        }
        
        if(count($request->id_j_institucion_1)>0) {
            foreach ($request->id_j_institucion_1 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_institucion();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_institucion = $cual_id;
                    $nuevo->id_tipo = 1;
                    $nuevo->save();
                }
            }
        }
        if(count($request->id_j_institucion_2)>0) {
            foreach ($request->id_j_institucion_2 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_institucion();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_institucion = $cual_id;
                    $nuevo->id_tipo = 2;
                    $nuevo->save();
                }
            }
        }
        if(count($request->id_j_institucion_3)>0) {
            foreach ($request->id_j_institucion_3 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_institucion();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_institucion = $cual_id;
                    $nuevo->id_tipo = 3;
                    $nuevo->save();
                }
            }
        }
        //porque acudio
        if ($tipo_entrevista == 'individual') {
            justicia_porque::where('id_e_ind_fvt',$id_entrevista)->delete();
        } else {
            justicia_porque::where('id_entrevista_etnica',$id_entrevista)->delete();
        }        
        
        if(count($request->id_j_porque_1)>0) {
            foreach ($request->id_j_porque_1 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_porque();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_porque = $cual_id;
                    $nuevo->id_tipo = 1;
                    $nuevo->save();
                }
            }
        }
        if(is_array($request->id_j_porque_2)) {
            foreach ($request->id_j_porque_2 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_porque();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_porque = $cual_id;
                    $nuevo->id_tipo = 2;
                    $nuevo->save();
                }
            }
        }
        if(count($request->id_j_porque_3)>0) {
            foreach ($request->id_j_porque_3 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_porque();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_porque = $cual_id;
                    $nuevo->id_tipo = 3;
                    $nuevo->save();
                }
            }
        }
        // Para qué acudio
        if ($tipo_entrevista == 'individual') {
            justicia_objetivo::where('id_e_ind_fvt',$id_entrevista)->delete();
        } else {
            justicia_objetivo::where('id_entrevista_etnica',$id_entrevista)->delete();
        }
        
        if(count($request->id_j_objetivo_1)>0) {
            foreach ($request->id_j_objetivo_1 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_objetivo();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_objetivo = $cual_id;
                    $nuevo->id_tipo = 1;
                    $nuevo->save();
                }
            }
        }
        if(count($request->id_j_objetivo_2)>0) {
            foreach ($request->id_j_objetivo_2 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_objetivo();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_objetivo = $cual_id;
                    $nuevo->id_tipo = 2;
                    $nuevo->save();
                }
            }
        }
        if(count($request->id_j_objetivo_3)>0) {
            foreach ($request->id_j_objetivo_3 as $cual_id) {
                if($cual_id > 0) {
                    $nuevo = new justicia_objetivo();
                    // $nuevo->id_e_ind_fvt = $id_e_ind_fvt;
                    $nuevo->$campo_id_entrevista = $id_entrevista;
                    $nuevo->id_objetivo = $cual_id;
                    $nuevo->id_tipo = 3;
                    $nuevo->save();
                }
            }
        }


        //return redirect()->back();
        if ($tipo_entrevista == 'etnica') {
            
            return redirect()->action('entrevista_etnicaController@fichas',$id);
        }

        return redirect()->action('entrevista_individualController@fichas',$id);
        
    }

    public function show($id_e_ind_fvt) {

        $tipo_entrevista = 'individual';

        $entrevista = entrevista_individual::find($id_e_ind_fvt);

        if (isset($_GET['tipo'])) {
            $tipo_entrevista = 'etnica';
            $entrevista = entrevista_etnica::find($id_e_ind_fvt); 
        }        

        // $entrevista = entrevista_individual::find($id_e_ind_fvt);
        $hay_justicia = entrevista_justicia::entrevista($id_e_ind_fvt, $tipo_entrevista)->first();

        if($hay_justicia) {
            $entrevista_justicia = $hay_justicia;
        }
        else {
            $entrevista_justicia = new entrevista_justicia();
        }

        $hay_encabezado = entrevista_impacto::entrevista($id_e_ind_fvt, $tipo_entrevista)->wherenull('id_impacto')->first();
        if($hay_encabezado) {
            $impacto =$hay_encabezado;
        }
        else {
            $impacto=new \stdClass();
            $impacto->transgeneracionales="";
            $impacto->afrentamiento_proceso="";
            $impacto->id_reparacion_etnica="";
        }

        return view('entrevista_individuals.ficha_impactos_show', compact('entrevista','entrevista_justicia','impacto', 'tipo_entrevista'));

    }

}
