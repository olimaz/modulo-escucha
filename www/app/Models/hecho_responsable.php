<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hecho_victima
 * @property int $id_hecho
 * @property int $id_persona_responsable
 * @property Fichas.hecho $fichas.hecho
 * @property Fichas.personaResponsable $fichas.personaResponsable
 */
class hecho_responsable extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.hecho_responsable';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho_responsable';

    /**
     * @var array
     */
    protected $fillable = ['id_hecho', 'id_persona_responsable'];

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
    public function rel_id_hecho()
    {
        return $this->belongsTo(hecho::class, 'id_hecho', 'id_hecho');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_persona_responsable()
    {
        return $this->belongsTo(persona_responsable::class, 'id_persona_responsable', 'id_persona_responsable');
    }

    public function getIdEntrevistaAttribute() {

        if($this->rel_id_persona_responsable->id_entrevista_etnica != null) {
            return $this->rel_id_persona_responsable->id_entrevista_etnica;
        }

        return $this->rel_id_persona_responsable->id_e_ind_fvt;
    }
}
