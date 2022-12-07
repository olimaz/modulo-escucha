<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_impacto
 * @property int $id_e_ind_fvt
 * @property int $id_impacto
 * @property string $transgeneracionales
 * @property string $afrentamiento_proceso
 * @property string $created_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 * @property Catalogos.catItem $catalogos.catItem
 */
class entrevista_impacto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.entrevista_impacto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_impacto';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_impacto', 'transgeneracionales', 'afrentamiento_proceso', 'created_at', 'id_entrevista_etnica', 'id_reparacion_etnica'];

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

    public function rel_id_impacto() {
        return $this->belongsTo(cat_item::class,'id_impacto','id_item');
    }
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }

    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }

    public function rel_id_reparacion_etnica() {
        return $this->belongsTo(cat_item::class, 'id_reparacion_etnica', 'id_item');
    }

    public function getFmtIdImpactoAttribute() {
        return cat_item::describir($this->id_impacto);
    }

    public static function scopePregunta($query,$id_cat=0) {
        if($id_cat>0) {
            $query->join('catalogos.cat_item','id_impacto','=','id_item')
                ->where('cat_item.id_cat',$id_cat);
        }
    }
    public static function scopeEntrevista($query,$id_e_ind_fvt=0, $tipo='individual') {
        if($id_e_ind_fvt>0) {
            if ($tipo=='individual') {
                $query->where('id_e_ind_fvt',$id_e_ind_fvt);
            } else {
                $query->where('id_entrevista_etnica',$id_e_ind_fvt);
            }
            
        }
    }

    //Función para poder editar c/pregunta
    public static function arreglo_impacto($id_e_ind_fvt, $id_cat, $tipo='individual') {
        $arreglo=array();
        $listado = entrevista_impacto::entrevista($id_e_ind_fvt, $tipo)->pregunta($id_cat)->get();
        foreach($listado as $item) {
                $arreglo[]=$item->id_impacto;
        }
        
        return $arreglo;
    }
    //Función para poder mostrar c/pregunta
    public static function arreglo_impacto_txt($id_e_ind_fvt,$id_cat, $tipo_entrevista='individual') {
        $arreglo=array();

        $listado = entrevista_impacto::entrevista($id_e_ind_fvt, $tipo_entrevista)->pregunta($id_cat)->get();

        foreach($listado as $item) {
            if($item->rel_id_impacto->id_cat == $id_cat) {
                $arreglo[$item->id_impacto]=$item->rel_id_impacto->descripcion;
            }
        }
        if(count($arreglo)<1) {
            $arreglo[0]='Sin especificar / No aplica';
        }
        return $arreglo;
    }


    //Autofill de impactos transgeneracionales
    public static function listar_opciones_campo($campo='transgeneracionales',$criterio="") {
        $criterio=trim($criterio);
        $criterio = str_replace(" ","%",$criterio);
        $opciones= entrevista_impacto::where($campo,'ilike',"%$criterio%")->distinct()->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }

}
