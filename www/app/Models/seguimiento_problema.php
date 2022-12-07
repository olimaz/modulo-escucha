<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_seguimiento_problema
 * @property int $id_seguimiento
 * @property int $id_tipo_problema
 * @property string $descripcion
 * @property Seguimiento $seguimiento
 * @property Catalogos.catItem $catalogos.catItem
 */
class seguimiento_problema extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'seguimiento_problema';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_seguimiento_problema';

    /**
     * @var array
     */
    protected $fillable = ['id_seguimiento', 'id_tipo_problema', 'descripcion'];

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
    public function rel_id_seguimiento()
    {
        return $this->belongsTo(seguimiento::class, 'id_seguimiento', 'id_seguimiento');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_tipo_problema()
    {
        return $this->belongsTo(cat_item::class, 'id_tipo_problema', 'id_item');
    }

    public function getFmtIdTipoProblemaAttribute() {
        return cat_item::describir($this->id_tipo_problema);
    }

    public function getFmtIdResolvibleAttribute() {
        return criterio_fijo::describir(12,$this->id_resolvible);
    }
}
