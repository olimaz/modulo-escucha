<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Gate;

/**
 * Class traza_actividad
 * @package App\Models
 * @version July 11, 2019, 10:30 pm -05
 *
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
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string|\Carbon\Carbon fecha_hora
 * @property integer id_usuario
 * @property integer id_accion
 * @property integer id_objeto
 * @property integer id_primaria
 * @property integer id_personificador
 * @property string referencia
 * @property string codigo
 */
class traza_actividad extends Model
{

    public $table = 'traza_actividad';
    protected $primaryKey = 'id_traza_actividad';
    
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d H:i:s.u';





    public $fillable = [
        'fecha_hora',
        'id_usuario',
        'id_accion',
        'id_objeto',
        'id_primaria',
        'referencia',
        'codigo',
        'id_personificador'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_traza_actividad' => 'integer',
        //'fecha_hora' => 'datetime',
        'id_usuario' => 'integer',
        'id_accion' => 'integer',
        'id_objeto' => 'integer',
        'referencia' => 'string',
        'codigo' => 'string'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(\Auth::check()) {
            if(\Auth::user()->isImpersonating()) {
                if( \Session::has('id_personificador')) {
                    $this->attributes['id_personificador']= \Session::get('id_personificador');
                }
            }
            $this->attributes['id_usuario']=\Auth::user()->id;
        }
        else {
            $this->attributes['id_usuario']=-1;
        }
    }

