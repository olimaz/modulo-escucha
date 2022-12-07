<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class correlativo
 * @package App\Models
 * @version April 17, 2019, 5:18 pm -05
 *
 * @property \App\Models\Catalogos.catItem idSubserie
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_subserie
 * @property integer correlativo
 */
class correlativo extends Model
{

    public $table = 'esclarecimiento.correlativo';
    protected $primaryKey = 'id_correlativo';
    
    public $timestamps = false;



    public $fillable = [
        'id_subserie',
        'correlativo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_correlativo' => 'integer',
        'id_subserie' => 'integer',
        'correlativo' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_correlativo' => 'required',
        'id_subserie' => 'required',
        'correlativo' => 'required'
    ];

    //Relaciones
    public function rel_id_subserie() {
        return $this->belongsTo(cat_item::class,'id_subserie','id_item');
    }

    public static function cual_toca($id_subserie=0){
        $fila = correlativo::where('id_subserie',$id_subserie)->first();
        if(empty($fila)) {
            correlativo::create(['id_subserie'=>$id_subserie, 'correlativo'=>1]);
            return 1;
        }
        else {
            $fila->correlativo++;
            $fila->save();
            return $fila->correlativo;
        }
    }


}
