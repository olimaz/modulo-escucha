<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class casos_informes_adjunto extends Model
{
    //
    public $table = 'esclarecimiento.casos_informes_adjunto';
    protected $primaryKey = 'id_casos_informes_adjunto';

    public $timestamps = false;



    public $fillable = [
        'id_casos_informes',
        'id_adjunto',
        'id_tipo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_casos_informes' => 'integer',
        'id_adjunto' => 'integer',
        'id_tipo' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_casos_informes' => 'required',
        'id_adjunto' => 'required',
    ];

    public function rel_id_adjunto() {
        return $this->belongsTo(adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_id_casos_informes() {
        return $this->belongsTo(casos_informes::class,'id_casos_informes','id_casos_informes');
    }

    public function getFmtIdTipoAttribute() {
        return criterio_fijo::describir(1,$this->id_tipo);
    }

    //Para ahorrarme estar revisando
    public function getFmtNombreAttribute() {
        $adjunto = $this->rel_id_adjunto;
        if($adjunto) {
            return $adjunto->ubicacion;
        }
        else {
            return "";
        }
    }


    public static function listado_adjuntos($id_casos_informes) {
        $listado = casos_informes_adjunto::where('id_casos_informes',$id_casos_informes)
            ->join('catalogos.criterio_fijo as cf','id_tipo','=','id_opcion')
            ->where('id_grupo',1)
            ->orderby('orden')
            ->orderby('id_casos_informes_adjunto')->get();
        $arreglo=array();
        foreach($listado as $archivo) {
            $adjunto = adjunto::find($archivo->id_adjunto);
            $item= array();
            $item['id_casos_informes_adjunto']=$archivo->id_casos_informes_adjunto;
            $item['id_adjunto']=$adjunto->id_adjunto;
            $item['nombre']=$adjunto->nombre;
            $item['tipo']=$archivo->fmt_id_tipo;
            $item['id_tipo']=$archivo->id_tipo;
            $item['adjunto']=$adjunto;
            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                //$visor = $adjunto->url_visor();
                $visor = false; //desactivado el 20-04-20
                if($visor) {
                    $url=$visor;
                }
                else {
                    $url = action('adjuntoController@show',$adjunto->id_adjunto);
                }
                $item['url']="<a target='_blank' href='".$url."'>$adjunto->nombre</a>";
            }
            else {
                $item['url']="$adjunto->nombre";
            }

            $item['tamano']=$adjunto->tamano;
            $item['fecha']=$adjunto->fecha;
            //$arreglo[]=$item;
            //Ocultar los otranscribe para todos menos para transcriptores
            if($item['id_tipo']==16) { //otranscribe
                if(\Gate::allows('nivel-10-al-11')) {
                    $arreglo[]=$item;
                }
            }
            else {
                $arreglo[]=$item;
            }
        }

        return $arreglo;
    }



    /**
     * Anexa un archivo cargado a un caso específico.
     * //Asume que el archivo ya se subió y está pendiente anexarlo a un expediente que ya existe
     * @param int $id_casos_informes
     * @param string $archivo
     * @param int $id_tipo
     * @return object
     */
    public static function adjuntar_archivo($id_casos_informes, $archivo="", $control="",  $nombre_orginal="", $otr='') {
        $caso = casos_informes::find($id_casos_informes);
        $id_tipo = self::determinar_tipo($control);
        if($caso) {
            //2022-05-15: calificar
            $calificacion = self::calificar($caso,$id_tipo);
            //Fin de la calificacion
            $archivo = str_replace("/storage/","/",$archivo);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo, 'nombre_original'=>$nombre_orginal]);
            $adjunto->tamano = $adjunto->tamano_bruto;
            $adjunto->md5 = $adjunto->calcular_hash();
            $adjunto->id_calificacion = $calificacion->id_calificacion;  //Se califica el adjunto
            $adjunto->save();
            $tmp['id_casos_informes'] = $id_casos_informes;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=$id_tipo;
            $adjunto_rel = casos_informes_adjunto::create($tmp);
            //Justificar la calificacion
            foreach($calificacion->justificacion as $id_justificacion) {
                adjunto_justificacion::create(['id_adjunto'=>$adjunto->id_adjunto, 'id_justificacion'=>$id_justificacion]);
            }
            if(strlen($otr)>0) {
                //Cambiarlo a tipo otr
                $adjunto_rel->id_tipo=16;
                $adjunto_rel->save();
                //Crear nuevo adjunto
                $otr = str_replace("/storage/","/",$otr);  //Quitar /storage/ al inicio
                $adjunto = adjunto::create(['ubicacion'=>$otr, 'nombre_original'=>$nombre_orginal]);
                $tmp['id_adjunto']=$adjunto->id_adjunto;
                $adjunto_rel2 = casos_informes_adjunto::create($tmp);
            }
            return $adjunto_rel;
        }
        else {
            return false;
        }
    }

    public static function calificar($entrevista, $id_tipo) {
        $res = new \stdClass();
        $res->id_calificacion=null;
        $res->justificacion=[];
        if($entrevista->clasifica_nna==1 || $entrevista->nna==1) { //NNA
            $res->id_calificacion=3;
            $res->justificacion=[7];
        }
        else {
            $res->id_calificacion=2;
            if($id_tipo==1) {
                $res->justificacion=[1,2];
            }
            else {
                $res->justificacion=[1,2,3,4];
            }
        }
        return $res;
    }

    //Basado en un texto tipo "adjunto_4" me devuelve 4, que equivale a un criterio fijo
    public static function determinar_tipo($control="") {
        $tmp = explode("_",$control);
        if(isset($tmp[1])) {
            $id_tipo=$tmp[1];
        }
        else {
            $id_tipo=4; //otros
        }
        return $id_tipo;
    }
}
