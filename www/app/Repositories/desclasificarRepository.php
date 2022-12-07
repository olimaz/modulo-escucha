<?php

namespace App\Repositories;

use App\Models\desclasificar;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class desclasificarRepository
 * @package App\Repositories
 * @version March 17, 2020, 6:26 pm -05
 *
 * @method desclasificar findWithoutFail($id, $columns = ['*'])
 * @method desclasificar find($id, $columns = ['*'])
 * @method desclasificar first($columns = ['*'])
*/
class desclasificarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_autorizador',
        'id_autorizado',
        'id_subserie',
        'id_primaria',
        'fh_insert',
        'id_activo',
        'id_denegador',
        'fh_update',
        'fh_del',
        'fh_al',
        'id_adjunto'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return desclasificar::class;
    }
}
