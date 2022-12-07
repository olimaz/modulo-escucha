<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_excel_traza_actividad
 * @property string $fecha_hora
 * @property string $usuario
 * @property string $accion
 * @property string $destino
 * @property string $codigo
 * @property string $referencia
 * @property int $id_usuario
 */
class excel_traza_actividad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'excel_traza_actividad';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_excel_traza_actividad';

    /**
     * @var array
     */
    protected $fillable = ['fecha_hora', 'usuario', 'accion', 'destino', 'codigo', 'referencia', 'id_usuario'];

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
            excel_traza_actividad::truncate();
        }

        $max = excel_traza_actividad::max('id_excel_traza_actividad');
        $max=intval($max);
        Log::notice("ETL de traza de actividad: inicio del proceso, fila inicial: $max");

        $total_filas = self::procesar_datos();

        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de traza de actividad: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function procesar_datos() {

        $max = excel_traza_actividad::max('id_excel_traza_actividad');
        $max=intval($max);
        $listado = traza_actividad::where('id_traza_actividad','>',$max)->orderby('id_traza_actividad')->get();
        $total_filas=0;
        foreach($listado as $fila) {
            $excel = new excel_traza_actividad();
            $excel->id_excel_traza_actividad = $fila->id_traza_actividad;
            $excel->fecha_hora = $fila->fecha_hora;
            $cortado = substr($fila->fecha_hora, 0, 19);
            //dd($cortado);
            $fecha = Carbon::createFromFormat("Y-m-d H:i:s",$cortado);
            $excel->fecha = $fecha->format("Y-m-d");
            $excel->fecha_hora_anyo = $fecha->format("Y");
            $excel->fecha_hora_mes = $fecha->format("m");
            $excel->fecha_hora_dia = $fecha->format("d");
            $excel->fecha_hora_hora = $fecha->format("H");
            $excel->fecha_hora_min = $fecha->format("i");
            $excel->usuario = $fila->fmt_id_usuario;
            $excel->accion = $fila->fmt_id_accion;
            $excel->destino = $fila->fmt_id_objeto;
            $excel->codigo = $fila->codigo;
            $excel->referencia = $fila->referencia;
            //

            $e = $fila->entrevista;
            if($e) {
                $excel->tipo_entrevista = $fila->fmt_tipo_entrevista;
                $excel->correlativo = $e->entrevista_correlativo;
                $excel->entrevista_correlativo = $excel->tipo_entrevista."-".str_pad($excel->correlativo,5,"0",STR_PAD_LEFT);
            }


            $excel->id_usuario = $fila->id_usuario;
            //
            $usr=$fila->rel_id_usuario;
            if($usr) {
                $quien = $usr->rel_entrevistador;
                if($quien) {
                    $excel->numero_entrevistador = $quien->numero_entrevistador;
                    $excel->territorio= $quien->fmt_id_territorio;
                    $excel->macroterritorio= $quien->fmt_id_macroterritorio;
                    $excel->perfil= $quien->fmt_id_nivel;
                    $excel->grupo= $quien->fmt_id_grupo;
                }
            }
            else {
                //dd($fila);
            }


            $excel->save();
            $total_filas++;

        }
        return $total_filas;
    }

    public static function scopePermisos($query) {
        if(Gate::allows('nivel-1')) {
            // no pada nada
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
