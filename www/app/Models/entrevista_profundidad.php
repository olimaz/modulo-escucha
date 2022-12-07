<?php

namespace App\Models;

use App\graficador;
use Carbon\Carbon;
use Eloquent as Model;
use Html2Text\Html2Text;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

/**
 * Class entrevista_profundidad
 * @package App\Models
 * @version July 31, 2019, 10:51 am -05
 *
 * @property \App\Models\entrevistador idEntrevistador
 * @property \App\Models\cev idMacroterritorio
 * @property \App\Models\cev idTerritorio
 * @property \App\Models\geo entrevistaLugar
 * @property \App\Models\cat_item idSector
 * @property \App\User idUsuario

 * @property \Illuminate\Database\Eloquent\Collection adjuntos
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection entrevistaProfundidadTemas
 * @property \Illuminate\Database\Eloquent\Collection catItems
 * @property integer id_entrevista_profundidad
 * @property integer id_macroterritorio
 * @property integer id_remitido
 * @property integer id_territorio
 * @property integer id_entrevistador
 * @property integer numero_entrevistador
 * @property string entrevista_codigo
 * @property integer entrevista_correlativo
 * @property integer entrevista_numero
 * @property integer es_virtual
 * @property integer entrevista_lugar
 * @property string|\Carbon\Carbon entrevista_fecha_inicio
 * @property string|\Carbon\Carbon entrevista_fecha_final
 * @property integer entrevista_avance
 * @property string titulo
 * @property string entrevista_objetivo
 * @property string entrevistado_nombres
 * @property string entrevistado_apellidos
 * @property integer id_sector
 * @property string observaciones
 * @property integer clasificacion_nna
 * @property integer clasificacion_sex
 * @property integer clasificacion_res
 * @property integer clasificacion_r2
 * @property integer clasificacion_r1
 * @property integer clasificacion_nivel
 * @property integer id_usuario
 * @property integer tiempo_entrevista
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property integer id_tipo
 * @property integer id_policia_parte
 * @property integer id_policia_rango
 * @property integer id_paramilitar_parte
 * @property integer id_paramilitar_rango
 * @property integer id_guerrilla_parte
 * @property integer id_guerrilla_rango
 * @property integer id_ejercito_parte
 * @property integer id_ejercito_rango
 * @property integer id_fuerza_aerea_parte
 * @property integer id_fuerza_aerea_rango
 * @property integer id_fuerza_naval_parte
 * @property integer id_fuerza_naval_rango
 * @property integer id_tercero_civil_parte
 * @property string id_tercero_civil_cual
 * @property integer id_agente_estado_parte
 * @property string id_agente_estado_cual
 * @property string html_transcripcion
 * @property string json_etiquetado
 */
class entrevista_profundidad extends Model
{

    public $table = 'esclarecimiento.entrevista_profundidad';
    protected $primaryKey = 'id_entrevista_profundidad';
    public $timestamps = true;



    public $fillable = [
        'id_macroterritorio',
        'id_remitido',
        'id_territorio',
        'id_entrevistador',
        'numero_entrevistador',
        'entrevista_codigo',
        'entrevista_correlativo',
        'entrevista_numero',
        'entrevista_lugar',
        'entrevista_fecha_inicio',
        'entrevista_fecha_final',
        'entrevista_avance',
        'titulo',
        'entrevista_objetivo',
        'entrevistado_nombres',
        'entrevistado_apellidos',
        'id_sector',
        'observaciones',
        'clasificacion_nna',
        'clasificacion_sex',
        'clasificacion_res',
        'clasificacion_r2',
        'clasificacion_r1',
        'clasificacion_nivel',
        'id_usuario',
        'tiempo_entrevista',
        'created_at',
        'updated_at',
        'id_tipo',
        'id_policia_parte',
        'id_policia_rango',
        'id_paramilitar_parte',
        'id_paramilitar_rango',
        'id_guerrilla_parte',
        'id_guerrilla_rango',
        'id_ejercito_parte',
        'id_ejercito_rango',
        'id_fuerza_aerea_parte',
        'id_fuerza_aerea_rango',
        'id_fuerza_naval_parte',
        'id_fuerza_naval_rango',
        'id_tercero_civil_parte',
        'id_tercero_civil_cual',
        'id_agente_estado_parte',
        'id_agente_estado_cual',
        'es_virtual'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entrevista_profundidad' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_remitido' => 'integer',
        'id_territorio' => 'integer',
        'id_entrevistador' => 'integer',
        'numero_entrevistador' => 'integer',
        'entrevista_codigo' => 'string',
        'entrevista_correlativo' => 'integer',
        'entrevista_numero' => 'integer',
        'entrevista_lugar' => 'integer',
        'entrevista_fecha_inicio' => 'datetime',
        'entrevista_fecha_final' => 'datetime',
        'entrevista_avance' => 'integer',
        'titulo' => 'string',
        'entrevista_objetivo' => 'string',
        'entrevistado_nombres' => 'string',
        'entrevistado_apellidos' => 'string',
        'id_sector' => 'integer',
        'observaciones' => 'string',
        'clasificacion_nna' => 'integer',
        'clasificacion_sex' => 'integer',
        'clasificacion_res' => 'integer',
        'clasificacion_r2' => 'integer',
        'clasificacion_r1' => 'integer',
        'clasificacion_nivel' => 'integer',
        'id_usuario' => 'integer',
        'tiempo_entrevista' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_territorio' => 'required',
        'id_entrevistador' => 'required',
        //'entrevista_numero' => 'required',
        'entrevista_lugar' => 'required',
        'entrevista_fecha_inicio_submit' => 'required',
        'entrevista_avance' => 'required',
        'titulo' => 'required',
        'entrevista_objetivo' => 'required',
        //'entrevistado_nombres' => 'required',
        // 'entrevistado_apellidos' => 'required',
        'id_sector' => 'required',
        'clasificacion_nna' => 'required',
        'clasificacion_sex' => 'required',
        'clasificacion_res' => 'required',
    ];

