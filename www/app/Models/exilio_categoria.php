<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_exilio_categoria
 * @property int $id_exilio
 * @property int $id_categoria
 * @property string $created_at
 * @property Catalogos.catItem $catalogos.catItem
 * @property Fichas.exilio $fichas.exilio
 */
class exilio_categoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.exilio_categoria';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_categoria';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio', 'id_categoria', 'created_at'];

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
    public function rel_id_categoria() {
        return $this->belongsTo(cat_item::class,'id_categoria','id_item');
    }
    public function getFmtIdCategoriaAttribute() {
        return cat_item::describir($this->id_categoria);
    }
}
