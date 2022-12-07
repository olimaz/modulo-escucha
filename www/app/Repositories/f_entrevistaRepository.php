<?php

namespace App\Repositories;

use App\Models\f_entrevista;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class f_entrevistaRepository
 * @package App\Repositories
 * @version May 27, 2020, 9:04 pm -05
 *
 * @method f_entrevista findWithoutFail($id, $columns = ['*'])
 * @method f_entrevista find($id, $columns = ['*'])
 * @method f_entrevista first($columns = ['*'])
*/
class f_entrevistaRepository extends BaseRepository
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
        'updated_at',
        'identificacion_consentimiento',
        'conceder_entrevista',
        'grabar_audio',
        'elaborar_informe',
        'tratamiento_datos_analizar',
        'tratamiento_datos_analizar_sensible',
        'tratamiento_datos_utilizar',
        'tratamiento_datos_utilizar_sensible',
        'tratamiento_datos_publicar',
        'insert_ent',
        'insert_ip',
        'insert_fh',
        'update_ent',
        'update_ip',
        'update_fh',
        'id_entrevista_etnica'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return f_entrevista::class;
    }
}
