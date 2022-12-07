<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_excel_traza_actividad
 * @property int $id_traza
 * @property int id_entrevistador
 * @property string $tipo_busqueda
 * @property string $criterio_busqueda
 * @property int $numero_entrevistador
 * @property int $nombre_entrevistador
 * @property string $territorio
 * @property string $macroterritorio
 * @property string $grupo
 * @property string $perfil
 * @property string $fecha_hora
 * @property string $fecha_hora_anyo
 * @property string $fecha_hora_mes
 * @property string $fecha_hora_dia
 * @property string $fecha_hora_dia_semana
 * @property string $fecha_hora_hora
 * @property string $fecha_hora_min
 */
class excel_traza_buscadora extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'excel_traza_buscadora';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_traza_buscadora';

    /**
     * @var array
     */
    protected $fillable = ['id_traza', 'id_usuario', 'id_etrevistador', 'tipo_busqueda', 'criterio_busqueda', 'usuario', 'numero_entrevistador', 'territorio', 'macroterritorio', 'grupo', 'perfil', 'fecha_hora', 'fecha_hora_anyo', 'fecha_hora_mes', 'fecha_hora_dia', 'fecha_hora_hora', 'fecha_hora_min'];

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


    public static function generar_plana($truncar=false) {
        $inicio = Carbon::now();
        if($truncar) {
            excel_traza_buscadora::truncate();
        }

        $max = excel_traza_buscadora::max('id_excel_traza_buscadora');
        $max=intval($max);
        Log::notice("ETL de traza de buscadora: inicio del proceso, fila inicial: $max");

        $total_filas = self::procesar_datos();

        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de traza de buscadora: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function procesar_datos() {

        $max = excel_traza_buscadora::max('id_excel_traza_buscadora');
        $max=intval($max);
        $listado = traza_buscador::where('id_traza_buscador','>',$max)->orderby('id_traza_buscador')->get();
        $total_filas=0;
        foreach($listado as $fila) {
            $excel = new excel_traza_buscadora();
            $excel->id_traza = $fila->id_traza_buscador;
            $excel->id_entrevistador = $fila->id_entrevistador;
            $excel->tipo_busqueda = $fila->fmt_id_tipo;
            $excel->criterio_busqueda = $fila->fmt_criterio;
            $quien = $fila->rel_id_entrevistador;
            if($quien) {
                $excel->numero_entrevistador = $quien->numero_entrevistador;
                $excel->nombre_entrevistador = $quien->fmt_nombre;
                $excel->territorio = $quien->fmt_id_territorio;
                $excel->macroterritorio = $quien->fmt_id_macroterritorio;
                $excel->grupo = $quien->fmt_id_grupo;
                $excel->perfil = $quien->fmt_id_nivel;
            }

            //Fecha y hora
            $cortado = substr($fila->fecha_hora, 0, 19);
            $fecha = Carbon::createFromFormat("Y-m-d H:i:s",$cortado);
            $excel->fecha_hora = $cortado;
            $excel->fecha_hora_anyo = $fecha->format("Y");
            $excel->fecha_hora_mes = $fecha->format("Y-m");
            $excel->fecha_hora_dia = $fecha->format("Y-m-d");
            $excel->fecha_hora_dia_semana = $fecha->formatLocalized("%a");
            $excel->fecha_hora_hora = $fecha->format("H");
            $excel->fecha_hora_min = $fecha->format("i");

            $excel->save();
            $total_filas++;

        }
        return $total_filas;
    }

    public static function scopePermisos($query) {
        if(Gate::allows('nivel-1')) {
            // no pasa nada
        }
        else {
            $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
            $arreglo_usuarios=array();
            foreach($arreglo_entrevistadores as $entrevistador) {
                $user = $entrevistador->rel_id_usuario;
                $arreglo_usuarios[]=$user->id;
            }
            $query->wherein('id_usuario',$arreglo_usuarios);
        }
    }

}
