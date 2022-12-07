<?php

namespace App\Repositories;

use App\Models\marca_entrevista;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class marca_entrevistaRepository
 * @package App\Repositories
 * @version February 20, 2020, 12:47 am -05
 *
 * @method marca_entrevista findWithoutFail($id, $columns = ['*'])
 * @method marca_entrevista find($id, $columns = ['*'])
 * @method marca_entrevista first($columns = ['*'])
*/
class marca_entrevistaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_subserie',
        'id_entrevista',
        'id_entrevistador',
        'id_marca'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return marca_entrevista::class;
    }
}
