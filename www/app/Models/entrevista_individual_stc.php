<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_stc
 * @package App\Models
 * @version May 9, 2019, 6:54 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idStc
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property integer id_stc
 */
class entrevista_individual_stc extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_stc';
    protected $primaryKey = 'id_e_ind_fvt_stc';
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_stc'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_stc' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_stc' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt_stc' => 'required',
        'id_e_ind_fvt' => 'required',
        'id_stc' => 'required'
    ];

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_stc() {
        return $this->belongsTo(cat_item::class,'id_stc','id_item');
    }
}
