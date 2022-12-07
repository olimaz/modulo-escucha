<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_legado
 * @property string $carpeta_1
 * @property string $carpeta_2
 * @property string $carpeta_3
 * @property string $carpeta_4
 * @property string $carpeta_5
 * @property string $carpeta_completa
 * @property string $archivo
 * @property string $created_at
 * @property string $codigo_entrevista
 * @property int $id_adjunto
 * @property string $archivo_original_nombre
 * @property int $archivo_original_tamano
 * @property string $archivo_liviano_nombre
 * @property int $archivo_liviano_tamano
 * @property int $clasificacion
 * @property string $codigo_subserie
 * @property string $tipo_archivo
 */
class legado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.legado';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_legado';

    /**
     * @var array
     */
    protected $fillable = ['carpeta_1', 'carpeta_2', 'carpeta_3', 'carpeta_4', 'carpeta_5', 'carpeta_completa', 'archivo', 'created_at', 'codigo_entrevista', 'id_adjunto', 'archivo_original_ubicacion', 'archivo_original_tamano', 'archivo_original_nombre', 'archivo_original_md5', 'archivo_liviano_nombre', 'archivo_liviano_tamano', 'archivo_liviano_tamano_md5', 'clasificacion', 'codigo_subserie', 'tipo_archivo', 'codigo_archivo'];
    //protected $guarded =['id_legado'];

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


    protected $a_tipos=[];
    public $a_codigos=[];
    protected $a_subserie=[];
    protected $total_filas=0; //Filas procesadas
    protected $total_registros=0; //Registros creados

    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        //Este arreglo define los tipos de archivos que serán considerados
        $this->a_tipos[1]='Consentimiento Informado';
        $this->a_tipos[2]='Audio';
        $this->a_tipos[3]='Ficha Corta';
        $this->a_tipos[4]='Otros Documentos';
        $this->a_tipos[5]='Ficha Larga';
        $this->a_tipos[6]='Transcripción';
        $this->a_tipos[7]='Referencia';
        $this->a_tipos[11]='Relatoría';
        $this->a_tipos[12]='Certificaciones';
        $this->a_tipos[13]='Evaluación de vulnerabilidad';
        $this->a_tipos[14]='Evaluación de seguridad';
        $this->a_tipos[15]='Caso e informe';
        $this->a_tipos[17]='Certificacion inicial';
        $this->a_tipos[18]='Certificacion final';
        $this->a_tipos[21]='Plan de trabajo';
        $this->a_tipos[22]='Valoración';
        $this->a_tipos[25]='Etiquetado';
        $this->a_tipos[30]='Listado de códigos';
        //Codigos respectivos
        $this->a_codigos[1]='CI';
        $this->a_codigos[2]='AU';
        $this->a_codigos[3]='FC';
        $this->a_codigos[4]='OD';
        $this->a_codigos[5]='FL';
        $this->a_codigos[6]='TR';
        $this->a_codigos[7]='RF';
        $this->a_codigos[11]='RL';
        $this->a_codigos[12]='CR';
        $this->a_codigos[13]='EV';
        $this->a_codigos[14]='ES';
        $this->a_codigos[15]='CA';
        $this->a_codigos[17]='CN';
        $this->a_codigos[18]='CF';
        $this->a_codigos[21]='PT';
        $this->a_codigos[22]='VL';
        $this->a_codigos[25]='ET';
        $this->a_codigos[30]='LC';
        $listado = cat_item::where('id_cat',1)->get();
        foreach($listado as $fila) {
            $this->a_subserie[$fila->id_item]=$fila->abreviado;
        }

    }

    public function poblar_tabla() {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("Poblar Legado: inicio del proceso");
        //Inicializar la tabla
        legado::truncate();

        $legado = new self();


        //VI,AA,TC
        $listado = \DB::table('esclarecimiento.e_ind_fvt as entrevista')
            ->join('esclarecimiento.e_ind_fvt_adjunto as ea','entrevista.id_e_ind_fvt','=','ea.id_e_ind_fvt')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.entrevista_codigo','clasifica_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo','id_subserie')
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();

        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }

        //CO
        $id_subserie=config('expedientes.co');
        $listado = \DB::table('esclarecimiento.entrevista_colectiva as entrevista')
            ->join('esclarecimiento.entrevista_colectiva_adjunto as ea','entrevista.id_entrevista_colectiva','=','ea.id_entrevista_colectiva')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.entrevista_codigo','clasificacion_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }

        //EE
        $id_subserie=config('expedientes.ee');
        $listado = \DB::table('esclarecimiento.entrevista_etnica as entrevista')
            ->join('esclarecimiento.entrevista_etnica_adjunto as ea','entrevista.id_entrevista_etnica','=','ea.id_entrevista_etnica')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.entrevista_codigo','clasificacion_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }


        //PR
        $id_subserie=config('expedientes.pr');
        $listado = \DB::table('esclarecimiento.entrevista_profundidad as entrevista')
                    ->join('esclarecimiento.entrevista_profundidad_adjunto as ea','entrevista.id_entrevista_profundidad','=','ea.id_entrevista_profundidad')
                    ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
                    ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
                    ->select('entrevista.entrevista_codigo','clasificacion_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
                    ->orderby('entrevista_codigo')
                    //->where('id_activo',1)
                    ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }

        //DC
        $id_subserie=config('expedientes.dc');
        $listado = \DB::table('esclarecimiento.diagnostico_comunitario as entrevista')
            ->join('esclarecimiento.diagnostico_comunitario_adjunto as ea','entrevista.id_diagnostico_comunitario','=','ea.id_diagnostico_comunitario')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.entrevista_codigo','clasificacion_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }

        //HV
        $id_subserie=config('expedientes.hv');
        $listado = \DB::table('esclarecimiento.historia_vida as entrevista')
            ->join('esclarecimiento.historia_vida_adjunto as ea','entrevista.id_historia_vida','=','ea.id_historia_vida')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.entrevista_codigo','clasificacion_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }

        //CI
        $id_subserie=config('expedientes.ci');
        $listado = \DB::table('esclarecimiento.casos_informes as entrevista')
            ->join('esclarecimiento.casos_informes_adjunto as ea','entrevista.id_casos_informes','=','ea.id_casos_informes')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.codigo as entrevista_codigo','clasifica_nivel as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }

        //Mis casos
        $id_subserie=config('expedientes.mc');
        $listado = \DB::table('esclarecimiento.mis_casos as entrevista')
            ->join('esclarecimiento.mis_casos_adjunto as ea','entrevista.id_mis_casos','=','ea.id_mis_casos')
            ->join('esclarecimiento.adjunto','ea.id_adjunto','=','adjunto.id_adjunto')
            ->join('catalogos.criterio_fijo','ea.id_tipo','=','criterio_fijo.id_opcion')->where('id_grupo',1)
            ->select('entrevista.codigo as entrevista_codigo','4 as nivel', 'adjunto.ubicacion','adjunto.nombre_original','adjunto.tamano','adjunto.id_adjunto','adjunto.md5','ea.id_tipo',\DB::raw("$id_subserie as id_subserie"))
            ->orderby('entrevista_codigo')
            //->where('id_activo',1)
            ->get();


        foreach($listado as $fila) {
            $legado->crear_registro($fila);
        }



        //Fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_registros = $legado->total_registros;
        $respuesta->total_filas = $legado->total_filas;

        Log::info("Poblar Legado: fin del proceso, $respuesta->total_filas filas procesadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }


    //Escanea la tabla adjuntos por completo.  Ignora si el archivo está atachado de alguna forma
    public function poblar_tabla_total()
    {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("Poblar Legado: inicio del proceso");
        //Inicializar la tabla
        legado::truncate();

        $legado = new self();

        $listado = adjunto::orderby('id_adjunto')->get();
        foreach($listado as $adjunto) {
            $e = $adjunto->entrevista;
            if(!$e) {
                $legado->crear_registro_nulo($adjunto);
            }
            elseif($e->id_subserie==1) {
                $legado->crear_registro_documentos($adjunto);
            }
            elseif($e->id_subserie==2) {
                $legado->crear_registro_autorizacion($adjunto);
            }
            else {
                $legado->crear_registro_entrevista($adjunto);
            }
        }
        //Fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_registros = $legado->total_registros;
        $respuesta->total_filas = $legado->total_filas;

        Log::info("Poblar Legado: fin del proceso, $respuesta->total_filas filas procesadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public  function crear_registro($fila) {
        //Determinar que sea un tipo valido
        if(isset($this->a_codigos[$fila->id_tipo])) {
            $registro=[];
            $registro['carpeta_1']='R'.intval($fila->nivel);
            $registro['carpeta_2']=$this->a_subserie[$fila->id_subserie];
            $registro['carpeta_3']=substr($fila->entrevista_codigo,0,strpos("$fila->entrevista_codigo","-"));
            $registro['carpeta_completa'] =  $registro['carpeta_1'].'\\'. $registro['carpeta_2']."\\". $registro['carpeta_3']."\\";
            $registro['codigo_entrevista']=$fila->entrevista_codigo;
            $registro['id_adjunto']=$fila->id_adjunto;
            $registro['archivo_original_ubicacion'] = $fila->ubicacion;
            $registro['archivo_original_tamano'] = intval($fila->tamano);
            $registro['archivo_original_nombre'] = substr($fila->nombre_original,0,150);
            $registro['archivo_original_md5'] = $fila->md5;
            $registro['clasificacion']=$fila->nivel;
            $registro['codigo_subserie']=$fila->id_subserie;
            $registro['tipo_archivo']=$this->a_tipos[$fila->id_tipo];
            $registro['codigo_archivo']=$this->a_codigos[$fila->id_tipo];
            legado::create($registro);
            //Conteo de registros creados
            $this->total_registros++;
        }
        //conteo de filas procesadas
        $this->total_filas++;

    }

    //Adjuntos que existen en la tabla adjunto, pero no estan adjuntados en ninguna parte
    public  function crear_registro_nulo($fila) {
        //Determinar que sea un tipo valido

            $registro=[];
            $registro['carpeta_1']='XX';
            $registro['carpeta_2']='Desconocid';
            $registro['carpeta_3']='Desconocid';
            $registro['carpeta_completa'] =  $registro['carpeta_1'].'\\'. $registro['carpeta_2']."\\". $registro['carpeta_3']."\\";
            $registro['codigo_entrevista']='XX';
            $registro['id_adjunto']=$fila->id_adjunto;
            $registro['archivo_original_ubicacion'] = $fila->ubicacion;
            $registro['archivo_original_tamano'] = intval($fila->tamano);
            $registro['archivo_original_nombre'] = substr($fila->nombre_original,0,150);
            $registro['archivo_original_md5'] = $fila->md5;
            $registro['clasificacion']=1;
            $registro['codigo_subserie']=0;
            $registro['tipo_archivo']="Adjunto no ubicado";
            $registro['codigo_archivo']="XX";
            legado::create($registro);
            //Conteo de registros creados
            $this->total_registros++;
        $this->total_filas++;

    }

    //Adjuntos a un documento de referencia
    public  function crear_registro_documentos($fila) {
        //Determinar que sea un tipo valido

        $registro=[];
        $registro['carpeta_1']='XX';
        $registro['carpeta_2']='DOC';
        $registro['carpeta_3']='Referencia';
        $registro['carpeta_completa'] =  $registro['carpeta_1'].'\\'. $registro['carpeta_2']."\\". $registro['carpeta_3']."\\";
        $registro['codigo_entrevista']='XX';
        $registro['id_adjunto']=$fila->id_adjunto;
        $registro['archivo_original_ubicacion'] = $fila->ubicacion;
        $registro['archivo_original_tamano'] = intval($fila->tamano);
        $registro['archivo_original_nombre'] = substr($fila->nombre_original,0,150);
        $registro['archivo_original_md5'] = $fila->md5;
        $registro['clasificacion']=1;
        $registro['codigo_subserie']=1;
        $registro['tipo_archivo']="Adjunto a documento de referencia";
        $registro['codigo_archivo']="XX";
        legado::create($registro);
        //Conteo de registros creados
        $this->total_registros++;
        $this->total_filas++;

    }

    //Adjuntos a un autorizaciones
    public  function crear_registro_autorizacion($fila) {
        //Determinar que sea un tipo valido

        $registro=[];
        $registro['carpeta_1']='XX';
        $registro['carpeta_2']='DOC';
        $registro['carpeta_3']='Autoriza';
        $registro['carpeta_completa'] =  $registro['carpeta_1'].'\\'. $registro['carpeta_2']."\\". $registro['carpeta_3']."\\";
        $registro['codigo_entrevista']=$fila->rel_reservado_acceso->entrevista->entrevista->entrevista_codigo ?? 'DESC';
        $registro['id_adjunto']=$fila->id_adjunto;
        $registro['archivo_original_ubicacion'] = $fila->ubicacion;
        $registro['archivo_original_tamano'] = intval($fila->tamano);
        $registro['archivo_original_nombre'] = substr($fila->nombre_original,0,150);
        $registro['archivo_original_md5'] = $fila->md5;
        $registro['clasificacion']=1;
        $registro['codigo_subserie']=$fila->rel_reservado_acceso->id_subserie;
        $registro['tipo_archivo']="Autorización de acceso a adjunto";
        $registro['codigo_archivo']="XX";
        legado::create($registro);
        //Conteo de registros creados
        $this->total_registros++;
        $this->total_filas++;

    }

    //Adjuntos a alguna entrevista
    public  function crear_registro_entrevista($fila) {
        $e = $fila->entrevista;

        $registro=[];
        $registro['carpeta_1']='R'.intval($e->clasificacion_nivel);
        $registro['carpeta_2']=$this->a_subserie[$e->id_subserie];
        $registro['carpeta_3']=substr($e->entrevista_codigo,0,strpos("$e->entrevista_codigo","-"));
        $registro['carpeta_completa'] =  $registro['carpeta_1'].'\\'. $registro['carpeta_2']."\\". $registro['carpeta_3']."\\";
        $registro['codigo_entrevista']=$e->entrevista_codigo;
        $registro['id_adjunto']=$fila->id_adjunto;
        $registro['archivo_original_ubicacion'] = $fila->ubicacion;
        $registro['archivo_original_tamano'] = intval($fila->tamano);
        $registro['archivo_original_nombre'] = substr($fila->nombre_original,0,150);
        $registro['archivo_original_md5'] = $fila->md5;
        $registro['clasificacion']=$e->clasificacion_nivel ?? 0;
        $registro['codigo_subserie']=$e->id_subserie;
        $registro['tipo_archivo']= $fila->tipo_adjunto;
        $registro['codigo_archivo']=$fila->codigo_adjunto;
        legado::create($registro);
        //Conteo de registros creados
        $this->total_registros++;
        $this->total_filas++;

    }

    public static function generar_plana($total=false) {
        $tmp = new legado();
        $res = new \stdClass();
        if($total) {
            $res->poblar_tabla = $tmp->poblar_tabla_total();
        }
        else {
            $res->poblar_tabla = $tmp->poblar_tabla();
        }

        $res->buscar_livianos = self::buscar_livianos();
        return $res;
    }
    public static function revisar_codigos() {
        $tmp = new legado();
        dd(array_sort($tmp->a_codigos));
    }


    public static function buscar_livianos($reset=false) {
        if($reset) {
            legado::where('codigo_archivo','AU')
                ->update(['archivo_liviano_nombre'=>null, 'archivo_liviano_tamano'=>null,'archivo_liviano_md5'=>null]);
        }
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("Legado - buscar archivos livianos: inicio del proceso");
        $total_filas=0;
        $total_encontrados=0;

        $listado = self::whereNull('archivo_liviano_md5')->orderby('id_legado')->get();
        foreach($listado as $fila) {
            $original= $fila->archivo_original_ubicacion;
            $info=pathinfo($original);
            if(isset($info['extension'])) {
                $ext = $info['extension'];
            }
            else {
                $ext = "txt";
            }
            if($ext<>'txt') {
                if($ext=='mp3') {
                    $nuevo = $original."_64k.mp3";
                }
                else {
                    $quitar=(strlen($ext)+1)*-1;
                    //dd($quitar);
                    $nuevo = substr($original,0,$quitar);
                    $nuevo.="_64k.mp3";
                }
                $archivo="public".$nuevo;
                if(Storage::exists($archivo)) {
                    $bytes = Storage::size($archivo);
                    $fila->archivo_liviano_nombre=$nuevo;
                    $fila->archivo_liviano_tamano=$bytes;
                    //Hash del liviano
                    $fila->archivo_liviano_md5 = md5(Storage::get($archivo));
                    $total_encontrados++;
                }
                else {
                    $fila->archivo_liviano_nombre=$fila->archivo_original_ubicacion;
                    $fila->archivo_liviano_tamano=$fila->archivo_original_tamano;
                    $fila->archivo_liviano_md5   =$fila->archivo_original_md5;
                }
                $fila->save();
            }

            $total_filas++;



        }
        //Fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_encontrados = $total_encontrados;
        $respuesta->total_filas = $total_filas;

        Log::info("Legado - buscar archivos livianos: fin del proceso, $respuesta->total_filas filas procesadas. Tiempo: $respuesta->duracion.");
        return $respuesta;


    }



}
