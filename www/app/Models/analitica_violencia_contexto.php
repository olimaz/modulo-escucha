<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_hecho
 * @property int $grupo
 * @property int $contexto
 */
class analitica_violencia_contexto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.violencia_contexto';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_hecho', 'grupo', 'contexto'];

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
        Log::notice("ETL de analitica-violencia_contexto: inicio del proceso");
        //Inicializar la tabla
        analitica_violencia_contexto::truncate();

        //Listado: no borrados (id_activo=1) que tengan ficha de persona entrevistada
        $query = hecho_contexto::join('fichas.hecho','hecho_contexto.id_hecho','=','hecho.id_hecho')
            ->join('esclarecimiento.e_ind_fvt','hecho.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','hecho_contexto.id_contexto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->orderby('hecho_contexto.id_hecho')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw('distinct hecho_contexto.*, cat_item.descripcion as contexto, cat_item.id_reclasificado, cat_cat.nombre as grupo'));

        $listado = $query->get();

        //dd($query->toSql());
        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_violencia_contexto();
            $excel->id_hecho = $fila->id_hecho;
            $excel->grupo = $fila->grupo;
            $excel->contexto = $fila->contexto;
            $excel->recategorizado = cat_item::describir_reclasificado($fila->id_contexto);

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-violencia_contexto: ".PHP_EOL.$e->getMessage());
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

        Log::info("ETL de analitica-violencia_contexto: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-violencia_contexto finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

    //Version binarizada
    public static function generar_plana_binarizada() {
        $inicio = Carbon::now();
        $log[]=array();
        $problema=array();
        //Registrar el evento
        Log::notice("ETL de analitica-violencia_contexto binarizada: inicio del proceso");
        //Inicializar la tabla
        analitica_contexto_binarizado::truncate();

        //Listado: no borrados (id_activo=1)
        $query = hecho_contexto::join('fichas.hecho','hecho_contexto.id_hecho','=','hecho.id_hecho')
            ->join('esclarecimiento.e_ind_fvt','hecho.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','hecho_contexto.id_contexto','=','cat_item.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            //->orderby('e_ind_fvt.id_e_ind_fvt')
            ->orderby('hecho_contexto.id_hecho')
            ->orderby('cat_item.id_cat')
            ->orderby('cat_item.otro')
            ->select(\DB::raw('distinct e_ind_fvt.id_e_ind_fvt, e_ind_fvt.entrevista_codigo, hecho_contexto.*, cat_item.otro as contexto, cat_item.id_cat'));


        $listado = $query->get();


        //dd($query->toSql());
        $total_filas=0;
        $total_errores=0;
        $id_hecho=0; //Para identificar salto de hecho

        $log[]= "Inicio.  id_hecho: $id_hecho";
        foreach($listado as $fila) {
            if($id_hecho==0) {  //Primera fila
                $id_hecho=$fila->id_hecho;
                $log[]="Primera fila. id_hecho:$id_hecho";
                $nuevo = new analitica_contexto_binarizado();
                $nuevo->id_hecho = $fila->id_hecho;
                $nuevo->codigo_entrevista = $fila->entrevista_codigo;
            }

            if($id_hecho <> $fila->id_hecho) {
                try {
                    $log[]="Grabar nueva fila.  id_hecho:$id_hecho";
                    $nuevo->save();
                    $total_filas++;
                    //Crear nuevo registro
                    $id_hecho=$fila->id_hecho;
                    $nuevo = new analitica_contexto_binarizado();
                    $nuevo->id_hecho = $fila->id_hecho;
                    $nuevo->codigo_entrevista = $fila->entrevista_codigo;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de analitica-violencia_contexto binarizado:  ".PHP_EOL.$e->getMessage());
                }
            }

            $campo = $fila->contexto;  //Asignar valor 1 al campo
            if(strlen($campo)>0) {
                $nuevo->$campo=1;
            }
            else {
                if(isset($problema[$fila->id_contexto])) {
                    $problema[$fila->id_contexto]++;
                }
                else {
                    $problema[$fila->id_contexto]=1;
                }
            }

        }
        //Grabar el último registro
        try {
            $log[]= "Ultimo registro.  id_hecho:$id_hecho";
            $nuevo->save();
            $total_filas++;
        }
        catch(\Exception $e) {
            $total_errores++;
            Log::debug("Error en generar registro de analitica-violencia_contexto binarizado:  ".PHP_EOL.$e->getMessage());
        }

        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;
        //$respuesta->log = $log;

        Log::info("ETL de analitica-violencia_contexto binarizado: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if(count($problema)>0) {
            Log::warning("id_contexto no considerado en binarización. ".PHP_EOL.http_build_query($problema));
            $respuesta->advertencias = count($problema);
        }
        if($total_errores>0) {
            Log::error("ETL de analitica-violencia_contexto binarizado finalizada con  $total_errores errores");
        }

        return $respuesta;

    }



}
