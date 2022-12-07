<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_etnica_rrom
 * @property int $id_entrevista_etnica
 * @property int $id_rrom
 * @property Esclarecimiento.entrevistaEtnica $esclarecimiento.entrevistaEtnica
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_etnica_rrom extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_etnica_rrom';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_etnica_rrom';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_etnica', 'id_rrom'];

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
    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }
    public function rel_id_rrom() {
        return $this->belongsTo(cat_item::class,'id_rrom','id_item');
    }
    public function getFmtIdRromAttribute() {
        return cat_item::describir($this->id_rrom);
    }
}
