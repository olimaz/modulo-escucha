<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class entrevista_prioridad extends Model
{
    //

    //Criterios de filtrado: ojo siempre alias de la entrevista como "as entrevista"

    public static function filtros_default($request = null)
    {
        $filtro = new \stdClass();
        $filtro->transcrita=0;
        $filtro->etiquetada=0;
        $filtro->id_territorio = 0;
        $filtro->id_macroterritorio = 0;
        $filtro->id_transcriptor = -1;
        //
        $filtro->etiquetada = isset($request->etiquetada) ? intval($request->etiquetada) : $filtro->etiquetada;
        $filtro->transcrita = isset($request->transcrita) ? intval($request->transcrita) : $filtro->transcrita;
        $filtro->id_transcriptor = isset($request->id_transcriptor) ? intval($request->id_transcriptor) : $filtro->id_transcriptor;
        //Determinar si es macro o territorio
        if(isset($request->id_territorio)) {
            if($request->id_territorio>0) {
                $filtro->id_territorio=$request->id_territorio;
            }
            else {
                if($request->id_territorio_macro > 0) {
                    $filtro->id_macroterritorio=$request->id_territorio_macro;
                }
            }
        }
        else {  //Llamada directa desde una grafica
            if(isset($request->id_territorio_macro)) {
                $filtro->id_macroterritorio=$request->id_territorio_macro;
            }
        }
        if(!isset($request->transcrita)) {
            if(\Gate::allows('nivel-10')) {
                $filtro->transcrita=0;
            }
            else {
                $filtro->transcrita=-1;
            }
        }


        return $filtro;
    }

    public static function scopeFiltrar($query, $criterios=0) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        //dd($criterios);
        //$listado = new entrevista_prioridad();
        $individual = entrevista_individual::join('public.prioridad','e_ind_fvt.id_e_ind_fvt','=','prioridad.id_entrevista')
                                ->wherein('prioridad.id_subserie',array(config('expedientes.vi'), config('expedientes.aa'), config('expedientes.tc')))
                                ->distinct()
                                ->select(\DB::raw('e_ind_fvt.entrevista_codigo, e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, e_ind_fvt.clasifica_nivel as nivel, prioridad.*'))
                                ->where('id_activo',1)
                                ->where('prioridad.id_tipo',1) //del documentador
                                ->procesable() //Con audio y consentimiento
                                ->permisos()
                                //Solo los que me interesan
                                ->id_territorio($criterios->id_territorio)
                                ->id_macroterritorio($criterios->id_macroterritorio)
                                ->transcrita($criterios->transcrita)
                                ->quientranscribe($criterios->id_transcriptor)
                                ->etiquetada($criterios->etiquetada);
                                //->get();

        $colectiva = entrevista_colectiva::join('public.prioridad','entrevista_colectiva.id_entrevista_colectiva','=','prioridad.id_entrevista')
            ->where('prioridad.id_subserie',config('expedientes.co'))
            ->distinct()
            ->select(\DB::raw('entrevista_colectiva.entrevista_codigo, entrevista_colectiva.id_macroterritorio, entrevista_colectiva.id_territorio, entrevista_colectiva.clasificacion_nivel as nivel, prioridad.*'))
            ->where('id_activo',1)
            ->where('prioridad.id_tipo',1) //del documentador
            ->procesable() //Con audio y consentimiento
            ->permisos()
            //Solo los que me interesan
            ->id_territorio($criterios->id_territorio)
            ->id_macroterritorio($criterios->id_macroterritorio)
            ->transcrita($criterios->transcrita)
            ->quientranscribe($criterios->id_transcriptor)
            ->etiquetada($criterios->etiquetada);
        $debug['sql']=$colectiva->toSql();
        $debug['par']=$colectiva->getBindings();
        //dd($debug);

        $etnica = entrevista_etnica::join('public.prioridad','entrevista_etnica.id_entrevista_etnica','=','prioridad.id_entrevista')
            ->where('prioridad.id_subserie',config('expedientes.ee'))
            ->distinct()
            ->select(\DB::raw('entrevista_etnica.entrevista_codigo, entrevista_etnica.id_macroterritorio, entrevista_etnica.id_territorio, entrevista_etnica.clasificacion_nivel as nivel, prioridad.*'))
            ->where('id_activo',1)
            ->where('prioridad.id_tipo',1) //del documentador
            ->procesable() //Con audio y consentimiento
            ->permisos()
            //Solo los que me interesan
            ->id_territorio($criterios->id_territorio)
            ->id_macroterritorio($criterios->id_macroterritorio)
            ->transcrita($criterios->transcrita)
            ->quientranscribe($criterios->id_transcriptor)
            ->etiquetada($criterios->etiquetada);



        $profundidad = entrevista_profundidad::join('public.prioridad','entrevista_profundidad.id_entrevista_profundidad','=','prioridad.id_entrevista')
            ->where('prioridad.id_subserie',config('expedientes.pr'))
            ->distinct()
            ->select(\DB::raw('entrevista_profundidad.entrevista_codigo, entrevista_profundidad.id_macroterritorio, entrevista_profundidad.id_territorio, entrevista_profundidad.clasificacion_nivel as nivel,  prioridad.*'))
            ->where('id_activo',1)
            ->where('prioridad.id_tipo',1) //del documentador
            ->procesable() //Con audio y consentimiento
            ->permisos()
            //Solo los que me interesan
            ->id_territorio($criterios->id_territorio)
            ->id_macroterritorio($criterios->id_macroterritorio)
            ->transcrita($criterios->transcrita)
            ->quientranscribe($criterios->id_transcriptor)
            ->etiquetada($criterios->etiquetada);




        $bd = $profundidad->union($etnica)->union($colectiva)->union($individual)->orderby('ponderacion','desc');
        //dd($individual->toSql());
        $todo = $bd->limit(300);

        return $todo;
    }




    //Rotulito para mostrar si está transcrita
    public static function estado_transcripcion($fila) {
        $texto = "(desconocido)";
        if($fila->id_subserie==config('expedientes.vi')) {
            $texto=entrevista_individual::estado_transcrita(entrevista_individual::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $texto=entrevista_individual::estado_transcrita(entrevista_individual::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $texto=entrevista_individual::estado_transcrita(entrevista_individual::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $texto=entrevista_individual::estado_transcrita(entrevista_colectiva::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $texto=entrevista_individual::estado_transcrita(entrevista_etnica::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $texto=entrevista_individual::estado_transcrita(entrevista_profundidad::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $texto=entrevista_individual::estado_transcrita(diagnostico_comunitario::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $texto=entrevista_individual::estado_transcrita(historia_vida::find($fila->id_entrevista));
        }
        return $texto;
    }

    //Rotulito para mostrar si está etiquetada
    public static function estado_etiquetado($fila) {
        $texto = "(desconocido)";
        if($fila->id_subserie==config('expedientes.vi')) {
            $texto=entrevista_individual::estado_etiquetada(entrevista_individual::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $texto=entrevista_individual::estado_etiquetada(entrevista_individual::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $texto=entrevista_individual::estado_etiquetada(entrevista_individual::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $texto=entrevista_individual::estado_etiquetada(entrevista_colectiva::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $texto=entrevista_individual::estado_etiquetada(entrevista_etnica::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $texto=entrevista_individual::estado_etiquetada(entrevista_profundidad::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $texto=entrevista_individual::estado_etiquetada(diagnostico_comunitario::find($fila->id_entrevista));
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $texto=entrevista_individual::estado_etiquetada(historia_vida::find($fila->id_entrevista));
        }
        return $texto;
    }

    // Quien hizo la transcripción
    public static function quien_transcribe($fila) {
        $texto=false;

        $asignacion = transcribir_asignacion::where('id_situacion',2)->orderby('fh_transcrito','desc');

        if($fila->id_subserie==config('expedientes.vi')) {
            $asignacion->where('id_e_ind_fvt',$fila->id_entrevista);
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $asignacion->where('id_e_ind_fvt',$fila->id_entrevista);
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $asignacion->where('id_e_ind_fvt',$fila->id_entrevista);
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $asignacion->where('id_entrevista_colectiva',$fila->id_entrevista);

        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $asignacion->where('id_entrevista_etnica',$fila->id_entrevista);
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $asignacion->where('id_entrevista_profundidad',$fila->id_entrevista);
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $asignacion->where('id_diagnostico_comunitario',$fila->id_entrevista);
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $asignacion->where('id_historia_vida',$fila->id_entrevista);
        }
        $hay = $asignacion->first();
        if ($hay) {
            $quien = entrevistador::find($hay->id_transcriptor);
            if($quien) {
                $texto = $quien->fmt_nombre;
            }
        }
        //Sin asignación
        return $texto;
    }


    //Indica si tiene asignación para transcripcion
    public static function asignado_transcripcion($fila) {
        $existe=false;

        if($fila->id_subserie==config('expedientes.vi')) {
            $existe = transcribir_asignacion::where('id_e_ind_fvt',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $existe = transcribir_asignacion::where('id_e_ind_fvt',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $existe = transcribir_asignacion::where('id_e_ind_fvt',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $existe = transcribir_asignacion::where('id_entrevista_colectiva',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $existe = transcribir_asignacion::where('id_entrevista_etnica',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $existe = transcribir_asignacion::where('id_entrevista_profundidad',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $existe = transcribir_asignacion::where('id_diagnostico_comunitario',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $existe = transcribir_asignacion::where('id_historia_vida',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        return $existe ? 1 : 0;
    }

    //Indica si tiene asignación para etiquetar
    public static function asignado_etiquetar($fila) {
        $existe=false;

        if($fila->id_subserie==config('expedientes.vi')) {
            $existe = etiquetar_asignacion::where('id_e_ind_fvt',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $existe = etiquetar_asignacion::where('id_e_ind_fvt',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $existe = etiquetar_asignacion::where('id_e_ind_fvt',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $existe = etiquetar_asignacion::where('id_entrevista_colectiva',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $existe = etiquetar_asignacion::where('id_entrevista_etnica',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $existe = etiquetar_asignacion::where('id_entrevista_profundidad',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $existe = etiquetar_asignacion::where('id_diagnostico_comunitario',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $existe = etiquetar_asignacion::where('id_historia_vida',$fila->id_entrevista)->where('id_situacion',1)->first();
        }
        return $existe ? 1 : 0;
    }

    public static function link_asignar_transcripcion($fila) {
        $link="";
        $title="";
        $boton_color="";
        $asignada = self::asignado_transcripcion($fila);
        if($asignada==1) {
            $title='Ya asignada';
            $boton_color="btn-warning";
            $icono="<i class='fa fa-headphones' aria-hidden='true'></i>";
        }
        else {
            $title='Sin asignar';
            $boton_color="btn-default";
            $icono="<i class='fa fa-headphones' aria-hidden='true'></i>";
        }

        $parametro="";

        if($fila->id_subserie==config('expedientes.vi')) {
            $parametro="id=";
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $parametro="id=";
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $parametro="id=";
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $parametro="id_co=";
        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $parametro="id_ee=";
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $parametro="id_pr=";
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $parametro="id_dc=";
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $parametro="id_hv=";
        }
        $url= url('transcribirAsignacions/create')."?$parametro".$fila->id_entrevista;
        $link = "<a href='$url' data-toggle='tooltip' title='$title' class='btn btn-sm $boton_color'>$icono</a>";
        return $link;
    }

    //Boton para asignar
    public static function link_asignar_etiquetado($fila) {
        $link="";
        $title="";
        $boton_color="";
        $asignada = self::asignado_etiquetar($fila);
        if($asignada==1) {
            $title='Ya asignada';
            $boton_color="btn-warning";
            $icono="<i class='fa fa-tags' aria-hidden='true'></i>";
        }
        else {
            $title='Sin asignar';
            $boton_color="btn-default";
            $icono="<i class='fa fa-tags' aria-hidden='true'></i>";
        }
        // Verificar que tenga transcripcion
        //dd($fila);
        $destino = enlace::buscar_llaves($fila->id_subserie, $fila->id_entrevista);
        //dd($destino);
        if(!$destino->e->tiene_transcripcion) {
            $str= '<a data-toggle="tooltip" title="Sin transcripción. " href="#" class="btn btn-default btn-sm"><i class="fa fa-tags text-danger" aria-hidden="true"></i> </a>';
            return $str;
        }

        $parametro="";

        if($fila->id_subserie==config('expedientes.vi')) {
            $parametro="id=";
        }
        elseif($fila->id_subserie==config('expedientes.aa')) {
            $parametro="id=";
        }
        elseif($fila->id_subserie==config('expedientes.tc')) {
            $parametro="id=";
        }
        elseif($fila->id_subserie==config('expedientes.co')) {
            $parametro="id_co=";
        }
        elseif($fila->id_subserie==config('expedientes.ee')) {
            $parametro="id_ee=";
        }
        elseif($fila->id_subserie==config('expedientes.pr')) {
            $parametro="id_pr=";
        }
        elseif($fila->id_subserie==config('expedientes.dc')) {
            $parametro="id_dc=";
        }
        elseif($fila->id_subserie==config('expedientes.hv')) {
            $parametro="id_hv=";
        }
        $url= url('etiquetarAsignacions/create')."?$parametro".$fila->id_entrevista;
        $link = "<a href='$url' data-toggle='tooltip' title='$title' class='btn btn-sm $boton_color'>$icono</a>";
        return $link;
    }


    //Reporte de personas entrevistadas
    public static function listado_entrevistados() {
        // Entrevistas a víctimas
        $id_subserie=config('expedientes.vi');
        $vi = \DB::table('esclarecimiento.e_ind_fvt')
                                ->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','=','persona_entrevistada.id_e_ind_fvt')
                                    ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona')
                                    ->selectraw(\DB::raw("e_ind_fvt.id_e_ind_fvt as id_entrevista, $id_subserie as id_subserie, nombre, apellido, alias, id_sexo, fec_nac_a, e_ind_fvt.entrevista_codigo, id_sector, clasifica_nivel as clasificacion_nivel "))
                                    ;
        $id_subserie=config('expedientes.pr');
        $pr = \DB::table('esclarecimiento.entrevista_profundidad')
            ->selectraw(\DB::raw("entrevista_profundidad.id_entrevista_profundidad as id_entrevista, $id_subserie as id_subserie, entrevistado_nombres as nombre, '' as apellido, entrevistado_apellidos as alias, 0 as id_sexo, 0 as fec_nac_a, entrevista_codigo, id_sector, clasificacion_nivel "))
            ;

        $id_subserie=config('expedientes.hv');
        $hv = \DB::table('esclarecimiento.historia_vida')
            ->selectraw(\DB::raw("historia_vida.id_historia_vida as id_entrevista, $id_subserie as id_subserie, entrevistado_nombres as nombre, entrevistado_apellidos as apellido, entrevistado_otros_nombres as alias, id_sexo as id_sexo, 0 as fec_nac_a, entrevista_codigo, id_sector, clasificacion_nivel "))
        ;


        $listado = $vi->union($pr)->union($hv)->orderby('nombre')->orderby('apellido')->get();
        return $listado;
    }

    public static function url_show($fila) {
        $link="#";
        if($fila->id_subserie == config('expedientes.vi')) {
            $link=action('entrevista_individualController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.aa')) {
            $link=action('entrevista_individualController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.tc')) {
            $link=action('entrevista_individualController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.co')) {
            $link=action('entrevista_colectivaController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.ee')) {
            $link=action('entrevista_etnicaController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.pr')) {
            $link=action('entrevista_profundidadController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.dc')) {
            $link=action('diagnostico_comunitarioController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.hv')) {
            $link=action('historia_vidaController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.ci')) {
            $link=action('casos_informesController@show',$fila->id_entrevista);
        }
        return $link;
    }

    public static function url_show_persona($fila) {
        $link="#";
        if($fila->id_subserie == config('expedientes.vi')) {
            $link=action('entrevista_individualController@fichas',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.aa')) {
            $link=action('entrevista_individualController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.tc')) {
            $link=action('entrevista_individualController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.co')) {
            $link=action('entrevista_colectivaController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.ee')) {
            $link=action('entrevista_etnicaController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.pr')) {
            $link=action('entrevista_profundidadController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.dc')) {
            $link=action('diagnostico_comunitarioController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.hv')) {
            $link=action('historia_vidaController@show',$fila->id_entrevista);
        }
        elseif($fila->id_subserie == config('expedientes.ci')) {
            $link=action('casos_informesController@show',$fila->id_entrevista);
        }
        return $link;
    }



}
