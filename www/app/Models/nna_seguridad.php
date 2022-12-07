<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class nna_seguridad
 * @package App\Models
 * @version July 9, 2019, 11:08 pm -05
 *
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property \App\Models\Catalogos.cev idMacroterritorio
 * @property \App\Models\Catalogos.cev idTerritorio
 * @property \App\Models\Catalogos.catItem idQuienRefiere
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_nna_vulnerabilidad
 * @property integer id_entrevistador
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property integer correlativo
 * @property string codigo
 * @property integer dictamen
 * @property string|\Carbon\Carbon fecha_evaluacion
 * @property integer id_quien_refiere
 * @property string id_quien_refiere_otro
 * @property integer revisar_proceso
 * @property integer firma_consentimiento
 * @property integer existe_entidad
 * @property integer lugar_privado
 * @property integer alguien_acompana
 * @property integer alguien_acompana_padre
 * @property integer alguien_acompana_ts
 * @property integer alguien_acompana_otro
 * @property integer apoyo_identificado
 * @property integer informado_presencia
 * @property integer informado_cev
 * @property integer entrevista_cierre
 * @property string entrevista_cierre_porque
 * @property integer entrevista_seguimiento
 * @property string observaciones
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class nna_seguridad extends Model
{

    public $table = 'esclarecimiento.nna_seguridad';

    protected $primaryKey = 'id_nna_seguridad';

    public $timestamps = true;

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['dictamen']=2;
        $this->attributes['fecha_evaluacion']=date("Y-m-d");
        $this->attributes['revisar_proceso']=2;
        $this->attributes['firma_consentimiento']=2;
        $this->attributes['existe_entidad']=2;
        $this->attributes['lugar_privado']=2;
        $this->attributes['alguien_acompana']=2;
        $this->attributes['alguien_acompana_padre']=2;
        $this->attributes['alguien_acompana_ts']=2;
        $this->attributes['alguien_acompana_otro']=2;
        $this->attributes['apoyo_identificado']=2;
        $this->attributes['informado_presencia']=2;
        $this->attributes['informado_cev']=2;
        $this->attributes['entrevista_cierre']=2;
        $this->attributes['entrevista_seguimiento']=2;
        if(\Auth::check()) {
            $this->attributes['id_territorio']=\Auth::user()->id_territorio;
        }
    }



    public $fillable = [
        'id_nna_vulnerabilidad',
        'id_entrevistador',
        'id_macroterritorio',
        'id_territorio',
        'correlativo',
        'codigo',
        'dictamen',
        'fecha_evaluacion',
        'id_quien_refiere',
        'id_quien_refiere_otro',
        'revisar_proceso',
        'firma_consentimiento',
        'existe_entidad',
        'lugar_privado',
        'alguien_acompana',
        'alguien_acompana_padre',
        'alguien_acompana_ts',
        'alguien_acompana_otro',
        'apoyo_identificado',
        'informado_presencia',
        'informado_cev',
        'entrevista_cierre',
        'entrevista_cierre_porque',
        'entrevista_seguimiento',
        'observaciones',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_nna_seguridad' => 'integer',
        'id_nna_vulnerabilidad' => 'integer',
        'id_entrevistador' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_territorio' => 'integer',
        'correlativo' => 'integer',
        'codigo' => 'string',
        'dictamen' => 'integer',
        'fecha_evaluacion' => 'datetime',
        'id_quien_refiere' => 'integer',
        'id_quien_refiere_otro' => 'string',
        'revisar_proceso' => 'integer',
        'firma_consentimiento' => 'integer',
        'existe_entidad' => 'integer',
        'lugar_privado' => 'integer',
        'alguien_acompana' => 'integer',
        'alguien_acompana_padre' => 'integer',
        'alguien_acompana_ts' => 'integer',
        'alguien_acompana_otro' => 'integer',
        'apoyo_identificado' => 'integer',
        'informado_presencia' => 'integer',
        'entrevista_cierre' => 'integer',
        'entrevista_cierre_porque' => 'string',
        'entrevista_seguimiento' => 'integer',
        'observaciones' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function rel_id_nna_vulnerabilidad() {
        return $this->belongsTo(nna_vulnerabiliad::class, 'id_nna_vulnerabilidad','id_nna_vulnerabilidad');
    }
    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador','id_entrevistador');
    }
    public function rel_id_macroterritorio() {
        return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
    }
    public function rel_id_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }
    public function rel_id_quien_refiere() {
        return $this->belongsTo(cat_item::class,'id_quien_refiere','id_item');
    }
    public function rel_info() {
        return $this->hasMany(nna_seguridad_info::class,'id_nna_seguridad','id_nna_seguridad');
    }

    //Getters
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
    public function getFmtNumeroNNAAttribute() {
        $item = $this->rel_id_nna_vulnerabilidad;
        return $item->correlativo;
    }
    public function getFmtFechaEvaluacionAttribute() {
        if(empty($this->fecha_evaluacion)) {
            return "Sin especificar";
        }
        try {
            $fecha= new Carbon($this->fecha_evaluacion);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtIdQuienRefiereAttribute() {
        $item = $this->rel_id_quien_refiere;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido";
        }
    }
    public function getFmtRevisarProcesoAttribute() {
        return $this->revisar_proceso == 1 ? "Sí" : "No";
    }
    public function getFmtFirmaConsentimientoAttribute() {
        return $this->firma_consentimiento == 1 ? "Sí" : "No";
    }
    public function getFmtExisteEntidadAttribute() {
        return $this->existe_entidad == 1 ? "Sí" : "No";
    }
    public function getFmtLugarPrivadoAttribute() {
        return $this->lugar_privado == 1 ? "Sí" : "No";
    }
    public function getFmtAlguienAcompanaAttribute() {
        return $this->alguien_acompana == 1 ? "Sí" : "No";
    }
    public function getFmtAlguienAcompanaPadreAttribute() {
        return $this->alguien_acompana_padre == 1 ? "Sí" : "No";
    }
    public function getFmtAlguienAcompanaTsAttribute() {
        return $this->alguien_acompana_ts == 1 ? "Sí" : "No";
    }
    public function getFmtAlguienAcompanaOtroAttribute() {
        return $this->alguien_acompana_otro == 1 ? "Sí" : "No";
    }
    public function getFmtApoyoIdentificadoAttribute() {
        return $this->apoyo_identificado == 1 ? "Sí" : "No";
    }
    public function getFmtInformadoPresenciaAttribute() {
        return $this->informado_presencia == 1 ? "Sí" : "No";
    }
    public function getFmtInformadoCevAttribute() {
        return $this->informado_cev == 1 ? "Sí" : "No";
    }
    public function getFmtEntrevistaCierreAttribute() {
        return $this->entrevista_cierre == 1 ? "Sí" : "No";
    }
    public function getFmtEntrevistaSeguimientoAttribute() {
        return $this->entrevista_seguimiento == 1 ? "Sí" : "No";
    }
    public function getFmtDictamenCortoAttribute() {
        return $this->dictamen == 1 ? "Positivo" : "Negativo";
    }
    public function getFmtDictamenAttribute() {
        return $this->dictamen == 1 ? "Se recomienda proceder con la toma del testimonio" : "Es necesaria una mayor revisión antes de la toma del testimonio.  ";
    }
    public function getFmtCodigoVulnerabilidadAttribute() {
        $item=$this->rel_id_nna_vulnerabilidad;
        if($item) {
            return $item->codigo;
        }
        else {
            return "Desconocido";
        }
    }
    //Informacion brindada
    public function getFmtInfoAttribute() {

        $arreglo=$this->arreglo_info();
        //dd($arreglo);
        $txt=implode("<li>",$arreglo);
        $txt="<ul><li>$txt</li></ul>";
        return $txt;
    }

    //Para la edición de select multiple
    public function getArregloInfoAttribute() {
        $arreglo=array();
        foreach($this->rel_info as $item) {
            $arreglo[]=$item->id_info;
        }
        return $arreglo;
    }


    //Setters
    public function setFechaEvaluacionAttribute($val) {
        if(strlen($val)==10) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
                $this->attributes['fecha_evaluacion']=$fecha;
            }
            catch (\Exception $e) {
                $this->attributes['fecha_evaluacion']=null;
            }
        }
    }

    //Lógica interna del modelo
    public function arreglo_info() {
        $arreglo=array();
        foreach($this->rel_info as $item) {
            $arreglo[$item->id_info] = $item->fmt_id_info;
        }
        return $arreglo;
    }
    //Funcion que encapsulta la calculada del codigo
    public function asignar_codigo() {
        $correlativo=$this->siguiente_correlativo();
        $this->correlativo =$correlativo;
        $corr = str_pad($correlativo,5,"0",STR_PAD_LEFT);
        $txt = $this->prefijo_codigo();
        $codigo = $txt.$corr;
        $this->codigo = $codigo;
        return $codigo;
    }
    //Calcula el correlativo general que se asigna a cada entrevista, según su subserie
    public function siguiente_correlativo() {
        $id_subserie=config('expedientes.nes');
        $cual = correlativo::cual_toca($id_subserie);
        return $cual;
    }

    public function prefijo_codigo() {
        $id_subserie=config('expedientes.nes');
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

    //Determina si procede o no
    public function calcular_dictamen() {
        $dictamen=1;  //Sí
        //No vive en familia
        if($this->revisar_proceso==2) {
            $dictamen=2;
        }
        //No asiste a la escuela
        if($this->firma_consentimiento==2) {
            $dictamen=2;
        }
        //Problemas en la escuela
        if($this->existe_entidad==2) {
            $dictamen=2;
        }
        //Problemas de progreso en la escuela
        if($this->lugar_privado==2) {
            $dictamen=2;
        }
        //Ha estado expuesto
        if($this->alguien_acompana==2) {
            $dictamen=2;
        }
        //La comunidad no tiene conocimiento C.V.
        if($this->apoyo_identificado==2) {
            $dictamen=2;
        }
        //No se han realizado reuniones en la comunidad
        if($this->informado_presencia==2) {
            $dictamen=2;
        }
        //La comunidad no está dispuesta a apoyar
        if($this->informado_cev==2) {
            $dictamen=2;
        }
        return $dictamen;
    }

    //Filtros
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->codigo = null;
        $filtro->correlativo = null;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->id_entrevistador = -1;
        $filtro->dictamen = -1;
        $filtro->observaciones = null;

        //Determinar si es macro o territorio
        if(isset($request->id_territorio)) {
            if($request->id_territorio>0) {
                $filtro->id_territorio=$request->id_territorio;
                $filtro->id_macroterritorio=$request->id_territorio_macro;
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


        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;
        $filtro->dictamen = isset($request->dictamen) ? $request->dictamen : $filtro->dictamen;
        $filtro->codigo = isset($request->codigo) ? $request->codigo : $filtro->codigo;
        $filtro->correlativo = isset($request->correlativo) ? $request->correlativo : $filtro->correlativo;
        $filtro->observaciones = isset($request->observaciones) ? $request->observaciones : $filtro->observaciones;



        //dd($filtro);

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
        $query->orderby('nna_seguridad.codigo');
    }
    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        //dd($criterios);
        $query->codigo($criterios->codigo)
            ->correlativo($criterios->correlativo)
            ->id_macroterritorio($criterios->id_macroterritorio)
            ->id_territorio($criterios->id_territorio)
            ->id_entrevistador($criterios->id_entrevistador)
            ->dictamen($criterios->dictamen)
            ->observaciones($criterios->observaciones);
        if(\Gate::denies('permisos-legado')) {
            $query->permisos();
        }
    }
    //De acuerdo al perfil, aplica los permisos
    public static function scopePermisos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('nna_seguridad.id_entrevistador',$arreglo_entrevistadores);
    }
    public static function scopeCodigo($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('codigo','ilike',"%$criterio%");
        }
    }
    public static function scopeCorrelativo($query,$criterio) {
        if($criterio>0) {
            $query->where('correlativo','=',$criterio);
        }
    }
    public static function scopeid_macroterritorio($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_macroterritorio',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_macroterritorio',$criterio);
            }
        }
    }
    public static function scopeid_territorio($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_territorio',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_territorio',$criterio);
            }
        }
    }


    public static function scopeId_entrevistador($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_entrevistador',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_entrevistador',$criterio);
            }
        }
    }

    public static function scopeDictamen($query,$criterio) {
        if($criterio>0) {
            $query->where('dictamen','=',$criterio);
        }
    }
    public static function scopeObservaciones($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('observaciones','ilike',"%$criterio%");
        }
    }



}
