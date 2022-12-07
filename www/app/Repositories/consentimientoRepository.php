<?php

namespace App\Repositories;

use App\Models\consentimiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class consentimientoRepository
 * @package App\Repositories
 * @version July 27, 2019, 6:56 pm -05
 *
 * @method consentimiento findWithoutFail($id, $columns = ['*'])
 * @method consentimiento find($id, $columns = ['*'])
 * @method consentimiento first($columns = ['*'])
*/
class consentimientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'fecha',
        'identificacion',
        'acuerdo_entrevista',
        'acuerdo_audio',
        'acuerdo_informe',
        'personales_analisis',
        'personales_informe',
        'personales_publicar',
        'sensibles_analisis',
        'sensibles_informe',
        'sensibles_publicar',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return consentimiento::class;
    }
}
