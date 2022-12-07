<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_historia_vida_mandato
 * @property int $id_historia_vida
 * @property int $id_mandato
 * @property int $id_usuario
 * @property string $created_at
 * @property string $updated_at
 * @property Esclarecimiento.historiaVida $esclarecimiento.historiaVida
 * @property Catalogos.catItem $catalogos.catItem
 */
class historia_vida_mandato extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.historia_vida_mandato';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_historia_vida_mandato';

    /**
     * @var array
     */
    protected $fillable = ['id_historia_vida', 'id_mandato', 'id_usuario', 'created_at', 'updated_at'];

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
    public function rel_id_historia_vida() {
        return $this->belongsTo(historia_vida::class,'id_historia_vida','id_historia_vida');
    }
    public function rel_id_mandato() {
        return $this->belongsTo(cat_item::class,'id_mandato','id_item');
    }
    //Describir el mandato
    public function getFmtIdMandatoAttribute() {
        return cat_item::describir($this->id_mandato);
    }
}
