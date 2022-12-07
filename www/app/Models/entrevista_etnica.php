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
 * Class entrevista_etnica
 * @package App\Models
 * @version October 6, 2019, 2:30 pm -05
 *
 * @property \App\Models\Catalogos.cev idMacroterritorio
 * @property \App\Models\Catalogos.cev idTerritorio
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property \App\Models\Catalogos.geo entrevistaLugar
 * @property \App\Models\Catalogos.geo temaLugar
 * @property \App\Models\Catalogos.catItem idSector
 * @property \App\Models\User idUsuario
 * @property integer id_entrevista_etnica
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property integer id_entrevistador
 * @property integer numero_entrevistador
 * @property string entrevista_codigo
 * @property integer entrevista_correlativo
 * @property integer entrevista_numero
 * @property integer entrevista_lugar
 * @property string equipo_facilitador
 * @property string equipo_memorista
 * @property string equipo_otros
 * @property string tema_descripcion
 * @property string tema_objetivo
 * @property string|\Carbon\Carbon tema_del
 * @property string|\Carbon\Carbon tema_al
 * @property integer tema_lugar
 * @property integer cantidad_participantes
 * @property integer id_sector
 * @property integer tiempo_entrevista
 * @property string eventos_descripcion
 * @property string observaciones
 * @property integer clasificacion_nna
 * @property integer clasificacion_sex
 * @property integer clasificacion_res
 * @property integer clasificacion_nivel
 * @property integer clasificacion_r1
 * @property integer clasificacion_r2
 * @property integer id_usuario
 * @property integer id_tipo_entrevista
 * @property integer id_tipo_sujeto
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string|\Carbon\Carbon entrevista_fecha_inicio
 * @property string|\Carbon\Carbon entrevista_fecha_final
 * @property integer entrevista_avance
 * @property string titulo
 * @property integer duracion_entrevista_minutos
 */
class entrevista_etnica extends Model
{

    public $table = 'esclarecimiento.entrevista_etnica';
    protected $primaryKey = 'id_entrevista_etnica';
    public $timestamps = true;



    protected $fillable = [
        'id_macroterritorio',
        'id_territorio',
        'id_entrevistador',
        'numero_entrevistador',
        'entrevista_codigo',
        'entrevista_correlativo',
        'entrevista_numero',
        'entrevista_lugar',
        'equipo_facilitador',
        'equipo_memorista',
        'equipo_otros',
        'tema_descripcion',
        'tema_objetivo',
        'tema_del',
        'tema_al',
        'tema_lugar',
        'cantidad_participantes',
        'id_sector',
        'id_tipo_entrevista',
        'id_tipo_sujeto',
        'eventos_descripcion',
        'observaciones',
        'clasificacion_nna',
        'clasificacion_sex',
        'clasificacion_res',
        'clasificacion_nivel',
        'clasificacion_r1',
        'clasificacion_r2',
        'id_usuario',
        'created_at',
        'updated_at',
        'entrevista_fecha_inicio',
        'entrevista_fecha_final',
        'entrevista_avance',
        'titulo',
        'tiempo_entrevista',
        'duracion_entrevista_minutos',
        'id_prioritario',
        'prioritario_tema',
        'id_subserie',
        'es_virtual'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entrevista_etnica' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_territorio' => 'integer',
        'id_entrevistador' => 'integer',
        'numero_entrevistador' => 'integer',
        'entrevista_codigo' => 'string',
        'entrevista_correlativo' => 'integer',
        'entrevista_numero' => 'integer',
        'entrevista_lugar' => 'integer',
        'equipo_facilitador' => 'string',
        'equipo_memorista' => 'string',
        'equipo_otros' => 'string',
        'tema_descripcion' => 'string',
        'tema_objetivo' => 'string',
        'tema_del' => 'datetime',
        'tema_al' => 'datetime',
        'tema_lugar' => 'integer',
        'cantidad_participantes' => 'integer',
        'id_sector' => 'integer',
        'id_tipo_entrevista' => 'integer',
        'id_tipo_sujeto' => 'integer',
        'eventos_descripcion' => 'string',
        'observaciones' => 'string',
        'clasificacion_nna' => 'integer',
        'clasificacion_sex' => 'integer',
        'clasificacion_res' => 'integer',
        'clasificacion_nivel' => 'integer',
        'clasificacion_r1' => 'integer',
        'clasificacion_r2' => 'integer',
        'id_usuario' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'entrevista_fecha_inicio' => 'datetime',
        'entrevista_fecha_final' => 'datetime',
        'entrevista_avance' => 'integer',
        'tiempo_entrevista' => 'integer',
        'titulo' => 'string',
        'duracion_entrevista_minutos' => 'integer',
        'id_prioritario' => 'integer',
        'prioritario_tema' => 'string',        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_territorio' => 'required',
        'entrevista_fecha_inicio' => 'required',
        'entrevista_fecha_inicio_submit' => 'required',
        'id_entrevistador' => 'required',
        'entrevista_numero' => 'required',
        'entrevista_lugar' => 'required',
        'titulo' => 'required',
        'equipo_facilitador' => 'required',
        'equipo_memorista' => 'required',
        'tema_descripcion' => 'required',
        'tema_objetivo' => 'required',
        //'tema_rango' => 'required',
        'tema_lugar' => 'required',
        'cantidad_participantes' => 'required',
        'id_sector' => 'required',
        'eventos_descripcion' => 'required',
        'clasificacion_nna' => 'required',
        'clasificacion_sex' => 'required',
        'clasificacion_res' => 'required',
    ];

