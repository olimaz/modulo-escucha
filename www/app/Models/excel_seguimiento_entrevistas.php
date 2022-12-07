<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_seguimiento
 * @property int $id_seguimiento_problema
 * @property int $id_entrevistador
 * @property string $codigo
 * @property string $entrevistador_codigo
 * @property string $tipo_seguimiento
 * @property string $descripcion
 * @property string $puede_resolverse
 * @property string $resolucion_sugerida
 * @property string $ha_sido_resuelto
 * @property string $anotaciones
 * @property string $fecha_reportado
 * @property string $fecha_resuelto
 */
class excel_seguimiento_entrevistas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.excel_seguimiento_entrevistas';

    /**
     * @var array
     */
    protected $fillable = ['id_seguimiento', 'id_seguimiento_problema', 'id_entrevistador', 'codigo', 'entrevistador_codigo', 'tipo_seguimiento', 'descripcion', 'puede_resolverse', 'resolucion_sugerida', 'ha_sido_resuelto', 'anotaciones', 'fecha_reportado', 'fecha_resuelto'];

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
        Log::notice("ETL de seguimiento a entrevistas: inicio del proceso");

        excel_seguimiento_entrevistas::truncate();
        $total_filas = self::cargar_asignaciones();



        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de seguimiento a entrevistas:  fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function cargar_asignaciones() {
        $total_filas=0;
        $listado = seguimiento::join('public.seguimiento_problema','seguimiento.id_seguimiento','=','seguimiento_problema.id_seguimiento')
                                ->orderby('seguimiento_problema.id_seguimiento')
                                ->orderby('seguimiento_problema.id_seguimiento_problema')
                                ->get();

        foreach($listado as $fila) {
            $excel = new excel_seguimiento_entrevistas();
            $excel->id_seguimiento = $fila->id_seguimiento;
            $excel->id_seguimiento_problema = $fila->id_seguimiento_problema;
            $quien = $fila->rel_id_entrevistador;
            $excel->id_entrevistador = $quien->id_entrevistador;
            $excel->entrevistador_codigo = $quien->fmt_numero_entrevistador;

            $entrevista = $fila->entrevista->entrevista;
            $excel->codigo=$entrevista->entrevista_codigo;
            $excel->procesamiento_cerrado = $entrevista->id_cerrado ==1 ? 1 : 0 ;
            $excel->macroterritorio = $entrevista->fmt_id_macroterritorio;
            $excel->territorio = $entrevista->fmt_id_territorio;
            $excel->grupo = $quien->fmt_id_grupo;
            $problema = seguimiento_problema::find($fila->id_seguimiento_problema);
            $excel->tipo_seguimiento = $problema->fmt_id_tipo_problema;
            $excel->descripcion = $problema->descripcion;
            $excel->puede_resolverse = $problema->fmt_id_resolvible;
            $excel->resolucion_sugerida = $problema->sugerencia;
            $excel->ha_sido_resuelto = $problema->cerrado_id_estado == 1 ? "Sí" : "No";
            $excel->anotaciones = $problema->cerrado_anotaciones;
            $excel->fecha_reportado = substr($fila->fecha_hora,0,10);
            $excel->fecha_resuelto = substr($problema->cerrado_fecha_hora,0,10);
            $excel->save();
            $total_filas++;

        }
        return $total_filas;

    }

}
