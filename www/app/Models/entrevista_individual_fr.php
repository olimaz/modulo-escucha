<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevista_individual_fr
 * @package App\Models
 * @version April 17, 2019, 5:34 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idFr
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property integer id_fr
 */
class entrevista_individual_fr extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt_fr';
    protected $primaryKey = 'id_e_ind_fvt_fr';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_fr'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt_fr' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_fr' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt_fr' => 'required',
        'id_e_ind_fvt' => 'required',
        'id_fr' => 'required'
    ];


    //Llaves foraneas
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_fr() {
        return $this->belongsTo(cat_item::class,'id_fr','id_item');
    }


}
