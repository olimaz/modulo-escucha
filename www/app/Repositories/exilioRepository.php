<?php

namespace App\Repositories;

use App\Models\exilio;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class exilioRepository
 * @package App\Repositories
 * @version October 21, 2019, 7:23 pm -05
 *
 * @method exilio findWithoutFail($id, $columns = ['*'])
 * @method exilio find($id, $columns = ['*'])
 * @method exilio first($columns = ['*'])
*/
class exilioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_tipo',
        'id_ha_tenido_retorno',
        'entidad_apoyo_retorno',
        'id_ha_tenido_ayuda',
        'institucion_ayuda',
        'id_retorno',
        'id_otro_exilio',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return exilio::class;
    }
}
