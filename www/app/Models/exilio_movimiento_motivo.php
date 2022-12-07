<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_exilio_movimiento_motivo
 * @property int $id_exilio_movimiento
 * @property int $id_motivo
 * @property string $created_at
 * @property Fichas.exilioMovimiento $fichas.exilioMovimiento
 * @property Catalogos.catItem $catalogos.catItem
 */
class exilio_movimiento_motivo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.exilio_movimiento_motivo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_movimiento_motivo';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio_movimiento', 'id_motivo', 'created_at'];

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
    public function rel_id_exilio_movimiento()
    {
        return $this->belongsTo(exilio_movimiento::class, 'id_exilio_movimiento', 'id_exilio_movimiento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_motivo()
    {
        return $this->belongsTo(cat_item::class, 'id_motivo', 'id_item');
    }

    public function getFmtIdMotivoAttribute() {
        return cat_item::describir($this->id_motivo);
    }
}
