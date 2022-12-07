<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use mysql_xdevapi\Exception;

/**
 * Class mis_casos_persona
 * @package App\Models
 * @version June 15, 2020, 8:35 pm -05
 *
 * @property \App\Models\Esclarecimiento.misCaso idMisCasos
 * @property integer id_mis_casos
 * @property string nombre
 * @property integer id_sexo
 * @property string contacto
 * @property integer id_contactado
 * @property integer id_entrevistado
 * @property integer id_subserie
 * @property integer id_entrevista
 * @property string anotaciones
 * @property string entrevista_fecha_hora
 * @property string|\Carbon\Carbon fh_insert
 * @property string|\Carbon\Carbon fh_update
 */
class mis_casos_persona extends Model
{

    public $table = 'esclarecimiento.mis_casos_persona';
    
    public $timestamps = false;



    protected $primaryKey = 'id_mis_casos_persona';

    public $fillable = [
        'id_mis_casos',
        'nombre',
        'id_sexo',
        'contacto',
        'id_contactado',
        'id_entrevistado',
        'id_subserie',
        'id_entrevista',
        'anotaciones',
        'entrevista_fecha_hora',
        'fh_update'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_mis_casos_persona' => 'integer',
        'id_mis_casos' => 'integer',
        'nombre' => 'string',
        'id_sexo' => 'integer',
        'contacto' => 'string',
        'id_contactado' => 'integer',
        'id_entrevistado' => 'integer',
        'id_subserie' => 'integer',
        'id_entrevista' => 'integer',
        'anotaciones' => 'string',
        'entrevista_fecha_hora' => 'datetime',
        //'fh_insert' => 'datetime',
        //'fh_update' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_mis_casos' => 'required',
        'nombre' => 'required'
    ];

    //public $dates = ['created_at', 'updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_mis_casos()
    {
        return $this->belongsTo(mis_casos::class, 'id_mis_casos','id_mis_casos');
    }
    public function rel_id_sexo() {
        return $this->belongsTo(cat_item::class,'id_sexo','id_item');
    }
    public function getFmtIdSexoAttribute() {
        return cat_item::describir($this->id_sexo);
    }
    public function getFmtEntrevistaAttribute() {
        if(is_null($this->id_subserie)) {
            return null;
        }
        else {
            $e = enlace::buscar_llaves($this->id_subserie, $this->id_entrevista);
            if($e->e) {
                $url = "<a href='$e->link_show'>$e->codigo</a>";
                //$url = $e->link_show;
                return $url;
            }
            else {
                return null;
            }
        }
    }

    //Para procesar el post
    public function buscar_codigo($codigo=null) {
        if(strlen($codigo)>=12) {
            $entrevista = enlace::buscar_codigo($codigo);  //devuelve false si no lo encuentra
            return $entrevista;
        }
        else {
            return false;
        }
    }
    //Para el formulario de edicion
    public function getCodigoAttribute() {
        $codigo=null;
        if($this->id_subserie>0) {
            $entrevista = enlace::buscar_llaves($this->id_subserie, $this->id_entrevista);
            $codigo = $entrevista->codigo;
        }
        return $codigo;
    }

    //Para procesar el request
    public static function procesar_fecha_hora($request) {
        $fecha_hora = null;
        //Fecha y hora de entrevista
        if(!is_null($request->entrevista_fecha_submit)) {
            $hora = is_null($request->entrevista_hora_submit) ? '00:00' : $request->entrevista_hora_submit;
            $fecha = $request->entrevista_fecha_submit;
            try {
                $fecha_hora = Carbon::createFromFormat("Y-m-d H:i",$fecha." ".$hora);
            }
            catch (Exception $e) {
                Log::debug("Error en fecha_hora de mis_casos_personas ".json_encode($request->all()));
            }
        }
        return $fecha_hora;
    }

    //Formatos
    public function getFmtEntrevistaFechaHoraAttribute() {
        if(is_null($this->entrevista_fecha_hora)) {
            return "-";
        }
        else {
            return $this->entrevista_fecha_hora->formatlocalized("%a %d-%b-%Y %l:%M %p");
        }
    }
    public function getEditarFechaAttribute() {
        if(is_null($this->entrevista_fecha_hora)) {
            return null;
        }
        else {
            return $this->entrevista_fecha_hora->format("Y-m-d");
        }
    }
    public function getEditarHoraAttribute() {
        if(is_null($this->entrevista_fecha_hora)) {
            return null;
        }
        else {
            return $this->entrevista_fecha_hora->format("H:i");
        }
    }
}
