<?php

namespace App\Repositories;

use App\Models\transcribir_asignacion;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class transcribir_asignacionRepository
 * @package App\Repositories
 * @version September 3, 2019, 5:20 pm -05
 *
 * @method transcribir_asignacion findWithoutFail($id, $columns = ['*'])
 * @method transcribir_asignacion find($id, $columns = ['*'])
 * @method transcribir_asignacion first($columns = ['*'])
*/
class transcribir_asignacionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_autoriza',
        'id_transcriptor',
        'id_situacion',
        'observaciones',
        'fh_asignado',
        'fh_revocado',
        'fh_transcrito',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return transcribir_asignacion::class;
    }
}
