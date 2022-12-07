<?php

namespace App\Repositories;

use App\Models\traza_catalogo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class traza_catalogoRepository
 * @package App\Repositories
 * @version December 10, 2019, 5:17 pm -05
 *
 * @method traza_catalogo findWithoutFail($id, $columns = ['*'])
 * @method traza_catalogo find($id, $columns = ['*'])
 * @method traza_catalogo first($columns = ['*'])
*/
class traza_catalogoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_directorio_catalogo',
        'id_entrevistador',
        'valor_anterior',
        'valor_nuevo',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return traza_catalogo::class;
    }
}
