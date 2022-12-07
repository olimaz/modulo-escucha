<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_entrevista
 * @property int $id_entrevistador
 * @property string $tipo_entrevista
 * @property string $codigo_entrevista
 * @property int $clasificacion_r1
 * @property int $clasificacion_r2
 * @property int $clasificacion_nna
 * @property int $clasificacion_sex
 * @property int $clasificacion_res
 * @property int $clasificacion_nivel
 * @property int $macroterritorio_id
 * @property string $macroterritorio_txt
 * @property int $territorio_id
 * @property string $territorio_txt
 * @property int $grupo_id
 * @property string $grupo_txt
 * @property string $entrevista_fecha
 * @property int $tiempo_entrevista
 * @property string $entrevista_lugar_n1_codigo
 * @property string $entrevista_lugar_n1_txt
 * @property string $entrevista_lugar_n2_codigo
 * @property string $entrevista_lugar_n2_txt
 * @property string $entrevista_lugar_n3_codigo
 * @property string $entrevista_lugar_n3_txt
 * @property string $titulo
 * @property string $hechos_lugar_n1_codigo
 * @property string $hechos_lugar_n1_txt
 * @property string $hechos_lugar_n2_codigo
 * @property string $hechos_lugar_n2_txt
 * @property string $hechos_lugar_n3_codigo
 * @property string $hechos_lugar_n3_txt
 * @property string $hechos_del
 * @property string $hechos_al
 * @property string $anotaciones
 * @property int $es_prioritario
 * @property string $prioritario_tema
 * @property string $sector_victima
 * @property int $interes_etnico
 * @property string $remitido
 * @property string $transcrita
 * @property string $transcripcion_fecha
 * @property string $transcripcion_fecha_a
 * @property string $transcripcion_fecha_m
 * @property string $etiquetada
 * @property string $etiquetado_fecha
 * @property string $etiquetado_fecha_a
 * @property string $etiquetado_fecha_m
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
 * @property int $ia_ds_o_convivencia
 * @property int $ia_ds_o_reconocimiento
 * @property int $ia_ds_o_no_repeticion
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
 * @property string $dinamica_1
 * @property string $dinamica_2
 * @property string $dinamica_3
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property float $hechos_lat
 * @property float $hechos_lon
 * @property string $transcripcion_html
 * @property string $etiquetado_json
 * @property string $created_at
 * @property string $created_at_month
 * @property string $updated_at
 */
