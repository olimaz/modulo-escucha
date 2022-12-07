<?php

namespace App\Repositories;

use App\Models\casos_informes_interes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class casos_informes_interesRepository
 * @package App\Repositories
 * @version May 13, 2019, 2:39 pm -05
 *
 * @method casos_informes_interes findWithoutFail($id, $columns = ['*'])
 * @method casos_informes_interes find($id, $columns = ['*'])
 * @method casos_informes_interes first($columns = ['*'])
*/
class casos_informes_interesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_casos_informes',
        'id_interes'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return casos_informes_interes::class;
    }
}
