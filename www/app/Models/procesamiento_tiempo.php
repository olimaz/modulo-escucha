<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_procesamiento_tiempo
 * @property int $id_entrevista
 * @property int $id_subserie
 * @property int $id_tipo_medicion
 * @property int $tiempo_minutos
 */
class procesamiento_tiempo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'procesamiento_tiempo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_procesamiento_tiempo';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_subserie', 'id_tipo_medicion', 'tiempo_minutos'];

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


    public static function procesar_request($request, $llave_foranea) {
        $info['id_entrevista']=$llave_foranea->id_entrevista;
        $info['id_subserie']=$llave_foranea->id_subserie;
        $respuesta = array();
        $request->duracion_transcripcion_minutos = str_replace(".","",$request->duracion_transcripcion_minutos);
        $request->duracion_transcripcion_minutos = str_replace(",","",$request->duracion_transcripcion_minutos);
        $request->duracion_transcripcion_minutos = (integer)$request->duracion_transcripcion_minutos;
        //
        $request->duracion_etiquetado_minutos = str_replace(".","",$request->duracion_etiquetado_minutos);
        $request->duracion_etiquetado_minutos = str_replace(",","",$request->duracion_etiquetado_minutos);
        $request->duracion_etiquetado_minutos = (integer)$request->duracion_etiquetado_minutos;
        //
        $request->duracion_fichas_minutos = str_replace(".","",$request->duracion_fichas_minutos);
        $request->duracion_fichas_minutos = str_replace(",","",$request->duracion_fichas_minutos);
        $request->duracion_fichas_minutos = (integer)$request->duracion_fichas_minutos;

        if($request->duracion_transcripcion_minutos > 0) {
            $info['id_tipo_medicion'] = 1;
            $tiempo = procesamiento_tiempo::FirstOrNew($info);
            $tiempo->tiempo_minutos = $request->duracion_transcripcion_minutos;
            $tiempo->id_transcribir_asignacion = $llave_foranea->id_transcribir_asignacion;
            $tiempo->id_etiquetar_asignacion = $llave_foranea->id_etiquetar_asignacion;
            $tiempo->save();
            $respuesta[] = $tiempo;
        }
        if($request->duracion_etiquetado_minutos > 0) {
            $info['id_tipo_medicion'] = 2;
            $tiempo = procesamiento_tiempo::FirstOrNew($info);
            $tiempo->tiempo_minutos = $request->duracion_etiquetado_minutos;
            $tiempo->id_transcribir_asignacion = $llave_foranea->id_transcribir_asignacion;
            $tiempo->id_etiquetar_asignacion = $llave_foranea->id_etiquetar_asignacion;
            $tiempo->save();
            $respuesta[] = $tiempo;
        }
        if($request->duracion_fichas_minutos > 0) {
            $info['id_tipo_medicion'] = 3;
            $tiempo = procesamiento_tiempo::FirstOrNew($info);
            $tiempo->tiempo_minutos = $request->duracion_fichas_minutos;
            $tiempo->id_transcribir_asignacion = $llave_foranea->id_transcribir_asignacion;
            $tiempo->id_etiquetar_asignacion = $llave_foranea->id_etiquetar_asignacion;
            $tiempo->save();
            $respuesta[] = $tiempo;
        }
        return $respuesta;
    }

}
