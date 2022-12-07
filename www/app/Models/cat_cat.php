<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class cat_cat
 * @package App\Models
 * @version April 15, 2019, 4:41 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection catalogos.catItems
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property string nombre
 * @property string descripcion
 * @property integer editable
 * @property integer id_reclasificado
 */
class cat_cat extends Model
{

    public $table = 'catalogos.cat_cat';
    protected $primaryKey = 'id_cat';
    
    public $timestamps = false;



    public $fillable = [
        'nombre',
        'descripcion',
        'editable'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_cat' => 'integer',
        'nombre' => 'string',
        'descripcion' => 'string',
        'editable' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_cat' => 'required',
        'nombre' => 'required'
    ];

    // Relaciones
    public function rel_items() {
        return $this->hasMany(cat_item::class,'id_cat','id_cat');
    }

    //Para el proceso de reclasificacion
    public function rel_id_reclasificado(){
        return $this->belongsTo(cat_cat::class,'id_reclasificado','id_cat');
    }


    public static function arreglo_editables() {
        //$editables=array(1,2,3,4);
        return self::where('editable',1)->orderby('nombre')->pluck('nombre','id_cat');
    }
    public static function arreglo_revisables() {
            $sql="select id_cat,nombre
                        from catalogos.cat_cat where id_cat in
                                                     (select id_cat from catalogos.cat_item where pendiente_revisar=1
                                                      group by 1 )
                        order by nombre";
            $datos = \DB::select(\DB::raw($sql));
            $arreglo=array();
            foreach($datos as $fila) {
                $arreglo[$fila->id_cat]=$fila->nombre;
            }
            return $arreglo;
    }

    public static function describir($id_cat) {
        if($id_cat <= 0) return "Sin Especificar";
        $existe = self::find($id_cat);
        if(empty($existe)) {
            return "Desconocido ($id_cat)";
        }
        else {
            return $existe->nombre;
        }
    }




}
