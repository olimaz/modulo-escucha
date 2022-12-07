<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_exilio_movimiento
 * @property int $id_exilio
 * @property int $id_entrevista
 * @property string $codigo_entrevista
 * @property string $macroterritorio_txt
 * @property string $territorio_txt
 * @property int $ha_retornado
 * @property int $pq_si_condiciones
 * @property int $pq_si_proteccion
 * @property int $pq_si_condiciones_economicas
 * @property int $pq_si_familiares
 * @property int $pq_si_nostalgia
 * @property int $pq_si_persecucion
 * @property int $pq_si_economicas
 * @property int $pq_si_laborales
 * @property int $pq_si_politicas
 * @property int $pq_si_pendular
 * @property int $pq_si_deportacion
 * @property int $pq_si_subvenciones
 * @property int $pq_no_proyecto_vida
 * @property int $pq_no_dificultades_economicas
 * @property int $pq_no_condiciones_politicas
 * @property int $pq_no_falta_garantias
 * @property int $pq_no_familia_fuera
 * @property int $pq_no_faimlia_muerta
 * @property int $pq_no_miedo
 * @property int $pq_no_ns_nr
 * @property int $pq_no_estudios
 * @property int $pq_no_hijos
 * @property int $pq_no_rechazo_colombia
 * @property string $salida_fecha
 * @property string $salida_anio
 * @property string $salida_mes
 * @property string $salida_lugar_codigo
 * @property string $salida_lugar_n1_codigo
 * @property string $salida_lugar_n1_txt
 * @property string $salida_lugar_n2_codigo
 * @property string $salida_lugar_n2_txt
 * @property string $salida_lugar_n3_codigo
 * @property string $salida_lugar_n3_txt
 * @property string $salida_lugar_especifico
 * @property string $salida_lugar_n3_lat
 * @property string $salida_lugar_n3_lon
 * @property string $llegada_fecha
 * @property string $llegada_anio
 * @property string $llegada_mes
 * @property string $llegada_lugar_codigo
 * @property string $llegada_lugar_n1_codigo
 * @property string $llegada_lugar_n1_txt
 * @property string $llegada_lugar_n2_codigo
 * @property string $llegada_lugar_n2_txt
 * @property string $llegada_lugar_n3_codigo
 * @property string $llegada_lugar_n3_txt
 * @property string $llegada_lugar_especifico
 * @property string $llegada_lugar_n3_lat
 * @property string $llegada_lugar_n3_lon
 * @property string $modalidad_retorno
 * @property int $cantidad_personas_salieron
 * @property int $cantidad_personas_nucleo_salieron
 * @property int $cantidad_personas_nucleo_quedaron
 * @property int $tuvo_ayuda
 * @property string $institucion_ayuda
 * @property int $ayuda_alimentaria
 * @property int $ayuda_proyectos
 * @property int $ayuda_educacion
 * @property int $ayuda_documentos
 * @property int $ayuda_vivienda
 * @property int $ayuda_exilio
 * @property int $ayuda_proteccion
 * @property int $otro_exilio
 * @property string $created_at
 * @property string $created_at_fecha
 * @property string $created_at_mes
 * @property string $updated_at
 * @property string $updated_at_fecha
 * @property string $updated_at_mes
 */
