<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class victima
 * @package App\Models
 * @version July 27, 2019, 6:53 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
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
 * @property \Illuminate\Database\Eloquent\Collection demo.hechosVictimas
 * @property integer id_e_ind_fvt
 * @property integer es_declarante
 * @property integer id_declarante
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
class Oldvictima extends Model
{

    public $table = 'demo.victima';
    protected $primaryKey = 'id_victima';
    
    public $timestamps = true;



    public $fillable = [
        'id_e_ind_fvt',
        'es_declarante',
        'id_declarante',
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
        'id_victima' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'es_declarante' => 'integer',
        'id_declarante' => 'integer',
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

        'nacimiento_fecha' => 'required',
        'nacimiento_lugar' => 'required',
        'sexo' => 'required',
        'orientacion_sexual' => 'required',
        'identidad_genero' => 'required',
        'pertenencia_etnico_racial' => 'required',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['es_declarante']=2;
        $this->attributes['id_declarante']=null;
    }


    public function getFmtEsDeclaranteAttribute() {
        return criterio_fijo::describir(2,$this->es_declarante);
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
    public function getFmtNombreCompletoAttribute() {
        $txt=$this->apellidos.", ".$this->nombres;
        if(strlen($this->otros_nombres)>0) {
            $txt.=" [".$this->otros_nombres."] ";
        }
        return $txt;
    }

    //Ordenado por
    public static function scopeOrdenado($query) {
        $query->orderby('es_declarante')
                ->orderby('apellidos')
                ->orderby('nombres')
                ->orderby('nacimiento_fecha');
    }

    public static function arreglo_expediente($id) {
        $listado = victima::where('id_e_ind_fvt',$id)->ordenado()->get();
        $arreglo = array();
        foreach($listado as $item) {
            $txt=$item->apellidos.", ".$item->nombres;
            if(strlen($item->otros_nombres)>0) {
                $txt.=" [".$item->otros_nombres."] ";
            }
            $txt.=" - (".$item->fmt_nacimiento_fecha.")";
            $arreglo[$item->id_victima]=$txt;
        }
        return $arreglo;
    }


}
