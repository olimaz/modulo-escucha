<?php

namespace App\Repositories;

use App\Models\entrevista_individual_tv;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individual_tvRepository
 * @package App\Repositories
 * @version April 17, 2019, 5:35 pm -05
 *
 * @method entrevista_individual_tv findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual_tv find($id, $columns = ['*'])
 * @method entrevista_individual_tv first($columns = ['*'])
*/
class entrevista_individual_tvRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_tv'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual_tv::class;
    }
}
