<?php

namespace App\Models;

use App\graficador;
use Eloquent as Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Array_;

/**
 * Class casos_informes
 * @package App\Models
 * @version May 13, 2019, 2:38 pm -05
 *
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection catalogos.catItems
 * @property integer correlativo
 * @property integer id_casos_informes
 * @property string codigo
 * @property integer id_entrevistador
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property string|\Carbon\Carbon registro_fecha
 * @property string|\Carbon\Carbon recepcion_fecha
 * @property string titulo
 * @property string autor
 * @property integer autor_id_tipo_organizacion
 * @property string descripcion
 * @property integer id_tipo_soporte
 * @property string contenido_texto
 * @property string contenido_audiovisual
 * @property string contenido_fotografia
 * @property string contenido_sonoro
 * @property string contenido_base_datos
 * @property string contenido_otros
 * @property string contenido_volumen
 * @property string remitente_nombre
 * @property string remitente_organizacion
 * @property integer remitente_id_tipo_organizacion
 * @property string remitente_correo
 * @property string remitente_telefono
 * @property string remitente_cedula
 * @property integer entrega_id_geo
 * @property string entrega_lugar
 * @property integer entrega_id_consentimiento
 * @property integer entrega_id_tratamiento
 * @property string receptor_nombre
 * @property integer receptor_id_area
 * @property string receptor_almacenaje
 * @property string receptor_anotaciones
 * @property string|\Carbon\Carbon caracterizacion_fecha_caracterizacion
 * @property integer caracterizacion_id_tipo
 * @property string|\Carbon\Carbon caracterizacion_fecha_elaboracion
 * @property string|\Carbon\Carbon caracterizacion_fecha_publicacion
 * @property string caracterizacion_temporalidad
 * @property string caracterizacion_cobertura
 * @property string caracterizacion_sectores
 * @property integer clasifica_nna
 * @property integer clasifica_sex
 * @property integer clasifica_res
 * @property integer clasifica_r2
 * @property integer clasifica_r1
 * @property integer clasifica_nivel
 * @property integer id_activo
 * @property integer cantidad_casos
 * @property date fh_insert
 * @property time fh_update
 */
class casos_informes extends Model
{

    public $table = 'esclarecimiento.casos_informes';
    protected $primaryKey = 'id_casos_informes';
    
    public $timestamps = false;



    public $fillable = [
        'correlativo',
        'codigo',
        'id_entrevistador',
        'id_macroterritorio',
        'id_territorio',
        'registro_fecha',
        'recepcion_fecha',
        'titulo',
        'autor',
        'autor_id_tipo_organizacion',
        'descripcion',
        'id_tipo_soporte',
        'contenido_texto',
        'contenido_audiovisual',
        'contenido_fotografia',
        'contenido_sonoro',
        'contenido_base_datos',
        'contenido_otros',
        'contenido_volumen',
        'remitente_nombre',
        'remitente_organizacion',
        'remitente_id_tipo_organizacion',
        'remitente_correo',
        'remitente_telefono',
        'remitente_cedula',
        'entrega_id_geo',
        'entrega_lugar',
        'entrega_id_consentimiento',
        'entrega_id_tratamiento',
        'receptor_nombre',
        'receptor_id_area',
        'receptor_almacenaje',
        'receptor_anotaciones',
        'caracterizacion_fecha_caracterizacion',
        'caracterizacion_id_tipo',
        'caracterizacion_fecha_elaboracion',
        'caracterizacion_fecha_publicacion',
        'caracterizacion_temporalidad',
        'caracterizacion_cobertura',
        'caracterizacion_sectores',
        'fh_insert',
        'fh_update',
        'clasifica_nna',
        'clasifica_sex',
        'clasifica_res',
        'clasifica_r2',
        'clasifica_r1',
        'clasifica_nivel',
        'cantidad_casos',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_casos_informes' => 'integer',
        'correlativo' => 'integer',
        'codigo' => 'string',
        'id_entrevistador' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_territorio' => 'integer',
        'registro_fecha' => 'datetime',
        'recepcion_fecha' => 'datetime',
        'titulo' => 'string',
        'autor' => 'string',
        'descripcion' => 'string',
        'id_tipo_soporte' => 'integer',
        'contenido_texto' => 'string',
        'contenido_audiovisual' => 'string',
        'contenido_fotografia' => 'string',
        'contenido_sonoro' => 'string',
        'contenido_base_datos' => 'string',
        'contenido_otros' => 'string',
        'contenido_volumen' => 'string',
        'remitente_nombre' => 'string',
        'remitente_organizacion' => 'string',
        'remitente_id_tipo_organizacion' => 'integer',
        'remitente_correo' => 'string',
        'remitente_telefono' => 'string',
        'remitente_cedula' => 'string',
        'entrega_id_geo' => 'integer',
        'entrega_lugar' => 'string',
        'entrega_id_consentimiento' => 'integer',
        'entrega_id_tratamiento' => 'integer',
        'receptor_nombre' => 'string',
        'receptor_id_area' => 'integer',
        'receptor_almacenaje' => 'string',
        'receptor_anotaciones' => 'string',
        'caracterizacion_fecha_caracterizacion' => 'datetime',
        'caracterizacion_id_tipo' => 'integer',
        'caracterizacion_fecha_elaboracion' => 'datetime',
        'caracterizacion_fecha_publicacion' => 'datetime',
        'caracterizacion_temporalidad' => 'string',
        'caracterizacion_cobertura' => 'string',
        'caracterizacion_sectores' => 'string',
        'fh_insert' => 'datetime',
        'fh_update' => 'datetime',
        'clasifica_nna' => 'integer',
        'clasifica_sex' => 'integer',
        'clasifica_res' => 'integer',
        'clasifica_r2' => 'integer',
        'clasifica_r1' => 'integer',
        'clasifica_nivel' => 'integer',
        'cantidad_casos' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [


        'recepcion_fecha_submit' => 'required',
        'titulo' => 'required',
        'autor' => 'required',
        'descripcion' => 'required',
        'remitente_nombre' => 'required',
        'entrega_id_geo' => 'required',

        'entrega_id_consentimiento' => 'required',
        'entrega_id_tratamiento' => 'required',
        'receptor_nombre' => 'required',
        'receptor_almacenaje' => 'required',

    ];

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['cantidad_casos']=1;
    }

