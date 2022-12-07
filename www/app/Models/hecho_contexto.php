<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hecho_contexto
 * @property int $id_hecho
 * @property int $id_contexto
 * @property string $created_at
 * @property Fichas.hecho $fichas.hecho
 * @property Catalogos.catItem $catalogos.catItem
 */
class hecho_contexto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.hecho_contexto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho_contexto';

    /**
     * @var array
     */
    protected $fillable = ['id_hecho', 'id_contexto', 'created_at'];

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
    public function rel_id_hecho()
    {
        return $this->belongsTo(hecho::class, 'id_hecho', 'id_hecho');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_contexto()
    {
        return $this->belongsTo(cat_item::class, 'id_contexto', 'id_item');
    }
}
