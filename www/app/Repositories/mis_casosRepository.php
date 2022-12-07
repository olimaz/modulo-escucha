<?php

namespace App\Repositories;

use App\Models\mis_casos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class mis_casosRepository
 * @package App\Repositories
 * @version June 12, 2020, 12:11 pm -05
 *
 * @method mis_casos findWithoutFail($id, $columns = ['*'])
 * @method mis_casos find($id, $columns = ['*'])
 * @method mis_casos first($columns = ['*'])
*/
class mis_casosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_macroterritorio',
        'id_territorio',
        'id_entrevistador',
        'entrevista_correlativo',
        'entrevista_numero',
        'entrevista_codigo',
        'nombre',
        'descripcion',
        'id_activo',
        'fts',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return mis_casos::class;
    }
}
