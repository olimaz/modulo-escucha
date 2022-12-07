<?php

namespace App\Repositories;

use App\Models\hecho;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class hechoRepository
 * @package App\Repositories
 * @version October 13, 2019, 2:05 pm -05
 *
 * @method hecho findWithoutFail($id, $columns = ['*'])
 * @method hecho find($id, $columns = ['*'])
 * @method hecho first($columns = ['*'])
*/
class hechoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_lugar',
        'sitio_especifico',
        'id_lugar_tipo',
        'fecha_ocurencia_d',
        'fecha_ocurencia_m',
        'fecha_ocurencia_a',
        'fecha_fin_d',
        'fecha_fin_m',
        'fecha_fin_a',
        'aun_continuan',
        'observaciones',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return hecho::class;
    }
}
