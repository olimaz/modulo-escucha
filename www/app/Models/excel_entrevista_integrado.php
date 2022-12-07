<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $tipo_entrevista
 * @property string $codigo_entrevista
 * @property int $clasificacion_nivel
 * @property int $clasificacion_nna
 * @property int $clasificacion_sex
 * @property int $clasificacion_res
 * @property int $clasificacion_r1
 * @property int $clasificacion_r2
 * @property int $personas_entrevistadas
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $codigo_entrevistador
 * @property string $grupo_entrevistador
 * @property string $entrevista_fecha
 * @property string $entrevista_mes
 * @property string $tipo_especifico
 * @property string $tema
 * @property string $objetivo
 * @property int $tiempo_entrevista
 * @property string $entrevista_lugar_n1
 * @property string $entrevista_lugar_n2
 * @property string $entrevista_lugar_n3
 * @property string $hechos_anio_del
 * @property string $hechos_anio_al
 * @property string $sector_entrevistado
 * @property int $i_objetivo_esclarecimiento
 * @property int $i_objetivo_reconocimiento
 * @property int $i_objetivo_convivencia
 * @property int $i_objetivo_no_repeticion
 * @property int $i_enfoque_genero
 * @property int $i_enfoque_psicosocial
 * @property int $i_enfoque_curso_vida
 * @property int $i_direccion_investigacion
 * @property int $i_direccion_territorios
 * @property int $i_direccion_etnica
 * @property int $i_comisionados
 * @property int $i_estrategia_arte
 * @property int $i_estrategia_comunicacion
 * @property int $i_estrategia_participacion
 * @property int $i_estrategia_pedagogia
 * @property int $i_grupo_acceso_informacion
 * @property int $i_presidencia
 * @property int $i_otra
 * @property int $i_enlace
 * @property int $i_sistema_informacion
 * @property int $ia_pueblo_etnico
 * @property int $ia_dialogo_social
 * @property int $ia_genero
 * @property int $ia_enfoque_ps
 * @property int $ia_curso_vida
 * @property int $nucleo_01
 * @property int $nucleo_02
 * @property int $nucleo_03
 * @property int $nucleo_04
 * @property int $nucleo_05
 * @property int $nucleo_06
 * @property int $nucleo_07
 * @property int $nucleo_08
 * @property int $nucleo_09
 * @property int $nucleo_10
 * @property int $mandato_01
 * @property int $mandato_02
 * @property int $mandato_03
 * @property int $mandato_04
 * @property int $mandato_05
 * @property int $mandato_06
 * @property int $mandato_07
 * @property int $mandato_08
 * @property int $mandato_09
 * @property int $mandato_10
 * @property int $mandato_11
 * @property int $mandato_12
 * @property int $mandato_13
 * @property int $a_consentimiento
 * @property int $a_audio
 * @property int $a_ficha_corta
 * @property int $a_ficha_larga
 * @property int $a_relatoria
 * @property int $a_otros
 * @property int $a_transcripcion_preliminar
 * @property int $a_transcripcion_final
 * @property int $a_retroalimentacion
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property string $fecha_carga
 * @property string $mes_carga
 * @property int $id_entrevistador
 * @property int $es_virtual
 * @property int $interes_exilio
 * @property int $procesamiento_requisitos_minimos
 * @property string $fecha_cierre
 * @property string $mes_cierre
 * @property string $entrevistada_nombres
 * @property string $entrevistada_apellidos
 * @property string $entrevistada_sexo
 * @property string $entrevistada_edad
 * @property string $entrevistada_es_victima
 * @property string $entrevistada_es_testigo
 *
 *
 */
