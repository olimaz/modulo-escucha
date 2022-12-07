<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_colectiva_dinamica
 * @property int $id_entrevista_colectiva
 * @property int $id_dinamica
 * @property string $dinamica
 * @property Esclarecimiento.entrevistaColectiva $esclarecimiento.entrevistaColectiva
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_colectiva_dinamica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_colectiva_dinamica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_colectiva_dinamica';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_colectiva', 'id_dinamica', 'dinamica'];

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
    public function rel_id_entrevista_colectiva() {
        return $this->belongsTo(entrevista_colectiva::class,'id_entrevista_colectiva','id_entrevista_colectiva');
    }
    public function rel_id_dinamica() {
        return $this->belongsTo(cat_item::class,'id_dinamica','id_item');
    }
}
