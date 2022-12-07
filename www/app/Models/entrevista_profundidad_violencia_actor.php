<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id_entrevista_profundidad_violencia_actor
 * @property int $id_entrevista_profundidad
 * @property int $id_violencia
 * @property Esclarecimiento.entrevistaProfundidad $esclarecimiento.entrevistaProfundidad
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_profundidad_violencia_actor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_profundidad_violencia_actor';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_profundidad_violencia_actor';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_profundidad', 'id_violencia'];

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
    public function rel_id_entrevista_profundidad()
    {
        return $this->belongsTo(entrevista_profundidad::class, 'id_entrevista_profundidad', 'id_entrevista_profundidad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_violencia()
    {
        return $this->belongsTo(cat_item::class, 'id_violencia', 'id_item');
    }
    public function getFmtIdViolenciaAttribute() {
        return cat_item::describir($this->id_violencia);
    }
}
