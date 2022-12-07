<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_entrevista
 * @property string $tipo_entidad
 * @property string $por_que
 */
class analitica_acceso_justicia_denuncia_por_que extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_acceso_justicia_denuncia_por_que';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'tipo_entidad', 'por_que'];

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
