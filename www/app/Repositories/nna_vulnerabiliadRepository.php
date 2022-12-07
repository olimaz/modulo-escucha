<?php

namespace App\Repositories;

use App\Models\nna_vulnerabiliad;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class nna_vulnerabiliadRepository
 * @package App\Repositories
 * @version July 9, 2019, 5:04 pm -05
 *
 * @method nna_vulnerabiliad findWithoutFail($id, $columns = ['*'])
 * @method nna_vulnerabiliad find($id, $columns = ['*'])
 * @method nna_vulnerabiliad first($columns = ['*'])
*/
class nna_vulnerabiliadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_entrevistador',
        'correlativo',
        'nombres',
        'apellidos',
        'edad',
        'menor_12',
        'vive_familia',
        'vive_padre_madre',
        'vive_rep_legal',
        'vive_familia_extensa',
        'vive_con',
        'pariticipa_familia',
        'pariticipa_comunidad',
        'escuela_asiste',
        'escuela_nombre',
        'escuela_grado',
        'escuela_problemas',
        'escuela_progreso',
        'abuso_exposicion',
        'abuso_fisico',
        'abuso_sexual',
        'abuso_abandono',
        'abuso_ajustes',
        'comunidad_conocimiento',
        'comunidad_mensajes',
        'comunidad_reuniones',
        'comunidad_apoyo',
        'fecha_entrevista',
        'observaciones',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return nna_vulnerabiliad::class;
    }
}
