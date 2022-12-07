<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class documento
 * @package App\Models
 * @version May 2, 2019, 2:42 pm -05
 *
 * @property \App\Models\Catalogos.catItem idObjetivo
 * @property \App\Models\Catalogos.catItem idInstrumento
 * @property \App\Models\Esclarecimiento.adjunto idAdjunto
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_objetivo
 * @property integer id_instrumento
 * @property integer orden
 * @property string descripcion
 * @property integer id_adjunto
 * @property string|\Carbon\Carbon fh_insert
 * @property string|\Carbon\Carbon fh_update
 */
class documento extends Model
{

    public $table = 'catalogos.documento';
    protected $primaryKey = 'id_documento';
    
    public $timestamps = false;



    public $fillable = [
        'id_objetivo',
        'id_instrumento',
        'id_adjunto',
        'orden',
        'descripcion',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_documento' => 'integer',
        'id_objetivo' => 'integer',
        'id_instrumento' => 'integer',
        'orden' => 'integer',
        'descripcion' => 'string',
        'id_adjunto' => 'integer',
        'fh_insert' => 'datetime',
        'fh_update' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_objetivo' => 'required',
        'id_instrumento' => 'required',
        'descripcion' => 'required',
    ];

    public function rel_id_objetivo() {
        return $this->belongsTo(cat_item::class,'id_objetivo','id_item');
    }
    public function rel_id_instrumento() {
        return $this->belongsTo(cat_item::class,'id_instrumento','id_item');
    }
    public function rel_id_adjunto() {
        return $this->belongsTo(adjunto::class,'id_adjunto','id_adjunto');
    }


    public function getFmtIdObjetivoAttribute() {
        $existe = $this->rel_id_objetivo;
        if($existe) {
            return $existe->descripcion;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtIdInstrumentoAttribute() {
        $existe = $this->rel_id_instrumento;
        if($existe) {
            return $existe->descripcion;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtUrlAttribute() {
        $existe = $this->rel_id_adjunto;
        if($existe) {
            return $existe->url_descarga_guia($this->descripcion);
        }
        else {
            return "Archivo de referencia no disponible";
        }
    }

    //Para la edición, el nombre del archivo
    public function getNombreArchivoAttribute() {
        $existe=$this->rel_id_adjunto;
        if($existe) {
            return $existe->ubicacion;
        }
        else {
            return null;
        }
    }


    public static function scopeOrdenar($query) {
        $query->join('catalogos.cat_item as oo','catalogos.documento.id_objetivo','=','oo.id_item')
                ->join('catalogos.cat_item as oi','catalogos.documento.id_instrumento','=','oi.id_item')
                ->orderby('oo.orden')
                ->orderby('oo.descripcion')
                ->orderby('oi.orden')
                ->orderby('oi.descripcion')
                ->orderby('catalogos.documento.orden')
                ->select('documento.*');
    }

    public static function scopeObjetivo($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_objetivo',$criterio);
        }
    }
    public static function scopeInstrumento($query, $criterio=-1) {
        if($criterio>0) {
            $query->where('id_instrumento',$criterio);
        }
    }
    public static function scopeDescripcion($query, $criterio=-1) {
        $criterio=trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('documento.descripcion','ilike',"%$criterio%");
        }
    }

    public static function scopeFiltrar($query, $criterios=null) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }
        $query->objetivo($criterios->id_objetivo)
            ->instrumento($criterios->id_instrumento)
            ->descripcion($criterios->descripcion);
    }

    public static function filtros_default($request = null) {
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->id_objetivo = -1;
        $filtro->id_instrumento = -1;
        $filtro->descripcion = null;

        //valores por GET
        $filtro->id_objetivo = isset($request->id_objetivo) ? $request->id_objetivo : $filtro->id_objetivo;
        $filtro->id_instrumento = isset($request->id_instrumento) ? $request->id_instrumento : $filtro->id_instrumento;
        $filtro->descripcion = isset($request->descripcion) ? $request->descripcion : $filtro->descripcion;


        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            $url = $request->fullUrl();
            $pedazos = explode("?",$url);
            if(isset($pedazos[1])) {
                $filtro->url = $pedazos[1]."&";

            }
            else {
                $filtro->url="";
            }
        }

        return $filtro;
    }


}
