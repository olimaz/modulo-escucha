<?php

namespace App\Repositories;

use App\Models\entrevista_individual_stc;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individual_stcRepository
 * @package App\Repositories
 * @version May 9, 2019, 6:54 pm -05
 *
 * @method entrevista_individual_stc findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual_stc find($id, $columns = ['*'])
 * @method entrevista_individual_stc first($columns = ['*'])
*/
class entrevista_individual_stcRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_stc'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual_stc::class;
    }
}
