<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hecho_victima
 * @property int $id_hecho
 * @property int $id_victima
 * @property int $id_lugar_residencia
 * @property int $id_lugar_residencia_tipo
 * @property int $edad
 * @property string $ocupacion
 * @property int $id_ocupacion
 * @property Fichas.hecho $fichas.hecho
 * @property Fichas.victima $fichas.victima
 * @property Catalogos.geo $catalogos.geo
 * @property Catalogos.catItem $catalogos.catItem
 */
class hecho_victima extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.hecho_victima';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho_victima';

    /**
     * @var array
     */
    protected $fillable = ['id_hecho', 'id_victima', 'ocupacion', 'id_ocupacion','id_lugar_residencia', 'id_lugar_residencia_tipo', 'edad'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_hecho()
    {
        return $this->belongsTo(hecho::class, 'id_hecho', 'id_hecho');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_victima()
    {
        return $this->belongsTo(victima::class, 'id_victima', 'id_victima');
    }
    public function rel_id_ocupacion() {
        return $this->belongsTo(cat_item::class,'id_ocupacion','id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_lugar_residencia()
    {
        return $this->belongsTo(geo::class, 'id_lugar_residencia', 'id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_lugar_residencia_tipo()
    {
        return $this->belongsTo(cat_item::class, 'id_lugar_residencia_tipo', 'id_item');
    }


    public function getFmtEdadAttribute() {
        if($this->edad > 0) {
            return $this->edad;
        }
        else {
            return "No indica";
        }
    }

    public function getFmtIdOcupacionAttribute() {
        return cat_item::describir($this->id_ocupacion);
    }
    public function getFmtIdOcupacionReclasificadoAttribute() {
        return cat_item::describir_reclasificado($this->id_ocupacion);
    }
    public function getFmtIdLugarResidenciaAttribute() {
        return geo::nombre_completo($this->id_lugar_residencia);
    }

    public function getDatosCompletosAttribute() {
        $victima = $this->rel_id_victima;
        $persona = $victima->persona;
        $str= $persona->nombre. " ".$persona->apellido.".";
        //Parentezco
        $id_victima = $this->id_victima;
        $id_e_ind_fvt = $victima->id_e_ind_fvt;
        $persona_entrevistada = persona_entrevistada::where('id_e_ind_fvt',$id_e_ind_fvt)->first();

        if($persona_entrevistada) {

            $id_persona_entrevistada = $persona_entrevistada->id_persona_entrevistada;
            $parentezco = \DB::table('fichas.per_ent_rel_victima')->where('id_victima',$id_victima)->where('id_persona_entrevistada',$id_persona_entrevistada)->first();
            if($parentezco) {
                $str.=" (".cat_item::describir($parentezco->id_rel_victima).") ";
            }
        }

        if($this->edad > 0) {
            $str.=" Edad: $this->edad.";
        }
        if($persona->id_sexo > 0) {
            $str.=" Sexo: ".$persona->sexo.".";
        }

        if($persona->id_etnia > 0) {
            $str.=" Etnia: ".$persona->etnia.".";
        }
        if($persona->id_etnia > 0) {
            $str.=" Etnia: ".$persona->etnia.".";
        }



        return $str;
    }

    //Setter
    public function setIdOcupacionAttribute($val) {
        if($val<=0) {
            $val=null;
        }
        $this->attributes['id_ocupacion']=$val;
    }

    //Utiliza la funcion calcular_edad de persona, pasandole los datos de persona y del hecho
    //Devuelve la edad, pero no altera el objeto, la asignación y actualización del registro debe ser manual
    public function calcular_edad() {
        $victima = $this->rel_id_victima;
        $hecho=false;
        $persona=false;
        $edad=null;
        if($victima) {
            $persona = $victima->rel_id_persona;
            if($persona) {
                $hecho = $this->rel_id_hecho;
            }
        }
        if($hecho) {
            $fecha_hecho = str_pad($hecho->fecha_ocurrencia_a,4,"0",STR_PAD_LEFT);
            $fecha_hecho.= "-".str_pad($hecho->fecha_ocurrencia_m,2,"0",STR_PAD_LEFT);
            $fecha_hecho.= "-".str_pad($hecho->fecha_ocurrencia_d,2,"0",STR_PAD_LEFT);
            //dd($fecha_hecho);
            $edad = $persona->calcular_edad($fecha_hecho);

        }
       return $edad;

    }

    //2021-06-07: el sistema no calculaba automaticamente la edad
    public static function calcular_edad_nulos() {
        $listado = hecho_victima::wherenull('edad')->get();
        $total=0;
        $arreglo=[];
        foreach($listado as $item) {
            $total++;
            $edad = $item->calcular_edad();
            $arreglo[$item->id_hecho_victima]=$edad;
            $item->edad = $edad;
            $item->save();
        }
        return $arreglo;

    }
}
