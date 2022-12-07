<?php

namespace App\Repositories;

use App\Models\adjunto;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class adjuntoRepository
 * @package App\Repositories
 * @version April 17, 2019, 5:25 pm -05
 *
 * @method adjunto findWithoutFail($id, $columns = ['*'])
 * @method adjunto find($id, $columns = ['*'])
 * @method adjunto first($columns = ['*'])
*/
class adjuntoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ubicacion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return adjunto::class;
    }
}
