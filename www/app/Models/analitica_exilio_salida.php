<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_exilio_movimiento
 * @property int $id_exilio
 * @property int $id_entrevista
 * @property int $codigo_entrevista
 * @property int $macroterritorio_id
 * @property int $macroterritorio_txt
 * @property int $territorio_id
 * @property int $territorio_txt
 * @property string $salida_fecha
 * @property string $salida_lugar_n1_codigo
 * @property string $salida_lugar_n1_txt
 * @property string $salida_lugar_n2_codigo
 * @property string $salida_lugar_n2_txt
 * @property string $salida_lugar_n3_codigo
 * @property string $salida_lugar_n3_txt
 * @property string $salida_lugar_n3_lat
 * @property string $salida_lugar_n3_lon
 * @property string $llegada_fecha
 * @property string $llegada_lugar_n1_codigo
 * @property string $llegada_lugar_n2_txt
 * @property string $llegada_lugar_n3_codigo
 * @property string $llegada_lugar_n3_txt
 * @property string $llegada_lugar_n3_lat
 * @property string $llegada_lugar_n3_lon
 * @property string $llegada_lugar_descripcion
 * @property string $asentamiento_fecha
 * @property string $asentamiento_lugar_n1_codigo
 * @property string $asentamiento_lugar_n1_txt
 * @property string $asentamiento_lugar_n2_codigo
 * @property string $asentamiento_lugar_n2_txt
 * @property string $asentamiento_lugar_n3_codigo
 * @property string $asentamiento_lugar_n3_txt
 * @property string $asentamiento_lugar_n3_lat
 * @property string $asentamiento_lugar_n3_lon
 * @property string $asentamiento_lugar_descripcion
 * @property int $modalidad_salida_id
 * @property string $modalidad_salida_txt
 * @property int $cantidad_personas_salieron
 * @property int $cantidad_personas_nucleo_salieron
 * @property int $cantidad_personas_nucleo_quedaron
 * @property int $proteccion_aprobada_id
 * @property string $proteccion_aprobada_txt
 * @property int $proteccion_denegada_id
 * @property string $proteccion_denegada_txt
 * @property int $ha_obtenido_residencia_id
 * @property string $ha_obtenido_residencia_txt
 * @property int $ha_sufrido_expulsion_id
 * @property string $ha_sufrido_expulsion_txt
 * @property int $cantidad_reasentamientos
 * @property int $tiene_datos_retorno
 * @property int $ha_retornado
 * @property int $otro_exilio
 * @property string created_at
 * @property string created_at_fecha
 * @property string created_at_mes
 * @property string udpated_at
 * @property string udpated_at_fecha
 * @property string udpated_at_mes
 *
 */
