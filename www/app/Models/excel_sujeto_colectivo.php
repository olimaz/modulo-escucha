<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_entrevista_etnica
 * @property string $codigo_entrevista
 * @property string $medios_virtuales
 * @property string $situacion_actual
 * @property int $personas_entrevistadas
 * @property string $macroterritorio
 * @property string $territorio
 * @property int $clasificacion
 * @property string $codigo_entrevistador
 * @property string $grupo_entrevistador
 * @property string $entrevista_fecha
 * @property string $entrevista_mes
 * @property int $tiempo_entrevista
 * @property string $entrevista_lugar_n1
 * @property string $entrevista_lugar_n2
 * @property string $entrevista_lugar_n3
 * @property string $tipo_entrevista
 * @property string $tipo_sujeto_colectivo
 * @property string $sector_entrevistado
 * @property int $i_achagua
 * @property int $i_ambalo
 * @property int $i_amorua
 * @property int $i_andoke
 * @property int $i_arhuaco
 * @property int $i_awa
 * @property int $i_barasan
 * @property int $i_bara
 * @property int $i_bari
 * @property int $i_betoye
 * @property int $i_bora
 * @property int $i_carapana
 * @property int $i_chiricoa
 * @property int $i_cocama
 * @property int $i_coreguaje
 * @property int $i_curripako
 * @property int $i_desano
 * @property int $i_embera_chami
 * @property int $i_embrea_dobida
 * @property int $i_embera_katio
 * @property int $i_eperara
 * @property int $i_ett
 * @property int $i_guanaca
 * @property int $i_guane
 * @property int $i_guna
 * @property int $i_hitnu
 * @property int $i_hupde
 * @property int $i_ijku
 * @property int $i_inga
 * @property int $i_jiw
 * @property int $i_jupda
 * @property int $i_juhup
 * @property int $i_kakua
 * @property int $i_kamentsa
 * @property int $i_kankuamo
 * @property int $i_karijona
 * @property int $i_kawiyari
 * @property int $i_kofan
 * @property int $i_kogui
 * @property int $i_kokonuko
 * @property int $i_kubeo
 * @property int $i_leguama
 * @property int $i_makaguaje
 * @property int $i_makuma
 * @property int $i_mapayerri
 * @property int $i_masiguare
 * @property int $i_matapi
 * @property int $i_mirana
 * @property int $i_misak
 * @property int $i_mokana
 * @property int $i_muina
 * @property int $i_muisca
 * @property int $i_nasa
 * @property int $i_nonyha
 * @property int $i_nukak
 * @property int $i_pastos
 * @property int $i_piapoco
 * @property int $i_piarona
 * @property int $i_pijao
 * @property int $i_piratapuyo
 * @property int $i_pisamira
 * @property int $i_plindara
 * @property int $i_pubense
 * @property int $i_puinave
 * @property int $i_quichua
 * @property int $i_quillanciga
 * @property int $i_quizgo
 * @property int $i_sikuani
 * @property int $i_siona
 * @property int $i_saliba
 * @property int $i_taiwano
 * @property int $i_tama
 * @property int $i_tanigua
 * @property int $i_tanimuka
 * @property int $i_tatuyo
 * @property int $i_tikuna
 * @property int $i_totoro
 * @property int $i_tsiripu
 * @property int $i_tubu
 * @property int $i_tucano
 * @property int $i_tutyka
 * @property int $i_uwa
 * @property int $i_uitoto
 * @property int $i_wamonae
 * @property int $i_wanano
 * @property int $i_waunan
 * @property int $i_wayuu
 * @property int $i_wipijiki
 * @property int $i_wiwa
 * @property int $i_yagua
 * @property int $i_yamalero
 * @property int $i_yanacona
 * @property int $i_yari
 * @property int $i_yaruro
 * @property int $i_yauna
 * @property int $i_yeral
 * @property int $i_yukpa
 * @property int $i_yukuna
 * @property int $i_yuri
 * @property int $i_yuruti
 * @property int $i_zenu
 * @property int $a_afrocolombiano
 * @property int $a_negro
 * @property int $a_palenquero
 * @property int $a_raizal
 * @property int $r_cucuta
 * @property int $r_envigado
 * @property int $r_giron
 * @property int $r_ibague
 * @property int $r_pasto
 * @property int $r_prorom
 * @property int $r_sabanalarga
 * @property int $r_sahagun
 * @property int $r_sampues
 * @property int $r_san_pelayo
 * @property int $r_union_romani
 * @property string $tema
 * @property string $objetivo
 * @property string $hechos_anio_del
 * @property string $hechos_anio_al
 * @property string $hechos_lugar_n1
 * @property string $hechos_lugar_n2
 * @property string $hechos_lugar_n3
 * @property string $descripcin_eventos
 * @property string $titulo
 * @property string $dinamica_1
 * @property string $dinamica_2
 * @property string $dinamica_3
 * @property int $transcrita
 * @property string $transcrita_fecha
 * @property string $transcrita_fecha_a
 * @property string $transcrita_fecha_m
 * @property int $etiquetada
 * @property string $etiquetada_fecha
 * @property string $etiquetada_fecha_a
 * @property string $etiquetada_fecha_m
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
 * @property int $a_otros
 * @property int $a_transcripcion_preliminar
 * @property int $a_transcripcion_final
 * @property int $a_etiquetado
 * @property int $a_retroalimentacion
 * @property int $a_relatoria
 * @property int $a_certificacion_inicial
 * @property int $a_certificacion_final
 * @property int $a_plan_trabajo
 * @property int $a_valoracion
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property string $fecha_carga
 * @property string $mes_carga
 * @property int $id_entrevistador
 * @property string $prioridad_e_fecha
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
 * @property int $consentimiento_conceder_entrevista
 * @property int $consentimiento_grabar_audio
 * @property int $consentimiento_elaborar_informe
 * @property int $consentimiento_grabar_video
 * @property int $consentimiento_tomar_fotos
 * @property int $consentimiento_tratamiento_datos_analizar
 * @property int $consentimiento_tratamiento_datos_analizar_sensible
 * @property int $consentimiento_tratamiento_datos_utilizar
 * @property int $consentimiento_tratamiento_datos_utilizar_sensible
 * @property int $consentimiento_tratamiento_datos_publicar
 * @property int $minutos_entrevista
 * @property int $minutos_transcripcion
 * @property int $minutos_etiquetado
 * @property int $minutos_diligenciado
 */
