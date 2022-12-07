<?php

namespace App\Repositories;

use App\Models\acceso_edicion;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class acceso_edicionRepository
 * @package App\Repositories
 * @version February 19, 2020, 4:40 pm -05
 *
 * @method acceso_edicion findWithoutFail($id, $columns = ['*'])
 * @method acceso_edicion find($id, $columns = ['*'])
 * @method acceso_edicion first($columns = ['*'])
*/
class acceso_edicionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_entrevista',
        'id_subserie',
        'id_autoriza',
        'id_autorizado',
        'observaciones',
        'id_situacion',
        'id_revocado',
        'fh_autorizado',
        'fh_revocado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return acceso_edicion::class;
    }
}
