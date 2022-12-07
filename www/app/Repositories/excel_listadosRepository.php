<?php

namespace App\Repositories;

use App\Models\excel_listados;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class excel_listadosRepository
 * @package App\Repositories
 * @version May 6, 2021, 2:50 pm -05
 *
 * @method excel_listados findWithoutFail($id, $columns = ['*'])
 * @method excel_listados find($id, $columns = ['*'])
 * @method excel_listados first($columns = ['*'])
*/
class excel_listadosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_entrevistador',
        'id_activo',
        'id_adjunto',
        'descripcion',
        'cantidad_codigos_si',
        'cantidad_codigos_no',
        'created_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return excel_listados::class;
    }
}
