<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class enlace
 * @package App\Models
 * @version June 2, 2020, 1:52 pm -05
 *
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property integer id_subserie
 * @property integer id_primaria
 * @property integer id_subserie_e
 * @property integer id_primaria_e
 * @property integer id_tipo
 * @property integer id_entrevistador
 * @property string anotaciones
 * @property integer id_activo
 * @property string|\Carbon\Carbon fh_insert
 */
class enlace extends Model
{

    public $table = 'esclarecimiento.enlace';
    
    public $timestamps = false;



    protected $primaryKey = 'id_enlace';

    public $fillable = [
        'id_subserie',
        'id_primaria',
        'id_subserie_e',
        'id_primaria_e',
        'id_tipo',
        'id_entrevistador',
        'anotaciones',
        'id_activo',
        'fh_insert'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_enlace' => 'integer',
        'id_subserie' => 'integer',
        'id_primaria' => 'integer',
        'id_subserie_e' => 'integer',
        'id_primaria_e' => 'integer',
        'id_tipo' => 'integer',
        'id_entrevistador' => 'integer',
        'anotaciones' => 'string',
        'id_activo' => 'integer',
        //'fh_insert' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_subserie' => 'required',
        'id_primaria' => 'required',
        //'id_subserie_e' => 'required',
        //'id_primaria_e' => 'required',
        //'id_entrevistador' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }
    public function scopeActivos($query) {
        $query->where('id_activo',1);
    }
    //Para el index
    public function scopeOrdenar($query){
        $query->orderby('fh_insert')->orderby('id_subserie');
    }
    public function getFmtIdEntrevistadorAttribute() {
        $quien = $this->rel_id_entrevistador;
        if($quien) {
            return $quien->fmt_numero_nombre;
        }
        else {
            return "Desconocido ($this->id_entrevistador)";
        }
    }
    public function getFmtFhInsertAttribute() {
        //return substr($this->fh_insert,0,19);
        $fecha = Carbon::createFromFormat("Y-m-d H:i:s.u",$this->fh_insert);
        return $fecha->format('d-m-Y H:i');
    }

    //Devuelve el código de la entrevista primaria
    public function getFmtPrimariaAttribute() {
        return self::buscar_llaves($this->id_subserie,$this->id_primaria);
    }
    public function getFmtSecundariaAttribute() {
        return self::buscar_llaves($this->id_subserie_e,$this->id_primaria_e);
    }

    public function getFmtIdTipoAttribute() {
        $txt = criterio_fijo::describir(20,$this->id_tipo);
        $e = entrevistador::find($this->id_entrevistador);
        $txt.= "<span data-toggle='tooltip' title='Número del entrevistador que hizo el relacionamiento'> (E#$e->fmt_numero_entrevistador)</span>";
        return $txt;
    }
    public function getFmtIdTipoSimpleAttribute() {
        $txt = criterio_fijo::describir(20,$this->id_tipo);

        return $txt;
    }


    //Llamado desde el controller store()  Devuelve el enlace creado, si procede
    public static function crear_nuevo($var) {
        $mensaje="Problemas al crear el enlace";
        $exito=false;
        $enlace=false;
        $codigo=$var['codigo'];

        $otra_e = enlace::buscar_codigo($codigo);

        if($otra_e) {  //Existe el código indicado
            if($otra_e->id_subserie == $var['id_subserie'] && $otra_e->id_primaria == $var['id_primaria'] ) {
                $exito=false;
                $mensaje="No se puede crear un enlace hacia la misma entrevista";
            }
            else {
                $var['id_subserie_e'] = $otra_e->id_subserie;
                $var['id_primaria_e'] = $otra_e->id_primaria;
                $var['id_entrevistador'] = \Auth::user()->id_entrevistador;
                $enlace = new enlace();
                $enlace->fill($var);
                $ya_hay_enlace = $enlace->buscar_enlaces();
                if(!$ya_hay_enlace) {
                    $enlace->save();
                    $exito=true;
                    $mensaje="Enlace creado exitosamente";
                }
                else {
                    $exito=false;
                    $mensaje="Ya existe un enlace con la entrevista $codigo";
                }
            }
        }
        else {
            $exito=false;
            $mensaje="No existe la entrevista con el código especificado ($codigo)";
        }
        if($enlace) {
            if($enlace->id_tipo == 2) {
                //Borrar la segunda entrevista
                $otra_e->e->id_activo = 2;
                $otra_e->e->save();
            }
        }
        $res = new \stdClass();
        $res->exito=$exito;
        $res->mensaje=$mensaje;
        $res->enlace=$enlace;
        return $res;
    }
    //Para no duplicar, busca ambas combinaciones (a->b, b->a)
    //Busca activos e inactivos
    public function buscar_enlaces() {
        $hay = enlace::where('id_subserie',$this->id_subserie)
                        ->where('id_primaria',$this->id_primaria)
                        ->where('id_subserie_e',$this->id_subserie_e)
                        ->where('id_primaria_e',$this->id_primaria_e)
                        ->activos()
                        ->first();
        if($hay) {
            return $hay;
        }
        else {
            $hay = enlace::where('id_subserie',$this->id_subserie_e)
                ->where('id_primaria',$this->id_primaria_e)
                ->where('id_subserie_e',$this->id_subserie)
                ->where('id_primaria_e',$this->id_primaria)
                ->activos()
                ->first();
            if($hay) {
                return true;
            }
            else {
                return false;
            }
        }
    }
    public static function listado_enlaces($id_subserie=0, $id_primaria=0) {
        $arreglo=array();
        $a =  enlace::where('id_subserie',$id_subserie)
                    ->where('id_primaria',$id_primaria)
                    ->activos()
                    ->get();
        foreach($a as $item) {
            $x=new \stdClass();
            $x->enlace = $item;
            $x->id_enlace = $item->id_enlace;
            $x->id_subserie = $item->id_subserie_e;
            $x->id_primaria = $item->id_primaria_e;
            $x->anotaciones = $item->anotaciones;

            $x->id_tipo = $item->id_tipo;
            $info = enlace::buscar_llaves($x->id_subserie,$x->id_primaria);
            if($info) {
                $x->codigo = $info->codigo;
                $x->link = $info->link_show;
                $x->titulo= $info->e->titulo;
                $arreglo[]=$x;
            }


        }
        $b =  enlace::where('id_subserie_e',$id_subserie)
            ->where('id_primaria_e',$id_primaria)
            ->activos()
            ->get();
        foreach($b as $item) {
            $x=new \stdClass();
            $x->enlace = $item;
            $x->id_enlace = $item->id_enlace;
            $x->id_subserie = $item->id_subserie;
            $x->id_primaria = $item->id_primaria;
            $x->anotaciones = $item->anotaciones;
            $x->id_tipo = $item->id_tipo;
            $info = enlace::buscar_llaves($x->id_subserie,$x->id_primaria);
            if($info) {
                $x->codigo = $info->codigo;
                $x->link = $info->link_show;
                $x->titulo= $info->e->titulo;
                $arreglo[]=$x;
            }
        }

        return $arreglo;
    }

    //Con base a 'id_subserie, id_primaria' busca la entrevista
    public static function buscar_llaves($id_subserie=0, $id_primaria=0) {
        $codigo=null;
        $link_show=null;
        $e=false;
        if($id_subserie == config('expedientes.vi')) {
            $e = entrevista_individual::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('entrevista_individualController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.aa')) {
            $e = entrevista_individual::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('entrevista_individualController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.tc')) {
            $e = entrevista_individual::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('entrevista_individualController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.co')) {
            $e = entrevista_colectiva::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('entrevista_colectivaController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.ee')) {
            $e = entrevista_etnica::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('entrevista_etnicaController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.pr')) {
            $e = entrevista_profundidad::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('entrevista_profundidadController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.dc')) {
            $e = diagnostico_comunitario::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('diagnostico_comunitarioController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.hv')) {
            $e = historia_vida::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('historia_vidaController@show',$id_primaria);
            }
        }
        elseif($id_subserie == config('expedientes.ci')) {
            $e = casos_informes::find($id_primaria);
            if($e) {
                $codigo=$e->entrevista_codigo;
                $link_show = action('casos_informesController@show',$id_primaria);
            }
        }

        if($e) {
            $res = new \stdClass();
            $res->e = $e;
            $res->codigo = $codigo;
            $res->link_show = $link_show;
            return $res;
        }
        else {
            return false;
        }


    }

