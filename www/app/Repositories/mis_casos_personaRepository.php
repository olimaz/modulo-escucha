<?php

namespace App\Repositories;

use App\Models\mis_casos_persona;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class mis_casos_personaRepository
 * @package App\Repositories
 * @version June 15, 2020, 8:35 pm -05
 *
 * @method mis_casos_persona findWithoutFail($id, $columns = ['*'])
 * @method mis_casos_persona find($id, $columns = ['*'])
 * @method mis_casos_persona first($columns = ['*'])
*/
class mis_casos_personaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_mis_casos',
        'nombre',
        'id_sexo',
        'contacto',
        'id_contactado',
        'id_entrevistado',
        'id_subserie',
        'id_entrevista',
        'anotaciones',
        'fh_insert',
        'fh_update'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return mis_casos_persona::class;
    }
}
