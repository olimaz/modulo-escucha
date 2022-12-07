<?php

namespace App\Repositories;

use App\Models\persona;
use App\Models\victima;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class personaRepository
 * @package App\Repositories
 * @version September 24, 2019, 4:54 pm -05
 *
 * @method persona findWithoutFail($id, $columns = ['*'])
 * @method persona find($id, $columns = ['*'])
 * @method persona first($columns = ['*'])
*/
class personaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'es_victima',
        'es_testigo',
        'nombre',
        'apellido',
        'alias',
        'fec_nac_a',
        'fec_nac_m',
        'fec_nac_d',
        'id_lugar_nacimiento',
        'id_sexo',
        'id_orientacion',
        'id_identidad',
        'id_etnia',
        'id_tipo_documento',
        'num_documento',
        'id_nacionalidad',
        'id_estado_civil',
        'id_lugar_residencia',
        'telefono',
        'correo_electronico',
        'id_zona',
        'id_edu_formal',
        'profesion',
        'ocupacion_actual',
        'cargo_publico',
        'cargo_publico_cual',
        'id_fuerza_publica_estado',
        'id_fuerza_publica',
        'id_actor_armado',
        'organizacion_colectivo',
        'nombre_organizacion',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return persona::class;
    }
}
