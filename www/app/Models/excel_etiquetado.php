<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $etiqueta_n1
 * @property string $etiqueta_n2
 * @property string $etiqueta_n3
 * @property string $texto_marcado
 * @property string $codigo_entrevista
 * @property string $tipo_entrevista
 * @property int $personas_entrevistadas
 * @property int $es_virtual
 * @property int $interes_exilio
 * @property string $sector_entrevistado
 * @property string $situacion_actual
 * @property int $clasificacion
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $codigo_entrevistador
 * @property string $grupo_entrevistador
 * @property string $entrevista_fecha
 * @property string $entrevista_mes
 * @property int $tiempo_entrevista
 * @property string $entrevista_lugar_n1
 * @property string $entrevista_lugar_n2
 * @property string $entrevista_lugar_n3
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property string $hechos_anio_del
 * @property string $hechos_anio_al
 * @property string $titulo
 * @property string $dinamica_1
 * @property string $dinamica_2
 * @property string $dinamica_3

 * @property int $aa_paramilitar
 * @property int $aa_guerrilla
 * @property int $aa_fuerza_publica
 * @property int $aa_terceros_civiles
 * @property int $aa_otro_grupo_armado
 * @property int $aa_otro_agente_estado
 * @property int $aa_otro_actor
 * @property int $aa_ns_nr
 * @property int $aa_internacional
 * @property int $viol_homicidio
 * @property int $viol_atentado_vida
 * @property int $viol_amenaza_vida
 * @property int $viol_desaparicion_f
 * @property int $viol_tortura
 * @property int $viol_violencia_sexual
 * @property int $viol_esclavitud
 * @property int $viol_reclutamiento
 * @property int $viol_detencion_arbitraria
 * @property int $viol_secuestro
 * @property int $viol_confinamiento
 * @property int $viol_pillaje
 * @property int $viol_extorsion
 * @property int $viol_ataque_bien_protegido
 * @property int $viol_ataque_indiscriminado
 * @property int $viol_despojo_tierras
 * @property int $viol_desplazamiento_forzado
 * @property int $viol_exilio

 * @property int $id_etiqueta_entrevista
 * @property int $id_entrevistador

 */
