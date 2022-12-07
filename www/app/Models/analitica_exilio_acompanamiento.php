<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_exilio_acompanamiento
 * @property int $id_exilio_movimiento
 * @property int $id_exilio
 * @property int $id_entrevista
 * @property string $codigo_entrevista
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $tipo_movimiento
 * @property string $momento
 * @property string $acompanamiento
 */
class analitica_exilio_acompanamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.exilio_acompanamiento';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_acompanamiento';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio_movimiento', 'id_exilio', 'id_entrevista', 'codigo_entrevista', 'macroterritorio', 'territorio', 'tipo_movimiento', 'momento', 'acompanamiento'];

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

    /*
    * Poblar la tabla
    */
    public static function generar_plana() {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("ETL de analitica-exilio_acompañamiento: inicio del proceso");
        //Inicializar la tabla
        analitica_exilio_acompanamiento::truncate();

        $listado = exilio_movimiento::join('fichas.exilio','exilio_movimiento.id_exilio','=','exilio.id_exilio')
            ->join('esclarecimiento.e_ind_fvt','exilio.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->join('fichas.exilio_movimiento_proteccion','exilio_movimiento.id_exilio_movimiento','=','exilio_movimiento_proteccion.id_exilio_movimiento')
            ->join('catalogos.cat_item','exilio_movimiento_proteccion.id_proteccion','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->where('cat_item.id_cat',218)
            ->orderby('exilio.id_e_ind_fvt')
            ->orderby('exilio.id_exilio')
            ->orderby('exilio_movimiento.id_exilio_movimiento')
            ->selectraw(\DB::raw('exilio.institucion_ayuda, exilio_movimiento.*, exilio_movimiento_proteccion.id_tipo as momento, cat_item.descripcion as proteccion'))
            ->get();

        $total_filas=0;
        $total_errores=0;
        $tipo_movimiento[1]="Primera salida";
        $tipo_movimiento[2]="Reasentamiento";
        $tipo_movimiento[3]="Retorno";
        $tipo_momento[1]="Salida";
        $tipo_momento[2]="Retorno";

        foreach($listado as $fila) {
            //Buscar referencias
            $exilio = exilio::find($fila->id_exilio);
            $entrevista = entrevista_individual::find($exilio->id_e_ind_fvt);


            //Crear registro
            $excel = new analitica_exilio_acompanamiento();
            $excel->id_exilio_movimiento = $fila->id_exilio_movimiento;
            $excel->id_exilio = $exilio->id_exilio;
            $excel->id_entrevista = $entrevista->id_e_ind_fvt;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->macroterritorio = $entrevista->fmt_id_macroterritorio;
            $excel->territorio = $entrevista->fmt_id_territorio;
            $excel->tipo_movimiento = $tipo_movimiento[$fila->id_tipo_movimiento];
            $excel->momento = $tipo_momento[$fila->momento];
            $excel->acompanamiento = $fila->proteccion;
            if($fila->id_tipo_movimiento==3 && $fila->momento==1) {
                $excel->institucion_ayuda = $fila->institucion_ayuda;
            }






            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-exilio_retorno: ".$e->getMessage());
            }
        }
        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de analitica-exilio_acompañamiento: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-exilio_acompañamiento finalizada con  $total_errores errores");
        }
        return $respuesta;

    }

}
