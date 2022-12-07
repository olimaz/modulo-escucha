<?php

namespace App\Models;

use App\Http\Controllers\etiquetar_asignacionController;
use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class etiquetar_asignacion
 * @package App\Models
 * @version February 10, 2020, 11:56 am -05
 *
 * @property \App\Models\Esclarecimiento.diagnosticoComunitario idDiagnosticoComunitario
 * @property \App\Models\Esclarecimiento.entrevistaColectiva idEntrevistaColectiva
 * @property \App\Models\Esclarecimiento.entrevistaEtnica idEntrevistaEtnica
 * @property \App\Models\Esclarecimiento.entrevistaProfundidad idEntrevistaProfundidad
 * @property \App\Models\Esclarecimiento.historiaVida idHistoriaVida
 * @property \App\Models\Esclarecimiento.entrevistador idAutoriza
 * @property \App\Models\Catalogos.catItem idCausa
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Esclarecimiento.entrevistador idTranscriptor
 * @property integer id_etiquetar_asignacion
 * @property integer id_e_ind_fvt
 * @property integer id_entrevista_profundidad
 * @property integer id_entrevista_colectiva
 * @property integer id_entrevista_etnica
 * @property integer id_diagnostico_comunitario
 * @property integer id_historia_vida
 * @property integer id_autoriza
 * @property integer id_transcriptor
 * @property integer id_situacion
 * @property integer id_causa
 * @property integer urgente
 * @property string observaciones
 * @property string|\Carbon\Carbon fh_asignado
 * @property string|\Carbon\Carbon fh_revocado
 * @property string|\Carbon\Carbon fh_transcrito
 * @property string|\Carbon\Carbon fh_anulado
 * @property string|\Carbon\Carbon fh_inicio
 * @property string|\Carbon\Carbon fh_fin
 * @property integer terceros
 * @property integer duracion_etiquetado_minutos
 * @property integer duracion_etiquetado_real_minutos
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class etiquetar_asignacion extends Model
{

    public $table = 'etiquetar_asignacion';
    protected $primaryKey  = 'id_etiquetar_asignacion';
    
    public $timestamps = false;




    public $fillable = [
        'id_e_ind_fvt',
        'id_entrevista_profundidad',
        'id_entrevista_colectiva',
        'id_entrevista_etnica',
        'id_diagnostico_comunitario',
        'id_historia_vida',
        'id_autoriza',
        'id_transcriptor',
        'id_situacion',
        'id_causa',
        'urgente',
        'observaciones',
        'fh_asignado',
        'fh_revocado',
        'fh_transcrito',
        'fh_anulado',
        'fh_inicio',
        'fh_fin',
        'terceros',
        'duracion_etiquetado_minutos',
        'duracion_etiquetado_real_minutos',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_etiquetar_asignacion' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_entrevista_profundidad' => 'integer',
        'id_entrevista_colectiva' => 'integer',
        'id_entrevista_etnica' => 'integer',
        'id_diagnostico_comunitario' => 'integer',
        'id_historia_vida' => 'integer',
        'id_autoriza' => 'integer',
        'id_transcriptor' => 'integer',
        'id_situacion' => 'integer',
        'id_causa' => 'integer',
        'urgente' => 'integer',
        'observaciones' => 'string',
        'fh_asignado' => 'datetime',
        'fh_revocado' => 'datetime',
        'fh_transcrito' => 'datetime',
        'fh_anulado' => 'datetime',
        'fh_inicio' => 'datetime',
        'fh_fin' => 'datetime',
        'terceros' => 'integer',
        'duracion_etiquetado_minutos' => 'integer',
        'duracion_etiquetado_real_minutos' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_e_ind_fvt' => 'required',
        //'id_transcriptor' => 'required',
    ];
    public static $rules_edit = [
        //'id_e_ind_fvt' => 'required',
        //'id_transcriptor' => 'required',
        'fecha_inicio_submit' => 'required',
        'fecha_fin_submit' => 'required',
        'hora_inicio_submit' => 'required',
        'hora_fin_submit' => 'required',
    ];

    public static $messages = [
        'fecha_inicio_submit.required' =>'Porfavor indique la fecha en que inició la transcripción'
        ,'hora_inicio_submit.required' =>'Porfavor indique la hora en que inició la transcripción'
        ,'fecha_fin_submit.required' =>'Porfavor indique la fecha en que finalizó la transcripción'
        ,'hora_fin_submit.required' =>'Porfavor indique la hora en que finalizó la transcripción'
    ];

    //Relaciones
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_entrevista_profundidad() {
        return $this->belongsTo(entrevista_profundidad::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_id_entrevista_colectiva() {
        return $this->belongsTo(entrevista_colectiva::class,'id_entrevista_colectiva','id_entrevista_colectiva');
    }
    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }
    public function rel_id_diagnostico_comunitario() {
        return $this->belongsTo(diagnostico_comunitario::class,'id_diagnostico_comunitario','id_diagnostico_comunitario');
    }
    public function rel_id_historia_vida() {
        return $this->belongsTo(historia_vida::class,'id_historia_vida','id_historia_vida');
    }
    public function rel_id_autoriza(){
        return $this->belongsTo(entrevistador::class,'id_autoriza','id_entrevistador');
    }
    public function rel_id_transcriptor(){
        return $this->belongsTo(entrevistador::class,'id_transcriptor','id_entrevistador');
    }
    public function rel_id_causa() {
        return $this->belongsTo(cat_item::class,'id_causa','id_item');
    }

    //Getters
    public function getFmtIdEIndFvtAttribute() {
        $cual=$this->rel_id_e_ind_fvt;
        $txt="Desconocido";
        if($cual) {
            $link=action('entrevista_individualController@show',$this->id_e_ind_fvt);
            $txt= "<a href='$link'>".$cual->entrevista_codigo."</a>";
            if(\Gate::allows('nivel-11')) {
                if($this->id_situacion<>1) {
                    $txt=$cual->entrevista_codigo;
                }
            }
        }
        return $txt;
    }

    public function getCodigoEntrevistaAttribute() {
        $link="";
        $txt="Desconocido";
        if($this->id_e_ind_fvt>0) {
            $link=action('entrevista_individualController@show',$this->id_e_ind_fvt);
            $txt= entrevista_individual::find($this->id_e_ind_fvt)->entrevista_codigo;
        }
        elseif($this->id_entrevista_profundidad > 0) {
            $link=action('entrevista_profundidadController@show',$this->id_entrevista_profundidad);
            $txt= entrevista_profundidad::find($this->id_entrevista_profundidad)->entrevista_codigo;
        }
        elseif($this->id_entrevista_colectiva > 0) {
            $link=action('entrevista_colectivaController@show',$this->id_entrevista_colectiva);
            $txt= entrevista_colectiva::find($this->id_entrevista_colectiva)->entrevista_codigo;
        }
        elseif($this->id_entrevista_etnica > 0) {
            $link=action('entrevista_etnicaController@show',$this->id_entrevista_etnica);
            $txt= entrevista_etnica::find($this->id_entrevista_etnica)->entrevista_codigo;
        }
        elseif($this->id_diagnostico_comunitario > 0) {
            $link=action('diagnostico_comunitarioController@show',$this->id_diagnostico_comunitario);
            $txt= diagnostico_comunitario::find($this->id_diagnostico_comunitario)->entrevista_codigo;
        }
        elseif($this->id_historia_vida > 0) {
            $link=action('historia_vidaController@show',$this->id_historia_vida);
            $txt= historia_vida::find($this->id_historia_vida)->entrevista_codigo;
        }
        else {
            $txt= "Instrumento desconocido";
        }
        return "<a href='$link'>$txt</a>";
    }
    public function getFmtTercerosAttribte() {
        return $this->terceros == 1 ? "Transcripción de terceros" : "";
    }

    public function getFmtIdAutorizaAttribute() {
        $cual=$this->rel_id_autoriza;
        if($cual) {
            return $cual->numero_entrevistador." - ".$cual->fmt_nombre;
        }
        else {
            return "Desconocido";
        }
    }
    public function getFmtIdTranscriptorAttribute() {
        $cual=$this->rel_id_transcriptor;
        if($cual) {
            return $cual->numero_entrevistador." - ".$cual->fmt_nombre;
        }
        else {
            return "Desconocido";
        }
    }
    public function getFmtIdSituacionAttribute() {
        return criterio_fijo::describir(9,$this->id_situacion);
    }
    public function getFmtIdCausaAttribute() {
        return cat_item::describir($this->id_causa);
    }
    public function getFmtUrgenteAttribute() {
        return $this->urgente == 1 ? "Sí" : "No";
    }

    public function getFmtFechaSituacionAttribute() {
        $fecha=$this->fh_asignado;
        if($this->id_situacion==3) {
            $fecha=$this->fh_revocado;
        }
        if($this->id_situacion==2) {
            $fecha=$this->fh_transcrito;
        }
        //$carbon = Carbon::createFromTimestamp($fecha);
        return $fecha->format("d-m-Y H:i");
    }


    //Setters
    public function setIdCausaAttribute($val) {
        if($val<=0) {
            $this->attributes['id_causa']=null;
        }
        else {
            $this->attributes['id_causa']=$val;
        }
    }

    public function setDuracionEtiquetadoMinutosAttribute($val) {
        $val=trim($val);
        $val=str_replace(",","",$val);
        $val=str_replace(".","",$val);
        $val=intval($val);
        $this->attributes['duracion_etiquetado_minutos']=$val;
    }



    //Scopes
    // SCOPES: filtros y criterios de ordenado
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new etiquetar_asignacion();
        $filtro->id_autoriza = -1;
        $filtro->id_transcriptor = -1;
        $filtro->id_situacion = -1;
        $filtro->id_e_ind_fvt = -1;
        $filtro->id_causa = -1;
        $filtro->urgente = -1;
        $filtro->asignado_del = null;
        $filtro->asignado_al = null;
        $filtro->observaciones = null;
        $filtro->entrevista_codigo = null;
        $filtro->vigente=true;  //Para ignorar los eliminados


        // Actualizar valores del REQUEST
        $filtro->id_autoriza = isset($request->id_autoriza) ? $request->id_autoriza : $filtro->id_autoriza;
        $filtro->id_transcriptor = isset($request->id_transcriptor) ? $request->id_transcriptor : $filtro->id_transcriptor;
        $filtro->id_situacion = isset($request->id_situacion) ? $request->id_situacion : $filtro->id_situacion;
        $filtro->id_causa = isset($request->id_causa) ? $request->id_causa : $filtro->id_causa;
        $filtro->urgente = isset($request->urgente) ? $request->urgente : $filtro->urgente;
        $filtro->id_e_ind_fvt = isset($request->id_e_ind_fvt) ? $request->id_e_ind_fvt : $filtro->id_e_ind_fvt;
        $filtro->observaciones = isset($request->observaciones) ? $request->id_e_ind_fvt : $filtro->observaciones;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;

        $filtro->asignado_del = isset($request->asignado_del_submit) ? $request->asignado_del_submit : $filtro->asignado_del;
        $filtro->asignado_al = isset($request->asignado_al_submit) ? $request->asignado_al_submit : $filtro->asignado_al;

        if(isset($request->entrevista_correlativo)) {
            $request->entrevista_correlativo = intval($request->entrevista_correlativo);
            $existe = entrevista_individual::where('entrevista_correlativo',$request->entrevista_correlativo)->first();
            if($existe) {
                $filtro->id_e_ind_fvt = $existe->id_e_ind_fvt;
            }
        }




        //Filtro por grupo del entrevistador
        if(\Auth::check()) {
            $usuario =\Auth::user();
            //Aplicar filtros por grupo
            if(in_array($usuario->id_nivel,[11])) {  //Tramscriptores: los propios
                $filtro->id_transcriptor = $usuario->id_entrevistador;
            }
        }

        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            $url = $request->fullUrl();
            $pedazos = explode("?",$url);
            if(isset($pedazos[1])) {
                $filtro->url = $pedazos[1]."&";

            }
            else {
                $filtro->url="";
            }
        }

        return $filtro;
    }
    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('id_situacion')
                ->orderby('urgente')
                ->orderby('fh_asignado');
    }
    public static function scopeId_Autoriza($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_autoriza',$criterio);
        }
    }
    public static function scopeId_Transcriptor($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_transcriptor',$criterio);
        }
    }
    public static function scopeId_Situacion($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_situacion',$criterio);
        }
    }
    public static function scopeId_E_Ind_Fvt($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_e_ind_fvt',$criterio);
        }
    }
    public static function scopeId_Causa($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_causa',$criterio);
        }
    }
    public static function scopeUrgente($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('urgente',$criterio);
        }
    }
    public static function scopeAsignado_del($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("fh_asignado",'>=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeAsignado_al($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 23:59:59");
                $query->where("fh_asignado",'<=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeObservaciones($query, $criterio="") {
        if(strlen($criterio) > 0) {
            $query->where('observaciones','ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevista_codigo($query, $criterio="") {
        if(strlen($criterio) > 0) {
            $criterio = mb_strtoupper($criterio);
            $truco="x$criterio";
            if(strpos($truco,"VI") > 0) {
                $query->join('esclarecimiento.e_ind_fvt as e','etiquetar_asignacion.id_e_ind_fvt','=','e.id_e_ind_fvt')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"AA") > 0) {
                $query->join('esclarecimiento.e_ind_fvt as e','etiquetar_asignacion.id_e_ind_fvt','=','e.id_e_ind_fvt')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"TC") > 0) {
                $query->join('esclarecimiento.e_ind_fvt as e','etiquetar_asignacion.id_e_ind_fvt','=','e.id_e_ind_fvt')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"CO") > 0) {
                $query->join('esclarecimiento.entrevista_colectiva as e','etiquetar_asignacion.id_entrevista_colectiva','=','e.id_entrevista_colectiva')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"EE") > 0) {
                $query->join('esclarecimiento.entrevista_etnica as e','etiquetar_asignacion.id_entrevista_etnica','=','e.id_entrevista_etnica')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"PR") > 0) {
                $query->join('esclarecimiento.entrevista_profundidad as e','etiquetar_asignacion.id_entrevista_profundidad','=','e.id_entrevista_profundidad')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"DC") > 0) {
                $query->join('esclarecimiento.diagnostico_comunitario as e','etiquetar_asignacion.id_diagnostico_comunitario','=','e.id_diagnostico_comunitario')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }
            elseif(strpos($truco,"HV") > 0) {
                $query->join('esclarecimiento.historia_vida as e','etiquetar_asignacion.id_historia_vida','=','e.id_historia_vida')
                    ->where('entrevista_codigo','ilike',"%$criterio%");
            }

        }
    }
    public static function scopeVigente($query,$vigentes=true) {
        if($vigentes) {
            $query->where('id_situacion','<>',0);
        }
    }




    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        $query = $query->asignado_del($criterios->asignado_del)
            ->asignado_al($criterios->asignado_al)
            ->id_autoriza($criterios->id_autoriza)
            ->id_transcriptor($criterios->id_transcriptor)
            ->id_situacion($criterios->id_situacion)
            ->id_e_ind_fvt($criterios->id_e_ind_fvt)
            ->id_causa($criterios->id_causa)
            ->urgente($criterios->urgente)
            ->observaciones($criterios->observaciones)
            ->entrevista_codigo($criterios->entrevista_codigo)
            ->vigente($criterios->vigente)
        ;
    }


    //Para matriz de resumen
    public static function cuadro_resumen($filtros=0) {
        if(!is_object($filtros)) {
            $filtros = etiquetar_asignacion::filtros_default();
        }


        $listado=etiquetar_asignacion::filtrar($filtros)->get();

        $a_transcriptores=array();
        $a_estado=criterio_fijo::listado_items(9);
        $a_datos=array();
        $a_minutos=array();
        $a_total_trans=array();
        $a_total_estado=array();
        $total=0;

        foreach($listado as $asignacion) {
            $a_transcriptores[$asignacion->id_transcriptor]=$asignacion->rel_id_transcriptor->fmt_numero_nombre;
            $a_minutos[$asignacion->id_transcriptor]=0;
        }
        $total_minutos=0;
        foreach($listado as $asignacion) {
            if($asignacion->id_situacion==2) {
                $tiempo = $asignacion->duracion_etiquetado_minutos;
                $a_minutos[$asignacion->id_transcriptor] = isset($a_minutos[$asignacion->id_transcriptor]) ? $a_minutos[$asignacion->id_transcriptor] += $tiempo : $tiempo;
                $total_minutos += $tiempo;
            }
        }



        foreach($a_transcriptores as $id_transcriptor=>$nombre) {
            $a_total_trans[$id_transcriptor]=0;//Para la sumatoria
            foreach($a_estado as $id_estado=>$descripcion) {
                $a_datos[$id_transcriptor][$id_estado]=0;
                $a_total_estado[$id_estado]=0;//Para la sumatoria
            }
        }
        foreach($listado as $asignacion) {
            $a_datos[$asignacion->id_transcriptor][$asignacion->id_situacion]++;
        }

        foreach($a_datos as $id_transcriptor=>$asignaciones) {
            foreach($asignaciones as $id_estado=>$conteo){
                $a_total_trans[$id_transcriptor]+=$conteo;
                $a_total_estado[$id_estado]+=$conteo;
                $total+=$conteo;
            }
        }

        $a_minutos_horas=array();
        foreach($a_minutos as $id=>$minutos) {
            $a_minutos_horas[$id] = transcribir_asignacion::en_horas($minutos);
        }
        //Promedio por entrevista
        $a_promedio=array();
        $total_promedio=0;

        foreach($a_minutos as $id=>$minutos) {
            if($a_datos[$id][2] >0 ){
                $a_promedio[$id] = $minutos / $a_datos[$id][2];
            }
            else {
                $a_promedio[$id] = 0;
            }

            $total_promedio+=$minutos;
        }
        if($total_promedio>0) {
            $total_promedio = $total_promedio / $a_total_estado[2];
        }
        $a_promedio_horas=array();

        foreach($a_promedio as $id=>$minutos) {
            $a_promedio_horas[$id] = transcribir_asignacion::en_horas($minutos);
        }



        $respuesta=new \stdClass();
        $respuesta->a_estado=$a_estado;
        $respuesta->a_transcriptores = $a_transcriptores;
        $respuesta->a_datos = $a_datos;
        $respuesta->a_total_trans = $a_total_trans;
        $respuesta->a_total_estado = $a_total_estado;
        $respuesta->a_minutos=$a_minutos;
        $respuesta->a_minutos_horas=$a_minutos_horas;
        $respuesta->total = $total;
        $respuesta->total_minutos = $total_minutos;
        $respuesta->total_minutos_horas = transcribir_asignacion::en_horas($total_minutos);
        $respuesta->a_promedio = $a_promedio;
        $respuesta->a_promedio_horas = $a_promedio_horas;
        $respuesta->total_promedio = $total_promedio;
        $respuesta->total_promedio_horas = transcribir_asignacion::en_horas($total_promedio);
        return $respuesta;
    }

    public static function tiene_etiquetado($entrevista) {
        if($entrevista->id_e_ind_fvt>0) {
            $sql = self::where('id_e_ind_fvt',$entrevista->id_e_ind_fvt);
        }
        elseif($entrevista->id_entrevista_colectiva > 0) {
            $sql = self::where('id_entrevista_colectiva',$entrevista->id_entrevista_colectiva);

        }
        elseif($entrevista->id_entrevista_etnica > 0) {
            $sql = self::where('id_entrevista_etnica',$entrevista->id_entrevista_etnica);
        }
        elseif($entrevista->id_entrevista_profundidad > 0) {
            $sql = self::where('id_entrevista_profundidad',$entrevista->id_entrevista_profundidad);
        }
        elseif($entrevista->id_diagnostico_comunitario > 0) {
            $sql = self::where('id_diagnostico_comunitario',$entrevista->id_diagnostico_comunitario);
        }
        elseif($entrevista->id_historia_vida > 0) {
            $sql = self::where('id_historia_vida',$entrevista->id_historia_vida);
        }
        $transcrita = $sql->where('id_situacion',2)->orderby('fh_transcrito','desc')->first();
        if($transcrita) {
            return $transcrita;
        }
        else {
            return false;
        }
    }

    public function traer_tiempos() {
        //$arreglo=array();
        $arreglo = procesamiento_tiempo::where('id_etiquetar_asignacion',$this->id_etiquetar_asignacion)
            ->pluck('tiempo_minutos','id_tipo_medicion')
            ->toArray();
        return $arreglo;
    }

    //Halar la entrevista
    public function getEntrevistaAttribute() {
        $e=false;
        if($this->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($this->id_e_ind_fvt);
        }
        elseif($this->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($this->id_entrevista_profundidad);
        }
        elseif($this->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($this->id_entrevista_colectiva);
        }
        elseif($this->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($this->id_entrevista_etnica);
        }
        elseif($this->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($this->id_diagnostico_comunitario);
        }
        elseif($this->id_historia_vida > 0) {
            $e = historia_vida::find($this->id_historia_vida);
        }
        return $e;
    }

    //Para advertir sobre doble asignacion
    public function buscar_duplicada() {
        $existe = self::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->where('id_entrevista_colectiva',$this->id_entrevista_colectiva)
            ->where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->where('id_entrevista_profundidad',$this->id_entrevista_profundidad)
            ->where('id_diagnostico_comunitario',$this->id_diagnostico_comunitario)
            ->where('id_historia_vida',$this->id_historia_vida)
            ->where('id_etiquetar_asignacion','<>',$this->id_etiquetar_asignacion)
            ->where('id_situacion',1)
            ->count();
        return $existe;
    }

}
