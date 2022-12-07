<?php

namespace App\Repositories;

use App\Models\entrevista_profundidad;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_profundidadRepository
 * @package App\Repositories
 * @version July 31, 2019, 10:51 am -05
 *
 * @method entrevista_profundidad findWithoutFail($id, $columns = ['*'])
 * @method entrevista_profundidad find($id, $columns = ['*'])
 * @method entrevista_profundidad first($columns = ['*'])
*/
class entrevista_profundidadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_macroterritorio',
        'id_territorio',
        'id_entrevistador',
        'numero_entrevistador',
        'entrevista_codigo',
        'entrevista_correlativo',
        'entrevista_numero',
        'entrevista_lugar',
        'entrevista_fecha',
        'entrevista_objetivo',
        'entrevistado_nombres',
        'entrevistado_apellidos',
        'id_sector',
        'observaciones',
        'clasificacion_nna',
        'clasificacion_sex',
        'clasificacion_res',
        'clasificacion_nivel',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_profundidad::class;
    }
}
