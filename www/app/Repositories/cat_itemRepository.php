<?php

namespace App\Repositories;

use App\Models\cat_item;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class cat_itemRepository
 * @package App\Repositories
 * @version April 15, 2019, 4:40 pm UTC
 *
 * @method cat_item findWithoutFail($id, $columns = ['*'])
 * @method cat_item find($id, $columns = ['*'])
 * @method cat_item first($columns = ['*'])
*/
class cat_itemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_cat',
        'descripcion',
        'abreviado',
        'texto',
        'orden',
        'predeterminado',
        'otro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return cat_item::class;
    }
}
