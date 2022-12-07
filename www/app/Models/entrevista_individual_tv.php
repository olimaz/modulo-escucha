<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_tv
 * @package App\Models
 * @version April 17, 2019, 5:35 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idTv
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property integer id_tv
 */
class entrevista_individual_tv extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_tv';
    protected $primaryKey = 'id_e_ind_fvt_tv';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_tv'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_tv' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_tv' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt_tv' => 'required',
        'id_e_ind_fvt' => 'required',
        'id_tv' => 'required'
    ];

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_tv() {
        return $this->belongsTo(cat_item::class,'id_tv','id_item');
    }


}