    //Relaciones mínimas de cualquier entrevista:
    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
    }
    //Seguimiento
    public function rel_seguimiento() {
        return $this->hasMany(seguimiento::class,'id_entrevista','id_entrevista_colectiva')->where('id_subserie',config('expedientes.ee'))->orderby('fecha_hora');
    }
    public function rel_id_macroterritorio() {
        return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
    }
    public function rel_id_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }
    public function rel_id_sector() {
        return $this->belongsTo(cat_item::class,'id_sector','id_item');
    }
    public function rel_id_tipo_entrevista() {
        return $this->belongsTo(cat_item::class,'id_tipo_entrevista','id_item');
    }
    public function rel_id_tipo_sujeto() {
        return $this->belongsTo(cat_item::class,'id_tipo_sujeto','id_item');
    }
    public function rel_entrevista_lugar() {
        return $this->belongsTo(geo::class,'entrevista_lugar','id_geo');
    }
    //Entidades debiles
    public function rel_mandato() {
        return $this->hasMany(entrevista_etnica_mandato::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_adjunto() {
        return $this->hasMany(entrevista_etnica_adjunto::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_dinamica() {
        return $this->hasMany(entrevista_etnica_dinamica::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_interes() {
        return $this->hasMany(entrevista_etnica_interes::class,$this->primaryKey,$this->primaryKey);
    }
    //Relaciones específicas de este instrumento
    public function rel_indigena() {
        return $this->hasMany(entrevista_etnica_indigena::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_narp() {
        return $this->hasMany(entrevista_etnica_narf::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_rrom() {
        return $this->hasMany(entrevista_etnica_rrom::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_tema_lugar() {
        return $this->belongsTo(geo::class,'tema_lugar','id_geo');
    }

    // cambios 03/2020
    // Ficha de entrevista
    public function rel_ficha_entrevista() {
        return $this->belongsTo(entrevista::class,'id_entrevista_etnica','id_entrevista_etnica');
    }
    //Consentimiento informado  (igual que la anterior, para que pr,hv,ee,vi tengan el mismo nombre)
    public function rel_consentimiento() {
        return $this->belongsTo(entrevista::class,'id_entrevista_etnica','id_entrevista_etnica');
    }

    //Fichas de responsable
    function rel_ficha_responsable() {
        return $this->hasMany(\App\Models\persona_responsable::class,'id_entrevista_etnica','id_entrevista_etnica');
    }    

    //Fichas de hechos
    public function rel_ficha_hecho() {
        return $this->hasMany(hecho::class,'id_entrevista_etnica','id_entrevista_etnica')
                        ->orderby('hecho.fecha_ocurrencia_a')
                        ->orderby('hecho.fecha_ocurrencia_m')
                        ->orderby('hecho.fecha_ocurrencia_d');
    }    


    //Permisos si fuera reservado-3
    public function rel_acceso_reservado() {
        return $this->hasMany(reservado_acceso::class,'id_primaria',$this->primaryKey)->where('reservado_acceso.id_subserie',config('expedientes.ee'))->where('id_activo',1);
    }
    //Asiganciones de transcripcion
    public function rel_transcripcion() {
        return $this->hasMany(transcribir_asignacion::class,$this->primaryKey,$this->primaryKey)->orderby('id_transcribir_asignacion','desc');
    }
    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista',$this->primaryKey)->where('id_subserie',config('expedientes.ee'));
    }
    //Asignaciones para etiquetado
    public function rel_etiquetado() {
        return $this->hasMany(etiquetar_asignacion::class,$this->primaryKey,$this->primaryKey)->orderby('id_etiquetar_asignacion','desc');;
    }
    //Etiquetado
    public function rel_etiquetas() {
        return $this->hasMany(etiqueta_entrevista::class,'id_entrevista',$this->primaryKey)->where('id_subserie',config('expedientes.ee'))->orderby('del');
    }
    public function listar_etiquetas() {
        return etiqueta_entrevista::where('id_subserie',config('expedientes.ee'))->where('id_entrevista',$this->id_entrevista_etnica)
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
                $inicio = strpos($r->texto, $marca->texto, $marca->del);
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

    //Para filtrar por listados cargados en excel
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
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_etnica.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo);
            }
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_etnica.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_etnica.id_macroterritorio',\Auth::user()->id_macroterritorio);
            }
            //$query->where('e_ind_fvt.id_macroterritorio',\Auth::user()->id_macroterritorio);
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_etnica.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_etnica.id_territorio',\Auth::user()->id_territorio);
            }
            //$query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_etnica.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_etnica.id_entrevistador',\Auth::user()->id_entrevistador);
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
                ->pluck('id_entrevista_etnica')->toArray();
            $asignadas_e = etiquetar_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                ->where('id_situacion',1)
                ->pluck('id_entrevista_etnica')->toArray();

            $asignaciones = array_merge($asignadas_t, $asignadas_e);

            $query->wherein('entrevista_etnica.id_entrevista_etnica',$asignaciones);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('entrevista_etnica.id_entrevistador',-1); //Ninguno
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


    //Ver si fue asignada para transcribir
    public function revisar_asignacion() {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }

        $asignaciones = $this->arreglo_asignaciones();


        return in_array($this->id_entrevista_etnica,$asignaciones);
    }

    //Para el scope de permisos
    public static function arreglo_asignaciones($id_subserie=0,$llave_primaria="") {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        $id_subserie = $id_subserie > 0 ? $id_subserie : config("expedientes.ee");
        $llave_primaria = strlen($llave_primaria) > 0 ? $llave_primaria : 'id_entrevista_etnica';
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

    //PAra asignar transcriptor
    //Para controlar si tiene los adjuntos requeridos
    public function verificar_adjunto($tipo=0) {
        return $this->rel_adjunto()->where('id_tipo',$tipo)->count();
    }
    // tiene audio?
    public function getTieneAudioAttribute() {  //tiene_audio: Audio
        return $this->verificar_adjunto(2) > 0 ? 1 : 0;
    }
    // tiene transcripcion?
    public function getTieneTfAttribute() { //tiene_tf: transcripcion final
        return $this->verificar_adjunto(6) > 0 ? 1 : 0;
    }
    //tiene etiquetado?
    public function getTieneEtiquetadoAttribute() { //Tiene etiquetado
        //return $this->verificar_adjunto(25) > 0 ? 1 : 0;
        return strlen($this->json_etiquetado)>0;
    }
    public function getTieneTranscripcionAttribute() {
        return strlen($this->html_transcripcion)>0;
    }


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
        return cev::nombre_completo($this->id_territorio);
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
    //Fechas y situacion de la entrevista
    public function getFmtEntrevistaFechaFinalAttribute() {
        try {
            $fecha= new Carbon($this->entrevista_fecha_final);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtIdTipoEntrevistaAttribute() {
        return cat_item::describir($this->id_tipo_entrevista);
    }
    public function getFmtIdTipoSujetoAttribute() {
        return cat_item::describir($this->id_tipo_sujeto);
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

    // Puede ser transcrita
    public function getPuedeTranscribirseAttribute() {
        if($this->es_virtual==1) {
            $obligatorio=array(2);  //Audio para las virtuales
        }
        else {
            $obligatorio=array(1,2);  //Consentimiento y Audio
        }

        $puede=true;
        foreach($obligatorio as $id_tipo) {
            if($this->rel_adjunto()->where('entrevista_etnica_adjunto.id_tipo',$id_tipo)->count()==0) {
                $puede=false;
                break;
            }
        }
        return $puede;
    }

    //Para descargar la plantilla
    public static function enlace_plantilla() {
        $doc = documento::find(parametro::find(3)->valor);
        if($doc) {
            return $doc->fmt_url;
        }
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

    public function getFmtMandatoAttribute() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[]=$item->fmt_id_mandato;
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
    public function getFmtIdSectorAttribute() {
        return cat_item::describir($this->id_sector);
    }
    //Para la edición de select multiple de mandato
    public function getArregloMandatoAttribute() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[]=$item->id_mandato;
        }
        return $arreglo;
    }

    //Estado de la transcripcion
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
    //Mostrar si está etiquetada
    public function getFmtEstadoEtiquetadoAttribute() {
        $si = $this->rel_etiquetado()->where('id_situacion',2)->count();
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
            $si = $this->rel_etiquetado()->where('id_situacion',1)->count();
            if($si >0) {
                return "<span class='text-warning'>En proceso</span>";
            }
            else {
                //No transcrita por alguna razón
                $negada = $this->rel_etiquetado()->where('id_situacion',4)->orderby('fh_asignado','desc')->first();
                //dd($negada);
                if($negada) {
                    $estado="No";
                    if($negada->id_causa) {
                        $razon = cat_item::describir($negada->id_causa);
                        $estado .=" - $razon";
                    }
                    return "<span class='text-danger'>$estado</span>";
                }
            }
        }
        //Sin asignación
        return "<span class='text-danger'>No</span>";
    }
    //Para la edición de select multiple de nucleos tematicos
    public function getArregloInteresAttribute() {
        $arreglo=array();
        foreach($this->rel_interes as $item) {
            $arreglo[]=$item->id_interes;
        }
        return $arreglo;
    }
    //Para la edición de select multiple de pueblos indigenas
    public function getArregloIndigenaAttribute() {
        $arreglo=array();
        foreach($this->rel_indigena as $item) {
            $arreglo[]=$item->id_indigena;
        }
        return $arreglo;
    }
    //Para la edición de select multiple de pueblos narp
    public function getArregloNarpAttribute() {
        $arreglo=array();
        foreach($this->rel_narp as $item) {
            $arreglo[]=$item->id_narf;
        }
        return $arreglo;
    }
    //Para la edición de select multiple de pueblos narp
    public function getArregloRromAttribute() {
        $arreglo=array();
        foreach($this->rel_rrom as $item) {
            $arreglo[]=$item->id_rrom;
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
    //Mutators: Formatos propios de este instrumento
    public function getFmtTemaDelAttribute() {
        try {
            $fecha= new Carbon($this->tema_del);
            return $fecha->format("Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtTemaAlAttribute() {
        try {
            $fecha= new Carbon($this->tema_al);
            return $fecha->format("Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    //Para el control de edicion
    public function getFmtTemaRangoAttribute() {
        if(empty($this->tema_del)) {
            return null;
        }
        try {
            $del= new Carbon($this->tema_del);
            $al= new Carbon($this->tema_al);
            return $del->format("d/m/Y")." - ".$al->format("d/m/Y");
        }
        catch(\Exception $e) {
            return null;
        }
    }
    //Para editar los anios
    public function getTemaAnioDelAttribute() {
        if(strlen($this->tema_del) >=10 ) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d",substr($this->tema_del,0,10));
                return $fecha->format("Y");
            }
            catch (\Exception $e) {
                return $this->tema_del;
            }
        }
        else {
            return $this->tema_del;
        }

    }
    public function getTemaAnioAlAttribute() {
        if(strlen($this->tema_al) >=10 ) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d",substr($this->tema_al,0,10));
                return $fecha->format("Y");
            }
            catch (\Exception $e) {
                return $this->tema_al;
            }
        }
        else {
            return $this->tema_al;
        }
    }
    public function getFmtTemaFechaAttribute() {
        if(empty($this->tema_al)) {
            return $this->tema_anio_del;
        }
        else {
            if(substr($this->tema_del,0,4)==substr($this->tema_al,0,4)) {
                return $this->tema_anio_del;
            }
            else{
                return $this->tema_anio_del." al ".$this->tema_anio_al;
            }
        }
    }
    public function getFmtTemaLugarAttribute() {
        return geo::nombre_completo($this->tema_lugar);
    }
    // Para la tabla de adjuntos
    public function getAdjuntosAttribute() {
        return entrevista_etnica_adjunto::listado_adjuntos($this->id_entrevista_etnica);
    }

    //Tiempo de procesamiento
    public function getTiempoProcesamientoAttribute() {
        $tiempos[0]=0; //Entrevista
        $tiempos[1]=0; //Transcripcion
        $tiempos[2]=0; //Etiquetar
        $tiempos[3]=0; //Diligenciar

        $listado = procesamiento_tiempo::where('id_entrevista',$this->id_entrevista_etnica)
            ->where('id_subserie',config('expedientes.ee'))
            ->select(\DB::raw('id_tipo_medicion, max(tiempo_minutos) as tiempo'))
            ->groupby('id_tipo_medicion')
            ->get();


        foreach($listado as $fila) {
            $tiempos[$fila->id_tipo_medicion] = $fila->tiempo;
        }
        $tr = $this->rel_transcripcion()->max('duracion_entrevista_minutos');
        //$et = $this->rel_etiquetado()->max('duracion_entrevista_minutos');
        //$max = $et > $tr ? $et : $tr;
        if(intval($tr) > 0) {
            $tiempos[0]=$tr;
        }
        else {
            $tiempos[0] = $this->tiempo_entrevista;  //Usar el valor de los metadatos
        }

        //Para no desplegar valores a cero
        $hay_tiempo=false;
        foreach($tiempos as $val) {
            if($val>0) {
                $hay_tiempo=true;
            }
        }
        if($hay_tiempo) {
            return $tiempos;
        }
        else {
            return false;
        }

    }





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
    //Setters propios de este instumento
    public function setTemaDelAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['tema_del']=$fecha;
    }
    public function setTemaAlAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['tema_al']=$fecha;
    }
    public function setTiempoEntrevistaAttribute($val) {
        $val=intval($val);
        $this->attributes['tiempo_entrevista']=$val;

    }
    // Logica interna
    //Calculo de codigo que le toca, usado en insert
    public function asignar_codigo($id_entrevistador=0) {
        $id_subserie=config('expedientes.ee');        
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
        $id_subserie=config('expedientes.ee');

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
        $this->tema_del = "2000-01-01";
        $this->tema_al= date("Y")."-12-31";
        $this->id_territorio = $entrevistador->id_territorio;
        $this->entrevista_lugar = $entrevistador->id_ubicacion;
        $this->tema_lugar = $entrevistador->id_ubicacion;
        $this->clasificacion_nna = 1;
        $this->clasificacion_sex = 1;
        $this->clasificacion_res = 1;
        $this->cantidad_participantes = 1;
        $this->entrevista_fecha_inicio = date('Y-m-d');
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
        $filtro->observaciones="";
        $filtro->cantidad_participantes="";
        $filtro->br=null; //Busqueda rapida
        $filtro->transcrita = -1; //Busqueda rapida
        $filtro->etiquetada = -1; //Busqueda rapida
        $filtro->marca = array();
        $filtro->id_cerrado=-1;
        $filtro->id_activo=1;

        //Propias del instrumento
        $filtro->id_sector = null;
        $filtro->tema_del = null;
        $filtro->tema_al = null;
        $filtro->tema_lugar = -1;
        $filtro->tema_objetivo = null;
        $filtro->tema_descripcion = null;
        $filtro->eventos_descripcion = null;
        //
        $filtro->id_tipo_entrevista=-1;
        $filtro->id_tipo_sujeto=-1;
        $filtro->id_indigena=-1;
        $filtro->id_narp=-1;
        $filtro->id_rrom=-1;

        $filtro->id_prioritario=-1;
        $filtro->prioritario_tema=null;
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
        $filtro->id_subserie = config('expedientes.ee'); //PAra el autofill
        //
        $filtro->con_transcripcion=-1;
        $filtro->con_etiquetado=-1;
        //Full text search
        $filtro->fts=null;
        //Tesauro
        $filtro->id_tesauro=-1;
        //Buscadora avanzada
        $filtro->id_tesauro_2=-1;
        $filtro->id_tesauro_3=-1;
        $filtro->d_hecho_min=-1;
        $filtro->d_contexto_min=-1;
        $filtro->d_impacto_min=-1;
        $filtro->d_justicia_min=-1;

        //Para crear conjuntos especificos, como el de sindicalismo, a partir de listados de excel
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
        $filtro->clasificacion_sex = isset($request->clasificacion_sex) ? $request->clasificacion_sex : $filtro->clasificacion_sex;
        $filtro->clasificacion_res = isset($request->clasificacion_res) ? $request->clasificacion_res : $filtro->clasificacion_res;
        $filtro->clasificacion_nna = isset($request->clasificacion_nna) ? $request->clasificacion_nna : $filtro->clasificacion_nna;
        $filtro->clasificacion_nivel = isset($request->clasificacion_nivel) ? $request->clasificacion_nivel : $filtro->clasificacion_nivel;
        $filtro->mandato = isset($request->mandato) ? $request->mandato : $filtro->mandato;
        $filtro->interes = isset($request->interes) ? $request->interes : $filtro->interes;
        $filtro->dinamica = isset($request->dinamica) ? $request->dinamica : $filtro->dinamica;
        $filtro->titulo = isset($request->titulo) ? $request->titulo : $filtro->titulo;
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;
        $filtro->observaciones = isset($request->observaciones) ? $request->observaciones : $filtro->observaciones;
        $filtro->cantidad_participantes = isset($request->cantidad_participantes) ? $request->cantidad_participantes : $filtro->cantidad_participantes;
        $filtro->transcrita = isset($request->transcrita) ? $request->transcrita : $filtro->transcrita;
        $filtro->etiquetada = isset($request->etiquetada) ? $request->etiquetada : $filtro->etiquetada;
        $filtro->marca = isset($request->marca) ? $request->marca : $filtro->marca;
        $filtro->id_cerrado = isset($request->id_cerrado) ? $request->id_cerrado : $filtro->id_cerrado;
        //
        $filtro->id_tipo_entrevista = isset($request->id_tipo_entrevista) ? $request->id_tipo_entrevista : $filtro->id_tipo_entrevista;
        $filtro->id_tipo_sujeto = isset($request->id_tipo_sujeto) ? $request->id_tipo_sujeto : $filtro->id_tipo_sujeto;
        $filtro->id_indigena = isset($request->id_indigena) ? $request->id_indigena : $filtro->id_indigena;
        $filtro->id_narp = isset($request->id_narp) ? $request->id_narp : $filtro->id_narp;
        $filtro->id_rrom = isset($request->id_rrom) ? $request->id_rrom : $filtro->id_rrom;
        //
        $filtro->id_activo = isset($request->id_activo) ? $request->id_activo : $filtro->id_activo;

        $filtro->id_prioritario = isset($request->id_prioritario) ? $request->id_prioritario : $filtro->id_prioritario;
        $filtro->prioritario_tema = isset($request->prioritario_tema) ? $request->prioritario_tema : $filtro->prioritario_tema;        

        //Determinar si es lp, muni o depto
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
        $filtro->tema_del = isset($request->tema_del_submit) ? $request->tema_del_submit : $filtro->tema_del;
        $filtro->tema_al = isset($request->tema_al_submit) ? $request->tema_al_submit : $filtro->tema_al;
        $filtro->tema_objetivo = isset($request->tema_objetivo) ? $request->tema_objetivo : $filtro->tema_objetivo;
        $filtro->tema_descripcion = isset($request->tema_descripcion) ? $request->tema_descripcion : $filtro->tema_descripcion;
        $filtro->eventos_descripcion = isset($request->eventos_descripcion) ? $request->eventos_descripcion : $filtro->eventos_descripcion;
        //Determinar si es lp, muni o depto
        if(isset($request->tema_lugar_depto)){
            if($request->tema_lugar_depto > 0) {
                $filtro->tema_lugar=$request->tema_lugar_depto;
            }
        }
        if(isset($request->tema_lugar_muni)){
            if($request->tema_lugar_muni > 0) {
                $filtro->tema_lugar=$request->tema_lugar_muni;
            }
        }
        if(isset($request->tema_lugar)){
            if($request->tema_lugar > 0) {
                $filtro->tema_lugar=$request->tema_lugar;
            }
        }

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
                $filtro->id_tesauro_3=$request->id_tesauro_2;
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
                $pedazos = explode("?", $url);
                if (isset($pedazos[1])) {
                    $filtro->url = $pedazos[1] . "&";

                } else {
                    $filtro->url = "";
                }
            }
        }

        return $filtro;
    }
    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('entrevista_correlativo');
    }
    public static function scopeId_activo($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_etnica.id_activo',$criterio);
        }
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
            $query->wherein('esclarecimiento.entrevista_etnica.id_entrevistador',$criterio);
        }
        elseif($criterio>0) {
            $query->where('esclarecimiento.entrevista_etnica.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_macroterritorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_etnica.id_macroterritorio',$criterio);
        }
    }
    public static function scopeId_territorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_etnica.id_territorio',$criterio);
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
    public static function scopeMandato($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_etnica_mandato as fmandato', 'entrevista_etnica.id_entrevista_etnica', '=', 'fmandato.id_entrevista_etnica')
                    ->wherein('id_mandato', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_etnica_mandato as fmandato', 'entrevista_etnica.id_entrevista_etnica', '=', 'fmandato.id_entrevista_etnica')
                    ->where('id_mandato',$criterio);
            }
        }
    }


    //De acuerdo al perfil, aplica los permisos  (sustituida el 20-1-20)
    public static function scopePermisos_bak($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('entrevista_etnica.id_entrevistador',$arreglo_entrevistadores);
        if(\Auth::check()) {  //Transcriptores
            if(\Auth::user()->id_nivel==11) {
                $asignadas = transcribir_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                    ->where('id_situacion',1)
                    ->pluck('id_entrevista_etnica');
                //dd($asignadas);

                $query->wherein('entrevista_etnica.id_entrevista_etnica',$asignadas);

            }
        }
    }

    //Priorizacion
    public static function scopeTipo_prioridad($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp0','entrevista_etnica.id_entrevista_etnica','=','fp0.id_entrevista')
                ->where('fp0.id_subserie','=',config('expedientes.ee'))
                ->where('fp0.id_tipo',$criterio);
        }
    }
    public static function scopeFluidez($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp1','entrevista_etnica.id_entrevista_etnica','=','fp1.id_entrevista')
                ->where('fp1.id_subserie','=',config('expedientes.ee'))
                ->where('fp1.fluidez',$criterio);
        }
    }
    public static function scopeCierre($query,$criterio=-1) {
        if($criterio>=0) {
            $query->join('prioridad as fp2','entrevista_etnica.id_entrevista_etnica','=','fp2.id_entrevista')
                ->where('fp2.id_subserie','=',config('expedientes.ee'))
                ->where('fp2.cierre',$criterio);
        }
    }
    public static function scopeD_hecho($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','entrevista_etnica.id_entrevista_etnica','=','fp3.id_entrevista')
                ->where('fp3.id_subserie','=',config('expedientes.ee'))
                ->where('fp3.d_hecho',$criterio);
        }
    }
    public static function scopeD_impacto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','entrevista_etnica.id_entrevista_etnica','=','fp4.id_entrevista')
                ->where('fp4.id_subserie','=',config('expedientes.ee'))
                ->where('fp4.d_impacto',$criterio);
        }
    }
    public static function scopeD_contexto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','entrevista_etnica.id_entrevista_etnica','=','fp5.id_entrevista')
                ->where('fp5.id_subserie','=',config('expedientes.ee'))
                ->where('fp5.d_contexto',$criterio);
        }
    }
    public static function scopeD_justicia($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','entrevista_etnica.id_entrevista_etnica','=','fp6.id_entrevista')
                ->where('fp6.id_subserie','=',config('expedientes.ee'))
                ->where('fp6.d_justicia',$criterio);
        }
    }
    public static function scopeAhora_entiendo($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp7','entrevista_etnica.id_entrevista_etnica','=','fp7.id_entrevista')
                ->where('fp7.id_subserie','=',config('expedientes.ee'))
                ->where('fp7.ahora_entiendo','ilike',"%$criterio%");
        }
    }
    public static function scopeCambio_perspectiva($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp8','entrevista_etnica.id_entrevista_etnica','=','fp8.id_entrevista')
                ->where('fp8.id_subserie','=',config('expedientes.ee'))
                ->where('fp8.cambio_perspectiva','ilike',"%$criterio%");
        }
    }
    //Buscadora
    public static function scopeD_hecho_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','entrevista_etnica.id_entrevista_etnica','=','fp3.id_entrevista')
                ->where('fp3.id_subserie','=',config('expedientes.ee'))
                ->where('fp3.d_hecho','>=',$criterio);
        }
    }
    public static function scopeD_impacto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','entrevista_etnica.id_entrevista_etnica','=','fp4.id_entrevista')
                ->where('fp4.id_subserie','=',config('expedientes.ee'))
                ->where('fp4.d_impacto','>=',$criterio);
        }
    }
    public static function scopeD_contexto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','entrevista_etnica.id_entrevista_etnica','=','fp5.id_entrevista')
                ->where('fp5.id_subserie','=',config('expedientes.ee'))
                ->where('fp5.d_contexto','>=',$criterio);
        }
    }
    public static function scopeD_justicia_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','entrevista_etnica.id_entrevista_etnica','=','fp6.id_entrevista')
                ->where('fp6.id_subserie','=',config('expedientes.ee'))
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
            $asignadas = entrevista_etnica::arreglo_asignaciones();
            $id_macroterritorio=\Auth::user()->id_macroterritorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( entrevista_etnica.id_macroterritorio = $id_macroterritorio  OR entrevista_etnica.id_entrevista_etnica in ($asignadas_where) )"));
            }
            else {
                $query->where('entrevista_etnica.id_macroterritorio',$id_macroterritorio);
            }
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            $asignadas = entrevista_etnica::arreglo_asignaciones();
            $id_territorio=\Auth::user()->id_territorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( entrevista_etnica.id_territorio = $id_territorio  OR entrevista_etnica.id_entrevista_etnica in ($asignadas_where) )"));
            }
            else {
                $query->where('entrevista_etnica.id_territorio',$id_territorio);
            }

        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas(); //Asignación de otros entrevistadores
            $asignadas = entrevista_etnica::arreglo_asignaciones();
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas); //Arreglo de entrevistas asignadas
                $entrevistadores_where = implode(",", $arreglo_entrevistadores);  //Arreglo de entrevistadores asignados
                $query->whereraw(DB::raw("( entrevista_etnica.id_entrevistador in ($entrevistadores_where)  OR entrevista_etnica.id_entrevista_etnica in ($asignadas_where) )"));
            }
            else {
                $query->wherein('entrevista_etnica.id_entrevistador',$arreglo_entrevistadores);
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
            $asignadas = entrevista_etnica::arreglo_asignaciones();
            $query->wherein('entrevista_etnica.id_entrevista_etnica',$asignadas);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('entrevista_etnica.id_entrevistador',-1); //Ninguno
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
        $query->whereNotIn('entrevista_etnica.id_entrevistador',$otros_confidenciales);
        */
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);

        //Si es de un grupo ajeno, agregar el filtro del grupo  (ruta pacifica, oim, etc)
        if(Gate::allows('grupo-ajeno')) {
            $query->join('esclarecimiento.entrevistador as fsg','entrevista_etnica.id_entrevistador','=','fsg.id_entrevistador')
                ->where('fsg.id_grupo',\Auth::user()->id_grupo);
        }


    }

    //Filtro según el grupo al que pertenece
    public static function scopeId_grupo($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('esclarecimiento.entrevistador as fe','entrevista_etnica.id_entrevistador','=','fe.id_entrevistador')
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
    public static function scopeId_tipo_entrevista($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_tipo_entrevista',$criterio);
        }
    }
    public static function scopeId_tipo_sujeto($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_tipo_sujeto',$criterio);
        }
    }
    public static function scopeTema_del($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("tema_del",'>=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeTema_al($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("tema_al",'<=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeTema_lugar($query,$id_geo=-1) {
        if($id_geo>0) {
            $query->wherein('tema_lugar',geo::arreglo_contenidos($id_geo));
        }
    }
    public static function scopeTema_objetivo($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('tema_objetivo','ilike',"%$criterio%");
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
            $query->join('esclarecimiento.entrevista_etnica_dinamica as fdinamica','entrevista_etnica.id_entrevista_etnica', '=', 'fdinamica.id_entrevista_etnica')
                ->where('dinamica','ilike',"%$criterio%");
        }
    }
    public static function scopeInteres($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_etnica_interes as finteres', 'entrevista_etnica.id_entrevista_etnica', '=', 'finteres.id_entrevista_etnica')
                    ->wherein('id_interes', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_etnica_interes as finteres', 'entrevista_etnica.id_entrevista_etnica', '=', 'finteres.id_entrevista_etnica')
                    ->where('id_interes', $criterio);
            }
        }
    }

    public static function scopeIndigena($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_etnica_indigena as findigena', 'entrevista_etnica.id_entrevista_etnica', '=', 'findigena.id_entrevista_etnica')
                    ->wherein('id_indigena', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_etnica_indigena as findigena', 'entrevista_etnica.id_entrevista_etnica', '=', 'findigena.id_entrevista_etnica')
                    ->where('id_indigena', $criterio);
            }
        }
    }
    public static function scopeNarp($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_etnica_narf as fnarf', 'entrevista_etnica.id_entrevista_etnica', '=', 'fnarf.id_entrevista_etnica')
                    ->wherein('id_narf', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_etnica_narf as fnarf', 'entrevista_etnica.id_entrevista_etnica', '=', 'fnarf.id_entrevista_etnica')
                    ->where('id_narf', $criterio);
            }
        }
    }
    public static function scopeRrom($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_etnica_rrom as frrom', 'entrevista_etnica.id_entrevista_etnica', '=', 'frrom.id_entrevista_etnica')
                    ->wherein('id_rrom', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_etnica_rrom as frrom', 'entrevista_etnica.id_entrevista_etnica', '=', 'frrom.id_entrevista_etnica')
                    ->where('id_rrom', $criterio);
            }
        }
    }

    public static function scopeTema_descripcion($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('tema_descripcion','ilike',"%$criterio%");
        }
    }
    public static function scopeEventos_descripcion($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('eventos_descripcion','ilike',"%$criterio%");
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
            $where[]="tema_descripcion ilike '%$criterio%'";
            $where[]="tema_objetivo ilike '%$criterio%'";
            $where[]="eventos_descripcion ilike '%$criterio%'";
            $where[]="observaciones ilike '%$criterio%'";
            $where[]="entrevista_codigo ilike '%$criterio%'";
            $where[]="titulo ilike '%$criterio%'";
            //$where[]="prioritario_tema ilike '%$criterio%'";
            //$where[]="dinamica ilike '%$criterio%'";
            $str_where=implode(" or ",$where);
            //$query->join('esclarecimiento.e_ind_fvt_dinamica as fd','e_ind_fvt.id_e_ind_fvt','=','fd.id_e_ind_fvt')
            //       ->whereraw("( $str_where )");
            $query->whereraw(" ( $str_where )");

        }
    }
    public static function scopeTranscrita($query,$criterio=-1) {
        if($criterio==0) { //Sin asignar
            $query->wherenull('entrevista_etnica.id_transcrita');
        }
        elseif($criterio>0) {
            $query->where('entrevista_etnica.id_transcrita',$criterio);
        }

    }
    public static function scopeQuienTranscribe($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('public.transcribir_asignacion as taa','entrevista_etnica.id_entrevista_etnica','=','taa.id_entrevista_etnica')
                ->where('taa.id_situacion',2)
                ->where('taa.id_transcriptor',$criterio);
        }
    }
    public static function scopeEtiquetada($query,$criterio=-1) {
        if($criterio==0) { //Sin asignar
            $query->wherenull('entrevista_etnica.id_etiquetada');
        }
        elseif($criterio>0) {
            $query->where('entrevista_etnica.id_etiquetada',$criterio);
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

    public static function scopeObservaciones($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevista_etnica.observaciones','ilike',"%$criterio%");
        }
    }
    public static function scopeCantidad_participantes($query,$criterio=-1) {
        if($criterio > 0) {
            if($criterio <=10) {
                $query->where('cantidad_participantes',$criterio);
            }
            elseif($criterio == 25) {
                $query->whereBetween('cantidad_participantes',[11,25]);
            }
            elseif($criterio == 50) {
                $query->whereBetween('cantidad_participantes',[26,50]);
            }
            else {
                $query->where('cantidad_participantes','>=',51);
            }

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
            $query->join('esclarecimiento.marca_entrevista as filtro_marca','entrevista_etnica.id_entrevista_etnica','=','filtro_marca.id_entrevista')
                ->where('filtro_marca.id_subserie','=',config('expedientes.ee'))
                ->where('filtro_marca.id_entrevistador',$id_entrevistador)
                ->wherein('id_marca',$criterio);
        }
    }
    //Busqueda de full text search
    public static function scopeFTS($query,$criterio="")  {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank1, entrevista_etnica.id_entrevista_etnica"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
        }
    }

    //Buscar en tesauro.  Recibe id_geo
    public function scopeTesauro($query, $criterio=-1) {
        $id_subserie = config('expedientes.ee');
        if($criterio > 0) {
            $contenidos = tesauro::find($criterio)->arreglo_incluidos();
            $universo =  etiqueta_entrevista::where('id_subserie',$id_subserie)
                ->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                ->wherein('ft.id_geo',$contenidos)
                ->distinct()
                ->pluck('id_entrevista');
            $query->wherein('entrevista_etnica.id_entrevista_etnica',$universo);
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
            ->observaciones($criterios->observaciones)
            ->cantidad_participantes($criterios->cantidad_participantes)
            ->transcrita($criterios->transcrita)
            ->etiquetada($criterios->etiquetada)
            ->marca($criterios->marca)
            ->br($criterios->br)
            ->id_cerrado($criterios->id_cerrado)
            ->id_grupo($criterios->id_grupo)
            ->id_activo($criterios->id_activo)
            //Scopes especificos
            ->id_sector($criterios->id_sector)
            ->id_tipo_entrevista($criterios->id_tipo_entrevista)
            ->id_tipo_sujeto($criterios->id_tipo_sujeto)
            ->indigena($criterios->id_indigena)
            ->narp($criterios->id_narp)
            ->rrom($criterios->id_rrom)
            ->tema_del($criterios->tema_del)
            ->tema_al($criterios->tema_al)
            ->tema_lugar($criterios->tema_lugar)
            ->tema_objetivo($criterios->tema_objetivo)
            ->tema_descripcion($criterios->tema_descripcion)
            ->eventos_descripcion($criterios->eventos_descripcion)
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
            // Con base al campo
            ->con_transcripcion($criterios->con_transcripcion)
            ->con_etiquetado($criterios->con_etiquetado)
            //Buscadora
            ->tesauro($criterios->id_tesauro)
            ->tesauro($criterios->id_tesauro_2)
            ->tesauro($criterios->id_tesauro_3)
            ->fts($criterios->fts) //Full text search
            //Filtros por listado
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
        $a = entrevista_etnica::join('esclarecimiento.entrevista_etnica_adjunto as a_au','entrevista_etnica.id_entrevista_etnica','=','a_au.id_entrevista_etnica')
            ->where('a_au.id_tipo',2)
            ->where('es_virtual',1)->distinct()->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();
        //Segundo grupo: no virtuales
        $b = entrevista_etnica::join('esclarecimiento.entrevista_etnica_adjunto as a_ci','entrevista_etnica.id_entrevista_etnica','=','a_ci.id_entrevista_etnica')
            ->where('a_ci.id_tipo',1)
            ->join('esclarecimiento.entrevista_etnica_adjunto as a_au','entrevista_etnica.id_entrevista_etnica','=','a_au.id_entrevista_etnica')
            ->where('a_au.id_tipo',2)
            ->where('es_virtual',2)->distinct()->pluck('entrevista_etnica.id_entrevista_etnica')->toArray();

        $c = array_merge($a, $b);
        $query->wherein('entrevista_etnica.id_entrevista_etnica',$c);
        

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
        $opciones= self::filtrar($filtros)->join('esclarecimiento.entrevista_etnica_dinamica','entrevista_etnica.id_entrevista_etnica','=','entrevista_etnica_dinamica.id_entrevista_etnica')
            ->where('dinamica','ilike',"%$criterio%")->distinct()->limit(30)->orderby('dinamica')->pluck('dinamica')->toArray();
        return $opciones;
    }



    //Evaluar si el usuario activo puede  editar las fichas
    public function permitir_modificar_fichas() {

        $respuesta = new \stdClass();
        $respuesta->permitido=false;
        $respuesta->texto="Sin analizar";

        //
        $activo=\Auth::user();
        if(!$activo) {
            return false;
        }
        $arreglo_asignados=entrevistador::entrevistadores_asignados($activo->id_entrevistador);
        if(in_array($this->id_entrevistador, $arreglo_asignados)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
            return $respuesta;
        }
        //No se hace el else, porque hay que evaluar según el perfil

        //Verificar si le han compartido alguna entrevista.
        //  Esta función debe existir en c/modelo ya que en esa función se especifica la llave primaria y el id_subserie
        if($this->revisar_asignacion()) {
            $respuesta->permitido=true;
            $respuesta->texto="Asignada del usuario";
            return $respuesta;
        }



        if(\Gate::allows('es-propio',$this->id_entrevistador)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
        }
        else {

            //Perfil de solo estadística
            if(Gate::allows('solo-estadistica')) {
                $respuesta->permitido=false;
                $respuesta->texto="Perfil estadístico";
            }
            else {

                if(Gate::allows('solo-lectura')) {
                    $respuesta->texto="Restricciones de analista. No puede modificar la entrevista.";
                    $respuesta->permitido = false;
                }
                else {
                    //Ver que tenga permisos de acceso a la entrevista
                    if (!$this->puede_acceder_entrevista) {
                        $respuesta->texto = "No puede acceder a esta entrevista";
                        $respuesta->permitido = false;
                    }
                    else {
                        //Segundo chequeo: reservado-3
                        if (!$this->puede_acceder_adjuntos()) { //R3 y R2
                            $respuesta->texto = "Restricciones de analista. No puede consultar las fichas de un expediente RESERVADO.";
                            $respuesta->permitido = false;
                        }
                        else {
                            $respuesta->texto = "Puede acceder a la entrevista y tiene acceso a los adjuntos";
                            $respuesta->permitido = true;
                        }
                    }
                }
            }
        }
        //dd($respuesta);
        return $respuesta;

    }

    //Para mostrar el consentimiento informado
    public function getConsentimientoAttribute() {
        $existe= entrevista::where('id_entrevista_etnica',$this->id_entrevista_etnica)->first();
        if(!$existe) {
            $existe = new \App\Models\entrevista();
        }
        return $existe;
    }



    public function getDiligenciadaAttribute() {
        return $this->conteo_fichas();
    }    

    // LOGICA DE LOS FORMULARIOS COMPLETOS (diligenciar fichas)
    public function conteo_fichas() {
        $conteo = new \stdClass();
        //Para referencias
        $conteo->fichas = new \stdClass();
        $conteo->fichas->entrevista = $this->rel_ficha_entrevista;
        // $conteo->fichas->persona_entrevistada = $this->rel_ficha_persona_entrevistada;
        $conteo->fichas->persona_entrevistada = 0;
        //conteos
        $conteo->entrevista = $this->rel_ficha_entrevista()->count() ;
        
        // $conteo->entrevistado = $this->rel_ficha_persona_entrevistada()->count() ;
        $conteo->entrevistado = 0;

        // $conteo->victimas  = $this->rel_ficha_victima()->count() ;
        $conteo->victimas  = 0;
        // $conteo->victimas_pendientes = $conteo->victimas;
        $conteo->victimas_pendientes = 0;

        $conteo->responsables  = $this->rel_ficha_responsable()->count() ;
        $conteo->responsables_pendientes  =$conteo->responsables;
        $conteo->hechos = $this->rel_ficha_hecho()->count() ;
        $conteo->violaciones =  0;
        $conteo->violencia = 0;
        
        $conteo->impactos = entrevista_impacto::entrevista($this->id_entrevista_etnica, 'etnica')->count();
        
        $listado = hecho::join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho')
                            ->where('hecho.id_entrevista_etnica',$this->id_entrevista_etnica)->get();
        if(count($listado)>0) {
            $conteo->violencia = count($listado);
        }

        foreach($listado as $violacion) { //Cada fila es una tipo de violacion            
            $conteo->violaciones = $conteo->violaciones + $violacion->cantidad_victimas;
        }
        
        // $conteo->exilio = $this->rel_ficha_exilio()->count() ; //Fichas de exilio
        $conteo->exilio = 0;
        $conteo->cierre=0;
        //Determinar si se necesita exilio
        $con_exilio = hecho_violencia::join('fichas.hecho','hecho.id_hecho','=','hecho_violencia.id_hecho')
                            ->join('catalogos.violencia','hecho_violencia.id_subtipo_violencia','=','violencia.id_geo')
                            ->where('hecho.id_entrevista_etnica',$this->id_entrevista_etnica)
                            ->where('violencia.codigo','2201')
                            ->count();

        $conteo->hay_exilio = $con_exilio == 0 ? 0 : 1 ;
        //$conteo->exilio = $this->rel_ficha_exilio->count();
        $conteo->exilio_collapsed = true;  //ocultar

        //Adjuntos
        $conteo->adjuntos = $this->rel_adjunto()->count();
        

        //Colores
        $conteo->color_victima = $conteo->victimas== 0 ? ' bg-red ' : ' bg-green ';
        $conteo->color_victima_box = $conteo->victimas== 0 ? ' box-danger ' : ' box-success ';
        $conteo->color_hechos = $conteo->hechos== 0 ? ' bg-red ' : ' bg-green ';
        $conteo->color_hechos_box = $conteo->hechos== 0 ? ' box-danger ' : ' box-success ';
        $conteo->color_violaciones = $conteo->violaciones == 0 ? ' bg-red ' : ' bg-green ';
        $conteo->color_responsables = $conteo->responsables == 0 ? ' bg-green' : ' bg-yellow ';
        $conteo->color_responsables_box = $conteo->responsables == 0 ? ' box-default' : ' box-success ';
        $conteo->color_exilio_box =  ' box-success ';

        if($conteo->hay_exilio==1) { //Llenaron hechos con exilio
            $conteo->color_exilio_box = $conteo->exilio == 0 ? ' box-danger ' : ' box-success ';
            $conteo->exilio_collapsed = false;
        }
        if($conteo->exilio > 0) {  //Llenaron ficha de exilio, pero no hay hechos con exilio
            $conteo->exilio_collapsed = false;
        }

        $conteo->color_adjunto = $conteo->adjuntos == 0  ? ' bg-red ' : ' bg-green ';

        //
        // Alertas
        $conteo->alerta_conteo = 0;
        $conteo->alerta_txt = array();
        //Color de los hechos en amarillo. alguno pendiente
        foreach($this->rel_ficha_hecho as $hecho) {
            if(!$hecho->control_calidad->completo) {
                $conteo->color_hechos_box = ' box-warning ';
                $conteo->alerta_txt[]="Alguna información de hechos se encuentra incompleta";
                break;
            }
        }

        if($conteo->entrevista == 0) {
            // $conteo->alerta_txt[]="Falta completar la información de entrevista";
            $conteo->alerta_txt[]="Pendiente consentimiento informado.";
        }
        if($conteo->entrevistado == 0) {
            // $conteo->alerta_txt[]="Falta completar la información de persona entrevistada";
        }

        if($conteo->victimas == 0) {
            // $conteo->alerta_txt[]="Falta completar información de al menos una víctima";
        }
        else {
            //Victimas sin hechos
            $arreglo_victimas = victima::where('id_e_ind_fvt',$this->id_e_ind_fvt)->pluck('id_victima')->toarray();
            $arreglo_victimas_en_hechos = hecho::where('id_e_ind_fvt',$this->id_e_ind_fvt)
                                                ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
                                                ->pluck('id_victima')->toarray();
            $pendiente=0;
            foreach($arreglo_victimas as $id_victima) {
                if(!in_array($id_victima,$arreglo_victimas_en_hechos)) {
                    $pendiente++;
                }
            }
            $conteo->victimas_pendientes=$pendiente;



            if($pendiente > 0) {
                $conteo->color_victima = ' bg-yellow ';
                $conteo->color_victima_box = ' box-warning ';
                $conteo->alerta_txt[]="Existen víctimas no incluidas en ningún hecho";
            }
            else {
                $conteo->color_victima = ' bg-green ';
                $conteo->color_victima_box = ' box-success ';
            }


        }
        if($conteo->responsables > 0) {
            //Revisar responsables sin violaciones
            $a_responsable = persona_responsable::where('id_e_ind_fvt',$this->id_entrevista_etnica)->pluck('id_persona_responsable')->toarray();
            $a_responsable_en_hechos = hecho::where('id_e_ind_fvt',$this->id_entrevista_etnica)
                                            ->join('fichas.hecho_responsable','hecho.id_hecho','=','hecho_responsable.id_hecho')
                                            ->pluck('id_persona_responsable')->toarray();
            $pendiente=0;
            foreach($a_responsable as $id_responsable) {
                if(!in_array($id_responsable,$a_responsable_en_hechos)) {
                    $pendiente++;
                }
            }
            $conteo->responsables_pendientes=$pendiente;
            if($pendiente > 0) {
                $conteo->color_responsables = ' bg-yellow ';
                $conteo->color_responsable_box = ' box-warning ';
                $conteo->color_hechos_box = ' box-warning ';
                $conteo->alerta_txt[]="Existen responsables no incluidos en ningún hecho";
            }
            else {
                $conteo->color_responsables = ' bg-green ';
                $conteo->color_responsable_box = ' box-success ';
            }

        }

        if($conteo->hechos == 0) {
            $conteo->alerta_txt[]="Falta completar la información de los hechos";
        }
        /*
        if($conteo->hay_exilio==1 && $conteo->exilio == 0) {
            $conteo->alerta_txt[]="No se ha diligenciado la información del exilio";
            $conteo->color_hechos = ' bg-yellow ';
        }
        */
        if($conteo->impactos == 0) {
            $conteo->alerta_txt[]="Falta diligenciar la información de impactos";
        }
        //Hechos con exilio, sin ficha de exilio
        if($conteo->hay_exilio == 1) {
            if($conteo->exilio==0) {
                // $conteo->alerta_txt[]="No se ha diligenciado la información del exilio";                
                $conteo->color_exilio_box = ' box-danger ';
            }
        }

        //Fichas de exilio incompletas: el ->ordenado() es para que ignore inconsistencias donde hay exilio sin movimiento de salida.  No debería pasar, pero por si acaso
        // foreach($this->rel_ficha_exilio()->ordenado()->get() as $f_exilio) {
        //     if(!$f_exilio->fmt_completo->completa) {
        //         $conteo->color_exilio_box = ' box-warning ';

        //         foreach($f_exilio->fmt_completo->alerta as $txt) {
        //             $conteo->alerta_txt[]="Exilio: $txt";
        //         }
        //     }
        // }





        //Alertas de la ficha de
        //Conteo de alertas
        $conteo->alerta_conteo = count($conteo->alerta_txt);

        //Consentimiento informado
        $conteo->consentimiento_alertas = array();
        $conteo->consentimiento = entrevista::where('id_entrevista_etnica',$this->id_entrevista_etnica)->first();
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
            if ($conteo->consentimiento->grabar_video  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó grabar el video de la participación de la comunidad para la entrevista";
            }
            if ($conteo->consentimiento->tomar_fotografia  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó tomar fotografías de la participación de la comunidad para la entrevista";
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
            //Boton
            if(count($conteo->consentimiento_alertas)>0) {
                $title='Existen alertas en el consentimiento informado';
                $color="btn-success";
            }
            else {
                $title='Consentimiento informado diligenciado y sin alertas';
                $color="btn-success";
            }
        }
        else {
            $conteo->consentimiento_alertas[] = "No se ha diligenciado el consentimiento informado";
        }



        $conteo->situacion=0;
        if($conteo->entrevista >0 || $conteo->entrevistado > 0 || $conteo->victimas >0 || $conteo->hechos>0 || $conteo->responsables > 0) {
            $conteo->situacion = $conteo->alerta_conteo > 0 ? 2 : 3;
        }
        else {
            $conteo->situacion=1;
        }
        $colores[0]='btn-info';
        $colores[1]='btn-info';
        $colores[1]='btn-info';
        $colores[2]='btn-warning';
        $colores[3]='btn-success';
        $texto[0]='Sin fichas';
        $texto[1]='Sin fichas';
        $texto[2]='Fichas incompletas';
        $texto[3]='Fichas diligenciadas';
        $conteo->situacion_boton=$colores[$conteo->situacion];
        $conteo->situacion_texto=$texto[$conteo->situacion];
        //botones

        //Devolver los datos
        return $conteo;
    }
    
    public function tipo() {
        return 'etnica';
    }

    public function id() {
        return $this->id_entrevista_etnica;
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
            $adjuntado = new entrevista_etnica_adjunto();
            $adjuntado->id_entrevista_etnica = $this->id_entrevista_etnica;
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
        $existe = prioridad::where('id_entrevista',$this->id_entrevista_etnica)->where('id_subserie',config('expedientes.ee'))
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


    //Para el select de responsables
    public function arreglo_responsables() {
        $arreglo = array();
        foreach($this->rel_ficha_responsable as $responsable) {
            $arreglo[$responsable->id_persona_responsable]=$responsable->persona->nombrecompleto." (".$responsable->persona->alias.")";
        }
        return $arreglo;
    }

    // Devuele el código de la entrevista
    public static function codigo($id_entrevista_etnica=null) {
        if($id_entrevista_etnica <= 0) return "Sin Especificar";
        $existe = self::find($id_entrevista_etnica);
        if(empty($existe)) {
            return "Desconocido ($id_entrevista_etnica)";
        }
        else {
            return $existe->entrevista_codigo;
        }
    }


    //Para mostrar detalle en el panel de fichas
    public function conteo_impactos() {
        $conteos=new \stdClass();
        $conteos->i_individuales=0;
        $conteos->i_relacionales=0;
        $conteos->i_colectivos=0;
        $conteos->a_individual=0;
        $conteos->a_familiar=0;
        $conteos->a_colectivo=0;
        $conteos->denuncia=0;
        $conteos->reparacion=0;

        $base = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
                                    ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item');

        $conteos->i_individuales = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
                                    ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                                    ->wherein('id_cat',[132,133,134, 236])->count();
        $conteos->i_relacionales = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[135,136])->count();
        $conteos->i_colectivos = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[138,139,140,141,142,143])->count();
        $conteos->a_individual = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[144])->count();
        $conteos->a_familiar = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[145])->count();
        $conteos->a_colectivo = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[146,147,148])->count();
        $conteos->denuncia = justicia_institucion::where('id_entrevista_etnica',$this->id_entrevista_etnica)->count();
        $conteos->reparacion = entrevista_impacto::where('id_entrevista_etnica',$this->id_entrevista_etnica)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[164,165,166,167,168])->count();


        return $conteos;




    }

    //Evaluar si el usuario activo puede  ver las fichas
    public function permitir_ver_fichas() {
        $respuesta = new \stdClass();
        $respuesta->permitido=false;
        $respuesta->texto="Sin analizar";

        //
        $activo=\Auth::user();
        if (!$activo) {
            return false;
        }
        $arreglo_asignados=entrevistador::entrevistadores_asignados($activo->id_entrevistador);
        if (in_array($this->id_entrevistador, $arreglo_asignados)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
            return $respuesta;
        }
        //No se hace el else, porque hay que evaluar según el perfil

        //Verificar si le han compartido alguna entrevista.
        //  Esta función debe existir en c/modelo ya que en esa función se especifica la llave primaria y el id_subserie
        if ($this->revisar_asignacion()) {
            $respuesta->permitido=true;
            $respuesta->texto="Asignada del usuario";
            return $respuesta;
        }

        if (\Gate::allows('es-propio', $this->id_entrevistador)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
        } else {
            //Perfil de solo estadística
            if (Gate::allows('solo-estadistica')) {
                $respuesta->permitido=false;
                $respuesta->texto="Perfil estadístico";
            } else {
                //Ver que tenga permisos de acceso a la entrevista
                if (!$this->puede_acceder_entrevista) {
                    $respuesta->texto = "No puede acceder a esta entrevista";
                    $respuesta->permitido = false;
                } else {
                    //Segundo chequeo: reservado-3
                    if (!$this->puede_acceder_adjuntos()) { //R3 y R2
                        $respuesta->texto = "Restricciones de analista. No puede consultar las fichas de un expediente RESERVADO.";
                        $respuesta->permitido = false;
                    } else {
                        $respuesta->texto = "Puede acceder a la entrevista y tiene acceso a los adjuntos";
                        $respuesta->permitido = true;
                    }
                }
            }
        }
        
        return $respuesta;
    }

    // Retorna el id de la entrevista segun sea etnica
    public function getIdEntrevistaAttribute() {
        return $this->id_entrevista_etnica;
    } 
    
    public function getFmtIdPrioritarioAttribute() {
        return $this->id_prioritario==1 ? "Sí" : "No";
    }
    public function getFmtIdCerradoAttribute() {
        $str="";
        if($this->id_cerrado==1) {
            $str = '<i class="fa fa-lock"  title="Procesamiento finalizado" data-toggle="tooltip" aria-hidden="true"></i>';
        }
        return $str;
    }

    // Setters
    public function setPrioritarioTemaAttribute($val) {
        $val=trim($val);
        if(strlen($val)<=0) {
            $this->attributes['prioritario_tema']=null;
        }
        else {
            $this->attributes['prioritario_tema']=$val;
        }
    }    

    public static function scopeId_prioritario($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('id_prioritario',$criterio);
        }
    }
    public static function scopePrioritario_tema($query,$criterio=null) {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->where('prioritario_tema','ilike',"%$criterio%");
        }
    }

    
    public static function si_valida_campos() {

        // Deshabilita la validación desde el servidor para cuando está actualizando el consentimiento informado únicamente
        if(isset($_POST['m_aut']) && $_POST['m_aut']=="edt_ci")
            return false;

        return true;
    }  
    
    public function tipo_entrevista() {
        return 'etnica';
    }

    //Estos getters son Para facilitar la edicion
    public function getArchivoCiAttribute() {
        $existe = $this->rel_adjunto()->where('id_tipo',1)->first();
        if($existe) {
            return $existe->fmt_nombre;
        }
        else {
            return "";
        }
    }    



    //Información para el dashboard principal
    public static function datos_dash($filtros=null) {
        if(!is_object($filtros)) {
            $filtros = entrevista_profundidad::filtros_default();
        }
        //Tipo de entrevista
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_etnica.entrevista_avance','=','cat_item.id_item')
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

        $avance = new \stdClass();
        $avance->categorias = $categorias;
        $avance->a_serie[] = $datos;
        $avance->nombre_serie[]="Entrevistas";
        $avance->descarga="ee_avance";
        $avance->grafica=graficador::g_pie($avance);


        //Sector
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_etnica.id_sector','=','cat_item.id_item')
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
        $sector->descarga="ee_sector";
        $sector->grafica=graficador::g_columna($sector);

        // Tipo de sujeto colectivo
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_etnica.id_tipo_sujeto','=','cat_item.id_item')
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

        $tipo_sujeto = new \stdClass();
        $tipo_sujeto->categorias = $categorias;
        $tipo_sujeto->a_serie[] = $datos;
        $tipo_sujeto->nombre_serie[]="Entrevistas";
        $tipo_sujeto->descarga="ee_tipo_sujeto";
        $tipo_sujeto->grafica=graficador::g_barra($tipo_sujeto);

        // Tipo de entrevista
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_etnica.id_tipo_entrevista','=','cat_item.id_item')
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

        $tipo = new \stdClass();
        $tipo->categorias = $categorias;
        $tipo->a_serie[] = $datos;
        $tipo->nombre_serie[]="Entrevistas";
        $tipo->descarga="ee_tipo";
        $tipo->grafica=graficador::g_barra($tipo);

        // Pueblos indigenas
        $query=self::filtrar($filtros)
            ->join('esclarecimiento.entrevista_etnica_indigena as p','entrevista_etnica.id_entrevista_etnica','=','p.id_entrevista_etnica')
            ->join('catalogos.cat_item','p.id_indigena','=','cat_item.id_item')
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

        $pueblo_i = new \stdClass();
        $pueblo_i->categorias = $categorias;
        $pueblo_i->a_serie[] = $datos;
        $pueblo_i->nombre_serie[]="Entrevistas";
        $pueblo_i->descarga="ee_p_indigena";
        $pueblo_i->grafica=graficador::g_barra($pueblo_i);


        // Pueblos afro
        $query=self::filtrar($filtros)
            ->join('esclarecimiento.entrevista_etnica_narf as p','entrevista_etnica.id_entrevista_etnica','=','p.id_entrevista_etnica')
            ->join('catalogos.cat_item','p.id_narf','=','cat_item.id_item')
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

        $pueblo_a = new \stdClass();
        $pueblo_a->categorias = $categorias;
        $pueblo_a->a_serie[] = $datos;
        $pueblo_a->nombre_serie[]="Entrevistas";
        $pueblo_a->descarga="ee_p_afro";
        $pueblo_a->grafica=graficador::g_barra($pueblo_a);


        // Pueblos rrom
        $query=self::filtrar($filtros)
            ->join('esclarecimiento.entrevista_etnica_rrom as p','entrevista_etnica.id_entrevista_etnica','=','p.id_entrevista_etnica')
            ->join('catalogos.cat_item','p.id_rrom','=','cat_item.id_item')
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

        $pueblo_r = new \stdClass();
        $pueblo_r->categorias = $categorias;
        $pueblo_r->a_serie[] = $datos;
        $pueblo_r->nombre_serie[]="Entrevistas";
        $pueblo_r->descarga="ee_p_afro";
        $pueblo_r->grafica=graficador::g_barra($pueblo_r);


        //Cantidad de participantes
        $query=self::filtrar($filtros)
            ->select(\DB::raw("entrevista_etnica.cantidad_participantes as id_item, entrevista_etnica.cantidad_participantes as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');
        //$debug['sql']=$query->toSql();
        //$debug['par']=$query->getBindings();

        $limites = array(1,2,3,4,5,6,7,8,9,10,25,50,100000);  //Estas categorias se usan en el scopeCantidad_personas
        //Todas las categorias
        $categorias=array();
        $categorias[1]=1;
        $categorias[2]=2;
        $categorias[3]=3;
        $categorias[4]=4;
        $categorias[5]=5;
        $categorias[6]=6;
        $categorias[7]=7;
        $categorias[8]=8;
        $categorias[9]=9;
        $categorias[10]=10;
        $categorias[25]='11-25';
        $categorias[50]='26-50';
        $categorias[100000]='51 o más';
        //Todos los datos
        $datos=array();
        foreach($categorias as $id => $txt) {
            $datos[$id]=0;
        }

        //Obtener y procesar datos
        $info = $query->get();
        foreach($info as $fila) {
            //$grupo=51;
            foreach($limites as $id => $max) {
                if($max >= $fila->id_item ) {
                    break;
                }
            }
            $grupo=$max;
            $datos[$grupo] += $fila->conteo;
        }

        //Eliminar las que no tengan valores
        foreach($datos as $id=>$val) {
            if($val==0) {
                unset($categorias[$id]);
            }
        }

        $cantidad = new \stdClass();
        $cantidad->categorias = $categorias;
        $cantidad->a_serie[] = $datos;
        $cantidad->nombre_serie[]="Entrevistas";
        $cantidad->descarga="ee_cantidad_entrevistados";
        $cantidad->grafica=graficador::g_columna($cantidad);

        $respuesta = new \stdClass();
        $respuesta->avance = $avance;
        $respuesta->sector = $sector;
        $respuesta->tipo = $tipo;
        $respuesta->tipo_sujeto = $tipo_sujeto;
        $respuesta->pueblo_i = $pueblo_i;
        $respuesta->pueblo_a = $pueblo_a;
        $respuesta->pueblo_r = $pueblo_r;
        $respuesta->cantidad = $cantidad;


        return $respuesta;

    }
    //Para convertir el tesauro en nube de etiquetas
    public function etiquetas_a_texto() {
        $listado = entrevista_individual::listado_etiquetas(config('expedientes.ee'), $this->id_entrevista_etnica);
        return implode(" ",$listado);
    }

    //Corregir error del update de la entrevista que cambia el codigo.  10/dic/20
    public static function revisar_codigo_entrevista() {
        $listado = self::orderby('entrevista_correlativo','desc')->get();
        $total=0;
        $a_corregidos = array();
        foreach($listado as $e) {
            $correcto = $e->calcular_codigo();
            if($e->entrevista_codigo <> $correcto) {
                $malo = $e->entrevista_codigo;
                $e->entrevista_codigo = $correcto;
                $e->save();
                $id=$e->id_entrevista_etnica;
                traza_actividad::create(['id_objeto'=>14, 'id_accion'=>66, 'codigo'=>$correcto, 'referencia'=>"codigo anterior: $malo", 'id_primaria'=>$id]);
                traza_actividad::where('codigo',$malo)
                    ->update(['codigo'=>$correcto]);
                $a_corregidos[]=$correcto;
            }
            $total++;
        }
        $res =new \stdClass();
        $res->a_corregidos = $a_corregidos;
        $res->registros = $total;
        $res->registros_corregidos = count($a_corregidos);

        return $res;
    }


    //Cambio el 11-may-22: puede tener más de un consentimiento.  Hago un nueva function que no haga conflicto con la anterior
    //Consentimientos informados
    public function rel_consentimiento_listado() {
        return $this->hasMany(entrevista::class,'id_entrevista_etnica','id_entrevista_etnica')
            ->orderby('asistencia','desc')
            ->orderby('consentimiento_correlativo')
            ->orderby('consentimiento_apellidos')
            ->orderby('consentimiento_nombres')
            ->where('borrable','<>',1);
    }

}
