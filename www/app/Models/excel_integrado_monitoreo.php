<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $estado_actual
 * @property int $personas_entrevistadas
 * @property string $tipo_entrevista
 * @property string $codigo_entrevista
 * @property int $es_virtual
 * @property string $avance_actual
 * @property int $clasificacion
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $codigo_entrevistador
 * @property string $grupo_entrevistador
 * @property string $entrevista_fecha
 * @property string $entrevista_mes
 * @property int $tiempo_entrevista
 * @property string $entrevista_lugar_n1
 * @property string $entrevista_lugar_n2
 * @property string $entrevista_lugar_n3
 * @property string $hechos_anio_del
 * @property string $hechos_anio_al
 * @property string $sector_entrevistado
 * @property string $titulo
 * @property int $transcrita
 * @property string $transcrita_fecha
 * @property string $transcrita_fecha_a
 * @property string $transcrita_fecha_m
 * @property int $etiquetada
 * @property string $etiquetada_fecha
 * @property string $etiquetada_fecha_a
 * @property string $etiquetada_fecha_m
 * @property int $a_consentimiento
 * @property int $a_audio
 * @property int $a_ficha_corta
 * @property int $a_ficha_larga
 * @property int $a_otros
 * @property int $a_transcripcion_preliminar
 * @property int $a_transcripcion_final
 * @property int $a_etiquetado
 * @property int $a_retroalimentacion
 * @property int $a_relatoria
 * @property int $a_certificacion_inicial
 * @property int $a_certificacion_final
 * @property int $a_plan_trabajo
 * @property int $a_valoracion
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property string $fecha_carga
 * @property string $mes_carga
 * @property string $fecha_ultima_actualizacion
 * @property string $mes_ultima_actualizacion
 * @property int $interes_exilio
 * @property int $id_entrevistador
 */
