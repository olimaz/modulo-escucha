<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_lista_negra
 * @property int $id_entrevistador
 * @property int $id_activo
 * @property string $comentarios
 * @property string $fh_insert
 * @property string $fh_update
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class lista_negra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'catalogos.lista_negra';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_lista_negra';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevistador', 'id_activo', 'comentarios', 'fh_insert', 'fh_update'];

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



    //Devuelve true/false según el caso
    public static function revisar_bloqueo($id_entrevistador=0) {
        $existe = lista_negra::where('id_entrevistador',$id_entrevistador)->where('id_activo',1)->count();
        if($existe > 0) {
            return true;
        }

        return false;
    }
}
