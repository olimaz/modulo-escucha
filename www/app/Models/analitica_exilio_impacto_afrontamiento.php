<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_exilio_impacto_afrontamiento
 * @property int $id_exilio
 * @property int $id_entrevista
 * @property string $codigo_entrevista
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $impacto_afrontamiento
 * @property string $movimiento
 * @property string $tipo
 * @property string $descripcion
 */
class analitica_exilio_impacto_afrontamiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.exilio_impacto_afrontamiento';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_impacto_afrontamiento';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio', 'id_entrevista', 'codigo_entrevista', 'macroterritorio', 'territorio', 'impacto_afrontamiento', 'movimiento', 'tipo', 'descripcion'];

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
        Log::notice("ETL de analitica-exilio_impacto_afrontamiento: inicio del proceso");
        //Inicializar la tabla
        analitica_exilio_impacto_afrontamiento::truncate();

        $listado = exilio::join('esclarecimiento.e_ind_fvt','exilio.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->join('fichas.exilio_impacto','exilio.id_exilio','=','exilio_impacto.id_exilio')
            ->join('catalogos.cat_item','exilio_impacto.id_impacto','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_item.id_cat',[208,209,210,211,214,215])
            ->orderby('exilio.id_e_ind_fvt')
            ->orderby('exilio.id_exilio')
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.descripcion')
            ->selectraw(\DB::raw('exilio_impacto.*, cat_item.descripcion as impacto, cat_item.id_cat'))
            ->get();


        $total_filas=0;
        $total_errores=0;
        $tipo_movimiento[1]="Impactos y afrontamientos específicos del exilio";
        $tipo_movimiento[2]="Impactos y afrontamientos del retorno";
        $tipo[1]="Impacto";
        $tipo[2]="Afrontamiento";

        foreach($listado as $fila) {
            //Buscar referencias
            $exilio = exilio::find($fila->id_exilio);
            $entrevista = entrevista_individual::find($exilio->id_e_ind_fvt);


            //Crear registro
            $excel = new analitica_exilio_impacto_afrontamiento();
            $excel->id_exilio = $exilio->id_exilio;
            $excel->id_entrevista = $entrevista->id_e_ind_fvt;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->macroterritorio = $entrevista->fmt_id_macroterritorio;
            $excel->territorio = $entrevista->fmt_id_territorio;
            if(in_array($fila->id_cat,[214,208,210])) {
                $excel->impacto_afrontamiento = $tipo[1];
            }
            else {
                $excel->impacto_afrontamiento = $tipo[2];
            }
            if(in_array($fila->id_cat,[214,215])) {
                $excel->movimiento = $tipo_movimiento[2];
            }
            else {
                $excel->movimiento = $tipo_movimiento[1];
            }
            $excel->tipo = cat_cat::find($fila->id_cat)->nombre;
            $excel->descripcion = $fila->impacto;

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-exilio_impacto_afrontamiento: ".$e->getMessage());
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

        Log::info("ETL de analitica-exilio_impacto_afrontamiento: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-exilio_impacto_afrontamiento finalizada con  $total_errores errores");
        }
        return $respuesta;

    }

}
