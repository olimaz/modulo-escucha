<?php

namespace App\Repositories;

use App\Models\responsable;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class responsableRepository
 * @package App\Repositories
 * @version July 27, 2019, 6:53 pm -05
 *
 * @method responsable findWithoutFail($id, $columns = ['*'])
 * @method responsable find($id, $columns = ['*'])
 * @method responsable first($columns = ['*'])
*/
class responsableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'nombres',
        'apellidos',
        'otros_nombres',
        'sexo',
        'id_edad',
        'pertenencia_etnico_racial',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return responsable::class;
    }
}
