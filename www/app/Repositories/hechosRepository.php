<?php

namespace App\Repositories;

use App\Models\hechos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class hechosRepository
 * @package App\Repositories
 * @version July 27, 2019, 6:54 pm -05
 *
 * @method hechos findWithoutFail($id, $columns = ['*'])
 * @method hechos find($id, $columns = ['*'])
 * @method hechos first($columns = ['*'])
*/
class hechosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_entrevista',
        'hechos_fecha',
        'hechos_lugar',
        'hechos_sitio',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return hechos::class;
    }
}
