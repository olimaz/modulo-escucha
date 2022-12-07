<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_entrevistador
 * @property int $id_retroalimentacion_etiquetado
 * @property string $fecha_hora
 * @property string $etiqueta
 * @property string $parrafo
 * @property string $comentarios
 * @property int $id_subserie
 * @property int $id_entrevista
 * @property string $codigo_entrevista
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class retroalimentacion_etiquetado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.retroalimentacion_etiquetado';
    protected $primaryKey = 'id_retroalimentacion_etiquetado';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador', 'id_retroalimentacion_etiquetado', 'fecha_hora', 'etiqueta', 'parrafo', 'comentarios', 'id_subserie', 'id_entrevista', 'codigo_entrevista'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_entrevistador() {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }

    //Getters
    public function getFmtIdEntrevistadorAttribute() {
        $quien = entrevistador::find($this->id_entrevistador);
        return $quien->fmt_nombre;
    }
    public function getFmtCorreoAttribute() {
        $quien = entrevistador::find($this->id_entrevistador);
        return $quien->rel_usuario->fmt_correo_e;
    }

    //Recibe el request y hace toda la magia
    public static function nuevo_reporte($request) {
        $etiqueta = etiqueta_entrevista::find($request->id_etiqueta_entrevista);
        if($etiqueta) {
            $nuevo = new retroalimentacion_etiquetado();
            $nuevo->id_entrevistador = optional(\Auth::user())->id_entrevistador;
            $nuevo->etiqueta = strip_tags($etiqueta->fmt_id_etiqueta);
            $nuevo->parrafo = $etiqueta->texto;
            $nuevo->comentarios = $request->comentarios;
            $nuevo->id_subserie = $etiqueta->id_subserie;
            $nuevo->id_entrevista = $etiqueta->id_entrevista;
            $nuevo->codigo_entrevista = $etiqueta->codigo;
            $nuevo->id_etiqueta_entrevista = $etiqueta->id_etiqueta_entrevista;
            $nuevo->save();
            $exito = $nuevo->notificar();
            return $exito;
        }
        else {
            return false;
        }
    }
    //Envía el correo
    public function notificar() {
        $to_email = config('expedientes.correo_reportes');
        $to_email_cc = config('expedientes.correo_reportes_cc');

        $info['nombre'] = $this->fmt_id_entrevistador;
        $info['codigo_entrevista']= $this->codigo_entrevista;
        $info['etiqueta']= $this->etiqueta;
        $info['parrafo'] = $this->parrafo;
        $info['comentarios'] = $this->comentarios;

        try {
            \Mail::send('mails.reporte_etiqueta', $info, function($message) use ($to_email, $to_email_cc) {
                $message->to($to_email)
                    ->subject("Reporte de etiqueta mal aplicada - $this->codigo_entrevista");
                if(strlen($to_email_cc )>0) {
                    $message->cc($to_email_cc);
                }
                $message->cc($this->fmt_correo);
                $message->from(config('expedientes.correo_reportes_from'),'SIM (etiquetado)');
            });
            Log::info("Mensaje enviado a $to_email cc: $to_email_cc cc:$this->>fmt_correo");
            return true;
        }
        catch (\Exception $e) {
            Log::info("Mensaje enviado a $to_email cc: $to_email_cc cc:$this->fmt_correo");
            Log::error("Problemas con el envío de correo ($this->id_retroalimentacion_etiquetado): ".PHP_EOL.$e->getMessage());
            return false;
        }

    }

}
