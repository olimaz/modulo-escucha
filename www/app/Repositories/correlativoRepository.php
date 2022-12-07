<?php

namespace App\Repositories;

use App\Models\correlativo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class correlativoRepository
 * @package App\Repositories
 * @version April 17, 2019, 5:18 pm -05
 *
 * @method correlativo findWithoutFail($id, $columns = ['*'])
 * @method correlativo find($id, $columns = ['*'])
 * @method correlativo first($columns = ['*'])
*/
class correlativoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_subserie',
        'correlativo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return correlativo::class;
    }
}
