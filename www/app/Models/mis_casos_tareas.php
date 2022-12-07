<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_mis_casos_tareas
 * @property int $id_mis_casos
 * @property string $descripcion
 * @property int $realizado
 * @property int $id_activo
 * @property string $fh_insert
 * @property string $fh_update
 */
class mis_casos_tareas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.mis_casos_tareas';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_mis_casos_tareas';

    /**
     * @var array
     */
    protected $fillable = ['id_mis_casos', 'descripcion', 'realizado', 'id_activo', 'fh_insert', 'fh_update'];

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

    public function rel_id_mis_casos() {
        return $this->belongsTo(mis_casos::class,'id_mis_casos','id_mis_casos');
    }

}
