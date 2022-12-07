<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_colectiva_interes
 * @property int $id_entrevista_colectiva
 * @property int $id_interes
 * @property Esclarecimiento.entrevistaColectiva $esclarecimiento.entrevistaColectiva
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_colectiva_interes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_colectiva_interes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_colectiva_interes';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_colectiva', 'id_interes'];

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


    public function rel_id_entrevista_colectiva() {
        return $this->belongsTo(entrevista_colectiva::class,'id_entrevista_colectiva','id_entrevista_colectiva');
    }
    public function rel_id_interes() {
        return $this->belongsTo(cat_item::class,'id_interes','id_item');
    }

    public function getFmtIdInteresAttribute() {
        return cat_item::describir($this->id_interes);
    }
}
