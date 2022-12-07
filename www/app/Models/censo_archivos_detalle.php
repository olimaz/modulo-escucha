<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_censo_archivos_detalle
 * @property int $id_censo_archivos
 * @property int $id_opcion
 * @property Esclarecimiento.censoArchivo $esclarecimiento.censoArchivo
 * @property Catalogos.catItem $catalogos.catItem
 */
class censo_archivos_detalle extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.censo_archivos_detalle';


    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_censo_archivos_detalle';

    /**
     * @var array
     */
    protected $fillable = ['id_censo_archivos', 'id_opcion'];

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
    public function rel_id_censo_archivo()
    {
        return $this->belongsTo(censo_archivos::class, 'id_censo_archivos', 'id_censo_archivos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_opcion()
    {
        return $this->belongsTo(cat_item::class, 'id_opcion', 'id_item');
    }
}