class excel_entrevista_integrado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_entrevista_integrado';

    /**
     * @var array
     */
    protected $fillable = ['tipo_entrevista', 'codigo_entrevista', 'clasificacion', 'macroterritorio', 'territorio', 'codigo_entrevistador', 'grupo_entrevistador', 'entrevista_fecha', 'entrevista_mes', 'tiempo_entrevista', 'entrevista_lugar_n1', 'entrevista_lugar_n2', 'entrevista_lugar_n3', 'hechos_anio_del', 'hechos_anio_al', 'sector_entrevistado', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'a_consentimiento', 'a_audio', 'a_ficha_corta', 'a_ficha_larga', 'a_relatoria', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_retroalimentacion', 'entrevista_lat', 'entrevista_lon', 'fecha_carga', 'mes_carga','id_entrevistador'];

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


    //Para pruebas
    public static function generar_plana_hv() {
        $inicio = Carbon::now();
        //Log::notice("ETL de integrado de entrevistas: inicio del proceso");

        excel_entrevista_integrado::truncate();
        $total_hv = self::cargar_hv();
        $total_filas=$total_hv;
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->hv = $total_hv;
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        return $respuesta;

    }

    public static function generar_plana() {
        $inicio = Carbon::now();
        Log::notice("ETL de integrado de entrevistas: inicio del proceso");

        excel_entrevista_integrado::truncate();
        $total_filas=0;
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




        //Segundo grupo: Sujetos colectivos

        Log::info("ETL de integrado de entrevistas: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");



        return $respuesta;

    }

    // Individuales: VI, AA, TC
    public static function cargar_individuales() {
        $total_filas=0;
        $listado = entrevista_individual::where('id_activo',1)->orderby('id_subserie')->orderby('id_e_ind_fvt')->get();


        foreach($listado as $fila) {
            $excel = new excel_entrevista_integrado();
            $excel->personas_entrevistadas=1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha;
            $excel->entrevista_mes = substr($fila->entrevista_fecha,0,7);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo = "entrevista_lugar_n".$nivel;
                $excel->$campo = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            $excel->hechos_anio_del = substr($fila->hechos_del,0,4);
            $excel->hechos_anio_al = substr($fila->hechos_al,0,4);
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                if($i<=3) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }
                $i++;
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



            //Transcripcion y etiquetado
            self::procesar_procesamiento($excel,$fila);
            //Diligenciamiento
            $d = $fila->diligenciada;

            $excel->fichas_estado_diligenciado = $d->situacion_texto;
            $excel->fichas_conteo_entrevistado = $d->entrevistado;
            $excel->fichas_conteo_victima = $d->victimas;
            $excel->fichas_conteo_responsable = $d->responsables;
            $excel->fichas_conteo_hechos = $d->hechos;
            $excel->fichas_conteo_violaciones = $d->violaciones;
            $excel->fichas_conteo_violencia = $d->violencia;
            $excel->fichas_conteo_exilio = $d->exilio;
            $excel->fichas_conteo_alertas = $d->alerta_conteo;
            //Tiempos
            $tiempo = $fila->tiempo_procesamiento;
            if($tiempo) {
                $excel->minutos_entrevista = $tiempo[0];
                $excel->minutos_transcripcion = $tiempo[1];
                $excel->minutos_etiquetado= $tiempo[2];
                $excel->minutos_diligenciado= $tiempo[2];
            }

            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }



            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            //dd($fila->fh_insert);
            if(!is_null($fila->fh_insert)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;

            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
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
            $excel->interes_exilio = $res;





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
            $excel = new excel_entrevista_integrado();
            $excel->personas_entrevistadas=$fila->cantidad_participantes;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo = "entrevista_lugar_n".$nivel;
                $excel->$campo = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            /*
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            */

            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //
            $excel->tema = $fila->tema_descripcion;
            $excel->objetivo = $fila->tema_objetivo;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                if($i<=3) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }
                $i++;
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

            //Procesamiento
            //Transcripcion y etiquetado
            self::procesar_procesamiento($excel,$fila);


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }



            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            //dd($fila->fh_insert);
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;

            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res;


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
            $excel = new excel_entrevista_integrado();
            $excel->personas_entrevistadas=$fila->cantidad_participantes;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->tiempo_entrevista = $fila->duracion_entrevista_minutos;
            //
            $excel->tema = $fila->tema_descripcion;
            $excel->objetivo = $fila->tema_objetivo;
            $excel->tipo_especifico = $fila->fmt_id_tipo_entrevista;
            //
            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo = "entrevista_lugar_n".$nivel;
                $excel->$campo = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            /*
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            */

            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                if($i<=3) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }
                $i++;
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

            //Procesamiento: transcripción, etiquetado y cierre
            self::procesar_procesamiento($excel,$fila);


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }



            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            //dd($fila->fh_insert);
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;

            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res;


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
            $excel = new excel_entrevista_integrado();
            $excel->personas_entrevistadas = 1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo = "entrevista_lugar_n".$nivel;
                $excel->$campo = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            /*
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            */

            $excel->hechos_anio_del = 'PR: No Aplica';
            $excel->hechos_anio_al = 'PR: No Aplica';
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            //
            //$excel->tema = $fila->tema_descripcion;
            $excel->objetivo = $fila->entrevista_objetivo;
            $excel->tipo_especifico = $fila->fmt_id_tipo;
            //
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                if($i<=3) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }
                $i++;
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

            //Procesamiento: transcripción, etiquetado y cierre
            self::procesar_procesamiento($excel,$fila);


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }



            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            //dd($fila->fh_insert);
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;

            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $hay_violencia = entrevista_profundidad_violencia_actor::join('catalogos.cat_item','entrevista_profundidad_violencia_actor.id_violencia','=','id_item')
                ->where('entrevista_profundidad_violencia_actor.id_entrevista_profundidad',$fila->id_entrevista_profundidad)
                ->where('cat_item.descripcion','ilike','exilio')
                ->count();
            if($hay_violencia > 0) {
                $res=1;
            }
            $hay_violencia = entrevista_profundidad_violencia_victima::join('catalogos.cat_item','entrevista_profundidad_violencia_victima.id_violencia','=','id_item')
                ->where('entrevista_profundidad_violencia_victima.id_entrevista_profundidad',$fila->id_entrevista_profundidad)
                ->where('cat_item.descripcion','ilike','exilio')
                ->count();
            if($hay_violencia > 0) {
                $res=1;
            }
            $excel->interes_exilio = $res;


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
            $excel = new excel_entrevista_integrado();
            $excel->personas_entrevistadas=$fila->cantidad_participantes;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;

            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo = "entrevista_lugar_n".$nivel;
                $excel->$campo = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            /*
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            */

            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //
            $excel->tema = $fila->tema_comunidad;
            $excel->objetivo = $fila->tema_objetivo;
            //$excel->tipo_especifico = $fila->fmt_id_tipo;
            //
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                if($i<=3) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }
                $i++;
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

            //Procesamiento: transcripción, etiquetado y cierre
            self::procesar_procesamiento($excel,$fila);


            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }


            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            //dd($fila->fh_insert);
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;
            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res;


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
            $excel = new excel_entrevista_integrado();
            $excel->personas_entrevistadas = 1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo = "entrevista_lugar_n".$nivel;
                $excel->$campo = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            /*
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            */

            $excel->hechos_anio_del = "HV: No Aplica";
            $excel->hechos_anio_al =  "HV: No Aplica";
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //
            //$excel->tema = $fila->tema_comunidad;
            $excel->objetivo = $fila->entrevista_objetivo;
            //$excel->tipo_especifico = $fila->fmt_id_tipo;
            //
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                if($i<=3) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }
                $i++;
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

            //Procesamiento: transcripción, etiquetado y cierre
            self::procesar_procesamiento($excel,$fila);
            //Procesamiento: transcripción, etiquetado y cierre



            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }


            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }
            //dd($fila->fh_insert);
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;
            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res;
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

    public static function procesar_procesamiento($excel, $fila) {
        //Transcripcion
        $excel->transcrita = is_null($fila->html_transcripcion) ? 0 : 1;
        if($excel->transcrita==1) {
            $transcripcion = transcribir_asignacion::tiene_transcripcion($fila);
            if($transcripcion) {
                //$excel->transcrita=1;
                $excel->transcrita_fecha = substr($transcripcion->fh_transcrito,0,10);
                $excel->transcrita_fecha_a = substr($transcripcion->fh_transcrito,0,4);
                $excel->transcrita_fecha_m = substr($transcripcion->fh_transcrito,0,7);
            }
            $excel->conteo_caracteres = strlen(trim(strip_tags($fila->html_transcripcion)));  //Tamaño de la transcripcion
        }

        //Etiquetado
        $excel->etiquetada = is_null($fila->json_etiquetado) ? 0 : 1;
        if($excel->etiquetada==1) {
            $etiquetado = etiquetar_asignacion::tiene_etiquetado($fila);
            if($etiquetado) {
                //$excel->etiquetada=1;
                $excel->etiquetada_fecha = substr($etiquetado->fh_transcrito,0,10);
                $excel->etiquetada_fecha_a = substr($etiquetado->fh_transcrito,0,4);
                $excel->etiquetada_fecha_m = substr($etiquetado->fh_transcrito,0,7);
            }
            $excel->conteo_etiquetas = etiqueta_entrevista::conteo_etiquetas($fila);
        }
        //Cerrada
        $excel->procesamiento_transcrito = $excel->transcrita;
        $excel->procesamiento_etiquetado = $excel->etiquetada;
        //Cerrado?
        $excel->procesamiento_cerrado = $fila->id_cerrado ==1 ? 1 : 0 ;
        //Conteo de consultas
        $excel->conteo_consultas = \App\Models\entrevista_individual::conteo_hits($fila);
        //Datos del entrevistado
        $entrevistado = $fila->rel_persona_entrevistada;
        if($entrevistado) {
            $persona = $entrevistado->rel_id_persona;
            $excel->entrevistada_nombres = $persona->nombre;
            $excel->entrevistada_apellidos = $persona->apellido;
            $excel->entrevistada_sexo = cat_item::describir($persona->id_sexo);
            $excel->entrevistada_edad = $entrevistado->calcular_edad();
            $excel->entrevistada_es_victima = $entrevistado->es_victima == 1 ? 1 : 0;
            $excel->entrevistada_es_testigo = $entrevistado->es_testigo == 1 ? 1 : 0;
        }
        //consentimiento informado
        $consentimiento = $fila->rel_consentimiento;
        if($consentimiento instanceof entrevista) {
            $excel->consentimiento_conceder_entrevista = $consentimiento->conceder_entrevista==1 ? 1: 0;
            $excel->consentimiento_grabar_audio = $consentimiento->grabar_audio==1 ? 1: 0;
            $excel->consentimiento_elaborar_informe = $consentimiento->elaborar_informe==1 ? 1: 0;
            $excel->consentimiento_tratamiento_datos_analizar = $consentimiento->tratamiento_datos_analizar==1 ? 1: 0;
            $excel->consentimiento_tratamiento_datos_analizar_sensible = $consentimiento->tratamiento_datos_analizar_sensible==1 ? 1: 0;
            $excel->consentimiento_tratamiento_datos_utilizar = $consentimiento->tratamiento_datos_utilizar==1 ? 1: 0;
            $excel->consentimiento_tratamiento_datos_utilizar_sensible = $consentimiento->tratamiento_datos_utilizar_sensible==1 ? 1: 0;
            $excel->consentimiento_tratamiento_datos_publicar = $consentimiento->tratamiento_datos_publicar==1 ? 1: 0;
        }

        //Fecha en que se cierra el expediente
        $seguimiento = $fila->rel_seguimiento()->orderby('id_seguimiento','desc')->first();
        if($seguimiento) {
            if($seguimiento->id_cerrado==1) {
                $excel->fecha_cierre = substr($seguimiento->fecha_hora,0,10);
                $excel->mes_cierre = substr($seguimiento->fecha_hora,0,7);
            }
            else {
                $excel->fecha_cierre = "Abierto";
                $excel->mes_cierre = "Abierto";
            }
        }
        else {
            $excel->fecha_cierre = "Abierto";
            $excel->mes_cierre = "Abierto";
        }
        //clasificación de la entrevista
        $excel->clasificacion_nivel = $fila->clasificacion_nivel;
        $excel->clasificacion_nna = $fila->clasificacion_nna == 1 ? 1 : 0;
        $excel->clasificacion_sex = $fila->clasificacion_sex == 1 ? 1 : 0;;
        $excel->clasificacion_res = $fila->clasificacion_res  == 1 ? 1 : 0;;
        $excel->clasificacion_r1 = $fila->clasificacion_r1 == 1 ? 1 : 0;;
        $excel->clasificacion_r2 = $fila->clasificacion_r2 == 1 ? 1 : 0;;

        //Adjuntos: en lugar de 1/0 indicar cantidad de cada tipo de adjuntos
        $adjuntos[1]="a_consentimiento";
        $adjuntos[2]="a_audio";
        $adjuntos[3]="a_ficha_corta";
        $adjuntos[5]="a_ficha_larga";
        $adjuntos[11]="a_relatoria";
        $adjuntos[8]="a_transcripcion_preliminar";
        $adjuntos[6]="a_transcripcion_final";
        $adjuntos[15]="a_casos_informes";
        $adjuntos[25]="a_etiquetado";
        $adjuntos[4]="a_otros";
        $adjuntos[20]="a_autorizaciones";
        $adjuntos[7]="a_referencias";
        $adjuntos[21]="a_plan_trabajo";
        $adjuntos[22]="a_valoracion";
        $adjuntos[12]="a_certificaciones";
        $adjuntos[17]="a_certificacion_inicial";
        $adjuntos[18]="a_certificacion_final";
        $adjuntos[13]="a_evaluacion_vulnerabilidad";
        $adjuntos[14]="a_evaluacion_seguridad";
        $adjuntos[10]="a_retroalimentacion";
        $adjuntos[16]="a_otranscribe";
        //
        $adjuntos[23]="a_comunicacion_oficial";


        $totales = $fila->rel_adjunto()
                    ->select(\DB::raw('count(*) as conteo, id_tipo'))
                        ->groupby('id_tipo')
                        ->get();
        $total_adjuntos=0;
        foreach($totales as $tmp) {
            $campo = $adjuntos[$tmp->id_tipo];
            $excel->$campo = $tmp->conteo;
            $total_adjuntos+=$tmp->conteo;
        }
        $excel->a_total_adjuntos = $total_adjuntos;

        //Por menso, el campo se llama diferente
        $ultimo_adjunto=false;

        if(isset($fila->id_e_ind_fvt)) {
            $ultimo_adjunto =  $fila->rel_adjunto()->max('fh_insert');
        }
        else {
            $ultimo_adjunto =  $fila->rel_adjunto()->max('created_at');
        }
        if($ultimo_adjunto) {
            $fecha = new Carbon($ultimo_adjunto);
            $excel->max_fecha_adjunto = $fecha->format("Y-m-d");
            $excel->max_mes_adjunto = $fecha->format("Y-m");
        }



    }

    public static function encabezados() {
        $encabezados['id']='Identificador único del listado del integrado';
        $encabezados['codigo_entrevista']='código de la entrevista';
        $encabezados['personas_entrevistadas']='cantidad de personas entrevistadas';
        $encabezados['es_virtual']='Esta entrevista se realizó por medios virtuales';
        $encabezados['situacion_actual']='Avance de la entrevista';
        $encabezados['clasificacion_nivel']='Clasificación de la entrevista (R1-R4)';
        $encabezados['clasificacion_nna']='Clasificación: es entrevista de NNA';
        $encabezados['clasificacion_sex']='Clasificación: inlcluye violencia sexual';
        $encabezados['clasificacion_res']='Clasificación: inlcluye reconocimiento de responsabilidades';
        $encabezados['clasificacion_r1']='Clasificación: clasificación manual a R2';
        $encabezados['clasificacion_r2']='Clasificación: clasificación manual a R1';
        $encabezados['macroterritorio']='Macroterritorio donde se realiza la entrevista';
        $encabezados['territorio']='Territorio donde se realiza la entrevista';
        $encabezados['codigo_entrevistador']='Código del entrevistador';
        $encabezados['grupo_entrevistador']='Grupo al que pertenece el entrevistador';
        $encabezados['entrevista_fecha']='Fecha de la entrevista';
        $encabezados['entrevista_mes']='Mes de la entrevista';
        $encabezados['tiempo_entrevista']='Duración de la entrevista en minutos';
        $encabezados['entrevista_lugar_n1']='Departamento donde se realiza la entrevista';
        $encabezados['entrevista_lugar_n2']='Municipio donde se realiza la entrevista';
        $encabezados['entrevista_lugar_n3']='Vereda donde se realiza la entrevista';
        $encabezados['hechos_anio_del']='Hechos, año de inicio';
        $encabezados['hechos_anio_al']='Hecho, año de finalización';
        $encabezados['sector_entrevistado']='Sector con el que se puede identificar las víctimas del relato';
        $encabezados['conteo_consultas']='Cantidad de veces que la entrevista ha sido consultada';
        $encabezados['interes_exilio']='Es una entrevista de interés para el equipo e exiio';
        $encabezados['tipo_entrevista']='Tipo de entrevista';
        $encabezados['titulo']='Título de la entrevsita';
        $encabezados['dinamica_1']='Dínamicas identificadas en la entrevista';
        $encabezados['dinamica_2']='Dínamicas identificadas en la entrevista';
        $encabezados['dinamica_3']='Dínamicas identificadas en la entrevista';
        $encabezados['transcrita']='Entrevista transcrita?';
        $encabezados['conteo_caracteres']='Cantidad de caracteres en la transcripción';
        $encabezados['transcrita_fecha']='Fecha de la transcripción';
        $encabezados['transcrita_fecha_a']='Año de la transcripción';
        $encabezados['transcrita_fecha_m']='Mes de la transcripción';
        $encabezados['etiquetada']='Entrevista etiquetada?';
        $encabezados['conteo_etiquetas']='Cantidad de etiquetas en la entrevista';
        $encabezados['etiquetada_fecha']='Fecha del etiquetado';
        $encabezados['etiquetada_fecha_a']='Año del etiquetado';
        $encabezados['etiquetada_fecha_m']='Mes del etiquetado';
        $encabezados['i_objetivo_esclarecimiento']='De interés para: Esclarecimiento';
        $encabezados['i_objetivo_reconocimiento']='De interés para: Reconocimiento';
        $encabezados['i_objetivo_convivencia']='De interés para: Convivencia';
        $encabezados['i_objetivo_no_repeticion']='De interés para: No Repetición';
        $encabezados['i_enfoque_genero']='De interés para: Enfoque de género';
        $encabezados['i_enfoque_psicosocial']='De interés para: Psicosocial';
        $encabezados['i_enfoque_curso_vida']='De interés para: Curso de Vida';
        $encabezados['i_direccion_investigacion']='De interés para: Dirección de investigación';
        $encabezados['i_direccion_territorios']='De interés para: Territorios';
        $encabezados['i_direccion_etnica']='De interés para: Dirección étnica';
        $encabezados['i_comisionados']='De interés para: Comisionados';
        $encabezados['i_estrategia_arte']='De interés para: Estrategia - Arte';
        $encabezados['i_estrategia_comunicacion']='De interés para: Estrategia - Comunicación';
        $encabezados['i_estrategia_participacion']='De interés para: Estrategia - Participación';
        $encabezados['i_estrategia_pedagogia']='De interés para: Estrategia - Pedagogía';
        $encabezados['i_grupo_acceso_informacion']='De interés para: Grupo de Acceso a la información';
        $encabezados['i_presidencia']='De interés para: Presidencia';
        $encabezados['i_otra']='De interés para: Otros';
        $encabezados['i_enlace']='De interés para: Enlace interinstitucional';
        $encabezados['i_sistema_informacion']='De interés para: SIM';
        $encabezados['ia_pueblo_etnico']='De interés para el área: Pueblos Étnicos';
        $encabezados['ia_dialogo_social']='De interés para el área: Diálogo social';
        $encabezados['ia_genero']='De interés para el área: Género';
        $encabezados['ia_enfoque_ps']='De interés para el área: Enfoque psico social';
        $encabezados['ia_curso_vida']='De interés para el área: Curso de Vida';
        $encabezados['nucleo_01']='De interés para el área: Núcleo 1';
        $encabezados['nucleo_02']='De interés para el área: Núcleo 2';
        $encabezados['nucleo_03']='De interés para el área: Núcleo 3';
        $encabezados['nucleo_04']='De interés para el área: Núcleo 4';
        $encabezados['nucleo_05']='De interés para el área: Núcleo 5';
        $encabezados['nucleo_06']='De interés para el área: Núcleo 6';
        $encabezados['nucleo_07']='De interés para el área: Núcleo 7';
        $encabezados['nucleo_08']='De interés para el área: Núcleo 8';
        $encabezados['nucleo_09']='De interés para el área: Núcleo 9';
        $encabezados['nucleo_10']='De interés para el área: Núcleo 10';
        $encabezados['mandato_01']='Coincide con el mandato 01';
        $encabezados['mandato_02']='Coincide con el mandato 02';
        $encabezados['mandato_03']='Coincide con el mandato 03';
        $encabezados['mandato_04']='Coincide con el mandato 04';
        $encabezados['mandato_05']='Coincide con el mandato 05';
        $encabezados['mandato_06']='Coincide con el mandato 06';
        $encabezados['mandato_07']='Coincide con el mandato 07';
        $encabezados['mandato_08']='Coincide con el mandato 08';
        $encabezados['mandato_09']='Coincide con el mandato 09';
        $encabezados['mandato_10']='Coincide con el mandato 10';
        $encabezados['mandato_11']='Coincide con el mandato 11';
        $encabezados['mandato_12']='Coincide con el mandato 12';
        $encabezados['mandato_13']='Coincide con el mandato 13';
        $encabezados['a_consentimiento']='Adjunto: Consentimiento informado';
        $encabezados['a_audio']='Adjunto: Audio de la entrevista';
        $encabezados['a_ficha_corta']='Adjunto: Ficha corta';
        $encabezados['a_ficha_larga']='Adjunto: Ficha larga';
        $encabezados['a_relatoria']='Adjunto: Relatoría';
        $encabezados['a_transcripcion_preliminar']='Adjunto: Transripción preliminar';
        $encabezados['a_transcripcion_final']='Adjunto: Transripción final';
        $encabezados['a_etiquetado']='Adjunto: Documento de etiquetado';
        $encabezados['a_casos_informes']='Adjunto: Casos e informes';
        $encabezados['a_otros']='Adjunto: otros';
        $encabezados['a_autorizaciones']='Adjunto: Autorizaciones';
        $encabezados['a_referencias']='Adjunto: Referencias';
        $encabezados['a_plan_trabajo']='Adjunto: Plan de trabajo';
        $encabezados['a_valoracion']='Adjunto: documento de valoración';
        $encabezados['a_certificaciones']='Adjunto: Certificaciones';
        $encabezados['a_certificacion_inicial']='Adjunto: Certificación inicial';
        $encabezados['a_certificacion_final']='Adjunto: Certificación final';
        $encabezados['a_evaluacion_vulnerabilidad']='Adjunto: Evaluación de vulnerabilidad';
        $encabezados['a_evaluacion_seguridad']='Adjunto: Evaluación de seguridad';
        $encabezados['a_retroalimentacion']='Adjunto: Retroalimentación';
        $encabezados['a_otranscribe']='Adjunto: Archivo de oTranscribe';
        $encabezados['a_total_adjuntos']='Cantidad total de archivos adjuntos';
        $encabezados['entrevista_lat']='Latitud donde se realiza la entrevista';
        $encabezados['entrevista_lon']='Longitud donde se realiza la entrevista';
        $encabezados['prioridad_e_fecha']='Prioridad del entrevistador: fecha en que se establece';
        $encabezados['prioridad_e_ponderacion']='Prioridad del entrevistador: Ponderación total';
        $encabezados['prioridad_e_fluidez']='Prioridad del entrevistador: Criterio de fluidez';
        $encabezados['prioridad_e_d_hecho']='Prioridad del entrevistador: Criterio de descripción de los hechos';
        $encabezados['prioridad_e_d_contexto']='Prioridad del entrevistador: Criterio de descripción del contexto';
        $encabezados['prioridad_e_d_impacto']='Prioridad del entrevistador: Criterio de descripción de los impactos';
        $encabezados['prioridad_e_d_justicia']='Prioridad del entrevistador: Criterio de descripción de acceso a la justicia';
        $encabezados['prioridad_e_cierre']='Prioridad del entrevistador: Criterio cierre';
        $encabezados['prioridad_e_ahora_entiendo']='Prioridad del entrevistador: "Con esta entrevista, ahora entiendo ..."';
        $encabezados['prioridad_e_cambio_perspectiva']='Prioridad del entrevistador: "Con esta entrevista, me cambia la perspectiva de ..."';
        $encabezados['prioridad_t_fecha']='Prioridad del transcriptor: fecha en que se establece';
        $encabezados['prioridad_t_ponderacion']='Prioridad del transcriptor: Ponderación total';
        $encabezados['prioridad_t_fluidez']='Prioridad del transcriptor: Criterio de fluidez';
        $encabezados['prioridad_t_d_hecho']='Prioridad del transcriptor: Criterio de descripción de los hechos';
        $encabezados['prioridad_t_d_contexto']='Prioridad del transcriptor: Criterio de descripción del contexto';
        $encabezados['prioridad_t_d_impacto']='Prioridad del transcriptor: Criterio de descripción de los impactos';
        $encabezados['prioridad_t_d_justicia']='Prioridad del transcriptor: Criterio de descripción de acceso a la justicia';
        $encabezados['prioridad_t_cierre']='Prioridad del transcriptor: Criterio cierre';
        $encabezados['prioridad_t_ahora_entiendo']='Prioridad del transcriptor: "Con esta entrevista, ahora entiendo ..."';
        $encabezados['prioridad_t_cambio_perspectiva']='Prioridad del transcriptor: "Con esta entrevista, me cambia la perspectiva de ..."';
        $encabezados['procesamiento_requisitos_minimos']='Cuenta con requisitos mínimos para ser procesada';
        $encabezados['procesamiento_transcrito']='Entrevista ya fué transcrita';
        $encabezados['procesamiento_etiquetado']='Entrevista ya fué etiquetada';
        $encabezados['procesamiento_cerrado']='Entrevista ya fué cerrada';
        $encabezados['consentimiento_conceder_entrevista']='Consentimiento informado: Autoriza conceder entrevista';
        $encabezados['consentimiento_grabar_audio']='Consentimiento informado: Autoriza grabar audio';
        $encabezados['consentimiento_elaborar_informe']='Consentimiento informado: Autoriza utilizar la entrevista para elaborar el informe';
        $encabezados['consentimiento_tratamiento_datos_analizar']='Consentimiento informado: Autoriza utilizar datos personales para el análisis';
        $encabezados['consentimiento_tratamiento_datos_analizar_sensible']='Consentimiento informado: Autoriza utilizar datos sensibles para el análisis';
        $encabezados['consentimiento_tratamiento_datos_utilizar']='Consentimiento informado: Autoriza utilizar datos personales para elaborar el informe';
        $encabezados['consentimiento_tratamiento_datos_utilizar_sensible']='Consentimiento informado: Autoriza utilizar datos sensibles para elaborar el informe';
        $encabezados['consentimiento_tratamiento_datos_publicar']='Consentimiento informado: Autoriza publidacar datos personales';
        $encabezados['fichas_estado_diligenciado']='Avance en diligenciar las fichas';
        $encabezados['fichas_conteo_entrevistado']='Cantidad de fichas de persona entrevistada';
        $encabezados['fichas_conteo_victima']='Cantidad de fichas de víctima';
        $encabezados['fichas_conteo_responsable']='Cantidad de fihas de presunto responsable individual';
        $encabezados['fichas_conteo_hechos']='Cantida de hechos de violencia';
        $encabezados['fichas_conteo_violaciones']='Cantidad de violaciones';
        $encabezados['fichas_conteo_violencia']='Cantidad de victimizaciones';
        $encabezados['fichas_conteo_exilio']='Cantidad de fichas de exilio';
        $encabezados['fichas_conteo_alertas']='Cantida de alertas en el diligenciamiento de las fichas';
        $encabezados['minutos_entrevista']='Duración de la entrevista en minutos';
        $encabezados['minutos_transcripcion']='Tiempo utilizado para la transcripción';
        $encabezados['minutos_etiquetado']='Tiempo utilizado para el etiqeutado';
        $encabezados['minutos_diligenciado']='Tiempo utilizado para diligenciar fichas';
        $encabezados['entrevistada_nombres']='Persona entrevistada: Nombres';
        $encabezados['entrevistada_apellidos']='Persona entrevistada: Apellidos';
        $encabezados['entrevistada_sexo']='Persona entrevistada: Sexo';
        $encabezados['entrevistada_edad']='Persona entrevistada: Edad';
        $encabezados['entrevistada_es_victima']='Persona entrevistada: ¿es víctima directa?';
        $encabezados['entrevistada_es_testigo']='Persona entrevistada: ¿es testigo?';
        $encabezados['fecha_carga']='Fecha en que se crea la entrevista';
        $encabezados['mes_carga']='Mes en que se crea la entrevista';
        $encabezados['fecha_cierre']='Fecha en que se cierra el procesamiento de la entrevista';
        $encabezados['mes_cierre']='Mes en que se cierra el procesamiento de la entrevista';
        $encabezados['max_fecha_adjunto']='Fecha del último adjunto cargado';
        $encabezados['max_mes_adjunto']='Mes del último adjunto cargado';
        $encabezados['id_entrevistador']='Identificador del entrevistador responsable';

        return $encabezados;
    }





}
