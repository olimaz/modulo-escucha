<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hecho_violencia_mecanismo
 * @property int $id_hecho_violencia
 * @property int $id_mecanismo
 * @property string $created_at
 * @property string $updated_at
 * @property Fichas.hechoViolencium $fichas.hechoViolencium
 * @property Catalogos.catItem $catalogos.catItem
 */
class hecho_violencia_mecanismo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.hecho_violencia_mecanismo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho_violencia_mecanismo';

    /**
     * @var array
     */
    protected $fillable = ['id_hecho_violencia', 'id_mecanismo', 'created_at', 'updated_at'];

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
     * @return hecho_violencia
     */
    public function rel_id_hecho_violencia() {
        return $this->belongsTo(hecho_violencia::class,'id_hecho_violencia','id_hecho_violencia');
    }

    /**
     * @return cat_item
     */
    public function rel_id_mecanismo()
    {
        return $this->belongsTo(cat_item::class, 'id_mecanismo', 'id_item');
    }
}