    /*
    // para detectar
    protected static function boot()    {
        parent::boot();
        self::creating(function ($query) {
            \Log::info("Boot de traza_actividad");
            if(\Auth::user()->isImpersonating()) {
                if( \Session::has('id_personificador')) {
                    $query->attributes['id_personificador']= \Session::get('id_personificador');
                }

            }
        });
    }
    */


    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_traza_actividad' => 'required',
        'fecha_hora' => 'required'
    ];

    public function rel_id_usuario() {
        return $this->belongsTo(User::class,'id_usuario','id');
    }
    public function rel_id_personificador() {
        return $this->belongsTo(User::class,'id_personificador','id');
    }

    public function getFmtIdUsuarioAttribute() {
        //Cambios en backend
        if($this->id_usuario==-1) {
            return "(Sistema de Información Misional)";
        }

        $item = $this->rel_id_usuario;
        if($item) {
            return $item->name;
        }
        else {
            return "Desconocido";
        }
    }
    public function getFmtIdPersonificadorAttribute() {
        $item = $this->rel_id_personificador;
        if($item) {
            return $item->name;
        }
        else {
            return "Desconocido";
        }
    }
    public function getFmtIdAccionAttribute() {
        return criterio_fijo::describir(21,$this->id_accion);
    }
    public function getFmtIdObjetoAttribute() {
        if(!is_null($this->id_objeto)) {
            return criterio_fijo::describir(22,$this->id_objeto);
        }
    }

    public function getFmtFechaHoraAttribute() {
        try {
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s.u',$this->fecha_hora);
            return $fecha->formatlocalized("%a %d/%b/%y %R");
        }
        catch(\Exception $e){
            return $this->fecha_hora;
        }
    }



    /// Filtros
    //Filtros
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->codigo = null;
        $filtro->id_usuario = -1;
        $filtro->id_objeto = -1;
        $filtro->id_accion = -1;
        //Evaluar filtros desde el GET
        $filtro->codigo = isset($request->codigo) ? $request->codigo : $filtro->codigo;
        $filtro->id_usuario = isset($request->id_usuario) ? $request->id_usuario : $filtro->id_usuario;
        $filtro->id_objeto = isset($request->id_objeto) ? $request->id_objeto : $filtro->id_objeto;
        $filtro->id_accion = isset($request->id_accion) ? $request->id_accion : $filtro->id_accion;
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
        $query->orderby('fecha_hora','desc');
    }
    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        //dd($criterios);
        $query->id_usuario($criterios->id_usuario)
            ->id_objeto($criterios->id_objeto)
            ->id_accion($criterios->id_accion)
            ->codigo($criterios->codigo)
            ->permisos();


        //->permisos() ;
    }
    public static function scopeid_usuario($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_usuario',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_usuario',$criterio);
            }
        }
    }
    public static function scopeid_objeto($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_objeto',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_objeto',$criterio);
            }
        }
    }
    public static function scopeid_accion($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_accion',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_accion',$criterio);
            }
        }
    }
    public static function scopeCodigo($query,$criterio) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('codigo','ilike',"$criterio%");
        }
    }

    public static function scopeid_primaria($query,$criterio) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                if(!in_array(-1,$criterio)) {
                    $query->wherein('id_primaria',$criterio);
                }
            }
        }
        else {
            if($criterio > 0) {
                $query->where('id_primaria',$criterio);
            }
        }
    }


    //Correspondencia entre tipo de documento y id_objeto en la traza de seguridad
    public static function cual_objeto($id_cat=0) {
        $objetos[config('expedientes.vi')]=1;
        $objetos[config('expedientes.aa')]=1;
        $objetos[config('expedientes.tc')]=1;
        $objetos[config('expedientes.ci')]=3;
        $objetos[config('expedientes.co')]=10;
        $objetos[config('expedientes.pr')]=11;
        $objetos[config('expedientes.hv')]=12;
        $objetos[config('expedientes.ee')]=14;
        $objetos[config('expedientes.dc')]=13;
        $objetos[config('expedientes.nev')]=7;
        $objetos[config('expedientes.nes')]=8;
        return isset($objetos[$id_cat]) ? $objetos[$id_cat] : 0;
    }

    //en funcion del id_objeto, devuelve el id_subserie//
    public static function cual_entrevista($id_objeto) {
        $arr[1]=config('excpedientes.vi');
        $arr[10]=config('excpedientes.co');
        $arr[14]=config('excpedientes.ee');
        $arr[11]=config('excpedientes.pr');
        $arr[13]=config('excpedientes.dc');
        $arr[12]=config('excpedientes.hv');
        $arr[3]=config('excpedientes.ci');
        return isset($arr[$id_objeto]) ? $arr[$id_objeto] : false;
    }


    //Devuelve el objeto a instanciar
    public static function cual_clase($id_cat=0) {
        $objetos[config('expedientes.vi')]='\App\Models\entrevista_individual';
        $objetos[config('expedientes.aa')]='\App\Models\entrevista_individual';
        $objetos[config('expedientes.tc')]='\App\Models\entrevista_individual';
        $objetos[config('expedientes.ci')]='\App\Models\casos_informes';
        $objetos[config('expedientes.co')]='\App\Models\entrevista_colectiva';
        $objetos[config('expedientes.pr')]='\App\Models\entrevista_profundidad';
        $objetos[config('expedientes.hv')]='\App\Models\historia_vida';
        $objetos[config('expedientes.dc')]='\App\Models\diagnostico_comunitario';
        $objetos[config('expedientes.ee')]='\App\Models\entrevista_etnica';
        $objetos[config('expedientes.nev')]='\App\Models\nna_vulnerabilidad';
        $objetos[config('expedientes.nes')]='\App\Models\nna_seguridad';
        return isset($objetos[$id_cat]) ? $objetos[$id_cat] : false;
    }

    public function getFmtTipoEntrevistaAttribute() {
        if(strlen($this->codigo)>8) {
            $x= substr($this->codigo,-8,2);
            return mb_strtoupper($x);
        }
        else {
            return false;
        }
    }
    public function getEntrevistaAttribute() {


        $tipo['VI']=config('expedientes.vi');
        $tipo['AA']=config('expedientes.vi');
        $tipo['TC']=config('expedientes.vi');
        $tipo['CO']=config('expedientes.co');
        $tipo['EE']=config('expedientes.co');
        $tipo['PR']=config('expedientes.pr');
        $tipo['DC']=config('expedientes.dc');
        $tipo['HV']=config('expedientes.hv');
        $tipo['CI']=config('expedientes.ci');
        $tipo['CT']=config('expedientes.ct');
        $tipo['CA']=config('expedientes.ca');
        $cual = $this->fmt_tipo_entrevista;

        if(isset($tipo[$cual])) {
            $clase = self::cual_clase($tipo[$cual]);
            if($clase) {
                if($tipo[$cual]==config('expedientes.ci')) {
                    $e = $clase::where('codigo',$this->codigo)->first();
                }
                else {
                    $e = $clase::where('entrevista_codigo',$this->codigo)->first();
                }

                return $e;
            }
            else {
                return false;
            }

        }
        else {
            return false;
        }

    }

    public static function scopePermisos($query) {
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        else {  //Todos los demas, con acceso al propio
            $query->where('id_usuario',\Auth::user()->id);
        }

    }

    //Recibe el id_subserie y devuelve el id_objeto
    public static function de_subserie_a_traza($id_subserie) {
        $arreglo[config('expedientes.vi')]=1;
        $arreglo[config('expedientes.aa')]=1;
        $arreglo[config('expedientes.tc')]=1;
        $arreglo[config('expedientes.co')]=10;
        $arreglo[config('expedientes.ee')]=14;
        $arreglo[config('expedientes.pr')]=11;
        $arreglo[config('expedientes.dc')]=13;
        $arreglo[config('expedientes.hv')]=12;
        $arreglo[config('expedientes.mc')]=15;
        $arreglo[config('expedientes.ci')]=3;

        return isset($arreglo[$id_subserie]) ? $arreglo[$id_subserie] : null;

    }


    
}
