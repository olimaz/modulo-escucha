<?php

namespace App\Repositories;

use App\Models\cat_cat;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class cat_catRepository
 * @package App\Repositories
 * @version April 15, 2019, 4:41 pm UTC
 *
 * @method cat_cat findWithoutFail($id, $columns = ['*'])
 * @method cat_cat find($id, $columns = ['*'])
 * @method cat_cat first($columns = ['*'])
*/
class cat_catRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'descripcion',
        'editable'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return cat_cat::class;
    }
}
