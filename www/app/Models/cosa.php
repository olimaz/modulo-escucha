<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class cosa
 * @package App\Models
 * @version September 18, 2019, 4:40 pm -05
 *
 * @property \App\Models\Catalogos.catItem idRemitido
 * @property \App\Models\Catalogos.catItem idSector
 * @property \App\Models\Catalogos.catItem idEtnico
 * @property integer id_subserie
 * @property integer id_entrevistador
 * @property integer entrevista_numero
 * @property string entrevista_codigo
 * @property integer entrevista_correlativo
 * @property integer id_macroterritorio
 * @property integer numero_entrevistador
 * @property integer hechos_lugar
 * @property string anotaciones
 * @property string seguimiento_revisado
 * @property integer seguimiento_finalizado
 * @property string metadatos_ce
 * @property string metadatos_ca
 * @property string metadatos_da
 * @property string metadatos_ac
 * @property integer entrevista_lugar
 * @property integer nna
 * @property string|\Carbon\Carbon entrevista_fecha
 * @property string|\Carbon\Carbon hechos_del
 * @property string|\Carbon\Carbon hechos_al
 * @property string|\Carbon\Carbon fh_insert
 * @property string|\Carbon\Carbon fh_update
 * @property integer id_territorio
 * @property string titulo
 * @property integer clasifica_nna
 * @property integer clasifica_sex
 * @property integer clasifica_res
 * @property integer clasifica_nivel
 * @property integer id_activo
 * @property integer id_prioritario
 * @property integer id_remitido
 * @property integer id_sector
 * @property integer id_etnico
 * @property string prioritario_tema
 */
class cosa extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt';
    protected $primaryKey = 'id_e_ind_fvt';
    
    public $timestamps = false;



    public $fillable = [
        'id_subserie',
        'id_entrevistador',
        'entrevista_numero',
        'entrevista_codigo',
        'entrevista_correlativo',
        'id_macroterritorio',
        'numero_entrevistador',
        'hechos_lugar',
        'anotaciones',
        'seguimiento_revisado',
        'seguimiento_finalizado',
        'metadatos_ce',
        'metadatos_ca',
        'metadatos_da',
        'metadatos_ac',
        'entrevista_lugar',
        'nna',
        'entrevista_fecha',
        'hechos_del',
        'hechos_al',
        'fh_insert',
        'fh_update',
        'id_territorio',
        'titulo',
        'clasifica_nna',
        'clasifica_sex',
        'clasifica_res',
        'clasifica_nivel',
        'id_activo',
        'id_prioritario',
        'id_remitido',
        'id_sector',
        'id_etnico',
        'prioritario_tema'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt' => 'integer',
        'id_subserie' => 'integer',
        'id_entrevistador' => 'integer',
        'entrevista_numero' => 'integer',
        'entrevista_codigo' => 'string',
        'entrevista_correlativo' => 'integer',
        'id_macroterritorio' => 'integer',
        'numero_entrevistador' => 'integer',
        'hechos_lugar' => 'integer',
        'anotaciones' => 'string',
        'seguimiento_revisado' => 'string',
        'seguimiento_finalizado' => 'integer',
        'metadatos_ce' => 'string',
        'metadatos_ca' => 'string',
        'metadatos_da' => 'string',
        'metadatos_ac' => 'string',
        'entrevista_lugar' => 'integer',
        'nna' => 'integer',

        'id_territorio' => 'integer',
        'titulo' => 'string',
        'clasifica_nna' => 'integer',
        'clasifica_sex' => 'integer',
        'clasifica_res' => 'integer',
        'clasifica_nivel' => 'integer',
        'id_activo' => 'integer',
        'id_prioritario' => 'integer',
        'id_remitido' => 'integer',
        'id_sector' => 'integer',
        'id_etnico' => 'integer',
        'prioritario_tema' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_e_ind_fvt' => 'required',
        'id_subserie' => 'required',
        'id_entrevistador' => 'required',
        'entrevista_numero' => 'required',
        'entrevista_codigo' => 'required',
        'entrevista_correlativo' => 'required',
        'id_macroterritorio' => 'required',
        'numero_entrevistador' => 'required',
        'seguimiento_finalizado' => 'required',
        'entrevista_lugar' => 'required'
    ];

    public function rel_id_entrevistador() {
        return $this->belongsto(entrevistador::class,'id_entrevistador','id_entrevistador');
    }

    public function getFmtIdEntrevistadorAttribute() {
        $quien = $this->rel_id_entrevistador;
        if($quien) {
            return "E# ".$quien->numero_entrevistador;
        }
        else {
            return "Desconocido";
        }
        //return "E#". entrevistador::find($this->id_entrevistador)->numero_entrevistador;
    }

    public function setIdEntrevistadorAttribute($val) {
        if($val <=0) {
            $val=null;
        }
        $this->attributes['id_entrevistador']=$val;

    }

    public function scopeIdEntrevistador($query, $criterio=0) {
        if($criterio>0) {
            $query->where('id_entrevistador',$criterio);
        }
    }

    public function scopeEntrevistaCodigo($query, $criterio='') {
        $criterio = trim($criterio);
        if(strlen($criterio)>0) {
            $query->where('entrevista_codigo','ilike',"%$criterio%");
        }
    }

    public  static function criterios_filtrado($request) {

        //
        $filtros = new \stdClass();
        $filtros->id_entrevistador=0;
        $filtros->entrevista_codigo='';
        //
        $filtros->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtros->id_entrevistador;
        $filtros->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtros->entrevista_codigo;


        return $filtros;
    }

    public static function scopeFiltrar($query,$filtros) {
        $query->identrevistador($filtros->id_entrevistador)
                ->entrevistacodigo($filtros->entrevista_codigo);
    }


}
