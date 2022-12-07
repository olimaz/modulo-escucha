<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_interes
 * @package App\Models
 * @version May 9, 2019, 4:14 pm -05
 *
 * @property integer id_e_ind_fvt
 * @property integer id_dinamica
 */
class entrevista_individual_dinamica extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_dinamica';
    protected $primaryKey = 'id_e_ind_fvt_dinamica';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'dinamica',
        'id_dinamica'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_dinamica' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_dinamica' => 'integer',
        'dinamica' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt' => 'required',
        //'id_interes' => 'required'
    ];

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_dinamica() {
        return $this->belongsTo(cat_item::class,'id_dinamica','id_item');
    }
}
