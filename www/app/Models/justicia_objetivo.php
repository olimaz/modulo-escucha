<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_justicia_objetivo
 * @property int $id_e_ind_fvt
 * @property int $id_objetivo
 * @property int $id_tipo
 * @property string $created_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 * @property Catalogos.catItem $catalogos.catItem
 */
class justicia_objetivo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.justicia_objetivo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_justicia_objetivo';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_objetivo', 'id_tipo', 'created_at', 'id_entrevista_etnica'];

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

    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }    
    public function rel_id_objetivo() {
        return $this->belongsTo(cat_item::class,'id_objetivo','id_item');
    }
    public function getFmtIdObjetivoAttribute() {
        return cat_item::describir($this->id_objetivo);
    }

    //scopes
    public static function scopeEntrevista($query,$id=0, $tipo_entrevista='individual') {
        if($id > 0) {

            if ($tipo_entrevista=='individual') {
                $query->where('id_e_ind_fvt',$id);
            } else {
                $query->where('id_entrevista_etnica',$id);
            }
        }
    }
    public static function scopeTipo($query,$id=0) {
        if($id>0){
            $query->where('id_tipo',$id);
        }
    }

    //Función para poder editar c/pregunta
    public static function arreglo_objetivo($id_e_ind_fvt=0, $id_tipo=0, $tipo_entrevista='individual') {
        $arreglo=array();
        $listado = justicia_objetivo::entrevista($id_e_ind_fvt, $tipo_entrevista)->tipo($id_tipo)->get();
        foreach($listado as $item) {
            $arreglo[]=$item->id_objetivo;
        }
        return $arreglo;
    }
    //Función para poder mostrar c/pregunta
    public static function arreglo_objetivo_txt($id_e_ind_fvt=0, $id_tipo=0, $tipo_entrevista='individual') {
        $arreglo=array();
        $listado = justicia_objetivo::entrevista($id_e_ind_fvt, $tipo_entrevista)->tipo($id_tipo)->get();
        foreach($listado as $item) {
            $arreglo[$item->id_objetivo]=$item->fmt_id_objetivo;
        }
        if(count($arreglo)<1) {
            $arreglo[0]='Sin especificar / No aplica';
        }
        return $arreglo;
    }
}
