<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_mis_casos_detalle
 * @property int $id_mis_casos
 * @property int $id_detalle
 * @property string $insert_fh
 * @property Esclarecimiento.misCaso $esclarecimiento.misCaso
 * @property Catalogos.catItem $catalogos.catItem
 */
class mis_casos_detalle extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.mis_casos_detalle';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_mis_casos_detalle';

    /**
     * @var array
     */
    protected $fillable = ['id_mis_casos', 'id_detalle', 'insert_fh'];

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
    public function rel_id_mis_casos()
    {
        return $this->belongsTo(mis_casos::class, 'id_mis_casos', 'id_mis_casos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_detalle()
    {
        return $this->belongsTo(cat_item::class, 'id_detalle', 'id_item');
    }
    public function getFmtIdDetalleAttribute() {
        return cat_item::describir($this->id_detalle);
    }
}
