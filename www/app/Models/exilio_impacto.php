<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_exilio_impacto
 * @property int $id_exilio
 * @property int $id_impacto
 * @property string $created_at
 * @property Fichas.exilio $fichas.exilio
 * @property Catalogos.catItem $catalogos.catItem
 */
class exilio_impacto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.exilio_impacto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_impacto';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio', 'id_impacto', 'created_at'];

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
    public function rel_id_exilio() {
        return $this->belongsTo(exilio::class,'id_exilio','id_exilio');
    }
    public function rel_id_impacto() {
        return $this->belongsTo(cat_item::class,'id_impacto','id_item');
    }
}
