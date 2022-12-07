<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_persona_autoridad_etnica
 * @property int $id_persona
 * @property string $autoridad
 */
class analitica_persona_autoridad_etnica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.persona_autoridad_etnica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_persona_autoridad_etnica';

    /**
     * @var array
     */
    protected $fillable = ['id_persona', 'autoridad'];

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
        Log::notice("ETL de analitica-persona_autoridad_etnica: inicio del proceso");
        //Inicializar la tabla
        analitica_persona_autoridad_etnica::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevistada
        $listado = persona::join('fichas.persona_aut_etnico_ter','persona_aut_etnico_ter.id_persona','=','persona.id_persona')
            ->join('catalogos.cat_item','persona_aut_etnico_ter.id_aut_etnico_ter','=','cat_item.id_item')
            ->orderby('persona.id_persona')
            ->orderby('persona_aut_etnico_ter.id_persona_aut_etnico_ter')
            ->select(\DB::raw('persona_aut_etnico_ter.*, cat_item.descripcion as tipo_autoridad'))
            ->get();
        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Buscar referencias
            //$persona = persona::find($fila->id_persona);
            //Crear registro
            $excel = new analitica_persona_autoridad_etnica();
            $excel->id_persona_autoridad_etnica = $fila->id_persona_aut_etnico_ter;
            $excel->id_persona = $fila->id_persona;
            $excel->autoridad = $fila->tipo_autoridad;

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-persona_autoridad_etnica: ".$e->getMessage());
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

        Log::info("ETL de analitica-persona_autoridad_etnica: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-persona_autoridad_etnica finalizada con  $total_errores errores");
        }

        return $respuesta;

    }



}
