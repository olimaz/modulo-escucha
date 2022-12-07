<?php

namespace App\Repositories;

use App\Models\entrevista_etnica;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevista_etnicaRepository
 * @package App\Repositories
 * @version October 6, 2019, 2:30 pm -05
 *
 * @method entrevista_etnica findWithoutFail($id, $columns = ['*'])
 * @method entrevista_etnica find($id, $columns = ['*'])
 * @method entrevista_etnica first($columns = ['*'])
*/
class entrevista_etnicaRepository extends BaseRepository
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
        'updated_at',
        'entrevista_fecha_inicio',
        'entrevista_fecha_final',
        'entrevista_avance',
        'titulo',
        'duracion_entrevista_minutos'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista_etnica::class;
    }
}
