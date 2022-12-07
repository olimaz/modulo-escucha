<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class casos_informes_interes
 * @package App\Models
 * @version May 13, 2019, 2:39 pm -05
 *
 * @property \App\Models\Esclarecimiento.casosInforme idCasosInformes
 * @property \App\Models\Catalogos.catItem idInteres
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_casos_informes
 * @property integer id_interes
 */
class casos_informes_interes extends Model
{

    public $table = 'esclarecimiento.casos_informes_interes';
    protected $primaryKey = 'id_casos_informes_interes';
    
    public $timestamps = false;



    public $fillable = [
        'id_casos_informes',
        'id_interes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_casos_informes_interes' => 'integer',
        'id_casos_informes' => 'integer',
        'id_interes' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_casos_informes_interes' => 'required',
        'id_casos_informes' => 'required',
        'id_interes' => 'required'
    ];

    public function rel_id_casos_informes() {
        return $this->belongsTo(casos_informes::class,'id_casos_informes','id_casos_informes');
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
            return "Desconocido ($this->id_interes)";
        }
    }
}
