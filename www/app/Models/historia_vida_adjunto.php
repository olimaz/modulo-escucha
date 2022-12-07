<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_historia_vida_adjunto
 * @property int $id_historia_vida
 * @property int $id_adjunto
 * @property int $id_usuario
 * @property int $id_tipo
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.historiaVida $esclarecimiento.historiaVida
 * @property Esclarecimiento.adjunto $esclarecimiento.adjunto
 */
class historia_vida_adjunto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.historia_vida_adjunto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_historia_vida_adjunto';

    /**
     * @var array
     */
    protected $fillable = ['id_historia_vida', 'id_adjunto', 'id_usuario','id_tipo', 'created_at', 'updated_at'];

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if(\Auth::check()) {
            $this->attributes['id_usuario']=\Auth::user()->id;
        }

    }

    public function rel_id_adjunto() {
        return $this->belongsTo(adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_id_historia_vida() {
        return $this->belongsTo(historia_vida::class,'id_historia_vida','id_historia_vida');
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
    //Para mostrar si ya fué transcrito
    public function getFmtTranscritoAttribute() {
        if($this->id_tipo==2) {
            if(is_null($this->id_transcripcion)) {
                return "No";
            }
            elseif($this->id_transcripcion==0) {
                return "En cola";
            }
            elseif($this->id_transcripcion==-1) {
                return "Error en la transcripcion";
            }
            elseif($this->id_transcripcion >0) {
                $trans = historia_vida_adjunto::find($this->id_transcripcion);
                if($trans) {
                    return "Sí: $trans->url";
                }
                else {
                    return "Sí";
                }

            }
            else {
                return "No determinado";
            }
        }
        else {
            return "No aplica";
        }
    }

    public function getUrlAttribute() {
        $adjunto = adjunto::find($this->id_adjunto);
        $ubica="public/".$adjunto->ubicacion;
        if(Storage::exists($ubica)) {
            $url = "<a target='_blank' href='".action('adjuntoController@show_hv',$adjunto->id_adjunto)."'>$adjunto->nombre</a>";
        }
        else {
            $url = "$adjunto->nombre";
        }
        return $url;

    }
    //Revisa si es audio y si hay para streaming
    public function getUrlStreamAttribute() { //Para transmitir
        $link="";
        if($this->id_tipo==2) {
            $adjunto = adjunto::find($this->id_adjunto);
            if($adjunto) {
                return $adjunto->url_stream;
            }
        }
        return $link;
    }
    public function getUrlStreamCortoAttribute() { //Para transmitir
        $link="";
        if($this->id_tipo==2) {
            $adjunto = adjunto::find($this->id_adjunto);
            if($adjunto) {
                return $adjunto->url_stream_corto;
            }
        }
        return $link;
    }


    public static function listado_adjuntos($id_entrevista) {
        $listado = historia_vida_adjunto::where('id_historia_vida',$id_entrevista)
            ->join('catalogos.criterio_fijo as cf','id_tipo','=','id_opcion')
            ->where('id_grupo',1)
            ->orderby('orden')
            ->orderby('id_historia_vida_adjunto')->get();
        $arreglo=array();
        $entrevista = historia_vida::find($id_entrevista);
        foreach($listado as $archivo) {
            $adjunto = adjunto::find($archivo->id_adjunto);
            $item= array();
            $item['id_historia_vida_adjunto']=$archivo->id_historia_vida_adjunto;
            $item['id_adjunto']=$adjunto->id_adjunto;
            $item['adjunto']=$adjunto;
            $item['nombre']=$adjunto->nombre;
            $item['tipo']=$archivo->fmt_id_tipo;
            $item['id_tipo']=$archivo->id_tipo;
            $item['id_transcripcion']=$archivo->id_transcripcion;
            $item['transcrito']=$archivo->fmt_transcrito;
            $item['existe']=$adjunto->existe;
            $item['url_stream']=$archivo->url_stream;
            $item['url_stream_corto']=$archivo->url_stream_corto;

            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                $visor = $adjunto->url_visor();
                if($visor) {
                    $url=$visor;
                }
                else {
                    $url = action('adjuntoController@show_hv',$adjunto->id_adjunto);
                }
                $item['url']="<a target='_blank' href='".$url."'>$adjunto->nombre_hv</a>";

            }
            else {
                $item['url']="$adjunto->nombre_hv";
            }

            $item['tamano']=$adjunto->tamano;
            $item['fecha']=$adjunto->fecha;
            //$arreglo[]=$item;
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
     * Anexa un archivo cargado a una entrevista específica.
     * //Asume que el archivo ya se subió y está pendiente anexarlo a un expediente
     * @param int $id_entrevista
     * @param string $archivo
     * @param int $id_tipo
     * @return object
     */
    public static function adjuntar_archivo($id_entrevista, $archivo="", $control="", $nombre_orginal="", $otr='') {
        $entrevista = historia_vida::find($id_entrevista);
        $id_tipo = self::determinar_tipo($control);
        if($entrevista) {
            //2022-05-15: calificar
            $calificacion = self::calificar($entrevista,$id_tipo);
            //Fin de la calificacion
            $archivo = str_replace("/storage/","/",$archivo);  //Quitar /storage/ al inicio
            $adjunto = adjunto::create(['ubicacion'=>$archivo, 'nombre_original'=>$nombre_orginal]);
            $adjunto->tamano = $adjunto->tamano_bruto;
            $adjunto->md5 = $adjunto->calcular_hash();
            $adjunto->id_calificacion = $calificacion->id_calificacion;  //Se califica el adjunto
            $adjunto->save();
            $tmp['id_historia_vida'] = $id_entrevista;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=$id_tipo;
            $tmp['id_usuario'] = \Auth::id() ?? 2;
            $tmp['created_at']= Carbon::now();
            $adjunto_rel = historia_vida_adjunto::create($tmp);
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
                $adjunto->tamano = $adjunto->tamano_bruto;
                $adjunto->md5 = $adjunto->calcular_hash();
                $adjunto->id_calificacion = $calificacion->id_calificacion; //Calificar este tambien
                $adjunto->save();
                $tmp['id_adjunto']=$adjunto->id_adjunto;
                $adjunto_rel2 = historia_vida_adjunto::create($tmp);
                //Registrar traza
                traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$adjunto_rel2->id_adjunto,'referencia'=>"OTR automatico"]);
                //Justificar la calificacion
                foreach($calificacion->justificacion as $id_justificacion) {
                    adjunto_justificacion::create(['id_adjunto'=>$adjunto_rel2->id_adjunto, 'id_justificacion'=>$id_justificacion]);
                }
            }
            return $adjunto_rel;
        }
        else {
            return false;
        }
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

    //2022-05-17: Calificacion de los adjuntos
    public static function calificar($entrevista, $id_tipo) {
        $res = new \stdClass();
        $res->id_calificacion=null;
        $res->justificacion=[];
        if($entrevista->clasificacion_nna==1 || $entrevista->nna==1) { //NNA
            $res->id_calificacion=3;
            $res->justificacion=[7];
        }
        else { //todas las que no son NNA
            $res->id_calificacion=2;
            if(in_array($id_tipo,[1,21])) {
                $res->justificacion=[1,2];
            }
            elseif(in_array($id_tipo,[11,25])) {
                $res->justificacion=[1,3,4];
            }
            else {
                $res->justificacion=[1,2,3,4];
            }

        }
        return $res;
    }

    //Llama a la función de procesar el json en adjunto y lo mete a las tablas respectivas
    public function procesar_etiquetas() {
        $respuesta =new \stdClass();
        $respuesta->exito=false;
        $respuesta->etiquetas=0;
        $respuesta->marcas=0;
        $respuesta->a_marcas=array();
        $respuesta->json=null;
        $respuesta->error='';
        $respuesta->entrevista=0;
        //
        $a_id_etiquetas=array();

        $adjunto=$this->rel_id_adjunto;
        if($adjunto) {
            $entrevista = $this->rel_id_historia_vida;
            $etiquetas = $adjunto->procesar_json_etiquetado();
            if($etiquetas->exito) {
                etiqueta_entrevista::where('id_subserie',config('expedientes.hv'))->where('id_entrevista',$this->id_historia_vida)->delete();
                $respuesta->json=$etiquetas;
                // Ver que todas las etiquetas en el catalogo general
                foreach($etiquetas->a_etiquetas as $etiqueta) {
                    $respuesta->etiquetas++;
                    $existe_etiqueta = etiqueta::firstOrCreate(['etiqueta' => $etiqueta]);
                    $a_id_etiquetas[$etiqueta] = $existe_etiqueta->id_etiqueta;
                    //Actualizar el tesauro, si procede
                    $tes = tesauro::wherenull('id_etiqueta')->where('etiqueta_completa',$etiqueta)->first();
                    if($tes) {
                        $tes->id_etiqueta = $existe_etiqueta->id_etiqueta;
                        $tes->save();
                    }
                }

                //Crear detalle de etiquetas
                foreach($etiquetas->a_marcas as $etiqueta => $a_marca) {

                    $nuevo['id_etiqueta']=$a_id_etiquetas[$etiqueta];
                    $nuevo['id_entrevista']=$this->id_historia_vida;
                    $nuevo['id_subserie']=config('expedientes.hv');
                    foreach($a_marca as $marca) {
                        $nuevo['texto']=$marca['texto'];
                        $nuevo['del']=$marca['inicio'];
                        $nuevo['al']=$marca['fin'];
                        $nuevo['codigo']=$entrevista->entrevista_codigo;
                        $bd = new etiqueta_entrevista();
                        $bd->fill($nuevo);
                        $bd->save();
                        $respuesta->a_marcas[] = $bd;
                        $respuesta->marcas++;
                    }
                }

                //Actualizar la entrevista

                $entrevista->html_transcripcion = $etiquetas->json->content;
                $entrevista->json_etiquetado = $etiquetas->texto;
                $entrevista->save();
                $respuesta->entrevista=$entrevista;

            }
            else {
                $respuesta->error = $etiquetas->error;
                $respuesta->exito = false;
            }
        }
        else {
            $respuesta->error='No se pudo localizar el archivo adjunto';
            $respuesta->exito=false;
        }
        return $respuesta;

    }

}