class excel_etiquetado extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'esclarecimiento.excel_etiquetado';
    protected $tesauro = array();

    /**
     * @var array
     */
    protected $fillable = ['etiqueta_n1', 'etiqueta_n2', 'etiqueta_n3', 'texto_marcado', 'codigo_entrevista', 'tipo_entrevista', 'personas_entrevistadas', 'es_virtual', 'interes_exilio', 'sector_entrevistado', 'situacion_actual', 'clasificacion', 'macroterritorio', 'territorio', 'codigo_entrevistador', 'grupo_entrevistador', 'entrevista_fecha', 'entrevista_mes', 'tiempo_entrevista', 'entrevista_lugar_n1', 'entrevista_lugar_n2', 'entrevista_lugar_n3', 'entrevista_lat', 'entrevista_lon', 'hechos_anio_del', 'hechos_anio_al', 'titulo', 'dinamica_1', 'dinamica_2', 'dinamica_3', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'aa_paramilitar', 'aa_guerrilla', 'aa_fuerza_publica', 'aa_terceros_civiles', 'aa_otro_grupo_armado', 'aa_otro_agente_estado', 'aa_otro_actor', 'aa_ns_nr', 'aa_internacional', 'viol_homicidio', 'viol_atentado_vida', 'viol_amenaza_vida', 'viol_desaparicion_f', 'viol_tortura', 'viol_violencia_sexual', 'viol_esclavitud', 'viol_reclutamiento', 'viol_detencion_arbitraria', 'viol_secuestro', 'viol_confinamiento', 'viol_pillaje', 'viol_extorsion', 'viol_ataque_bien_protegido', 'viol_ataque_indiscriminado', 'viol_despojo_tierras', 'viol_desplazamiento_forzado', 'viol_exilio', 'prioridad_e_fecha', 'prioridad_e_ponderacion', 'prioridad_e_fluidez', 'prioridad_e_d_hecho', 'prioridad_e_d_contexto', 'prioridad_e_d_impacto', 'prioridad_e_d_justicia', 'prioridad_e_cierre', 'prioridad_e_ahora_entiendo', 'prioridad_e_cambio_perspectiva', 'prioridad_t_fecha', 'prioridad_t_ponderacion', 'prioridad_t_fluidez', 'prioridad_t_d_hecho', 'prioridad_t_d_contexto', 'prioridad_t_d_impacto', 'prioridad_t_d_justicia', 'prioridad_t_cierre', 'prioridad_t_ahora_entiendo', 'prioridad_t_cambio_perspectiva', 'consentimiento_conceder_entrevista', 'consentimiento_grabar_audio', 'consentimiento_elaborar_informe', 'consentimiento_tratamiento_datos_analizar', 'consentimiento_tratamiento_datos_analizar_sensible', 'consentimiento_tratamiento_datos_utilizar', 'consentimiento_tratamiento_datos_utilizar_sensible', 'consentimiento_tratamiento_datos_publicar', 'transcrita', 'transcrita_fecha', 'transcrita_fecha_a', 'transcrita_fecha_m', 'etiquetada', 'etiquetada_fecha', 'etiquetada_fecha_a', 'etiquetada_fecha_m', 'procesamiento_requisitos_minimos', 'procesamiento_transcrito', 'procesamiento_etiquetado', 'procesamiento_cerrado', 'fichas_estado_diligenciado', 'fichas_conteo_entrevistado', 'fichas_conteo_victima', 'fichas_conteo_responsable', 'fichas_conteo_hechos', 'fichas_conteo_violaciones', 'fichas_conteo_violencia', 'fichas_conteo_exilio', 'fichas_conteo_alertas', 'minutos_entrevista', 'minutos_transcripcion', 'minutos_etiquetado', 'minutos_diligenciado', 'id_etiqueta_entrevista', 'id_entrevistador', 'fecha_carga', 'mes_carga'];

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
    public static function generar_plana_test() {
        $inicio = Carbon::now();
        //Log::notice("ETL de integrado de entrevistas: inicio del proceso");

        //excel_etiquetado::truncate();
        //Quitar los que ya no estén
        $sql="delete from esclarecimiento.excel_etiquetado
                    using esclarecimiento.excel_etiquetado as excel
                        left join sim.etiqueta_entrevista as etiqueta
                                    on excel.id_etiqueta_entrevista=etiqueta.id_etiqueta_entrevista
                        where excel_etiquetado.id_etiqueta_entrevista=excel.id_etiqueta_entrevista
                                and etiqueta.id_etiqueta_entrevista is null";
        \DB::raw($sql);
        $total_hv = self::cargar_hv();
        $total_filas=$total_hv;
        $fin = Carbon::now();
        $respuesta = new \stdClass();

        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->test = $total_hv;
        $respuesta->total_filas = $total_filas;
        return $respuesta;

    }

    public static function generar_plana() {
        $inicio = Carbon::now();
        Log::notice("ETL de excel de etiquetado: inicio del proceso");

        //excel_etiquetado::truncate();
        $sql="delete from esclarecimiento.excel_etiquetado
                    using esclarecimiento.excel_etiquetado as excel
                        left join sim.etiqueta_entrevista as etiqueta
                                    on excel.id_etiqueta_entrevista=etiqueta.id_etiqueta_entrevista
                        where excel_etiquetado.id_etiqueta_entrevista=excel.id_etiqueta_entrevista
                                and etiqueta.id_etiqueta_entrevista is null";
        $total_filas=0;
        $total_errores=0;
        // 1. Entrevista individual  (VI, AA, TC)
        $vi = self::cargar_individuales();
        $total_filas += $vi->total_filas;
        $total_errores += $vi->total_errores;

        // 4. Colectivas
        $co = self::cargar_colectivas();
        $total_filas += $co->total_filas;
        $total_errores += $co->total_errores;

        // 5. Etnicas
        $ee = self::cargar_etnicas();
        $total_filas += $ee->total_filas;
        $total_errores += $ee->total_errores;


        // 6. Entrevistas a profunidad
        $pr = self::cargar_profundidad();
        $total_filas   += $pr->total_filas;
        $total_errores += $pr->total_errores;

        // 7. Diagnostico comunitario
        $dc = self::cargar_dc();
        $total_filas   += $dc->total_filas;
        $total_errores += $dc->total_errores;


        // 8. Historia de Vida
        $hv = self::cargar_hv();
        $total_filas   += $hv->total_filas;
        $total_errores += $hv->total_errores;





        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->vi = $vi;
        $respuesta->co = $co;
        $respuesta->ee = $ee;
        $respuesta->pr = $pr;
        $respuesta->dc = $dc;
        $respuesta->hv = $hv;
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;

        //Segundo grupo: Sujetos colectivos

        Log::info("ETL de excel de etiquetado: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    // Individuales: VI, AA, TC
    public static function cargar_individuales() {
        $total_filas=0;
        $total_errores=0;
        /*
        $listado = entrevista_individual::join('sim.etiqueta_entrevista', function($join)
                                            {
                                                $join->on('e_ind_fvt.id_e_ind_fvt', '=', 'etiqueta_entrevista.id_entrevista');
                                                $join->on('e_ind_fvt.id_subserie','=', 'etiqueta_entrevista.id_subserie');
                                            })
                    ->join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
                    ->selectRaw(\DB::raw('e_ind_fvt.*, id_etiqueta_entrevista, etiqueta_entrevista.id_etiqueta, etiqueta_entrevista.texto'))
                    ->where('e_ind_fvt.id_activo',1)
                    ->orderby('id_e_ind_fvt')
                    ->orderby('del')
                    ->get();
        */
        //Halar los que no estén ya (leftjoin)
        $query = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
                    ->wherein('id_subserie',[config('expedientes.vi'), config('expedientes.aa'), config('expedientes.tc')])
                    ->orderby('id_entrevista')
                    ->orderby('etiqueta_entrevista.id_etiqueta_entrevista')
                    ->leftJoin('esclarecimiento.excel_etiquetado','etiqueta_entrevista.id_etiqueta_entrevista','excel_etiquetado.id_etiqueta_entrevista')
                    ->wherenull('excel_etiquetado.id_etiqueta_entrevista')
                    ->selectraw(\DB::raw('etiqueta_entrevista.*'));
        $listado = $query->get();
        //dd($query->toSql());

        /*
        echo PHP_EOL;
        echo "Hora:".date("Y-m-d H:i:s");
        echo "  Individuales: ".count($listado);
        */

        foreach($listado as $etiqueta) {

            $excel = new excel_etiquetado();
            $excel->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $excel->texto_marcado = $etiqueta->texto;
            $res = $excel->extraer_etiquetas($etiqueta->id_etiqueta, $excel);
            $fila = entrevista_individual::find($etiqueta->id_entrevista);
            if($fila->id_activo==1) {
                $excel->personas_entrevistadas=1;
                $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
                $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->clasificacion = $fila->clasifica_nivel;
                $excel->macroterritorio = $fila->fmt_id_macroterritorio;
                $excel->territorio= $fila->fmt_id_territorio;
                $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
                $quien=$fila->rel_id_entrevistador;
                $excel->grupo_entrevistador = $quien->fmt_grupo;
                $excel->entrevista_fecha = $fila->fmt_entrevista_fecha;
                $excel->entrevista_mes = substr($fila->entrevista_fecha,0,7);
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


                $excel->hechos_anio_del = substr($fila->hechos_del,0,4);
                $excel->hechos_anio_al = substr($fila->hechos_al,0,4);
                $excel->sector_entrevistado = $fila->fmt_id_sector;
                //Titulo y dinamicas
                $excel->titulo = $fila->titulo;
                $i=1;
                foreach($fila->rel_dinamica as $dinamica) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }





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


                //Fuerzas responsables
                $aa = $fila->rel_fr;
                foreach($aa as $item) {
                    $campo=$item->rel_id_fr->otro;
                    if(strlen($campo)>0) {
                        $excel->$campo=1;
                    }
                }
                //Violencia
                $aa = $fila->rel_tv;
                foreach($aa as $item) {
                    $campo=$item->rel_id_tv->otro;
                    if(strlen($campo)>0) {
                        $excel->$campo=1;
                    }
                }


                try {
                    $excel->save();
                    $total_filas++;
                }
                catch (\Exception $e) {
                    $total_errores++;
                    Log::error("Problemas con el ETL de excel_etiquetado:".PHP_EOL.$e->getMessage());
                }
            }



        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    // Colectivas: CO
    public static function cargar_colectivas() {
        $total_filas=0;
        $total_errores=0;

        $listado = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
            ->where('id_subserie',config('expedientes.co'))
            ->orderby('id_entrevista')
            ->orderby('etiqueta_entrevista.id_etiqueta_entrevista')
            ->leftJoin('esclarecimiento.excel_etiquetado','etiqueta_entrevista.id_etiqueta_entrevista','excel_etiquetado.id_etiqueta_entrevista')
            ->wherenull('excel_etiquetado.id_etiqueta_entrevista')
            ->selectraw(\DB::raw('etiqueta_entrevista.*'))
            ->get();

        foreach($listado as $etiqueta) {

            $excel = new self();
            $excel->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $excel->texto_marcado = $etiqueta->texto;
            $res = $excel->extraer_etiquetas($etiqueta->id_etiqueta, $excel);
            $fila = entrevista_colectiva::find($etiqueta->id_entrevista);
            if($fila->id_activo==1) {
                $excel->personas_entrevistadas=$fila->cantidad_participantes;
                $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->clasificacion = $fila->clasificacion_nivel;
                $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
                $excel->macroterritorio = $fila->fmt_id_macroterritorio;
                $excel->territorio= $fila->fmt_id_territorio;
                $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
                $quien=$fila->rel_id_entrevistador;
                $excel->grupo_entrevistador = $quien->fmt_grupo;
                $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
                $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
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

                $excel->hechos_anio_del = substr($fila->tema_del,0,4);
                $excel->hechos_anio_al = substr($fila->tema_del,0,4);
                $excel->sector_entrevistado = $fila->fmt_id_sector;
                //Titulo y dinamicas
                $excel->titulo = $fila->titulo;
                $i=1;
                foreach($fila->rel_dinamica as $dinamica) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }




                //Es una entrevista virtual
                $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
                // Es de interes para exilio
                $res=0;
                if($fila->rel_id_macroterritorio->codigo=='IN') {
                    $res=1;
                }
                $excel->interes_exilio = $res;


                try {
                    $excel->save();
                    $total_filas++;
                }
                catch (\Exception $e) {
                    $total_errores++;
                    Log::error("Problemas con el ETL de excel_etiquetado:".PHP_EOL.$e->getMessage());
                }
            }

        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    //Sujetos colectivos: EE
    public static function cargar_etnicas() {
        $total_filas=0;
        $total_errores=0;

        $listado = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
            ->where('id_subserie',config('expedientes.ee'))
            ->orderby('id_entrevista')
            ->orderby('etiqueta_entrevista.id_etiqueta_entrevista')
            ->leftJoin('esclarecimiento.excel_etiquetado','etiqueta_entrevista.id_etiqueta_entrevista','excel_etiquetado.id_etiqueta_entrevista')
            ->wherenull('excel_etiquetado.id_etiqueta_entrevista')
            ->selectraw(\DB::raw('etiqueta_entrevista.*'))
            ->get();

        foreach($listado as $etiqueta) {

            $excel = new self();
            $excel->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $excel->texto_marcado = $etiqueta->texto;
            $res = $excel->extraer_etiquetas($etiqueta->id_etiqueta, $excel);
            $fila = entrevista_etnica::find($etiqueta->id_entrevista);
            $excel->personas_entrevistadas=$fila->cantidad_participantes;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->clasificacion = $fila->clasificacion_nivel;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
            $excel->tiempo_entrevista = $fila->duracion_entrevista_minutos;
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

            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                $campo = "dinamica_$i";
                $excel->$campo = $dinamica->dinamica;
            }



            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $excel->interes_exilio = $res;


            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_etiquetado:".PHP_EOL.$e->getMessage());
            }
        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    // Profunidad: PR
    public static function cargar_profundidad() {
        $total_filas=0;
        $total_errores=0;

        $listado = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
            ->where('id_subserie',config('expedientes.pr'))
            ->orderby('id_entrevista')
            ->orderby('etiqueta_entrevista.id_etiqueta_entrevista')
            ->leftJoin('esclarecimiento.excel_etiquetado','etiqueta_entrevista.id_etiqueta_entrevista','excel_etiquetado.id_etiqueta_entrevista')
            ->wherenull('excel_etiquetado.id_etiqueta_entrevista')
            ->selectraw(\DB::raw('etiqueta_entrevista.*'))
            ->get();

        foreach($listado as $etiqueta) {

            $excel = new self();
            $excel->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $excel->texto_marcado = $etiqueta->texto;
            $res = $excel->extraer_etiquetas($etiqueta->id_etiqueta, $excel);
            $fila = entrevista_profundidad::find($etiqueta->id_entrevista);
            $excel->personas_entrevistadas = 1;
            $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->clasificacion = $fila->clasificacion_nivel;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_entrevistador = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
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

            $excel->hechos_anio_del = 'PR: No Aplica';
            $excel->hechos_anio_al = 'PR: No Aplica';
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                $campo = "dinamica_$i";
                $excel->$campo = $dinamica->dinamica;
            }



            //Violencia: actores
            $aa = $fila->rel_violencia_actor;
            foreach($aa as $item) {
                $campo=cat_item::find($item->id_violencia)->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Violencia: victimas
            $aa = $fila->rel_violencia_victima;
            foreach($aa as $item) {
                $campo=cat_item::find($item->id_violencia)->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }


            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
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


            try {
                $excel->save();
                $total_filas++;
            }
            catch (\Exception $e) {
                $total_errores++;
                Log::error("Problemas con el ETL de excel_etiquetado:".PHP_EOL.$e->getMessage());
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    // Diagnosticos Comunitarios
    public static function cargar_dc() {
        $total_filas=0;
        $total_errores=0;

        $listado = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
            ->where('id_subserie',config('expedientes.dc'))
            ->orderby('id_entrevista')
            ->orderby('etiqueta_entrevista.id_etiqueta_entrevista')
            ->leftJoin('esclarecimiento.excel_etiquetado','etiqueta_entrevista.id_etiqueta_entrevista','excel_etiquetado.id_etiqueta_entrevista')
            ->wherenull('excel_etiquetado.id_etiqueta_entrevista')
            ->selectraw(\DB::raw('etiqueta_entrevista.*'))
            ->get();

        foreach($listado as $etiqueta) {

            $excel = new self();
            $excel->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $excel->texto_marcado = $etiqueta->texto;
            $res = $excel->extraer_etiquetas($etiqueta->id_etiqueta, $excel);
            $fila = diagnostico_comunitario::find($etiqueta->id_entrevista);
            if($fila->id_activo==1) {
                $excel->personas_entrevistadas=$fila->cantidad_participantes;
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
                $excel->clasificacion = $fila->clasificacion_nivel;
                $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
                $excel->macroterritorio = $fila->fmt_id_macroterritorio;
                $excel->territorio= $fila->fmt_id_territorio;
                $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
                $quien=$fila->rel_id_entrevistador;
                $excel->grupo_entrevistador = $quien->fmt_grupo;
                $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
                $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio,0,7);
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

                $excel->hechos_anio_del = substr($fila->tema_del,0,4);
                $excel->hechos_anio_al = substr($fila->tema_del,0,4);
                $excel->sector_entrevistado = $fila->fmt_id_sector;
                //Titulo y dinamicas
                $excel->titulo = $fila->titulo;
                $i=1;
                foreach($fila->rel_dinamica as $dinamica) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }




                $excel->id_entrevistador = $fila->id_entrevistador;
                //Es una entrevista virtual
                $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
                //Es procesable
                // Es de interes para exilio
                $res=0;
                if($fila->rel_id_macroterritorio->codigo=='IN') {
                    $res=1;
                }
                $excel->interes_exilio = $res;


                try {
                    $excel->save();
                    $total_filas++;
                }
                catch (\Exception $e) {
                    $total_errores++;
                    Log::error("Problemas con el ETL de excel_etiquetado:".PHP_EOL.$e->getMessage());
                }

            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
    }

    // Historia de vida
    public static function cargar_hv() {
        $total_filas=0;
        $total_errores=0;

        $listado = etiqueta_entrevista::join('catalogos.tesauro','etiqueta_entrevista.id_etiqueta','tesauro.id_etiqueta')
            ->where('id_subserie',config('expedientes.hv'))
            ->orderby('id_entrevista')
            ->orderby('etiqueta_entrevista.id_etiqueta_entrevista')
            ->leftJoin('esclarecimiento.excel_etiquetado','etiqueta_entrevista.id_etiqueta_entrevista','excel_etiquetado.id_etiqueta_entrevista')
            ->wherenull('excel_etiquetado.id_etiqueta_entrevista')
            ->selectraw(\DB::raw('etiqueta_entrevista.*'))
            ->get();

        foreach($listado as $etiqueta) {

            $excel = new self();
            $excel->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $excel->texto_marcado = $etiqueta->texto;
            $res = $excel->extraer_etiquetas($etiqueta->id_etiqueta, $excel);
            $fila = historia_vida::find($etiqueta->id_entrevista);
            if($fila->id_activo==1) {
                $excel->personas_entrevistadas = 1;
                $excel->tipo_entrevista = substr($fila->entrevista_codigo, strpos($fila->entrevista_codigo, '-') + 1, 2);
                $excel->codigo_entrevista = $fila->entrevista_codigo;
                $excel->clasificacion = $fila->clasificacion_nivel;
                $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
                $excel->macroterritorio = $fila->fmt_id_macroterritorio;
                $excel->territorio = $fila->fmt_id_territorio;
                $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
                $quien = $fila->rel_id_entrevistador;
                $excel->grupo_entrevistador = $quien->fmt_grupo;
                $excel->entrevista_fecha = $fila->fmt_entrevista_fecha_inicio;
                $excel->entrevista_mes = substr($fila->entrevista_fecha_inicio, 0, 7);
                $excel->tiempo_entrevista = $fila->tiempo_entrevista;
                $geo = $fila->rel_entrevista_lugar;
                if ($geo) {
                    $excel->entrevista_lugar_n3 = $geo->descripcion;
                    $excel->entrevista_lat = $geo->lat;
                    $excel->entrevista_lon = $geo->lon;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $excel->entrevista_lugar_n2 = $geo->descripcion;
                        $geo = geo::find($geo->id_padre);
                        if ($geo) {
                            $excel->entrevista_lugar_n1 = $geo->descripcion;
                        }
                    }
                }

                $excel->hechos_anio_del = "HV: No Aplica";
                $excel->hechos_anio_al = "HV: No Aplica";
                $excel->sector_entrevistado = $fila->fmt_id_sector;
                //Titulo y dinamicas
                $excel->titulo = $fila->titulo;
                $i = 1;
                foreach ($fila->rel_dinamica as $dinamica) {
                    $campo = "dinamica_$i";
                    $excel->$campo = $dinamica->dinamica;
                }


                //Es una entrevista virtual
                $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0;

                // Es de interes para exilio
                $res = 0;
                if ($fila->rel_id_macroterritorio->codigo == 'IN') {
                    $res = 1;
                }
                $excel->interes_exilio = $res;

                try {
                    $excel->save();
                    $total_filas++;
                } catch (\Exception $e) {
                    $total_errores++;
                    Log::error("Problemas con el ETL de excel_etiquetado:" . PHP_EOL . $e->getMessage());
                }
            }


        }
        $res= new \stdClass();
        $res->total_filas=$total_filas;
        $res->total_errores=$total_errores;
        return $res;
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
        }
        //Cerrada
        $excel->procesamiento_transcrito = $excel->transcrita;
        $excel->procesamiento_etiquetado = $excel->etiquetada;
        //Cerrado?
        $excel->procesamiento_cerrado = $fila->id_cerrado ==1 ? 1 : 0 ;
    }

    // Para determinar las etiquetas del tesauro
    public  function extraer_etiquetas($id_etiqueta=null, $excel=null) {
        if(isset($this->tesauro[$id_etiqueta])) {
            $nivel[1]=$this->tesauro[$id_etiqueta][1];
            $nivel[2]=$this->tesauro[$id_etiqueta][2];
            $nivel[3]=$this->tesauro[$id_etiqueta][3];
        }
        else {
            $nivel[1]=null;
            $nivel[2]=null;
            $nivel[3]=null;
            $etiqueta = tesauro::where('id_etiqueta',$id_etiqueta)->first();
            while ($etiqueta) {
                $nivel[$etiqueta->nivel] = $etiqueta->descripcion;
                $etiqueta=tesauro::find($etiqueta->id_padre);
            }
            $this->tesauro[$id_etiqueta]=$nivel;
        }

        if(is_object($excel)) {
            foreach ($nivel as $var => $val) {
                $atributo = "etiqueta_n" . $var;
                $excel->$atributo = $val;
            }
        }
        return $nivel;
    }

}
