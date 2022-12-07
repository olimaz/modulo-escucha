<?php

namespace App\Repositories;

use App\Models\entrevista;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class entrevistaRepository
 * @package App\Repositories
 * @version September 20, 2019, 3:55 pm -05
 *
 * @method entrevista findWithoutFail($id, $columns = ['*'])
 * @method entrevista find($id, $columns = ['*'])
 * @method entrevista first($columns = ['*'])
*/
class entrevistaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_idioma',
        'id_nativo',
        'nombre_interprete',
        'documentacion_aporta',
        'documentacion_especificar',
        'identifica_testigos',
        'ampliar_relato',
        'ampliar_relato_temas',
        'priorizar_entrevista',
        'priorizar_entrevista_asuntos',
        'contiene_patrones',
        'contiene_patrones_cuales',
        'indicaciones_transcripcion',
        'observaciones',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return entrevista::class;
    }
}
