<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class traza_catalogo
 * @package App\Models
 * @version December 10, 2019, 5:17 pm -05
 *


 * @property integer id_directorio_catalogo
 * @property integer id_entrevistador
 * @property integer valor_anterior
 * @property integer valor_nuevo
 * @property string|\Carbon\Carbon created_at
 */
class traza_catalogo extends Model
{

    public $table = 'traza_catalogo';

    public $timestamps = false;

    protected $primaryKey = 'id_traza_catalogo';

    public $fillable = [
        'id_directorio_catalogo',
        'id_entrevistador',
        'valor_anterior',
        'valor_nuevo',
        'created_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_traza_catalogo' => 'integer',
        'id_directorio_catalogo' => 'integer',
        'id_entrevistador' => 'integer',
        'valor_anterior' => 'integer',
        'valor_nuevo' => 'integer',
        'created_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    // public static $rules = [
    //     'id_traza_catalogo' => 'required',
    //     'id_directorio_catalogo' => 'required',
    //     'id_entrevistador' => 'required',
    //     'valor_anterior' => 'required',
    //     'valor_nuevo' => 'required',
    //     'created_at' => 'required'
    // ];


}
