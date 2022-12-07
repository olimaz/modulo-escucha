<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_diagnostico_comunitario_dinamica
 * @property int $id_dinamica
 * @property int $id_diagnostico_comunitario
 * @property string $dinamica
 * @property Esclarecimiento.diagnosticoComunitario $esclarecimiento.diagnosticoComunitario
 * @property Catalogos.catItem $catalogos.catItem
 */
class diagnostico_comunitario_dinamica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.diagnostico_comunitario_dinamica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_diagnostico_comunitario_dinamica';

    /**
     * @var array
     */
    protected $fillable = ['id_dinamica', 'id_diagnostico_comunitario', 'dinamica'];

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
    public function rel_id_diagnostico_comunitario() {
        return $this->belongsTo(diagnostico_comunitario::class,'id_diagnostico_comunitario','id_diagnostico_comunitario');
    }
    public function rel_id_dinamica() {
        return $this->belongsTo(cat_item::class,'id_dinamica','id_item');
    }
    //Describir el mandato
    public function getFmtIdDinamicaAttribute() {
        return cat_item::describir($this->id_dinamica);
    }
}
