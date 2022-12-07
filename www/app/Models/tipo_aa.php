<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_geo
 * @property int $id_padre
 * @property int $nivel
 * @property string $descripcion
 * @property int $id_tipo
 * @property string $codigo
 * @property Fichas.hechoResponsabilidad[] $fichas.hechoResponsabilidads
 * @property Fichas.hechoResponsabilidad[] $fichas.hechoResponsabilidads
 * @property Fichas.hechoResponsabilidad[] $fichas.hechoResponsabilidads
 * @property Fichas.hechoResponsabilidad[] $fichas.hechoResponsabilidads
 */
class tipo_aa extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'catalogos.aa';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_geo';

    /**
     * @var array
     */
    protected $fillable = ['id_padre', 'nivel', 'descripcion', 'id_tipo', 'codigo'];

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

    // PAra abstaer la ordenada
    public function scopeOrdenar($query) {
        $query->orderby('codigo')->orderby('descripcion');
    }

    /**
     * Para llenar un control de la forma mas simple
     * @param null $id_padre
     * @return mixed
     */
    public static function listar_hijos($id_padre=null, $vacio="") {

        $nivel=0;
        //Para mostrar la descripción del lugar poblado

        if($id_padre>0) {
            $padre=self::find($id_padre);
            if($padre) {
                $nivel=$padre->nivel + 1;
            }
        }

        if($id_padre>0) {
            if($nivel ==3) {
                //$sql="select g.*, c.descripcion as tipo, concat(g.descripcion,' (',c.descripcion,')') as lugar_poblado
                $sql="select g.*, c.descripcion as tipo, g.descripcion as lugar_poblado
                            from catalogos.geo g left join catalogos.cat_item c on g.id_tipo=c.id_item
                            where id_padre=$id_padre
                            order by g.codigo, g.descripcion";
                $resultado = \DB::select($sql);
                $opciones=array();
                foreach($resultado as $fila) {
                    $opciones[$fila->id_geo] = $fila->lugar_poblado;
                }

            }
            else {
                $opciones=self::where('id_padre',$id_padre)->ordenar()->pluck('descripcion','id_geo')->toArray();
            }

        }
        elseif($id_padre==0) {  //Todos los de primer nivel
            $opciones=self::whereNull('id_padre')->ordenar()->pluck('descripcion','id_geo')->toArray();
        }
        else {  //Paso -1 para [Mostrar todos]
            $opciones=self::where('id_padre',$id_padre)->ordenar()->pluck('descripcion','id_geo')->toArray();
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



    //Devolver el nombre completo
    public static function nombre_completo($id_geo=0) {
        $existe = self::find($id_geo);
        if(!$existe) {
            $texto= "Identificador ($id_geo) no encontrado";
        }
        else {
            $texto = $existe->descripcion;
            if($existe->id_padre <> null) {
                $padre = self::nombrar($existe->id_padre);
                if($padre <> $texto) {
                    $texto = "$padre: $texto";
                    //$texto.=", ".$padre;
                }
                else {
                    $texto.=".";
                }

            }
            else {
                $texto.=".";
            }
        }
        return $texto;
    }
    //Devolver el nombre, sin ancestros
    public static function nombrar($id_geo=0) {
        $existe = self::find($id_geo);
        if(!$existe) {
            $texto= "Identificador ($id_geo) no encontrado";
        }
        else {
            $texto = $existe->descripcion;
        }
        return $texto;
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
