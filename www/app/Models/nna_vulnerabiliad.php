<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class nna_vulnerabiliad
 * @package App\Models
 * @version July 9, 2019, 5:04 pm -05
 *
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
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
 * @property integer id_entrevistador
 * @property integer correlativo
 * @property integer dictamen
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property string nombres
 * @property string apellidos
 * @property string codigo
 * @property integer edad
 * @property integer menor_12
 * @property integer vive_familia
 * @property integer vive_padre_madre
 * @property integer vive_rep_legal
 * @property integer vive_familia_extensa
 * @property string vive_con
 * @property integer pariticipa_familia
 * @property integer pariticipa_comunidad
 * @property integer escuela_asiste
 * @property string escuela_nombre
 * @property string escuela_grado
 * @property integer escuela_problemas
 * @property integer escuela_problemas_progreso
 * @property integer abuso_exposicion
 * @property integer abuso_fisico
 * @property integer abuso_sexual
 * @property integer abuso_abandono
 * @property integer abuso_ajustes
 * @property integer comunidad_conocimiento
 * @property string comunidad_mensajes
 * @property integer comunidad_reuniones
 * @property integer comunidad_apoyo
 * @property string|\Carbon\Carbon fecha_evaluacion
 * @property string observaciones
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class nna_vulnerabiliad extends Model
{

    public $table = 'esclarecimiento.nna_vulnerabilidad';
    protected $primaryKey = 'id_nna_vulnerabilidad';
    
    public $timestamps = true;

    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['menor_12']=1;
        $this->attributes['vive_familia']=2;
        $this->attributes['vive_padre_madre']=2;
        $this->attributes['vive_rep_legal']=2;
        $this->attributes['vive_familia_extensa']=2;
        $this->attributes['pariticipa_familia']=2;
        $this->attributes['pariticipa_comunidad']=2;
        $this->attributes['escuela_asiste']=2;
        $this->attributes['escuela_problemas']=1;
        $this->attributes['escuela_problemas_progreso']=1;
        $this->attributes['abuso_exposicion']=1;
        $this->attributes['abuso_fisico']=1;
        $this->attributes['abuso_sexual']=1;
        $this->attributes['abuso_abandono']=1;
        $this->attributes['abuso_ajustes']=1;
        $this->attributes['comunidad_conocimiento']=2;
        $this->attributes['comunidad_reuniones']=2;
        $this->attributes['comunidad_apoyo']=2;
        $this->attributes['fecha_evaluacion']=date("Y-m-d");
        if(\Auth::check()) {
            $this->attributes['id_territorio']=\Auth::user()->id_territorio;
        }

        //$this->attributes['id_macroterritorio']=\Auth::user()->id_territorio;
    }


    public $fillable = [
        'id_entrevistador',
        'correlativo',
        'id_macroterritorio',
        'id_territorio',
        'codigo',
        'nombres',
        'apellidos',
        'edad',
        'menor_12',
        'vive_familia',
        'vive_padre_madre',
        'vive_rep_legal',
        'vive_familia_extensa',
        'vive_con',
        'pariticipa_familia',
        'pariticipa_comunidad',
        'escuela_asiste',
        'escuela_nombre',
        'escuela_grado',
        'escuela_problemas',
        'escuela_problemas_progreso',
        'abuso_exposicion',
        'abuso_fisico',
        'abuso_sexual',
        'abuso_abandono',
        'abuso_ajustes',
        'comunidad_conocimiento',
        'comunidad_mensajes',
        'comunidad_reuniones',
        'comunidad_apoyo',
        'fecha_evaluacion',
        'observaciones',
        'created_at',
        'updated_at',

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_nna_vulnerabilidad' => 'integer',
        'id_entrevistador' => 'integer',
        'correlativo' => 'integer',
        'nombres' => 'string',
        'apellidos' => 'string',
        'edad' => 'integer',
        'menor_12' => 'integer',
        'vive_familia' => 'integer',
        'vive_padre_madre' => 'integer',
        'vive_rep_legal' => 'integer',
        'vive_familia_extensa' => 'integer',
        'vive_con' => 'string',
        'pariticipa_familia' => 'integer',
        'pariticipa_comunidad' => 'integer',
        'escuela_asiste' => 'integer',
        'escuela_nombre' => 'string',
        'escuela_grado' => 'string',
        'escuela_problemas' => 'integer',
        'escuela_problemas_progreso' => 'integer',
        'abuso_exposicion' => 'integer',
        'abuso_fisico' => 'integer',
        'abuso_sexual' => 'integer',
        'abuso_abandono' => 'integer',
        'abuso_ajustes' => 'integer',
        'comunidad_conocimiento' => 'integer',
        'comunidad_mensajes' => 'string',
        'comunidad_reuniones' => 'integer',
        'comunidad_apoyo' => 'integer',
        'fecha_evaluacion' => 'datetime',
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
        'nombres' => 'required',
        'apellidos' => 'required',
        'edad' => 'required|min:1|max:17',
        'fecha_evaluacion_submit' => 'required'
    ];

    /**
     * RELACIONES
     **/
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador','id_entrevistador');
    }

    public function rel_id_macroterritorio() {
        return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
    }
    public function rel_id_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }

    //GETERS
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


    public function getFmtMenor12Attribute() {
        return $this->menor_12 == 1 ? "Sí" : "No";
    }
    public function getFmtDictamenCortoAttribute() {
        return $this->dictamen == 1 ? "Positivo" : "Negativo";
    }
    public function getFmtDictamenAttribute() {
        return $this->dictamen == 1 ? "Se recomienda proceder con la evaluación de seguridad" : "Es necesaria una mayor revisión antes de la toma del testimonio.  ";
    }
    public function getFmtViveFamiliaAttribute() {
        return $this->vive_familia == 1 ? "Sí" : "No";
    }
    public function getFmtVivePadreMadreAttribute() {
        return $this->vive_padre_madre == 1 ? "Sí" : "No";
    }
    public function getFmtViveRepLegalAttribute() {
        return $this->vive_rep_legal == 1 ? "Sí" : "No";
    }
    public function getFmtViveFamiliaExtensaAttribute() {
        return $this->vive_familia_extensa == 1 ? "Sí" : "No";
    }
    public function getFmtParticipaFamiliaAttribute() {
        $opciones = [1=>'Participa en la vida familiar',2=>'No participa en la vida familiar'];
        return isset($opciones[$this->pariticipa_familia]) ?  $opciones[$this->pariticipa_familia] : "Desconocido";
    }
    public function getFmtParticipaComunidadAttribute() {
        $opciones = [1=>'Participa en estos espacios',2=>'No participa en estos espacios'];
        return isset($opciones[$this->pariticipa_comunidad]) ?  $opciones[$this->pariticipa_comunidad] : "Desconocido";

    }
    public function getFmtEscuelaAsisteAttribute() {
        $opciones =[1=>'Sí asiste o ya terminó la escuela',2=>'No atiende a la escuela'];
        return isset($opciones[$this->escuela_asiste]) ?  $opciones[$this->escuela_asiste] : "Desconocido";

    }
    public function getFmtEscuelaProblemasAttribute() {
        $opciones =[1=>'Vive situaciones significativas en este momento en la escuela ',2=>'No'];
        return isset($opciones[$this->escuela_problemas]) ?  $opciones[$this->escuela_problemas] : "Desconocido";
    }
    public function getFmtEscuelaProblemasProgresoAttribute() {
        $opciones =  [1=>'Vive situaciones significativas en este momento en la escuela ',2=>'No'];
        return isset($opciones[$this->escuela_problemas_progreso]) ?  $opciones[$this->escuela_problemas_progreso] : "Desconocido";
    }
    public function getFmtAbusoExposicionAttribute() {
        return $this->abuso_exposicion == 1 ? "Sí" : "No";
    }
    public function getFmtAbusoFisicoAttribute() {
        return $this->abuso_fisico == 1 ? "Sí" : "No";
    }
    public function getFmtAbusoSexualAttribute() {
        return $this->abuso_sexual == 1 ? "Sí" : "No";
    }
    public function getFmtAbusoAbandonoAttribute() {
        return $this->abuso_abandono == 1 ? "Sí" : "No";
    }
    public function getFmtAbusoAjustesAttribute() {
        return $this->abuso_exposicion == 1 ? "Sí" : "No";
    }
    public function getFmtComunidadConocimientoAttribute() {
        $opciones =  [1=>'Sí ',2=>'La comunidad no ha escuchado nada acerca de la Comisión. '];
        return isset($opciones[$this->comunidad_conocimiento]) ?  $opciones[$this->comunidad_conocimiento] : "Desconocido";

    }
    public function getFmtComunidadReunionesAttribute() {
        return $this->comunidad_reuniones == 1 ? "Sí" : "No";
    }
    public function getFmtComunidadApoyoAttribute() {
        $opciones = [1=>'Sí ',2=>'El niño o niña necesita protección especial después de dar el testimonio'];
        return isset($opciones[$this->comunidad_apoyo]) ?  $opciones[$this->comunidad_apoyo] : "Desconocido";

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
        $id_subserie=config('expedientes.nev');
        $cual = correlativo::cual_toca($id_subserie);
        return $cual;
    }

    public function prefijo_codigo() {
        $id_subserie=config('expedientes.nev');
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
        if($this->vive_familia==2) {
            $dictamen=2;
        }
        //No asiste a la escuela
        if($this->escuela_asiste==2) {
            $dictamen=2;
        }
        //Problemas en la escuela
        if($this->escuela_problemas==1) {
            $dictamen=2;
        }
        //Problemas de progreso en la escuela
        if($this->escuela_problemas_progreso==1) {
            $dictamen=2;
        }
        //Ha estado expuesto
        if($this->abuso_exposicion==1) {
            $dictamen=2;
        }
        //La comunidad no tiene conocimiento C.V.
        if($this->comunidad_conocimiento==2) {
            $dictamen=2;
        }
        //No se han realizado reuniones en la comunidad
        if($this->comunidad_reuniones==2) {
            $dictamen=2;
        }
        //La comunidad no está dispuesta a apoyar
        if($this->comunidad_apoyo==2) {
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
        $filtro->nombres = null;
        $filtro->apellidos = null;
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
        $filtro->nombres = isset($request->nombres) ? $request->nombres : $filtro->nombres;
        $filtro->apellidos = isset($request->apellidos) ? $request->apellidos : $filtro->apellidos;
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
        $query->orderby('nna_vulnerabilidad.codigo');
    }
    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        //dd($criterios);
        $query->codigo($criterios->codigo)
            ->nombres($criterios->nombres)
            ->apellidos($criterios->apellidos)
            ->correlativo($criterios->correlativo)
            ->id_territorio($criterios->id_territorio)
            ->id_macroterritorio($criterios->id_macroterritorio)
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
        $query->wherein('nna_vulnerabilidad.id_entrevistador',$arreglo_entrevistadores);
    }
    public static function scopeCodigo($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('codigo','ilike',"%$criterio%");
        }
    }
    public static function scopeNombres($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('nombres','ilike',"%$criterio%");
        }
    }
    public static function scopeApellidos($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('apellidos','ilike',"%$criterio%");
        }
    }
    public static function scopeObservaciones($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('observaciones','ilike',"%$criterio%");
        }
    }
    public static function scopeCorrelativo($query,$criterio) {
        if($criterio>0) {
            $query->where('correlativo','=',$criterio);
        }
    }
    public static function scopeDictamen($query,$criterio) {
        if($criterio>0) {
            $query->where('dictamen','=',$criterio);
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

    //Controles de seguridad
    public function getFmtNombresAttribute() {
        if(\Gate::check('es-propio',$this->id_entrevistador) || \Gate::check('nivel-1')) {
            return $this->nombres;
        }
        else {
            return "(Bloqueado por seguridad)";
        }
    }
    public function getFmtApellidosAttribute() {
        if(\Gate::check('es-propio',$this->id_entrevistador) || \Gate::check('nivel-1')) {
            return $this->apellidos;
        }
        else {
            return "(Bloqueado por seguridad)";
        }
    }


}
