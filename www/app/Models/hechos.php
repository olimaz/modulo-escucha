<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class hechos
 * @package App\Models
 * @version July 27, 2019, 6:54 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt


 * @property integer id_entrevista
 * @property string|\Carbon\Carbon hechos_fecha
 * @property string|\Carbon\Carbon hechos_lugar
 * @property string|\Carbon\Carbon hechos_sitio
 * @property integer id_usuario
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class hechos extends Model
{

    public $table = 'demo.hechos';
    protected $primaryKey = 'id_hechos';
    public $timestamps = true;
    public $fillable = [
        'id_e_ind_fvt',
        'id_entrevista',
        'hechos_fecha',
        'hechos_lugar',
        'hechos_sitio',
        'cantidad_victimas',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_hechos' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_entrevista' => 'integer',
        'hechos_fecha' => 'datetime',
        'hechos_lugar' => 'integer',
        'hechos_sitio' => 'text',
        'cantidad_victimas' => 'integer',
        'id_usuario' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'hechos_fecha' => 'required',
        'hechos_lugar' => 'required',

        'cantidad_victimas' => 'required|integer|min:1'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['cantidad_victimas']=1;
    }

    public function rel_victima() {
        return $this->hasMany(hechos_victima::class,'id_hechos','id_hechos');
    }
    public function rel_violacion() {
        return $this->hasMany(hechos_violacion::class,'id_hechos','id_hechos');
    }
    public function rel_responsable() {
        return $this->hasMany(hechos_responsable::class,'id_hechos','id_hechos');
    }
    public function rel_fuerza() {
        return $this->hasMany(hechos_fuerza::class,'id_hechos','id_hechos');
    }

    public function getFmtHechosFechaAttribute() {
        return $this->hechos_fecha->format("d-m-Y");
    }
    public function getFmtHechosLugarAttribute() {
        return geo::nombrar($this->hechos_lugar);
    }
    public function getFmtHechosLugarCompletoAttribute() {
        return geo::nombre_completo($this->hechos_lugar);
    }
    public function getConteoViolacionesAttribute() {
        $victimas = $this->cantidad_victimas;
        $violaciones = $this->rel_violacion()->count();
        return $victimas*$violaciones;
    }
    public static function scopeOrdenado($query) {
        $query->orderBy('hechos_fecha');
    }


}
