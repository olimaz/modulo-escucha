<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class f_entrevista
 * @package App\Models
 * @version May 27, 2020, 9:04 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \App\Models\Catalogos.catItem idioma
 * @property \App\Models\Catalogos.catItem idNativo
 * @property \App\Models\Esclarecimiento.entrevistaEtnica idEntrevistaEtnica
 * @property \Illuminate\Database\Eloquent\Collection catalogos.catItem2s
 * @property \Illuminate\Database\Eloquent\Collection fichas.entrevistaTestigos
 * @property integer id_e_ind_fvt
 * @property integer id_idioma
 * @property integer id_nativo
 * @property string nombre_interprete
 * @property integer documentacion_aporta
 * @property string documentacion_especificar
 * @property integer identifica_testigos
 * @property integer ampliar_relato
 * @property string ampliar_relato_temas
 * @property integer priorizar_entrevista
 * @property string priorizar_entrevista_asuntos
 * @property integer contiene_patrones
 * @property string contiene_patrones_cuales
 * @property string indicaciones_transcripcion
 * @property string observaciones
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property string identificacion_consentimiento
 * @property integer conceder_entrevista
 * @property integer grabar_audio
 * @property integer elaborar_informe
 * @property integer tratamiento_datos_analizar
 * @property integer tratamiento_datos_analizar_sensible
 * @property integer tratamiento_datos_utilizar
 * @property integer tratamiento_datos_utilizar_sensible
 * @property integer tratamiento_datos_publicar
 * @property integer insert_ent
 * @property string insert_ip
 * @property string|\Carbon\Carbon insert_fh
 * @property integer update_ent
 * @property string update_ip
 * @property string|\Carbon\Carbon update_fh
 * @property integer id_entrevista_etnica
 */
class f_entrevista extends Model
{

    public $table = 'fichas.entrevista';
    
    public $timestamps = false;



    protected $primaryKey = 'id_entrevista';

    public $fillable = [
        'id_e_ind_fvt',
        'id_idioma',
        'id_nativo',
        'nombre_interprete',
        'documentacion_aporta',
        'documentacion_especificar',
        'identifica_testigos',
        'ampliar_relato',
        'ampliar_relato_temas',
        'priorizar_entrevista',
        'priorizar_entrevista_asuntos',
        'contiene_patrones',
        'contiene_patrones_cuales',
        'indicaciones_transcripcion',
        'observaciones',
        'created_at',
        'updated_at',
        'identificacion_consentimiento',
        'conceder_entrevista',
        'grabar_audio',
        'elaborar_informe',
        'tratamiento_datos_analizar',
        'tratamiento_datos_analizar_sensible',
        'tratamiento_datos_utilizar',
        'tratamiento_datos_utilizar_sensible',
        'tratamiento_datos_publicar',
        'insert_ent',
        'insert_ip',
        'insert_fh',
        'update_ent',
        'update_ip',
        'update_fh',
        'id_entrevista_etnica'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_entrevista' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_idioma' => 'integer',
        'id_nativo' => 'integer',
        'nombre_interprete' => 'string',
        'documentacion_aporta' => 'integer',
        'documentacion_especificar' => 'string',
        'identifica_testigos' => 'integer',
        'ampliar_relato' => 'integer',
        'ampliar_relato_temas' => 'string',
        'priorizar_entrevista' => 'integer',
        'priorizar_entrevista_asuntos' => 'string',
        'contiene_patrones' => 'integer',
        'contiene_patrones_cuales' => 'string',
        'indicaciones_transcripcion' => 'string',
        'observaciones' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'identificacion_consentimiento' => 'string',
        'conceder_entrevista' => 'integer',
        'grabar_audio' => 'integer',
        'elaborar_informe' => 'integer',
        'tratamiento_datos_analizar' => 'integer',
        'tratamiento_datos_analizar_sensible' => 'integer',
        'tratamiento_datos_utilizar' => 'integer',
        'tratamiento_datos_utilizar_sensible' => 'integer',
        'tratamiento_datos_publicar' => 'integer',
        'insert_ent' => 'integer',
        'insert_ip' => 'string',
        'insert_fh' => 'datetime',
        'update_ent' => 'integer',
        'update_ip' => 'string',
        'update_fh' => 'datetime',
        'id_entrevista_etnica' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        /*
        'id_idioma' => 'required',
        'documentacion_aporta' => 'required',
        'identifica_testigos' => 'required',
        'ampliar_relato' => 'required',
        'priorizar_entrevista' => 'required',
        'contiene_patrones' => 'required',
        'conceder_entrevista' => 'required',
        'grabar_audio' => 'required',
        'elaborar_informe' => 'required',
        'tratamiento_datos_analizar' => 'required',
        'tratamiento_datos_analizar_sensible' => 'required',
        'tratamiento_datos_utilizar' => 'required',
        'tratamiento_datos_utilizar_sensible' => 'required',
        'tratamiento_datos_publicar' => 'required'
        */
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_ent_ind_fvt()
    {
        return $this->belongsTo(entrevista_individual::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_idioma()
    {
        return $this->belongsTo(cat_item::class, 'id_idioma','id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function id_nativo()
    {
        return $this->belongsTo(cat_item::class, 'id_nativo','id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_entrevista_etnica()
    {
        return $this->belongsTo(entrevista_etnica::class, 'id_entrevista_etnica', 'id_entrevista_etnica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function rel_entrevista_condiciones()
    {
        return $this->hasMany(entrevista_condiciones::class, 'id_entrevista','id_entrevista');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function rel_entrevsita_testigo()
    {
        return $this->hasMany(entrevista_testigo::class, 'id_entrevista', 'id_entrevista');
    }
}
