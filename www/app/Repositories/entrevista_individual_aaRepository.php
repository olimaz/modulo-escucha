<?php

namespace App\Repositories;

use App\Models\entrevista_individual_aa;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individual_aaRepository
 * @package App\Repositories
 * @version May 9, 2019, 4:14 pm -05
 *
 * @method entrevista_individual_aa findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual_aa find($id, $columns = ['*'])
 * @method entrevista_individual_aa first($columns = ['*'])
*/
class entrevista_individual_aaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_aa'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual_aa::class;
    }
}
