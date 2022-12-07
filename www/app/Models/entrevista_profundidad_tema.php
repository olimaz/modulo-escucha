<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_profundidad_tema
 * @property int $id_entrevista_profundidad
 * @property string $tema
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.entrevistaProfundidad $esclarecimiento.entrevistaProfundidad
 */
class entrevista_profundidad_tema extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.entrevista_profundidad_tema';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_profundidad_tema';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista_profundidad', 'tema', 'id_usuario', 'created_at', 'updated_at'];

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

}
