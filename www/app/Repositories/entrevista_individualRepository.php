<?php

namespace App\Repositories;

use App\Models\entrevista_individual;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_individualRepository
 * @package App\Repositories
 * @version April 17, 2019, 5:33 pm -05
 *
 * @method entrevista_individual findWithoutFail($id, $columns = ['*'])
 * @method entrevista_individual find($id, $columns = ['*'])
 * @method entrevista_individual first($columns = ['*'])
*/
class entrevista_individualRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_subserie',
        'id_entrevistador',
        'entrevista_numero',
        'entrevista_codigo',
        'entrevista_correlativo',
        'id_macroterritorio',
        'entrevista_fecha',
        'numero_entrevistador',
        'hechos_del',
        'hechos_al',
        'hechos_lugar',
        'anotaciones',
        'seguimiento_revisado',
        'seguimiento_finalizado',
        'metadatos_ce',
        'metadatos_ca',
        'metadatos_da',
        'metadatos_ac',
        'entrevista_lugar',
        'nna'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_individual::class;
    }
}
