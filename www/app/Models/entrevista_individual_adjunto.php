<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class entrevista_individual_adjunto
 * @package App\Models
 * @version April 17, 2019, 5:34 pm -05
 *
 * @property \App\Models\Esclarecimiento.adjunto idAdjunto
 * @property \App\Models\Catalogos.catItem idTipo
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt_adjunto
 * @property integer id_tipo
 * @property integer id_adjunto
 * @property integer id_e_ind_fvt
 * @property integer id_transcripcion
 */
class entrevista_individual_adjunto extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_adjunto';
    protected $primaryKey = 'id_e_ind_fvt_adjunto';
    
    public $timestamps = false;



    public $fillable = [
        'id_tipo',
        'id_adjunto',
        'id_e_ind_fvt',
        'id_transcripcion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_adjunto' => 'integer',
        'id_tipo' => 'integer',
        'id_adjunto' => 'integer',
        'id_e_ind_fvt' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt_adjunto' => 'required',
        'id_adjunto' => 'required',
        'id_e_ind_fvt' => 'required'
    ];


    public function rel_id_adjunto() {
        return $this->belongsTo(adjunto::class,'id_adjunto','id_adjunto');
    }
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
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
    //Para el legado
    public function getFmtNombreLegadoAttribute() {
        $e = $this->rel_id_e_ind_fvt;
        $a = $this->rel_id_adjunto;
        if($e && $a) {
            $info = pathinfo($a->ubicacion);

            $nombre[] = $e->entrevista_codigo;
            $nombre[] = criterio_fijo::describir(1,$this->id_tipo);
            $nombre[] = $this->id_adjunto;
            if (isset($info['extension'])) {
                $nombre[] = ".".$info['extension'];
            }

            $completo = implode("_",$nombre);  //Unir piezas
            $completo = mb_strtolower($completo);  //Siempre  minusculas
            $completo = adjunto::quitar_acentos($completo);  //cambiar á por a
            $completo = str_replace(" ","-",$completo); //sin espacios en blanco
            $completo = filter_var($completo, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH); //Por si acaso
            return $completo;
        }
        else {
            return null;
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
                $trans = entrevista_individual_adjunto::find($this->id_transcripcion);
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
            $url = "<a target='_blank' href='".action('adjuntoController@show',$adjunto->id_adjunto)."'>$adjunto->nombre</a>";
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
        $listado = entrevista_individual_adjunto::where('id_e_ind_fvt',$id_entrevista)
                            ->join('catalogos.criterio_fijo as cf','id_tipo','=','id_opcion')
                            ->where('id_grupo',1)
                            ->orderby('orden')
                            ->orderby('id_e_ind_fvt_adjunto')->get();
        $arreglo=array();
        //$entrevista = entrevista_individual::find($id_entrevista);
        foreach($listado as $archivo) {
            $adjunto = adjunto::find($archivo->id_adjunto);
            $item= array();
            $item['id_e_ind_fvt_adjunto']=$archivo->id_e_ind_fvt_adjunto;
            $item['id_adjunto']=$adjunto->id_adjunto;
            $item['nombre']=$adjunto->nombre;
            $item['tipo']=$archivo->fmt_id_tipo;
            $item['id_tipo']=$archivo->id_tipo;
            $item['id_transcripcion']=$archivo->id_transcripcion;
            $item['transcrito']=$archivo->fmt_transcrito;
            $item['existe']=$adjunto->existe;
            $item['url_stream']=$archivo->url_stream;
            $item['url_stream_corto']=$archivo->url_stream_corto;
            $item['adjunto']=$adjunto;

            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                $visor = $adjunto->url_visor();
                if($visor) {
                    $url=$visor;
                }
                else {
                    $url=action('adjuntoController@show',$adjunto->id_adjunto);
                }

                $item['url']="<a target='_blank' href='".$url."'>$adjunto->nombre </a>";
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
     * Anexa un archivo cargado a una entrevista específica.
     * //Asume que el archivo ya se subió y está pendiente anexarlo a un expediente
     * @param int $id_entrevista
     * @param string $archivo
     * @param string $control   //determina el tipo de archivo
     * @return object
     */
    public static function adjuntar_archivo($id_entrevista, $archivo="", $control="", $nombre_orginal="", $otr='') {
        $entrevista = entrevista_individual::find($id_entrevista);
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
            $tmp['id_e_ind_fvt'] = $id_entrevista;
            $tmp['id_adjunto']=$adjunto->id_adjunto;
            $tmp['id_tipo']=$id_tipo;
            $adjunto_rel = entrevista_individual_adjunto::create($tmp);
            //Justificar la calificacion
            foreach($calificacion->justificacion as $id_justificacion) {
                adjunto_justificacion::create(['id_adjunto'=>$adjunto->id_adjunto, 'id_justificacion'=>$id_justificacion]);
            }
            // Fin de la calificacion
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
                $adjunto_rel2 = entrevista_individual_adjunto::create($tmp);
                //Justificar la calificacion
                foreach($calificacion->justificacion as $id_justificacion) {
                    adjunto_justificacion::create(['id_adjunto'=>$adjunto_rel2->id_adjunto, 'id_justificacion'=>$id_justificacion]);
                }
                //Registrar traza
                traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$adjunto_rel2->id_adjunto,'referencia'=>"OTR automatico"]);
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

    public static function calificar($entrevista, $id_tipo) {
        $res = new \stdClass();
        $res->id_calificacion=null;
        $res->justificacion=[];
        if($entrevista->id_casos_informes > 0) {  //Casos e informes
            $res->id_calificacion=2;
            if($id_tipo==1) {
                $res->justificacion=[1,2];
            }
            else {
                $res->justificacion=[1,2,3,4];
            }

        }
        elseif($entrevista->clasifica_nna==1 || $entrevista->nna==1) { //NNA
            $res->id_calificacion=3;
            $res->justificacion=[7];
        }
        elseif($entrevista->id_subserie==config('expedientes.vi')) { //VI
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
        else { //AA y TC
            if(in_array($id_tipo,[17,18])) {
                $res->id_calificacion=1;
                //Est nivel no requiere justificacion
            }
            else {
                $res->id_calificacion=3;
                if(in_array($id_tipo,[1])) {
                    $res->justificacion=[5,6];
                }
                else {
                    $res->justificacion=[1,2,3,4,5,6,10];
                }
            }

        }
        return $res;
    }


    public function transcribir() {
        $adjunto =$this->rel_id_adjunto;
        $entrevista = $this->rel_id_e_ind_fvt;
        //Llamar al webservice
        $transcribir = $adjunto->transcribir( $entrevista->entrevista_codigo);
        //dd($transcribir);


        //Siempre se registra en la cola, así sea con estado de error

        $cola = new control_transcripcion();
        $cola->id_subserie = config('expedientes.vi');
        $cola->id_primaria = $this->id_e_ind_fvt_adjunto;
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


        $id_subserie = config('expedientes.vi');
        $control = control_transcripcion::where('id_subserie',$id_subserie)
                                        ->where('id_primaria',$this->id_e_ind_fvt_adjunto)
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
                $adjuntado['id_e_ind_fvt']=$this->id_e_ind_fvt;
                $adjuntado['id_adjunto']=$adjunto->id_adjunto;
                $nuevo = entrevista_individual_adjunto::firstOrcreate($adjuntado);
                $this->id_transcripcion=$nuevo->id_e_ind_fvt_adjunto;
                $this->save();
                //Actualizar el control
                $control->id_estado=3;
                $control->fh_fin=Carbon::now();
                $control->id_adjunto_nuevo = $nuevo->id_e_ind_fvt_adjunto;
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
        $id_subserie = config('expedientes.vi');
        $control = control_transcripcion::where('id_subserie',$id_subserie)
            ->where('id_primaria',$id)
            ->orderby('id_control_transcripcion','desc')
            ->first();
        $adjuntado = entrevista_individual_adjunto::find($id);
        $transcripcion = entrevista_individual_adjunto::find($adjuntado->id_transcripcion);
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

    public static function revisar_bloque_google($bloque=0) {
        if($bloque==0) {
            $bloque = config('expedientes.cantidad_transcribir');
        }
        $respuesta=new \stdClass();
        $respuesta->titulo="Transcripciones VI";
        $respuesta->inicio=\Carbon\Carbon::now();
        $respuesta->pendientes_revisar=array();
        $respuesta->resultado_revisiones=array();
        $respuesta->enviados=array();

        $respuesta->log[]="Trabajando con bloques de $bloque";
        $sql_sin_transcripcion="select distinct a.id_e_ind_fvt_adjunto
                            from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
                            where a.id_tipo=2 and a.id_transcripcion is null
                                -- Transcritos a mano
                              and a.id_e_ind_fvt not in (
                                  select e.id_e_ind_fvt
                                        from esclarecimiento.e_ind_fvt e join public.transcribir_asignacion a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
                                        where a.id_situacion=2
                            
                                )
                            order by 1";
        $sql_revisar =  "select distinct a.id_e_ind_fvt_adjunto
                            from esclarecimiento.e_ind_fvt e join esclarecimiento.e_ind_fvt_adjunto a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
                            where a.id_tipo=2 and a.id_transcripcion =0
                                -- Transcritos a mano
                              and a.id_e_ind_fvt not in (
                                  select e.id_e_ind_fvt
                                        from esclarecimiento.e_ind_fvt e join public.transcribir_asignacion a on (e.id_e_ind_fvt=a.id_e_ind_fvt)
                                        where a.id_situacion=2
                            
                                )
                            order by 1";

        $pendientes_revisar=array();
        $listado_revisar= DB::select(\DB::raw($sql_revisar));
        foreach($listado_revisar as $fila) {
            $pendientes_revisar[]=$fila->id_e_ind_fvt_adjunto;
        }
        $respuesta->cola_revisar=$pendientes_revisar;
        $respuesta->resultado_revisiones=array();
        $respuesta->log[]="<br>Iniciando revision de la cola. Transcripciones pendientes:".count($pendientes_revisar);
        foreach($pendientes_revisar as $cual) {
            $respuesta->log[]="<br>Revisando: $cual";
            $adjuntado = entrevista_individual_adjunto::find($cual);
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
                $respuesta->log[]="Para la cola: ".$fila->id_e_ind_fvt_adjunto;
                $listado_enviar[]=$fila->id_e_ind_fvt_adjunto;
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
            $adjuntado = entrevista_individual_adjunto::find($cual);
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
            //Buscar la entrevista
            $entrevista = $this->rel_id_e_ind_fvt;
            ///Procesar el json
            $etiquetas = $adjunto->procesar_json_etiquetado();
            if($etiquetas->exito) {
                etiqueta_entrevista::where('id_subserie',config('expedientes.vi'))->where('id_entrevista',$this->id_e_ind_fvt)->delete();
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
                    $nuevo['id_entrevista']=$this->id_e_ind_fvt;
                    $nuevo['id_subserie']=$entrevista->id_subserie;
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
