<?php

namespace App\Repositories;

use App\Models\censo_archivos_permisos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class censo_archivos_permisosRepository
 * @package App\Repositories
 * @version June 14, 2021, 1:16 pm -05
 *
 * @method censo_archivos_permisos findWithoutFail($id, $columns = ['*'])
 * @method censo_archivos_permisos find($id, $columns = ['*'])
 * @method censo_archivos_permisos first($columns = ['*'])
*/
class censo_archivos_permisosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_censo_archivos',
        'id_entrevistador',
        'id_perfil',
        'fh_insert'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return censo_archivos_permisos::class;
    }
}
