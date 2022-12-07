<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hechos_victima
 * @property int $id_e_ind_fvt
 * @property int $id_hechos
 * @property int $id_victima
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 * @property Demo.hecho $demo.hecho
 * @property Demo.victima $demo.victima
 */
class hechos_victima extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'demo.hechos_victima';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hechos_victima';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_hechos', 'id_victima', 'id_usuario', 'created_at', 'updated_at'];

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

    public function rel_id_hechos() {
        return $this->belongsTo(hechos::class,'id_hechos','id_hechos');
    }
    public function rel_id_victima() {
        return $this->belongsTo(victima::class,'id_victima','id_victima');
    }



}
