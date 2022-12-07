<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_diagnostico_comunitario_interes
 * @property int $id_diagnostico_comunitario
 * @property int $id_interes
 * @property Esclarecimiento.diagnosticoComunitario $esclarecimiento.diagnosticoComunitario
 * @property Catalogos.catItem $catalogos.catItem
 */
class diagnostico_comunitario_interes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.diagnostico_comunitario_interes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_diagnostico_comunitario_interes';

    /**
     * @var array
     */
    protected $fillable = ['id_diagnostico_comunitario', 'id_interes'];

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
    public function rel_id_interes() {
        return $this->belongsTo(cat_item::class,'id_interes','id_item');
    }
    //Describir el mandato
    public function getFmtIdInteresAttribute() {
        return cat_item::describir($this->id_interes);
    }
}
