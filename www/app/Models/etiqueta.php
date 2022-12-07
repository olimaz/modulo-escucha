<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_etiqueta
 * @property string $etiqueta
 */
class etiqueta extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.etiqueta';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_etiqueta';

    /**
     * @var array
     */
    protected $fillable = ['etiqueta'];

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


    //Busca en el tesauro, sino, devuelve el texto corto
    public function getTextoAttribute() {
        $tes = tesauro::where('id_etiqueta',$this->id_etiqueta)->first();

        if($tes) {
            return tesauro::nombre_completo($tes->id_geo);
        }
        else {
            return $this->etiqueta;
        }

    }

}
