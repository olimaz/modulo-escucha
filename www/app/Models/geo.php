<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Arr;

/**
 * Class geo
 * @package App\Models
 * @version April 15, 2019, 4:41 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_padre
 * @property integer nivel
 * @property string descripcion
 * @property integer id_tipo
 * @property string codigo
 * @property string lat
 * @property string lon
 */
class geo extends Model
{

    public $table = 'catalogos.geo';
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
    public static function listar_hijos($id_padre=null, $vacio="", $otro_cual=true) {

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
                                and g.codigo <> 'reasignado'
                            order by g.descripcion";
                $resultado = \DB::select($sql);
                $opciones=array();
                foreach($resultado as $fila) {
                    $txt = $fila->lugar_poblado;
                    if($fila->codigo=='revisar') {
                        $txt.=" (pendiente de revisar)";
                    }
                    $opciones[$fila->id_geo] = $txt;
                }
                if($otro_cual) {
                    $opciones[-99] = 'Otro, ¿Cuál?';
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
    public static function json_select($id_padre=null,$elegido=null, $vacio="",$otro_cual=false) {
        //$id_padre=$request->depdrop_parents[0];
        $listado = self::listar_hijos($id_padre,$vacio,$otro_cual);

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
        if(intval($id_geo)<=0) {
            return "Sin especificar";
        }
        $existe = self::find($id_geo);
        if(!$existe) {
            $texto= "Identificador ($id_geo) no encontrado";
        }
        else {
            $texto = $existe->descripcion;
            if($existe->id_padre <> null) {
                //$texto.=", ".self::nombre_completo($existe->id_padre);
                $anterior = self::nombre_completo($existe->id_padre);
                if(strlen($anterior)>0) {
                    $texto = $anterior.", ".$texto;
                }

                //$texto=self::nombre_completo($existe->id_padre)." , ".$texto;
            }
            else {
                if(substr($existe->codigo,0,2) <> 'ii') {
                    $texto = "Colombia, $texto";
                }
                else {
                    $texto="";
                }
                //$texto="$texto - $existe->codigo";
            }
        }
        return $texto;
    }
    //Devolver el nombre, sin ancestros
    public static function nombrar($id_geo=0) {
        if(is_null($id_geo)) {
            return "Sin Especificar";
        }
        $existe = self::find($id_geo);
        if(!$existe) {
            $texto= "Identificador ($id_geo) no encontrado";
        }
        else {
            $texto = $existe->descripcion;
        }
        return $texto;
    }

    //Formato de codigo con guiones
    public function getFmtCodigoAttribute() {
        $codigo = $this->codigo;
        $codigo = strtolower($codigo);
        $nuevo="";
        $pedazos=[];
        if(substr($codigo,0,2)=='ii') {
            //Buscar codigo de pais y de ciudad
            $pedazos[] = $this->codigo_2;
        }
        else {
            $pedazos[] = "CO";
            $pedazos[]=substr($codigo,0,2);
            $pedazos[]=substr($codigo,2,3);
            $pedazos[]=substr($codigo,5,3);
        }
        $armar=[];
        foreach($pedazos as $tmp) {
            if(strlen($tmp)>0) {
                $armar[]=$tmp;
            }
        }
        return implode("-",$armar);
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


    public static function reasignar($viejo, $nuevo) {
        if($viejo>0 and $nuevo > 0) {

            $geo = geo::find($viejo);
            if($geo) {
                $existe = geo::find($nuevo);
                if(!$existe) {
                    return "No existe id_geo=$nuevo";
                }
                $codigo = $geo->codigo; //Para la traza
                //Actualizar codigo en geo
                $geo->codigo='reasignado';
                $geo->save();
                //Aplicar la reasignacion
                $listado = geo_reasignar::get();
                $total=0;
                foreach($listado as $campo) {
                    $tabla = $campo->esquema.".".$campo->tabla;
                    $conteo = \DB::table($tabla)
                                ->where($campo->campo,$viejo)
                                ->update([$campo->campo => $nuevo]);
                    $total+=$conteo;
                }
                $referencia = "de $viejo a $nuevo:$total sustituciones";
                traza_actividad::create(['id_accion'=>4,'id_objeto'=>31,'id_primaria'=>$viejo, 'referencia'=>$referencia, 'codigo'=>$codigo]);
                return $total;
            }
            else {
                return "No existe id_geo=$viejo";
            }

        }
        else {
            return "Valores inválidos: de $viejo a $nuevo";
        }
    }

    public static function aplicar_codigo_internacional() {
        $sql = "select n1.descripcion as depto, n1.codigo as depto_codigo, n1.id_geo as id_depto, n2.descripcion as muni, n2.codigo as muni_codigo, n2.id_geo as id_muni, n3.descripcion as revisar, n3.id_geo, n3.codigo
                    from catalogos.geo n3
                        join catalogos.geo n2 on n3.id_padre=n2.id_geo
                        join catalogos.geo n1 on n2.id_padre=n1.id_geo
                    WHERE n1.codigo ilike 'ii%'  and  n3.codigo ilike 'revisar' 
                    order by n1.codigo, n2.codigo;
                ";
        $listado = \DB::select($sql);
        $conteo=0;
        $arreglo=array();
        foreach($listado as $fila) {
            $codigo_muni = $fila->muni_codigo;
            $ultimo = geo::where('nivel',3)
                            ->where('id_padre',$fila->id_muni)
                            ->where('codigo','ilike',"$codigo_muni%")
                            ->orderby('codigo','desc')
                            ->first();
            if($ultimo) {
                $numero=intval(substr($ultimo->codigo,5));
            }
            else {
                $numero=0;
            }
            $numero++;
            $codigo =str_pad($numero,3,"0",STR_PAD_LEFT);
            $nuevo_codigo = $codigo_muni.$codigo;
            $cambio = geo::find($fila->id_geo);
            $cambio->codigo = $nuevo_codigo;
            $cambio->save();
            //Pruebas:
            $tmp = new \stdClass();
            $tmp->id_geo = $fila->id_geo;
            $tmp->cod_muni = $fila->muni_codigo;
            $tmp->cod_viejo = $fila->codigo;
            $tmp->cod_nuevo = $nuevo_codigo;
            $arreglo[]=$tmp;

            $conteo++;
        }
        $r = new \stdClass();
        $r->cambios = $arreglo;
        $r->conteo=$conteo;
        return $r;
    }

}
