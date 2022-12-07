<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_marca
 * @property string $texto
 * @property Esclarecimiento.marcaEntrevistum[] $esclarecimiento.marcaEntrevistas
 */
class marca extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.marca';


    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_marca';

    /**
     * @var array
     */
    protected $fillable = ['texto'];

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

    //Procesar el request y crear las marcas
    public static function crear_marcas(array $arreglo) {
        $existe=array();
        //dd($arreglo);
        foreach($arreglo as $texto) {
            if(strlen($texto)>190) {
                $texto = substr($texto,0,190);
            }
            if( is_numeric($texto)>0) {
                $hay = marca::find((integer)$texto);
                if($hay) {
                    $existe[] = $hay;
                }
            }
            else {
                $existe[] = marca::firstOrCreate(['texto'=>$texto]);
            }
        }
        //dd($arreglo);
        //dd($existe);
        return $existe;
    }
}
