<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_condiciones
 * @property int $id_entrevista
 * @property int $id_condicion
 * @property string $created_at
 * @property string $updated_at
 * @property Catalogos.catItem $catalogos.catItem
 * @property Fichas.entrevistum $fichas.entrevistum
 */
class entrevista_condiciones extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fichas.entrevista_condiciones';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_entrevista_condiciones';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'id_condicion', 'created_at', 'updated_at'];

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
    public function rel_id_condicion()
    {
        return $this->belongsTo(\App\Models\cat_item::class, 'id_condicion', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_entrevista()
    {
        return $this->belongsTo(\App\Models\entrevista::class, 'id_entrevista', 'id_entrevista');
    }
}
