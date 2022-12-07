<?php

namespace App\Repositories;

use App\Models\documento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class documentoRepository
 * @package App\Repositories
 * @version May 2, 2019, 2:42 pm -05
 *
 * @method documento findWithoutFail($id, $columns = ['*'])
 * @method documento find($id, $columns = ['*'])
 * @method documento first($columns = ['*'])
*/
class documentoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_objetivo',
        'id_instrumento',
        'orden',
        'descripcion',
        'id_adjunto',
        'fh_insert',
        'fh_update'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return documento::class;
    }
}
