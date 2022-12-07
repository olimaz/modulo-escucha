<?php

namespace App\Repositories;

use App\Models\victima;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class victimaRepository
 * @package App\Repositories
 * @version July 27, 2019, 6:53 pm -05
 *
 * @method victima findWithoutFail($id, $columns = ['*'])
 * @method victima find($id, $columns = ['*'])
 * @method victima first($columns = ['*'])
*/
class victimaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'es_declarante',
        'id_declarante',
        'nombres',
        'apellidos',
        'otros_nombres',
        'nacimiento_fecha',
        'nacimiento_lugar',
        'sexo',
        'orientacion_sexual',
        'identidad_genero',
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
        return victima::class;
    }
}