class excel_sujeto_colectivo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_sujeto_colectivo';

    /**
     * @var array
     */
    protected $fillable = ['codigo_entrevista', 'medios_virtuales', 'situacion_actual', 'personas_entrevistadas', 'macroterritorio', 'territorio', 'clasificacion', 'codigo_entrevistador', 'grupo_entrevistador', 'entrevista_fecha', 'entrevista_mes', 'tiempo_entrevista', 'entrevista_lugar_n1', 'entrevista_lugar_n2', 'entrevista_lugar_n3', 'tipo_entrevista', 'tipo_sujeto_colectivo', 'sector_entrevistado', 'i_achagua', 'i_ambalo', 'i_amorua', 'i_andoke', 'i_arhuaco', 'i_awa', 'i_barasan', 'i_bara', 'i_bari', 'i_betoye', 'i_bora', 'i_carapana', 'i_chiricoa', 'i_cocama', 'i_coreguaje', 'i_curripako', 'i_desano', 'i_embera_chami', 'i_embrea_dobida', 'i_embera_katio', 'i_eperara', 'i_ett', 'i_guanaca', 'i_guane', 'i_guna', 'i_hitnu', 'i_hupde', 'i_ijku', 'i_inga', 'i_jiw', 'i_jupda', 'i_juhup', 'i_kakua', 'i_kamentsa', 'i_kankuamo', 'i_karijona', 'i_kawiyari', 'i_kofan', 'i_kogui', 'i_kokonuko', 'i_kubeo', 'i_leguama', 'i_makaguaje', 'i_makuma', 'i_mapayerri', 'i_masiguare', 'i_matapi', 'i_mirana', 'i_misak', 'i_mokana', 'i_muina', 'i_muisca', 'i_nasa', 'i_nonyha', 'i_nukak', 'i_pastos', 'i_piapoco', 'i_piarona', 'i_pijao', 'i_piratapuyo', 'i_pisamira', 'i_plindara', 'i_pubense', 'i_puinave', 'i_quichua', 'i_quillanciga', 'i_quizgo', 'i_sikuani', 'i_siona', 'i_saliba', 'i_taiwano', 'i_tama', 'i_tanigua', 'i_tanimuka', 'i_tatuyo', 'i_tikuna', 'i_totoro', 'i_tsiripu', 'i_tubu', 'i_tucano', 'i_tutyka', 'i_uwa', 'i_uitoto', 'i_wamonae', 'i_wanano', 'i_waunan', 'i_wayuu', 'i_wipijiki', 'i_wiwa', 'i_yagua', 'i_yamalero', 'i_yanacona', 'i_yari', 'i_yaruro', 'i_yauna', 'i_yeral', 'i_yukpa', 'i_yukuna', 'i_yuri', 'i_yuruti', 'i_zenu', 'a_afrocolombiano', 'a_negro', 'a_palenquero', 'a_raizal', 'r_cucuta', 'r_envigado', 'r_giron', 'r_ibague', 'r_pasto', 'r_prorom', 'r_sabanalarga', 'r_sahagun', 'r_sampues', 'r_san_pelayo', 'r_union_romani', 'tema', 'objetivo', 'hechos_anio_del', 'hechos_anio_al', 'hechos_lugar_n1', 'hechos_lugar_n2', 'hechos_lugar_n3', 'descripcin_eventos', 'titulo', 'dinamica_1', 'dinamica_2', 'dinamica_3', 'transcrita', 'transcrita_fecha', 'transcrita_fecha_a', 'transcrita_fecha_m', 'etiquetada', 'etiquetada_fecha', 'etiquetada_fecha_a', 'etiquetada_fecha_m', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'a_consentimiento', 'a_audio', 'a_ficha_corta', 'a_ficha_larga', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_etiquetado', 'a_retroalimentacion', 'a_relatoria', 'a_certificacion_inicial', 'a_certificacion_final', 'a_plan_trabajo', 'a_valoracion', 'entrevista_lat', 'entrevista_lon', 'fecha_carga', 'mes_carga', 'id_entrevistador', 'prioridad_e_fecha', 'prioridad_e_ponderacion', 'prioridad_e_fluidez', 'prioridad_e_d_hecho', 'prioridad_e_d_contexto', 'prioridad_e_d_impacto', 'prioridad_e_d_justicia', 'prioridad_e_cierre', 'prioridad_e_ahora_entiendo', 'prioridad_e_cambio_perspectiva', 'prioridad_t_fecha', 'prioridad_t_ponderacion', 'prioridad_t_fluidez', 'prioridad_t_d_hecho', 'prioridad_t_d_contexto', 'prioridad_t_d_impacto', 'prioridad_t_d_justicia', 'prioridad_t_cierre', 'prioridad_t_ahora_entiendo', 'prioridad_t_cambio_perspectiva', 'consentimiento_conceder_entrevista', 'consentimiento_grabar_audio', 'consentimiento_elaborar_informe', 'consentimiento_grabar_video', 'consentimiento_tomar_fotos', 'consentimiento_tratamiento_datos_analizar', 'consentimiento_tratamiento_datos_analizar_sensible', 'consentimiento_tratamiento_datos_utilizar', 'consentimiento_tratamiento_datos_utilizar_sensible', 'consentimiento_tratamiento_datos_publicar', 'minutos_entrevista', 'minutos_transcripcion', 'minutos_etiquetado', 'minutos_diligenciado'];

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
        Log::notice("ETL de entrevistas a sujeto colectivo: inicio del proceso");

        excel_sujeto_colectivo::truncate();
        $total_filas=0;
        // Entrevistas Etnicas
        $res = self::cargar_etnicas();
        $total_filas    =$res['si'];
        $total_errores  =$res['no'];
        // Fin
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        //Registro
        Log::info("ETL de entrevistas a sujeto colectivo: fin del proceso, $total_filas filas generadas, $total_errores filas con problemas. Tiempo: $respuesta->duracion.");
        if ($total_errores > 0) {
            Log::error("Problemas en el ETL de entrevistas a sujeto colectivo");
        }
        //
        return $respuesta;
    }



    //Sujetos colectivos: EE
    public static function cargar_etnicas() {
        $total_filas=0;
        $total_errores=0;
        $listado = entrevista_etnica::where('id_activo',1)->orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_sujeto_colectivo();
            $excel->id_entrevista_etnica = $fila->id_entrevista_etnica;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->medios_virtuales = $fila->es_virtual==1 ? 1 : 0;
            $excel->situacion_actual = cat_item::describir($fila->entrevista_avance);
            $excel->personas_entrevistadas=$fila->cantidad_participantes;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio= $fila->fmt_id_territorio;
            $excel->clasificacion = $fila->clasificacion_nivel;
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
            $excel->tipo_entrevista = cat_item::describir($fila->id_tipo_entrevista);
            $excel->tipo_sujeto_colectivo = cat_item::describir($fila->id_tipo_sujeto);
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->tema = $fila->tema_descripcion;
            $excel->objetivo = $fila->tema_objetivo;
            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);
            $geo = $fila->rel_tema_lugar;
            if($geo) {
                $excel->hechos_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            $excel->descripcin_eventos = $fila->eventos_descripcion;
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                $campo = "dinamica_$i";
                $excel->$campo = $dinamica->dinamica;
            }
            // PArticipantes indigenas
            $aa = $fila->rel_indigena;
            foreach($aa as $item) {
                $campo=$item->rel_id_indigena->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            // PArticipantes afro
            $aa = $fila->rel_narp;
            foreach($aa as $item) {
                $campo=$item->rel_id_narf->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            // PArticipantes rrom
            $aa = $fila->rel_rrom;
            foreach($aa as $item) {
                $campo=$item->rel_id_rrom->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            $excel->transcrita = is_null($fila->html_transcripcion) ? "0" : "1";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "0" : "1";
            $transcripcion = transcribir_asignacion::tiene_transcripcion($fila);
            if($transcripcion) {
                $excel->transcrita_fecha = substr($transcripcion->fh_transcrito,0,10);
                $excel->transcrita_fecha_a = substr($transcripcion->fh_transcrito,0,4);
                $excel->transcrita_fecha_m = substr($transcripcion->fh_transcrito,0,7);
            }
            //Etiquetado
            $etiquetado = etiquetar_asignacion::tiene_etiquetado($fila);
            if($etiquetado) {
                $excel->etiquetada_fecha = substr($etiquetado->fh_transcrito,0,10);
                $excel->etiquetada_fecha_a = substr($etiquetado->fh_transcrito,0,4);
                $excel->etiquetada_fecha_m = substr($etiquetado->fh_transcrito,0,7);
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
            //Adjuntos
            $adjuntos[1]="a_consentimiento";
            $adjuntos[2]="a_audio";
            $adjuntos[3]="a_ficha_corta";
            $adjuntos[5]="a_ficha_larga";
            $adjuntos[4]="a_otros";
            $adjuntos[8]="a_transcripcion_preliminar";
            $adjuntos[6]="a_transcripcion_final";
            $adjuntos[10]="a_retroalimentacion";
            $adjuntos[11]="a_relatoria";
            $adjuntos[17]="a_certificacion_inicial";
            $adjuntos[18]="a_certificacion_final";
            $adjuntos[25]="a_etiquetado";
            foreach($fila->rel_adjunto as $adjunto) {
                if(isset($adjuntos[$adjunto->id_tipo])) {
                    $campo=$adjuntos[$adjunto->id_tipo];
                    $excel->$campo=1;
                }
            }
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            $excel->id_entrevistador = $fila->id_entrevistador;

            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.ee'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            excel_entrevista_integrado::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.ee'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            excel_entrevista_integrado::procesar_prioridad_t($excel,$prioridad);

            //Consentimiento informado
            //Diligenciamiento
            $d = $fila->diligenciada;
            if($d->fichas->entrevista) {
                $excel->consentimiento_nombre_autoridad =  $d->fichas->entrevista->nombre_autoridad_etnica;
                $excel->consentimiento_nombre_identitario =  $d->fichas->entrevista->nombre_identitario;
                $excel->consentimiento_pueblo_representado  =  cat_item::describir($d->fichas->entrevista->id_pueblo_representado);
                $excel->consentimiento_numero_identificacion =  $d->fichas->entrevista->identificacion_consentimiento;
                $excel->consentimiento_conceder_entrevista = $d->fichas->entrevista->conceder_entrevista==1 ? 1: 0;
                $excel->consentimiento_grabar_audio = $d->fichas->entrevista->grabar_audio==1 ? 1: 0;
                $excel->consentimiento_elaborar_informe = $d->fichas->entrevista->elaborar_informe==1 ? 1: 0;
                $excel->consentimiento_grabar_video = $d->fichas->entrevista->grabar_video==1 ? 1: 0;
                $excel->consentimiento_tomar_fotos = $d->fichas->entrevista->tomar_fotografia==1 ? 1: 0;
                $excel->consentimiento_tratamiento_datos_analizar = $d->fichas->entrevista->tratamiento_datos_analizar==1 ? 1: 0;
                $excel->consentimiento_tratamiento_datos_analizar_sensible = $d->fichas->entrevista->tratamiento_datos_analizar_sensible==1 ? 1: 0;
                $excel->consentimiento_tratamiento_datos_utilizar = $d->fichas->entrevista->tratamiento_datos_utilizar==1 ? 1: 0;
                $excel->consentimiento_tratamiento_datos_utilizar_sensible = $d->fichas->entrevista->tratamiento_datos_utilizar_sensible==1 ? 1: 0;
                $excel->consentimiento_tratamiento_datos_publicar = $d->fichas->entrevista->tratamiento_datos_publicar==1 ? 1: 0;
            }

            //Tiempos
            $tiempo = $fila->tiempo_procesamiento;
            if($tiempo) {
                $excel->minutos_entrevista = $tiempo[0];
                $excel->minutos_transcripcion = $tiempo[1];
                $excel->minutos_etiquetado= $tiempo[2];
                $excel->minutos_diligenciado= $tiempo[2];
            }

            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_sujeto_colectivo. ". PHP_EOL .$e->getMessage());
            }
        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;
    }


}
