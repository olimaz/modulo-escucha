<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class entrevistado
 * @package App\Models
 * @version July 27, 2019, 6:53 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Demo.entrevistum idEntrevista
 * @property \App\Models\Catalogos.catItem sexo
 * @property \App\Models\Catalogos.catItem orientacionSexual
 * @property \App\Models\Catalogos.catItem identidadGenero
 * @property \App\Models\Catalogos.catItem pertenenciaEtnicoRacial
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property integer id_entrevista
 * @property integer es_victima
 * @property integer es_testigo
 * @property string nombres
 * @property string apellidos
 * @property string otros_nombres
 * @property string|\Carbon\Carbon nacimiento_fecha
 * @property integer nacimiento_lugar
 * @property integer sexo
 * @property integer orientacion_sexual
 * @property integer identidad_genero
 * @property integer pertenencia_etnico_racial
 * @property integer id_usuario
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class entrevistado extends Model
{

    public $table = 'demo.entrevistado';
    protected $primaryKey = 'id_entrevistado';
    
    public $timestamps = true;



    public $fillable = [
        'id_e_ind_fvt',
        'id_entrevista',
        'es_victima',
        'es_testigo',
        'nombres',
        'apellidos',
        'otros_nombres',
        'nacimiento_fecha',
        'nacimiento_lugar',
        'sexo',
        'orientacion_sexual',
        'identidad_genero',
        'pertenencia_etnico_racial',
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
        'id_entrevistado' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_entrevista' => 'integer',
        'es_victima' => 'integer',
        'es_testigo' => 'integer',
        'nombres' => 'string',
        'apellidos' => 'string',
        'otros_nombres' => 'string',
        'nacimiento_fecha' => 'datetime',
        'nacimiento_lugar' => 'integer',
        'sexo' => 'integer',
        'orientacion_sexual' => 'integer',
        'identidad_genero' => 'integer',
        'pertenencia_etnico_racial' => 'integer',
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
        'es_victima' => 'required',
        'es_testigo' => 'required',
        'nombres' => 'required',
        'apellidos' => 'required',
        'nacimiento_fecha_submit' => 'required',
        'nacimiento_lugar' => 'required',
        'sexo' => 'required',
        'orientacion_sexual' => 'required',
        'identidad_genero' => 'required',
        'pertenencia_etnico_racial' => 'required',

    ];

   public function __construct(array $attributes = [])
   {
       parent::__construct($attributes);
       $this->attributes['es_victima']=2;
       $this->attributes['es_testigo']=2;
   }

   public function getFmtEsVictimaAttribute() {
       return criterio_fijo::describir(2,$this->es_victima);
   }
    public function getFmtEsTestigoAttribute() {
        return criterio_fijo::describir(2,$this->es_testigo);
    }
    public function getFmtNacimientoFechaAttribute() {
       return $this->nacimiento_fecha->format("d-m-Y");
    }
    public function getFmtNacimientoLugarAttribute() {
       return geo::nombre_completo($this->nacimiento_lugar);
    }
    public function getFmtSexoAttribute() {
       return cat_item::describir($this->sexo);
    }
    public function getFmtOrientacionSexualAttribute() {
        return cat_item::describir($this->orientacion_sexual);
    }
    public function getFmtIdentidadGeneroAttribute() {
        return cat_item::describir($this->identidad_genero);
    }
    public function getFmtPertenenciaEtnicoRacialAttribute() {
        return cat_item::describir($this->pertenencia_etnico_racial);
    }
}
