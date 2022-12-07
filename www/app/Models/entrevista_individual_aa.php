<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_aa
 * @package App\Models
 * @version May 9, 2019, 4:14 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idAa
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property integer id_aa
 */
class entrevista_individual_aa extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_aa';
    protected $primaryKey = 'id_e_ind_fvt_aa';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_aa'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_aa' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_aa' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt_aa' => 'required',
        'id_e_ind_fvt' => 'required',
        'id_aa' => 'required'
    ];

    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_aa() {
        return $this->belongsTo(cat_item::class,'id_aa','id_item');
    }
}
