<?php

namespace App\Repositories;

use App\Models\entrevista_individual_tc;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individual_tcRepository
 * @package App\Repositories
 * @version May 9, 2019, 4:15 pm -05
 *
 * @method entrevista_individual_tc findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual_tc find($id, $columns = ['*'])
 * @method entrevista_individual_tc first($columns = ['*'])
*/
class entrevista_individual_tcRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_tc'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual_tc::class;
    }
}
