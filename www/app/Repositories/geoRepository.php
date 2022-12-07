<?php

namespace App\Repositories;

use App\Models\geo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class geoRepository
 * @package App\Repositories
 * @version April 15, 2019, 4:41 pm UTC
 *
 * @method geo findWithoutFail($id, $columns = ['*'])
 * @method geo find($id, $columns = ['*'])
 * @method geo first($columns = ['*'])
*/
class geoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_padre',
        'nivel',
        'descripcion',
        'id_tipo',
        'codigo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return geo::class;
    }
}
