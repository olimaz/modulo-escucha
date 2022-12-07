<?php

namespace App\Repositories;

use App\Models\mis_casos_adjunto_compartir;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class mis_casos_adjunto_compartirRepository
 * @package App\Repositories
 * @version September 26, 2020, 1:27 pm -05
 *
 * @method mis_casos_adjunto_compartir findWithoutFail($id, $columns = ['*'])
 * @method mis_casos_adjunto_compartir find($id, $columns = ['*'])
 * @method mis_casos_adjunto_compartir first($columns = ['*'])
*/
class mis_casos_adjunto_compartirRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_mis_casos_adjunto_compartir',
        'id_mis_casos_adjunto',
        'id_autorizador',
        'id_autorizado',
        'anotaciones',
        'id_situacion',
        'fh_autorizado',
        'fh_revocado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return mis_casos_adjunto_compartir::class;
    }
}
