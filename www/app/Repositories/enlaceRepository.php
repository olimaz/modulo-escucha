<?php

namespace App\Repositories;

use App\Models\enlace;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class enlaceRepository
 * @package App\Repositories
 * @version June 2, 2020, 1:52 pm -05
 *
 * @method enlace findWithoutFail($id, $columns = ['*'])
 * @method enlace find($id, $columns = ['*'])
 * @method enlace first($columns = ['*'])
*/
class enlaceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_subserie',
        'id_primaria',
        'id_subserie_e',
        'id_primaria_e',
        'id_tipo',
        'id_entrevistador',
        'anotaciones',
        'id_activo',
        'fh_insert'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return enlace::class;
    }
}