class excel_integrado_monitoreo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_integrado_monitoreo';

    /**
     * @var array
     */
    protected $fillable = ['estado_actual', 'personas_entrevistadas', 'tipo_entrevista', 'codigo_entrevista', 'es_virtual', 'situacion_actual', 'clasificacion', 'macroterritorio', 'territorio', 'codigo_entrevistador', 'grupo_entrevistador', 'entrevista_fecha', 'entrevista_mes', 'tiempo_entrevista', 'entrevista_lugar_n1', 'entrevista_lugar_n2', 'entrevista_lugar_n3', 'hechos_anio_del', 'hechos_anio_al', 'sector_entrevistado', 'titulo', 'transcrita', 'transcrita_fecha', 'transcrita_fecha_a', 'transcrita_fecha_m', 'etiquetada', 'etiquetada_fecha', 'etiquetada_fecha_a', 'etiquetada_fecha_m', 'a_consentimiento', 'a_audio', 'a_ficha_corta', 'a_ficha_larga', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_etiquetado', 'a_retroalimentacion', 'a_relatoria', 'a_certificacion_inicial', 'a_certificacion_final', 'a_plan_trabajo', 'a_valoracion', 'entrevista_lat', 'entrevista_lon', 'fecha_carga', 'mes_carga', 'fecha_ultima_actualizacion', 'mes_ultima_actualizacion', 'interes_exilio', 'id_entrevistador'];

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
        Log::notice("ETL de integrado de entrevistas (monitoreo): inicio del proceso");

        excel_integrado_monitoreo::truncate();
        $total_filas=0;
        $total_errores=0;
        // 1. Entrevista individual  (VI, AA, TC)
        $total_fvt = self::cargar_individuales();
        $total_filas+=$total_fvt['si'];
        $total_errores+=$total_fvt['no'];


        // 2. Colectivas
        $total_co = self::cargar_colectivas();
        $total_filas+=$total_co['si'];
        $total_errores+=$total_co['no'];

        // 3. Entrevistas Etnicas
        $total_ee = self::cargar_etnicas();
        $total_filas+=$total_ee['si'];
        $total_errores+=$total_ee['no'];

        // 4. Entrevistas a profunidad
        $total_pr = self::cargar_profundidad();
        $total_filas+=$total_pr['si'];
        $total_errores+=$total_pr['no'];

        // 5. Diagnóstico comunitario
        $total_dc = self::cargar_dc();
        $total_filas+=$total_dc['si'];
        $total_errores+=$total_dc['no'];

        // 6. Historia de Vida
        $total_hv = self::cargar_hv();
        $total_filas+=$total_hv['si'];
        $total_errores+=$total_hv['no'];



        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->vi = $total_fvt;
        $respuesta->co = $total_co;
        $respuesta->ee = $total_ee;
        $respuesta->pr = $total_pr;
        $respuesta->dc = $total_dc;
        $respuesta->hv = $total_hv;
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;






        //Segundo grupo: Sujetos colectivos

        Log::info("ETL de integrado de entrevistas (monitoreo): fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");

        if($total_errores>0) {
            Log::error("ETL de integrado de entrevistas (monitoreo) finalizada con  $total_errores errores");
        }

        return $respuesta;

    }

    // Individuales: VI, AA, TC
    public static function cargar_individuales() {
        $total_filas=0;
        $total_errores=0;
        $listado = entrevista_individual::orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_integrado_monitoreo();
            self::campos_comunes($excel,$fila); //
            $excel->hechos_anio_del = substr($fila->hechos_del,0,4);
            $excel->hechos_anio_al = substr($fila->hechos_al,0,4);

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_integrado_monitoreo VI: ".$e->getMessage());
            }

        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;
    }

    // Colectivas: CO
    public static function cargar_colectivas() {
        $total_filas=0;
        $total_errores=0;
        $listado = entrevista_colectiva::orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_integrado_monitoreo();
            self::campos_comunes($excel,$fila); //
            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_integrado_monitoreo CO: ".$e->getMessage());
            }

        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;


    }

    //Sujetos colectivos: EE
    public static function cargar_etnicas() {
        $total_filas=0;
        $total_errores=0;
        $listado = entrevista_etnica::orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_integrado_monitoreo();
            self::campos_comunes($excel,$fila); //
            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_integrado_monitoreo EE: ".$e->getMessage());
            }

        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;
    }

    // Profunidad: PR
    public static function cargar_profundidad() {
        $total_filas=0;
        $total_errores=0;
        $listado = entrevista_profundidad::orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_integrado_monitoreo();
            self::campos_comunes($excel,$fila); //
            $excel->hechos_anio_del = 'PR: No Aplica';
            $excel->hechos_anio_al = 'PR: No Aplica';


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_integrado_monitoreo PR: ".$e->getMessage());
            }

        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;
    }

    // Diagnosticos Comunitarios
    public static function cargar_dc() {
        $total_filas=0;
        $total_errores=0;
        $listado = diagnostico_comunitario::orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_integrado_monitoreo();
            self::campos_comunes($excel,$fila); //
            $excel->hechos_anio_del = substr($fila->tema_del,0,4);
            $excel->hechos_anio_al = substr($fila->tema_del,0,4);


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_integrado_monitoreo DC: ".$e->getMessage());
            }

        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;

    }

    // Historia de vida
    public static function cargar_hv() {
        $total_filas=0;
        $total_errores=0;
        $listado = historia_vida::orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_integrado_monitoreo();
            self::campos_comunes($excel,$fila); //
            $excel->hechos_anio_del = "HV: No Aplica";
            $excel->hechos_anio_al =  "HV: No Aplica";


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_integrado_monitoreo HV: ".$e->getMessage());
            }

        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;


    }

    public static function scopePermitidos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('id_entrevistador',$arreglo_entrevistadores);
    }



    //Utiliza el objeto excel y recibe la fila para procesar todos los campos que se llaman igual y se comportan igual
    public static function campos_comunes($excel, $fila) {
        $excel->estado_actual = $fila->id_activo==1 ? "Vigente" : "Anulada";
        if(isset($fila->cantidad_participantes)) {
            $excel->personas_entrevistadas=$fila->cantidad_participantes;
        }
        else {
            $excel->personas_entrevistadas=1;
        }
        if(isset($fila->entrevista_avance)) {
            $excel->avance_actual = cat_item::describir($fila->entrevista_avance);
        }
        $excel->tipo_entrevista = substr($fila->entrevista_codigo,strpos($fila->entrevista_codigo,'-')+1,2);
        $excel->codigo_entrevista = $fila->entrevista_codigo;
        $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
        $excel->clasificacion = $fila->clasifica_nivel;
        $excel->macroterritorio = $fila->fmt_id_macroterritorio;
        $excel->territorio= $fila->fmt_id_territorio;
        $quien=$fila->rel_id_entrevistador;
        $excel->codigo_entrevistador = $quien->numero_entrevistador;
        $excel->grupo_entrevistador = $quien->fmt_grupo;
        $excel->entrevista_fecha = $fila->fmt_entrevista_fecha;
        $excel->entrevista_mes = substr($fila->entrevista_fecha,0,7);
        $excel->tiempo_entrevista = $fila->tiempo_entrevista;
        $id_lugar = $fila->entrevista_lugar;
        while($geo = geo::find($id_lugar)) {
            $nivel = $geo->nivel;
            $campo = "entrevista_lugar_n".$nivel;
            $excel->$campo = $geo->descripcion;
            if($nivel==3) {
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;
            }
            $id_lugar=$geo->id_padre;
        }

        $excel->sector_entrevistado = $fila->fmt_id_sector;
        $excel->titulo = $fila->titulo;
        //Transcripcion
        $excel->transcrita = strlen($fila->html_transcripcion) > 0 ? 1 : 0;
        $transcripcion = transcribir_asignacion::tiene_transcripcion($fila);
        if($transcripcion) {
            $excel->transcrita_fecha = substr($transcripcion->fh_transcrito,0,10);
            $excel->transcrita_fecha_a = substr($transcripcion->fh_transcrito,0,4);
            $excel->transcrita_fecha_m = substr($transcripcion->fh_transcrito,0,7);
        }
        //Etiquetado
        $excel->etiquetada = strlen($fila->json_etiquetado) > 0 ? 1 : 0;
        $etiquetado = etiquetar_asignacion::tiene_etiquetado($fila);
        if($etiquetado) {
            $excel->etiquetada_fecha = substr($etiquetado->fh_transcrito,0,10);
            $excel->etiquetada_fecha_a = substr($etiquetado->fh_transcrito,0,4);
            $excel->etiquetada_fecha_m = substr($etiquetado->fh_transcrito,0,7);
        }
        $excel->id_entrevistador = $fila->id_entrevistador;

        if(isset($fila->fh_insert)) {
            if(!is_null($fila->fh_insert)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m");
            }
            if(!is_null($fila->fh_update)) {
                $excel->fecha_ultima_actualizacion = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_update);
                $excel->mes_ultima_actualizacion = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_update)->format("Y-m");
            }
        }
        else {
            if(!is_null($fila->created_at)) {
                $excel->fecha_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->mes_carga = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m");
            }
            if(!is_null($fila->updated_at)) {
                $excel->fecha_ultima_actualizacion = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at);
                $excel->mes_ultima_actualizacion = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at)->format("Y-m");
            }
        }
    }

}
