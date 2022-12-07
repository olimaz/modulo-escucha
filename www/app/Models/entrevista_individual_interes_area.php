<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_e_ind_fvt_interes_area
 * @property int $id_e_ind_fvt
 * @property int $id_interes
 */
class entrevista_individual_interes_area extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.e_ind_fvt_interes_area';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_e_ind_fvt_interes_area';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_interes'];

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

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_interes() {
        return $this->belongsTo(cat_item::class,'id_interes','id_item');
    }
    public function getFmtIdInteresAttribute() {
        $item = $this->rel_id_interes;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido: $this->id_interes";
        }
    }

}