    //Relaciones mínimas de cualquier entrevista:
    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
    }
    public function rel_id_remitido() {
        return $this->belongsTo(cat_item::class,'id_remitido','id_item');
    }
    //Detalle de violencias
    public function rel_violencia_actor() {
        return $this->hasMany(entrevista_profundidad_violencia_actor::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_violencia_victima() {
        return $this->hasMany(entrevista_profundidad_violencia_victima::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    //Consentimiento informado
    public function rel_consentimiento() {
        return $this->belongsTo(entrevista::class,'id_entrevista_profundidad','id_entrevista_profundidad')->orderby('restrictiva')->orderby('id_entrevista','desc');
    }

    //Persona entrevistada
    public function rel_persona_entrevistada() {
        return $this->belongsTo(persona_entrevistada::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    //Seguimiento
    public function rel_seguimiento() {
        return $this->hasMany(seguimiento::class,'id_entrevista','id_entrevista_profundidad')->where('id_subserie',config('expedientes.pr'))->orderby('fecha_hora');
    }



    public function getFmtIdRemitidoAttribute() {
        return cat_item::describir($this->id_remitido);
    }
    public function getFmtIdCerradoAttribute() {
        $str="";
        if($this->id_cerrado==1) {
            $str = '<i class="fa fa-lock"  title="Procesamiento finalizado" data-toggle="tooltip" aria-hidden="true"></i>';
        }
        return $str;
    }
    //Setter
    public function setIdRemitidoAttribute($val) {
        if($val<=0) {
            $val=null;
        }
        $this->attributes['id_remitido']=$val;
    }
    public function setIdPoliciaRangoAttribute($val) {
        $val = $val <= 0 ? null : $val;
        $this->attributes['id_policia_rango']=$val;
    }
    public function setIdParamilitarRangoAttribute($val) {
        $val = $val <= 0 ? null : $val;
        $this->attributes['id_paramilitar_rango']=$val;
    }
    public function setIdGuerrillaRangoAttribute($val) {
        $val = $val <= 0 ? null : $val;
        $this->attributes['id_guerrilla_rango']=$val;
    }
    public function setIdEjercitoRangoAttribute($val) {
        $val = $val <= 0 ? null : $val;
        $this->attributes['id_ejercito_rango']=$val;
    }
    public function setIdFuerzaAereaRangoAttribute($val) {
        $val = $val <= 0 ? null : $val;
        $this->attributes['id_fuerza_aerea_rango']=$val;
    }
    public function setIdFuerzaNavalRangoAttribute($val) {
        $val = $val <= 0 ? null : $val;
        $this->attributes['id_fuerza_naval_rango']=$val;
    }
    public function setTiempoEntrevistaAttribute($val) {
        $val=intval($val);
        $this->attributes['tiempo_entrevista']=$val;

    }

    //Relaciones
    public function rel_id_macroterritorio() {
        return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
    }
    public function rel_id_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }
    public function rel_id_sector() {
        return $this->belongsTo(cat_item::class,'id_sector','id_item');
    }
    public function rel_entrevista_lugar() {
        return $this->belongsTo(geo::class,'entrevista_lugar','id_geo');
    }
    public function rel_mandato() {
        return $this->hasMany(entrevista_profundidad_mandato::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_tema() {
        return $this->hasMany(entrevista_profundidad_tema::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_adjunto() {
        return $this->hasMany(entrevista_profundidad_adjunto::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_dinamica() {
        return $this->hasMany(entrevista_profundidad_dinamica::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_interes() {
        return $this->hasMany(entrevista_profundidad_interes::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }




    //Permisos si fuera reservado-3
    public function rel_acceso_reservado() {
        return $this->hasMany(reservado_acceso::class,'id_primaria',$this->primaryKey)->where('reservado_acceso.id_subserie',config('expedientes.pr'))->where('reservado_acceso.id_activo',1);
    }
    //Asiganciones de transcripcion
    public function rel_transcripcion() {
        return $this->hasMany(transcribir_asignacion::class,$this->primaryKey,$this->primaryKey)->orderby('id_transcribir_asignacion','desc');
    }
    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista',$this->primaryKey)->where('id_subserie',config('expedientes.pr'));;
    }
    //Asignaciones para etiquetado
    public function rel_etiquetado() {
        return $this->hasMany(etiquetar_asignacion::class,$this->primaryKey,$this->primaryKey)->orderby('id_etiquetar_asignacion','desc');;
    }
    //Etiquetado
    public function rel_etiquetas() {
        return $this->hasMany(etiqueta_entrevista::class,'id_entrevista',$this->primaryKey)->where('id_subserie',config('expedientes.pr'))->orderby('del');
    }
    public function listar_etiquetas() {
        return etiqueta_entrevista::where('id_subserie',config('expedientes.pr'))->where('id_entrevista',$this->id_entrevista_profundidad)
            ->join('sim.etiqueta','etiqueta_entrevista.id_etiqueta','=','etiqueta.id_etiqueta')
            ->leftjoin('catalogos.tesauro','etiqueta.id_etiqueta','=','tesauro.id_etiqueta')
            ->orderby('tesauro.codigo')
            ->orderby('etiqueta.etiqueta')
            ->select(DB::raw('etiqueta_entrevista.*'))
            ->get();
    }
    //Atributos relacionados con el etiquetado
    public function getEtiquetasAttribute() {
        $a_etiquetas=array();
        foreach($this->rel_etiquetas as $marca) {
            $etiqueta =  etiqueta::find($marca->id_etiqueta);
            $a_etiquetas[$etiqueta->etiqueta] =$etiqueta->texto;
        }
        return $a_etiquetas;

    }

    function getEtiquetadoAttribute() {
        $r = new \stdClass();
        $r->a_original=array();
        $r->a_texto = array();
        $r->a_pos = array();
        $r->a_etiquetado = array();
        $salto = 13;  //Ajustar la posición relativa
        $r->texto = $texto = $this->html_transcripcion;
        $posicion=0;
        foreach($this->rel_etiquetas as $marca) {
            if($marca->del >= $posicion && $marca->del <=strlen($r->texto)) { //ver que no se traslape.  esto ignoraría parrafos con doble marca y entidades
                $r->a_original[] = $marca->texto;
                $inicio = @strpos($r->texto, $marca->texto, $marca->del);
                $texto_etiquetado = substr($r->texto, $inicio, strlen($marca->texto));
                $r->a_texto[] = $texto_etiquetado;
                $pos['del'] = $marca->del;
                $pos['al'] = $marca->al;
                $r->a_pos[] = $pos;
                // Lo que quedó en medio de las etiquetas
                //$posicion++;
                $texto_previo = substr($r->texto,$posicion,$inicio-$posicion);
                $r->a_etiquetado[]=$texto_previo;
                //Resaltar el texto en otra variable para no perder el largo original
                $etiqueta= etiqueta::find($marca->id_etiqueta);  //Buscar el texto descriptivo para el tooltip
                $resaltado = "<span title='$etiqueta->texto' class='text-green' data-toggle='tooltip'>$texto_etiquetado</span>";  //texto con marca
                $r->a_etiquetado[]=$resaltado;
                $posicion = $inicio + strlen($texto_etiquetado);
            }
        }
        $r->a_etiquetado[] = substr($r->texto,$posicion);

        // Unir en un solo texto
        $r->texto_resaltado = nl2br(implode("", $r->a_etiquetado));
        return $r;

    }

    //Devuelve un listado con los codigos de quienes tienen acceso
    public function getAccesosAutorizadosAttribute() {
        $arreglo=array();
        foreach($this->rel_acceso_reservado as $permiso) {
            $jefe = entrevistador::find($permiso->id_autorizador);
            $gato = entrevistador::find($permiso->id_autorizado);
            $arreglo[]= "Ent. #".$gato->numero_entrevistador. " (Aut: #$jefe->numero_entrevistador)";
        }
        if(count($arreglo)==0) {
            $str="Nadie, solo el propietario.";
        }
        else {
            $str=implode(", ",$arreglo);
        }
        return $str;
    }

    //Scope para filtrar por listados cargados en excel
    public static function scopeId_excel_listados($query,$criterio) {
        if($criterio > 0) {
            $codigos = excel_listados::arreglo_codigos($criterio);
            $query->wherein('entrevista_codigo',$codigos);
        }
    }

    /*
     * Controles de seguridad
     */
    //Nueva versi{on, 18-feb: todos pueden ver todos los metadatos
    public static function scopePermisos_new($query) {
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //Sin filtro, acceso total
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_profundidad.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo);
            }
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_profundidad.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_profundidad.id_macroterritorio',\Auth::user()->id_macroterritorio);
            }
            //$query->where('e_ind_fvt.id_macroterritorio',\Auth::user()->id_macroterritorio);
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_profundidad.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_profundidad.id_territorio',\Auth::user()->id_territorio);
            }
            //$query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_profundidad.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_profundidad.id_entrevistador',\Auth::user()->id_entrevistador);
            }
        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            //Ni maiz
            $query->where('id_entrevistador',-1);
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            // Entrevistas asignadas
            $asignadas_t = transcribir_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                ->where('id_situacion',1)
                ->pluck('id_entrevista_profundidad')->toArray();
            $asignadas_e = etiquetar_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                ->where('id_situacion',1)
                ->pluck('id_entrevista_profundidad')->toArray();

            $asignaciones = array_merge($asignadas_t, $asignadas_e);

            $query->wherein('entrevista_profundidad.id_entrevista_profundidad',$asignaciones);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('entrevista_profundidad.id_entrevistador',-1); //Ninguno
        }

    }

    //Funcion para el controller, me permite determinar si se puede acceder o no a la entrevista en sí (usado en show y edit)
    public function getPuedeAccederEntrevistaAttribute() {
        return entrevista_individual::revisar_acceso_a_entrevista($this);
    }

    //Basado en puede_acceder, encapsula todas las revisiones por hacer respecto a R2, R3, R4
    public function puede_acceder_adjuntos() {
        return entrevista_individual::revisar_acceso_adjuntos($this);
    }

    ////PAra el controller, me permite determinar si puede modificar la entrevista.  Lo uso en la vista para ocultar botones de edición
    public function puede_modificar_entrevista($id_entrevistador = 0) {
        return entrevista_individual::revisar_modificar_entrevista($this);
    }
    //igual a puede_modificar_entrevista, pero no revisa que esté cerrada
    public function puede_desclasificar_entrevista() {
        return entrevista_individual::revisar_conceder_acceso($this);
    }

    //Para determinar si puede enviarse a transcribir
    public function getPuedeTranscribirseAttribute() {
        if($this->es_virtual==1) {
            $obligatorio=array(2);  //Audio para las virtuales
        }
        else {
            $obligatorio=array(1,2);  //Consentimiento y Audio
        }

        $puede=true;
        foreach($obligatorio as $id_tipo) {
            if($this->rel_adjunto()->where('entrevista_profundidad_adjunto.id_tipo',$id_tipo)->count()==0) {
                $puede=false;
                break;
            }
        }
        return $puede;
    }


    //Ver si fue asignada para transcribir
    public function revisar_asignacion() {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }

        $asignaciones = $this->arreglo_asignaciones();


        return in_array($this->id_entrevista_profundidad,$asignaciones);
    }

    //Para el scope de permisos
    public static function arreglo_asignaciones($id_subserie=0,$llave_primaria="") {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        $id_subserie = $id_subserie > 0 ? $id_subserie : config("expedientes.pr");
        $llave_primaria = strlen($llave_primaria) > 0 ? $llave_primaria : 'id_entrevista_profundidad';
        $asignadas_t = transcribir_asignacion::where('id_transcriptor',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->pluck($llave_primaria)->toArray();

        $asignadas_e = etiquetar_asignacion::where('id_transcriptor',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->pluck($llave_primaria)->toArray();

        $asignadas_m = acceso_edicion::where('id_autorizado',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->where('id_subserie',$id_subserie)
            ->pluck('id_entrevista')->toArray();

        $asignaciones = array_merge($asignadas_t, $asignadas_e, $asignadas_m);

        //Eliminar los valores no validos como null
        $limpio=array();
        foreach($asignaciones as $val) {
            if($val > 0) {
                $limpio[]=$val;
            }
        }

        return $limpio;
    }

    ////// FIN DE LOS CONTROLES DE SEGURIDAD

    //Mutators: Formatos de datos de la entrevista
    public function getFmtIdEntrevistadorAttribute() {
        $item = $this->rel_id_entrevistador;
        if($item) {
            return $item->fmt_nombre;
        }
        else {
            return "Desconocido ($this->id_entrevistador)";
        }
    }
    public function getFmtIdMacroterritorioAttribute() {
        $item = $this->rel_id_macroterritorio;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido ($this->id_macroterritorio)";
        }
    }
    public function getFmtIdTerritorioAttribute() {
        //return cev::nombre_completo($this->id_territorio);
        $ref=$this->rel_id_territorio;
        if($ref) {
            return $ref->descripcion;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtEntrevistaLugarAttribute() {
        return geo::nombre_completo($this->entrevista_lugar);
    }
    public function getFmtEntrevistaFechaInicioAttribute() {
        try {
            $fecha= new Carbon($this->entrevista_fecha_inicio);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtEntrevistaFechaFinalAttribute() {
        try {
            $fecha= new Carbon($this->entrevista_fecha_final);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }

    //Mostrar si está transcrita o etiquetada
    public function getFmtEstadoTranscripcionAttribute() {
        //
        $si = $this->rel_transcripcion()->where('id_situacion',2)->count();
        if($si>0) {
            $et = $this->rel_etiquetado()->where('id_situacion',2)->count();
            if($et >0 ) {
                return "<span class='text-success'>Etiquetada</span>";
            }
            else {
                return "<span class='text-success'>Transcrita</span>";
            }

        }
        else {
            $et = $this->rel_etiquetado()->where('id_situacion',2)->count();
            if($et >0 ) {
                return "<span class='text-success'>Etiquetada</span>";
            }
            else {

                $si = $this->rel_transcripcion()->where('id_situacion', 1)->count();
                if ($si > 0) {
                    return "<span class='text-warning'>En proceso</span>";
                } else {
                    //No transcrita por alguna razón
                    $negada = $this->rel_transcripcion()->where('id_situacion', 4)->orderby('fh_asignado', 'desc')->first();
                    //dd($negada);
                    if ($negada) {
                        $estado = "No";
                        if ($negada->id_causa) {
                            $razon = cat_item::describir($negada->id_causa);
                            $estado .= " - $razon";
                        }
                        return "<span class='text-danger'>$estado</span>";
                    }
                }
            }
        }
        //Sin asignación
        return "<span class='text-danger'>No</span>";
    }
    // Para el show: muestra la fecha como rango
    public function getFmtEntrevistaFechaRangoAttribute() {
        if($this->entrevista_fecha_final==$this->entrevista_fecha_inicio) {
            return $this->fmt_entrevista_fecha_inicio;
        }
        elseif(is_null($this->entrevista_fecha_final)) {
            return "Iniciada el ".$this->fmt_entrevista_fecha_inicio;
        }
        else {
            return $this->fmt_entrevista_fecha_inicio." al ".$this->fmt_entrevista_fecha_final;
        }
    }
    // Nuevos metadatos
    public function getFmtIdTipoAttribute() {
        return criterio_fijo::describir(15,$this->id_tipo);
    }
    public function getFmtIdPoliciaParteAttribute() {
        return criterio_fijo::describir(2,$this->id_policia_parte);
    }
    public function getFmtIdPoliciaRangoAttribute() {
        return cat_item::describir($this->id_policia_rango);
    }
    public function getFmtIdParamilitarParteAttribute() {
        return criterio_fijo::describir(2,$this->id_paramilitar_parte);
    }
    public function getFmtIdParamilitarRangoAttribute() {
        return cat_item::describir($this->id_paramilitar_rango);
    }
    public function getFmtIdGuerrillaParteAttribute() {
        return criterio_fijo::describir(2,$this->id_guerrilla_parte);
    }
    public function getFmtIdGuerrillaRangoAttribute() {
        return cat_item::describir($this->id_guerrilla_rango);
    }
    public function getFmtIdEjercitoParteAttribute() {
        return criterio_fijo::describir(2,$this->id_ejercito_parte);
    }
    public function getFmtIdEjercitoRangoAttribute() {
        return cat_item::describir($this->id_ejercito_rango);
    }
    public function getFmtIdFuerzaAereaParteAttribute() {
        return criterio_fijo::describir(2,$this->id_fuerza_aerea_parte);
    }
    public function getFmtIdFuerzaAereaRangoAttribute() {
        return cat_item::describir($this->id_fuerza_aerea_rango);
    }
    public function getFmtIdFuerzaNavalParteAttribute() {
        return criterio_fijo::describir(2,$this->id_fuerza_naval_parte);
    }
    public function getFmtIdFuerzaNavalRangoAttribute() {
        return cat_item::describir($this->id_fuerza_naval_rango);
    }
    public function getFmtIdTerceroCivilParteAttribute() {
        return criterio_fijo::describir(2,$this->id_tercero_civil_parte);
    }
    public function getFmtIdAgenteEstadoParteAttribute() {
        return criterio_fijo::describir(2,$this->id_agente_estado_parte);

    }
    //////////////////////////Para la edición de select multiple
    //Devuelve arreglo con violencia mencionada por el actor armado
    public function getArregloViolenciaActorAttribute() {
        $arreglo=array();
        foreach($this->rel_violencia_actor as $viol) {
            $arreglo[]=$viol->id_violencia;
        }
        return $arreglo;
    }
    //Devuelve arreglo con violencia mencionada por la vícitima
    public function getArregloViolenciaVictimaAttribute() {
        $arreglo=array();
        foreach($this->rel_violencia_victima as $viol) {
            $arreglo[]=$viol->id_violencia;
        }
        return $arreglo;
    }
    // Detalle de tipos de violacion de victima
    public function getFmtViolenciaVictimaAttribute() {
        $arreglo=array();
        foreach($this->rel_violencia_victima as $tv) {
            $arreglo[]=$tv->fmt_id_violencia;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de tipos de violacion de actor
    public function getFmtViolenciaActorAttribute() {
        $arreglo=array();
        foreach($this->rel_violencia_actor as $tv) {
            $arreglo[]=$tv->fmt_id_violencia;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }

    //Para descargar la plantilla
    public static function enlace_plantilla() {
        $url="";
        $doc = documento::find(parametro::find(4)->valor);
        if($doc) {
            $url.= $doc->fmt_url. "  ";
        }
        $doc = documento::find(parametro::find(7)->valor);
        if($doc) {
            if(strlen($url)>0) {
                $url.=" <br> ";
            }
            $url.= $doc->fmt_url;
        }
        return $url;
    }

    public function getFmtEntrevistaAvanceAttribute() {
        return cat_item::describir($this->entrevista_avance);
    }
    //Clasificacion
    public function getFmtClasificaNnaAttribute() {
        return $this->clasificacion_nna == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaSexAttribute() {
        return $this->clasificacion_sex == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaResAttribute() {
        return $this->clasificacion_res == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaR2Attribute() {
        return $this->clasificacion_r2 == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }

    //Para la edición de select multiple de mandato
    public function getArregloMandatoAttribute() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[]=$item->id_mandato;
        }
        return $arreglo;
    }
    // Para la tabla de adjuntos
    public function getAdjuntosAttribute() {
        return entrevista_profundidad_adjunto::listado_adjuntos($this->id_entrevista_profundidad);
    }
    public function getFmtIdSectorAttribute() {
        return cat_item::describir($this->id_sector);
    }
    //Para la edición de select multiple de nucleos tematicos
    public function getArregloInteresAttribute() {
        $arreglo=array();
        foreach($this->rel_interes as $item) {
            $arreglo[]=$item->id_interes;
        }
        return $arreglo;
    }
    //Devuelve un arreglo de tres posiciones, sirve para la edicion
    public function getArregloDinamicaAttribute() {
        $arreglo=array(null,null,null);
        $i=0;
        foreach($this->rel_dinamica as $item) {
            $arreglo[$i]=$item->dinamica;
            $i++;
        }
        return $arreglo;
    }
    //
    //Setters: Asignacion de datos de la entrevista
    public function setEntrevistaFechaInicioAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['entrevista_fecha_inicio']=$fecha;
    }
    public function setEntrevistaFechaFinalAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['entrevista_fecha_final']=$fecha;
    }
    public function setIdSectorAttribute($val) {
        $val = $val<=0 ? null : $val;
        $this->attributes['id_sector']=$val;
    }

    // Logica interna
    //Calculo de codigo que le toca, usado en insert
    public function asignar_codigo($id_entrevistador=0) {
        $id_subserie=config('expedientes.pr');
        $correlativo=correlativo::cual_toca($id_subserie);
        $this->entrevista_correlativo =$correlativo;
        $corr = str_pad($correlativo,5,"0",STR_PAD_LEFT);
        if($id_entrevistador > 0) {
            $this->id_entrevistador=$id_entrevistador;
        }
        $txt = $this->prefijo_codigo($id_subserie);
        $codigo = $txt.$corr;
        $this->entrevista_codigo = $codigo;
        return $codigo;
    }
    //Calcula el prefijo del código según la serie y el entrevistador
    public function prefijo_codigo() {
        $id_subserie=config('expedientes.pr');
        //Defaults, si no está autenticado (para pruebas)
        $txt="XX";
        $entrev="eee";
        $cual = cat_item::find($id_subserie);
        if($cual) {
            if(strlen($cual->abreviado) > 0) {
                $txt= $cual->abreviado;
            }
        }
        $quien = entrevistador::find($this->id_entrevistador);
        if($quien) {
            $entrev = $quien->fmt_numero_entrevistador;
        }
        $codigo = $entrev."-".$txt."-";
        return $codigo;
    }
    //Con los datos que tiene, calcula el código. Usado en udpate
    public function calcular_codigo() {
        $txt = $this->prefijo_codigo();
        $corr = str_pad($this->entrevista_correlativo,5,"0",STR_PAD_LEFT);
        return $txt.$corr;

    }
    //Para el create, establece el siguiente correlativo que le toca al entrevistador
    public function cual_toca() {
        $max=self::where('id_entrevistador',$this->id_entrevistador)
            ->max('entrevista_numero');
        $nuevo=intval($max)+1;
        return $nuevo;
    }
    //PAra el create, establece los valores predeterminados
    public function valores_iniciales($id_entrevistador) {
        $entrevistador = entrevistador::find($id_entrevistador);
        $this->id_entrevistador=$id_entrevistador;
        $this->entrevista_numero = $this->cual_toca();
        $this->entrevista_fecha_inicio = date("Y-m-d");
        $this->entrevista_fecha_final= date("Y-m-d");
        $this->id_territorio = $entrevistador->id_territorio;
        $this->entrevista_lugar = $entrevistador->id_ubicacion;
        $this->clasificacion_nna = 1;
        $this->clasificacion_sex = 1;
        $this->clasificacion_res = 1;
    }
    //Para reutilización de codigo
    public static function calcular_nivel_acceso($entrevista) {
        //Nivel 4 por defecto
        $nivel=4;

        // Nivel 3
        if($entrevista->clasificacion_nna==1) {
            $nivel=3;
        }
        if($entrevista->clasificacion_res==1) {
            $nivel=3;
        }
        if($entrevista->clasificacion_sex==1) {
            $nivel=3;
        }

        //Nivel 2
        //Compareciente, aplica únicamente a PR
        if($entrevista->id_tipo==5) {
            $entrevista->clasificacion_r2=1;
            $nivel=2;
        }
        //Comisionados
        if(isset($entrevista->id_entrevistador)) {   //update
            $e = entrevistador::find($entrevista->id_entrevistador);
            if($e) {
                if ($e->id_nivel==6) {
                    $nivel=2;
                    $entrevista->clasificacion_r2=1;
                }
            }
        }
        else {
            if(Gate::allows('nivel-6')) {  //insert
                $nivel=2;
                $entrevista->clasificacion_r2=1;
            }
        }

        //Nivel asignado de forma directa
        if($entrevista->clasificacion_r2==1) {
            $nivel=2;
        }

        // Nivel 1
        if($entrevista->clasificacion_r1==1) {
            $nivel=1;
        }

        $entrevista->clasificacion_nivel=$nivel;
        return $nivel;

    }
    //Determina el nivel de clasificacion del expediente
    public function clasificar_acceso() {
        return entrevista_profundidad::calcular_nivel_acceso($this);
    }

    // SCOPES: filtros y criterios de ordenado
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->entrevista_del = null;
        $filtro->entrevista_al = null;
        $filtro->entrevista_avance = -1;
        $filtro->entrevista_lugar = -1;
        $filtro->id_entrevistador = -1;
        $filtro->id_grupo = -1;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->entrevista_correlativo=null;
        $filtro->entrevista_codigo=null;
        $filtro->clasificacion_sex=-1;
        $filtro->clasificacion_res=-1;
        $filtro->clasificacion_nna=-1;
        $filtro->clasificacion_nivel=-1;
        $filtro->mandato=-1;
        $filtro->interes=-1;
        $filtro->dinamica="";
        $filtro->titulo="";
        $filtro->tema="";
        $filtro->br=null; //busqueda rapida
        //Propias del instrumento
        $filtro->id_sector = -1;
        $filtro->id_remitido = -1;
        $filtro->entrevista_objetivo = null;
        $filtro->entrevistado_nombres = null;
        $filtro->entrevistado_apellidos = null;
        $filtro->observaciones = null;
        $filtro->transcrita=-1;
        $filtro->etiquetada=-1;
        $filtro->marca=array();
        $filtro->id_cerrado=-1;
        $filtro->tema=null;
        $filtro->fts=null;
        $filtro->id_tesauro=-1;
        $filtro->id_activo=1; //Activos por default

        //Tesauro
        $filtro->id_tesauro = -1;
        //Buscadora avanzada
        $filtro->id_tesauro_2=-1;
        $filtro->id_tesauro_3=-1;
        $filtro->d_hecho_min=-1;
        $filtro->d_contexto_min=-1;
        $filtro->d_impacto_min=-1;
        $filtro->d_justicia_min=-1;


        //Nuevos metadatos
        $filtro->id_tipo=-1;
        $filtro->id_policia_parte=-1;
        $filtro->id_paramilitar_parte=-1;
        $filtro->id_guerrilla_parte=-1;
        $filtro->id_ejercito_parte=-1;
        $filtro->id_fuerza_aerea_parte=-1;
        $filtro->id_fuerza_naval_parte=-1;
        $filtro->id_tercero_civil_parte=-1;
        $filtro->id_agente_estado_parte=-1;
        //Priorizacion
        $filtro->tipo_prioridad=-1;
        $filtro->fluidez=-1;
        $filtro->cierre=-1;
        $filtro->d_hecho=-1;
        $filtro->d_contexto=-1;
        $filtro->d_impacto=-1;
        $filtro->d_justicia=-1;
        $filtro->ahora_entiendo="";
        $filtro->cambio_perspectiva="";
        $filtro->id_subserie = config('expedientes.pr'); //PAra el autofill
        //
        $filtro->con_transcripcion=-1;
        $filtro->con_etiquetado=-1;
        //parametro para filtrar por listado de excel
        $filtro->id_excel_listados =  -1;
        $filtro->id_excel_listados = isset($request->id_excel_listados) ? $request->id_excel_listados : $filtro->id_excel_listados;


        // Actualizar valores del REQUEST
        $filtro->con_transcripcion = isset($request->con_transcripcion) ? intval($request->con_transcripcion) : $filtro->con_transcripcion;
        $filtro->con_etiquetado = isset($request->con_etiquetado) ? intval($request->con_etiquetado) : $filtro->con_etiquetado;

        $filtro->entrevista_del = isset($request->entrevista_del_submit) ? $request->entrevista_del_submit : $filtro->entrevista_del;
        $filtro->entrevista_al = isset($request->entrevista_al_submit) ? $request->entrevista_al_submit : $filtro->entrevista_al;
        $filtro->entrevista_avance = isset($request->entrevista_avance) ? $request->entrevista_avance : $filtro->entrevista_avance;
        $filtro->entrevista_correlativo = isset($request->entrevista_correlativo) ? $request->entrevista_correlativo : $filtro->entrevista_correlativo;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;
        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;
        $filtro->id_grupo = isset($request->id_grupo) ? $request->id_grupo : $filtro->id_grupo;
        $filtro->clasificacion_sex = isset($request->clasificacion_sex) ? $request->clasificacion_sex : $filtro->clasificacion_sex;
        $filtro->clasificacion_res = isset($request->clasificacion_res) ? $request->clasificacion_res : $filtro->clasificacion_res;
        $filtro->clasificacion_nna = isset($request->clasificacion_nna) ? $request->clasificacion_nna : $filtro->clasificacion_nna;
        $filtro->clasificacion_nivel = isset($request->clasificacion_nivel) ? $request->clasificacion_nivel : $filtro->clasificacion_nivel;
        $filtro->mandato = isset($request->mandato) ? $request->mandato : $filtro->mandato;
        $filtro->interes = isset($request->interes) ? $request->interes : $filtro->interes;
        $filtro->dinamica = isset($request->dinamica) ? $request->dinamica : $filtro->dinamica;
        $filtro->titulo = isset($request->titulo) ? $request->titulo : $filtro->titulo;
        $filtro->tema = isset($request->tema) ? $request->tema : $filtro->tema;
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;
        //Determinar si es lp, muni o depto
        if(isset($request->entrevista_lugar_depto)){
            if($request->entrevista_lugar_depto > 0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar_depto;
            }
        }

        if(isset($request->entrevista_lugar_muni)){
            if($request->entrevista_lugar_muni > 0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar_muni;
            }
        }
        if(isset($request->entrevista_lugar)){
            if($request->entrevista_lugar > 0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar;
            }
        }
        //Determinar si es macro o territorio
        if(isset($request->id_territorio)) {
            if($request->id_territorio>0) {
                $filtro->id_territorio=$request->id_territorio;
                if(isset($request->id_territorio_macro)) {
                    $filtro->id_macroterritorio = $request->id_territorio_macro;
                }
            }
            else {

                if(isset($request->id_territorio_macro)) {
                    if($request->id_territorio_macro > 0) {
                        $filtro->id_macroterritorio=$request->id_territorio_macro;
                    }
                }

            }
        }
        else {  //Llamada directa desde una grafica
            if(isset($request->id_territorio_macro)) {
                $filtro->id_macroterritorio=$request->id_territorio_macro;
            }
        }


        //Filtros propios del instrumento
        $filtro->id_sector = isset($request->id_sector) ? $request->id_sector : $filtro->id_sector;
        $filtro->id_remitido = isset($request->id_remitido) ? $request->id_remitido : $filtro->id_remitido;
        $filtro->entrevista_objetivo = isset($request->entrevista_objetivo) ? $request->entrevista_objetivo : $filtro->entrevista_objetivo;
        $filtro->entrevistado_nombres = isset($request->entrevistado_nombres) ? $request->entrevistado_nombres : $filtro->entrevistado_nombres;
        $filtro->entrevistado_apellidos = isset($request->entrevistado_apellidos) ? $request->entrevistado_apellidos : $filtro->entrevistado_apellidos;
        $filtro->observaciones = isset($request->observaciones) ? $request->observaciones : $filtro->observaciones;
        $filtro->transcrita = isset($request->transcrita) ? intval($request->transcrita) : $filtro->transcrita;
        $filtro->etiquetada = isset($request->etiquetada) ? intval($request->etiquetada) : $filtro->etiquetada;
        $filtro->marca = isset($request->marca) ? $request->marca : $filtro->marca;
        $filtro->id_cerrado = isset($request->id_cerrado) ? $request->id_cerrado : $filtro->id_cerrado;
        //Nuevos metadatos

        $filtro->id_tipo = isset($request->id_tipo) ? intval($request->id_tipo) : $filtro->id_tipo;
        $filtro->id_policia_parte = isset($request->id_policia_parte) ? intval($request->id_policia_parte) : $filtro->id_policia_parte;
        $filtro->id_paramilitar_parte = isset($request->id_paramilitar_parte) ? intval($request->id_paramilitar_parte) : $filtro->id_paramilitar_parte;
        $filtro->id_guerrilla_parte = isset($request->id_guerrilla_parte) ? intval($request->id_guerrilla_parte) : $filtro->id_guerrilla_parte;
        $filtro->id_ejercito_parte = isset($request->id_ejercito_parte) ? intval($request->id_ejercito_parte) : $filtro->id_ejercito_parte;
        $filtro->id_fuerza_aerea_parte = isset($request->id_fuerza_aerea_parte) ? intval($request->id_fuerza_aerea_parte) : $filtro->id_fuerza_aerea_parte;
        $filtro->id_fuerza_naval_parte = isset($request->id_fuerza_naval_parte) ? intval($request->id_fuerza_naval_parte) : $filtro->id_fuerza_naval_parte;
        $filtro->id_tercero_civil_parte = isset($request->id_tercero_civil_parte) ? intval($request->id_tercero_civil_parte) : $filtro->id_tercero_civil_parte;
        $filtro->id_agente_estado_parte = isset($request->id_agente_estado_parte) ? intval($request->id_agente_estado_parte) : $filtro->id_agente_estado_parte;
        $filtro->id_activo = isset($request->id_activo) ? $request->id_activo : $filtro->id_activo;


        ///Priorizacion
        $filtro->tipo_prioridad = isset($request->tipo_prioridad) ? $request->tipo_prioridad : $filtro->tipo_prioridad;
        $filtro->fluidez = isset($request->fluidez) ? $request->fluidez : $filtro->fluidez;
        $filtro->cierre = isset($request->cierre) ? $request->cierre : $filtro->cierre;
        $filtro->d_hecho = isset($request->d_hecho) ? $request->d_hecho : $filtro->d_hecho;
        $filtro->d_contexto = isset($request->d_contexto) ? $request->d_contexto : $filtro->d_contexto;
        $filtro->d_impacto = isset($request->d_impacto) ? $request->d_impacto : $filtro->d_impacto;
        $filtro->d_justicia = isset($request->d_justicia) ? $request->d_justicia : $filtro->d_justicia;
        $filtro->ahora_entiendo = isset($request->ahora_entiendo) ? $request->ahora_entiendo : $filtro->ahora_entiendo;
        $filtro->cambio_perspectiva = isset($request->cambio_perspectiva) ? $request->cambio_perspectiva : $filtro->cambio_perspectiva;
        //Priorizacion como valor minimo
        $filtro->d_hecho_min = isset($request->d_hecho_min) ? $request->d_hecho_min : $filtro->d_hecho_min;
        $filtro->d_contexto_min = isset($request->d_contexto_min) ? $request->d_contexto_min : $filtro->d_contexto_min;
        $filtro->d_impacto_min = isset($request->d_impacto_min) ? $request->d_impacto_min : $filtro->d_impacto_min;
        $filtro->d_justicia_min = isset($request->d_justicia_min) ? $request->d_justicia_min : $filtro->d_justicia_min;

        //Full text search
        $filtro->fts = isset($request->fts) ? $request->fts : $filtro->fts;
        //Tesauro
        if(isset($request->id_tesauro_depto)){
            if($request->id_tesauro_depto > 0) {
                $filtro->id_tesauro=$request->id_tesauro_depto;
            }
        }
        if(isset($request->id_tesauro_muni)){
            if($request->id_tesauro_muni > 0) {
                $filtro->id_tesauro=$request->id_tesauro_muni;
            }
        }
        if(isset($request->id_tesauro)){
            if($request->id_tesauro > 0) {
                $filtro->id_tesauro=$request->id_tesauro;
            }
        }
        //Tesauro_2
        if(isset($request->id_tesauro_2_depto)){
            if($request->id_tesauro_2_depto > 0) {
                $filtro->id_tesauro_2=$request->id_tesauro_2_depto;
            }
        }
        if(isset($request->id_tesauro_2_muni)){
            if($request->id_tesauro_2_muni > 0) {
                $filtro->id_tesauro_2=$request->id_tesauro_2_muni;
            }
        }
        if(isset($request->id_tesauro_2)){
            if($request->id_tesauro_2 > 0) {
                $filtro->id_tesauro_2=$request->id_tesauro_2;
            }
        }
        //Tesauro_3
        if(isset($request->id_tesauro_3_depto)){
            if($request->id_tesauro_3_depto > 0) {
                $filtro->id_tesauro_3=$request->id_tesauro_3_depto;
            }
        }
        if(isset($request->id_tesauro_3_muni)){
            if($request->id_tesauro_3_muni > 0) {
                $filtro->id_tesauro_3=$request->id_tesauro_3_muni;
            }
        }
        if(isset($request->id_tesauro_3)){
            if($request->id_tesauro_3 > 0) {
                $filtro->id_tesauro_3=$request->id_tesauro_3;
            }
        }




        //Filtro por grupo del entrevistador
        if(\Auth::check()) {
            $usuario =\Auth::user();
            //Aplicar filtros por grupo
            if(in_array($usuario->id_nivel,[2,3,4])) {  //Que no sea admin
                if($usuario->id_grupo <> 1) { //Que no sea grupo CEV
                    $filtro->id_grupo = $usuario->id_grupo;
                }
            }
        }

        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            if(method_exists($request,'fullUrl')) {
                $url = $request->fullUrl();
                $pedazos = explode("?",$url);
                if(isset($pedazos[1])) {
                    $filtro->url = $pedazos[1]."&";

                }
                else {
                    $filtro->url="";
                }
            }
        }

        return $filtro;
    }
    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('entrevista_correlativo');
    }
    public static function scopeEntrevista_del($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("entrevista_fecha_inicio",'>=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeEntrevista_al($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("entrevista_fecha_inicio",'<=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeEntrevista_avance($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('entrevista_avance',$criterio);
        }
    }
    public static function scopeEntrevista_Lugar($query,$id_geo=-1) {
        if($id_geo>0) {
            $query->wherein('entrevista_lugar',geo::arreglo_contenidos($id_geo));
        }
    }
    public static function scopeId_entrevistador($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('esclarecimiento.entrevista_profundidad.id_entrevistador',$criterio);
        }
        elseif($criterio>0) {
            $query->where('esclarecimiento.entrevista_profundidad.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_macroterritorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_profundidad.id_macroterritorio',$criterio);
        }
    }
    public static function scopeId_territorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_profundidad.id_territorio',$criterio);
        }
    }
    public static function scopeEntrevista_correlativo($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_correlativo',$criterio);
        }
    }
    public static function scopeEntrevista_codigo($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevista_codigo','ilike',"%$criterio%");
        }
    }
    public static function scopeClasificacion_sex($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('clasificacion_sex',$criterio);
        }
    }
    public static function scopeClasificacion_nna($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('clasificacion_nna',$criterio);
        }
    }
    public static function scopeClasificacion_res($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('clasificacion_res',$criterio);
        }
    }
    public static function scopeClasificacion_nivel($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('clasificacion_nivel',$criterio);
        }
    }
    public static function scopeId_activo($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_profundidad.id_activo',$criterio);
        }
    }
    public static function scopeMandato($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_profundidad_mandato as fmandato', 'entrevista_profundidad.id_entrevista_profundidad', '=', 'fmandato.id_entrevista_profundidad')
                    ->wherein('id_mandato', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_profundidad_mandato as fmandato', 'entrevista_profundidad.id_entrevista_profundidad', '=', 'fmandato.id_entrevista_profundidad')
                    ->where('id_mandato',$criterio);
            }
        }
    }
    public static function scopeTitulo($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('titulo','ilike',"%$criterio%");
        }
    }
    public static function scopeDinamica($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->join('esclarecimiento.entrevista_profundidad_dinamica as fdinamica','entrevista_profundidad.id_entrevista_profundidad', '=', 'fdinamica.id_entrevista_profundidad')
                ->where('dinamica','ilike',"%$criterio%");
        }
    }
    public static function scopeTema($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->join('esclarecimiento.entrevista_profundidad_tema as ftema','entrevista_profundidad.id_entrevista_profundidad', '=', 'ftema.id_entrevista_profundidad')
                ->where('tema','ilike',"%$criterio%");
        }
    }
    public static function scopeInteres($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_profundidad_interes as finteres','entrevista_profundidad.id_entrevista_profundidad', '=', 'finteres.id_entrevista_profundidad')
                    ->wherein('id_interes', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_profundidad_interes as finteres','entrevista_profundidad.id_entrevista_profundidad', '=', 'finteres.id_entrevista_profundidad')
                    ->where('id_interes', $criterio);
            }
        }
    }
    public static function scopeTranscrita($query,$criterio=-1) {
        if($criterio==0) { //Sin asignar
            $query->wherenull('entrevista_profundidad.id_transcrita');
        }
        elseif($criterio>0) {
            $query->where('entrevista_profundidad.id_transcrita',$criterio);
        }
    }
    public static function scopeQuienTranscribe($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('public.transcribir_asignacion as taa','entrevista_profundidad.id_entrevista_profundidad','=','taa.id_entrevista_profundidad')
                ->where('taa.id_situacion',2)
                ->where('taa.id_transcriptor',$criterio);
        }
    }
    public static function scopeEtiquetada($query,$criterio=-1) {
        if($criterio==0) { //Sin asignar
            $query->wherenull('entrevista_profundidad.id_etiquetada');
        }
        elseif($criterio>0) {
            $query->where('entrevista_profundidad.id_etiquetada',$criterio);
        }
    }
    //Filtros basados en el campo, no en la asignación
    public static function scopeCon_Transcripcion($query, $criterio=-1) {
        if($criterio > 0) {
            if($criterio==1) {  //Sí
                $query->whereNotNull('html_transcripcion');
            }
            else { //No
                $query->whereNull('html_transcripcion');
            }
        }
    }
    public static function scopeCon_Etiquetado($query, $criterio=-1) {
        if($criterio > 0) {
            if($criterio==1) {  //Sí
                $query->whereNotNull('json_etiquetado');
            }
            else { //No
                $query->whereNull('json_etiquetado');
            }
        }
    }
    //Para saber si se cerró el procesamiento
    public static function scopeId_Cerrado($query, $criterio=-1){
        if($criterio>0) {
            $query->where('id_cerrado',$criterio);
        }
    }
    //Buscar en tesauro.  Recibe id_geo
    public function scopeTesauro($query, $criterio=-1) {
        $id_subserie = config('expedientes.pr');
        if($criterio > 0) {
            $contenidos = tesauro::find($criterio)->arreglo_incluidos();
            $universo =  etiqueta_entrevista::where('id_subserie',$id_subserie)
                                ->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                                ->wherein('ft.id_geo',$contenidos)
                                ->distinct()
                                ->pluck('id_entrevista');
            $query->wherein('entrevista_profundidad.id_entrevista_profundidad',$universo);
        }
    }

    //De acuerdo al perfil, aplica los permisos  (sustituida el 21-1-20)
    public static function scopePermisos_bak($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('entrevista_profundidad.id_entrevistador',$arreglo_entrevistadores);
        if(\Auth::check()) {  //Transcriptores
            if(\Auth::user()->id_nivel==11) {
                $asignadas = transcribir_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                    ->where('id_situacion',1)
                    ->pluck('id_entrevista_profundidad');
                //dd($asignadas);

                $query->wherein('entrevista_profundidad.id_entrevista_profundidad',$asignadas);

            }
        }


        //Ocultar los confidenciales
        $otros_confidenciales=entrevistador::where('id_nivel',6)
                ->where('id_entrevistador','<>',\Auth::user()->id_entrevistador)
                ->pluck('id_entrevistador')->toArray();

        $query->whereNotIn('entrevista_profundidad.id_entrevistador',$otros_confidenciales);



    }
    //Priorizacion
    public static function scopeTipo_prioridad($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp0','entrevista_profundidad.id_entrevista_profundidad','=','fp0.id_entrevista')
                ->where('fp0.id_subserie','=',config('expedientes.pr'))
                ->where('fp0.id_tipo',$criterio);
        }
    }
    public static function scopeFluidez($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp1','entrevista_profundidad.id_entrevista_profundidad','=','fp1.id_entrevista')
                ->where('fp1.id_subserie','=',config('expedientes.pr'))
                ->where('fp1.fluidez',$criterio);
        }
    }
    public static function scopeCierre($query,$criterio=-1) {
        if($criterio>=0) {
            $query->join('prioridad as fp2','entrevista_profundidad.id_entrevista_profundidad','=','fp2.id_entrevista')
                ->where('fp2.id_subserie','=',config('expedientes.pr'))
                ->where('fp2.cierre',$criterio);
        }
    }
    public static function scopeD_hecho($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','entrevista_profundidad.id_entrevista_profundidad','=','fp3.id_entrevista')
                ->where('fp3.id_subserie','=',config('expedientes.pr'))
                ->where('fp3.d_hecho',$criterio);
        }
    }
    public static function scopeD_impacto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','entrevista_profundidad.id_entrevista_profundidad','=','fp4.id_entrevista')
                ->where('fp4.id_subserie','=',config('expedientes.pr'))
                ->where('fp4.d_impacto',$criterio);
        }
    }
    public static function scopeD_contexto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','entrevista_profundidad.id_entrevista_profundidad','=','fp5.id_entrevista')
                ->where('fp5.id_subserie','=',config('expedientes.pr'))
                ->where('fp5.d_contexto',$criterio);
        }
    }
    public static function scopeD_justicia($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','entrevista_profundidad.id_entrevista_profundidad','=','fp6.id_entrevista')
                ->where('fp6.id_subserie','=',config('expedientes.pr'))
                ->where('fp6.d_justicia',$criterio);
        }
    }
    public static function scopeAhora_entiendo($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp7','entrevista_profundidad.id_entrevista_profundidad','=','fp7.id_entrevista')
                ->where('fp7.id_subserie','=',config('expedientes.pr'))
                ->where('fp7.ahora_entiendo','ilike',"%$criterio%");
        }
    }
    public static function scopeCambio_perspectiva($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp8','entrevista_profundidad.id_entrevista_profundidad','=','fp8.id_entrevista')
                ->where('fp8.id_subserie','=',config('expedientes.pr'))
                ->where('fp8.cambio_perspectiva','ilike',"%$criterio%");
        }
    }
    //Buscadora
    public static function scopeD_hecho_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','entrevista_profundidad.id_entrevista_profundidad','=','fp3.id_entrevista')
                ->where('fp3.id_subserie','=',config('expedientes.pr'))
                ->where('fp3.d_hecho','>=',$criterio);
        }
    }
    public static function scopeD_impacto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','entrevista_profundidad.id_entrevista_profundidad','=','fp4.id_entrevista')
                ->where('fp4.id_subserie','=',config('expedientes.pr'))
                ->where('fp4.d_impacto','>=',$criterio);
        }
    }
    public static function scopeD_contexto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','entrevista_profundidad.id_entrevista_profundidad','=','fp5.id_entrevista')
                ->where('fp5.id_subserie','=',config('expedientes.pr'))
                ->where('fp5.d_contexto','>=',$criterio);
        }
    }
    public static function scopeD_justicia_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','entrevista_profundidad.id_entrevista_profundidad','=','fp6.id_entrevista')
                ->where('fp6.id_subserie','=',config('expedientes.pr'))
                ->where('fp6.d_justicia','>=',$criterio);
        }
    }

    //De acuerdo al perfil, aplica los permisos.  Nueva versión de acuerdo al perfil
    /* LOGICA:
     * 1. Determina el acceso según el nivel (entrevistador, coord. territorio, coord. macro, etc.)
     * 2. Quita confidenciales  (ajenos)
     * 3. aplica filtro por grupo  (solo ruta pacifica, oim, etc.)
     */
    public static function scopePermisos($query) {
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            $asignadas = entrevista_profundidad::arreglo_asignaciones();
            $id_macroterritorio=\Auth::user()->id_macroterritorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( entrevista_profundidad.id_macroterritorio = $id_macroterritorio  OR entrevista_profundidad.id_entrevista_profundidad in ($asignadas_where) )"));
            }
            else {
                $query->where('entrevista_profundidad.id_macroterritorio',$id_macroterritorio);
            }
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            $asignadas = entrevista_profundidad::arreglo_asignaciones();
            $id_territorio=\Auth::user()->id_territorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( entrevista_profundidad.id_territorio = $id_territorio  OR entrevista_profundidad.id_entrevista_profundidad in ($asignadas_where) )"));
            }
            else {
                $query->where('entrevista_profundidad.id_territorio',$id_territorio);
            }

        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas(); //Asignación de otros entrevistadores
            $asignadas = entrevista_profundidad::arreglo_asignaciones();
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas); //Arreglo de entrevistas asignadas
                $entrevistadores_where = implode(",", $arreglo_entrevistadores);  //Arreglo de entrevistadores asignados
                $query->whereraw(DB::raw("( entrevista_profundidad.id_entrevistador in ($entrevistadores_where)  OR entrevista_profundidad.id_entrevista_profundidad in ($asignadas_where) )"));
            }
            else {
                $query->wherein('entrevista_profundidad.id_entrevistador',$arreglo_entrevistadores);
            }

        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            $asignadas = entrevista_profundidad::arreglo_asignaciones();
            $query->wherein('entrevista_profundidad.id_entrevista_profundidad',$asignadas);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('entrevista_profundidad.id_entrevistador',-1); //Ninguno
        }

        /*

        //Siempre quitar los otros confidenciales
        if(\Auth::check()) {
            $id_entrevistador = \Auth::user()->id_entrevistador;
        }
        else {
            $id_entrevistador = 0;
        }
        $otros_confidenciales=entrevistador::where('id_nivel',6)
            ->where('id_entrevistador','<>',$id_entrevistador)
            ->pluck('id_entrevistador')->toArray();
        $query->whereNotIn('entrevista_profundidad.id_entrevistador',$otros_confidenciales);
        */
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);

        //Si es de un grupo ajeno, agregar el filtro del grupo  (ruta pacifica, oim, etc)
        if(Gate::allows('grupo-ajeno')) {
            $query->join('esclarecimiento.entrevistador as fsg','entrevista_profundidad.id_entrevistador','=','fsg.id_entrevistador')
                ->where('fsg.id_grupo',\Auth::user()->id_grupo);
        }
    }





    //Filtro según el grupo al que pertenece
    public static function scopeId_grupo($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('esclarecimiento.entrevistador as fe','entrevista_profundidad.id_entrevistador','=','fe.id_entrevistador')
                ->where('fe.id_grupo',$criterio);
        }
    }

    //Filtros propios del instrumento
    public static function scopeId_sector($query,$criterio=-1 ) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_sector',$criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_sector',$criterio);
            }
        }
    }
    public static function scopeId_Remitido($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_remitido',$criterio);
        }
    }
    public static function scopeEntrevista_Objetivo($query, $criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)> 0) {
            $query->where("entrevista_objetivo",'ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevistado_Nombres($query, $criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)> 0) {
            $query->where("entrevistado_nombres",'ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevistado_Apellidos($query, $criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)> 0) {
            $query->where("entrevistado_apellidos",'ilike',"%$criterio%");
        }
    }
    public static function scopeObservaciones($query, $criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)> 0) {
            $query->where("observaciones",'ilike',"%$criterio%");
        }
    }
    //Nuevos metadatos
    public static function scopeId_Tipo($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_tipo',$criterio);
        }
    }
    public static function scopeId_policia_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_policia_parte',$criterio);
        }
    }
    public static function scopeId_paramilitar_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_paramilitar_parte',$criterio);
        }
    }
    public static function scopeId_guerrilla_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_guerrilla_parte',$criterio);
        }
    }
    public static function scopeId_ejercito_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_ejercito_parte',$criterio);
        }
    }
    public static function scopeId_fuerza_aerea_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_fuerza_aerea_parte',$criterio);
        }
    }
    public static function scopeId_fuerza_naval_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_fuerza_naval_parte',$criterio);
        }
    }
    public static function scopeId_tercero_civil_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_tercero_civil_parte',$criterio);
        }
    }
    public static function scopeId_agente_estado_parte($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_agente_estado_parte',$criterio);
        }
    }

    //Busqueda rapida
    public static function scopeBR($query,$criterio="") {
        $criterio=trim($criterio);
        if(is_numeric($criterio) and intval($criterio)>0) {
            $query->where('entrevista_correlativo',$criterio);
        }
        elseif(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);

            $where[]="entrevista_profundidad.entrevista_codigo ilike '%$criterio%'";
            $where[]="entrevista_profundidad.entrevista_objetivo ilike '%$criterio%'";
            $where[]="entrevista_profundidad.entrevistado_nombres ilike '%$criterio%'";
            $where[]="entrevista_profundidad.entrevistado_apellidos ilike '%$criterio%'";
            $where[]="entrevista_profundidad.observaciones ilike '%$criterio%'";
            $where[]="entrevista_profundidad.titulo ilike '%$criterio%'";


            //$where[]="prioritario_tema ilike '%$criterio%'";
            //$where[]="dinamica ilike '%$criterio%'";
            $str_where=implode(" or ",$where);
            //$query->join('esclarecimiento.e_ind_fvt_dinamica as fd','e_ind_fvt.id_e_ind_fvt','=','fd.id_e_ind_fvt')
            //       ->whereraw("( $str_where )");
            $query->whereraw(" ( $str_where )");

        }
    }

    //Busqueda de full text search
    public static function scopeFTS($query,$criterio="")  {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank, entrevista_profundidad.id_entrevista_profundidad"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
            //$query->orderby('rank');
            //$query->orderby('entrevista_codigo');
        }
    }

    public static function scopeMarca($query, $criterio=0) {
        if(!is_array($criterio)) {
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(count($criterio)>0) {
            $id_entrevistador = \Auth::check() ? \Auth::user()->id_entrevistador : 0;
            $query->join('esclarecimiento.marca_entrevista as filtro_marca','entrevista_profundidad.id_entrevista_profundidad','=','filtro_marca.id_entrevista')
                ->where('filtro_marca.id_subserie','=',config('expedientes.pr'))
                ->where('filtro_marca.id_entrevistador',$id_entrevistador)
                ->wherein('id_marca',$criterio);
        }
    }



    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        $query->entrevista_del($criterios->entrevista_del)
            ->entrevista_al($criterios->entrevista_al)
            ->entrevista_avance($criterios->entrevista_avance)
            ->entrevista_lugar($criterios->entrevista_lugar)
            ->id_entrevistador($criterios->id_entrevistador)
            ->id_macroterritorio($criterios->id_macroterritorio)
            ->id_territorio($criterios->id_territorio)
            ->entrevista_correlativo($criterios->entrevista_correlativo)
            ->entrevista_codigo($criterios->entrevista_codigo)
            ->clasificacion_sex($criterios->clasificacion_sex)
            ->clasificacion_nna($criterios->clasificacion_nna)
            ->clasificacion_res($criterios->clasificacion_res)
            ->clasificacion_nivel($criterios->clasificacion_nivel)
            ->mandato($criterios->mandato)
            ->interes($criterios->interes)
            ->dinamica($criterios->dinamica)
            ->titulo($criterios->titulo)
            ->br($criterios->br)

            ->id_cerrado($criterios->id_cerrado)
            ->id_grupo($criterios->id_grupo)
            ->id_activo($criterios->id_activo)
            //Scopes especificos
            ->id_sector($criterios->id_sector)
            ->id_remitido($criterios->id_remitido)
            ->entrevista_objetivo($criterios->entrevista_objetivo)
            ->entrevistado_nombres($criterios->entrevistado_nombres)
            ->entrevistado_apellidos($criterios->entrevistado_apellidos)
            ->transcrita($criterios->transcrita)
            ->etiquetada($criterios->etiquetada)
            ->marca($criterios->marca)
            ->observaciones($criterios->observaciones)
            ->tema($criterios->tema)
            ->id_tipo($criterios->id_tipo)
            ->id_policia_parte($criterios->id_policia_parte)
            ->id_paramilitar_parte($criterios->id_paramilitar_parte)
            ->id_guerrilla_parte($criterios->id_guerrilla_parte)
            ->id_ejercito_parte($criterios->id_ejercito_parte)
            ->id_fuerza_aerea_parte($criterios->id_fuerza_aerea_parte)
            ->id_fuerza_naval_parte($criterios->id_fuerza_naval_parte)
            ->id_tercero_civil_parte($criterios->id_tercero_civil_parte)
            ->id_agente_estado_parte($criterios->id_agente_estado_parte)
            //priorizacion
            ->tipo_prioridad($criterios->tipo_prioridad)
            ->fluidez($criterios->fluidez)
            ->cierre($criterios->cierre)
            ->d_hecho($criterios->d_hecho)
            ->d_impacto($criterios->d_impacto)
            ->d_contexto($criterios->d_contexto)
            ->d_justicia($criterios->d_justicia)
            ->ahora_entiendo($criterios->ahora_entiendo)
            ->cambio_perspectiva($criterios->cambio_perspectiva)
            //priorizacion minima
            ->d_hecho_min($criterios->d_hecho_min)
            ->d_impacto_min($criterios->d_impacto_min)
            ->d_contexto_min($criterios->d_contexto_min)
            ->d_justicia_min($criterios->d_justicia_min)
            //Buscadora
            ->tesauro($criterios->id_tesauro)
            ->tesauro($criterios->id_tesauro_2)
            ->tesauro($criterios->id_tesauro_3)
            ->fts($criterios->fts) //Full text search
            // Con base al campo
            ->con_transcripcion($criterios->con_transcripcion)
            ->con_etiquetado($criterios->con_etiquetado)
            //Filtro por listados
            ->id_excel_listados($criterios->id_excel_listados);
        //Seguridad
        if(Gate::denies('permisos-legado')) {
            $query->permisos();
        }
    }

    //Para asingar etiquetado/transcripcion
    public static function scopeProcesable($query) {
        $a=array();
        $b=array();
        $c=array();
        //Primer grupo: virtuales
        $a = entrevista_profundidad::join('esclarecimiento.entrevista_profundidad_adjunto as a_au','entrevista_profundidad.id_entrevista_profundidad','=','a_au.id_entrevista_profundidad')
            ->where('a_au.id_tipo',2)
            ->where('es_virtual',1)->distinct()->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();
        //Segundo grupo: no virtuales
        $b = entrevista_profundidad::join('esclarecimiento.entrevista_profundidad_adjunto as a_ci','entrevista_profundidad.id_entrevista_profundidad','=','a_ci.id_entrevista_profundidad')
            ->where('a_ci.id_tipo',1)
            ->join('esclarecimiento.entrevista_profundidad_adjunto as a_au','entrevista_profundidad.id_entrevista_profundidad','=','a_au.id_entrevista_profundidad')
            ->where('a_au.id_tipo',2)
            ->where('es_virtual',2)->distinct()->pluck('entrevista_profundidad.id_entrevista_profundidad')->toArray();

        $c = array_merge($a, $b);
        $query->wherein('entrevista_profundidad.id_entrevista_profundidad',$c);
        /*
        //Consentimiento
        $query->join('esclarecimiento.entrevista_profundidad_adjunto as a_ci','entrevista_profundidad.id_entrevista_profundidad','=','a_ci.id_entrevista_profundidad')
            ->where('a_ci.id_tipo',1);
        //Audio
        $query->join('esclarecimiento.entrevista_profundidad_adjunto as a_au','entrevista_profundidad.id_entrevista_profundidad','=','a_au.id_entrevista_profundidad')
            ->where('a_au.id_tipo',2);
        */

    }



    //Para controlar si tiene los adjuntos requeridos
    public function verificar_adjunto($tipo=0) {
        return $this->rel_adjunto()->where('id_tipo',$tipo)->count();
    }
    public function getTieneCFAttribute() { //tiene_cf: consentimiento infomado
        return $this->verificar_adjunto(1) > 0 ? 1 : 0;
    }
    public function getTieneAudioAttribute() {  //tiene_audio: Audio
        return $this->verificar_adjunto(2) > 0 ? 1 : 0;
    }
    public function getTieneFcAttribute() { //tiene_fc: Ficha corta
        return $this->verificar_adjunto(3) > 0 ? 1 : 0;
    }
    public function getTieneOtrosAttribute() { //tiene_otros: Otros
        return $this->verificar_adjunto(4) > 0 ? 1 : 0;
    }
    public function getTieneFlAttribute() { //tiene_fl: ficha larga
        return $this->verificar_adjunto(5) > 0 ? 1 : 0;
    }
    public function getTieneTfAttribute() { //tiene_tf: transcripcion final
        return $this->verificar_adjunto(6) > 0 ? 1 : 0;
    }
    public function getTieneRefAttribute() { //tiene_ref: referencias
        return $this->verificar_adjunto(7) > 0 ? 1 : 0;
    }
    public function getTieneTpAttribute() { //tiene_tp: transcripcion preliminar (automática)
        return $this->verificar_adjunto(8) > 0 ? 1 : 0;
    }
    public function getTieneRetroaAttribute() { //tiene_retroa: Retroalimentacion
        return $this->verificar_adjunto(10) > 0 ? 1 : 0;
    }
    public function getTieneRelAttribute() { //tiene_rel: Relatoría
        return $this->verificar_adjunto(11) > 0 ? 1 : 0;
    }
    public function getTieneCertAttribute() { //tiene_cert: Certificaciones
        return $this->verificar_adjunto(12) > 0 ? 1 : 0;
    }
    public function getTieneNevAttribute() { //tiene_nev: NNA: evaluacion de Vulnerabilidad
        return $this->verificar_adjunto(13) > 0 ? 1 : 0;
    }
    public function getTieneNesAttribute() { //tiene_nes: NNA: evaluacion de Seguridad
        return $this->verificar_adjunto(14) > 0 ? 1 : 0;
    }
    //tiene etiquetado?
    public function getTieneEtiquetadoAttribute() { //Tiene etiquetado
        //return $this->verificar_adjunto(25) > 0 ? 1 : 0;
        return strlen($this->json_etiquetado)>0 ? 1 : 0;
    }
    public function getTieneTranscripcionAttribute() {
        return strlen($this->html_transcripcion)>0 ? 1 : 0;
    }
    //Determina si tiene asignación pendiente.  PAra no enviar dos veces el mismo
    public function getAsignadoEtiquetadoAttribute() {
        $existe = etiquetar_asignacion::where('id_entrevista_profundidad',$this->id_entrevista_profundidad)->where('id_situacion',1)->first();
        return $existe ? 1 : 0;
    }

    //Para el autofill
    //Autofill de un campo de la tabla
    public static function listar_opciones_campo($campo,$criterio="") {
        $crterio=trim($criterio);
        $filtros = self::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $opciones= self::filtrar($filtros)->where($campo,'ilike',"%$criterio%")->distinct()->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }

    //Autofill de dinamica
    public static function listar_opciones_dinamica($criterio="") {
        $crterio=trim($criterio);
        $filtros = self::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $opciones= self::filtrar($filtros)->join('esclarecimiento.entrevista_profundidad_dinamica','entrevista_profundidad.id_entrevista_profundidad','=','entrevista_profundidad_dinamica.id_entrevista_profundidad')
            ->where('dinamica','ilike',"%$criterio%")->distinct()->limit(30)->orderby('dinamica')->pluck('dinamica')->toArray();
        return $opciones;
    }
    //Autofill de tema
    public static function listar_opciones_tema($criterio="") {
        $crterio=trim($criterio);
        $filtros = self::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $opciones= self::filtrar($filtros)->join('esclarecimiento.entrevista_profundidad_tema','entrevista_profundidad.id_entrevista_profundidad','=','entrevista_profundidad_tema.id_entrevista_profundidad')
            ->where('tema','ilike',"%$criterio%")->distinct()->limit(30)->orderby('tema')->pluck('tema')->toArray();
        return $opciones;
    }


    /*
     * INTERCONEXION CON DATATURKS
     */


    //Esta función es un wrapper que facilita las cosas
    public function dataturk_enviar_todo($id_entrevistador=10) {
        return entrevista_individual::dataturk_crear_y_asignar($this,$id_entrevistador);
    }



    // Crear el proyecto en dataturks
    public function dataturk_crear_proyecto() {
        $insercion = tesauro::dataturk_crear_proyecto($this);
        return $insercion;
    }

    //Eliminar un proyecto
    public function dataturk_eliminar_proyecto() {
        return tesauro::dataturk_eliminar_proyecto($this->entrevista_codigo);
    }

    //Funcion que envia al dataturk la transcripcion como un solo texto
    public function dataturk_enviar_texto() {
        $cuanto=config('expedientes.turk_limit');
        if(!empty($this->json_etiquetado)) {
            $txt = $this->json_etiquetado;
            $tipo=2;//Etiquetado
        }
        else {
            $txt = $this->extraer_texto_transcripcion();
            //Bug de dataturk que no acepta textos largos
            $txt=substr($txt,0,$cuanto);
            $tipo=1; //texto
        }

        $envio = tesauro::dataturk_subir_archivo($this->entrevista_codigo,$txt,$tipo);
        return $envio;
    }

    public function extraer_texto_transcripcion() {
        return $this->fmt_html_transcripcion;
    }

    public function dataturk_asignar_etiquetador($id_entrevistador=10) {
        $e = entrevistador::find($id_entrevistador);
        $correo = $e ? $e->correo : "invalido_$id_entrevistador@gmail.com";
        $respuesta = tesauro::dataturk_asignar_etiquetador($correo,$this->entrevista_codigo);
        return $respuesta;
    }

    public function dataturk_quitar_etiquetador($id_entrevistador=10) {
        $e = entrevistador::find($id_entrevistador);
        $correo = $e ? $e->correo : "invalido_$id_entrevistador@gmail.com";
        $respuesta = tesauro::dataturk_quitar_etiquetador($correo,$this->entrevista_codigo);
        return $respuesta;
    }



    //Descarga el etiquetado, lo adjunta y lo procesa
    public function dataturk_traer_etiquetado() {
        $respuesta = new \stdClass();
        $respuesta->exito = false;
        $respuesta->etiquetado = null;
        $recibido = tesauro::dataturk_descargar_etiquetado($this->entrevista_codigo);
        if($recibido->exito) {
            //dd($recibido->respuesta);
            $json = $recibido->respuesta;
            $adjunto = adjunto::crear_archivo(json_encode($json));
            $adjuntado = new entrevista_profundidad_adjunto();
            $adjuntado->id_entrevista_profundidad = $this->id_entrevista_profundidad;
            $adjuntado->id_adjunto = $adjunto->id_adjunto;
            $adjuntado->id_tipo = 25;
            $adjuntado->save();
            //Procesar las etiquetas
            $respuesta->etiquetado = $adjuntado->procesar_etiquetas();
            $respuesta->exito = true;
        }
        else {
            Flash::error("No se pudo extraer el texto de dataturk.  ¿faltó darle click a 'Finalizar' en dataturk?");
            Log::warning($recibido->respuesta);
            Log::warning("Problemas al extraer el texto etiquetado del dataturk para la entrevista $this->entrevista_codigo");
            $respuesta->etiquetado = $recibido;
        }
        return $respuesta;
    }

    //Mostrar la transcripcion mas bonita
    public function getFmtHtmlTranscripcionAttribute() {
        $transcripcion = $this->html_transcripcion;

        //Corregir tags de otranscribe
        $quitar= '<p><span> </span></p>';
        $transcripcion = str_ireplace($quitar,'',$transcripcion);

        //Limpiador de html, meterle los retornos de linea como html
        $html = new Html2Text(nl2br($transcripcion),['width'=>0]);
        $txt = $html->getText(0);
        //Quitar retornos de linea dobles
        $txt = preg_replace( "/([\r\n]{4,}|[\n]{2,}|[\r]{2,})/", "\n", $txt);
        //Fin del proceso
        return $txt;
    }
    //Nombre del entrevistado
    public function getFmtNombreEntrevistadoAttribute() {
        $partes=array();
        if(strlen(trim($this->entrevistado_nombres))) {
            $partes[] = $this->entrevistado_nombres;
        }

        if(strlen(trim($this->entrevistado_apellidos))) {
            $partes[] = "(".$this->entrevistado_apellidos.")";
        }
        if(count($partes)==0) {
            $partes[]="(sin especificar)";
        }
        return implode(" ",$partes);

    }




    // Leer html del adjunto
    public function halar_transcripcion() {
        if(strlen($this->json_etiquetado)<=0 && strlen($this->html_transcripcion)<=0) {
            $adjunto = $this->rel_adjunto()->where('id_tipo',6)->orderby('id_adjunto','desc')->first();
            if($adjunto) {
                $transcripcion = $adjunto->rel_id_adjunto;
                if($transcripcion->existe) {
                    $html = Storage::get('public/'.$transcripcion->ubicacion);
                    if($html) {
                        $this->html_transcripcion = $html;
                        $this->save();
                        return true;
                    }
                }
                else {
                    return false;
                }

            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
        return false;
    }

    //Desplegar prioridad
    public function getPrioridadAttribute() {
        $existe = prioridad::where('id_entrevista',$this->id_entrevista_profundidad)->where('id_subserie',config('expedientes.pr'))
            ->orderby('id_tipo','desc')
            ->orderby('fecha_hora','desc')
            ->first();
        if($existe) {
            return $existe;
        }
        else {
            return false;
        }
    }

    //Información para el dashboard principal
    public static function datos_dash($filtros=null) {
        if(!is_object($filtros)) {
            $filtros = entrevista_profundidad::filtros_default();
        }
        //Tipo de entrevista
        $query=self::filtrar($filtros)
            ->join('catalogos.criterio_fijo','entrevista_profundidad.id_tipo','=','criterio_fijo.id_opcion')
            ->select(\DB::raw("criterio_fijo.id_opcion as id_item, criterio_fijo.descripcion as txt, count(1) as conteo"))
            ->where('criterio_fijo.id_grupo',15)
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');

        //$debug['sql']=$query->toSql();
        //$debug['par']=$query->getBindings();
        $info = $query->get();
        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $tipo = new \stdClass();
        $tipo->categorias = $categorias;
        $tipo->a_serie[] = $datos;
        $tipo->nombre_serie[]="Entrevistas";
        $tipo->descarga="pr_tipo";
        $tipo->grafica=graficador::g_columna($tipo);


        //Sector
        //Tipo de entrevista
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_profundidad.id_sector','=','cat_item.id_item')
            ->select(\DB::raw("cat_item.id_item as id_item, cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');

        //$debug['sql']=$query->toSql();
        //$debug['par']=$query->getBindings();
        $info = $query->get();
        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $sector = new \stdClass();
        $sector->categorias = $categorias;
        $sector->a_serie[] = $datos;
        $sector->nombre_serie[]="Entrevistas";
        $sector->descarga="pr_sector";
        $sector->grafica=graficador::g_barra($sector);

        $respuesta = new \stdClass();
        $respuesta->tipo = $tipo;
        $respuesta->sector = $sector;

        return $respuesta;



    }

    //Para convertir el tesauro en nube de etiquetas
    public function etiquetas_a_texto() {
        $listado = entrevista_individual::listado_etiquetas(config('expedientes.pr'), $this->id_entrevista_profundidad);
        return implode(" ",$listado);
    }

    public static function revisar_codigo() {
        $listado = self::orderby('id_entrevista_profundidad')->get();
        $conteo=0;
        $errores=array();
        foreach($listado as $entrevista) {
            $codigo = $entrevista->calcular_codigo();
            if($entrevista->entrevista_codigo <> $codigo) {
                $entrevista->entrevista_codigo = $codigo;
                try {
                    $entrevista->save();
                    $conteo++;
                }
                catch (\Exception $e) {
                    $errores[]=$entrevista->id_entrevista_colectiva;
                }

                $conteo++;
            }
        }
        $res['corregidas']=$conteo;
        $res['errores']=$errores;
        return $res;
    }

    //Para mostrar el consentimiento informado
    public function getConsentimientoAttribute() {
        //$existe= entrevista::where('id_entrevista_profundidad',$this->id_entrevista_profundidad)->first();
        $existe= $this->rel_consentimiento;

        if(!$existe) {
            $existe = new \App\Models\entrevista();
        }
        return $existe;
    }

    //Alertas del consentimiento informado
    public function getDiligenciadaAttribute() {
        return $this->conteo_fichas();
    }


    // LOGICA DE LOS FORMULARIOS COMPLETOS (diligenciar fichas)
    public function conteo_fichas() {
        $conteo = new \stdClass();
        $conteo->existe = false;
        $conteo->existe_persona_entrevistada = false;
        $conteo->btn_consentimiento="";
        $conteo->btn_show="";
        $conteo->consentimiento_alertas = array();
        //$conteo->consentimiento = entrevista::where('id_entrevista_profundidad',$this->id_entrevista_profundidad)->first();
        $conteo->consentimiento = $this->rel_consentimiento;
        //$url=action('entrevista_profundidadController@frm_ci',$this->id_entrevista_profundidad);
        $url=action('persona_entrevistadaController@create')."?id_entrevista_profundidad=$this->id_entrevista_profundidad";
        $title='Diligenciar consentimiento informado';
        $color="btn-info";
        if($conteo->consentimiento) {
            $conteo->existe=true;
            if ($conteo->consentimiento->conceder_entrevista <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó esta entrevista";
            }
            if ($conteo->consentimiento->grabar_audio  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó grabar la entrevista";
            }
            if ($conteo->consentimiento->elaborar_informe  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no está de acuerdo en que su entrevista sea utilizada para elaborar el Informe Final";
            }
            if ($conteo->consentimiento->tratamiento_datos_analizar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos personales para ser analizados";
            }
            if ($conteo->consentimiento->tratamiento_datos_analizar_sensible  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos sensibles para ser analizados";
            }
            if ($conteo->consentimiento->tratamiento_datos_utilizar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos personales para la elaboración del informe final";
            }
            if ($conteo->consentimiento->tratamiento_datos_utilizar_sensible  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos sensibles para la elaboración del informe final";
            }
            if ($conteo->consentimiento->tratamiento_datos_publicar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza publicar su nombre en el informe final";
            }
        }
        else {
            $conteo->consentimiento_alertas[] = "No se ha diligenciado el consentimiento informado";
        }

        //Persona entrevistada
        $persona_entrevistada = $this->rel_persona_entrevistada;
        if($persona_entrevistada) {
            $conteo->existe_persona_entrevistada =true;
        }
        else {
            $conteo->consentimiento_alertas[] = "No se ha diligenciado la ficha de persona entrevistada";
        }



        if($conteo->existe && $conteo->existe_persona_entrevistada) {
            $color="btn-success";
            $title = "Se ha diligenciado el consentimiento informado y la ficha de persona entrevistada";
            $url = action('persona_entrevistadaController@show',$this->rel_persona_entrevistada->id_persona_entrevistada);
            $conteo->btn_show = "<a href='$url' class='btn btn-default btn-sm ' title='Mostrar ficha de persona entrevistada' data-toggle='tooltip'><i class='fa fa-send-o'></i></a>";

        }
        elseif(!$conteo->existe && !$conteo->existe_persona_entrevistada) {
            $color="btn-danger";
            $title = "No Se ha diligenciado el consentimiento informado ni la ficha de persona entrevistada";
        }
        else {
            $color="btn-warning";
            if(!$conteo->existe) {
                $title = "No se ha diligenciado el consentimiento informado";
            }
            if(!$conteo->existe_persona_entrevistada) {
                $title = "No se ha diligenciado la ficha de persona entrevistada";
            }
        }


        if(count($conteo->consentimiento_alertas)>0) {
            //$title .= ' ->Existen alertas en el consentimiento informado';
        }


        if($this->puede_modificar_entrevista()) {
            $url=action('persona_entrevistadaController@create')."?id_entrevista_profundidad=$this->id_entrevista_profundidad";
            $conteo->btn_consentimiento = "<a href='$url' title='$title' data-toggle='tooltip' class='btn $color btn-sm'><i class='fa fa-send'></i></a>";
        }
        else {
            $conteo->btn_consentimiento="";
        }

        return $conteo;

    }

    //Usado en store() y update()
    public function procesar_consentimiento($request) {
        if(intval($this->id_entrevista_profundidad) <= 0) {  // Por si acaso
            return false;
        }
        if(isset($request->identificacion_consentimiento)) {
            $existe = entrevista::where('id_entrevista_profundidad',$this->id_entrevista_profundidad)->first();
            if($existe) {
                $existe->fill($request->all());
                $existe->update_ent=\Auth::user()->id_entrevistador;
                $existe->update_fh=\Carbon\Carbon::now();
                $existe->update_ip=\Request::ip();
                $existe->save();
                Flash::success("Consentimiento actualizado exitosamente");
                //Registrar traza
                traza_actividad::create(['id_objeto'=>105, 'id_accion'=>4, 'codigo'=>$this->entrevista_codigo, 'referencia'=>'id_entrevista_profundidad = '.$this->id_entrevista_profundidad , 'id_primaria'=>$existe->id_entrevista]);
            }
            else {
                $nuevo = new entrevista();
                $nuevo->fill($request->all());
                $nuevo->id_entrevista_profundidad=$this->id_entrevista_profundidad;
                $nuevo->insert_ent=\Auth::user()->id_entrevistador;
                $nuevo->insert_fh=\Carbon\Carbon::now();
                $nuevo->insert_ip=\Request::ip();
                $nuevo->save();
                traza_actividad::create(['id_objeto'=>105, 'id_accion'=>3, 'codigo'=>$this->entrevista_codigo, 'referencia'=>'id_entrevista_profundidad = '.$this->id_entrevista_profundidad , 'id_primaria'=>$nuevo->id_entrevista]);
            }
        }
    }

    //Para Lina Forero: cambiar una entrevista a otro usuario
    public function trasladar($id_entrevistador=0) {
        $quien=entrevistador::find($id_entrevistador);
        if($quien) {
            if($this->id_entrevistador <> $id_entrevistador) {
                $this->id_entrevistador = $id_entrevistador;
                $this->entrevista_numero = $this->cual_toca();
                $this->entrevista_codigo = $this->calcular_codigo();
                $this->save();
                return $this->entrevista_codigo;
            }
            else {
                echo "Mismo entrevistador";
                return false;
            }

        }
        else {
            echo "No existe el entrevistador $id_entrevistador";
            return false;
        }
    }


    //Convierte en entrevista colectiva
    //Convierte en entrevista colectiva
    public function trasladar_co() {
        //Crear CO
        $nueva = new entrevista_colectiva();
        $nueva->id_macroterritorio = $this->id_macroterritorio;
        $nueva->id_territorio = $this->id_territorio;
        $nueva->es_virtual = $this->es_virtual;
        $nueva->id_entrevistador = $this->id_entrevistador;
        $nueva->numero_entrevistador = $this->numero_entrevistador;
        $nueva->entrevista_numero = $nueva->cual_toca();
        $nueva->asignar_codigo($nueva->id_entrevistador);
        $nueva->entrevista_lugar = $this->entrevista_lugar;
        $nueva->titulo = $this->titulo;
        $nueva->observaciones = $this->observaciones;
        $nueva->clasificacion_nna = $this->clasificacion_nna;
        $nueva->clasificacion_sex = $this->clasificacion_sex;
        $nueva->clasificacion_res = $this->clasificacion_res;
        $nueva->clasificacion_r2 = $this->clasificacion_r2;
        $nueva->clasificacion_r1 = $this->clasificacion_r1;
        $nueva->clasificacion_nivel = $this->clasificacion_nivel;
        $nueva->id_transcrita = $this->id_transcrita;
        $nueva->id_etiquetada = $this->id_etiquetada;
        if($this->id_sector==null) {
            $nueva->id_sector = config('expedientes.pr_sector');
        }
        else {
            $nueva->id_sector = $this->id_sector;
        }

        //Facilitador
        $e = $this->rel_id_entrevistador;
        $nueva->equipo_facilitador = $e->fmt_numero_nombre;
        $nueva->equipo_memorista = $e->fmt_numero_nombre;
        $nueva->tema_objetivo = $this->entrevista_objetivo;
        $nueva->tema_descripcion = "Traslado desde la entrevista $this->entrevista_codigo";
        $nueva->tema_del = substr($this->entrevista_fecha_inicio,0,10);
        $nueva->tema_al = substr($this->entrevista_fecha_final, 0, 10);
        $nueva->tema_lugar = $this->entrevista_lugar;
        $nueva->cantidad_participantes = 1;
        $nueva->eventos_descripcion = "Sin especificar";



        if(\Auth::check()) {
            $nueva->id_usuario = \Auth::user()->id;
        }
        else {
            $nueva->id_usuario=1;
        }

        //dd($this->entrevista_fecha);
        $nueva->entrevista_fecha_inicio = substr($this->entrevista_fecha_inicio,0,10);
        $nueva->entrevista_fecha_final = substr($this->entrevista_fecha_final,0,10);
        $nueva->entrevista_avance = $this->entrevista_avance;

        $nueva->tiempo_entrevista = $this->tiempo_entrevista;
        //Transcripcion/etiquetado
        $nueva->html_transcripcion = $this->html_transcripcion;
        $nueva->json_etiquetado = $this->json_etiquetado;
        $nueva->id_activo =1;
        $nueva->id_cerrado = $this->id_cerrado;
        $nueva->es_virtual = $this->es_virtual;
        //dd($nueva);
        //GRABAR y continuar con el detalle
        try {
            $nueva->save();
            //Detalle: adjuntos, dinamica, interes, mandato, violencia_victima
            foreach($this->rel_adjunto as $item) {
                $tmp = new entrevista_colectiva_adjunto();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->id_tipo = $item->id_tipo;
                $tmp->id_adjunto = $item->id_adjunto;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->id_transcripcion = $item->id_transcripcion;
                $tmp->save();
            }
            foreach($this->rel_dinamica as $item) {
                $tmp = new entrevista_colectiva_dinamica();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->dinamica = $item->dinamica;
                $tmp->save();
            }
            foreach($this->rel_interes as $item) {
                $tmp = new entrevista_colectiva_interes();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->id_interes = $item->id_interes;
                $tmp->save();
            }
            foreach($this->rel_mandato as $item) {
                $tmp = new entrevista_colectiva_mandato();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->id_mandato = $item->id_mandato;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->save();
            }


            //Etiquetado
            $conteo=0;
            foreach($this->rel_etiquetas as $antigua) {
                $nueva_etiqueta = new etiqueta_entrevista();
                //Nuevos datos
                $nueva_etiqueta->id_entrevista = $nueva->id_entrevista_colectiva;
                $nueva_etiqueta->id_subserie = config('expedientes.co');
                $nueva_etiqueta->codigo = $nueva->entrevista_codigo;
                //Copiar etiquetado
                $nueva_etiqueta->id_etiqueta = $antigua->id_etiqueta;
                $nueva_etiqueta->texto = $antigua->texto;
                $nueva_etiqueta->del = $antigua->del;
                $nueva_etiqueta->al = $antigua->al;
                $nueva_etiqueta->save();
                $conteo++;
            }
            //Crear enlace
            $enlace= new enlace();
            $enlace->id_subserie = config('expedientes.pr');
            $enlace->id_primaria = $this->id_entrevista_profundidad;
            $enlace->id_subserie_e = config('expedientes.co');
            $enlace->id_primaria_e = $nueva->id_entrevista_colectiva;
            $enlace->id_tipo = 3; //Traslado
            if(\Auth::check()) {
                $enlace->id_entrevistador = \Auth::user()->id_entrevistador;
            }
            else {
                $enlace->id_entrevistador=10;
            }
            $enlace->anotaciones = "Traslado de $this->entrevista_codigo a $nueva->entrevista_codigo";
            $enlace->id_activo=1;
            $enlace->save();
            //Anular
            $this->id_activo=2;
            $this->save();
            //Registrar traza de actividad
            //Traza
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>34, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$this->id_entrevista_profundidad, 'referencia'=>"Traslado a $nueva->entrevista_codigo"]);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_entrevista_colectiva, 'referencia'=>"Traslado desde $this->entrevista_codigo"]);
            //Devolver id_entrevista_profundidad

            return $nueva;
        }
        catch(\Exception $e) {
            Log::error('Problemas al trasladar PR a CO'.PHP_EOL.$e->getMessage());
            return false;
        }
    }

    //Trasladar a EE
    public function trasladar_ee() {
        //Crear CO
        $nueva = new entrevista_etnica();
        $nueva->id_macroterritorio = $this->id_macroterritorio;
        $nueva->id_territorio = $this->id_territorio;
        $nueva->es_virtual = $this->es_virtual;
        $nueva->id_entrevistador = $this->id_entrevistador;
        $nueva->numero_entrevistador = $this->numero_entrevistador;
        $nueva->entrevista_numero = $nueva->cual_toca();
        $nueva->asignar_codigo($nueva->id_entrevistador);
        $nueva->entrevista_lugar = $this->entrevista_lugar;
        $nueva->titulo = $this->titulo;
        $nueva->observaciones = $this->observaciones;
        $nueva->clasificacion_nna = $this->clasificacion_nna;
        $nueva->clasificacion_sex = $this->clasificacion_sex;
        $nueva->clasificacion_res = $this->clasificacion_res;
        $nueva->clasificacion_r2 = $this->clasificacion_r2;
        $nueva->clasificacion_r1 = $this->clasificacion_r1;
        $nueva->clasificacion_nivel = $this->clasificacion_nivel;
        $nueva->id_transcrita = $this->id_transcrita;
        $nueva->id_etiquetada = $this->id_etiquetada;
        if($this->id_sector==null) {
            $nueva->id_sector = config('expedientes.pr_sector');
        }
        else {
            $nueva->id_sector = $this->id_sector;
        }

        //Facilitador
        $e = $this->rel_id_entrevistador;
        $nueva->equipo_facilitador = $e->fmt_numero_nombre;
        $nueva->equipo_memorista = $e->fmt_numero_nombre;
        $nueva->tema_objetivo = $this->entrevista_objetivo;
        $nueva->tema_descripcion = "Traslado desde la entrevista $this->entrevista_codigo";
        $nueva->tema_del = substr($this->entrevista_fecha_inicio,0,10);
        $nueva->tema_al = substr($this->entrevista_fecha_final, 0, 10);
        $nueva->tema_lugar = $this->entrevista_lugar;
        $nueva->cantidad_participantes = 1;
        $nueva->eventos_descripcion = "Sin especificar";




        if(\Auth::check()) {
            $nueva->id_usuario = \Auth::user()->id;
        }
        else {
            $nueva->id_usuario=1;
        }

        //dd($this->entrevista_fecha);
        $nueva->entrevista_fecha_inicio = substr($this->entrevista_fecha_inicio,0,10);
        $nueva->entrevista_fecha_final = substr($this->entrevista_fecha_final,0,10);
        $nueva->entrevista_avance = $this->entrevista_avance;

        $nueva->tiempo_entrevista = $this->tiempo_entrevista;
        //Transcripcion/etiquetado
        $nueva->html_transcripcion = $this->html_transcripcion;
        $nueva->json_etiquetado = $this->json_etiquetado;
        $nueva->id_activo =1;
        $nueva->id_cerrado = $this->id_cerrado;
        $nueva->es_virtual = $this->es_virtual;
        //dd($nueva);
        //GRABAR y continuar con el detalle
        try {
            $nueva->save();
            //Detalle: adjuntos, dinamica, interes, mandato, violencia_victima
            foreach($this->rel_adjunto as $item) {
                $tmp = new entrevista_etnica_adjunto();
                $tmp->id_entrevista_etnica = $nueva->id_entrevista_etnica;
                $tmp->id_tipo = $item->id_tipo;
                $tmp->id_adjunto = $item->id_adjunto;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->id_transcripcion = $item->id_transcripcion;
                $tmp->save();
            }
            foreach($this->rel_dinamica as $item) {
                $tmp = new entrevista_etnica_dinamica();
                $tmp->id_entrevista_etnica = $nueva->id_entrevista_etnica;
                $tmp->dinamica = $item->dinamica;
                $tmp->save();
            }
            foreach($this->rel_interes as $item) {
                $tmp = new entrevista_etnica_interes();
                $tmp->id_entrevista_etnica = $nueva->id_entrevista_etnica;
                $tmp->id_interes = $item->id_interes;
                $tmp->save();
            }
            foreach($this->rel_mandato as $item) {
                $tmp = new entrevista_etnica_mandato();
                $tmp->id_entrevista_etnica = $nueva->id_entrevista_etnica;
                $tmp->id_mandato = $item->id_mandato;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->save();
            }


            //Etiquetado
            $conteo=0;
            foreach($this->rel_etiquetas as $antigua) {
                $nueva_etiqueta = new etiqueta_entrevista();
                //Nuevos datos
                $nueva_etiqueta->id_entrevista = $nueva->id_entrevista_etnica;
                $nueva_etiqueta->id_subserie = config('expedientes.ee');
                $nueva_etiqueta->codigo = $nueva->entrevista_codigo;
                //Copiar etiquetado
                $nueva_etiqueta->id_etiqueta = $antigua->id_etiqueta;
                $nueva_etiqueta->texto = $antigua->texto;
                $nueva_etiqueta->del = $antigua->del;
                $nueva_etiqueta->al = $antigua->al;
                $nueva_etiqueta->save();
                $conteo++;
            }
            //Crear enlace
            $enlace= new enlace();
            $enlace->id_subserie = config('expedientes.pr');
            $enlace->id_primaria = $this->id_entrevista_profundidad;
            $enlace->id_subserie_e = config('expedientes.ee');
            $enlace->id_primaria_e = $nueva->id_entrevista_etnica;
            $enlace->id_tipo = 3; //Traslado
            if(\Auth::check()) {
                $enlace->id_entrevistador = \Auth::user()->id_entrevistador;
            }
            else {
                $enlace->id_entrevistador=10;
            }
            $enlace->anotaciones = "Traslado de $this->entrevista_codigo a $nueva->entrevista_codigo";
            $enlace->id_activo=1;
            $enlace->save();
            //Anular
            $this->id_activo=2;
            $this->save();
            //Registrar traza de actividad
            //Traza
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>34, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$this->id_entrevista_profundidad, 'referencia'=>"Traslado a $nueva->entrevista_codigo"]);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_entrevista_etnica, 'referencia'=>"Traslado desde $this->entrevista_codigo"]);
            //Devolver id_entrevista_profundidad

            return $nueva;
        }
        catch(\Exception $e) {
            Log::error('Problemas al trasladar VI a CO'.PHP_EOL.$e->getMessage());
            return false;
        }
    }


    //Para diligenciar persona entrevistada, crear registro a partir de metadatos
    public function crear_persona_entrevistada() {

        $nueva_persona = new persona();
        $nueva_persona->nombre = $this->entrevistado_nombres;
        $nueva_persona->alias = $this->entrevistado_apellidos;
        $nueva_persona->insert_ent = \Auth::user()->id_entrevistador;
        $nueva_persona->insert_ip =\Request::ip();
        $nueva_persona->insert_fh = \Carbon\Carbon::now();

        $consentimiento = entrevista::where('id_entrevista_profundidad',$this->id_entrevista_profundidad)->first();
        if($consentimiento) {
            $nueva_persona->num_documento = substr($consentimiento->identificacion_consentimiento,0,20);
        }
        $nueva_persona->save();
        $nueva = new persona_entrevistada();
        $nueva->id_entrevista_profundidad = $this->id_entrevista_profundidad;
        $nueva->id_persona = $nueva_persona->id_persona;
        $nueva->insert_ent = \Auth::user()->id_entrevistador;
        $nueva->insert_ip =\Request::ip();
        $nueva->insert_fh = \Carbon\Carbon::now();
        $nueva->save();

        return $nueva;


    }


}
