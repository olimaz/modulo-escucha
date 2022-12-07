<?php

namespace App\Repositories;

use App\Models\entrevista_colectiva;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_colectivaRepository
 * @package App\Repositories
 * @version July 31, 2019, 10:50 am -05
 *
 * @method entrevista_colectiva findWithoutFail($id, $columns = ['*'])
 * @method entrevista_colectiva find($id, $columns = ['*'])
 * @method entrevista_colectiva first($columns = ['*'])
*/
class entrevista_colectivaRepository extends BaseRepository
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
        'equipo_memorista',
        'equipo_otros',
        'tema_descripcion',
        'tema_objetivo',
        'tema_del',
        'tema_al',
        'tema_lugar',
        'cantidad_participantes',
        'id_sector',
        'eventos_descripcion',
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
        return entrevista_colectiva::class;
    }
}