class analitica_exilio_salida extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.exilio_salida';

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
    protected $fillable = ['id_exilio', 'id_entrevista', 'codigo_entrevista', 'macroterritorio_id', 'macroterritorio_txt', 'territorio_id', 'territorio_txt', 'salida_fecha', 'salida_lugar_n1_codigo', 'salida_lugar_n1_txt', 'salida_lugar_n2_codigo', 'salida_lugar_n2_txt', 'salida_lugar_n3_codigo', 'salida_lugar_n3_txt', 'salida_lugar_lat', 'salida_lugar_lon', 'llegada_fecha', 'llegada_lugar_n1_codigo', 'llegada_lugar_n2_txt', 'llegada_lugar_n3_codigo', 'llegada_lugar_n3_txt', 'llegada_lugar_lat', 'llegada_lugar_lon', 'llegada_lugar_descripcion', 'asentamiento_fecha', 'asentamiento_lugar_n1_codigo', 'asentamiento_lugar_n1_txt', 'asentamiento_lugar_n2_codigo', 'asentamiento_lugar_n2_txt', 'asentamiento_lugar_n3_codigo', 'asentamiento_lugar_n3_txt', 'asentamiento_lugar_lat', 'asentamiento_lugar_lon', 'asentamiento_descripcion', 'modalidad_salida_id', 'modalidad_salida_txt', 'cantidad_personas_salieron', 'cantidad_personas_nucleo_salieron', 'cantidad_personas_nucleo_quedaron', 'proteccion_aprobada_id', 'proteccion_aprobada_txt', 'proteccion_denegada_id', 'proteccion_denegada_txt', 'ha_obtenido_residencia_id', 'ha_obtenido_residencia_txt', 'ha_sufrido_expulsion_id', 'ha_sufrido_expulsion_txt', 'cantidad_reasentamientos', 'tiene_retorno', 'ha_retornado'];

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
        Log::notice("ETL de analitica-exilio_salida: inicio del proceso");
        //Inicializar la tabla
        analitica_exilio_salida::truncate();

        $listado = exilio_movimiento::join('fichas.exilio','exilio_movimiento.id_exilio','=','exilio.id_exilio')
                            ->join('esclarecimiento.e_ind_fvt','exilio.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
                            ->where('e_ind_fvt.id_activo',1)
                            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
                            ->where('id_tipo_movimiento',1)
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
            $excel = new analitica_exilio_salida();
            $excel->id_exilio_movimiento = $fila->id_exilio_movimiento;
            $excel->id_exilio = $exilio->id_exilio;
            $excel->id_entrevista = $entrevista->id_e_ind_fvt;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->macroterritorio_id = $entrevista->id_macroterritorio;
            $excel->macroterritorio_txt = $entrevista->fmt_id_macroterritorio;
            $excel->territorio_id = $entrevista->id_territorio;
            $excel->territorio_txt = $entrevista->fmt_id_territorio;
            //Se reconoce como
            $detalle = $exilio->rel_exilio_categoria;
            foreach($detalle as $item) {
                $campo=$item->rel_id_categoria->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Motivos del exilio
            $detalle = $fila->rel_exilio_movimiento_motivo;
            foreach($detalle as $item) {
                $campo=$item->rel_id_motivo->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //
            $excel->salida_fecha = $fila->fecha_salida;
            $excel->salida_anio = substr($excel->salida_fecha,0,4);
            $excel->salida_mes = substr($excel->salida_fecha,0,7);
            $sufijo = self::calcular_campos_geo($fila->id_lugar_salida);
            foreach($sufijo as $var=>$val) {
                $campo = "salida_lugar_$var";
                $excel->$campo=$val;
            }
            $excel->llegada_fecha = $fila->fecha_llegada;
            $excel->llegada_anio = substr($excel->llegada_fecha,0,4);
            $excel->llegada_mes = substr($excel->llegada_fecha,0,7);
            $sufijo = self::calcular_campos_geo($fila->id_lugar_llegada);
            foreach($sufijo as $var=>$val) {
                $campo = "llegada_lugar_$var";
                $excel->$campo=$val;
            }
            $excel->llegada_lugar_descripcion = $fila->llegada_ciudad;
            $excel->asentamiento_especificado = $fila->id_lugar_llegada_2 > 0 ? 1 : 0;
            if($excel->asentamiento_especificado == 1 ) {
                $excel->asentamiento_fecha = $fila->fecha_asentamiento;
                $excel->asentamiento_anio = substr($excel->asentamiento_fecha,0,4);
                $excel->asentamiento_mes = substr($excel->asentamiento_fecha,0,7);
                $sufijo = analitica_exilio_salida::calcular_campos_geo($fila->id_lugar_llegada_2);
                foreach($sufijo as $var=>$val) {
                    $campo = "asentamiento_lugar_$var";
                    $excel->$campo=$val;
                }
                $excel->asentamiento_lugar_descripcion = $fila->llegada_2_ciudad;
            }

            $excel->modalidad_salida_id = $fila->id_modalidad;
            $excel->modalidad_salida_txt = $fila->fmt_id_modalidad;
            $excel->cantidad_personas_salieron = $fila->cant_personas_salieron;
            $excel->cantidad_personas_nucleo_salieron = $fila->cant_personas_familia_salieron;
            $excel->cantidad_personas_nucleo_quedaron = $fila->cant_personas_familia_quedaron;
            //Proteccion
            $detalle = $fila->rel_exilio_movimiento_proteccion;
            foreach($detalle as $item) {
                $campo=$item->rel_id_proteccion->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            $excel->proteccion_aprobada = $fila->fmt_id_aprobada_proteccion;
            $excel->proteccion_denegada = $fila->fmt_id_denegada_proteccion;
            $excel->ha_obtenido_residencia = $fila->fmt_id_residencia_proteccion;
            $excel->ha_sufrido_expulsion = $fila->fmt_id_expulsion;
            //
            $excel->cantidad_reasentamientos = $exilio->rel_exilio_movimiento()->where('id_tipo_movimiento',2)->count();
            $excel->tiene_datos_retorno = $exilio->rel_exilio_movimiento()->where('id_tipo_movimiento',1)->count() > 0 ? 1 : 0;
            //$excel->ha_retornado = $exilio->id_retorno==1 ? 1 : 0;
            $excel->ha_retornado = $exilio->id_ha_tenido_retorno==1 ? 1 : 0;
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
                Log::debug("Error en generar registro de analitica-exilio_salida: ".$e->getMessage());
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

        Log::info("ETL de analitica-exilio_salida: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-exilio_salida finalizada con  $total_errores errores");
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
