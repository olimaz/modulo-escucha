<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_entrevista
 * @property string $quien_apoya
 */
class analitica_acceso_justicia_apoyo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.entrevista_acceso_justicia_apoyo';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'quien_apoya'];

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
