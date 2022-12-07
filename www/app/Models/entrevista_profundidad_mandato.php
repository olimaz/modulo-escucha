<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_profundidad_mandato
 * @property int $id_entrevista_profundidad
 * @property int $id_mandato
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.entrevistaProfundidad $esclarecimiento.entrevistaProfundidad
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_profundidad_mandato extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_profundidad_mandato';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_profundidad_mandato';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_profundidad', 'id_mandato', 'id_usuario', 'created_at', 'updated_at'];

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
    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if(\Auth::check()) {
            $this->attributes['id_usuario']=\Auth::user()->id;
        }
    }

    //Llaves foraneas
    public function rel_id_entrevista_profundidad() {
        return $this->belongsTo(entrevista_profundidad::class,'id_entrevista_profundidad','id_entrevista_profundidad');
    }
    public function rel_id_mandato() {
        return $this->belongsTo(cat_item::class,'id_mandato','id_item');
    }
    //Describir el mandato
    public function getFmtIdMandatoAttribute() {
        return cat_item::describir($this->id_mandato);
    }
}
