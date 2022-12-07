<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_responsable
 * @property int $id_entrevista
 * @property int $id_hecho_responsable
 * @property int $id_hecho
 * @property int $id_persona
 * @property string $codigo_entrevista
 * @property string $nombre
 * @property string $apellido
 * @property string $otros_nombres
 * @property int $edad
 * @property string $sexo
 * @property string $pertenencia_etnica
 * @property string $pertenencia_indigena
 * @property string $actor_armado
 * @property string $rango_cargo
 * @property int $responsabilidad_ordeno
 * @property int $responsabilidad_planeo
 * @property int $responsabilidad_realizo
 * @property int $responsabilidad_participo
 * @property int $responsabilidad_no_evito
 * @property string $nombre_superior
 * @property int $sabe_que_hace_ahora
 * @property string $ahora_que_hace
 * @property string $ahora_donde_esta
 * @property int $sabe_otros_hechos
 * @property string $cuales_otros_hechos
 */
class analitica_pri extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.presunto_responsable_individual';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_responsable';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_persona', 'codigo_entrevista', 'nombre', 'apellido', 'otros_nombres', 'edad', 'sexo', 'pertenencia_etnica', 'pertenencia_indigena', 'actor_armado', 'rango_cargo', 'responsabilidad_ordeno', 'responsabilidad_planeo', 'responsabilidad_realizo', 'responsabilidad_participo', 'responsabilidad_no_evito', 'nombre_superior', 'sabe_que_hace_ahora', 'ahora_que_hace', 'ahora_donde_esta', 'sabe_otros_hechos', 'cuales_otros_hechos'];

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
        Log::notice("ETL de analitica-pri: inicio del proceso");
        //Inicializar la tabla
        analitica_pri::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevistada
        $listado = persona_responsable::join('esclarecimiento.e_ind_fvt','persona_responsable.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->join('fichas.persona','persona_responsable.id_persona','=','persona.id_persona')
            ->join('fichas.hecho_responsable','persona_responsable.id_persona_responsable','hecho_responsable.id_persona_responsable')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            //->orderby('e_ind_fvt.entrevista_correlativo')
            ->orderby('persona_responsable.id_persona_responsable')
            ->select(\DB::raw('distinct persona_responsable.*, hecho_responsable.id_hecho, hecho_responsable.id_hecho_responsable'))
            ->get();
        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Buscar referencias
            $persona = persona::find($fila->id_persona);
            $entrevista = entrevista_individual::find($fila->id_e_ind_fvt);
            //Crear registro

            $excel = new analitica_pri();
            $excel->id_hecho_responsable = $fila->id_hecho_responsable;
            $excel->id_responsable = $fila->id_persona_responsable;
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->id_hecho = $fila->id_hecho;
            $excel->id_persona = $fila->id_persona;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->nombre = $persona->nombre;
            $excel->apellido = $persona->apellido;
            $excel->otros_nombres = $persona->alias;
            $excel->sexo = cat_item::describir($persona->id_sexo);
            $excel->edad = cat_item::describir($fila->id_edad_aproximada);
            $excel->pertenencia_etnica = cat_item::describir($persona->pertenencia_etnica);
            $excel->pertenencia_indigena = cat_item::describir($persona->pertenencia_indigena);
            $excel->actor_armado = cat_item::describir($fila->id_rango_cargo);
            if(!is_null($fila->id_grupo_paramilitar)) {
                $excel->rango_cargo = cat_item::describir($fila->id_grupo_paramilitar);
            }
            if(!is_null($fila->id_guerrilla)) {
                $excel->rango_cargo = cat_item::describir($fila->id_guerrilla);
            }
            if(!is_null($fila->id_fuerza_publica)) {
                $excel->rango_cargo = cat_item::describir($fila->id_fuerza_publica);
            }
            //Responsabilidades en el caso
            $detalle = $fila->rel_responsabilidad;
            foreach($detalle as $item) {
                $campo=$item->detalle->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            $excel->nombre_superior = $fila->nombre_superior;
            $excel->sabe_que_hace_ahora = $fila->conoce_info==1 ? 1 : 0;
            $excel->ahora_que_hace = $fila->que_hace;
            $excel->ahora_donde_esta = $fila->donde_esta;
            $excel->sabe_otros_hechos = $fila->otros_hechos==1 ? 1 : 0;
            $excel->cuales_otros_hechos = $fila->cuales;


            if(!is_null($fila->insert_fh)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->insert_fh);
                $excel->insert_fecha_hora = $fecha->format('Y-m-d H:i:s');
                $excel->insert_fecha = $fecha->format('Y-m-d');
                $excel->insert_fecha_mes = $fecha->format('Y-m');
            }

            if(!is_null($fila->update_fh)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->update_fh);
                $excel->update_fecha_hora = $fecha->format('Y-m-d H:i:s');
                $excel->update_fecha_mes = $fecha->format('Y-m');
                $excel->update_fecha = $fecha->format('Y-m-d');
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-pri: ".$e->getMessage());
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

        Log::info("ETL de analitica-pri: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-pri finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

}
