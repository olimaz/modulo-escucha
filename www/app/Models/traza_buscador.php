<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_traza_buscador
 * @property int $id_entrevistador
 * @property string $texto_buscado
 * @property string $id_tipo
 */
class traza_buscador extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'traza_buscador';
    protected $primaryKey = 'id_traza_buscador';

    /**
     * @var array
     */
    protected $fillable = ['id_traza_buscador', 'id_entrevistador', 'texto_buscado','id_tipo'];

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if(\Auth::check()) {
            $this->attributes['id_entrevistador']=\Auth::user()->id_entrevistador;
        }
        else {
            $this->attributes['id_entrevistador']=-1;
        }

    }

    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
    }

    public function getFmtIdTipoAttribute() {
        $tipo[1]="Texto";
        $tipo[2]="Tesauro";
        $tipo[3]="Marca";
        return isset($tipo[$this->id_tipo]) ? $tipo[$this->id_tipo] : "Desconocido";
    }

    public function getFmtCriterioAttribute() {
        if($this->id_tipo == 1) {
            return $this->texto_buscado;
        }
        elseif($this->id_tipo==2) {
            $pedazos = explode(" ",$this->texto_buscado);
            $codigo=$pedazos[0];
            $tes = tesauro::where('codigo','=',$codigo)->orderby('id_activo')->first();
            if($tes) {
                return $codigo." ".tesauro::nombre_completo($tes->id_geo);
            }
            else {
                return "Desconocido: $codigo";
            }
        }
        elseif($this->id_tipo==3){
            $texto= trim($this->texto_buscado);
            if(strlen($texto)>0) {
                $arreglo = explode(",",$this->texto_buscado);
                if(count($arreglo) > 0) {
                    //dd($arreglo);
                    $existe = marca::wherein('id_marca',$arreglo)->pluck('texto')->toArray();
                    return implode("; ",$existe);
                }
            }


            return "Desconocido: ($this->texto_buscado)";


        }
        else {
            return "Tipo desconocido: $this->id_tipo";
        }
    }



}
