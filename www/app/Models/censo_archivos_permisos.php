<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_censo_archivos_permisos
 * @property int $id_censo_archivos
 * @property int $id_entrevistador
 * @property int $id_perfil
 * @property string $fh_insert
 * @property Esclarecimiento.censoArchivo $esclarecimiento.censoArchivo
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class censo_archivos_permisos extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'esclarecimiento.censo_archivos_permisos';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_censo_archivos_permisos';

    /**
     * @var array
     */
    protected $fillable = ['id_censo_archivos', 'id_entrevistador', 'id_perfil', 'fh_insert'];

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
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_censo_archivos()
    {
        return $this->belongsTo(censo_archivos::class, 'id_censo_archivos', 'id_censo_archivos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }


    //GETTERS
    function getFmtIdEntrevistadorAttribute() {
        $quien = $this->rel_id_entrevistador;
        if($quien) {
            return $quien->fmt_numero_nombre;
        }
        else {
            return "Desconocido";
        }
    }

    public function getFmtIdPerfilAttribute() {
        return criterio_fijo::describir(55,$this->id_perfil);
    }


}
