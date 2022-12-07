<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_control_transcripcion
 * @property string $fh_inicio
 * @property string $fh_fin
 * @property int $id_primaria
 * @property int $id_subserie
 * @property string $nombre_archivo
 * @property int $id_adjunto_nuevo
 * @property int $id_estado
 * @property string $created_at
 * @property string $updated_at
 */
class control_transcripcion extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'control_transcripcion';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_control_transcripcion';

    /**
     * @var array
     */
    protected $fillable = ['fh_inicio', 'fh_fin', 'id_primaria', 'id_subserie', 'nombre_archivo', 'id_adjunto_nuevo', 'id_estado', 'created_at', 'updated_at'];

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