    //Relaciones
   public function rel_id_entrevistador() {
       return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
   }
   public function rel_dinamica() {
       return casos_informes_adjunto::where('id_adjunto',-1)->get();
   }
   //Detalle de cobertura geográfica
   public function rel_casos_informes_geo() {
        return $this->hasMany(casos_informes_geo::class,'id_casos_informes','id_casos_informes');
   }
   //Detalle de sectores_incluye (actores armados, poblaciones, ocupaciones)
    public function rel_sectores() {
        return $this->hasMany(casos_informes_sectores::class,'id_casos_informes','id_casos_informes' );
    }

   public function rel_id_macroterritorio() {
       return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
   }
    public function rel_id_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }
    public function rel_id_tipo_soporte() {
        return $this->belongsTo(cat_item::class,'id_tipo_soporte','id_item');
    }
    public function rel_remitente_id_tipo_organizacion() {
        return $this->belongsTo(cat_item::class,'remitente_id_tipo_organizacion','id_item');
    }
    public function rel_autor_id_tipo_organizacion() {
        return $this->belongsTo(cat_item::class,'autor_id_tipo_organizacion','id_item');
    }
    public function rel_entrega_id_geo() {
        return $this->belongsTo(geo::class,'entrega_id_geo','id_geo');
    }
    public function rel_receptor_id_area() {
        return $this->belongsTo(cat_item::class,'receptor_id_area','id_item');
    }
    public function rel_caracterizacion_id_tipo() {
        return $this->belongsTo(cat_item::class,'caracterizacion_id_tipo','id_item');
    }
    public function rel_intereses() {
       return $this->hasMany(casos_informes_interes::class,'id_casos_informes','id_casos_informes');
    }

    public function rel_mandato() {
        return $this->hasMany(casos_informes_mandato::class,'id_casos_informes','id_casos_informes');
    }

    //Permisos si fuera reservado-3
    public function rel_acceso_reservado() {
        return $this->hasMany(reservado_acceso::class,'id_primaria',$this->primaryKey)->where('reservado_acceso.id_subserie',config('expedientes.ci'))->where('id_activo',1);
    }
    //ARchivos adjuntos
    public function rel_adjunto() {
        return $this->hasMany(casos_informes_adjunto::class,'id_casos_informes','id_casos_informes');
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
    public function puede_acceder($id_entrevistador=0) {
       return entrevista_individual::revisar_acceso_adjuntos($this);
       if($this->clasifica_nivel > 3) {
           return true;
       }

        if($id_entrevistador == 0) {
            if(\Auth::check()) {
                $id_entrevistador=\Auth::user()->id_entrevistador;
            }
            else {
                return false;
            }
        }

        $existe = $this->rel_acceso_reservado()->where('id_autorizado',$id_entrevistador)->first();
        if($existe) {
            return $existe->id_autorizador;
        }
        else {
            return false;
        }
    }

    //Mutators
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
    public function getFmtIdTipoSoporteAttribute() {
        $item = $this->rel_id_tipo_soporte;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido ($this->id_tipo_soporte)";
        }
    }
    public function getFmtRemitenteIdTipoOrganizacionAttribute() {
        $item = $this->rel_remitente_id_tipo_organizacion;

        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido ($this->remitente_id_tipo_organizacion)";
        }
    }

    public function getFmtReceptorIdAreaAttribute() {
        $item = $this->rel_receptor_id_area;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido ($this->receptor_id_area)";
        }
    }
    public function getFmtCaracterizacionIdTipoAttribute() {
        $item = $this->rel_caracterizacion_id_tipo;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido ($this->caracterizacion_id_tipo)";
        }
    }
    public function getFmtIdTerritorioAttribute() {
        return cev::nombre_completo($this->id_territorio);
    }
    //FEchas
    public function getFmtRegistroFechaAttribute() {
       if(empty($this->registro_fecha)) {
           return "Sin especificar";
       }
        try {
            $fecha= new Carbon($this->registro_fecha);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtRecepcionFechaAttribute() {
        if(empty($this->recepcion_fecha)) {
            return "Sin especificar";
        }
        try {
            $fecha= new Carbon($this->recepcion_fecha);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtCaracterizacionFechaCaracterizacionAttribute() {
        if(empty($this->caracterizacion_fecha_caracterizacion)) {
            return "Sin especificar";
        }
        try {
            $fecha= new Carbon($this->caracterizacion_fecha_caracterizacion);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtCaracterizacionFechaElaboracionAttribute() {
        if(empty($this->caracterizacion_fecha_elaboracion)) {
            return "Sin especificar";
        }
        try {
            $fecha= new Carbon($this->caracterizacion_fecha_elaboracion);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtCaracterizacionFechaPublicacionAttribute() {
        if(empty($this->caracterizacion_fecha_publicacion)) {
            return "Sin especificar";
        }
        try {
            $fecha= new Carbon($this->caracterizacion_fecha_publicacion);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtEntregaIdGeoAttribute() {
        return geo::nombre_completo($this->entrega_id_geo);
    }
    public function getFmtEntregaIdConsentimientoAttribute() {
       return $this->entrega_id_consentimiento==1 ? "Sí" : "No";
    }
    public function getFmtEntregaIdTratamientoAttribute() {
        return $this->entrega_id_tratamiento==1 ? "Sí" : "No";
    }
    //Clasificacion
    public function getFmtClasificaNnaAttribute() {
        return $this->clasifica_nna == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaSexAttribute() {
        return $this->clasifica_sex == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaResAttribute() {
        return $this->clasifica_res == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaR2Attribute() {
        return $this->clasifica_r2 == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    // Campo nuevo (25/may/22)
    public function getFmtAutorIdTipoOrganizacionAttribute() {
        if(is_null($this->autor_id_tipo_organizacion)) {
            return "Sin especificar";
        }

        $item = $this->rel_autor_id_tipo_organizacion;

        if($item) {
            return $item->descripcion;
        }
        else {

            return "Desconocido ($this->autor_id_tipo_organizacion)";
        }
    }
    //Remiendo
    public function getClasificacionNivelAttribute() {
        return $this->clasifica_nivel;
    }
    public function getClasificacionNnaAttribute() {
        return $this->clasifica_nna;
    }
    public function getClasificacionSexAttribute() {
        return $this->clasifica_sex;
    }
    public function getClasificacionResAttribute() {
        return $this->clasifica_res;
    }
    public function getClasificacionR1Attribute() {
        return $this->clasifica_r1;
    }
    public function getClasificacionR2Attribute() {
        return $this->clasifica_r2;
    }
    public function getEntrevistaCorrelativoAttribute() {
        return $this->correlativo;
    }
    //Fin del remiendo


    // Detalle de intereses
    public function getFmtInteresesAttribute() {
        $arreglo=$this->arreglo_intereses();
        //dd($arreglo);
        $txt=implode("<li>",$arreglo);
        $txt="<ul><li>$txt</li></ul>";
        return $txt;
    }
    //Para la edición de select multiple
    public function getArregloInteresesAttribute() {
        $arreglo=array();
        foreach($this->rel_intereses as $item) {
            $arreglo[]=$item->id_interes;
        }
        return $arreglo;
    }
    public function getArregloMandatoAttribute() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[]=$item->id_mandato;
        }
        return $arreglo;
    }
    //
    public function arreglo_intereses() {
       $arreglo=array();
       foreach($this->rel_intereses as $item) {
           $arreglo[$item->id_interes] = $item->fmt_id_interes;
       }
       return $arreglo;
    }
    // Para la edición de los campos de poblaciones, actores armados,oficios
    public function arreglo_sectores($id_cat=0) {
        $listado = casos_informes_sectores::join('catalogos.cat_item','casos_informes_sectores.id_item','cat_item.id_item')
                                ->where('id_casos_informes',$this->id_casos_informes)
                                ->where('cat_item.id_cat',$id_cat)
                                ->pluck('cat_item.descripcion','cat_item.id_item');
        $arreglo=$listado->toArray();
        return $arreglo;
    }
    public function arreglo_mandato() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[$item->id_mandato] = $item->fmt_id_mandato;
        }
        return $arreglo;
    }
    //Para las fechas
    public function setRegistroFechaAttribute($val) {
       if(strlen($val)==10) {
           try {
               $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
               $this->attributes['registro_fecha']=$fecha;
           }
           catch (\Exception $e) {
               $this->attributes['registro_fecha']=null;
           }
       }
    }
    public function setRecepcionFechaAttribute($val) {
        if(strlen($val)==10) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
                $this->attributes['recepcion_fecha']=$fecha;
            }
            catch (\Exception $e) {
                $this->attributes['recepcion_fecha']=null;
            }
        }
    }
    public function setCaracterizacionFechaCaracterizacionAttribute($val) {
        if(strlen($val)==10) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
                $this->attributes['caracterizacion_fecha_caracterizacion']=$fecha;
            }
            catch (\Exception $e) {
                $this->attributes['caracterizacion_fecha_caracterizacion']=null;
            }
        }
    }
    public function setCaracterizacionFechaElaboracionAttribute($val) {
        if(strlen($val)==10) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
                $this->attributes['caracterizacion_fecha_elaboracion']=$fecha;
            }
            catch (\Exception $e) {
                $this->attributes['caracterizacion_fecha_elaboracion']=null;
            }
        }
    }
    public function setCaracterizacionFechaPublicacionAttribte($val) {
        if(strlen($val)==10) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
                $this->attributes['caracterizacion_fecha_publicacion']=$fecha;
            }
            catch (\Exception $e) {
                $this->attributes['caracterizacion_fecha_publicacion']=null;
            }
        }
    }
    ///
    /// Para no meterlo en el controlador: recibe el arreglo de intereses a insertar
    public function grabar_intereses($arreglo) {
       $this->rel_intereses()->delete();  //Eliminar lo anterior
       foreach($arreglo as $id) {
           try {
               casos_informes_interes::create(['id_casos_informes' => $this->id_casos_informes, 'id_interes' => $id]);
           }
            catch(\Exception $e) {
               Log::error("Violacion de llave unica en casos_informes_interes: id_casos_informes,id_interes: $this->id_casos_informes, $id");
            }
       }
    }
    /// Para no meterlo en el controlador: recibe el arreglo de intereses a insertar
    public function grabar_mandato($arreglo) {
        $this->rel_mandato()->delete();  //Eliminar lo anterior
        foreach($arreglo as $id) {
            try {
                casos_informes_mandato::create(['id_casos_informes' => $this->id_casos_informes, 'id_mandato' => $id]);
            }
            catch(\Exception $e) {
                Log::error("Violacion de llave unica en casos_informes_mandato: id_casos_informes,id_mandato: $this->id_casos_informes, $id");
            }
        }
    }

    // Lógica interna
    //Calcula el correlativo general que se asigna a cada entrevista, según su subserie
    public function siguiente_correlativo() {
       $this->id_subserie=config('expedientes.ci');

        $fila = correlativo::where('id_subserie',$this->id_subserie)->first();
        if(empty($fila)) {
            correlativo::create(['id_subserie'=>$this->id_subserie, 'correlativo'=>1]);
            return 1;
        }
        else {
            $fila->correlativo++;
            $fila->save();
            return $fila->correlativo;
        }
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

    public function prefijo_codigo() {
        $this->id_subserie=config('expedientes.ci');
        //Defaults, si no está autenticado (para pruebas)
        $txt="XX";
        $entrev="eee";
        $cual = cat_item::find($this->id_subserie);
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

    // Filtros
    //Para los filtros
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->codigo = null;
        $filtro->titulo = null;
        $filtro->autor = null;
        $filtro->descripcion = null;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;

        $filtro->remitente_organizacion = null;
        $filtro->remitente_id_tipo_organizacion = -1;

        $filtro->id_entrevistador = -1;
        $filtro->receptor_nombre=null;
        $filtro->receptor_id_area=-1;

        $filtro->caracterizacion_id_tipo = -1;

        $filtro->interes = -1;
        $filtro->mandato = -1;

        $filtro->br="";

        $filtro->id_activo=1; //Soft delete





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
        $filtro->codigo = isset($request->codigo) ? $request->codigo : $filtro->codigo;
        $filtro->titulo = isset($request->titulo) ? $request->titulo : $filtro->titulo;
        $filtro->autor = isset($request->autor) ? $request->autor : $filtro->autor;
        $filtro->descripcion = isset($request->descripcion) ? $request->descripcion : $filtro->descripcion;
        $filtro->remitente_organizacion = isset($request->remitente_organizacion) ? $request->remitente_organizacion : $filtro->remitente_organizacion;
        $filtro->remitente_id_tipo_organizacion = isset($request->remitente_id_tipo_organizacion) ? $request->remitente_id_tipo_organizacion : $filtro->remitente_id_tipo_organizacion;
        $filtro->receptor_nombre = isset($request->receptor_nombre) ? $request->receptor_nombre : $filtro->receptor_nombre;
        $filtro->receptor_id_area = isset($request->receptor_id_area) ? $request->receptor_id_area : $filtro->receptor_id_area;
        $filtro->caracterizacion_id_tipo = isset($request->caracterizacion_id_tipo) ? $request->caracterizacion_id_tipo : $filtro->caracterizacion_id_tipo;
        $filtro->interes = isset($request->interes) ? $request->interes : $filtro->interes;
        $filtro->mandato = isset($request->mandato) ? $request->mandato : $filtro->mandato;
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;
        $filtro->id_activo = isset($request->id_activo) ? $request->id_activo : $filtro->id_activo;


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

    //Busqueda rapida
    public static function scopeBR($query,$criterio="") {
        $criterio=trim($criterio);
        if(is_numeric($criterio) and intval($criterio)>0) {
            $query->where('casos_informes.correlativo',$criterio);
        }
        elseif(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $where[]="casos_informes.titulo ilike '%$criterio%'";
            $where[]="casos_informes.codigo ilike '%$criterio%'";
            $where[]="casos_informes.autor ilike '%$criterio%'";
            $where[]="casos_informes.descripcion ilike '%$criterio%'";
            //$where[]="dinamica ilike '%$criterio%'";
            $str_where=implode(" or ",$where);
            //$query->join('esclarecimiento.e_ind_fvt_dinamica as fd','e_ind_fvt.id_e_ind_fvt','=','fd.id_e_ind_fvt')
            //       ->whereraw("( $str_where )");
            $query->whereraw(" ( $str_where )");

        }
    }

    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('casos_informes.codigo');
    }
    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        //dd($criterios);
        $query->codigo($criterios->codigo)
                ->titulo($criterios->titulo)
                ->autor($criterios->autor)
                ->descripcion($criterios->descripcion)
                ->remitente_organizacion($criterios->remitente_organizacion)
                ->remitente_id_tipo_organizacion($criterios->remitente_id_tipo_organizacion)
                ->id_territorio($criterios->id_territorio)
                ->id_macroterritorio($criterios->id_macroterritorio)
                ->receptor_nombre($criterios->receptor_nombre)
                ->receptor_id_area($criterios->receptor_id_area)
                ->id_entrevistador($criterios->id_entrevistador)
                ->caracterizacion_id_tipo($criterios->caracterizacion_id_tipo)
                ->interes($criterios->interes)
                ->mandato($criterios->mandato)
                ->id_activo($criterios->id_activo)
                ->br($criterios->br);
                //->permisos() ;

    }
    //De acuerdo al perfil, aplica los permisos
    public static function scopePermisos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso();
        $query->wherein('casos_informes.id_entrevistador',$arreglo_entrevistadores);
    }

    public static function scopeCodigo($query,$criterio) {
       $criterio=trim($criterio);
       if(strlen($criterio)>0) {
           $query->where('codigo','ilike',"%$criterio%");
       }
    }
    public static function scopeId_activo($query,$criterio) {

        if($criterio>0) {
            $query->where('id_activo',$criterio);
        }
    }
    public static function scopeTitulo($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('titulo','ilike',"%$criterio%");
        }
    }
    public static function scopeAutor($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('autor','ilike',"%$criterio%");
        }
    }
    public static function scopeDescripcion($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('descripcion','ilike',"%$criterio%");
        }
    }
    public static function scopeRemitente_Organizacion($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('remitente_organizacion','ilike',"%$criterio%");
        }
    }
    public static function scopeReceptor_Nombre($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('receptor_nombre','ilike',"%$criterio%");
        }
    }
    public static function scopeRemitente_id_tipo_organizacion($query,$criterio) {
       if(is_array($criterio)) {
           if(count($criterio)>0) {
               if(!in_array(-1,$criterio)) {
                   $query->wherein('remitente_id_tipo_organizacion',$criterio);
               }
           }
       }
       else {
           if($criterio > 0) {
               $query->where('remitente_id_tipo_organizacion',$criterio);
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
    public static function scopeReceptor_id_area($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('receptor_id_area',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('receptor_id_area',$criterio);
            }
        }
    }
    public static function scopeCaracterizacion_id_tipo($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('caracterizacion_id_tipo',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('caracterizacion_id_tipo',$criterio);
            }
        }
    }
    public static function scopeId_entrevistador($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('casos_informes.id_entrevistador',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('casos_informes.id_entrevistador',$criterio);
            }
        }
    }
    public static function scopeInteres($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->join('esclarecimiento.casos_informes_interes as fi','esclarecimiento.casos_informes.id_casos_informes','=','fi.id_casos_informes')
                        ->wherein('id_interes',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->join('esclarecimiento.casos_informes_interes as fi','esclarecimiento.casos_informes.id_casos_informes','=','fi.id_casos_informes')
                    ->where('id_interes',$criterio);
            }
        }
    }
    public static function scopeMandato($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->join('esclarecimiento.casos_informes_mandato as fm','esclarecimiento.casos_informes.id_casos_informes','=','fm.id_casos_informes')
                        ->wherein('id_mandato',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->join('esclarecimiento.casos_informes_mandato as fm','esclarecimiento.casos_informes.id_casos_informes','=','fm.id_casos_informes')
                    ->where('id_mandato',$criterio);
            }
        }
    }


    //Manejo de adjuntos
    public function getAdjuntosAttribute() {
        return casos_informes_adjunto::listado_adjuntos($this->id_casos_informes);
    }


    //Determina el nivel de clasificacion del expediente
    public function clasificar_acceso() {
        $nivel=4;
        if($this->clasifica_nna==1) {
            $nivel=3;
        }
        if($this->clasifica_res==1) {
            $nivel=3;
        }
        if($this->clasifica_sex==1) {
            $nivel=3;
        }
        if($this->clasifica_r2 == 1) {
            $nivel =2;
        }

        if($this->clasifica_r1==1) {
            $nivel=1;
        }
        $this->clasifica_nivel=$nivel;
        return $nivel;
    }
    //Para unificar la tabla de desclasificacion con las entrevistas
    public function getEntrevistaCodigoAttribute() {
       return $this->codigo;
    }

    /*
     * SEGURIDAD
     */
    // Para evaluar el acceso a adjuntos  (r3 y r2)
    public function puede_acceder_adjuntos() {
        return   entrevista_individual::revisar_acceso_adjuntos($this);
    }
    //Aceso a la entrevista
    //Funcion para el controller, me permite determinar si se puede acceder o no a la entrevista en sí (usado en show y edit)
    public function getPuedeAccederEntrevistaAttribute() {
        //return entrevista_individual::revisar_acceso_a_entrevista($this);
        return true;  //Siempre se puede acceder a un caso o infore
    }



    public function puede_modificar_entrevista($id_entrevistador = 0) {
        return entrevista_individual::revisar_modificar_entrevista($this);
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


        return in_array($this->id_casos_informes,$asignaciones);
    }

    //Para el scope de permisos
    public static function arreglo_asignaciones($id_subserie=0,$llave_primaria="") {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        $id_subserie = $id_subserie > 0 ? $id_subserie : config("expedientes.ci");
        $llave_primaria = strlen($llave_primaria) > 0 ? $llave_primaria : 'id_casos_informes';
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



    //Información para el dashboard principal
    public static function datos_dash($filtros=null) {
        if(!is_object($filtros)) {
            $filtros = casos_informes::filtros_default();
        }
        //Tipo de organización que remite
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','casos_informes.remitente_id_tipo_organizacion','=','cat_item.id_item')
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

        $remitente = new \stdClass();
        $remitente->categorias = $categorias;
        $remitente->a_serie[] = $datos;
        $remitente->nombre_serie[]="Casos e informes";
        $remitente->descarga="ci_remitente";
        $remitente->grafica=graficador::g_barra($remitente);


        //Sector
        $query=self::filtrar($filtros)
            ->join('catalogos.cat_item','casos_informes.caracterizacion_id_tipo','=','cat_item.id_item')
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
        $tipo->descarga="ee_sector";
        $tipo->grafica=graficador::g_columna($tipo);


        $respuesta = new \stdClass();
        $respuesta->remitente = $remitente;
        $respuesta->tipo = $tipo;
        return $respuesta;



    }

    /*
     * GENERAR ESTRUCTURAS DE DATOS
     */
    public function generar_dublin() {
        //Estructura del dublin core
        $textos = array();  //Esta es el arreglo que rige la estructura
        $textos['identificador'] = 'Identificador';
        $textos['identificador_gd'] = 'Identificador Gestión Documental';
        $textos['fecha_registro'] = 'Fecha de registro';
        $textos['fecha_actualizacion'] = 'Fecha de actualización';
        $textos['documento_adjunto'] = 'Documento adjunto';
        //$textos['tipo_documento'] = 'Tipo de documento';
        $textos['nivel_descripcion'] = 'Nivel de descripción';
        $textos['area'] = 'Área';
        $textos['titulo'] = 'Título';
        $textos['titulo_alternativo'] = 'Título alternativo';
        $textos['autor'] = 'Autor';
        $textos['colaboradores'] = 'Colaboradores';
        $textos['custodio'] = 'Custodio';
        $textos['derechos'] = 'Derechos';
        $textos['nivel_acceso'] = 'Nivel de acceso interno';
        $textos['ubicacion'] = 'Ubicación';
        $textos['fecha_publicacion'] = 'Fecha de creación/publicación';
        $textos['fecha_publicacion_final'] = 'Fecha de creación/publicación final';
        $textos['descripcion'] = 'Descripción';
        $textos['temas'] = 'Temas';
        $textos['mandato'] = 'Mandato';
        $textos['objetivo'] = 'Objetivo';
        $textos['enfoque'] = 'Enfoque';
        $textos['tipo_violencia'] = 'Tipo de violencia';
        $textos['cobertura_espacial'] = 'Cobertura espacial';
        $textos['cobertura_temporal'] = 'Cobertura temporal';
        $textos['hitos'] = 'Hitos';
        $textos['aa'] = 'Actores armados';
        $textos['poblacion'] = 'Población';
        $textos['ocupaciones'] = 'Ocupaciones';
        $textos['idioma'] = 'Idioma/Lengua';
        $textos['derechos_uso'] = 'Autorización derechos de uso';
        $textos['codigo_hash'] = 'Código hash';
        $textos['formato'] = 'Formato';
        $textos['tamano'] = 'Tamaño';
        $textos['numero_paginas'] = 'Número de páginas';
        $textos['duracion'] = 'Duración';
        $textos['resolucion'] = 'Resolución';
        $textos['formato_compresion'] = 'Formato de compresión';
        $textos['asociar_recursos'] = 'Asociar con otros recursos';
        $textos['asociar_fondos'] = 'Asociar con otros fondos';
        $textos['notas_catalogacion'] = 'Notas de catalogación';
        $textos['usuario_carga'] = 'Usuario que carga el recurso';
        
        //Contenido: equivalencias internas específicas para Casos e informes
        $datos = [];
        $datos['identificador'] = $this->codigo;
        $datos['identificador_gd'] = 'Sin información';
        $datos['fecha_registro'] = optional($this->fh_insert)->format("Y-m-d");
        $datos['fecha_actualizacion'] = optional($this->fh_update)->format("Y-m-d");
        $adjuntos = array();
        foreach($this->rel_adjunto as $item) {
            $archivo = $item->rel_id_adjunto;
            if($archivo = $item->rel_id_adjunto) {
                $tmp['Documento adjunto'] = $archivo->nombre;
                $tmp['Tipo de documento'] = $item->fmt_id_tipo;
                $adjuntos[]=$tmp;
            }
        }
        $datos['documento_adjunto']=$adjuntos;

        $datos['nivel_descripcion'] = 'Sin información';
        $datos['area'] = 'Sin información';
        $datos['titulo'] = $this->titulo;
        $datos['titulo_alternativo'] = 'Sin información';
        $datos['autor'] = $this->autor;
        $datos['colaboradores'] = 'Sin información';
        $datos['custodio'] = $this->remitente_organizacion;
        $datos['derechos'] = 'Sin información';
        $datos['nivel_acceso'] = $this->clasifica_nivel;
        $datos['ubicacion'] = 'Sin información';
        $datos['fecha_publicacion'] = optional($this->caracterizacion_fecha_elaboracion)->format("Y-m-d");
        $datos['fecha_publicacion_final'] = 'No aplica';
        $descripcion = array();
        $descripcion['descripcion']=$this->descripcion;
        $descripcion['Medio en el que se entrega']=$this->fmt_id_tipo_soporte;
        if($this->contenido_texto) {
            $descripcion['Describir el contenido, si se trata de texto:']=$this->contenido_texto;
        }
        if($this->contenido_audiovisual) {
            $descripcion['Describir el contenido, si es audiovisual:']=$this->contenido_audiovisual;
        }
        if($this->contenido_fotografia) {
            $descripcion['Describir el contenido, si es fotográfico:']=$this->contenido_fotografia;
        }
        if($this->contenido_sonoro) {
            $descripcion['Describir el contenido, si es sonoro:']=$this->contenido_sonoro;
        }
        if($this->contenido_base_datos) {
            $descripcion['Describir el contenido, si es base de datos:']=$this->contenido_base_datos;
        }
        if($this->contenido_otros) {
            $descripcion['Describir el contenido, si fuera de otro tipo:']=$this->contenido_otros;
        }

        if($this->receptor_anotaciones) {
            $descripcion['Anotaciones de quien recibe:']=$this->receptor_anotaciones;
        }
        $datos['descripcion'] = $descripcion;
        //temas, enfoque, objetivo
        //Enfoque
        $lis_enfoque = cat_item::where('cat_item.otro','ilike','%enfoque%')
            ->orWhere('cat_item.otro','ilike','%genero%')
            ->orWhere('cat_item.otro','ilike','%curso_vida%')
            ->orWhere('cat_item.otro','ilike','%direccion_etnica%')
            ->pluck('id_item');

        //Objetivo
        $lis_objetivo = cat_item::where('cat_item.otro','ilike','%objetivo%')
            ->pluck('id_item');
        //Temas
        $lis_temas = cat_item::where('cat_item.otro','ilike','%nucleo_%')
            ->pluck('id_item');


        ////////////
        $temas = casos_informes_interes::join('catalogos.cat_item','id_interes','id_item')
            ->where('id_casos_informes',$this->id_casos_informes)
            ->wherein('id_item',$lis_temas)
            ->orderby('cat_item.descripcion')
            ->distinct()
            ->pluck('cat_item.descripcion')
            ->toArray();
        $datos['temas']=$temas;
        ///////
        //mandato
        $datos['mandato']=[];
        foreach($this->rel_mandato as $mandato) {
            $datos['mandato'][]=$mandato->fmt_id_mandato;
        }
        ////
        $objetivo = casos_informes_interes::join('catalogos.cat_item','id_interes','id_item')
                                ->where('id_casos_informes',$this->id_casos_informes)
                                ->wherein('id_item',$lis_objetivo)
                                ->orderby('cat_item.descripcion')
                                ->distinct()
                                ->pluck('cat_item.descripcion')
                                ->toArray();

        $datos['objetivo'] = $objetivo;


        $enfoque = casos_informes_interes::join('catalogos.cat_item','id_interes','id_item')
            ->where('id_casos_informes',$this->id_casos_informes)
            ->wherein('id_item',$lis_enfoque)
            ->orderby('cat_item.descripcion')
            ->distinct()
            ->pluck('cat_item.descripcion')
            ->toArray();
        $datos['enfoque'] = $enfoque;
        $datos['tipo_violencia'] = 'Sin información';
        $datos['cobertura_espacial'] = $this->caracterizacion_cobertura; //Sobreescrito posteriormente
        $datos['cobertura_temporal'] = $this->caracterizacion_temporalidad;
        $datos['hitos'] = 'Sin información';
        //$datos['aa'] = 'Sin información';
        //$datos['poblacion'] = $this->caracterizacion_sectores;
        //$datos['ocupaciones'] = $this->caracterizacion_sectores; //Repetido, así venía el excel
        //Cambios en sectores incluye
        $a_tmp=array();
        foreach($this->rel_sectores as $tmp ) {
            $item = cat_item::find($tmp->id_item);
            if($item) {
                $a_tmp[$item->id_cat][]=$item->descripcion;
            }

        }
        $sectores_incluye_aa="";
        $sectores_incluye_poblaciones="";
        $sectores_incluye_ocupaciones="";
        if(isset($a_tmp[190])) {
            $sectores_incluye_aa = $a_tmp[190];
        }
        if(isset($a_tmp[191])) {
            $sectores_incluye_poblaciones = $a_tmp[191];
        }
        if(isset($a_tmp[192])) {
            $sectores_incluye_ocupaciones = $a_tmp[192];
        }
        $datos['aa'] = $sectores_incluye_aa;
        $datos['poblacion'] = $sectores_incluye_poblaciones;
        $datos['ocupaciones'] = $sectores_incluye_ocupaciones;
        //Cambios en cobertura geográfica
        $a_tmp=array();
        foreach($this->rel_casos_informes_geo as $tmp) {
            $tmp_geo=[];
            $tmp_geo['codigo']=geo::find($tmp->id_geo)->fmt_codigo;
            $tmp_geo['descripcion']=geo::nombre_completo($tmp->id_geo);
            $a_tmp[]=$tmp_geo;
        }
        $datos['cobertura_espacial'] = $a_tmp;


        $datos['idioma'] = 'Sin información';
        $consentimiento = $this->rel_adjunto()->where('id_tipo',1)->count();
        $datos['derechos_uso'] = $consentimiento>0 ? "Sí" : "No";

        $datos['codigo_hash'] = 'N/A';
        $datos['formato'] = 'N/A';
        $datos['tamano'] = $this->contenido_volumen;
        $datos['numero_paginas'] = $this->contenido_volumen; //Repetido, así venía el excel
        $datos['duracion'] = 'N/A';
        $datos['resolucion'] = 'N/A';
        $datos['formato_compresion'] = 'N/A';
        $tmp=[];
        if($this->descripcion) $tmp[]=$this->descripcion;
        if($this->receptor_anotaciones) $tmp[]=$this->receptor_anotaciones;
        $txt=implode(PHP_EOL, $tmp);
        $datos['asociar_recursos'] = $txt;
        $datos['asociar_fondos'] = 'No aplica';
        $datos['notas_catalogacion'] = $txt; //Repetido, así venia
        $datos['usuario_carga'] = 'Entrevistador #'.$this->rel_id_entrevistador->fmt_numero_entrevistador;
        
        $objeto = new \stdClass();
        foreach($textos as $llave=>$texto) {
            $objeto->$texto = $datos[$llave];
        }

        $estructura = new \stdClass();
        $estructura->textos = $textos;
        $estructura->datos = $datos;
        $estructura->objeto = $objeto;

        return $estructura;
    }

}
