<?php

namespace App\Repositories;

use App\Models\entrevista_individual_adjunto;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individual_adjuntoRepository
 * @package App\Repositories
 * @version April 17, 2019, 5:34 pm -05
 *
 * @method entrevista_individual_adjunto findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual_adjunto find($id, $columns = ['*'])
 * @method entrevista_individual_adjunto first($columns = ['*'])
*/
class entrevista_individual_adjuntoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_tipo',
        'id_adjunto',
        'id_e_ind_fvt'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual_adjunto::class;
    }
}
