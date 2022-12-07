<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_tiempo_transcripcion
 * @property int $id_adjunto
 * @property string $duracion
 * @property string $fh_recibido
 * @property string $fh_inicio_work
 * @property string $fh_inicio_upload
 * @property string $fh_inicio_trans
 * @property string $fh_fin_trans
 * @property string $fh_save_word
 * @property string $fh_delete_cloud
 * @property string $fh_mongo
 * @property float $tiempo_cola
 * @property float $tiempo_carga
 * @property float $tiempo_trans
 * @property float $tiempo_procesamiento
 */
class tiempo_transcripcion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tiempo_transcripcion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_tiempo_transcripcion';

    /**
     * @var array
     */
    //protected $fillable = ['id_adjunto', 'duracion', 'fh_recibido', 'fh_inicio_work', 'fh_inicio_upload', 'fh_inicio_trans', 'fh_fin_trans', 'fh_save_word', 'fh_delete_cloud', 'fh_mongo', 'tiempo_cola', 'tiempo_carga', 'tiempo_trans', 'tiempo_procesamiento'];
    protected $guarded = ['id_tiempo_transcripcion'];

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


    //Recibe las fechas del servicio
    public static function registrar($respuesta) {
        //dd($respuesta);

            $r['id_adjunto']=$respuesta->id_adjunto;
            $r['duracion']=round($respuesta->json->duration);
            $r['tamano']=round($respuesta->json->size);
            /*

            $r['fh_recibido']=$respuesta->fechas_ts->queue->getTimeStamp();
            $r['fh_inicio_work']=$respuesta->fechas_ts->start->getTimeStamp();
            $r['fh_inicio_upload']=$respuesta->fechas_ts->upload->getTimeStamp();
            $r['fh_inicio_trans']=$respuesta->fechas_ts->initTrascription->getTimeStamp();
            $r['fh_fin_trans']=$respuesta->fechas_ts->endTrascription->getTimeStamp();
            $r['fh_save_word']=$respuesta->fechas_ts->saveText->getTimeStamp();
            $r['fh_delete_cloud']=$respuesta->fechas_ts->deleteCloudFile->getTimeStamp();
            $r['fh_mongo']=$respuesta->fechas_ts->saveMongo->getTimeStamp();
            */
            $r['fh_recibido']=$respuesta->fechas_ts->queue;
            $r['fh_inicio_work']=$respuesta->fechas_ts->start;
            $r['fh_inicio_upload']=$respuesta->fechas_ts->upload;
            $r['fh_inicio_trans']=$respuesta->fechas_ts->initTrascription;
            $r['fh_fin_trans']=$respuesta->fechas_ts->endTrascription;
            $r['fh_save_word']=$respuesta->fechas_ts->saveText;
            $r['fh_delete_cloud']=$respuesta->fechas_ts->deleteCloudFile;
            $r['fh_mongo']=$respuesta->fechas_ts->saveMongo;

            //tiempo que estuvo en cola
            $r['tiempo_cola'] = $respuesta->fechas_ts->queue->diffInMinutes($respuesta->fechas_ts->start);
            //tiempo que tardó en ser cargado
            $r['tiempo_carga']=$respuesta->fechas_ts->start->diffInMinutes($respuesta->fechas_ts->upload);
            //tiempo que estuvo en ser transcrito
            $r['tiempo_trans']=$respuesta->fechas_ts->initTrascription->diffInMinutes($respuesta->fechas_ts->endTrascription);
            //tiempo efectivo de procesamiento
            $r['tiempo_procesamiento']=$respuesta->fechas_ts->start->diffInMinutes($respuesta->fechas_ts->saveMongo);
            //Tiempo total, incluye espera en cola
            $r['tiempo_total']=$respuesta->fechas_ts->queue->diffInMinutes($respuesta->fechas_ts->saveMongo);
            $r['json']=json_encode($respuesta);
            $nuevo = new tiempo_transcripcion();
            $nuevo->fill($r);
            $nuevo->save();
            return $nuevo;
    }

    //Recibe la marca de tiempo con decimas de segundo y lo convierte a carbon
    public static function convertir_hora($hora) {
        return Carbon::createFromTimestamp($hora / 1000);

    }

}
