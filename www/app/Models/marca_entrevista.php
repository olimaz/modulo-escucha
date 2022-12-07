<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Gate;

/**
 * Class marca_entrevista
 * @package App\Models
 * @version February 20, 2020, 12:47 am -05
 *

 * @property integer id_subserie
 * @property integer id_entrevista
 * @property integer id_entrevistador
 * @property integer id_marca
 */
class marca_entrevista extends Model
{

    public $table = 'esclarecimiento.marca_entrevista';
    protected $primaryKey = 'id_marca_entrevista';
    public $timestamps = false;



    public $fillable = [
        'id_subserie',
        'id_entrevista',
        'id_entrevistador',
        'id_marca'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_marca_entrevista' => 'integer',
        'id_subserie' => 'integer',
        'id_entrevista' => 'integer',
        'id_entrevistador' => 'integer',
        'id_marca' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_marca_entrevista' => 'required',
        'id_subserie' => 'required',
        'id_entrevista' => 'required',
        //'id_entrevistador' => 'required',
        //'id_marca' => 'required'
    ];

    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
    }

    public function rel_id_marca() {
        return $this->belongsTo(marca::class,'id_marca','id_marca');
    }

    public function getEntrevistaEnlaceAttribute() {
        return enlace::buscar_llaves($this->id_subserie, $this->id_entrevista);
    }


    public function getEntrevistaAttribute() {
        $detalles = enlace::buscar_llaves($this->id_subserie, $this->id_entrevista);
        return $detalles->e;

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


    /*
     * FILTROS y buscadores
     */
    // SCOPES: filtros y criterios de ordenado
    public static function filtros_default($request = null) {
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->id_subserie = -1;
        $filtro->id_entrevista = -1;
        $filtro->id_marca = array();  //Esta propiedad es parte de la tabla
        $filtro->id_entrevistador = -1;
        $filtro->texto = null;


        // Actualizar valores del REQUEST
        $filtro->id_subserie = isset($request->id_subserie) ? $request->id_subserie : $filtro->id_subserie;
        $filtro->id_entrevista = isset($request->id_entrevista) ? $request->id_entrevista : $filtro->id_entrevista;
        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;
        $filtro->id_marca = isset($request->id_marca) ? $request->id_marca : $filtro->id_marca;
        $filtro->texto = isset($request->texto) ? $request->texto : $filtro->texto;


        if(\Auth::check()) {
            $filtro->id_entrevistador = \Auth::user()->id_entrevistador;
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
        $query->orderby('fh_autorizado')
            ->orderby('id_marca');
    }
    public static function scopeId_Subserie($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('marca_entrevista.id_subserie',$criterio);
        }
    }
    public static function scopeId_Entrevista($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('marca_entrevista.id_entrevista',$criterio);
        }
    }
    public static function scopeId_Entrevistador($query, $criterio=-1) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                $query->wherein('marca_entrevista.id_entrevistador',$criterio);
            }
        }
        elseif($criterio>0) {
            $query->where('marca_entrevista.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_Marca($query, $criterio=-1) {
        if(is_array($criterio)) {
            if(count($criterio)>0) {
                $query->wherein('marca_entrevista.id_marca',$criterio);
            }
        }
        elseif($criterio>0) {
            $query->where('marca_entrevista.id_marca',$criterio);
        }
    }

    public static function scopeTexto($query, $txt=null) {
        $txt=trim($txt);
        if(strlen($txt)>0) {
            $query->join('esclarecimiento.marca as fm','marca_entrevsita.id_marca','=','fm.id_marca')
                    ->where('fm.texto','ilike',"%$txt%");
        }
    }
    public static function scopeFiltrar($query,$filtros=0) {
        if(!is_object($filtros)) {
            $filtros=marca_entrevista::filtros_default();
        }
        $query->id_subserie($filtros->id_subserie)
                ->id_entrevista($filtros->id_entrevista)
                ->id_entrevistador($filtros->id_entrevistador)
                ->id_marca($filtros->id_marca);

    }


    public static function listar_marcas_entrevistador($id_entrevistador=0) {
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }

        $arreglo = marca_entrevista::id_entrevistador($id_entrevistador)
                            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
                            ->orderBy('texto')
                            ->pluck('texto','m.id_marca')
                            ->toArray();
        return $arreglo;
    }
    //Para la buscadora, listado de marcas y veces que fué aplicada
    public static function listar_uso_marcas($id_entrevistador=0) {
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }

        $res = marca_entrevista::id_entrevistador($id_entrevistador)
            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
            ->select(\DB::raw("m.id_marca, m.texto, count(1) as conteo"))
            ->groupby('m.id_marca')
            ->groupby('m.texto')
            ->orderBy('texto')
            ->get();
        return $res;
    }
    //Para los formularios de filtros
    public static function listar_marcas_grupo($id_entrevistador=0) {
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }

        $otros = entrevistador::join('esclarecimiento.marca_grupo_entrevistador as ge','entrevistador.id_entrevistador','=','ge.id_entrevistador')
            ->join('esclarecimiento.marca_grupo as g','ge.id_marca_grupo','=','g.id_marca_grupo')
            ->join('esclarecimiento.marca_grupo_entrevistador as e','g.id_marca_grupo','=','e.id_marca_grupo')
            ->where('ge.id_entrevistador','=', $id_entrevistador)
            //->where('e.id_entrevistador','<>', $id_entrevistador)
            ->distinct()
            ->pluck('e.id_entrevistador')
            ->toArray();

        if(count($otros) <= 0) {
            $otros[]=$id_entrevistador;
        }



        $listado = marca_entrevista::id_entrevistador($otros)
            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
            ->orderBy('texto')
            ->get();
            //->pluck('texto','m.id_marca')
            //->toArray();
        $arreglo=array();
        foreach($listado as $fila) {
            if($fila->id_entrevistador==$id_entrevistador) {
                $arreglo[$fila->id_marca] = $fila->texto;
            }
            else {
                $arreglo[$fila->id_marca] = $fila->texto. " [Grupo]";
            }
         }
        return $arreglo;
    }

    public static function listar_marcas_aplicadas($id_subserie,$id_entrevista,$id_entrevistador=0) {
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }

        $arreglo = marca_entrevista::id_entrevistador($id_entrevistador)
            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
            ->orderBy('texto')
            ->id_subserie($id_subserie)
            ->id_entrevista($id_entrevista)
            ->pluck('m.id_marca')
            ->toArray();
        return $arreglo;
    }


    //Funcionamiento interno
    public static function procesar_marcas($request) {
        $id_entrevista=$request->id_entrevista;
        $id_subserie = $request->id_subserie;
        $id_entrevistador=0;
        $conteo=0;
        if(\Auth::check()) {
            $id_entrevistador = \Auth::user()->id_entrevistador;
        }
        if($id_entrevistador>0) {
            marca_entrevista::Id_Entrevista($id_entrevista)
                                ->id_subserie($id_subserie)
                                ->id_entrevistador($id_entrevistador)
                                ->delete();
            if(is_array($request->marca)) {
                $a_marcas =  $a_marcas = marca::crear_marcas($request->marca);
                foreach($a_marcas as $texto) {
                    $marca = new marca_entrevista();
                    $marca->id_entrevista = $id_entrevista;
                    $marca->id_subserie = $id_subserie;
                    $marca->id_entrevistador = $id_entrevistador;
                    $marca->id_marca = $texto->id_marca;
                    try {
                        $marca->save();
                        $conteo++;
                    }
                    catch (\Exception $e) {
                        //No pasa nada
                    }

                }
            }

        }
        return $conteo;

        //Borrar anteriores

    }

    //Para el index de c/tipo de entrevista
    public static function listado_marcas($id_subserie,$id_entrevista,$id_entrevistador=0) {
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }

        $otros = entrevistador::join('esclarecimiento.marca_grupo_entrevistador as ge','entrevistador.id_entrevistador','=','ge.id_entrevistador')
                                    ->join('esclarecimiento.marca_grupo as g','ge.id_marca_grupo','=','g.id_marca_grupo')
                                    ->join('esclarecimiento.marca_grupo_entrevistador as e','g.id_marca_grupo','=','e.id_marca_grupo')
                                    ->where('ge.id_entrevistador','=', $id_entrevistador)
                                    //->where('e.id_entrevistador','<>', $id_entrevistador)
                                    ->distinct()
                                    ->pluck('e.id_entrevistador')
                                    ->toArray();

        if(count($otros) <= 0) {
            $otros[]=$id_entrevistador;
        }



        $listado = marca_entrevista::id_entrevistador($otros)
            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
            ->join('esclarecimiento.entrevistador','marca_entrevista.id_entrevistador','=','entrevistador.id_entrevistador')
            ->join('users','entrevistador.id_usuario','=','users.id')
            ->orderBy('texto')
            ->id_subserie($id_subserie)
            ->id_entrevista($id_entrevista)
            //->select('m.texto', 'm.id_marca','m.id_entrevistador')
            ->get();


        $url=action('entrevista_individualController@index')."?id_subserie=$id_subserie";

        if($id_subserie == config('expedientes.vi')) {
            $url=action('entrevista_individualController@index')."?id_subserie=$id_subserie";
        }
        elseif($id_subserie == config('expedientes.aa')) {
            $url=action('entrevista_individualController@index')."?id_subserie=$id_subserie";
        }
        elseif($id_subserie == config('expedientes.tc')) {
            $url=action('entrevista_individualController@index')."?id_subserie=$id_subserie";
        }
        elseif($id_subserie == config('expedientes.co')) {
            $url=action('entrevista_colectivaController@index')."?yyz=2112";
        }
        elseif($id_subserie == config('expedientes.ee')) {
            $url=action('entrevista_etnicaController@index')."?yyz=2112";
        }
        elseif($id_subserie == config('expedientes.pr')) {
            $url=action('entrevista_profundidadController@index')."?yyz=2112";
        }
        elseif($id_subserie == config('expedientes.dc')) {
            $url=action('diagnostico_comunitarioController@index')."?yyz=2112";
        }
        elseif($id_subserie == config('expedientes.hv')) {
            $url=action('historia_vidaController@index')."?yyz=2112";
        }

        $link=array();
        foreach($listado as $fila) {
            $color = $fila->id_entrevistador == $id_entrevistador ? 'text-success' : 'text-warning';
            $tooltip = $fila->id_entrevistador <> $id_entrevistador ? " title='Marca de: $fila->name' " : ' title="Marca propia" ';

            $link[]="<a href='$url&marca[]=$fila->id_marca' class='$color' $tooltip data-toggle='tooltip'>$fila->texto</a>";

        }


        $texto = implode(";  ",$link);
        return $texto;
    }


    //Igual que el anterior, pero para buscadora
    public static function listado_marcas_buscadora($id_subserie,$id_entrevista,$id_entrevistador=0) {
        if($id_entrevistador==0) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }

        $otros = entrevistador::join('esclarecimiento.marca_grupo_entrevistador as ge','entrevistador.id_entrevistador','=','ge.id_entrevistador')
            ->join('esclarecimiento.marca_grupo as g','ge.id_marca_grupo','=','g.id_marca_grupo')
            ->join('esclarecimiento.marca_grupo_entrevistador as e','g.id_marca_grupo','=','e.id_marca_grupo')
            ->where('ge.id_entrevistador','=', $id_entrevistador)
            //->where('e.id_entrevistador','<>', $id_entrevistador)
            ->distinct()
            ->pluck('e.id_entrevistador')
            ->toArray();

        if(count($otros) <= 0) {
            $otros[]=$id_entrevistador;
        }
        //dd($otros);



        $query = marca_entrevista::id_entrevistador($otros)
            ->join('esclarecimiento.marca as m','marca_entrevista.id_marca','=','m.id_marca')
            ->join('esclarecimiento.entrevistador','marca_entrevista.id_entrevistador','=','entrevistador.id_entrevistador')
            ->join('users','entrevistador.id_usuario','=','users.id')
            ->orderBy('texto')
            ->id_subserie($id_subserie)
            ->id_entrevista($id_entrevista);

        //$debug['sql']= nl2br($query->toSql());
        //$debug['criterios']=$query->getBindings();
        //dd($debug);


        $listado = $query->get();

        //dd($listado);



        $url= \Request::url();
        $link=array();
        foreach($listado as $fila) {
            $color = $fila->id_entrevistador == $id_entrevistador ? 'text-success' : 'text-warning';
            $tooltip = $fila->id_entrevistador <> $id_entrevistador ? " title='Marca de: $fila->name' " : ' title="Marca propia" ';

            $link[]="<a href='$url?marca[]=$fila->id_marca' class='$color' $tooltip data-toggle='tooltip'>$fila->texto</a>";

        }


        $texto = implode(";  ",$link);
        return $texto;
    }







}
