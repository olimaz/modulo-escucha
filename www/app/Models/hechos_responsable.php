<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hechos_responsable
 * @property int $id_e_ind_fvt
 * @property int $id_hechos
 * @property int $id_responsable
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at

 */
class hechos_responsable extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'demo.hechos_responsable';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hechos_responsable';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_hechos', 'id_responsable', 'id_usuario', 'created_at', 'updated_at'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    public $dates = ['created_at', 'updated_at'];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function rel_id_hechos() {
        return $this->belongsTo(hechos::class,'id_hechos','id_hechos');
    }
    public function rel_id_responsable() {
        //return $this->belongsTo(responsable::class,'id_responsable','id_responsable');
    }


}
