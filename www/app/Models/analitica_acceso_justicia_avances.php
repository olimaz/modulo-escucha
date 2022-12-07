<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_entrevista
 * @property string $grupo
 * @property string $seccion
 * @property string $avance
 */
class analitica_acceso_justicia_avances extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_acceso_justicia_avances';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'grupo', 'avance'];

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

}
