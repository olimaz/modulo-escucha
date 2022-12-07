<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_entrevista
 * @property string $tipo_entidad
 * @property string $entidad
 */
class analitica_acceso_justicia_denuncia_entidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_acceso_justicia_denuncia_entidad';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'tipo_entidad', 'entidad'];

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