class analitica_exilio_retorno extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.exilio_retorno';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_movimiento';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_exilio', 'id_entrevista', 'codigo_entrevista', 'macroterritorio_txt', 'territorio_txt', 'ha_retornado', 'pq_si_condiciones', 'pq_si_proteccion', 'pq_si_condiciones_economicas', 'pq_si_familiares', 'pq_si_nostalgia', 'pq_si_persecucion', 'pq_si_economicas', 'pq_si_laborales', 'pq_si_politicas', 'pq_si_pendular', 'pq_si_deportacion', 'pq_si_subvenciones', 'pq_no_proyecto_vida', 'pq_no_dificultades_economicas', 'pq_no_condiciones_politicas', 'pq_no_falta_garantias', 'pq_no_familia_fuera', 'pq_no_faimlia_muerta', 'pq_no_miedo', 'pq_no_ns_nr', 'pq_no_estudios', 'pq_no_hijos', 'pq_no_rechazo_colombia', 'salida_fecha', 'salida_anio', 'salida_mes', 'salida_lugar_codigo', 'salida_lugar_n1_codigo', 'salida_lugar_n1_txt', 'salida_lugar_n2_codigo', 'salida_lugar_n2_txt', 'salida_lugar_n3_codigo', 'salida_lugar_n3_txt', 'salida_lugar_especifico', 'salida_lugar_n3_lat', 'salida_lugar_n3_lon', 'llegada_fecha', 'llegada_anio', 'llegada_mes', 'llegada_lugar_codigo', 'llegada_lugar_n1_codigo', 'llegada_lugar_n1_txt', 'llegada_lugar_n2_codigo', 'llegada_lugar_n2_txt', 'llegada_lugar_n3_codigo', 'llegada_lugar_n3_txt', 'llegada_lugar_especifico', 'llegada_lugar_n3_lat', 'llegada_lugar_n3_lon', 'modalidad_retorno', 'cantidad_personas_salieron', 'cantidad_personas_nucleo_salieron', 'cantidad_personas_nucleo_quedaron', 'tuvo_ayuda', 'institucion_ayuda', 'ayuda_alimentaria', 'ayuda_proyectos', 'ayuda_educacion', 'ayuda_documentos', 'ayuda_vivienda', 'ayuda_exilio', 'ayuda_proteccion', 'otro_exilio', 'created_at', 'created_at_fecha', 'created_at_mes', 'updated_at', 'updated_at_fecha', 'updated_at_mes'];

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
        Log::notice("ETL de analitica-exilio_retorno: inicio del proceso");
        //Inicializar la tabla
        analitica_exilio_retorno::truncate();

        $listado = exilio_movimiento::join('fichas.exilio','exilio_movimiento.id_exilio','=','exilio.id_exilio')
            ->join('esclarecimiento.e_ind_fvt','exilio.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->where('id_tipo_movimiento',3)
            ->where('exilio.id_ha_tenido_retorno',1)  //Que hayan retornado
            ->orderby('exilio.id_e_ind_fvt')
            ->orderby('exilio.id_exilio')
            ->orderby('exilio_movimiento.id_exilio_movimiento')
            ->selectraw(\DB::raw('exilio_movimiento.*'))
            ->get();

        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Buscar referencias
            $exilio = exilio::find($fila->id_exilio);
            $entrevista = entrevista_individual::find($exilio->id_e_ind_fvt);


            //Crear registro
            $excel = new analitica_exilio_retorno();
            $excel->id_exilio_movimiento = $fila->id_exilio_movimiento;
            $excel->id_exilio = $exilio->id_exilio;
            $excel->id_entrevista = $entrevista->id_e_ind_fvt;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->macroterritorio_txt = $entrevista->fmt_id_macroterritorio;
            $excel->territorio_txt = $entrevista->fmt_id_territorio;
            //$excel->ha_retornado = $exilio->id_retorno==1 ? 1 : 0;
            $excel->ha_retornado = $exilio->id_ha_tenido_retorno==1 ? 1 : 0;
            //pq_si, pq_no
            $detalle = $fila->rel_exilio_movimiento_motivo;
            foreach($detalle as $item) {
                $campo=$item->rel_id_motivo->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            $excel->salida_fecha = $fila->fecha_salida;
            $excel->salida_anio = substr($excel->salida_fecha,0,4);
            $excel->salida_mes = substr($excel->salida_fecha,0,7);
            $sufijo = self::calcular_campos_geo($fila->id_lugar_salida);
            foreach($sufijo as $var=>$val) {
                $campo = "salida_lugar_$var";
                $excel->$campo=$val;
            }
            $excel->salida_lugar_especifico = $fila->salida_ciudad;
            $excel->llegada_fecha = $fila->fecha_llegada;
            $excel->llegada_anio = substr($excel->llegada_fecha,0,4);
            $excel->llegada_mes = substr($excel->llegada_fecha,0,7);
            $sufijo = self::calcular_campos_geo($fila->id_lugar_llegada);
            foreach($sufijo as $var=>$val) {
                $campo = "llegada_lugar_$var";
                $excel->$campo=$val;
            }
            $excel->llegada_lugar_especifico = $fila->llegada_ciudad;


            $excel->modalidad_retorno = $fila->fmt_id_modalidad;
            $excel->cantidad_personas_salieron = $fila->cant_personas_salieron;
            $excel->cantidad_personas_nucleo_salieron = $fila->cant_personas_familia_salieron;
            $excel->cantidad_personas_nucleo_quedaron = $fila->cant_personas_familia_quedaron;
            //Proteccion
            $excel->tuvo_ayuda = $exilio->id_ha_tenido_ayuda==1 ? 1 : 0;
            $excel->institucion_ayuda = $exilio->institucion_ayuda ;
            //Ayuda recibida
            $arreglo = $exilio->arreglo_impacto(216);
            foreach($arreglo as $item) {
                $cat = cat_item::find($item);
                $campo = $cat->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //
            $excel->otro_exilio = $exilio->id_otro_exilio==1 ? 1 : 0;


            if(!is_null($fila->created_at)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
                $excel->created_at = $fecha->format('Y-m-d H:i:s');
                $excel->created_at_fecha = $fecha->format('Y-m-d');
                $excel->created_at_mes = $fecha->format('Y-m');
            }

            //Fecha de actualizacion
            if(!is_null($fila->update_fh)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->update_fh);
                $excel->updated_at = $fecha->format('Y-m-d H:i:s');
                $excel->updated_at_fecha = $fecha->format('Y-m-d');
                $excel->updated_at_mes = $fecha->format('Y-m');
            }


            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-exilio_retorno: ".$e->getMessage());
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

        Log::info("ETL de analitica-exilio_retorno: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-exilio_retorno finalizada con  $total_errores errores");
        }
        return $respuesta;

    }

    //Genera los campos requeridos:
    public static function calcular_campos_geo($id_geo=0) {
        $geo = geo::find($id_geo);
        $sufijo=array();
        if($geo) {
            $sufijo['codigo'] = $geo->codigo;

            $n=array();
            $n[1]['txt']=null;
            $n[1]['codigo']=null;
            $n[2]['txt']=null;
            $n[2]['codigo']=null;
            $n[3]['txt']=null;
            $n[3]['codigo']=null;
            $n[intval($geo->nivel)]['codigo']=$geo->codigo;
            $n[intval($geo->nivel)]['txt']=$geo->descripcion;
            if($geo->nivel==3) {
                $sufijo['n3_lat']=$geo->lat;
                $sufijo['n3_lon']=$geo->lon;
            }
            while($geo = geo::find($geo->id_padre)) {
                if($geo->nivel > 0 && $geo->nivel < 4) {
                    $n[intval($geo->nivel)]['codigo']=$geo->codigo;
                    $n[intval($geo->nivel)]["txt"]=$geo->descripcion;
                }
            }
            //dd($n);
            foreach($n as $id_nivel => $texto) {
                $campo = 'n'.$id_nivel;
                $codigo = $campo."_codigo";
                $txt    = $campo."_txt";
                $sufijo[$codigo]=$texto['codigo'];
                $sufijo[$txt]=$texto['txt'];
            }
        }
        return $sufijo;

    }

}
