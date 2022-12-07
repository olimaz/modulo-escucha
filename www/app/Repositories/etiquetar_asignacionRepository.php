<?php

namespace App\Repositories;

use App\Models\etiquetar_asignacion;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class etiquetar_asignacionRepository
 * @package App\Repositories
 * @version February 10, 2020, 11:56 am -05
 *
 * @method etiquetar_asignacion findWithoutFail($id, $columns = ['*'])
 * @method etiquetar_asignacion find($id, $columns = ['*'])
 * @method etiquetar_asignacion first($columns = ['*'])
*/
class etiquetar_asignacionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_e_ind_fvt',
        'id_entrevista_profundidad',
        'id_entrevista_colectiva',
        'id_entrevista_etnica',
        'id_diagnostico_comunitario',
        'id_historia_vida',
        'id_autoriza',
        'id_transcriptor',
        'id_situacion',
        'id_causa',
        'urgente',
        'observaciones',
        'fh_asignado',
        'fh_revocado',
        'fh_transcrito',
        'fh_anulado',
        'fh_inicio',
        'fh_fin',
        'terceros',
        'duracion_etiquetado_minutos',
        'duracion_etiquetado_real_minutos',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return etiquetar_asignacion::class;
    }
}
