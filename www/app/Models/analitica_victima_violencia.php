<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_hecho
 * @property int $id_victima
 */
class analitica_victima_violencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.victima_violencia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_victima'];

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
        //Registrar el evento
        Log::notice("ETL de analitica-victima_violencia: inicio del proceso");
        //Inicializar la tabla
        analitica_victima_violencia::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevistada
        $query = hecho_victima::join('fichas.hecho','hecho_victima.id_hecho','=','hecho.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','persona.id_persona')
            ->join('esclarecimiento.e_ind_fvt','hecho.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->orderby('hecho_victima.id_victima')
            ->orderby('hecho_victima.id_hecho')
            ->select(\DB::raw('distinct hecho_victima.*'));

        $listado = $query->get();

        //dd($query->toSql());
        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_victima_violencia();
            $excel->id_hecho = $fila->id_hecho;
            $excel->id_victima = $fila->id_victima;
            //$excel->ocupacion = $fila->ocupacion;
            $excel->ocupacion_momento_hechos = $fila->fmt_id_ocupacion;
            $excel->ocupacion_momento_hechos_reclasificado = $fila->fmt_id_ocupacion_reclasificado;
            $excel->edad = $fila->edad;
            $sufijo = analitica_exilio_salida::calcular_campos_geo($fila->id_lugar_residencia);
            foreach($sufijo as $var=>$val) {
                $campo = "lugar_res_$var";
                $excel->$campo=$val;
            }
            $excel->lugar_res_zona_id = $fila->id_lugar_residencia_tipo;
            $excel->lugar_res_zona_txt = cat_item::describir($fila->id_lugar_residencia_tipo);



            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-victima_violencia: ".$e->getMessage());
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

        Log::info("ETL de analitica-victima_violencia: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-victima_violencia finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

}
