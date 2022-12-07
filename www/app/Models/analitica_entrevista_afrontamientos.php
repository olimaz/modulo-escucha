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
 * @property string $afrontamiento
 * @property string $recategorizado
 */
class analitica_entrevista_afrontamientos extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_afrontamientos';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'grupo', 'seccion', 'afrontamiento','recategorizado'];

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
        Log::notice("ETL de analitica-entrevista_afrontamientos: inicio del proceso");
        //Inicializar la tabla
        analitica_entrevista_afrontamientos::truncate();
        $total_filas=0;
        $total_errores=0;

        //Afrontamientos individuales
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[144])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Afrontamiento individual' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_afrontamientos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->afrontamiento = $fila->impacto;
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
                Log::debug("Error en generar registro de analitica-entrevista_afrontamientos: ".PHP_EOL.$e->getMessage());
            }
        }

        // Afontamiento familiar
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[145])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Afrontamiento familiar' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_afrontamientos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->afrontamiento = $fila->impacto;
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
                Log::debug("Error en generar registro de analitica-entrevista_afrontamientos: ".PHP_EOL.$e->getMessage());
            }
        }


        // Afrontamiento colectivo
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->leftJoin('catalogos.cat_item as recategorizado','cat_item.id_reclasificado','recategorizado.id_item')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherein('cat_cat.id_cat',[146,147,148])
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('cat_cat.nombre')
            ->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, cat_item.id_reclasificado, recategorizado.descripcion as recategorizado, cat_item.descripcion as impacto, cat_cat.nombre as seccion, 'Afrontamiento colectivo' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_afrontamientos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->afrontamiento = $fila->impacto;
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
                Log::debug("Error en generar registro de analitica-entrevista_afrontamientos: ".PHP_EOL.$e->getMessage());
            }
        }
        // Procesos colectivos/iniciativa
        $query = entrevista_impacto::join('esclarecimiento.e_ind_fvt','entrevista_impacto.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
            //->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            //->join('catalogos.cat_cat','cat_item.id_cat','cat_cat.id_cat')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->wherenotnull('entrevista_impacto.afrentamiento_proceso')
            ->orderby('entrevista_impacto.id_e_ind_fvt')
            ->orderby('entrevista_impacto.afrentamiento_proceso')
            //->orderby('cat_item.descripcion')
            ->select(\DB::raw("distinct entrevista_impacto.*, 'Afrontamiento colectivo - participación' as seccion, 'Afrontamiento colectivo' as grupo "));
        $listado = $query->get();
        foreach($listado as $fila) {
            //Crear registro
            $excel = new analitica_entrevista_afrontamientos();
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->grupo = $fila->grupo;
            $excel->seccion = $fila->seccion;
            $excel->afrontamiento = $fila->afrentamiento_proceso;

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-entrevista_afrontamientos: ".PHP_EOL.$e->getMessage());
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

        Log::info("ETL de analitica-entrevista_afrontamientos: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-entrevista_afrontamientos finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

}
