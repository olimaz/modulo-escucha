<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_entrevistador
 * @property int $numero_entrevistador
 * @property string $codigo_entrevistador
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $grupo
 * @property string $privilegios_perfil
 * @property int $privilegios_restringido
 * @property string $usuario
 * @property string $nombre
 * @property string $correo
 * @property string $creado_fh
 * @property string $creado_fecha
 * @property string $creado_mes
 */
class excel_usuarios extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_usuarios';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevistador';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['numero_entrevistador', 'codigo_entrevistador', 'macroterritorio', 'territorio', 'grupo', 'privilegios_perfil', 'privilegios_restringido', 'usuario', 'nombre', 'correo', 'creado_fh', 'creado_fecha', 'creado_mes'];

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



    //
    public static function generar_plana() {
        $inicio = Carbon::now();
        // Nueva logica, siempre truncar
        Log::notice("ETL de exel_usuarios: inicio del proceso");
        $total_filas=0;
        $total_errores=0;
        excel_usuarios::truncate();

        $listado = entrevistador::orderby('id_entrevistador')->get();

        foreach($listado as $fila) {
            $excel = new excel_usuarios();
            $excel->id_entrevistador = $fila->id_entrevistador;
            $excel->numero_entrevistador = $fila->numero_entrevistador;
            $excel->codigo_entrevistador = $fila->fmt_numero_entrevistador;
            $excel->macroterritorio = $fila->fmt_id_macroterritorio;
            $excel->territorio = $fila->fmt_id_territorio;
            $excel->grupo = $fila->fmt_id_grupo;
            $excel->privilegios_perfil = $fila->fmt_id_nivel;
            $excel->privilegios_restringido = $fila->solo_lectura==1 ? 1 : 0;
            $excel->usuario = $fila->rel_usuario->username;
            $excel->nombre = $fila->rel_usuario->name;
            $excel->correo = $fila->rel_usuario->email;
            if(!is_null($fila->fh_insert)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert);
                $excel->creado_fh = $fecha->format('Y-m-d H:i:s');
                $excel->creado_fecha = $fecha->format('Y-m-d');
                $excel->creado_mes = $fecha->format('Y-m');
            }


            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_usaurio: ".$e->getMessage());
            }

        }
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;

        Log::info("ETL de exel_usuarios: fin del proceso, $total_filas filas generadas ($total_errores errores reportados). Tiempo: $respuesta->duracion.");
        return $respuesta;

    }


}
