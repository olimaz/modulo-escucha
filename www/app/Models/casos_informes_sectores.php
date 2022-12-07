<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_casos_informes_sectores
 * @property int $id_casos_informes
 * @property int $id_item
 * @property int $id_entrevistador_insert
 * @property string $fh_insert
 * @property Esclarecimiento.casosInforme $esclarecimiento.casosInforme
 * @property Catalogos.catItem $catalogos.catItem
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class casos_informes_sectores extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.casos_informes_sectores';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_casos_informes_sectores';

    /**
     * @var array
     */
    protected $fillable = ['id_casos_informes', 'id_item', 'id_entrevistador_insert', 'fh_insert'];

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
    public function rel_id_casos_informes()
    {
        return $this->belongsTo(casos_informes::class, 'id_casos_informes', 'id_casos_informes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_item()
    {
        return $this->belongsTo(cat_item::class, 'id_item', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador_insert', 'id_entrevistador');
    }
}
