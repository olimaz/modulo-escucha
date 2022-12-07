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
 * Class entrevista_colectiva
 * @package App\Models
 * @version July 31, 2019, 10:50 am -05
 *
 * @property integer id_entrevista_colectiva
 * @property \App\Models\entrevistador idEntrevistador
 * @property \App\Models\cev idMacroterritorio
 * @property \App\Models\cev idTerritorio
 * @property \App\Models\geo temaLugar
 * @property \App\Models\geo entrevistaLugar
 * @property \App\Models\cat_item idSector
 * @property \App\Models\User idUsuario

 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property integer id_entrevistador
 * @property integer numero_entrevistador
 * @property string entrevista_codigo
 * @property integer entrevista_correlativo
 * @property integer entrevista_numero
 * @property integer entrevista_lugar
 * @property string|\Carbon\Carbon entrevista_fecha_inicio
 * @property string|\Carbon\Carbon entrevista_fecha_final
 * @property integer entrevista_avance
 * @property string titulo
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
 * @property string eventos_descripcion
 * @property string observaciones
 * @property integer clasificacion_nna
 * @property integer clasificacion_sex
 * @property integer clasificacion_res
 * @property integer clasificacion_nivel
 * @property integer clasificacion_r1
 * @property integer clasificacion_r2
 * @property integer id_usuario
 * @property integer tiempo_entrevista
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class entrevista_colectiva extends Model
{

    public $table = 'esclarecimiento.entrevista_colectiva';
    protected $primaryKey = 'id_entrevista_colectiva';
    public $timestamps = true;


    public $fillable = [
        'id_macroterritorio',
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
        'eventos_descripcion',
        'observaciones',
        'clasificacion_nna',
        'clasificacion_sex',
        'clasificacion_res',
        'clasificacion_nivel',
        'clasificacion_r1',
        'clasificacion_r2',
        'id_usuario',
        'tiempo_entrevista',
        'created_at',
        'updated_at',
        'es_virtual',
        'tema_del',
        'tema_al'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entrevista_colectiva' => 'integer',
        'id_macroterritorio' => 'integer',
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
        'equipo_facilitador' => 'string',
        'equipo_memorista' => 'string',
        'equipo_otros' => 'string',
        'tema_descripcion' => 'string',
        'tema_objetivo' => 'string',
        //'tema_del' => 'datetime',
        //'tema_al' => 'datetime',
        'tema_lugar' => 'integer',
        'cantidad_participantes' => 'integer',
        'id_sector' => 'integer',
        'eventos_descripcion' => 'string',
        'observaciones' => 'string',
        'clasificacion_nna' => 'integer',
        'clasificacion_sex' => 'integer',
        'clasificacion_res' => 'integer',
        'clasificacion_nivel' => 'integer',
        'clasificacion_r1' => 'integer',
        'clasificacion_r2' => 'integer',
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
        return $this->hasMany(seguimiento::class,'id_entrevista','id_entrevista_colectiva')->where('id_subserie',config('expedientes.co'))->orderby('fecha_hora');
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
    public function rel_entrevista_lugar() {
        return $this->belongsTo(geo::class,'entrevista_lugar','id_geo');
    }
    public function rel_mandato() {
        return $this->hasMany(entrevista_colectiva_mandato::class,'id_entrevista_colectiva','id_entrevista_colectiva');
    }
    public function rel_adjunto() {
        return $this->hasMany(entrevista_colectiva_adjunto::class,'id_entrevista_colectiva','id_entrevista_colectiva');
    }
    //Entidades debiles
    public function rel_dinamica() {
        return $this->hasMany(entrevista_colectiva_dinamica::class,$this->primaryKey,$this->primaryKey);
    }
    public function rel_interes() {
        return $this->hasMany(entrevista_colectiva_interes::class,$this->primaryKey,$this->primaryKey);
    }
    //Relaciones específicas de este instrumento
    public function rel_tema_lugar() {
        return $this->belongsTo(geo::class,'tema_lugar','id_geo');
    }

    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista',$this->primaryKey)->where('id_subserie',config('expedientes.co'));;
    }

    //Permisos si fuera reservado-3
    public function rel_acceso_reservado() {
        return $this->hasMany(reservado_acceso::class,'id_primaria',$this->primaryKey)->where('reservado_acceso.id_subserie',config('expedientes.co'))->where('id_activo',1);
    }
    //Asiganciones de transcripcion
    public function rel_transcripcion() {
        return $this->hasMany(transcribir_asignacion::class,$this->primaryKey,$this->primaryKey)->orderby('id_transcribir_asignacion','desc');;
    }
    //Asignaciones para etiquetado
    public function rel_etiquetado() {
        return $this->hasMany(etiquetar_asignacion::class,$this->primaryKey,$this->primaryKey)->orderby('id_etiquetar_asignacion','desc');;
    }
    //Etiquetado
    public function rel_etiquetas() {
        return $this->hasMany(etiqueta_entrevista::class,'id_entrevista',$this->primaryKey)->where('id_subserie',config('expedientes.co'))->orderby('del');
    }
    public function listar_etiquetas() {
        return etiqueta_entrevista::where('id_subserie',config('expedientes.co'))->where('id_entrevista',$this->id_entrevista_colectiva)
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
            if($this->rel_adjunto()->where('entrevista_colectiva_adjunto.id_tipo',$id_tipo)->count()==0) {
                $puede=false;
                break;
            }
        }
        return $puede;
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

    /*
     * FUNCIONES DE SEGURIDAD
     */


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


        return in_array($this->id_entrevista_colectiva,$asignaciones);
    }

    //Para el scope de permisos
    public static function arreglo_asignaciones($id_subserie=0,$llave_primaria="") {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        $id_subserie = $id_subserie > 0 ? $id_subserie : config("expedientes.co");
        $llave_primaria = strlen($llave_primaria) > 0 ? $llave_primaria : 'id_entrevista_colectiva';
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

    ///////////// FIN DE REGLAS DE SEGURIDAD ////////////////////


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
    public function getFmtIdCerradoAttribute() {
        $str="";
        if($this->id_cerrado==1) {
            $str = '<i class="fa fa-lock"  title="Procesamiento finalizado" data-toggle="tooltip" aria-hidden="true"></i>';
        }
        return $str;
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
    public function clasificacion_rojo($par) {
        return $par == 1 ? "<span class='text-danger'>Sí</span>" : "No";
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
        return entrevista_colectiva_adjunto::listado_adjuntos($this->id_entrevista_colectiva);
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
        $id_subserie=config('expedientes.co');
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
        $id_subserie=config('expedientes.co');
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

    //Para el softdelete
    public static function scopeId_activo($query, $id_activo=1) {
        if($id_activo>0) {
            $query->where('id_activo',$id_activo);
        }

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
        //Propias del instrumento
        $filtro->id_sector = null;
        $filtro->tema_del = null;
        $filtro->tema_al = null;
        $filtro->tema_lugar = -1;
        $filtro->tema_objetivo = null;
        $filtro->tema_descripcion = null;
        $filtro->eventos_descripcion = null;
        $filtro->observaciones = null;
        $filtro->cantidad_participantes = -1;
        //Softdelete
        $filtro->id_activo = 1;
        //Busqueda rapida
        $filtro->br=null;
        //transcrita
        $filtro->transcrita=-1;
        $filtro->etiquetada=-1;
        $filtro->marca = array();
        $filtro->id_cerrado=-1;
        //
        $filtro->con_transcripcion=-1;
        $filtro->con_etiquetado=-1;
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
        $filtro->id_subserie = config('expedientes.co'); //PAra el autofill

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
        $filtro->id_activo = isset($request->id_activo) ? intval($request->id_activo) : $filtro->id_activo;
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
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;
        $filtro->cantidad_participantes = isset($request->cantidad_participantes) ? $request->cantidad_participantes : $filtro->cantidad_participantes;
        $filtro->transcrita = isset($request->transcrita) ? $request->transcrita : $filtro->transcrita;
        $filtro->etiquetada = isset($request->etiquetada) ? $request->etiquetada : $filtro->etiquetada;
        $filtro->marca = isset($request->marca) ? $request->marca : $filtro->marca;
        $filtro->id_cerrado = isset($request->id_cerrado) ? $request->id_cerrado : $filtro->id_cerrado;
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
                    $filtro->id_macroterritorio=$request->id_territorio_macro;
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
        $filtro->observaciones = isset($request->observaciones) ? $request->observaciones : $filtro->observaciones;
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
            $query->wherein('esclarecimiento.entrevista_colectiva.id_entrevistador',$criterio);
        }
        elseif($criterio>0) {
            $query->where('esclarecimiento.entrevista_colectiva.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_macroterritorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_colectiva.id_macroterritorio',$criterio);
        }
    }
    public static function scopeId_territorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_colectiva.id_territorio',$criterio);
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
                $query->join('esclarecimiento.entrevista_colectiva_mandato as fmandato', 'entrevista_colectiva.id_entrevista_colectiva', '=', 'fmandato.id_entrevista_colectiva')
                    ->wherein('id_mandato', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_colectiva_mandato as fmandato', 'entrevista_colectiva.id_entrevista_colectiva', '=', 'fmandato.id_entrevista_colectiva')
                    ->where('id_mandato',$criterio);
            }
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

    //Para asingar etiquetado/transcripcion
    public static function scopeProcesable($query) {

        $a=array();
        $b=array();
        $c=array();
        //Primer grupo: virtuales
        $a = entrevista_colectiva::join('esclarecimiento.entrevista_colectiva_adjunto as a_au','entrevista_colectiva.id_entrevista_colectiva','=','a_au.id_entrevista_colectiva')
            ->where('a_au.id_tipo',2)
            ->where('es_virtual',1)->distinct()->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();
        //Segundo grupo: no virtuales
        $b = entrevista_colectiva::join('esclarecimiento.entrevista_colectiva_adjunto as a_ci','entrevista_colectiva.id_entrevista_colectiva','=','a_ci.id_entrevista_colectiva')
            ->where('a_ci.id_tipo',1)
            ->join('esclarecimiento.entrevista_colectiva_adjunto as a_au','entrevista_colectiva.id_entrevista_colectiva','=','a_au.id_entrevista_colectiva')
            ->where('a_au.id_tipo',2)
            ->where('es_virtual',2)->distinct()->pluck('entrevista_colectiva.id_entrevista_colectiva')->toArray();

        $c = array_merge($a, $b);
        $query->wherein('entrevista_colectiva.id_entrevista_colectiva',$c);
    }

    //Para filtrar por listados cargados en excel
    public static function scopeId_excel_listados($query,$criterio) {
        if($criterio > 0) {
            $codigos = excel_listados::arreglo_codigos($criterio);
            $query->wherein('entrevista_codigo',$codigos);
        }
    }


    //De acuerdo al perfil, aplica los permisos  (funcion reemplazada en ene-20)
    public static function scopePermisos_bak($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('entrevista_colectiva.id_entrevistador',$arreglo_entrevistadores);
        if(\Auth::check()) {  //Transcriptores
            if(\Auth::user()->id_nivel==11) {
                $asignadas = transcribir_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                    ->where('id_situacion',1)
                    ->pluck('id_entrevista_colectiva');
                //dd($asignadas);

                $query->wherein('entrevista_colectiva.id_entrevista_colectiva',$asignadas);

            }
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
            $asignadas = entrevista_colectiva::arreglo_asignaciones();
            $id_macroterritorio=\Auth::user()->id_macroterritorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( entrevista_colectiva.id_macroterritorio = $id_macroterritorio  OR entrevista_colectiva.id_entrevista_colectiva in ($asignadas_where) )"));
            }
            else {
                $query->where('entrevista_colectiva.id_macroterritorio',$id_macroterritorio);
            }

        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            $asignadas = entrevista_colectiva::arreglo_asignaciones();
            $id_territorio=\Auth::user()->id_territorio;
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( entrevista_colectiva.id_territorio = $id_territorio  OR entrevista_colectiva.id_entrevista_colectiva in ($asignadas_where) )"));
            }
            else {
                $query->where('entrevista_colectiva.id_territorio',$id_territorio);
            }

        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas(); //Asignación de otros entrevistadores
            $asignadas = entrevista_colectiva::arreglo_asignaciones();
            if(count($asignadas) > 0) {
                $asignadas_where=implode(",",$asignadas); //Arreglo de entrevistas asignadas
                $entrevistadores_where = implode(",", $arreglo_entrevistadores);  //Arreglo de entrevistadores asignados
                $query->whereraw(DB::raw("( entrevista_colectiva.id_entrevistador in ($entrevistadores_where)  OR entrevista_colectiva.id_entrevista_colectiva in ($asignadas_where) )"));
            }
            else {
                $query->wherein('entrevista_colectiva.id_entrevistador',$arreglo_entrevistadores);
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
            // Entrevistas asignadas
            $asignadas = entrevista_colectiva::arreglo_asignaciones();
            $query->wherein('entrevista_colectiva.id_entrevista_colectiva',$asignadas);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('entrevista_colectiva.id_entrevistador',-1); //Ninguno
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
        $query->whereNotIn('entrevista_colectiva.id_entrevistador',$otros_confidenciales);
        */
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);

        //Si es de un grupo ajeno, agregar el filtro del grupo  (ruta pacifica, oim, etc)
        if(Gate::allows('grupo-ajeno')) {
            $query->join('esclarecimiento.entrevistador as fsg','entrevista_colectiva.id_entrevistador','=','fsg.id_entrevistador')
                ->where('fsg.id_grupo',\Auth::user()->id_grupo);
        }


    }

    //Nueva version, 18-feb: todos pueden ver todos los metadatos
    public static function scopePermisos_new($query) {
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //Sin filtro, acceso total
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_colectiva.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo);
            }
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_colectiva.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_colectiva.id_macroterritorio',\Auth::user()->id_macroterritorio);
            }
            //$query->where('e_ind_fvt.id_macroterritorio',\Auth::user()->id_macroterritorio);
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_colectiva.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_colectiva.id_territorio',\Auth::user()->id_territorio);
            }
            //$query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','entrevista_colectiva.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('entrevista_colectiva.id_entrevistador',\Auth::user()->id_entrevistador);
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
                ->pluck('id_entrevista_colectiva')->toArray();
            $asignadas_e = etiquetar_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                ->where('id_situacion',1)
                ->pluck('id_entrevista_colectiva')->toArray();

            $asignaciones = array_merge($asignadas_t, $asignadas_e);

            $query->wherein('entrevista_colectiva.id_entrevista_colectiva',$asignaciones);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('entrevista_colectiva.id_entrevistador',-1); //Ninguno
        }

    }
    //Filtro según el grupo al que pertenece
    public static function scopeId_grupo($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('esclarecimiento.entrevistador as filtro_eg','entrevista_colectiva.id_entrevistador','=','filtro_eg.id_entrevistador')
                ->where('filtro_eg.id_grupo',$criterio);
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
    public static function scopeObservaciones($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('observaciones','ilike',"%$criterio%");
        }
    }
    public static function scopeDinamica($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->join('esclarecimiento.entrevista_colectiva_dinamica as fdinamica','entrevista_colectiva.id_entrevista_colectiva', '=', 'fdinamica.id_entrevista_colectiva')
                ->where('dinamica','ilike',"%$criterio%");
        }
    }
    public static function scopeInteres($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.entrevista_colectiva_interes as finteres', 'entrevista_colectiva.id_entrevista_colectiva', '=', 'finteres.id_entrevista_colectiva')
                    ->wherein('id_interes', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.entrevista_colectiva_interes as finteres', 'entrevista_colectiva.id_entrevista_colectiva', '=', 'finteres.id_entrevista_colectiva')
                    ->where('id_interes', $criterio);
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
            $where[]="observaciones ilike '%$criterio%'";
            $where[]="entrevista_codigo ilike '%$criterio%'";
            $where[]="titulo ilike '%$criterio%'";
            $where[]="tema_descripcion ilike '%$criterio%'";
            $where[]="tema_objetivo ilike '%$criterio%'";
            $where[]="eventos_descripcion ilike '%$criterio%'";
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
            $query->wherenull('entrevista_colectiva.id_transcrita');
        }
        elseif($criterio>0) {
            $query->where('entrevista_colectiva.id_transcrita',$criterio);
        }
    }
    public static function scopeQuienTranscribe($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('public.transcribir_asignacion as taa','entrevista_colectiva.id_entrevista_colectiva','=','taa.id_entrevista_colectiva')
                ->where('taa.id_situacion',2)
                ->where('taa.id_transcriptor',$criterio);
        }
    }
    public static function scopeEtiquetada($query,$criterio=-1) {
        if($criterio==0) { //Sin asignar
            $query->wherenull('entrevista_colectiva.id_etiquetada');
        }
        elseif($criterio>0) {
            $query->where('entrevista_colectiva.id_etiquetada',$criterio);
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

    //Priorizacion
    public static function scopeTipo_prioridad($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp0','entrevista_colectiva.id_entrevista_colectiva','=','fp0.id_entrevista')
                ->where('fp0.id_subserie','=',config('expedientes.co'))
                ->where('fp0.id_tipo',$criterio);
        }
    }
    public static function scopeFluidez($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp1','entrevista_colectiva.id_entrevista_colectiva','=','fp1.id_entrevista')
                ->where('fp1.id_subserie','=',config('expedientes.co'))
                ->where('fp1.fluidez',$criterio);
        }
    }
    public static function scopeCierre($query,$criterio=-1) {
        if($criterio>=0) {
            $query->join('prioridad as fp2','entrevista_colectiva.id_entrevista_colectiva','=','fp2.id_entrevista')
                ->where('fp2.id_subserie','=',config('expedientes.co'))
                ->where('fp2.cierre',$criterio);
        }
    }
    public static function scopeD_hecho($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','entrevista_colectiva.id_entrevista_colectiva','=','fp3.id_entrevista')
                ->where('fp3.id_subserie','=',config('expedientes.co'))
                ->where('fp3.d_hecho',$criterio);
        }
    }
    public static function scopeD_impacto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','entrevista_colectiva.id_entrevista_colectiva','=','fp4.id_entrevista')
                ->where('fp4.id_subserie','=',config('expedientes.co'))
                ->where('fp4.d_impacto',$criterio);
        }
    }
    public static function scopeD_contexto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','entrevista_colectiva.id_entrevista_colectiva','=','fp5.id_entrevista')
                ->where('fp5.id_subserie','=',config('expedientes.co'))
                ->where('fp5.d_contexto',$criterio);
        }
    }
    public static function scopeD_justicia($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','entrevista_colectiva.id_entrevista_colectiva','=','fp6.id_entrevista')
                ->where('fp6.id_subserie','=',config('expedientes.co'))
                ->where('fp6.d_justicia',$criterio);
        }
    }
    public static function scopeAhora_entiendo($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp7','entrevista_colectiva.id_entrevista_colectiva','=','fp7.id_entrevista')
                ->where('fp7.id_subserie','=',config('expedientes.co'))
                ->where('fp7.ahora_entiendo','ilike',"%$criterio%");
        }
    }
    public static function scopeCambio_perspectiva($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp8','entrevista_colectiva.id_entrevista_colectiva','=','fp8.id_entrevista')
                ->where('fp8.id_subserie','=',config('expedientes.co'))
                ->where('fp8.cambio_perspectiva','ilike',"%$criterio%");
        }
    }
    //Buscadora
    public static function scopeD_hecho_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','entrevista_colectiva.id_entrevista_colectiva','=','fp3.id_entrevista')
                ->where('fp3.id_subserie','=',config('expedientes.co'))
                ->where('fp3.d_hecho','>=',$criterio);
        }
    }
    public static function scopeD_impacto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','entrevista_colectiva.id_entrevista_colectiva','=','fp4.id_entrevista')
                ->where('fp4.id_subserie','=',config('expedientes.co'))
                ->where('fp4.d_impacto','>=',$criterio);
        }
    }
    public static function scopeD_contexto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','entrevista_colectiva.id_entrevista_colectiva','=','fp5.id_entrevista')
                ->where('fp5.id_subserie','=',config('expedientes.co'))
                ->where('fp5.d_contexto','>=',$criterio);
        }
    }
    public static function scopeD_justicia_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','entrevista_colectiva.id_entrevista_colectiva','=','fp6.id_entrevista')
                ->where('fp6.id_subserie','=',config('expedientes.co'))
                ->where('fp6.d_justicia','>=',$criterio);
        }
    }
    //Buscar en tesauro.  Recibe id_geo
    public function scopeTesauro($query, $criterio=-1) {
        $id_subserie = config('expedientes.co');
        if($criterio > 0) {
            $contenidos = tesauro::find($criterio)->arreglo_incluidos();
            $universo =  etiqueta_entrevista::where('id_subserie',$id_subserie)
                ->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                ->wherein('ft.id_geo',$contenidos)
                ->distinct()
                ->pluck('id_entrevista');
            $query->wherein('entrevista_colectiva.id_entrevista_colectiva',$universo);
        }
    }

    //Busqueda de full text search
    public static function scopeFTS($query,$criterio="")  {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank, entrevista_colectiva.id_entrevista_colectiva"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
            //$query->orderby('rank');
            //$query->orderby('entrevista_codigo');
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

    public static function scopeMarca($query, $criterio=0) {
        if(!is_array($criterio)) {
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(count($criterio)>0) {
            $id_entrevistador = \Auth::check() ? \Auth::user()->id_entrevistador : 0;
            $query->join('esclarecimiento.marca_entrevista as filtro_marca','entrevista_colectiva.id_entrevista_colectiva','=','filtro_marca.id_entrevista')
                ->where('filtro_marca.id_subserie','=',config('expedientes.co'))
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
            ->id_grupo($criterios->id_grupo)
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
            //Busqueda rapida
            ->br($criterios->br)
            ->id_cerrado($criterios->id_cerrado)
            //Scopes especificos
            ->id_sector($criterios->id_sector)
            ->tema_del($criterios->tema_del)
            ->tema_al($criterios->tema_al)
            ->tema_lugar($criterios->tema_lugar)
            ->tema_objetivo($criterios->tema_objetivo)
            ->tema_descripcion($criterios->tema_descripcion)
            ->id_activo($criterios->id_activo) //Soft delete
            ->transcrita($criterios->transcrita)
            ->etiquetada($criterios->etiquetada)
            ->marca($criterios->marca)
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
    public function getTieneEtiquetadoAttribute() { //Tiene etiquetado
        //return $this->verificar_adjunto(25) > 0 ? 1 : 0;
        return strlen($this->json_etiquetado)>0;
    }
    public function getTieneTranscripcionAttribute() {
        return strlen($this->html_transcripcion)>0;
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
        $opciones= self::filtrar($filtros)->join('esclarecimiento.entrevista_colectiva_dinamica','entrevista_colectiva.id_entrevista_colectiva','=','entrevista_colectiva_dinamica.id_entrevista_colectiva')
            ->where('dinamica','ilike',"%$criterio%")->distinct()->limit(30)->orderby('dinamica')->pluck('dinamica')->toArray();
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
            $adjuntado = new entrevista_colectiva_adjunto();
            $adjuntado->id_entrevista_colectiva = $this->id_entrevista_colectiva;
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
        $existe = prioridad::where('id_entrevista',$this->id_entrevista_colectiva)->where('id_subserie',config('expedientes.co'))
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
            $filtros = entrevista_colectiva::filtros_default();
        }
        //Estado de entrevista
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_colectiva.entrevista_avance','=','cat_item.id_item')
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
        $avance->descarga="co_avance";
        $avance->grafica=graficador::g_pie($avance);


        //Sector
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','entrevista_colectiva.id_sector','=','cat_item.id_item')
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
        $sector->descarga="co_sector";
        $sector->grafica=graficador::g_columna($sector);

        //Cantidad de participantes
        $query=self::filtrar($filtros)
            ->select(\DB::raw("entrevista_colectiva.cantidad_participantes as id_item, entrevista_colectiva.cantidad_participantes as txt, count(1) as conteo"))
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
        $cantidad->descarga="co_cantidad_entrevistados";
        $cantidad->grafica=graficador::g_columna($cantidad);





        $respuesta = new \stdClass();
        $respuesta->avance = $avance;
        $respuesta->sector = $sector;
        $respuesta->cantidad = $cantidad;



        return $respuesta;



    }

    //Para convertir el tesauro en nube de etiquetas
    public function etiquetas_a_texto() {
        $listado = entrevista_individual::listado_etiquetas(config('expedientes.co'), $this->id_entrevista_colectiva);
        return implode(" ",$listado);
    }

    public static function revisar_codigo() {
        $listado = self::orderby('id_entrevista_colectiva')->get();
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

            }
        }
        $res['corregidas']=$conteo;
        $res['errores']=$errores;
        return $res;

    }

    //Para Lili: cambiar una entrevista a otro usuario
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


    //Trasladar a EE
    public function trasladar_ee() {
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
        $nueva->equipo_facilitador = $this->equipo_facilitador;
        $nueva->equipo_memorista = $this->equipo_memorista;
        $nueva->equipo_otros = $this->equipo_otros;
        $nueva->tema_descripcion = $this->tema_descripcion;
        $nueva->tema_objetivo = $this->tema_objetivo;
        $nueva->tema_del = substr($this->tema_del,0,10);
        $nueva->tema_al = substr($this->tema_al, 0, 10);
        $nueva->tema_lugar = $this->tema_lugar;
        $nueva->cantidad_participantes = $this->cantidad_participantes;
        $nueva->eventos_descripcion = $this->eventos_descripcion;




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
        //Tipo de entrevista etnica
        $tipo = cat_item::where('id_cat',90)->where('descripcion','ilike','inter%')->first();
        $nueva->id_tipo_entrevista = $tipo->id_item;

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
            $enlace->id_subserie = config('expedientes.co');
            $enlace->id_primaria = $this->id_entrevista_colectiva;
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
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>34, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$this->id_entrevista_colectiva, 'referencia'=>"Traslado a $nueva->entrevista_codigo"]);
            traza_actividad::create(['id_objeto'=>14, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_entrevista_etnica, 'referencia'=>"Traslado desde $this->entrevista_codigo"]);
            //Devolver id_entrevista_profundidad

            return $nueva;
        }
        catch(\Exception $e) {
            Log::error('Problemas al trasladar CO a EE'.PHP_EOL.$e->getMessage());
            return false;
        }
    }

    //Consentimientos informados
    public function rel_consentimiento() {
        return $this->hasMany(entrevista::class,'id_entrevista_colectiva','id_entrevista_colectiva')
            ->orderby('asistencia','desc')
            ->orderby('consentimiento_correlativo')
            ->orderby('consentimiento_apellidos')
            ->orderby('consentimiento_nombres')
            ->where('borrable','<>',1);
    }
}
