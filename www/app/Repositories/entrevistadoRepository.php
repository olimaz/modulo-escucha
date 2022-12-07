<?php

namespace App\Repositories;

use App\Models\entrevistado;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevistadoRepository
 * @package App\Repositories
 * @version July 27, 2019, 6:53 pm -05
 *
 * @method entrevistado findWithoutFail($id, $columns = ['*'])
 * @method entrevistado find($id, $columns = ['*'])
 * @method entrevistado first($columns = ['*'])
*/
class entrevistadoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_entrevista',
        'es_victima',
        'es_testigo',
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
        return entrevistado::class;
    }
}