class analitica_metadatos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.metadatos';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador', 'tipo_entrevista', 'codigo_entrevista', 'clasificacion_acceso', 'macroterritorio_id', 'macroterritorio_txt', 'territorio_id', 'territorio_txt', 'grupo_id', 'grupo_txt', 'entrevista_fecha', 'tiempo_entrevista', 'entrevista_lugar_n1_codigo', 'entrevista_lugar_n1_txt', 'entrevista_lugar_n2_codigo', 'entrevista_lugar_n2_txt', 'entrevista_lugar_n3_codigo', 'entrevista_lugar_n3_txt', 'titulo', 'hechos_lugar_n1_codigo', 'hechos_lugar_n1_txt', 'hechos_lugar_n2_codigo', 'hechos_lugar_n2_txt', 'hechos_lugar_n3_codigo', 'hechos_lugar_n3_txt', 'hechos_del', 'hechos_al', 'anotaciones', 'es_prioritario', 'prioritario_tema', 'sector_victima', 'interes_etnico', 'remitido', 'transcrita', 'transcripcion_fecha', 'transcripcion_fecha_a', 'transcripcion_fecha_m', 'etiquetada', 'etiquetado_fecha', 'etiquetado_fecha_a', 'etiquetado_fecha_m', 'aa_paramilitar', 'aa_guerrilla', 'aa_fuerza_publica', 'aa_terceros_civiles', 'aa_otro_grupo_armado', 'aa_otro_agente_estado', 'aa_otro_actor', 'aa_ns_nr', 'aa_internacional', 'viol_homicidio', 'viol_atentado_vida', 'viol_amenaza_vida', 'viol_desaparicion_f', 'viol_tortura', 'viol_violencia_sexual', 'viol_esclavitud', 'viol_reclutamiento', 'viol_detencion_arbitraria', 'viol_secuestro', 'viol_confinamiento', 'viol_pillaje', 'viol_extorsion', 'viol_ataque_bien_protegido', 'viol_ataque_indiscriminado', 'viol_despojo_tierras', 'viol_desplazamiento_forzado', 'viol_exilio', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_ds_o_convivencia', 'ia_ds_o_reconocimiento', 'ia_ds_o_no_repeticion', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'dinamica_1', 'dinamica_2', 'dinamica_3', 'entrevista_lat', 'entrevista_lon', 'hechos_lat', 'hechos_lon', 'transcripcion_html', 'etiquetado_json', 'created_at', 'created_at_month', 'updated_at'];

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

    public static function generar_plana($truncar=false) {
        $inicio = Carbon::now();
        // Nueva logica, siempre truncar
        Log::notice("ETL de analitica-metadatos: inicio del proceso");
        $total_filas=0;
        $total_errores=0;
        analitica_metadatos::truncate();

        $listado = entrevista_individual::where('id_activo',1)->where('id_subserie',config('expedientes.vi'))->orderby('id_e_ind_fvt')->get();

        foreach($listado as $fila) {
            $excel = new analitica_metadatos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->id_entrevistador = $fila->id_entrevistador;
            $excel->tipo_entrevista = $fila->fmt_id_subserie_codigo;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->clasificacion_r1 = $fila->clasifica_r1==1 ? 1 : 0;;
            $excel->clasificacion_r2 = $fila->clasifica_r2==1 ? 1 : 0;;
            $excel->clasificacion_nna = $fila->clasifica_nna==1 ? 1 : 0;;
            $excel->clasificacion_sex = $fila->clasifica_sex==1 ? 1 : 0;;
            $excel->clasificacion_res = $fila->clasifica_res==1 ? 1 : 0;;
            $excel->clasificacion_nivel = $fila->clasifica_nivel;
            $excel->macroterritorio_id = $fila->id_macroterritorio;
            $excel->macroterritorio_txt = $fila->fmt_id_macroterritorio;
            $excel->territorio_id = $fila->id_territorio;
            $excel->territorio_txt = $fila->fmt_id_territorio;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_id = $quien->id_grupo;
            $excel->grupo_txt = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha;
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            //Lugar de la entrevista
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;

                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }

            // Lugar de los hechos
            $geo = $fila->rel_hechos_lugar;
            if($geo) {
                $excel->hechos_lugar_n3_codigo = $geo->codigo;
                $excel->hechos_lugar_n3_txt = $geo->descripcion;
                $excel->hechos_lat = $geo->lat;
                $excel->hechos_lon = $geo->lon;

                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2_codigo = $geo->codigo;
                    $excel->hechos_lugar_n2_txt = $geo->descripcion;

                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1_codigo = $geo->codigo;
                        $excel->hechos_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }
            $excel->hechos_del = $fila->fmt_hechos_del;
            $excel->hechos_al = $fila->fmt_hechos_al;
            $excel->anotaciones = $fila->anotaciones;
            $excel->es_prioritario = $fila->id_prioritario==1 ? 1 : 0;
            $excel->prioritario_tema = $fila->prioritario_tema;
            $excel->sector_victima = $fila->fmt_id_sector;
            $excel->interes_etnico = $fila->id_etnico == 1 ? 1 : 0 ;
            $excel->remitido = $fila->fmt_id_remitido;
            $excel->transcrita = is_null($fila->html_transcripcion) ? "0" : "1";
            //transcripcion
            $excel->transcripcion_fecha = entrevista_individual::fecha_transcrita($fila);
            if(substr($excel->transcripcion_fecha,0,2)=="20") {
                $excel->transcripcion_fecha = substr($excel->transcripcion_fecha,0,10);
                $excel->transcripcion_fecha_a = substr($excel->transcripcion_fecha,0,4);
                $excel->transcripcion_fecha_m = substr($excel->transcripcion_fecha,0,7);
            }
            //etiquetado
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "0" : "1";
            $excel->etiquetado_fecha = entrevista_individual::fecha_etiquetada($fila);
            if(substr($excel->etiquetado_fecha,0,2)=="20") {
                $excel->etiquetado_fecha = substr($excel->etiquetado_fecha, 0, 10);
                $excel->etiquetado_fecha_a = substr($excel->etiquetado_fecha, 0, 4);
                $excel->etiquetado_fecha_m = substr($excel->etiquetado_fecha, 0, 7);
            }
            //fichas diligenciadas
            $excel->fichas_diligenciadas = criterio_fijo::describir(40,$fila->fichas_estado);
            //titulo de la entrevista
            $excel->titulo = $fila->titulo;
            //Dinamicas
            $i=1;
            $aa = $fila->rel_dinamica;
            foreach($aa as $item) {
                $campo="dinamica_$i";
                if($i<=3) {
                    $excel->$campo=$item->dinamica;
                }
                $i++;
            }
            //Rellenar
            $j=$i;
            while($j <= 3) {
                $campo="dinamica_$j";
                $excel->$campo="(Sin Especificar)";
                $j++;
            }
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
            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Interes_area
            $aa = $fila->rel_interes_area;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
                //dd($campo);
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $tmp = $item->rel_id_mandato;
                if($tmp) {
                    $campo = $tmp->otro;
                    if(strlen($campo)>0) {
                        $excel->$campo=1;
                    }
                }
            }
            //Transcripcion y etiquetado
            //$excel->transcripcion_html = $fila->html_transcripcion;
            //$excel->etiquetado_json = $fila->json_etiquetado;
            //fecha de carga
            if(!is_null($fila->fh_insert)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert);
                $excel->created_at_month = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m");
            }
            //Fecha de actualizacion
            if(!is_null($fila->fh_update)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s.u', $fila->fh_update);
            }
            //-- FIn de los metadatos de la entrevista


            /////////////////////// FICHA de entrevista
            $ficha = $fila->rel_ficha_entrevista;
            if($ficha) {
                $excel->id_ficha_entrevista = $ficha->id_entrevista;
                $excel->idioma_id = $ficha->id_idioma;
                $excel->idioma_txt = $ficha->fmt_id_idioma;
                $excel->idioma_nativo_id = $ficha->id_nativo;
                $excel->idioma_nativo_txt = $ficha->fmt_id_nativo;
                $excel->nombre_interprete = $ficha->nombre_interprete;
                $excel->documentacion_aporta = $ficha->documentacion_aporta==1 ? 1 : 0;;
                $excel->documentacion_especificar = $ficha->documentacion_especificar;
                $excel->identifica_testigos = $ficha->identifica_testigos==1 ? 1 : 0;
                $excel->ampliar_relato = $ficha->ampliar_relato==1 ? 1 : 0;
                $excel->ampliar_relato_temas = $ficha->ampliar_relato_temas;
                $excel->priorizar_entrevista = $ficha->priorizar_entrevista==1 ? 1 : 0;
                $excel->priorizar_entrevista_asuntos = $ficha->priorizar_entrevista_asuntos;
                $excel->contiene_patrones = $ficha->contiene_patrones==1 ? 1 : 0;
                $excel->contiene_patrones_cuales = $ficha->contiene_patrones_cuales;
                $excel->indicaciones_transcripcion = $ficha->indicaciones_transcripcion;
                $excel->observaciones = $ficha->observaciones;
                $excel->ci_identificacion = $ficha->identificacion_consentimiento;
                $excel->ci_conceder_entrevista = $ficha->conceder_entrevista==1 ? 1 : 0;
                $excel->ci_grabar_audio =$ficha->grabar_audio==1 ? 1 : 0;
                $excel->ci_elaborar_informe = $ficha->elabrorar_informe==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_analizar = $ficha->tratamiento_datos_analizar==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_analizar_sensible = $ficha->tratamiento_datos_analizar_sensible==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_utilizar = $ficha->tratamiento_datos_utilizar==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_utilizar_sensible = $ficha->tratamiento_datos_utilizar_sensible==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_publicar = $ficha->tratamiento_datos_publicar==1 ? 1 : 0;
                //fecha de carga de la ficha
                if(!is_null($ficha->insert_fh)) {
                    try {
                        $fecha = Carbon::createFromFormat('Y-m-d H:i:s.u',$ficha->insert_fh);
                        $excel->ficha_entrevista_created_at = $fecha->format('Y-m-d H:i:s');
                        $excel->ficha_entrevista_created_at_fecha = $fecha->format('Y-m-d');
                        $excel->ficha_entrevista_created_at_mes = $fecha->format('Y-m');
                    }
                    catch (\Exception $e) {

                    }

                }
                //Fecha de actualizacion
                if(!is_null($ficha->update_fh)) {
                    try {
                        $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $ficha->update_fh)->format("Y-m-d H:i:s");
                    }
                    catch (\Exception $e) {

                    }

                }
            }


            //Prioridad
            $prioridad = $fila->prioridad;
            if($prioridad) {
                $excel->id_prioridad = $prioridad->id_prioridad;
                $excel->prioridad_tipo = $prioridad->id_tipo==1 ? 'Documentador' : 'Transcriptor';
                $excel->prioridad_fluidez = $prioridad->fluidez;
                $excel->prioridad_d_hecho = $prioridad->d_hecho;
                $excel->prioridad_d_contexto = $prioridad->d_contexto;
                $excel->prioridad_d_impacto = $prioridad->d_impacto;
                $excel->prioridad_d_justicia = $prioridad->d_justicia;
                $excel->prioridad_cierre = $prioridad->cierre;
                $excel->prioridad_ponderacion = $prioridad->ponderacion;
                $excel->prioridad_ahora_entiendo = $prioridad->ahora_entiendo;
                $excel->prioridad_cambio_perspectiva = $prioridad->cambio_perspectiva;
                //fecha de carga de la ficha
                if(!is_null($prioridad->fecha_hora)) {
                    $fecha = Carbon::createFromFormat('Y-m-d H:i:s.u',$prioridad->fecha_hora);
                    $excel->prioridad_fecha_hora = $fecha->format('Y-m-d H:i:s');
                    $excel->prioridad_fecha = $fecha->format('Y-m-d');
                    $excel->prioridad_mes = $fecha->format('Y-m');
                }

            }

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-metadatos: ".$e->getMessage());
            }
        }
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de analitica-metadatos: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-metadatos finalizada con $total_errores errores");
        }
        return $respuesta;

    }

}
