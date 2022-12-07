<?php

namespace App\Repositories;

use App\Models\entrevista_individual_fr;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individual_frRepository
 * @package App\Repositories
 * @version April 17, 2019, 5:34 pm -05
 *
 * @method entrevista_individual_fr findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual_fr find($id, $columns = ['*'])
 * @method entrevista_individual_fr first($columns = ['*'])
*/
class entrevista_individual_frRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_fr'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual_fr::class;
    }
}
