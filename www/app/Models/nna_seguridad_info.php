<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_nna_seguridad_info
 * @property int $id_nna_seguridad
 * @property int $id_info
 * @property Esclarecimiento.nnaSeguridad $esclarecimiento.nnaSeguridad
 * @property Catalogos.catItem $catalogos.catItem
 */
class nna_seguridad_info extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.nna_seguridad_info';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_nna_seguridad_info';

    /**
     * @var array
     */
    protected $fillable = ['id_nna_seguridad', 'id_info'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;


    public function rel_id_nna_seguridad() {
        return $this->belongsTo(nna_seguridad::class,'id_nna_seguridad','id_nna_seguridad');
    }
    public function rel_id_info() {
        return $this->belongsTo(cat_item::class,'id_info','id_item');
    }
    public function getFmtIdInfoAttribute() {
        $item=$this->rel_id_info;
        if($item) {
            return $item->descripcion;
        }
    }
}
