<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_asignacion
 * @property string $entrevista_tipo
 * @property string $entrevista_codigo
 * @property int $entrevista_duracion_minutos
 * @property string $entrevista_macroterritorio
 * @property string $entrevista_territorio
 * @property string $entrevista_entrevistador
 * @property string $entrevista_entrevistador_grupo
 * @property string $asignacion_quien_asigna_codigo
 * @property string $asignacion_urgente
 * @property string $asignacion_responsable_codigo
 * @property string $asignacion_responsable_macroterritorio
 * @property string $asignacion_responsable_territorio
 * @property string $asignacion_responsable_grupo
 * @property string $asignacion_responsable_perfil
 * @property string $procesamiento_situacion
 * @property string $procesamiento_porque_no
 * @property string $procesamiento_terceros
 * @property string $procesamiento_observaciones
 * @property string $fecha_asignado
 * @property string $fecha_revocado
 * @property string $fecha_procesado
 * @property string $fecha_anulado
 * @property int $tiempo_entrevista
 * @property int $tiempo_transcripcion
 */
class excel_asignaciones_transcripcion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.excel_asignaciones_transcripcion';

    /**
     * @var array
     */
    protected $fillable = ['id_asignacion', 'entrevista_tipo', 'entrevista_codigo', 'entrevista_duracion_minutos', 'entrevista_macroterritorio', 'entrevista_territorio', 'entrevista_entrevistador', 'entrevista_entrevistador_grupo', 'asignacion_quien_asigna_codigo', 'asignacion_urgente', 'asignacion_responsable_codigo', 'asignacion_responsable_macroterritorio', 'asignacion_responsable_territorio', 'asignacion_responsable_grupo', 'column_responsable_perfil', 'procesamiento_situacion', 'procesamiento_porque_no', 'procesamiento_terceros', 'procesamiento_observaciones', 'fecha_asignado', 'fecha_revocado', 'fecha_procesado', 'fecha_anulado', 'tiempo_entrevista', 'tiempo_transcripcion'];

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
        Log::notice("ETL de asignaciones para transcribir: inicio del proceso");
        excel_asignaciones_transcripcion::truncate();
        $total_filas = self::cargar_asignaciones();

        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        Log::info("ETL de asignaciones para transcribir: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function cargar_asignaciones() {
        $total_filas=0;
        $listado = transcribir_asignacion::orderby('id_transcribir_asignacion')->get();
        foreach($listado as $fila) {
            $entrevista = excel_asignaciones_transcripcion::traer_entrevista($fila);
            if($entrevista) {
                $excel = new excel_asignaciones_transcripcion();
                $excel->id_asignacion = $fila->id_transcribir_asignacion;
                $excel->entrevista_tipo = substr($fila->codigo,strpos($fila->codigo,"-")+1,2);
                $excel->entrevista_codigo = $fila->codigo;
                $excel->entrevista_duracion_minutos = $entrevista->tiempo_entrevista;
                $excel->entrevista_macroterritorio = $entrevista->fmt_id_macroterritorio;
                $excel->entrevista_territorio = $entrevista->fmt_id_territorio;
                $entrevistador = entrevistador::find($entrevista->id_entrevistador);
                $excel->entrevista_entrevistador = $entrevistador->fmt_numero_entrevistador;
                $excel->entrevista_entrevistador_grupo = $entrevistador->fmt_id_grupo;
                //asignacion
                $excel->asignacion_quien_asigna_codigo = entrevistador::find($fila->id_autoriza)->fmt_numero_entrevistador;
                $excel->asignacion_urgente = $fila->fmt_urgente;
                $quien = entrevistador::find($fila->id_transcriptor);
                $excel->asignacion_responsable_codigo = $quien->fmt_numero_entrevistador;
                $excel->asignacion_responsable_macroterritorio = $quien->fmt_id_macroterritorio;
                $excel->asignacion_responsable_territorio = $quien->fmt_id_macroterritorio;
                $excel->asignacion_responsable_grupo = $quien->fmt_id_grupo;
                $excel->asignacion_responsable_perfil = $quien->fmt_id_nivel;
                //Procesamiento
                $excel->procesamiento_situacion = $fila->fmt_id_situacion;
                $excel->procesamiento_porque_no = $fila->fmt_id_causa;
                $excel->procesamiento_terceros = $fila->terceros == 1 ? "Sí" : "No";
                $excel->procesamiento_observaciones = $fila->observaciones;
                $excel->fecha_asignado = substr($fila->fh_asignado,0,10);
                $excel->fecha_procesado = substr($fila->fh_transcrito,0,10);
                $excel->fecha_revocado = substr($fila->fh_revocado,0,10);
                $excel->fecha_anulado = substr($fila->fh_anulado,0,10);
                $tiempos = $fila->traer_tiempos();
                $excel->tiempo_entrevista = $fila->duracion_entrevista_minutos;
                $excel->tiempo_transcripcion = isset($tiempos[1]) ? $tiempos[1] : null;
                $excel->tiempo_etiquetado = isset($tiempos[2]) ? $tiempos[2] : null;
                $excel->tiempo_fichas = isset($tiempos[3]) ? $tiempos[3] : null;
                $excel->save();
                $total_filas++;
            }
        }
        return $total_filas;

    }

    public static function traer_entrevista($fila) {
        $e=false;
        if($fila->id_e_ind_fvt > 0) {
            $e = entrevista_individual::find($fila->id_e_ind_fvt);
        }
        elseif($fila->id_entrevista_profundidad > 0) {
            $e = entrevista_profundidad::find($fila->id_entrevista_profundidad);
        }
        elseif($fila->id_entrevista_colectiva > 0) {
            $e = entrevista_colectiva::find($fila->id_entrevista_colectiva);
        }
        elseif($fila->id_entrevista_etnica > 0) {
            $e = entrevista_etnica::find($fila->id_entrevista_etnica);
        }
        elseif($fila->id_diagnostico_comunitario > 0) {
            $e = diagnostico_comunitario::find($fila->id_diagnostico_comunitario);
        }
        elseif($fila->id_historia_vida > 0) {
            $e = historia_vida::find($fila->id_historia_vida);
        }
        return $e;
    }


}
