<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_entrevista_etnica_adjunto
 * @property int $id_entrevista_etnica
 * @property int $id_adjunto
 * @property int $id_tipo
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.entrevistaEtnica $esclarecimiento.entrevistaEtnica
 * @property Esclarecimiento.adjunto $esclarecimiento.adjunto
 */
class entrevista_etnica_adjunto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_etnica_adjunto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_etnica_adjunto';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_etnica', 'id_adjunto', 'id_tipo', 'id_usuario', 'created_at', 'updated_at'];

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
    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
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
                $trans = entrevista_etnica_adjunto::find($this->id_transcripcion);
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
        $listado = entrevista_etnica_adjunto::where('id_entrevista_etnica',$id_entrevista)
            ->join('catalogos.criterio_fijo as cf','id_tipo','=','id_opcion')
            ->where('id_grupo',1)
            ->orderby('orden')
            ->orderby('id_entrevista_etnica_adjunto')->get();
        $arreglo=array();
        $entrevista = entrevista_etnica::find($id_entrevista);
        foreach($listado as $archivo) {
            $adjunto = adjunto::find($archivo->id_adjunto);
            $item= array();
            $item['id_entrevista_etnica_adjunto']=$archivo->id_entrevista_etnica_adjunto;
            $item['id_adjunto']=$adjunto->id_adjunto;
            $item['adjunto']=$adjunto;
            //$item['nombre']=$adjunto->nombre_ee;
            $item['nombre']=$adjunto->nombre_ee;
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
                    $url = action('adjuntoController@show_ee',$adjunto->id_adjunto);
                }
                $item['url']="<a target='_blank' href='".$url."'>$adjunto->nombre_ee</a>";
            }
            else {
                $item['url']="$adjunto->nombre";
            }
            /*
            if($archivo->id_tipo ==2) { //Audio
                if(\Auth::user()->cannot('es-propio',$entrevista->id_entrevistador)) {
                    if(\Auth::user()->can('solo-lectura')) {
                        $item['url']="<i class='text-warning'>Acceso restringido por perfil del usuario</i>";
                        $item['url_stream']=""; //Para que no lo muestre la tabla
                    }
                }
            }
            */
            $item['tamano']=$adjunto->tamano;
            $item['fecha']=$adjunto->fecha;
            if($item['id_tipo']==16) { //otranscribe
                if(\Gate::allows('nivel-10-al-11')) {
                    $arreglo[]=$item;
                }
            }
            else {
                $arreglo[]=$item;
            }
            //$arreglo[]=$item;
        }

        return $arreglo;
    }



    /**
     * Anexa un archivo cargado a una entrevista específica.
     * //Asume que el archivo ya se subió y está pendiente anexarlo a un expediente
     * @param int $id_entrevista
     * @param string $archivo
     * @param string $control
     * @param string $nombre_orginal
     * @param string $otr
     * @return object
     */
    public static function adjuntar_archivo($id_entrevista, $archivo="", $control="", $nombre_orginal="", $otr='') {
        $entrevista = entrevista_etnica::find($id_entrevista);
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
            $tmp['id_entrevista_etnica'] = $id_entrevista;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=$id_tipo;
            $tmp['created_at']= Carbon::now();
            $adjunto_rel = entrevista_etnica_adjunto::create($tmp);
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
                $adjunto_rel2 = entrevista_etnica_adjunto::create($tmp);
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


    /*
     * TRANSCRIBIR CON GOOGLE
     */



    public function transcribir() {
        $adjunto =$this->rel_id_adjunto;
        $entrevista = $this->rel_id_entrevista_etnica;
        //Llamar al webservice
        $transcribir = $adjunto->transcribir( $entrevista->entrevista_codigo);
        //dd($transcribir);


        //Siempre se registra en la cola, así sea con estado de error

        $cola = new control_transcripcion();
        $cola->id_subserie = config('expedientes.ee');
        $cola->id_primaria = $this->id_entrevista_etnica_adjunto;
        $cola->fh_inicio = Carbon::now();
        $cola->nombre_archivo = $transcribir->original;
        $cola->created_at = Carbon::now();

        if($transcribir->exito) {
            $cola->id_estado=2; //En cola
            $this->id_transcripcion=0;
        }
        else {
            $cola->id_estado=4; //Error en transcripcion
            $this->id_transcripcion=-1;
        }
        $cola->save();
        $this->save();
        $cola->json=$transcribir;

        return $cola;
    }

    public function transcribir_revisar() {
        $respuesta = new \stdClass();
        $respuesta->transcrito = false;
        $respuesta->mensaje="Inicial";
        $respuesta->detalle="Inicial";


        $id_subserie = config('expedientes.ee');
        $control = control_transcripcion::where('id_subserie',$id_subserie)
            ->where('id_primaria',$this->id_entrevista_etnica_adjunto)
            ->orderby('id_control_transcripcion','desc')
            ->first();
        if(!$control) { //No hay cola
            $estado = $this->transcribir(); //MEter a la cola
            $respuesta->mensaje = "No estaba en la cola de la base de datos, se metio a la cola";
            $respuesta->transcrito = false;
            $respuesta->detalle = $estado;
            return $respuesta;
        }


        if($control->id_estado==2) { //En cola: revisar
            $audio = $control->nombre_archivo;
            $revision = new adjunto();
            $estado = $revision->ws_revisar($audio);
            if(!$estado->transcrito) {  //No transcrito
                if(is_null($estado->json)) {  //No estaba en la cola
                    $estado = $this->transcribir(); //MEter a la cola
                    $respuesta->mensaje = "No estaba en la cola del servicio, se metio a la cola";
                    $respuesta->transcrito = false;
                    $respuesta->detalle = $estado;
                    return $respuesta;
                }
                elseif($estado->error) {  //Error en el servicio
                    $respuesta->mensaje = "Error en el servicio de transcripcion";
                    $respuesta->transcrito = false;
                    $respuesta->detalle = $estado;
                    //Actualizar para no seguir comprobando
                    $this->id_transcripcion=-1;
                    $this->save();
                    //Actualizar el control
                    $control->id_estado = 4;
                    $control->save();

                    return $respuesta;
                }
                else {  //No ha sido transcrito
                    $respuesta->mensaje = "No ha sido procesado, sigue en cola";
                    $respuesta->transcrito = false;
                    $respuesta->detalle = $estado;
                    return $respuesta;
                }
            }
            else {  //Ya fue transcrito
                //dd($estado);

                //Crear adjunto
                $archivo = adjunto::extrae_ruta($estado->json->fileOut);
                //Ver que no exista ya el adjunto en la BD
                $adjunto = adjunto::where('ubicacion',$archivo)->first();
                if(!$adjunto) {
                    $adjunto = adjunto::create(['ubicacion'=>$archivo]);
                }
                //Ver que no haya sido adjuntando antes
                //Anexar el adjunto a la entrevista
                $adjuntado['id_tipo']=8;
                $adjuntado['id_entrevista_etnica']=$this->id_entrevista_etnica;
                $adjuntado['id_adjunto']=$adjunto->id_adjunto;
                $nuevo = entrevista_etnica_adjunto::firstOrcreate($adjuntado);
                $this->id_transcripcion=$nuevo->id_entrevista_etnica_adjunto;
                $this->save();
                //Actualizar el control
                $control->id_estado=3;
                $control->fh_fin=Carbon::now();
                $control->id_adjunto_nuevo = $nuevo->id_entrevista_etnica_adjunto;
                $control->nombre_archivo_transcripcion = $archivo;
                $control->updated_at=Carbon::now();
                $control->save();
                //Actualizar el control de tiempo de transcripción automática
                $estado->id_adjunto=$adjunto->id_adjunto; // A la respuesta del servicio, le agrego el id del adjunto recien creado
                $tiempo = tiempo_transcripcion::registrar($estado);
                $respuesta->transcrito = true;
                $respuesta->mensaje = "Control de transcripción actualizada";
                $respuesta->detalle = $control;
                return $respuesta;
            }
        }
        elseif($control->id_estado == 3) { //finalizado con exito, se está consultando un registro actualizado con anterioridad
            $respuesta->transcrito = true;
            $respuesta->mensaje = "Control de transcripción ya existente";
            $respuesta->detalle = $control;
            //Actualizar el estado de la transcripcion
            $this->id_transcripcion=$control->id_adjunto_nuevo;
            $this->save();
            //dd($control);

            return $respuesta;
        }
        elseif($control->id_estado == 4) { //finalizado con error
            $respuesta->transcrito = false;
            $respuesta->mensaje = "Hubo un problema en el procesamiento de la transcripcion";
            $respuesta->detalle = $control;
            //Actualizar el registro del adjuntado
            $this->id_transcripcion=-1;
            $this->save();
            return $respuesta;
        }
        else { //otro problema
            $respuesta->transcrito = false;
            $respuesta->mensaje = "Hay un problema que no había sido considerado";
            $respuesta->detalle = $control;
            return $respuesta;
        }
    }

    public static function quitar_trans($id) {
        $id_subserie = config('expedientes.ee');
        $control = control_transcripcion::where('id_subserie',$id_subserie)
            ->where('id_primaria',$id)
            ->orderby('id_control_transcripcion','desc')
            ->first();
        $adjuntado = entrevista_etnica_adjunto::find($id);
        $transcripcion = entrevista_etnica_adjunto::find($adjuntado->id_transcripcion);
        if($transcripcion) {
            $adjunto_transcripcion = $transcripcion->rel_id_adjunto;
            $transcripcion->delete();
            $adjunto_transcripcion->delete();
            $control->id_estado=2;
            $control->save();
            $adjuntado->id_transcripcion=0;
            $adjuntado->save();
            return "Transcripcion eliminada";
        }
        else {
            return "No se encontró el adjunto ($adjuntado->id_transcripcion)";
        }



    }
    //Para transcribir por bloques, en cron jobs
    public static function revisar_bloque_google($bloque=0) {
        if($bloque==0) {
            $bloque = config('expedientes.cantidad_transcribir');
        }
        $respuesta=new \stdClass();
        $respuesta->titulo="Transcripciones EE";
        $respuesta->inicio=\Carbon\Carbon::now();
        $respuesta->pendientes_revisar=array();
        $respuesta->resultado_revisiones=array();
        $respuesta->enviados=array();

        $respuesta->log[]="Trabajando con bloques de $bloque";
        $sql_sin_transcripcion="select distinct a.id_entrevista_etnica_adjunto
                            from esclarecimiento.entrevista_etnica e join esclarecimiento.entrevista_etnica_adjunto a on (e.id_entrevista_etnica=a.id_entrevista_etnica)
                            where a.id_tipo=2 and a.id_transcripcion is null
                                -- Transcritos a mano
                              and a.id_entrevista_etnica not in (
                                  select e.id_entrevista_etnica
                                        from esclarecimiento.entrevista_etnica e join public.transcribir_asignacion a on (e.id_entrevista_etnica=a.id_entrevista_etnica)
                                        where a.id_situacion=2                    
                                )
                            order by 1";
        $sql_revisar =  "select distinct a.id_entrevista_etnica_adjunto
                            from esclarecimiento.entrevista_etnica e join esclarecimiento.entrevista_etnica_adjunto a on (e.id_entrevista_etnica=a.id_entrevista_etnica)
                            where a.id_tipo=2 and a.id_transcripcion =0
                                -- Transcritos a mano
                              and a.id_entrevista_etnica not in (
                                  select e.id_entrevista_etnica
                                        from esclarecimiento.entrevista_etnica e join public.transcribir_asignacion a on (e.id_entrevista_etnica=a.id_entrevista_etnica)
                                        where a.id_situacion=2                    
                                )
                            order by 1";

        $pendientes_revisar=array();
        $listado_revisar= DB::select(\DB::raw($sql_revisar));
        foreach($listado_revisar as $fila) {
            $pendientes_revisar[]=$fila->id_entrevista_etnica_adjunto;
        }
        $respuesta->cola_revisar=$pendientes_revisar;
        $respuesta->resultado_revisiones=array();
        $respuesta->log[]="<br>Iniciando revision de la cola. Transcripciones pendientes:".count($pendientes_revisar);
        foreach($pendientes_revisar as $cual) {
            $respuesta->log[]="<br>Revisando: $cual";
            $adjuntado = entrevista_etnica_adjunto::find($cual);
            $resultado = $adjuntado->transcribir_revisar();
            $respuesta->resultado_revisiones[] = $resultado;
        }
        $respuesta->log[]="<br>Iniciando envío a la cola de transcripción";
        // Si no hay nada pendiente de revisar, enviar un bloque
        $listado_enviar=array();

        if(count($respuesta->cola_revisar)==0) {
            $respuesta->log[]="<br>No hay pendiente de revisar, buscando pendientes de transcribir";
            $listado_transcribir= DB::select(\DB::raw($sql_sin_transcripcion));
            $maximo=0;
            foreach($listado_transcribir as $fila) {
                $respuesta->log[]="Para la cola: ".$fila->id_entrevista_etnica_adjunto;
                $listado_enviar[]=$fila->id_entrevista_etnica_adjunto;
                $maximo++;
                if($maximo > $bloque) {
                    break;
                }
            }
        }
        else {
            $respuesta->log[]="<br>Hay pendiente de revisar. No se genera cola para el envío";
        }
        $respuesta->cola_enviar=$listado_enviar;
        $respuesta->log[]="<br>Procesando bloque de pendientes de transcribir";
        foreach($listado_enviar as $cual) {
            $respuesta->log[]="<br>Enviando: $cual";
            $adjuntado = entrevista_etnica_adjunto::find($cual);
            $resultado = $adjuntado->transcribir();
            $respuesta->enviados[] = $resultado;
        }

        return $respuesta;
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
            $entrevista = $this->rel_id_entrevista_etnica;
            $etiquetas = $adjunto->procesar_json_etiquetado();
            if($etiquetas->exito) {
                etiqueta_entrevista::where('id_subserie',config('expedientes.ee'))->where('id_entrevista',$this->id_entrevista_etnica)->delete();
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
                    $nuevo['id_entrevista']=$this->id_entrevista_etnica;
                    $nuevo['id_subserie']=config('expedientes.ee');
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
