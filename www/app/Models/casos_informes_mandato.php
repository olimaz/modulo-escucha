<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class casos_informes_mandato extends Model
{
    //
    public $table = 'esclarecimiento.casos_informes_mandato';
    protected $primaryKey = 'id_casos_informes_mandato';

    public $timestamps = false;



    public $fillable = [
        'id_casos_informes',
        'id_mandato'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_casos_informes_interes' => 'integer',
        'id_casos_informes' => 'integer',
        'id_mandato' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_casos_informes_interes' => 'required',
        'id_casos_informes' => 'required',
        'id_mandato' => 'required'
    ];

    public function rel_id_casos_informes() {
        return $this->belongsTo(casos_informes::class,'id_casos_informes','id_casos_informes');
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
            return "Desconocido ($this->id_mandato)";
        }
    }
}
