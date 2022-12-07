<?php

namespace App\Repositories;

use App\Models\diagnostico_comunitario;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class diagnostico_comunitarioRepository
 * @package App\Repositories
 * @version July 31, 2019, 10:52 am -05
 *
 * @method diagnostico_comunitario findWithoutFail($id, $columns = ['*'])
 * @method diagnostico_comunitario find($id, $columns = ['*'])
 * @method diagnostico_comunitario first($columns = ['*'])
*/
class diagnostico_comunitarioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_macroterritorio',
        'id_territorio',
        'id_entrevistador',
        'numero_entrevistador',
        'entrevista_codigo',
        'entrevista_correlativo',
        'entrevista_numero',
        'entrevista_lugar',
        'entrevista_fecha',
        'equipo_facilitador',
        'equipo_relator',
        'equipo_memorista',
        'equipo_otros',
        'tema_comunidad',
        'tema_objetivo',
        'tema_del',
        'tema_al',
        'tema_lugar',
        'cantidad_participantes',
        'id_sector',
        'tema_dinamica',
        'observaciones',
        'clasificacion_nna',
        'clasificacion_sex',
        'clasificacion_res',
        'clasificacion_nivel',
        'id_usuario',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return diagnostico_comunitario::class;
    }
}