    //Con base a codigo' busca la entrevista
    public static function buscar_codigo($codigo='') {
        $buscar=mb_strtolower($codigo);
        $id_subserie=0;
        $id_primaria=0;
        $link_show="";
        $llave_primaria="";
        $e=false;
        if(strlen($buscar)>=6) { // xxx-vi
            if(strstr($buscar,'-vi')){
                $e = entrevista_individual::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie=$e->id_subserie;
                    $id_primaria=$e->id_e_ind_fvt;
                    $llave_primaria="id_e_ind_fvt";
                    $link_show = action('entrevista_individualController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-aa')) {
                $e = entrevista_individual::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie=$e->id_subserie;
                    $id_primaria=$e->id_e_ind_fvt;
                    $llave_primaria="id_e_ind_fvt";
                    $link_show = action('entrevista_individualController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-tc')) {
                $e = entrevista_individual::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie=$e->id_subserie;
                    $id_primaria=$e->id_e_ind_fvt;
                    $llave_primaria="id_e_ind_fvt";
                    $link_show = action('entrevista_individualController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-co')) {
                $e = entrevista_colectiva::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie = config('expedientes.co');
                    $id_primaria=$e->id_entrevista_colectiva;
                    $llave_primaria="id_entrevista_colectiva";
                    $link_show = action('entrevista_colectivaController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-ee')) {
                $e = entrevista_etnica::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie = config('expedientes.ee');
                    $id_primaria=$e->id_entrevista_etnica;
                    $llave_primaria="id_entrevista_etnica";
                    $link_show = action('entrevista_etnicaController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-pr')) {
                $e = entrevista_profundidad::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie = config('expedientes.pr');
                    $id_primaria=$e->id_entrevista_profundidad;
                    $llave_primaria="id_entrevista_profundidad";
                    $link_show = action('entrevista_profundidadController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-dc')) {
                $e = diagnostico_comunitario::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie = config('expedientes.dc');
                    $id_primaria=$e->id_diagnostico_comunitario;
                    $llave_primaria="id_diagnostico_comunitario";
                    $link_show = action('diagnostico_comunitarioController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-hv')) {
                $e = historia_vida::entrevista_codigo($buscar)->first();
                if($e) {
                    $id_subserie = config('expedientes.hv');
                    $id_primaria=$e->id_historia_vida;
                    $llave_primaria="id_historia_vida";
                    $link_show = action('historia_vidaController@show',$id_primaria);
                }
            }
            elseif(strstr($buscar,'-ci')) {
                $e = casos_informes::codigo($buscar)->first();
                if($e) {
                    $id_subserie = config('expedientes.ci');
                    $id_primaria=$e->id_casos_informes;
                    $llave_primaria="id_casos_informes";
                    $link_show = action('casos_informesController@show',$id_primaria);
                }
            }
        }

        if($e) {
            $res = new \stdClass();
            $res->e = $e;
            $res->id_primaria = $id_primaria;
            $res->id_subserie = $id_subserie;
            $res->link_show = $link_show;
            $res->llave_primaria=$llave_primaria;

            return $res;
        }
        else {
            return false;
        }
    }

    //Borra el enlace y restablece la entrevista anulada si fuera necesario
    public function borrar() {

        if($this->id_tipo==2) {
            $a = enlace::buscar_llaves($this->id_subserie, $this->id_primaria);
            $a->e->id_activo=1;  //Des-borrar
            $a->e->save();
            $a = enlace::buscar_llaves($this->id_subserie_e, $this->id_primaria_e);
            $a->e->id_activo=1;  //Des-borrar
            $a->e->save();
        }
        $this->id_activo=2;
        $this->save();
    }

    public function getEntrevistaAttribute() {
        return enlace::buscar_llaves($this->id_subserie, $this->id_primaria);
    }




}
