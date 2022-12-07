<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class mis_casos_entrevistador
 * @package App\Models
 * @version August 4, 2020, 9:38 pm -05
 *
 * @property \App\Models\Esclarecimiento.misCaso idMisCasos
 * @property \App\Models\Esclarecimiento.entrevistador idEntrevistador
 * @property integer id_mis_casos
 * @property integer id_entrevistador
 * @property integer id_perfil
 * @property string|\Carbon\Carbon fh_insert
 */
class mis_casos_entrevistador extends Model
{

    public $table = 'esclarecimiento.mis_casos_entrevistador';
    
    public $timestamps = false;



    protected $primaryKey = 'id_mis_casos_entrevistador';

    public $fillable = [
        'id_mis_casos',
        'id_entrevistador',
        'id_perfil',
        'fh_insert'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_mis_casos_usuario' => 'integer',
        'id_mis_casos' => 'integer',
        'id_entrevistador' => 'integer',
        'id_perfil' => 'integer',
        //'fh_insert' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_mis_casos()
    {
        return $this->belongsTo(mis_casos::class, 'id_mis_casos', 'id_mis_casos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }

    public function getFmtIdPerfilAttribute() {
        return criterio_fijo::describir(51,$this->id_perfil);
    }
    public function getFmtIdEntrevistadorAttribute() {
        return $this->rel_id_entrevistador->fmt_numero_nombre;
    }
}
