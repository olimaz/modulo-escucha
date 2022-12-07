<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_interes
 * @package App\Models
 * @version May 9, 2019, 4:14 pm -05
 *
 * @property integer id_e_ind_fvt
 * @property integer id_mandato
 */
class entrevista_individual_mandato extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_mandato';
    protected $primaryKey = 'id_e_ind_fvt_mandato';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_mandato'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_mandato' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_mandato' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt' => 'required',
        'id_mandato' => 'required'
    ];

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_mandato() {
        return $this->belongsTo(cat_item::class,'id_mandato','id_item');
    }

    public function getFmtIdMandatoAttribute() {
        $item = $this->rel_id_mandato;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Desconocido: $this->id_mandato";
        }
    }
}
