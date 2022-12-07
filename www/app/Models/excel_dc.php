<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_diagnostico_comunitario
 * @property string $codigo_entrevista
 * @property string $medios_virtuales
 * @property string $situacion_actual
 * @property int $personas_entrevistadas
 * @property string $macroterritorio
 * @property string $territorio
 * @property int $clasificacion
 * @property string $codigo_entrevistador
 * @property string $grupo_entrevistador
 * @property string $entrevista_fecha_inicio
 * @property string $entrevista_fecha_inicio_mes
 * @property string $entrevista_fecha_final
 * @property int $tiempo_entrevista
 * @property string $entrevista_lugar_n1
 * @property string $entrevista_lugar_n2
 * @property string $entrevista_lugar_n3
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property string $sector_entrevistado
 * @property string $comunidad
 * @property string $objetivo
 * @property string $dinamica
 * @property string $tema_anio_del
 * @property string $tema_anio_al
 * @property string $tema_lugar_n1
 * @property string $tema_lugar_n2
 * @property string $tema_lugar_n3
 * @property string $titulo
 * @property string $observaciones
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
 * @property int $minutos_entrevista
 * @property int $minutos_transcripcion
 * @property int $minutos_etiquetado
 * @property int $minutos_diligenciado
 */
class excel_dc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_dc';

    /**
     * @var array
     */
    protected $fillable = ['id_diagnostico_comunitario', 'codigo_entrevista', 'medios_virtuales', 'situacion_actual', 'personas_entrevistadas', 'macroterritorio', 'territorio', 'clasificacion', 'codigo_entrevistador', 'grupo_entrevistador', 'entrevista_fecha_inicio', 'entrevista_fecha_inicio_mes', 'entrevista_fecha_final', 'tiempo_entrevista', 'entrevista_lugar_n1', 'entrevista_lugar_n2', 'entrevista_lugar_n3', 'entrevista_lat', 'entrevista_lon', 'sector_entrevistado', 'comunidad', 'objetivo', 'dinamica', 'tema_anio_del', 'tema_anio_al', 'tema_lugar_n1', 'tema_lugar_n2', 'tema_lugar_n3', 'titulo', 'observaciones', 'dinamica_1', 'dinamica_2', 'dinamica_3', 'transcrita', 'transcrita_fecha', 'transcrita_fecha_a', 'transcrita_fecha_m', 'etiquetada', 'etiquetada_fecha', 'etiquetada_fecha_a', 'etiquetada_fecha_m', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'nucleo_01', 'nucleo_02', 'nucleo_03', 'nucleo_04', 'nucleo_05', 'nucleo_06', 'nucleo_07', 'nucleo_08', 'nucleo_09', 'nucleo_10', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'a_consentimiento', 'a_audio', 'a_ficha_corta', 'a_ficha_larga', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_etiquetado', 'a_retroalimentacion', 'a_relatoria', 'a_certificacion_inicial', 'a_certificacion_final', 'a_plan_trabajo', 'a_valoracion', 'fecha_carga', 'mes_carga', 'id_entrevistador', 'prioridad_e_fecha', 'prioridad_e_ponderacion', 'prioridad_e_fluidez', 'prioridad_e_d_hecho', 'prioridad_e_d_contexto', 'prioridad_e_d_impacto', 'prioridad_e_d_justicia', 'prioridad_e_cierre', 'prioridad_e_ahora_entiendo', 'prioridad_e_cambio_perspectiva', 'prioridad_t_fecha', 'prioridad_t_ponderacion', 'prioridad_t_fluidez', 'prioridad_t_d_hecho', 'prioridad_t_d_contexto', 'prioridad_t_d_impacto', 'prioridad_t_d_justicia', 'prioridad_t_cierre', 'prioridad_t_ahora_entiendo', 'prioridad_t_cambio_perspectiva', 'minutos_entrevista', 'minutos_transcripcion', 'minutos_etiquetado', 'minutos_diligenciado'];

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
        Log::notice("ETL de diagnosticos comunitarios: inicio del proceso");

        excel_dc::truncate();
        $total_filas=0;
        // Entrevistas Etnicas
        $res = self::cargar_entrevistas();
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
        Log::info("ETL de diagnosticos comunitarios: fin del proceso, $total_filas filas generadas, $total_errores filas con problemas. Tiempo: $respuesta->duracion.");
        if ($total_errores > 0) {
            Log::error("Problemas en el ETL de diagnosticos comunitarios");
        }
        //
        return $respuesta;
    }

    //Diagnosticos Comunitarios
    public static function cargar_entrevistas() {
        $total_filas=0;
        $total_errores=0;
        $listado = diagnostico_comunitario::where('id_activo',1)->orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_dc();
            $excel->id_diagnostico_comunitario = $fila->id_diagnostico_comunitario;
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
            $excel->entrevista_fecha_inicio = $fila->entrevista_fecha_inicio->format("Y-m-d");
            $excel->entrevista_fecha_inicio_mes = $fila->entrevista_fecha_inicio->format("Y-m");
            if(!is_null($fila->entrevista_fecha_final)) {
                $excel->entrevista_fecha_final = $fila->entrevista_fecha_final->format("Y-m-d");
            }
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
            $excel->comunidad = $fila->tema_comunidad;
            $excel->objetivo = $fila->tema_objetivo;
            $excel->dinamica = $fila->tema_dinamica;
            $excel->tema_anio_del = substr($fila->tema_del,0,4);
            $excel->tema_anio_al = substr($fila->tema_del,0,4);
            $geo = $fila->rel_tema_lugar;
            if($geo) {
                $excel->tema_lugar_n3 = $geo->descripcion;
                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->tema_lugar_n2 = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->tema_lugar_n1 = $geo->descripcion;
                    }
                }
            }
            //Titulo y dinamicas
            $excel->titulo = $fila->titulo;
            $excel->observaciones = $fila->observaciones;
            $i=1;
            foreach($fila->rel_dinamica as $dinamica) {
                $campo = "dinamica_$i";
                $excel->$campo = $dinamica->dinamica;
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
                ->where('prioridad.id_subserie',config('expedientes.dc'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            excel_entrevista_integrado::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.dc'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            excel_entrevista_integrado::procesar_prioridad_t($excel,$prioridad);



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
                Log::debug("Error en generar registro de excel_dc. ". PHP_EOL .$e->getMessage());
            }
        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;
    }
}
