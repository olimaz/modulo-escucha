<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;

/**
 * @property int $id_reservado_acceso
 * @property int $id_autorizador
 * @property int $id_autorizado
 * @property int $id_subserie
 * @property int $id_primaria
 * @property int $id_adjunto
 * @property string $fh_insert
 * @property string $fh_del
 * @property string $fh_al
 */
class reservado_acceso extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.reservado_acceso';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_reservado_acceso';

    /**
     * @var array
     */
    protected $fillable = ['id_autorizador', 'id_autorizado', 'id_subserie', 'id_primaria', 'fh_insert','fh_del','fh_al','id_adjunto'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     * 
     * @var string
     */
    protected $dateFormat = 'U';

    public function rel_id_autorizador() {
        return $this->belongsTo(entrevistador::class,'id_autorizador','id_entrevistador');
    }
    public function rel_id_autorizado() {
        return $this->belongsTo(entrevistador::class,'id_autorizado','id_entrevistador');
    }


    //Seters
    public function setFhDelAttribute($val) {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d',$val);
        }
        catch(Exception $e) {
            $fecha=Carbon::now();
        }
        $this->attributes['fh_del']=$fecha->format("Y-m-d 00:00:00");
    }
    public function setFhAlAttribute($val) {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d',$val);
        }
        catch(Exception $e) {
            $fecha=Carbon::now();
        }
        $this->attributes['fh_al']=$fecha->format("Y-m-d 23:59:59");
    }
    public function getFmtFhInsertAttribute() {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s',$this->fh_insert);
            return $fecha->formatLocalized("%a %d-%b-%Y %H:%M");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtFhDelAttribute() {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s',$this->fh_del);
            return $fecha->formatLocalized("%a %d-%b-%Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtFhAlAttribute() {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s',$this->fh_al);
            return $fecha->formatLocalized("%a %d-%b-%Y");
        }
        catch(\Exception $e) {
            return "Sin especificar ";
        }
    }
    public function getUrlAttribute() {
        $adjunto = adjunto::find($this->id_adjunto);

        if($adjunto) {
            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                $url = "<a target='_blank' href='".action('adjuntoController@show_autoriza',$adjunto->id_adjunto)."'>$adjunto->nombre_adjunto</a>";
            }
            else {
                $url = "$adjunto->nombre_adjunto";
            }
        }
        else {
            $url="(Sin soporte)";
        }
        return $url;

    }


    //Formatos
    public function getFmtIdAutorizadoAttribute() {
        $quien=entrevistador::find($this->id_autorizado);
        if($quien) {
            return $quien->numero_entrevistador." - ".$quien->nombre;
        }
        else {
            return "Autorizado ($this->id_autorizado) desconocido";
        }
    }
    public function getFmtIdAutorizadorAttribute() {
        $quien=entrevistador::find($this->id_autorizador);
        if($quien) {
            return $quien->numero_entrevistador." - ".$quien->nombre;
        }
        else {
            return "Autorizador ($this->id_autorizado) desconocido";
        }
    }

    // URL para el show.  Lo uso en la tabla de prioridades
    public  function getEntrevistaAttribute() {

        $r=new \stdClass();
        $r->url="Desconocido";
        $r->entrevista=false;

        if($this->id_subserie==config('expedientes.vi')) {
            $r->url=action('entrevista_individualController@show',$this->id_primaria);
            $r->entrevista= entrevista_individual::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.aa')) {
            $r->url=action('entrevista_individualController@show',$this->id_primaria);
            $r->entrevista= entrevista_individual::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.tc')) {
            $r->url=action('entrevista_individualController@show',$this->id_primaria);
            $r->entrevista= entrevista_individual::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.co')) {
            $r->url=action('entrevista_colectivaController@show',$this->id_primaria);
            $r->entrevista = entrevista_colectiva::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.ee')) {
            $r->url=action('entrevista_etnicaController@show',$this->id_primaria);
            $r->entrevista = entrevista_etnica::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.pr')) {
            $r->url=action('entrevista_profundidadController@show',$this->id_primaria);
            $r->entrevista = entrevista_profundidad::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.dc')) {
            $r->url=action('diagnostico_comunitarioController@show',$this->id_primaria);
            $r->entrevista = diagnostico_comunitario::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.hv')) {
            $r->url=action('historia_vidaController@show',$this->id_primaria);
            $r->entrevista = historia_vida::find($this->id_primaria);
        }
        elseif($this->id_subserie==config('expedientes.ci')) {
            $r->url=action('casos_informesController@show',$this->id_primaria);
            $r->entrevista = casos_informes::find($this->id_primaria);
        }
        return $r;
    }

    //SCOPES
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
        $filtro->entrevista_objetivo = null;
        $filtro->entrevistado_nombres = null;
        $filtro->entrevistado_apellidos = null;
        $filtro->entrevistado_otros_nombres = null;



        // Actualizar valores del REQUEST
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
        //Determinar si es lp, muni o depto
        if(isset($request->entrevista_lugar)) {
            if($request->entrevista_lugar>0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar;
            }
            else {
                if($request->entrevista_lugar_muni > 0) {
                    $filtro->entrevista_lugar=$request->entrevista_lugar_muni;
                }
                else {
                    if($request->entrevista_lugar_depto > 0) {
                        $filtro->entrevista_lugar=$request->entrevista_lugar_depto;
                    }
                }
            }
        }
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


        //Filtros propios del instrumento
        $filtro->id_sector = isset($request->id_sector) ? $request->id_sector : $filtro->id_sector;
        $filtro->entrevista_objetivo = isset($request->entrevista_objetivo) ? $request->entrevista_objetivo : $filtro->entrevista_objetivo;
        $filtro->entrevistado_nombres = isset($request->entrevistado_nombres) ? $request->entrevistado_nombres : $filtro->entrevistado_nombres;
        $filtro->entrevistado_apellidos = isset($request->entrevistado_apellidos) ? $request->entrevistado_apellidos : $filtro->entrevistado_apellidos;
        $filtro->entrevistado_otros_nombres = isset($request->entrevistado_otros_nombres) ? $request->entrevistado_otros_nombres : $filtro->entrevistado_otros_nombres;





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
            $query->wherein('esclarecimiento.historia_vida.id_entrevistador',$criterio);
        }
        elseif($criterio>0) {
            $query->where('esclarecimiento.historia_vida.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_macroterritorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('historia_vida.id_macroterritorio',$criterio);
        }
    }
    public static function scopeId_territorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('historia_vida.id_territorio',$criterio);
        }
    }
    public static function scopeEntrevista_correlativo($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('entrevista_correlativo',$criterio);
        }
    }
    public static function scopeEntrevista_codigo($query,$criterio="") {
        $criterio=trim($criterio);
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
                $query->join('esclarecimiento.historia_vida_mandato as fmandato', 'historia_vida.id_historia_vida', '=', 'fmandato.id_historia_vida')
                    ->wherein('id_mandato', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.historia_vida_mandato as fmandato', 'historia_vida.id_historia_vida', '=', 'fmandato.id_historia_vida')
                    ->where('id_mandato',$criterio);
            }
        }
    }
    public static function scopeTitulo($query,$criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('titulo','ilike',"%$criterio%");
        }
    }
    public static function scopeDinamica($query,$criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->join('esclarecimiento.historia_vida_dinamica as fdinamica','historia_vida.id_historia_vida', '=', 'fdinamica.id_historia_vida')
                ->where('dinamica','ilike',"%$criterio%");
        }
    }
    public static function scopeInteres($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.historia_vida_interes as finteres', 'historia_vida.id_historia_vida', '=', 'finteres.id_historia_vida')
                    ->wherein('id_interes', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.historia_vida_interes as finteres', 'historia_vida.id_historia_vida', '=', 'finteres.id_historia_vida')
                    ->where('id_interes', $criterio);
            }
        }
    }

    //De acuerdo al perfil, aplica los permisos
    public static function scopePermisos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('historia_vida.id_entrevistador',$arreglo_entrevistadores);
    }
    //Filtro según el grupo al que pertenece
    public static function scopeId_grupo($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('esclarecimiento.entrevistador as fe','historia_vida.id_entrevistador','=','fe.id_entrevistador')
                ->where('fe.id_grupo',$criterio);
        }
    }

    //Filtros propios del instrumento
    public static function scopeId_sector($query,$criterio=-1 ) {
        if($criterio>0) {
            $query->where('id_sector',$criterio);
        }
    }
    public static function scopeEntrevista_objetivo($query,$criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevista_objetivo','ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevistado_nombres($query,$criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevistado_nombres','ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevistado_apellidos($query,$criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevistado_apellidos','ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevistado_otros_nombres($query,$criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevistado_otros_nombres','ilike',"%$criterio%");
        }
    }



    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        $query = $query->entrevista_del($criterios->entrevista_del)
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
            //Seguridad
            ->permisos()
            ->id_grupo($criterios->id_grupo)
            //Scopes especificos
            ->id_sector($criterios->id_sector)
            ->entrevista_objetivo($criterios->entrevista_objetivo)
            ->entrevistado_nombres($criterios->entrevistado_nombres)
            ->entrevistado_apellidos($criterios->entrevistado_apellidos)
            ->entrevistado_otros_nombres($criterios->entrevistado_otros_nombres);

    }



}
