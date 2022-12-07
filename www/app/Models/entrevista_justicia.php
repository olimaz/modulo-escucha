<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_justicia
 * @property int $id_e_ind_fvt
 * @property int $id_denuncio
 * @property string $porque_no
 * @property int $id_apoyo
 * @property int $id_adecuado
 * @property string $created_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 */
class entrevista_justicia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.entrevista_justicia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_justicia';

    /**
     * @var array
     */
    protected $fillable = ['id_e_ind_fvt', 'id_denuncio', 'porque_no', 'id_apoyo', 'id_adecuado', 'created_at'];

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
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }

    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }    

    //scopes
    public static function scopeEntrevista($query,$id=0, $tipo='individual') {
        if($id > 0) {

            if ($tipo=='individual') {
                $query->where('id_e_ind_fvt',$id);
            } else {
                $query->where('id_entrevista_etnica',$id);
            }
        }
    }

    public function getFmtIdDenuncioAttribute() {
        return $this->id_denuncio ==1 ? "Sí" : "No";
    }
    public function getFmtIdApoyoAttribute() {
        return $this->id_apoyo ==1 ? "Sí" : "No";
    }
    public function getFmtIdAdecuadoAttribute() {
        return $this->id_adecuado ==1 ? "Sí" : "No";
    }



}
