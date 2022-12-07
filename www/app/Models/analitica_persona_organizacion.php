<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_persona_organizacion
 * @property int $id_persona
 * @property string $institucion_tipo
 * @property string $institucion_nombre
 * @property string $rol
 */
class analitica_persona_organizacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.persona_organizacion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_persona_organizacion';

    /**
     * @var array
     */
    protected $fillable = ['id_persona', 'institucion_tipo', 'institucion_nombre', 'rol'];

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
        Log::notice("ETL de analitica-persona_organizacion: inicio del proceso");
        //Inicializar la tabla
        analitica_persona_organizacion::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevistada
        $listado = persona::join('fichas.persona_organizacion','persona_organizacion.id_persona','=','persona.id_persona')
            ->join('catalogos.cat_item','persona_organizacion.id_tipo_organizacion','=','cat_item.id_item')
            ->orderby('persona.id_persona')
            ->orderby('persona_organizacion.id_persona_organizacion')
            ->select(\DB::raw('persona_organizacion.*, cat_item.descripcion as tipo_organizacion'))
            ->get();
        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Buscar referencias
            //$persona = persona::find($fila->id_persona);
            //Crear registro
            $excel = new analitica_persona_organizacion();
            $excel->id_persona_organizacion = $fila->id_persona_organizacion;
            $excel->id_persona = $fila->id_persona;
            $excel->institucion_tipo = $fila->tipo_organizacion;
            $excel->institucion_nombre = $fila->nombre;
            $excel->rol = $fila->rol;

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-persona_organizacion: ".$e->getMessage());
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

        Log::info("ETL de analitica-persona_organizacion: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-persona_organizacion finalizada con  $total_errores errores");
        }

        return $respuesta;

    }



}
