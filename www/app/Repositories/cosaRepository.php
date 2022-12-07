<?php

namespace App\Repositories;

use App\Models\cosa;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class cosaRepository
 * @package App\Repositories
 * @version September 18, 2019, 4:40 pm -05
 *
 * @method cosa findWithoutFail($id, $columns = ['*'])
 * @method cosa find($id, $columns = ['*'])
 * @method cosa first($columns = ['*'])
*/
class cosaRepository extends BaseRepository
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
        'numero_entrevistador',
        'hechos_lugar',
        'anotaciones',
        'seguimiento_revisado',
        'seguimiento_finalizado',
        'metadatos_ce',
        'metadatos_ca',
        'metadatos_da',
        'metadatos_ac',
        'entrevista_lugar',
        'nna',
        'entrevista_fecha',
        'hechos_del',
        'hechos_al',
        'fh_insert',
        'fh_update',
        'id_territorio',
        'titulo',
        'clasifica_nna',
        'clasifica_sex',
        'clasifica_res',
        'clasifica_nivel',
        'id_activo',
        'id_prioritario',
        'id_remitido',
        'id_sector',
        'id_etnico',
        'prioritario_tema'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return cosa::class;
    }
}
