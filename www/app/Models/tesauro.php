<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_geo
 * @property int $id_padre
 * @property int $nivel
 * @property string $descripcion
 * @property int $id_tipo
 * @property string $codigo
 * @property string $etiqueta
 * @property int $id_etiqueta
 */
class tesauro extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'catalogos.tesauro';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_geo';

    /**
     * @var array
     */
    protected $fillable = ['id_padre', 'nivel', 'descripcion', 'id_tipo', 'codigo', 'etiqueta', 'id_etiqueta'];

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
        $query->orderby('tesauro.codigo');
    }

    /**
     * Para llenar un control de la forma mas simple
     * @param null $id_padre
     * @return mixed
     */
    public static function listar_hijos($id_padre=null, $vacio="", $otro_cual=false) {

        $nivel=0;
        //Para mostrar la descripción del lugar poblado

        if($id_padre>0) {
            $padre=self::find($id_padre);
            if($padre) {
                $nivel=$padre->nivel + 1;
            }
        }
        elseif($id_padre==-1) {  //En "Mostrar todos"
            $nivel=4;
        }

        if($id_padre>0) {
            if($nivel ==3) {
                //$sql="select g.*, c.descripcion as tipo, concat(g.descripcion,' (',c.descripcion,')') as lugar_poblado
                $sql="select g.*, c.descripcion as tipo, g.descripcion as lugar_poblado
                            from catalogos.tesauro g left join catalogos.cat_item c on g.id_tipo=c.id_item
                            where id_padre=$id_padre and id_activo=1
                            order by g.codigo";
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
                $opciones=self::where('id_padre',$id_padre)->where('id_activo',1)->ordenar()->pluck('descripcion','id_geo')->toArray();
            }

        }
        elseif($id_padre==0) {  //Todos los de primer nivel
            $opciones=self::whereNull('id_padre')->where('id_activo',1)->ordenar()->pluck('descripcion','id_geo')->toArray();
        }
        else {  //Paso -1 para [Mostrar todos]
            $opciones=self::where('id_padre',$id_padre)->where('id_activo',1)->ordenar()->pluck('descripcion','id_geo')->toArray();
        }


        if(strlen($vacio)>0) {
            $opciones = [-1=>$vacio] + $opciones;
        }

        if(count($opciones)==0) {
            $opciones[-1] = 'No aplica';
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
    public static function nombre_completo($id_geo=0, $br=false) {
        if(intval($id_geo)<=0) {
            return "Sin especificar";
        }
        $existe = tesauro::find($id_geo);
        if(!$existe) {
            $texto= "Identificador ($id_geo) no encontrado";
        }
        else {
            $texto = $existe->descripcion;
            if($existe->id_padre <> null) {
                $goma = $br ? "<br>=>" : " => ";
                $texto = tesauro::nombre_completo($existe->id_padre, $br) . $goma. $texto;
            }
            else {
                //$texto.=".";
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
                $hijos=self::where('id_padre',$id_geo)->where('id_activo',1)->orderby('id_geo')->pluck('id_geo');
                foreach($hijos as $id_geo) { //por las malas
                    $lugares[]=$id_geo;
                }

            }
            elseif($cual->nivel==1) {
                $hijos=self::where('id_padre',$id_geo)->where('id_activo',1)->orderby('id_geo')->pluck('id_geo');
                $nietos = self::wherein('id_padre',$hijos)->where('id_activo',1)->orderby('id_geo')->pluck('id_geo');
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


    public static function estructura_completa() {
        $todos = tesauro::orderby('codigo')->where('id_activo',1)->get();
        $n1=array();
        $n2=array();
        $n3=array();
        foreach($todos as $fila) {
            if ($fila->nivel==1) {
                if(strlen($fila->descripcion)>0) {
                    $n1[$fila->id_geo]['texto'] = $fila->descripcion;
                    $n1[$fila->id_geo]['etiqueta'] = $fila->etiqueta_completa;
                    $n1[$fila->id_geo]['conteo_entrevistas'] = $fila->conteo_entrevistas;
                    $n1[$fila->id_geo]['conteo_aplicaciones'] = $fila->conteo_aplicaciones();
                }

            }
            elseif ($fila->nivel==2) {
                if(strlen($fila->descripcion)>0) {
                    $n2[$fila->id_padre][$fila->id_geo]['texto'] = $fila->descripcion;
                    $n2[$fila->id_padre][$fila->id_geo]['etiqueta'] = $fila->etiqueta_completa;
                    $n2[$fila->id_padre][$fila->id_geo]['conteo_entrevistas'] = $fila->conteo_entrevistas;
                    $n2[$fila->id_padre][$fila->id_geo]['conteo_aplicaciones'] = $fila->conteo_aplicaciones();

                }
            }
            elseif($fila->nivel==3) {
                if(strlen($fila->descripcion)>0) {
                    $padre = tesauro::find($fila->id_padre);
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['texto'] = $fila->descripcion;
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['etiqueta'] = $fila->etiqueta_completa;
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['conteo_entrevistas'] = $fila->conteo_entrevistas;
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['conteo_aplicaciones'] = $fila->conteo_aplicaciones();


                }
            }
        }


        $respuesta = new \stdClass();
        $respuesta->n1 = $n1;
        $respuesta->n2 = $n2;
        $respuesta->n3 = $n3;
        return $respuesta;
    }

    //Devuelve el reporte de tesauro, aplicando los conteos que recibe

    /**
     * Devuelve el reporte de tesauro, aplicando los conteos que recibe
     * Espera un arreglo tipo:  arreglo[id_etiqueta]=conteo
     * @param $conteos array
     * @return \stdClass
     */
    public static function estructura_completa_comparada($conteos) {
        $todos = tesauro::orderby('codigo')->where('id_activo',1)->get();
        $n1=array();
        $n2=array();
        $n3=array();
        foreach($todos as $fila) {
            if ($fila->nivel==1) {
                if(strlen($fila->descripcion)>0) {
                    $n1[$fila->id_geo]['texto'] = $fila->descripcion;
                    $n1[$fila->id_geo]['etiqueta'] = $fila->etiqueta_completa;
                    $valor = isset($conteos[$fila->id_etiqueta]) ? $conteos[$fila->id_etiqueta] : 0;
                    $n1[$fila->id_geo]['conteo_aplicaciones'] = $valor;
                }

            }
            elseif ($fila->nivel==2) {
                if(strlen($fila->descripcion)>0) {
                    $n2[$fila->id_padre][$fila->id_geo]['texto'] = $fila->descripcion;
                    $n2[$fila->id_padre][$fila->id_geo]['etiqueta'] = $fila->etiqueta_completa;
                    $valor = isset($conteos[$fila->id_etiqueta]) ? $conteos[$fila->id_etiqueta] : 0;
                    $n2[$fila->id_padre][$fila->id_geo]['conteo_aplicaciones'] = $valor;

                }
            }
            elseif($fila->nivel==3) {
                if(strlen($fila->descripcion)>0) {
                    $padre = tesauro::find($fila->id_padre);
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['texto'] = $fila->descripcion;
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['etiqueta'] = $fila->etiqueta_completa;
                    $valor = isset($conteos[$fila->id_etiqueta]) ? $conteos[$fila->id_etiqueta] : 0;
                    $n3[$padre->id_padre][$padre->id_geo][$fila->id_geo]['conteo_aplicaciones'] = $valor;
                }
            }
        }


        $respuesta = new \stdClass();
        $respuesta->n1 = $n1;
        $respuesta->n2 = $n2;
        $respuesta->n3 = $n3;
        return $respuesta;
    }



    /**
     * REalizar conteo de etiquetas, utilizando filtros de la buscadora
     * Devuelve un arreglo con id_etiqueta=X
     * @param $filtros
     */
    public static function conteo_comparado($filtros) {
        $universo = etiqueta_entrevista::Id_geo_contenida($filtros->id_tesauro)
            ->otros_filtros($filtros)
            ->distinct()
            ->select('id_subserie','id_entrevista');
            //->toSql();
        //$debug['sql']= nl2br($universo->toSql());
        //$debug['criterios']=$universo->getBindings();
        $query_completo = tesauro::getSqlWithBindings($universo);
        //dd($debug);
        $universo = " ($query_completo) as universo";
        //dd($universo);
        $query = etiqueta_entrevista::selectraw(\DB::raw('id_etiqueta, count(1) as conteo'))
                                    ->groupby('id_etiqueta')
                                    ->join(\DB::raw($universo),function($join)
                                    {
                                        $join->on("etiqueta_entrevista.id_subserie",'=','universo.id_subserie');
                                        $join->on("etiqueta_entrevista.id_entrevista",'=','universo.id_entrevista');
                                    });
        //dd($query->toSql());
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);
        $conteos=$query->get();
        $a_datos=array();
        foreach($conteos as $fila) {
            $a_datos[$fila->id_etiqueta]=$fila->conteo;
        }
        return $a_datos;
    }
    //Para los conteos, me devuelve el query con los valores del where en el query: https://stackoverflow.com/questions/27314506/laravel-how-to-get-query-with-bindings
    public static function getSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
            return is_numeric($binding) ? $binding : "'{$binding}'";
        })->toArray());
    }




    public static function completar_etiqueta() {
        $todos = tesauro::orderby('codigo')->where('id_activo',1)->get();
        $conteo=0;
        foreach($todos as $termino) {
            if($termino->nivel==2) {
                $padre = tesauro::find($termino->id_padre);
                $termino->etiqueta_completa = $padre->etiqueta." - ".$termino->etiqueta;
                $termino->save();
                $conteo++;
            }
            elseif($termino->nivel==3) {
                $padre = tesauro::find($termino->id_padre);
                $abuelo = tesauro::find($padre->id_padre);
                $termino->etiqueta_completa = $abuelo->etiqueta." - ".$padre->etiqueta." - ".$termino->etiqueta;
                $termino->save();
                $conteo++;
            }
            elseif($termino->nivel==1) {
                $termino->etiqueta_completa = $termino->etiqueta;
                $termino->save();
                $conteo++;
            }
        }
        return $conteo;
    }


    //Exporta las etiquetas para el servicio de data turk
    public static function etiquetas_dataturk() {
        $respuesta = new \stdClass();
        $etiquetas = tesauro::orderby('codigo')->where('id_activo',1)->pluck('etiqueta_completa')->toArray();
        foreach($etiquetas as $var => $val) {
                $etiquetas[$var] = str_replace(",",";",$val);
        }
        $arreglo = implode(", ",$etiquetas);
        $respuesta->tags = $arreglo;
        $respuesta->instructions = "Tu puedes!";
        return json_encode($respuesta);
    }


    public static function dataturk_existe_proyecto($codigo) {
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $client = new Client();
        $url = config('expedientes.turk_url').$codigo."/getProjectDetails?quien=$quien";
        $r = new \stdClass();
        $r->exito=false;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->respuesta="Hubo problemas";
        $r->existe=false;

        //Consumir el servicio
        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]

            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            if(is_null($respuesta)) {
                $r->exito = false;
                $r->respuesta = "Se recibe una respuesta nula";
            }
            else {
                $r->exito = true;
                $r->respuesta = $respuesta;
                if(isset($respuesta->name)) {
                    $r->existe = true ;
                }
            }
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->respuesta = $e->getMessage();
            $r->problema = $e;
        }
        return $r;
    }



    //Consume servicios de crear proyecto
    public static function dataturk_crear_proyecto($entrevista) {

        $log=array();
        $existe = tesauro::dataturk_existe_proyecto($entrevista->entrevista_codigo);
        $log[]="Revisando si existe el proyecto: $existe->existe";
        if($existe->existe) {
            $log[]="Extraer etiquetado si lo hubiera.";
            $re = $entrevista->dataturk_traer_etiquetado();
            if($re->exito) {
                $log[]= "Resultado de la extracción exitoso";
                $log[]="Eliminar el proyecto";
                $r = tesauro::dataturk_eliminar_proyecto($entrevista->entrevista_codigo);
                $log[] = "Resultado de eliminar el proyecto: $r->exito";
            }
            else {
                $log[]= "Resultado de la extracción fallido"; //Detener el proceso
                $exito=false;
                $r=new \stdClass();
                $r->exito=false;
                $r->log = implode(" || ",$log);
                $r->respuesta = $re;
                $r->mensaje = "Ya existe un proyecto en dataturks y no se pudo extraer el etiquetado. ¿faltó darle click a 'Finalizar' en dataturk? ";
                Log::debug('tesauro::dataturk_crear_proyecto.  Problemas');
                Log::debug(json_encode($r));
                return $r;
            }

        }
        $log[]="Crear el proyecto";

        $json= new \stdClass();
        $json->name = $entrevista->entrevista_codigo;
        $json->taskType = "DOCUMENT_ANNOTATION";
        $json->accessType = "RESTRICTED";
        $json->shortDescription = "Contribuyendo a la verdad ;-)";
        $json->description = "Tesauro - ".date("Ymd");
        $json->rules = tesauro::etiquetas_dataturk();

        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $client = new Client();
        $url = config('expedientes.turk_url').'createProject'."?quien=$quien";

        $r = new \stdClass();
        $r->json = $json;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->respuesta = null;
        $r->mensaje="Hubo problemas";
        $r->exito=false;

        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]
                , RequestOptions::JSON => $json
            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->exito=true;
            $r->respuesta = $respuesta;
            $r->mensaje="ok";
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }
        $r->log = $log;
        return $r;
    }

    //Consume servicios para eliminar proyecto
    public static function dataturk_eliminar_proyecto($proyecto="666-VI-00001") {
        $client = new Client();
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url = config('expedientes.turk_url').$proyecto."/deleteProject?quien=$quien";
        $r = new \stdClass();
        $r->exito=false;
        $r->proyecto=$proyecto;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->respuesta = null;
        $r->mensaje="Hubo problemas";
        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]

            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->respuesta = $respuesta;
            if(is_null($respuesta)) {
                $r->exito = false;
                $r->mensaje = "No ha sido eliminado";
            }
            else {
                $respuesta->response = mb_strtolower($respuesta->response);
                if(isset($respuesta->response)) {
                    if($respuesta->response == "ok") {
                        $r->exito=true;
                        $r->mensaje="Proyecto eliminado sin piedad";
                    }
                    else {
                        $r->exito=false;
                        $r->mensaje = "El servicio no devolvió la respuesta esperada.";
                    }
                }
                else {
                    $r->exito=false;
                    $r->mensaje = "El servicio devolvió un valor nulo.";
                }
            }
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }

        return $r;
    }

    //Consume servicios para cargar texto. Tipo= 1:texto, 2:json
    public static function dataturk_subir_archivo($proyecto="001-VI-00001",$texto="Hola mundo",$tipo=1) {
        //Log::debug("Envio a dataturks");
        if($tipo==1) {
            if(config('expedientes.pre_etiquetar')) {
                $pre = self::pre_etiquetar($texto,$proyecto);
                if(!$pre) {
                    $r = new \stdClass();
                    $r->exito=false;
                    $r->proyecto=$proyecto;
                    $r->texto = $texto;
                    $r->mensaje = "Problemas al consultar el servicio de pre-etiqutado para  $proyecto";
                    return $r;
                }
                Log::debug("Pre-etiquetado, resultado del proceso completo($proyecto): ". PHP_EOL .$pre);
                //Log::debug(json_encode($pre));
                return self::dataturk_subir_json($proyecto,$pre);
            }
            else {
                //Log::debug('NO pre etiquetado: pre-etiquetado deshabilitado');
                return self::dataturk_subir_texto($proyecto,$texto);
            }

        }
        else {
            //Log::debug('NO pre etiquetado: ya había etiquetado');
            return self::dataturk_subir_json($proyecto,$texto);
        }
    }

    //enviar la transcripcion como texto
    public static function dataturk_subir_texto($proyecto="001-VI-00001",$texto="Hola mundo") {
        $client = new Client();
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url = config('expedientes.turk_url').$proyecto.'/upload'."?quien=$quien";


        $r = new \stdClass();
        $r->exito=false;
        $r->proyecto=$proyecto;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->texto = $texto;
        $r->respuesta=null;
        $r->mensaje="Hubo problemas";
        $filename='texto.txt';


        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key')
                    , 'secret'=>config('expedientes.turk_secret')

                ]
                ,'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $texto,
                        'filename' => $filename
                    ]
                ]]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->exito=true;
            $r->respuesta = $respuesta;
            $r->mensaje='ok';
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }
        return $r;
    }



    //Subir el eitquetado anterior
    public static function dataturk_subir_json($proyecto="888-VI-00003",$texto="") {
        Log::debug("Subiendo json: ". PHP_EOL .$texto);
        $client = new Client();
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url = config('expedientes.turk_url').$proyecto."/upload?format=PRE_TAGGED_JSON&itemStatus=notDone&quien=$quien";

        if(empty($texto)) {
            $texto = '{"content":"Hola Mundo!  este es un texto de prueba hecho por Oliver","annotation":[{"label":["Entidades - Personas"],"points":[{"start":49,"end":55,"text":" Oliver"}]},{"label":["N8 Causas - Impactos - Espirituales"],"points":[{"start":0,"end":10,"text":"Hola Mundo!"}]}],"extras":null,"metadata":{"first_done_at":1582835833000,"last_updated_at":1582835833000,"sec_taken":0,"last_updated_by":"sim@comisiondelaverdad.co","status":"done","evaluation":"NONE"}}';
        }


        $r = new \stdClass();
        $r->exito=false;
        $r->proyecto=$proyecto;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->texto = $texto;
        $filename='etiquetado.json';
        $r->filename=$filename;
        $r->respuesta=null;
        $r->mensaje="Hubo problemas";


        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key')
                    , 'secret'=>config('expedientes.turk_secret')
                    //, 'Accept'                => 'application/json'
                    //, 'Content-Type'          => 'multipart/form-data'

                ]
                //, RequestOptions::JSON => $json
                ,'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $texto,
                        'filename' => $filename
                    ]
                ]]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->exito=true;
            $r->respuesta = $respuesta;
            $r->mensaje = 'ok';
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }
        return $r;
    }

    //Consume servicios para cargar texto
    public static function dataturk_descargar_etiquetado($proyecto="666-VI-00001") {
        $client = new Client();
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url = config('expedientes.turk_url').$proyecto.'/download'."?quien=$quien";
        $r = new \stdClass();
        $r->exito=false;
        $r->proyecto=$proyecto;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->respuesta = null;
        $r->mensaje="Hubo problemas";
        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]

            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->respuesta = $respuesta;
            if(is_null($respuesta) ) {
                $r->exito = false;
                $r->mensaje = "No ha sido etiquetado";
            }
            else {
                $r->exito=true;
                $r->mensaje = 'ok';
            }

        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }

        return $r;
    }

    //Consume servicios para asignar etiquetador
    public static function dataturk_asignar_etiquetador($correo='sim@comisiondelaverdad.co',$proyecto="666-VI-00001") {
        $client = new Client();
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url = config('expedientes.turk_url').$proyecto."/addContributor?role=CONTRIBUTOR&userEmail=$correo&quien=$quien";
        $r = new \stdClass();
        $r->exito=false;
        $r->proyecto=$proyecto;
        $r->correo=$correo;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->respuesta = null;
        $r->mensaje="Hubo problemas";
        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]

            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->respuesta = $respuesta;
            if(is_null($respuesta)) {
                $r->exito = false;
                $r->mensaje = "No ha sido etiquetado";
            }
            else {
                $respuesta->response = mb_strtolower($respuesta->response);

                if(isset($respuesta->response)) {
                    if($respuesta->response == "ok") {
                        $r->exito=true;
                        $r->mensaje='ok';
                    }
                    else {
                        $r->exito=false;
                        $r->mensaje = "REspuesta del mensaje inesperada: $respuesta->response";
                    }
                }
                else {
                    $r->exito=false;
                    $r->mensaje = "Respuesta del servicio nula";
                }
            }
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }

        return $r;
    }

    //Consume servicios para des-asignar etiquetador
    public static function dataturk_quitar_etiquetador($correo='sim@comisiondelaverdad.co',$proyecto="666-VI-00001") {
        $client = new Client();
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url = config('expedientes.turk_url').$proyecto."/removeContributor?userEmail=$correo&quien=$quien";
        $r = new \stdClass();

        $r->proyecto=$proyecto;
        $r->correo=$correo;
        $r->secret = config('expedientes.turk_secret');
        $r->key = config('expedientes.turk_key');
        $r->url = $url;
        $r->respuesta=null;
        $r->mensaje="Hay problemas";
        $r->exito=false;
        try {
            $response = $client->post($url, [
                'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]

            ]);
            $respuesta = json_decode($response->getBody()->getContents());
            $r->respuesta = $respuesta;
            if(is_null($respuesta)) {
                $r->exito = false;
                $r->mensaje = "El servicio devolvió un valor nulo";
            }
            else {
                $respuesta->response = mb_strtolower($respuesta->response);
                $r->respuesta = $respuesta;
                if(isset($respuesta->response)) {
                    if($respuesta->response == "ok") {
                        $r->exito=true;
                        $r->mensaje='ok';
                    }
                    else {
                        $r->exito=false;
                        $r->mensaje = 'El serviccio devolvió un valor insesperado';
                    }
                }
                else {
                    $r->exito=false;
                    $r->mensaje = 'El servicio devolvió un valor nulo';
                }
            }
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->mensaje = $e->getMessage();
        }

        return $r;
    }


    //Devuelve la cantidad de entrevistas identificadas con esa etiqueta
    public function getConteoEntrevistasAttribute() {
        if($this->id_etiqueta > 0) {
            $res = etiqueta_entrevista::id_etiqueta_exacta($this->id_etiqueta)
                ->select('id_entrevista','id_subserie')
                ->distinct()
                ->get();

            return count($res);
        }
        else {
            return "-";
        }

    }
    //Devuelve la cantidad de aplicaciones de la etiqueta
    public function conteo_aplicaciones() {
        if($this->id_etiqueta > 0) {
            $res = etiqueta_entrevista::id_etiqueta_exacta($this->id_etiqueta)
                ->count();
            return $res;
        }
        else {
            return "-";
        }

    }


    public  static function buscar_entrevistas($id_etiqueta=0) {
        if($id_etiqueta > 0) {
            $vi = entrevista_individual::tesauro($id_etiqueta);
        }


    }



    //Si es nivel 2 o 1, me devuelve los hijos
    public function arreglo_incluidos() {
        $arreglo = array();
        if($this->nivel==3) {
            return array($this->id_geo);
        }
        elseif($this->nivel==2) {
            //Hijos:
            $arreglo =  tesauro::where('id_padre',$this->id_geo)->where('id_activo',1)->pluck('id_geo')->toArray(); //Listado de hijos
            $arreglo[]=$this->id_geo; //Agregar a mi mismo
        }
        elseif($this->nivel==1) {
            //
            $arreglo=array();
            $hijos =  tesauro::where('id_padre',$this->id_geo)->where('id_activo',1)->get();
            foreach($hijos as $hijito) {
                $nietos = tesauro::where('id_padre',$hijito->id_geo)->where('id_activo',1)->get();
                foreach($nietos as $nieto) {
                    $arreglo[]=$nieto->id_geo; //Listado de nietos
                }
                $arreglo[]=$hijito->id_geo;  //Listado de hijos
            }
            $arreglo[]=$this->id_geo; //mi mismo

        }
        return $arreglo;


    }

    public static function scopeId_Etiqueta($query, $criterio=0) {
        if($criterio > 0) {
            $query->where('id_etiqueta',$criterio);
        }
    }

    //Consumir el servicio de Eduar Ramos.
    //Ojo: el servicio solo puede recibir texto sin formato ni etiquetas
    public static function servicio_pre_etiquetar($texto=null, $proyecto=null) {
        $url = config('expedientes.url_pre_etiquetado');
        $quien = \Auth::check() ? \Auth::user()->fmt_numero_entrevistador : "000";
        $url=$url."?quien=$quien";
        $client = new Client();
        $r = new \stdClass();
        $r->exito=false;
        $r->url = $url;
        $r->respuesta="Hubo problemas";
        $r->nuevo_texto=$texto;  //El que tenía originalmente, si hay problemas, que devuelva el texto
        //Rechazar textos nulos
        if(is_null($texto)) {
            $r->respuesta = "Se recibió un texto nulo";
            return $r;
        }
        $json = new \stdClass();
        $json->content = $texto;

        //Consumir el servicio
        try {
            $response = $client->post($url, [
                //'headers'        => ['key' => config('expedientes.turk_key'), 'secret'=>config('expedientes.turk_secret')]
                 RequestOptions::JSON => $json
            ]);

            $respuesta = json_decode($response->getBody()->getContents());
            if(is_null($respuesta)) {
                $r->exito = false;
                $r->respuesta = "Se recibe una respuesta nula o vacía";
                Log::warning("Se recibió respuesta nula del servicio de  pre-etiquetado ");
            }
            else {
                $r->exito = true;
                $r->respuesta = "Servicio consumido con éxito para $proyecto en $url";
                $r->nuevo_texto = $respuesta;
                Log::debug($r->respuesta.  PHP_EOL . json_encode( $respuesta));

            }
        }
        catch(\Exception $e) {
            $r->exito=false;
            $r->respuesta = $e->getMessage();
            $r->problema = $e;
            Log::warning("Problemas al consultar el servicio de pre-etiquetado para $proyecto: ".$r->respuesta );
        }
        return $r;
    }


    /**
     * consume el servicio y realiza la homologación.  Devuelve el mismo texto si hay problema, o un json_encode listo para el dataturks
     *
     * @param $texto
     * @return false|json_encode
     *
     */
    public static function pre_etiquetar($texto,$proyecto) {

        //Consumir el servicio y realizar la homologación.
        $fecha_inicio = Carbon::now();
        $pre = self::servicio_pre_etiquetar($texto, $proyecto);
        $fecha_fin = Carbon::now();

        //Aplicar la homologación
        if($pre->exito) {  //Hubo respuesta
            //Hard code del feo necesario para la homologación
            $entidades = array();  //Este arreglo son las etiquetas que devuelve el servicio y su equivalente al tesauro del sistema
            $entidades['1. Fecha']='000100';
            $entidades['2. Divipola/Sitios/Regiones']='000300';
            $entidades['3. Personas']='000500';
            $entidades['4. Organizaciones']='000600';
            $entidades['5. Armas, instrumetnos y medios']='000700';
            $entidades['6. Roles y poblaciones']='000900';

            //Determinar las etiquetas respectivas
            $nomenclatura = array(); //Este arreglo tiene la nueva nomenclatura de la etiqueta
            foreach($entidades as $txt=>$codigo) {
                $tes = tesauro::where('codigo',$codigo)->first();
                if($tes) {
                    $nomenclatura[substr($txt,0,2)]=$tes->etiqueta_completa;  //El substr es para evitarme problemas por una mayuscula o espacio
                }
            }
            //Fin de la homologación fea


            $original = $pre->nuevo_texto;
            //Homologación
            $nuevo= new \stdClass();
            $nuevo->content = $original->content;
            $nuevo->annotation = array();
            foreach($original->annotation as $identificado) { //Recorrer las marcas y cambiarlas
                $inicio = substr($identificado->label,0,2);
                if(isset($nomenclatura[$inicio])) { //Si no existe el equivalente en nomeclatura, lo ignoro porque es una entidad no homologada
                    $etiqueta = $nomenclatura[$inicio];
                    $marca = new \stdClass();
                    $marca->label[] = $etiqueta;
                    $punto = new \stdClass();
                    $punto->start = $identificado->points[0]->start;
                    //Bug de eduar
                    //$var = "end";  //espacio al final.  Corregido por
                    //$punto->end = $identificado->points[0]->$var;
                    $punto->end = $identificado->points[0]->end;
                    $punto->text = $identificado->points[0]->text;
                    $marca->points[] =  $punto;
                    //Meterno a la nueva estructura
                    $nuevo->annotation[]=clone $marca;
                }
                else {
                    Log::alert('No se pudo homologar una etiqueta de pre-etiquetado: '.$identificado->label.'.');
                }
            }
            //Otros campos de dataturks

            $nuevo->extras = null;
            $nuevo->metadata = new \stdClass();

            $nuevo->metadata->first_done_at = $fecha_inicio->timestamp*1000;
            $nuevo->metadata->last_updated_at = $fecha_fin->timestamp*1000;
            $nuevo->metadata->sec_taken= $fecha_fin->diffInSeconds($fecha_inicio);
            $nuevo->metadata->last_updated_by = 'pre-etiquetado@comisiondelaverdad.co';
            $nuevo->metadata->status="done";
            $nuevo->metadata->evaluation="NONE";
            //Log::debug("Respuesta del servicio de pre-etiquetado: $respuesta");
            return json_encode($nuevo);

        }
        else {
            return false;  //Para el manejo de errores
        }



    }

    //JSON para el jsonTree: https://www.jstree.com/docs/json/
    public static function json_tree($quitar="", $poner="") {
        $query = self::where('id_activo',1)->orderby('codigo');
        if(strlen($quitar)>0) {
            $query->where('codigo','not like',"$quitar%");
        }
        if(strlen($poner)>0) {
            $query->where('codigo','like',"$poner%");
        }

            $tesauro = $query->get();
        $estructura = array();
        foreach($tesauro as $fila) {
            $nodo = new \stdClass();
            $nodo->id = $fila->codigo;
            if($fila->id_padre>0) {
                $padre = self::find($fila->id_padre);
                if($padre) {
                    $nodo->parent = $padre->codigo;
                }
                else {
                    $nodo->parent = "#";
                }

            }
            else {
                $nodo->parent = "#";
            }
            $nodo->text = $fila->descripcion;
            $estructura[]=$nodo;
        }
        $tree = new \stdClass();
        $tree->core = new \stdClass();
        $tree->core->data = $estructura;
        return \GuzzleHttp\json_encode($tree);
    }

}
