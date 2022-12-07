<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7;
use GuzzleHttp\RequestOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



/**
 * @property string $codigo_entrevista
 * @property string $es_virtual
 * @property int $personas_entrevistadas
 * @property string $tipo_entrevista
 * @property int $nivel_de_acceso
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $codigo_entrevistador
 * @property string $grupo_entrevistador
 * @property string $entrevista_fecha
 * @property string $entrevista_mes
 * @property string $entrevista_anyo
 * @property string $tiempo_entrevista
 * @property string $entrevista_lugar_n1
 * @property string $entrevista_lugar_n2
 * @property string $entrevista_lugar_n3
 * @property string $hechos_anio_del
 * @property string $hechos_anio_al
 * @property string $sector_entrevistado
 * @property string $transcrita
 * @property string $etiquetada
 * @property string $i_objetivo_esclarecimiento
 * @property string $i_objetivo_reconocimiento
 * @property string $i_objetivo_convivencia
 * @property string $i_objetivo_no_repeticion
 * @property string $i_enfoque_genero
 * @property string $i_enfoque_psicosocial
 * @property string $i_enfoque_curso_vida
 * @property string $i_direccion_investigacion
 * @property string $i_direccion_territorios
 * @property string $i_direccion_etnica
 * @property string $i_comisionados
 * @property string $i_estrategia_arte
 * @property string $i_estrategia_comunicacion
 * @property string $i_estrategia_participacion
 * @property string $i_estrategia_pedagogia
 * @property string $i_grupo_acceso_informacion
 * @property string $i_presidencia
 * @property string $i_otra
 * @property string $i_enlace
 * @property string $i_sistema_informacion
 * @property string $ia_pueblo_etnico
 * @property string $ia_dialogo_social
 * @property string $ia_genero
 * @property string $ia_enfoque_ps
 * @property string $ia_curso_vida
 * @property string $nucleo_01
 * @property string $nucleo_02
 * @property string $nucleo_03
 * @property string $nucleo_04
 * @property string $nucleo_05
 * @property string $nucleo_06
 * @property string $nucleo_07
 * @property string $nucleo_08
 * @property string $nucleo_09
 * @property string $nucleo_10
 * @property string $mandato_01
 * @property string $mandato_02
 * @property string $mandato_03
 * @property string $mandato_04
 * @property string $mandato_05
 * @property string $mandato_06
 * @property string $mandato_07
 * @property string $mandato_08
 * @property string $mandato_09
 * @property string $mandato_10
 * @property string $mandato_11
 * @property string $mandato_12
 * @property string $mandato_13
 * @property string $a_consentimiento
 * @property string $a_audio
 * @property string $a_ficha_corta
 * @property string $a_ficha_larga
 * @property string $a_otros
 * @property string $a_transcripcion_preliminar
 * @property string $a_transcripcion_final
 * @property string $a_etiquetado
 * @property string $a_retroalimentacion
 * @property string $a_relatoria
 * @property string $a_certificacion_inicial
 * @property string $a_certificacion_final
 * @property string $a_plan_trabajo
 * @property string $a_valoracion
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property int $prioridad_e_ponderacion
 * @property int $prioridad_e_fluidez
 * @property int $prioridad_e_d_hecho
 * @property int $prioridad_e_d_contexto
 * @property int $prioridad_e_d_impacto
 * @property int $prioridad_e_d_justicia
 * @property int $prioridad_e_cierre
 * @property string $prioridad_e_ahora_entiendo
 * @property string $prioridad_e_cambio_perspectiva
 * @property string $prioridad_t_fecha
 * @property int $prioridad_t_ponderacion
 * @property int $prioridad_t_fluidez
 * @property int $prioridad_t_d_hecho
 * @property int $prioridad_t_d_contexto
 * @property int $prioridad_t_d_impacto
 * @property int $prioridad_t_d_justicia
 * @property int $prioridad_t_cierre
 * @property string $prioridad_t_ahora_entiendo
 * @property string $prioridad_t_cambio_perspectiva
 * @property string $interes_exilio
 * @property int $consentimiento_conceder_entrevista
 * @property int $consentimiento_grabar_audio
 * @property int $consentimiento_elaborar_informe
 * @property int $consentimiento_tratamiento_datos_analizar
 * @property int $consentimiento_tratamiento_datos_analizar_sensible
 * @property int $consentimiento_tratamiento_datos_utilizar
 * @property int $consentimiento_tratamiento_datos_utilizar_sensible
 * @property int $consentimiento_tratamiento_datos_publicar
 * @property string $fichas_estado_diligenciado
 * @property int $fichas_conteo_entrevistado
 * @property int $fichas_conteo_victima
 * @property int $fichas_conteo_responsable
 * @property int $fichas_conteo_hechos
 * @property int $fichas_conteo_violaciones
 * @property int $fichas_conteo_violencia
 * @property int $fichas_conteo_exilio
 */
