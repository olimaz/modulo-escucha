<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Gate;

/**
 * Class acceso_edicion
 * @package App\Models
 * @version February 19, 2020, 4:40 pm -05
 *

 * @property integer id_entrevista
 * @property integer id_subserie
 * @property integer id_autoriza
 * @property integer id_autorizado
 * @property string observaciones
 * @property integer id_situacion
 * @property integer id_revocado
 * @property string|\Carbon\Carbon fh_autorizado
 * @property string|\Carbon\Carbon fh_revocado
 */
class acceso_edicion extends Model
{

    public $table = 'acceso_edicion';
    protected $primaryKey = 'id_acceso_edicion';
    
    public $timestamps = false;




    public $fillable = [
        'id_entrevista',
        'id_subserie',
        'id_autoriza',
        'id_autorizado',
        'observaciones',
        'id_situacion',
        'id_revocado',
        'fh_autorizado',
        'fh_revocado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_acceso_edicion' => 'integer',
        'id_entrevista' => 'integer',
        'id_subserie' => 'integer',
        'id_autoriza' => 'integer',
        'id_autorizado' => 'integer',
        'observaciones' => 'string',
        'id_situacion' => 'integer',
        'id_revocado' => 'integer',
        'fh_autorizado' => 'datetime',
        'fh_revocado' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_entrevista' => 'required',
        'id_subserie' => 'required',
        //'id_autoriza' => 'required',
        'id_autorizado' => 'required',
    ];

    //Relaciones
    public function rel_id_autoriza() {
        return $this->belongsTo(entrevistador::class,'id_autoriza','id_entrevistador');
    }
    public function rel_id_autorizado() {
        return $this->belongsTo(entrevistador::class,'id_autorizado','id_entrevistador');
    }
    public function rel_id_revocado() {
        return $this->belongsTo(entrevistador::class,'id_revocado','id_entrevistador');
    }

    //
    public function getFmtIdSituacionAttribute() {
        return criterio_fijo::describir(11,$this->id_situacion);
    }
    public function getFmtIdAutorizaAttribute() {
        $e = $this->rel_id_autoriza;
        $nombre= "Desconocido";
        if($e) {
            $nombre = $e->nombre;
        }
        return $nombre;
    }
    public function getFmtIdAutorizadoAttribute() {
        $e = $this->rel_id_autorizado;
        $nombre= "Desconocido";
        if($e) {
            $nombre = $e->nombre;
        }
        return $nombre;
    }
    public function getFmtIdRevocadoAttribute() {
        $e = $this->rel_id_revocado;
        $nombre= "";
        if($e) {
            $nombre = $e->nombre;
        }
        return $nombre;
    }

    public function getEntrevistaAttribute() {
        if($this->id_subserie == config('expedientes.vi')) {
            $e = entrevista_individual::find($this->id_entrevista);
        }
        elseif($this->id_subserie == config('expedientes.aa')) {
            $e = entrevista_individual::find($this->id_entrevista);
        }
        elseif($this->id_subserie == config('expedientes.tc')) {
            $e = entrevista_individual::find($this->id_entrevista);
        }
        elseif($this->id_subserie== config('expedientes.co')) {
            $e = entrevista_colectiva::find($this->id_entrevista);
        }
        elseif($this->id_subserie== config('expedientes.ee')) {
            $e = entrevista_etnica::find($this->id_entrevista);
        }
        elseif($this->id_subserie== config('expedientes.pr')) {
            $e = entrevista_profundidad::find($this->id_entrevista);
        }
        elseif($this->id_subserie== config('expedientes.dc')) {
            $e = diagnostico_comunitario::find($this->id_entrevista);
        }
        elseif($this->id_subserie== config('expedientes.hv')) {
            $e = historia_vida::find($this->id_entrevista);
        }
        elseif($this->id_subserie== config('expedientes.ci')) {
            $e = casos_informes::find($this->id_entrevista);
        }
        else {
            return false;
        }
        return $e;
    }

    public function getCodigoEntrevistaAttribute()
    {
        $e =$this->entrevista;
        if($e) {
            return $e->entrevista_codigo;
        }
        else {
            return false;
        }
    }
    public function getPuedeConcederAccesoAttribute() {
        $e = $this->entrevista;
        if(!$e) {
            return false;
        }
        return entrevista_individual::revisar_conceder_acceso($e);
    }

    /*
     * FILTROS y buscadores
     */
    // SCOPES: filtros y criterios de ordenado
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->id_subserie = -1;
        $filtro->id_autoriza = -1;
        $filtro->id_autorizado = -1;
        $filtro->observaciones = null;
        $filtro->id_situacion = null;
        $filtro->id_revocado = null;
        $filtro->entrevista_codigo = null;




