<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_adjunto_justificacion
 * @property int $id_adjunto
 * @property int $insert_id_entrevistador
 * @property int $id_justificacion
 * @property string $insert_fh
 * @property Esclarecimiento.adjunto $esclarecimiento.adjunto
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class adjunto_justificacion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.adjunto_justificacion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_adjunto_justificacion';

    /**
     * @var array
     */
    protected $fillable = ['id_adjunto', 'insert_id_entrevistador', 'id_justificacion', 'insert_fh'];

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

    public function rel_id_adjunto() {
        return $this->belongsTo(adjunto::class,'id_adjunto','id_adjunto');
    }
    public function getFmtIdJustificacionAttribute() {
        $calificacion[2]=126;
        $calificacion[3]=127;
        $calificacion[4]=128;
        $adjunto = $this->rel_id_adjunto;
        if($adjunto) {
            if(isset($calificacion[$adjunto->id_calificacion])) {
                return criterio_fijo::describir($calificacion[$adjunto->id_calificacion],$this->id_justificacion);
            }
            else {
                return "Justificacion ($this->id_justificacion) no coincide con la calificacion($adjunto->id_calificacion)";
            }
        }
        else {
            return "Adjunto ($id_adjunto) no existe";
        }

    }
}
