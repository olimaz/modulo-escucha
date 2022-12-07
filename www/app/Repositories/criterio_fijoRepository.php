<?php

namespace App\Repositories;

use App\Models\criterio_fijo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class criterio_fijoRepository
 * @package App\Repositories
 * @version April 15, 2019, 4:41 pm UTC
 *
 * @method criterio_fijo findWithoutFail($id, $columns = ['*'])
 * @method criterio_fijo find($id, $columns = ['*'])
 * @method criterio_fijo first($columns = ['*'])
*/
class criterio_fijoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_grupo',
        'id_opcion',
        'descripcion',
        'orden'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return criterio_fijo::class;
    }
}
