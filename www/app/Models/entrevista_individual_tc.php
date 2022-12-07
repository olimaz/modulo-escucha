<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_tc
 * @package App\Models
 * @version May 9, 2019, 4:15 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idTc
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property integer id_tc
 */
class entrevista_individual_tc extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_tc';
    protected $primaryKey = 'id_e_ind_fvt_tc';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_tc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_tc' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_tc' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt_tc' => 'required',
        'id_e_ind_fvt' => 'required',
        'id_tc' => 'required'
    ];

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_tc() {
        return $this->belongsTo(cat_item::class,'id_tc','id_item');
    }
}
