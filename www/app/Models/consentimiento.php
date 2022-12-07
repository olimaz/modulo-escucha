<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class consentimiento
 * @package App\Models
 * @version July 27, 2019, 6:56 pm -05
 *
 * @property \App\Models\Esclarecimiento.eIndFvt idEIndFvt
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property \Illuminate\Database\Eloquent\Collection 
 * @property integer id_e_ind_fvt
 * @property string|\Carbon\Carbon fecha
 * @property string identificacion
 * @property integer acuerdo_entrevista
 * @property integer acuerdo_audio
 * @property integer acuerdo_informe
 * @property integer personales_analisis
 * @property integer personales_informe
 * @property integer personales_publicar
 * @property integer sensibles_analisis
 * @property integer sensibles_informe
 * @property integer sensibles_publicar
 * @property integer id_usuario
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class consentimiento extends Model
{

    public $table = 'demo.consentimiento';
    protected $primaryKey = 'id_consentimiento';

    public $timestamps = true;




    public $fillable = [
        'id_e_ind_fvt',
        'fecha',
        'identificacion',
        'acuerdo_entrevista',
        'acuerdo_audio',
        'acuerdo_informe',
        'personales_analisis',
        'personales_informe',
        'personales_publicar',
        'sensibles_analisis',
        'sensibles_informe',
        'sensibles_publicar',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_consentimiento' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'fecha' => 'datetime',
        'identificacion' => 'string',
        'acuerdo_entrevista' => 'integer',
        'acuerdo_audio' => 'integer',
        'acuerdo_informe' => 'integer',
        'personales_analisis' => 'integer',
        'personales_informe' => 'integer',
        'personales_publicar' => 'integer',
        'sensibles_analisis' => 'integer',
        'sensibles_informe' => 'integer',
        'sensibles_publicar' => 'integer',
        'id_usuario' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id_consentimiento' => 'required',
        'id_e_ind_fvt' => 'required',
        'fecha' => 'required',
        'identificacion' => 'required',
        'acuerdo_entrevista' => 'required',
        'acuerdo_audio' => 'required',
        'acuerdo_informe' => 'required',
        'personales_analisis' => 'required',
        'personales_informe' => 'required',
        'personales_publicar' => 'required',
        'sensibles_analisis' => 'required',
        'sensibles_informe' => 'required',
        'sensibles_publicar' => 'required',
        'id_usuario' => 'required'
    ];


}
