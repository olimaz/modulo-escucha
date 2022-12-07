<?php

namespace App\Repositories;

use App\Models\traza_actividad;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class traza_actividadRepository
 * @package App\Repositories
 * @version July 11, 2019, 10:30 pm -05
 *
 * @method traza_actividad findWithoutFail($id, $columns = ['*'])
 * @method traza_actividad find($id, $columns = ['*'])
 * @method traza_actividad first($columns = ['*'])
*/
class traza_actividadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fecha_hora',
        'id_usuario',
        'id_accion',
        'id_objeto',
        'referencia',
        'codigo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return traza_actividad::class;
    }
}
