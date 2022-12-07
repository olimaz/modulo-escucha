<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Storage;

/**
 * Class desclasificar
 * Esta clase apunta a la misma tabla que reservado_acceso.
 * Es una versión nueva para poder asignar varios de un solo, pero usa la misma tabla y lógica.
 * @package App\Models
 * @version March 17, 2020, 6:26 pm -05
 *
 * @property \App\Models\Esclarecimiento.adjunto idAdjunto
 * @property integer id_autorizador
 * @property integer id_autorizado
 * @property integer id_subserie
 * @property integer id_primaria
 * @property string|\Carbon\Carbon fh_insert
 * @property integer id_activo
 * @property integer id_denegador
 * @property string|\Carbon\Carbon fh_update
 * @property string|\Carbon\Carbon fh_del
 * @property string|\Carbon\Carbon fh_al
 * @property integer id_adjunto
 */
class desclasificar extends Model
{

    public $table = 'esclarecimiento.reservado_acceso';
    
    public $timestamps = false;



    protected $primaryKey = 'id_reservado_acceso';

    public $fillable = [
        'id_autorizador',
        'id_autorizado',
        'id_subserie',
        'id_primaria',
        'fh_insert',
        'id_activo',
        'id_denegador',
        'fh_update',
        'fh_del',
        'fh_al',
        'id_adjunto'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_reservado_acceso' => 'integer',
        'id_autorizador' => 'integer',
        'id_autorizado' => 'integer',
        'id_subserie' => 'integer',
        'id_primaria' => 'integer',
        'fh_insert' => 'datetime',
        'id_activo' => 'integer',
        'id_denegador' => 'integer',
        'fh_update' => 'datetime',
        'fh_del' => 'datetime',
        'fh_al' => 'datetime',
        'id_adjunto' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

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

    //Getters
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
    public function getFechaRangoAttribute() {
        if(empty($this->fh_del)) {
            return null;
        }
        try {
            $del= new Carbon($this->fh_del);
            $al= new Carbon($this->fh_al);
            return $del->format("d/m/Y")." - ".$al->format("d/m/Y");
        }
        catch(\Exception $e) {
            return null;
        }

    }
    public function getFmtUrlSoporteAttribute() {
        $adjunto = adjunto::find($this->id_adjunto);

        if($adjunto) {
            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                $url = "<a target='_blank' href='".action('adjuntoController@show_autoriza',$adjunto->id_adjunto)."'>$adjunto->nombre_original</a>";
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

    //Para desplegar el adjunto como adjuntado
    public function getFmtEditaSoporteAttribute() {
        $adjunto = adjunto::find($this->id_adjunto);
        $ubica="public/".$adjunto->ubicacion;
        if(Storage::exists($ubica)) {
            $ubica="/storage".$adjunto->ubicacion;
        }
        else {
            $ubica="";
        }
        return $ubica;


    }
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


    /*
     * SCOPES
     */
    public static function filtros_default($request = null) {

        //Valores por defecto
        $filtro =new desclasificar();
        $filtro->id_primaria = -1;
        $filtro->id_subserie = -1;
        $filtro->id_activo = 1;
        $filtro->id_autorizado = -1;
        $filtro->id_autorizador = -1;
        $filtro->entrevista_codigo = null;
        $filtro->vigentes=0;
        $filtro->entrevista_nivel=-1;




        // Actualizar valores del REQUEST
        $filtro->id_primaria = isset($request->id_primaria) ? $request->id_primaria : $filtro->id_primaria;
        $filtro->id_subserie = isset($request->id_subserie) ? $request->id_subserie : $filtro->id_subserie;
        $filtro->id_activo = isset($request->id_activo) ? $request->id_activo : $filtro->id_activo;
        $filtro->id_autorizado = isset($request->id_autorizado) ? $request->id_autorizado : $filtro->id_autorizado;
        $filtro->id_autorizador = isset($request->id_autorizador) ? $request->id_autorizador : $filtro->id_autorizador;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;
        $filtro->vigentes = isset($request->vigentes) ? $request->vigentes : $filtro->vigentes;
        $filtro->entrevista_nivel = isset($request->entrevista_nivel) ? $request->entrevista_nivel : $filtro->entrevista_nivel;


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

    public static function scopeId_Activo($query, $criterio=-1) {
        if($criterio > 0) {
            $query->where('id_activo',$criterio);
        }
    }
    public static function scopeId_autorizado($query, $criterio=-1) {
        if($criterio > 0) {
            $query->where('id_autorizado',$criterio);
        }
    }
    public static function scopeId_autorizador($query, $criterio=-1) {
        if($criterio > 0) {
            $query->where('id_autorizador',$criterio);
        }
    }
    public static function scopeId_Subserie($query, $criterio=-1) {
        if($criterio > 0) {
            $query->where('id_subserie',$criterio);
        }
    }
    public static function scopeEntrevista_Codigo($query,$codigo="") {
        $codigo=trim($codigo);
        $codigo=mb_strtoupper($codigo);
        $arreglo=array();
        $id_subserie=0;
        if(strlen($codigo)>0) {
            if(strpos($codigo,'-VI')> 0) {
                $arreglo = entrevista_individual::entrevista_codigo($codigo)->pluck('id_e_ind_fvt')->toArray();
                $id_subserie=config('expedientes.vi');
            }
            elseif(strpos($codigo,'-AA')> 0) {
                $arreglo = entrevista_individual::entrevista_codigo($codigo)->pluck('id_e_ind_fvt')->toArray();
                $id_subserie=config('expedientes.aa');
            }
            elseif(strpos($codigo,'-TC')> 0) {
                $arreglo = entrevista_individual::entrevista_codigo($codigo)->pluck('id_e_ind_fvt')->toArray();
                $id_subserie=config('expedientes.tc');
            }
            elseif(strpos($codigo,'-CO')> 0) {
                $arreglo = entrevista_colectiva::entrevista_codigo($codigo)->pluck('id_entrevista_colectiva')->toArray();
                $id_subserie=config('expedientes.co');
            }
            elseif(strpos($codigo,'-EE')> 0) {
                $arreglo = entrevista_etnica::entrevista_codigo($codigo)->pluck('id_entrevista_etnica')->toArray();
                $id_subserie=config('expedientes.ee');
            }
            elseif(strpos($codigo,'-PR')> 0) {
                $arreglo = entrevista_profundidad::entrevista_codigo($codigo)->pluck('id_entrevista_profundidad')->toArray();
                $id_subserie=config('expedientes.pr');
            }
            elseif(strpos($codigo,'-DC')> 0) {
                $arreglo = diagnostico_comunitario::entrevista_codigo($codigo)->pluck('id_diagnostico_comunitario')->toArray();
                $id_subserie=config('expedientes.dc');
            }
            elseif(strpos($codigo,'-HV')> 0) {
                $arreglo = historia_vida::entrevista_codigo($codigo)->pluck('id_historia_vida')->toArray();
                $id_subserie=config('expedientes.hv');
            }
            elseif(strpos($codigo,'-CI')> 0) {
                $arreglo = casos_informes::codigo($codigo)->pluck('id_casos_informes')->toArray();
                $id_subserie=config('expedientes.ci');
            }
            $query->wherein('id_primaria',$arreglo)
                    ->where('id_subserie',$id_subserie);
        }
    }

    public static function scopeEntrevista_Nivel($query,$nivel=-1) {

        if($nivel>0) {
            $vi = entrevista_individual::where('clasifica_nivel',$nivel)->pluck('id_e_ind_fvt')->toArray();
            $co = entrevista_colectiva::where('clasificacion_nivel',$nivel)->pluck('id_entrevista_colectiva')->toArray();
            $ee = entrevista_etnica::where('clasificacion_nivel',$nivel)->pluck('id_entrevista_etnica')->toArray();
            $pr = entrevista_profundidad::where('clasificacion_nivel',$nivel)->pluck('id_entrevista_profundidad')->toArray();
            $dc = diagnostico_comunitario::where('clasificacion_nivel',$nivel)->pluck('id_diagnostico_comunitario')->toArray();
            $hv = historia_vida::where('clasificacion_nivel',$nivel)->pluck('id_historia_vida')->toArray();
            $ci = casos_informes::where('clasifica_nivel',$nivel)->pluck('id_casos_informes')->toArray();

            $id_vi=config('expedientes.vi');
            $id_aa=config('expedientes.aa');
            $id_tc=config('expedientes.tc');
            $id_co=config('expedientes.co');
            $id_ee=config('expedientes.ee');
            $id_pr=config('expedientes.pr');
            $id_dc=config('expedientes.dc');
            $id_hv=config('expedientes.hv');
            $id_ci=config('expedientes.ci');

            if(count($vi)>0)
                $sql[] = " (id_subserie in ($id_vi, $id_aa, $id_tc) and id_primaria in (". implode(',',$vi ). ")) ";
            if(count($co)>0)
                $sql[] = " (id_subserie in ($id_co) and id_primaria in (". implode(',',$co ). ")) ";
            if(count($ee)>0)
                $sql[] = " (id_subserie in ($id_ee) and id_primaria in (". implode(',',$ee ). ")) ";
            if(count($pr)>0)
                $sql[] = " (id_subserie in ($id_pr) and id_primaria in (". implode(',',$pr ). ")) ";
            if(count($dc)>0)
                $sql[] = " (id_subserie in ($id_dc) and id_primaria in (". implode(',',$dc ). ")) ";
            if(count($hv)>0)
                $sql[] = " (id_subserie in ($id_hv) and id_primaria in (". implode(',',$hv ). ")) ";
            if(count($ci)>0)
                $sql[] = " (id_subserie in ($id_ci) and id_primaria in (". implode(',',$ci ). ")) ";

            $where = implode (" or ",$sql);



            $query->whereraw(\DB::raw("($where)"));

        }
    }

    public static function scopeVigentes($query,$criterio=0) {
        $del=date("Y-m-d 00:00:00");
        $al=date("Y-m-d 23:59:59");
        if($criterio == 1) {
            $query->where('fh_del','<=',$del)
                    ->where('fh_al','>=',$al);
        }
        elseif($criterio == 2) {
            $query->where('fh_al','<',$al);
        }
    }

    public static function scopeOrdenar($query) {
        $query->orderby('fh_insert','desc')->orderby('id_subserie')->orderby('id_primaria');
    }

    public static function scopeFiltrar($query, $criterios)
    {
        if (!is_object($criterios)) {
            $criterios = self::filtros_default();
        }
        $query->id_subserie($criterios->id_subserie)
                ->id_activo($criterios->id_activo)
                ->id_autorizado($criterios->id_autorizado)
                ->id_autorizador($criterios->id_autorizador)
                ->entrevista_codigo($criterios->entrevista_codigo)
                ->entrevista_nivel($criterios->entrevista_nivel)
                ->vigentes($criterios->vigentes);

    }


    //Buscar la entrevista para asignar permisos
    public static function buscar_entrevista($codigo="") {
        $codigo=trim($codigo);
        $codigo=mb_strtoupper($codigo);
        $respuesta = new \stdClass();
        $respuesta->nivel=4;
        $respuesta->id_primaria=null;
        $respuesta->entrevista=null;
        $respuesta->id_subserie=0;
        $respuesta->url_show="";

        if(strlen($codigo)>0) {
            if(strpos($codigo,'-VI-')> 0) {
                $e = entrevista_individual::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasifica_nivel;
                    $respuesta->id_primaria = $e->id_e_ind_fvt;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.vi');
                    $respuesta->url_show = action('entrevista_individualController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-AA-')> 0) {
                $e = entrevista_individual::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasifica_nivel;
                    $respuesta->id_primaria = $e->id_e_ind_fvt;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.aa');
                    $respuesta->url_show = action('entrevista_individualController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-TC-')> 0) {
                $e = entrevista_individual::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasifica_nivel;
                    $respuesta->id_primaria = $e->id_e_ind_fvt;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.tc');
                    $respuesta->url_show = action('entrevista_individualController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-CO')> 0) {
                $e = entrevista_colectiva::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasificacion_nivel;
                    $respuesta->id_primaria = $e->id_entrevista_colectiva;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.co');
                    $respuesta->url_show = action('entrevista_colectivaController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-EE')> 0) {
                $e = entrevista_etnica::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasificacion_nivel;
                    $respuesta->id_primaria = $e->id_entrevista_etnica;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.ee');
                    $respuesta->url_show = action('entrevista_etnicaController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-PR')> 0) {
                $e = entrevista_profundidad::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasificacion_nivel;
                    $respuesta->id_primaria = $e->id_entrevista_profundidad;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.pr');
                    $respuesta->url_show = action('entrevista_profundidadController@show',$respuesta->id_primaria ) ;
                }

            }
            elseif(strpos($codigo,'-DC')> 0) {
                $e = diagnostico_comunitario::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasificacion_nivel;
                    $respuesta->id_primaria = $e->id_diagnostico_comunitario;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.dc');
                    $respuesta->url_show = action('diagnostico_comunitarioController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-HV')> 0) {
                $e = historia_vida::entrevista_codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasificacion_nivel;
                    $respuesta->id_primaria = $e->id_historia_vida;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.hv');
                    $respuesta->url_show = action('historia_vidaController@show',$respuesta->id_primaria ) ;
                }
            }
            elseif(strpos($codigo,'-CI')> 0) {
                $e = casos_informes::codigo($codigo)->first();
                if($e) {
                    $respuesta->nivel       = $e->clasifica_nivel;
                    $respuesta->id_primaria = $e->id_casos_informes;
                    $respuesta->entrevista  = $e;
                    $respuesta->id_subserie = config('expedientes.ci');
                    $respuesta->url_show = action('casos_informesController@show',$respuesta->id_primaria ) ;
                }

            }
        }
        return $respuesta;
    }


}
