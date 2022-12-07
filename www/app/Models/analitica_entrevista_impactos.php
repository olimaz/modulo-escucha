<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property int $id_entrevista
 * @property string $grupo
 * @property string $seccion
 * @property string $impacto
 * @property string $recategorizado
 */
class analitica_entrevista_impactos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_impactos';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'grupo', 'seccion', 'impacto','recategorizado'];

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
        Log::notice("ETL de analitica-entrevista_impactos: inicio del proceso");
        //Inicializar la tabla
        analitica_entrevista_impactos::truncate();
        $total_filas=0;
        $total_errores=0;

        //Impactos individuales
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[132,133,134])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Impactos individuales' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_impactos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->impacto = $fila->impacto;

            if($fila->id_reclasificado==-1) {
                $excel->recategorizado = "(Opción inválida: ignorar)";
            }
            elseif(is_null($fila->id_reclasificado)) {
                $excel->recategorizado = "(Pendiente reclasificar)";
            }
            else {
                $excel->recategorizado = $fila->recategorizado;
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_impactos: ".PHP_EOL.$e->getMessage());
            }
        }

        // Impactos relacionales
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[135,136])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Impactos relacionales' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_impactos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->impacto = $fila->impacto;
            if($fila->id_reclasificado==-1) {
                $excel->recategorizado = "(Opción inválida: ignorar)";
            }
            elseif(is_null($fila->id_reclasificado)) {
                $excel->recategorizado = "(Pendiente reclasificar)";
            }
            else {
                $excel->recategorizado = $fila->recategorizado;
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_impactos: ".PHP_EOL.$e->getMessage());
            }
        }

        // Impactos transgeneracionales
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            //->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            //->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherenotnull('entrevista_impacto.transgeneracionales')
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('entrevista_impacto.transgeneracionales')
            //->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, 'Impactos transgeneracionales' as seccion, 'Impactos relacionales' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_impactos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->impacto = $fila->transgeneracionales;
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_impactos: ".PHP_EOL.$e->getMessage());
            }
        }

        // Revictimizacion
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[137])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Revictimización' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_impactos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->impacto = $fila->impacto;
            if($fila->id_reclasificado==-1) {
                $excel->recategorizado = "(Opción inválida: ignorar)";
            }
            elseif(is_null($fila->id_reclasificado)) {
                $excel->recategorizado = "(Pendiente reclasificar)";
            }
            else {
                $excel->recategorizado = $fila->recategorizado;
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_impactos: ".PHP_EOL.$e->getMessage());
            }
        }
        // Impactos colectivos
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->wherein('cat_cat.id_cat',[138,139,140,141,142,143])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Impactos colectivos' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_impactos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->impacto = $fila->impacto;
            if($fila->id_reclasificado==-1) {
                $excel->recategorizado = "(Opción inválida: ignorar)";
            }
            elseif(is_null($fila->id_reclasificado)) {
                $excel->recategorizado = "(Pendiente reclasificar)";
            }
            else {
                $excel->recategorizado = $fila->recategorizado;
            }
            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_impactos: ".PHP_EOL.$e->getMessage());
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

        Log::info("ETL de analitica-entrevista_impactos: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-entrevista_impactos finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

}
