<?php

namespace App\Repositories;

use App\Models\entrevistador;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevistadorRepository
 * @package App\Repositories
 * @version April 12, 2019, 8:40 pm UTC
 *
 * @method entrevistador findWithoutFail($id, $columns = ['*'])
 * @method entrevistador find($id, $columns = ['*'])
 * @method entrevistador first($columns = ['*'])
*/
class entrevistadorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_territorial',
        'id_usuario',
        'numero_entrevistador',
        'id_ubicacion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevistador::class;
    }
}