        // Actualizar valores del REQUEST
        $filtro->id_subserie = isset($request->id_subserie) ? $request->id_subserie : $filtro->id_subserie;
        $filtro->id_autoriza = isset($request->id_autoriza) ? $request->id_autoriza : $filtro->id_autoriza;
        $filtro->id_autorizado = isset($request->id_autorizado) ? $request->id_autorizado : $filtro->id_autorizado;
        $filtro->id_situacion = isset($request->id_situacion) ? $request->id_situacion : $filtro->id_situacion;
        $filtro->observaciones = isset($request->observaciones) ? $request->observaciones : $filtro->observaciones;
        $filtro->id_situacion = isset($request->id_situacion) ? $request->id_situacion : $filtro->id_situacion;
        $filtro->id_revocado = isset($request->id_revocado) ? $request->id_revocado : $filtro->id_revocado;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;


        //Aplicar filtro si no es administrador
        if(Gate::denies('revisar-m-nivel',[[1,2]])) {
            if(\Auth::check()) {
                $filtro->id_autoriza = \Auth::user()->id_entrevistador;
            }
            else {
                $filtro->id_autoriza = -1;
            }

        }
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
        $query->orderby('fh_autorizado')
            ->orderby('id_situacion');
    }
    public static function scopeId_Subserie($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_subserie',$criterio);
        }
    }
    public static function scopeId_Autoriza($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_autoriza',$criterio);
        }
    }
    public static function scopeId_Autorizado($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_autorizado',$criterio);
        }
    }
    public static function scopeObservaciones($query, $criterio="") {
        if(strlen($criterio) > 0) {
            $query->where('observaciones','ilike',"%$criterio%");
        }
    }
    public static function scopeId_Situacion($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_situacion',$criterio);
        }
    }
    public static function scopeId_Revocado($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_revocado',$criterio);
        }
    }


    public static function scopeEntrevista_codigo($query, $criterio="") {
        $criterio=trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = mb_strtoupper($criterio);
            $truco="x$criterio";
            //dd($truco);
            if(strpos($truco,"VI") > 0) {

                $query->join('esclarecimiento.e_ind_fvt as e','acceso_edicion.id_entrevista','=','e.id_e_ind_fvt')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.vi'));
            }
            elseif(strpos($truco,"AA") > 0) {
                $query->join('esclarecimiento.e_ind_fvt as e','acceso_edicion.id_entrevista','=','e.id_e_ind_fvt')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.aa'));
            }
            elseif(strpos($truco,"TC") > 0) {
                $query->join('esclarecimiento.e_ind_fvt as e','acceso_edicion.id_entrevista','=','e.id_e_ind_fvt')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.tc'));
            }
            elseif(strpos($truco,"CO") > 0) {
                $query->join('esclarecimiento.entrevista_colectiva as e','acceso_edicion.id_entrevista','=','e.id_entrevista_colectiva')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.co'));
            }
            elseif(strpos($truco,"EE") > 0) {
                $query->join('esclarecimiento.entrevista_etnica as e','acceso_edicion.id_entrevista','=','e.id_entrevista_etnica')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.ee'));
            }
            elseif(strpos($truco,"PR") > 0) {
                $query->join('esclarecimiento.entrevista_profundidad as e','acceso_edicion.id_entrevista','=','e.id_entrevista_profundidad')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.pr'));
            }
            elseif(strpos($truco,"DC") > 0) {
                $query->join('esclarecimiento.diagnostico_comunitario as e','acceso_edicion.id_entrevista','=','e.id_diagnostico_comunitario')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.dc'));
            }
            elseif(strpos($truco,"HV") > 0) {
                $query->join('esclarecimiento.historia_vida as e','acceso_edicion.id_entrevista','=','e.id_historia_vida')
                    ->where('acceso_edicion.id_subserie','=',config('expedientes.hv'));
            }
            else {
                $query->where('acceso_edicion.id_subserie',-1);
            }
            $query->where('entrevista_codigo','ilike',"$criterio%");


        }
    }





    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        $query = $query->id_subserie($criterios->id_subserie)
            ->id_autoriza($criterios->id_autoriza)
            ->id_autorizado($criterios->id_autorizado)
            ->observaciones($criterios->observaciones)
            ->id_situacion($criterios->id_situacion)
            ->id_revocado($criterios->id_revocado)
            ->entrevista_codigo($criterios->entrevista_codigo);
    }
}
