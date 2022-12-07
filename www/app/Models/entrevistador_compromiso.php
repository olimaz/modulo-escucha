<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevistador_compromiso
 * @property int $id_entrevistador
 * @property string $fh_aceptacion
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class entrevistador_compromiso extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevistador_compromiso';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevistador_compromiso';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    protected $dates = ['fh_aceptacion'];

    /**
     * The storage format of the model's date columns.
     * 
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.ue';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }
}
