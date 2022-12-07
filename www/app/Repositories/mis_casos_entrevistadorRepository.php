<?php

namespace App\Repositories;

use App\Models\mis_casos_entrevistador;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class mis_casos_entrevistadorRepository
 * @package App\Repositories
 * @version August 4, 2020, 9:38 pm -05
 *
 * @method mis_casos_entrevistador findWithoutFail($id, $columns = ['*'])
 * @method mis_casos_entrevistador find($id, $columns = ['*'])
 * @method mis_casos_entrevistador first($columns = ['*'])
*/
class mis_casos_entrevistadorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_mis_casos',
        'id_entrevistador',
        'id_perfil',
        'fh_insert'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return mis_casos_entrevistador::class;
    }
}
