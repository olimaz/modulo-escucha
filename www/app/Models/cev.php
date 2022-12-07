<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class cev
 * @package App\Models
 * @version May 16, 2019, 4:41 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection
 * @property \Illuminate\Database\Eloquent\Collection
 * @property integer id_padre
 * @property integer nivel
 * @property string descripcion
 * @property integer id_tipo
 * @property string codigo
 */

class cev extends Model
{
    public $table = 'catalogos.cev';
    protected $primaryKey = 'id_geo';

    public $timestamps = false;



    public $fillable = [
        'id_padre',
        'nivel',
        'descripcion',
        'id_tipo',
        'codigo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_geo' => 'integer',
        'id_padre' => 'integer',
        'nivel' => 'integer',
        'descripcion' => 'string',
        'id_tipo' => 'integer',
        'codigo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_geo' => 'required',
        'nivel' => 'required',
        'descripcion' => 'required'
    ];

    // PAra abstaer la ordenada
    public function scopeOrdenar($query) {
        $query->orderby('descripcion');
    }

    /**
     * Para llenar un control de la forma mas simple
     * @param null $id_padre
     * @return mixed
     */
    public static function listar_hijos($id_padre=null, $vacio="") {

        if(is_null($id_padre)) {
            $id_padre=0;
        }

        if($id_padre>0) {
            $padre=self::find($id_padre);
            if($padre) {
                $nivel=$padre->nivel + 1;
            }
        }


        if($id_padre<>0) {
            $opciones=self::where('id_padre',$id_padre)->ordenar()->pluck('descripcion','id_geo')->toArray();
        }
        else {  //Todos los de primer nivel
            $opciones=self::whereNull('id_padre')->ordenar()->pluck('descripcion','id_geo')->toArray();
        }



        if(strlen($vacio)>0) {
            $opciones = [-1=>$vacio] + $opciones;
        }


        return $opciones;
    }

    /**
     * PAra el JSON del control dependiente
     */
    public static function json_select($id_padre=null,$elegido=null, $vacio="") {
        //$id_padre=$request->depdrop_parents[0];
        $listado = self::listar_hijos($id_padre,$vacio);

        //preparar arreglo de acuerdo a http://plugins.krajee.com/dependent-dropdown/demo

        $nuevo=array();
        if($elegido==null and $vacio<>"") {
            $elegido=-1;
        }
        foreach($listado as $key=>$value) {
            $nuevo[]=array('id'=>$key,'name'=>$value);
        }

        $json['output']=$nuevo;

        //si viene un predeterminado, ver que exista y agregarlo
        if(array_key_exists($elegido,$listado)) {
            $json['selected']=$elegido;
        }
        elseif(strlen($vacio)>0) {
            //$json['selected']=0;
        }

        return $json;
    }



    //Devolver el nombre completo, funcion recursiva
    public static function nombre_completo($id_geo=0) {
        $existe = self::find($id_geo);
        if(!$existe) {
            $texto= "Identificador ($id_geo) no encontrado";
        }
        else {
            $texto = $existe->descripcion;
            if($existe->id_padre <> null) {
                $texto.=", ".self::nombre_completo($existe->id_padre);
            }
            else {
                $texto.=".";
            }
        }
        return $texto;
    }

    public static function describir($id_geo=0) {
        if($id_geo>0) {
            $existe = self::find($id_geo);
            if($existe) {
                return $existe->descripcion;
            }
            else {
                return "Identificador ($id_geo) no encontrado";
            }
        }
        else {
            return "Sin especificar ($id_geo)";
        }
    }

    //PAra los queries geograficos, considerar el arbol (para muni, todos los lp, para depto, todos los muni y todos los lp)
    public static function arreglo_contenidos($id_geo) {
        $lugares=array(); //Arreglo final
        $hijos=array();
        $nietos=array();

        $cual=self::find($id_geo);
        if($cual) {
            $lugares[]=$id_geo; //Agregar el que busco, siempre debe de estar
            if($cual->nivel==2) {
                $hijos=self::where('id_padre',$id_geo)->orderby('id_geo')->pluck('id_geo');
                foreach($hijos as $id_geo) { //por las malas
                    $lugares[]=$id_geo;
                }

            }
            elseif($cual->nivel==1) {
                $hijos=self::where('id_padre',$id_geo)->orderby('id_geo')->pluck('id_geo');
                $nietos = self::wherein('id_padre',$hijos)->orderby('id_geo')->pluck('id_geo');
                foreach($hijos as $id_geo) { //por las malas
                    $lugares[]=$id_geo;
                }
                foreach($nietos as $id_geo) { //por las malas
                    $lugares[]=$id_geo;
                }
            }
        }
        return $lugares;
    }
}
