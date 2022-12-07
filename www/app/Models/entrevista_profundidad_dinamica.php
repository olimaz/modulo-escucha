<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_profundidad_dinamica
 * @property int $id_entrevista_profundidad
 * @property int $id_dinamica
 * @property string $dinamica
 * @property Esclarecimiento.entrevistaProfundidad $esclarecimiento.entrevistaProfundidad
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_profundidad_dinamica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_profundidad_dinamica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_profundidad_dinamica';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_profundidad', 'id_dinamica', 'dinamica'];

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
    public function rel_id_entrevista_profundidad() {
        return $this->belongsTo(entrevista_profundidad::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_id_mandato() {
        return $this->belongsTo(cat_item::class,'id_dinamica','id_item');
    }
    //Describir el mandato
    public function getFmtIdDinamicaAttribute() {
        return cat_item::describir($this->id_dinamica);
    }
}
