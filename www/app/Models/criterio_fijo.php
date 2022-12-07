<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class criterio_fijo
 * @package App\Models
 * @version April 15, 2019, 4:41 pm UTC
 *

 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_grupo
 * @property integer id_opcion
 * @property string descripcion
 * @property integer orden
 */
class criterio_fijo extends Model
{

    public $table = 'catalogos.criterio_fijo';
    
    public $timestamps = false;



    public $fillable = [
        'id_grupo',
        'id_opcion',
        'descripcion',
        'orden'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_grupo' => 'integer',
        'id_opcion' => 'integer',
        'descripcion' => 'string',
        'orden' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_grupo' => 'required',
        'id_opcion' => 'required',
        'descripcion' => 'required',
        'orden' => 'required'
    ];

    public static function describir($id_grupo=0, $id_opcion=0) {
        if(is_null($id_opcion) || $id_opcion ==0) {
            return "Sin especificar";
        }
        $cual=self::where('id_grupo',$id_grupo)
                    ->where('id_opcion',$id_opcion)
                    ->first();
        if($cual) {
            return $cual->descripcion;
        }
        else {
            return "Desconocido ($id_grupo,$id_opcion)";
        }
    }

    //$excepcion_casos: casos especial del CF 126 y 127 que en casos_informes tiene mas opciones que en entrevistas
    public static function listado_items($id_grupo=1, $vacio="",$nulo='', $excepcion_entrevista=false) {
        $query=self::where('id_grupo',$id_grupo)
            ->orderby('orden')
            ->orderby('id_opcion');

        //Excepción para catalogo 126 y 127
        //Si $excepcion_entrevista=true, no se incluyen todas las opciones,
        // de lo contrario, es un caso_informe y las opciones son todas
        if(in_array($id_grupo,[126,127])) {
            if($excepcion_entrevista) {
                if($id_grupo==126) {
                    $query->where('id_opcion','<=',4);
                }
                elseif($id_grupo==127) {
                    $query->where('id_opcion','<=',10);
                }

            }
        }

       $listado = $query->pluck('descripcion','id_opcion')
            ->toArray();

        if(strlen($nulo)>0) {
            $listado = [0=>$nulo] + $listado;
            //$listado->prepend($nulo,null);
        }
        if(strlen($vacio)>0) {
            $listado = [-1=>$vacio] + $listado;
            //$listado->prepend($vacio,-1);
        }

        return $listado;
    }
    public static function listado_privilegios_validos() {
        $mi_nivel=\Auth::user()->id_nivel;
        $listado=self::where('id_grupo',4)
            ->where('id_opcion','>=',$mi_nivel)
            ->orderby('orden')
            ->orderby('id_opcion')
            ->pluck('descripcion','id_opcion');
        return $listado->toArray();
    }

    public static function listado_resultados_transcripcion() {
        $listado=self::where('id_grupo',8)
            ->wherein('id_opcion',[2,4])
            ->orderby('orden')
            ->orderby('id_opcion')
            ->pluck('descripcion','id_opcion');
        return $listado->toArray();
    }

    public static function listado_resultados_etiquetado() {
        $listado=self::where('id_grupo',9)
            ->wherein('id_opcion',[2,4])
            ->orderby('orden')
            ->orderby('id_opcion')
            ->pluck('descripcion','id_opcion');
        return $listado->toArray();
    }


}