class nvivo_clasificador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'metadatos_nvivo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'codigo_entrevista';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['es_virtual', 'personas_entrevistadas', 'tipo_entrevista', 'nivel_de_acceso', 'macroterritorio', 'territorio', 'codigo_entrevistador', 'grupo_entrevistador', 'entrevista_fecha', 'entrevista_mes', 'entrevista_anyo', 'tiempo_entrevista', 'entrevista_lugar_n1', 'entrevista_lugar_n2', 'entrevista_lugar_n3', 'hechos_anio_del', 'hechos_anio_al', 'sector_entrevistado', 'transcrita', 'etiquetada', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'a_consentimiento', 'a_audio', 'a_ficha_corta', 'a_ficha_larga', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_etiquetado', 'a_retroalimentacion', 'a_relatoria', 'a_certificacion_inicial', 'a_certificacion_final', 'a_plan_trabajo', 'a_valoracion', 'entrevista_lat', 'entrevista_lon', 'prioridad_e_ponderacion', 'prioridad_e_fluidez', 'prioridad_e_d_hecho', 'prioridad_e_d_contexto', 'prioridad_e_d_impacto', 'prioridad_e_d_justicia', 'prioridad_e_cierre', 'prioridad_e_ahora_entiendo', 'prioridad_e_cambio_perspectiva', 'prioridad_t_fecha', 'prioridad_t_ponderacion', 'prioridad_t_fluidez', 'prioridad_t_d_hecho', 'prioridad_t_d_contexto', 'prioridad_t_d_impacto', 'prioridad_t_d_justicia', 'prioridad_t_cierre', 'prioridad_t_ahora_entiendo', 'prioridad_t_cambio_perspectiva', 'interes_exilio', 'consentimiento_conceder_entrevista', 'consentimiento_grabar_audio', 'consentimiento_elaborar_informe', 'consentimiento_tratamiento_datos_analizar', 'consentimiento_tratamiento_datos_analizar_sensible', 'consentimiento_tratamiento_datos_utilizar', 'consentimiento_tratamiento_datos_utilizar_sensible', 'consentimiento_tratamiento_datos_publicar', 'fichas_estado_diligenciado', 'fichas_conteo_entrevistado', 'fichas_conteo_victima', 'fichas_conteo_responsable', 'fichas_conteo_hechos', 'fichas_conteo_violaciones', 'fichas_conteo_violencia', 'fichas_conteo_exilio'];

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


    public static function generar_plana() {
        $inicio = Carbon::now();
        Log::notice("ETL de clasificador de NVIVO: inicio del proceso");

        nvivo_clasificador::truncate();
        $total_filas=0;
        $total_fvt=0;
        $total_co=0;
        $total_ee=0;
        $total_pr=0;
        $total_dc=0;
        $total_hv=0;
        // 1. Entrevista individual  (VI, AA, TC)
        $total_fvt = self::cargar_individuales();
        $total_filas+=$total_fvt;


        // 2. Colectivas
        $total_co = self::cargar_colectivas();
        $total_filas+=$total_co;

        // 3. Entrevistas Etnicas
        $total_ee = self::cargar_etnicas();
        $total_filas+=$total_ee;
        // 4. Entrevistas a profunidad
        $total_pr = self::cargar_profundidad();
        $total_filas+=$total_pr;

        // 5. Diagnóstico comunitario
        $total_dc = self::cargar_dc();
        $total_filas+=$total_dc;

        // 6. Historia de Vida
        $total_hv = self::cargar_hv();
        $total_filas+=$total_hv;


        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->vi = $total_fvt;
        $respuesta->co = $total_co;
        $respuesta->ee = $total_ee;
        $respuesta->pr = $total_pr;
        $respuesta->dc = $total_dc;
        $respuesta->hv = $total_hv;
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;

        //Respuesta
        Log::info("ETL de clasificador de NVIVO:  fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    // Individuales: VI, AA, TC
    public static function cargar_individuales() {
        $total_filas=0;
        $listado = entrevista_individual::where('id_activo',1)->orderby('id_e_ind_fvt')->get();
        foreach($listado as $fila) {

            $excel = new nvivo_clasificador();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->es_virtual = $fila->es_virtual == 1 ? 'Sí' : 'No' ;
            $excel->personas_entrevistadas=1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->nivel_de_acceso = $fila->clasifica_nivel;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha,0,10);
            $excel->entrevista_mes = substr($fila->entrevista_fecha,0,7);
            $excel->entrevista_anyo = substr($fila->entrevista_fecha,0,4);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            //Lugar de la entrevista
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            $excel->hechos_anio_del = substr($fila->hechos_del,0,4);
            $excel->hechos_anio_al = substr($fila->hechos_al,0,4);
            //Lugar de los hechos
            $geo = $fila->rel_hechos_lugar;
            if($geo) {
                $excel->hechos_lugar_n3 = $geo->descripcion;
                $excel->hechos_lat = $geo->lat;
                $excel->hechos_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "No" : "Sí";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "No" : "Sí";
            if(!is_null($fila->fh_insert)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m-d");
                $excel->fecha_carga_mes = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m");
                $excel->fecha_carga_anio = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y");
            }
            //Interes etnico
            $excel->interes_etnico = $fila->id_etnico==1 ? "Sí" : "No";

            //Fuerzas responsables
            $aa = $fila->rel_fr;
            foreach($aa as $item) {
                $campo=$item->rel_id_fr->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Violencia
            $aa = $fila->rel_tv;
            foreach($aa as $item) {
                $campo=$item->rel_id_tv->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }

            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $tmp = $item->rel_id_mandato;
                if($tmp) {
                    $campo = $tmp->otro;
                    if(strlen($campo)>0) {
                        $excel->$campo="Sí";
                    }
                }
            }


            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',$fila->id_subserie)
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',$fila->id_subserie)
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $hay_violencia = entrevista_individual_tv::join('catalogos.cat_item','e_ind_fvt_tv.id_tv','=','id_item')
                ->where('e_ind_fvt_tv.id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.descripcion','ilike','exilio')
                ->count();
            if($hay_violencia > 0) {
                $res=1;
            }
            $excel->interes_exilio = $res==1 ? "Sí" : "No";
            if($fila->id_subserie==config('expedientes.vi')) {
                //Diligenciamiento
                $d = $fila->diligenciada;
                if($d->fichas->entrevista) {
                    $excel->consentimiento_conceder_entrevista = $d->fichas->entrevista->conceder_entrevista==1 ? "Sí": "No";
                    $excel->consentimiento_grabar_audio = $d->fichas->entrevista->grabar_audio==1 ? "Sí": "No";
                    $excel->consentimiento_elaborar_informe = $d->fichas->entrevista->elaborar_informe==1 ? "Sí": "No";
                    $excel->consentimiento_tratamiento_datos_analizar = $d->fichas->entrevista->tratamiento_datos_analizar==1 ? "Sí": "No";
                    $excel->consentimiento_tratamiento_datos_analizar_sensible = $d->fichas->entrevista->tratamiento_datos_analizar_sensible==1 ? "Sí": "No";
                    $excel->consentimiento_tratamiento_datos_utilizar = $d->fichas->entrevista->tratamiento_datos_utilizar==1 ? "Sí": "No";
                    $excel->consentimiento_tratamiento_datos_utilizar_sensible = $d->fichas->entrevista->tratamiento_datos_utilizar_sensible==1 ? "Sí": "No";
                    $excel->consentimiento_tratamiento_datos_publicar = $d->fichas->entrevista->tratamiento_datos_publicar==1 ? "Sí": "No";
                }
                $excel->fichas_estado_diligenciado = $d->situacion_texto;
                $excel->fichas_conteo_entrevistado = $d->entrevistado;
                $excel->fichas_conteo_victima = $d->victimas;
                $excel->fichas_conteo_responsable = $d->responsables;
                $excel->fichas_conteo_hechos = $d->hechos;
                $excel->fichas_conteo_violaciones = $d->violaciones;
                $excel->fichas_conteo_violencia = $d->violencia;
                $excel->fichas_conteo_exilio = $d->exilio;
            }


            $excel->save();
            $total_filas++;
        }
        return $total_filas;
    }

    // Colectivas: CO
    public static function cargar_colectivas() {
        $total_filas=0;
        $listado = entrevista_colectiva::where('id_activo',1)->orderby('entrevista_codigo')->get();
        foreach($listado as $fila) {

            $excel = new nvivo_clasificador();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->es_virtual = $fila->es_virtual == 1 ? 'Sí' : 'No' ;
            $excel->personas_entrevistadas = $fila->cantidad_participantes;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->nivel_de_acceso = $fila->clasificacion_nivel;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->entrevista_anyo = substr($fila->entrevista_fecha_inicio,0,4);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }

            $excel->hechos_anio_del = $fila->tema_del;
            $excel->hechos_anio_al =  $fila->tema_al;
            //Lugar de los hechos
            $geo = $fila->rel_tema_lugar;
            if($geo) {
                $excel->hechos_lugar_n3 = $geo->descripcion;
                $excel->hechos_lat = $geo->lat;
                $excel->hechos_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1 = $geo->descripcion;
                    }
                }
            }

            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "No" : "Sí";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "No" : "Sí";
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
                $excel->fecha_carga_mes = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
                $excel->fecha_carga_anio = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y");
            }


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }


            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.co'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.co'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }

            $excel->interes_exilio = $res==1 ? "Sí" : "No";
            //


            $excel->save();
            $total_filas++;
        }
        return $total_filas;
    }

    //Sujetos colectivos: EE
    public static function cargar_etnicas() {
        $total_filas=0;
        $listado = entrevista_etnica::where('id_activo',1)->orderby('entrevista_codigo')->get();
        foreach($listado as $fila) {

            $excel = new nvivo_clasificador();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->es_virtual = $fila->es_virtual == 1 ? 'Sí' : 'No' ;
            $excel->personas_entrevistadas = $fila->cantidad_participantes;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->nivel_de_acceso = $fila->clasificacion_nivel;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->entrevista_anyo = substr($fila->entrevista_fecha_inicio,0,4);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }

            $excel->hechos_anio_del = $fila->tema_del;
            $excel->hechos_anio_al =  $fila->tema_al;
            //Lugar de los hechos
            $geo = $fila->rel_tema_lugar;
            if($geo) {
                $excel->hechos_lugar_n3 = $geo->descripcion;
                $excel->hechos_lat = $geo->lat;
                $excel->hechos_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1 = $geo->descripcion;
                    }
                }
            }

            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "No" : "Sí";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "No" : "Sí";
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
                $excel->fecha_carga_mes = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
                $excel->fecha_carga_anio = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y");
            }


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }


            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.ee'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.ee'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }

            $excel->interes_exilio = $res==1 ? "Sí" : "No";
            //


            $excel->save();
            $total_filas++;
        }


        return $total_filas;
    }

    // Profunidad: PR
    public static function cargar_profundidad() {
        $total_filas=0;
        $listado = entrevista_profundidad::where('id_activo',1)->orderby('entrevista_codigo')->get();

        foreach($listado as $fila) {

            $excel = new nvivo_clasificador();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->es_virtual = $fila->es_virtual == 1 ? 'Sí' : 'No' ;
            $excel->personas_entrevistadas = 1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->nivel_de_acceso = $fila->clasificacion_nivel;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->entrevista_anyo = substr($fila->entrevista_fecha_inicio,0,4);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }



            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "No" : "Sí";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "No" : "Sí";
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
                $excel->fecha_carga_mes = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
                $excel->fecha_carga_anio = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y");
            }

            //Violencia de la victima
            $aa = $fila->rel_violencia_victima;
            foreach($aa as $item) {
                $campo=$item->rel_id_violencia->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Violencia del responsable
            $aa = $fila->rel_violencia_actor;
            foreach($aa as $item) {
                $campo=$item->rel_id_violencia->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }

            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }


            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.pr'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.pr'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $hay_violencia = entrevista_profundidad_violencia_actor::join('catalogos.cat_item','id_violencia','=','id_item')
                ->where('id_entrevista_profundidad',$fila->id_entrevista_profundidad)
                ->where('cat_item.descripcion','ilike','exilio')
                ->count();
            if($hay_violencia > 0) {
                $res=1;
            }
            $hay_violencia = entrevista_profundidad_violencia_victima::join('catalogos.cat_item','id_violencia','=','id_item')
                ->where('id_entrevista_profundidad',$fila->id_entrevista_profundidad)
                ->where('cat_item.descripcion','ilike','exilio')
                ->count();
            if($hay_violencia > 0) {
                $res=1;
            }

            $excel->interes_exilio = $res==1 ? "Sí" : "No";
            //


            $excel->save();
            $total_filas++;
        }


        return $total_filas;
    }

    // Diagnosticos Comunitarios
    public static function cargar_dc() {
        $total_filas=0;
        $listado = diagnostico_comunitario::where('id_activo',1)->orderby('entrevista_codigo')->get();

        foreach($listado as $fila) {

            $excel = new nvivo_clasificador();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->es_virtual = $fila->es_virtual == 1 ? 'Sí' : 'No' ;
            $excel->personas_entrevistadas = $fila->cantidad_participantes;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->nivel_de_acceso = $fila->clasificacion_nivel;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->entrevista_anyo = substr($fila->entrevista_fecha_inicio,0,4);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            $excel->hechos_anio_del = $fila->tema_del;
            $excel->hechos_anio_al =  $fila->tema_al;
            //Lugar de los hechos
            $geo = $fila->rel_tema_lugar;
            if($geo) {
                $excel->hechos_lugar_n3 = $geo->descripcion;
                $excel->hechos_lat = $geo->lat;
                $excel->hechos_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1 = $geo->descripcion;
                    }
                }
            }



            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "No" : "Sí";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "No" : "Sí";
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
                $excel->fecha_carga_mes = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
                $excel->fecha_carga_anio = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y");
            }


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }


            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.dc'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.dc'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res==1 ? "Sí" : "No";
            //


            $excel->save();
            $total_filas++;
        }
        return $total_filas;
    }

    // Historia de vida
    public static function cargar_hv() {
        $total_filas=0;
        $listado = historia_vida::where('id_activo',1)->orderby('entrevista_codigo')->get();

        foreach($listado as $fila) {

            $excel = new nvivo_clasificador();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->es_virtual = $fila->es_virtual == 1 ? 'Sí' : 'No' ;
            $excel->personas_entrevistadas = 1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->nivel_de_acceso = $fila->clasificacion_nivel;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = substr($fila->entrevista_fecha_inicio,0,10);
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->entrevista_anyo = substr($fila->entrevista_fecha_inicio,0,4);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }



            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "No" : "Sí";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "No" : "Sí";
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
                $excel->fecha_carga_mes = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
                $excel->fecha_carga_anio = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y");
            }


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo="Sí";
                }
            }


            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.hv'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.hv'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res==1 ? "Sí" : "No";
            //


            $excel->save();
            $total_filas++;
        }
        return $total_filas;
    }

    public static function scopePermitidos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('id_entrevistador',$arreglo_entrevistadores);
    }

    //Para usarla en todos los instrumentos
    public static function procesar_prioridad_e($excel,$prioridad) {
        if($prioridad) {//Puedo recibir valores nulos
            $excel->prioridad_e_fecha = substr($prioridad->fecha_hora,0,10);
            $excel->prioridad_e_fluidez = $prioridad->fluidez;
            $excel->prioridad_e_d_hecho = $prioridad->d_hecho;
            $excel->prioridad_e_d_contexto = $prioridad->d_contexto;
            $excel->prioridad_e_d_impacto = $prioridad->d_impacto;
            $excel->prioridad_e_d_justicia = $prioridad->d_justicia;
            $excel->prioridad_e_cierre = $prioridad->cierre;
            $excel->prioridad_e_ponderacion = $prioridad->ponderacion;
            $excel->prioridad_e_ahora_entiendo = $prioridad->ahora_entiendo;
            $excel->prioridad_e_cambio_perspectiva = $prioridad->cambio_perspectiva;
        }

    }

    //Para usarla en todos los instrumentos
    public static function procesar_prioridad_t($excel,$prioridad) {
        if($prioridad) { //Puedo recibir valores nulos
            $excel->prioridad_t_fecha = substr($prioridad->fecha_hora,0,10);
            $excel->prioridad_t_fluidez = $prioridad->fluidez;
            $excel->prioridad_t_d_hecho = $prioridad->d_hecho;
            $excel->prioridad_t_d_contexto = $prioridad->d_contexto;
            $excel->prioridad_t_d_impacto = $prioridad->d_impacto;
            $excel->prioridad_t_d_justicia = $prioridad->d_justicia;
            $excel->prioridad_t_cierre = $prioridad->cierre;
            $excel->prioridad_t_ponderacion = $prioridad->ponderacion;
            $excel->prioridad_t_ahora_entiendo = $prioridad->ahora_entiendo;
            $excel->prioridad_t_cambio_perspectiva = $prioridad->cambio_perspectiva;
        }
    }



    /**
     * Manejo del WebService que exporta a NVIVO
     */
    //Recibe un arreglo de codigos de entrevistas y devuelve un QDPX
    public static function generar_qdpx($listado_codigos=array()) {
        //Respuesta al cliente
        $res = new \stdClass();
        $res->listado = $listado_codigos;  //Listado original
        $res->archivo = null;  //Si hay exito, ubicación del archivo que proporciona el web service
        $res->listado_valido = array();
        $res->listado_rechazo = array();
        $res->qdpx = null; //Respusta del Web Service
        $res->exito = false;  //banderita
        $res->mensaje = null; //mensajes de error
        $res->descarga = null; //Response para el controller

        //Extraer los JSON involucrados
        $arreglo_entrevistas=array();
        $arreglo_json=array();
        $arreglo_rechazo=array();
        foreach($listado_codigos as $buscar) {
            $buscar=trim($buscar);
            $buscar=str_replace(" ","-",$buscar);
            $buscar=str_replace(".","-",$buscar);
            $buscar=strtolower($buscar);
            $e=false;
            if(strlen($buscar)>=6) { // xxx-vi-
                if(strstr($buscar,'-vi-')){
                    $e = entrevista_individual::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-aa-')) {
                    $e = entrevista_individual::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-tc-')) {
                    $e = entrevista_individual::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-co-')) {
                    $e = entrevista_colectiva::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-ee-')) {
                    $e = entrevista_etnica::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-pr-')) {
                    $e = entrevista_profundidad::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-dc-')) {
                    $e = diagnostico_comunitario::where('entrevista_codigo','ilike',$buscar)->first();
                }
                elseif(strstr($buscar,'-hv-')) {
                    $e = historia_vida::where('entrevista_codigo','ilike',$buscar)->first();
                }

            }
            if($e) {
                //Permisos de acceso
                if($e->clasificacion_nivel >= 3) {  //Nunca exportar R1 o R2
                    if($e->puede_acceder_adjuntos()) {
                        if(strlen($e->json_etiquetado)>0) {
                            $arreglo_entrevistas[$buscar]=$buscar;
                            $arreglo_json[$buscar]=$e->json_etiquetado;
                        }
                        else {
                            $arreglo_rechazo['sin_etiquetado'][]=$buscar;
                        }
                    }
                    else {
                        $arreglo_rechazo['sin_acceso'][]=$buscar;
                    }
                }
                else {
                    $arreglo_rechazo['r1_r2'][]=$buscar;
                }

            }
            else {
                $arreglo_rechazo['no_existe'][]=$buscar;
            }
        }
        //Consumir el web service
        $arreglo_ws=array();
        if(count($arreglo_json)>0) {
            foreach($arreglo_json as $codigo => $etiquetado) {
                $tmp[0]=new \stdClass();
                $tmp[0]->name = mb_strtoupper($codigo);
                $etiquetado = \GuzzleHttp\json_decode($etiquetado);
                //El web service pide el arreglo ordenado de forma distinta.  En este paso, reorganizo el json
                $cambiado = new \stdClass();
                $cambiado->annotation = $etiquetado->annotation;
                $cambiado->content = $etiquetado->content;
                $cambiado->extras = $etiquetado->extras;
                $cambiado->metadata = $etiquetado->metadata;
                $tmp[1]=$cambiado;
                $arreglo_ws[] = $tmp;
            }
            //dd($arreglo_ws);
            $json=\GuzzleHttp\json_encode($arreglo_ws);
            //dd($json);
            $qdpx = self::ws_qdpx($json);
            dd($qdpx);
            $res->qdpx = $qdpx;
            if($qdpx->exito) {
                $res->exito = true;
                $res->archivo = $qdpx->archivo_final;
                $res->descarga = $qdpx->descarga;
            }
            else {
                $res->exito = false;
                $res->mensaje = "Problemas al consumir el WS: ".PHP_EOL.$qdpx->mensaje;
            }
        }
        else {
            $res->exito = false;
            $res->mensaje = "No se especificó ninguna entrevista con etiquetado";
        }

        $res->listado_rechazo = $arreglo_rechazo;
        $res->listado_valido = $arreglo_entrevistas;


        return $res;
    }

    /*
     * Consumir el WebService que genera QDPX
     * Recibe el JSON que es un arreglo de entrevistas con su etiquetado
     * Devuelve el contenido de un archivo que tiene formato QDPX.
     * Ojo que el QDPX es un archivo binario
     */
    public static function ws_qdpx($json) {
        $inicio = Carbon::now();
        $url = config('expedientes.ws_nvivo');
        //Respuesta al usuario
        $r = new \stdClass();
        $r->inicio = null; //Para calculo del tiempo
        $r->fin = null; //Para calculo del tiempo
        $r->respuesta = null; //Respuesta del webservice
        $r->destino=null;  //Nombre del archivo que guarda la respuesta
        $r->destino_url=null;  //Ubicación (path completo) del archivo que guarda la respuesta
        $r->archivo_final=null; //Ubicación (path relativo a public) del archivo que guarda la respuesta
        $r->descarga = null; // PAra los Controller
        $r->url = $url;  //URL del web service
        $r->exito=false; //Bandera para saber como nos fué
        $r->duracion = null;  //Tiempo utilizado por el WS
        $r->json = $json;  //JSON recibido para procesar
        $r->mensaje = null;  //Mensajes de error

        //Archivo que recibe el resultado del WS
        $nuevo_nombre = uniqid() . '.qdpx';
        $mes=date("Ym");
        $nuevo_nombre = "tmp/$mes/".$nuevo_nombre;
        $r->destino= $nuevo_nombre;
        $r->destino_url = public_path("/storage/$nuevo_nombre");
        $r->archivo_final = 'storage/'.$r->destino;

        //Por si acaso, creo el directorio tmp con el Ym
        $path=public_path("/storage/tmp/$mes");
        if(!\File::exists($path)) {
            @\File::makeDirectory($path, $mode = 0744, true, true);
        }


        //Consumir WS
        $client = new Client();
        try {
            $response = $client->get($url, [
                'multipart' => [
                    [
                        'name'     => 'file_uploaded',
                        'contents' => $json,
                        'filename' => 'comision.json'
                    ]
                ]
                , 'sink' => $r->destino_url  //Este parametro es el que descarga el archivo.  la respuesta del WS es "application/force-download"

            ]);
            $r->exito=true;
            $r->respuesta = $response;
            //Descarga
            if(\Auth::check()) {
                $codigo = \Auth::user()->fmt_numero_entrevistador;
            }
            else {
                $codigo="XXX";
            }
            $fecha=date("Y-m-d");
            $descarga = $fecha."_".$codigo."_etiquetado.qdpx";
            $path = "public/";
            //$archivo = url($path.$res->archivo_final);
            $archivo = base_path($path.$r->archivo_final);

            $debug['path']=$path;
            $debug['original']=$r->archivo_final;
            $debug['ubicacion']=$archivo;
            $debug['existe']=file_exists($archivo);
            //dd($debug);

            //Response para la descarga
            $r->descarga = \Response::download($archivo,$descarga);
        }
        catch(RequestException $e){
            $r->exito=false;
            $error[]= "WS: Problemas al consumir el servicio que genera QDPX $url";
            $error[] = "ERROR:".$e->getMessage();
            //$error[] = 'REQUEST: '.Psr7\Message::toString($e->getRequest());
            if($e->hasResponse()) {
                $error[] = 'STATUS_CODE: '.$e->getResponse()->getStatusCode();
                $error[] = 'RESPONSE: '.Psr7\Message::toString($e->getResponse());
            }

            $r->mensaje = implode(PHP_EOL,$error);
            \Log::error($r->mensaje);
        }
        catch(ServerException $e) {
            $r->exito = false;
            $error[] = "Problemas al consumir el servicio que genera QDPX $url";
            $error[]  = PHP_EOL.$e->getMessage();
            if($e->getStatusCode()) {
                    $error[] = 'STATUS_CODE'.$e->getStatusCode();
            }
            $r->mensaje = implode(PHP_EOL,$error);
            \Log::error($r->mensaje);
        }

        //control de tiempo
        $fin = Carbon::now();
        $r->inicio = $inicio;
        $r->fin = $fin;
        $r->duracion = $fin->diffForHumans($inicio);

        return $r;

    }
    public static function test_ws_nvivo($archivo = 'formato_qdpx.json') {

        $ubicacion = base_path();
        $contenido = file_get_contents($ubicacion."/resources/".$archivo);
        $json = \GuzzleHttp\json_decode($contenido);
        //return $json;
        $res = self::ws_qdpx(\GuzzleHttp\json_encode($json));
        return $res;
    }

}
