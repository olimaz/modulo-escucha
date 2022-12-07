<?php

namespace App\Repositories;

use App\Models\historia_vida;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class historia_vidaRepository
 * @package App\Repositories
 * @version July 31, 2019, 10:51 am -05
 *
 * @method historia_vida findWithoutFail($id, $columns = ['*'])
 * @method historia_vida find($id, $columns = ['*'])
 * @method historia_vida first($columns = ['*'])
*/
class historia_vidaRepository extends BaseRepository
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
        'entrevistado_otros_nombres',
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
        return historia_vida::class;
    }
}
