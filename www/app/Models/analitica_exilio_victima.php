<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_exilio_victimas
 * @property string $codigo_entrevista
 * @property int $id_entrevista
 * @property int $id_exilio
 * @property int $id_persona
 * @property int $id_victima
 * @property int $id_hecho
 * @property string $nombres
 * @property string $apellidos
 * @property string $otros_nombres
 * @property string $sexo
 * @property string $orientacion_sexual
 * @property string $identidad_genero
 * @property int $edad
 * @property string $ocupacion
 * @property string $estado_civil
 * @property string $pertenencia_etnica
 * @property string $pertenencia_indigena
 * @property string $lugar_residencia
 * @property string $lugar_residencia_codigo
 * @property string $lugar_nacimiento
 * @property string $lugar_nacimiento_codigo
 * @property int $fecha_exilio_anio
 * @property int $fecha_exilio_mes
 * @property int $fecha_exilio_dia
 * @property string $lugar_exilio
 * @property string $lugar_exilio_codigo
 */
class analitica_exilio_victima extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.exilio_victimas';
    protected $primaryKey ='id_exilio_victimas';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio_victimas', 'codigo_entrevista', 'id_entrevista', 'id_exilio', 'id_persona', 'id_victima', 'id_hecho', 'nombres', 'apellidos', 'otros_nombres', 'sexo', 'orientacion_sexual', 'identidad_genero', 'edad', 'ocupacion', 'estado_civil', 'pertenencia_etnica', 'pertenencia_indigena', 'lugar_residencia', 'lugar_residencia_codigo', 'lugar_nacimiento', 'lugar_nacimiento_codigo', 'fecha_exilio_anio', 'fecha_exilio_mes', 'fecha_exilio_dia'];

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
        Log::notice("ETL de analitica-exilio_victimas: inicio del proceso");
        //Inicializar la tabla
        analitica_exilio_victima::truncate();

        $listado = entrevista_individual::join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                            ->join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                            ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                            ->join('fichas.persona','victima.id_persona','persona.id_persona')
                            ->join('catalogos.violencia','hecho_violencia.id_tipo_violencia', 'violencia.id_geo')
                            ->join('catalogos.geo','hecho.id_lugar','geo.id_geo')
                            ->where('e_ind_fvt.id_activo',1)  //Entrevistas habilitadas
                            ->where('violencia.codigo','22')  //Exilio
                            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))  //entrevistas a victimas
                    ->get();


        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_exilio_victima();
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->id_persona = $fila->id_persona;
            $excel->id_victima = $fila->id_victima;
            $excel->id_hecho = $fila->id_hecho;
            $excel->nombres = $fila->nombre;
            $excel->apellidos = $fila->apellido;
            $excel->otros_nombres = $fila->alias;
            $excel->sexo = cat_item::describir($fila->id_sexo);
            $excel->orientacion_sexual = cat_item::describir($fila->id_orientacion);
            $excel->identidad_genero = cat_item::describir($fila->id_identidad);
            $excel->estado_civil = cat_item::describir($fila->id_estado_civil);
            $excel->pertenencia_etnica = cat_item::describir($fila->id_etnia);
            $excel->pertenencia_indigena = cat_item::describir($fila->id_etnia_indigena);
            //
            $al_momento_hechos = hecho_victima::find($fila->id_hecho_victima);
            $excel->edad = $al_momento_hechos->edad;
            $excel->ocupacion = $al_momento_hechos->ocupacion;
            $lugar = geo::find($al_momento_hechos->id_lugar_residencia);
            if($lugar) {
                $excel->lugar_residencia = $lugar->descripcion;
                $excel->lugar_residencia_codigo = $lugar->codigo;
            }
            $lugar = geo::find($fila->id_lugar_nacimiento);
            if($lugar) {
                $excel->lugar_nacimiento = $lugar->descripcion;
                $excel->lugar_nacimiento_codigo = $lugar->codigo;
            }
            $excel->fecha_exilio_anio = $fila->fecha_ocurrencia_a;
            $excel->fecha_exilio_mes = $fila->fecha_ocurrencia_m;
            $excel->fecha_exilio_dia = $fila->fecha_ocurrencia_d;

            $lugar = geo::find($fila->id_lugar);
            if($lugar) {
                $excel->lugar_exilio = $lugar->descripcion;
                $excel->lugar_exilio_codigo = $lugar->codigo;
            }


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-exilio_victima: ".$e->getMessage());
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

        Log::info("ETL de analitica-exilio_victimas: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-exilio_victimas finalizada con  $total_errores errores");
        }
        return $respuesta;

    }

}
