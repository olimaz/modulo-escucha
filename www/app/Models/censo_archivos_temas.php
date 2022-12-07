<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_censo_archivos_temas
 * @property int $id_censo_archivos
 * @property string $nombre
 * @property string $descripcion
 * @property Esclarecimiento.censoArchivo $esclarecimiento.censoArchivo
 */
class censo_archivos_temas extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.censo_archivos_temas';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_censo_archivos_temas';

    /**
     * @var array
     */
    protected $fillable = ['id_censo_archivos', 'nombre', 'descripcion'];

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
}
