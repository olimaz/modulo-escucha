<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_rol_entrevistador
 * @property int $id_entrevistador
 * @property int $id_rol
 * @property string $fh_insert
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class rol_entrevistador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'catalogos.rol_entrevistador';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_rol_entrevistador';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador', 'id_rol', 'fh_insert'];

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


    public function rel_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }
    public function rel_id_rol() {
        return $this->belongsTo(rol::class, 'id_rol', 'id_rol');
    }

    /**
     * @param int $id_entrevistador
     * @param int $id_rol
     * @return bool
     */
    public static function tiene_rol($id_entrevistador=0, $id_rol=0) {
        $existe = rol_entrevistador::where('id_rol',$id_rol)->where('id_entrevistador',$id_entrevistador)->first();
        if($existe) {
            return true;
        }
        else {
            return false;
        }
    }
}
