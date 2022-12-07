<?php

namespace App\Repositories;

use App\Models\directorio_catalogo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class directorio_catalogoRepository
 * @package App\Repositories
 * @version December 10, 2019, 5:25 pm -05
 *
 * @method directorio_catalogo findWithoutFail($id, $columns = ['*'])
 * @method directorio_catalogo find($id, $columns = ['*'])
 * @method directorio_catalogo first($columns = ['*'])
*/
class directorio_catalogoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_catalogo',
        'tabla',
        'campo',
        'descripcion',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return directorio_catalogo::class;
    }
}
