<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hechos_fuerza
 * @property int $id_e_ind_fvt
 * @property int $id_hechos
 * @property int $id_fuerza
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 * @property Demo.hecho $demo.hecho
 * @property Catalogos.catItem $catalogos.catItem
 */
class hechos_fuerza extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'demo.hechos_fuerza';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hechos_fuerza';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_hechos', 'id_fuerza', 'id_usuario', 'created_at', 'updated_at'];

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
    public function rel_id_hechos() {
        return $this->belongsTo(hechos::class,'id_hechos','id_hechos');
    }
    public function rel_id_fuerza() {
        return $this->belongsTo(cat_item::class,'id_fuerza','id_item');
    }
    public function getFmtIdFuerzaAttribute() {
        return cat_item::describir($this->id_fuerza);
    }
}
