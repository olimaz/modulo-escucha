<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_historia_vida_dinamica
 * @property int $id_historia_vida
 * @property int $id_dinamica
 * @property string $dinamica
 * @property Esclarecimiento.historiaVida $esclarecimiento.historiaVida
 * @property Catalogos.catItem $catalogos.catItem
 */
class historia_vida_dinamica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.historia_vida_dinamica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_historia_vida_dinamica';

    /**
     * @var array
     */
    protected $fillable = ['id_historia_vida', 'id_dinamica', 'dinamica'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     * 
     * @var string
     */
    protected $dateFormat = 'U';

    //Llaves foraneas
    public function rel_id_historia_vida() {
        return $this->belongsTo(historia_vida::class,'id_historia_vida','id_historia_vida');
    }
    public function rel_id_dinamica() {
        return $this->belongsTo(cat_item::class,'id_dinamica','id_item');
    }
    //Describir el mandato
    public function getFmtIdDinamicaAttribute() {
        return cat_item::describir($this->id_dinamica);
    }
}
