<?php

namespace App\Repositories;

use App\Models\nna_seguridad;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class nna_seguridadRepository
 * @package App\Repositories
 * @version July 9, 2019, 11:08 pm -05
 *
 * @method nna_seguridad findWithoutFail($id, $columns = ['*'])
 * @method nna_seguridad find($id, $columns = ['*'])
 * @method nna_seguridad first($columns = ['*'])
*/
class nna_seguridadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_nna_vulnerabilidad',
        'id_entrevistador',
        'id_macroterritorio',
        'id_territorio',
        'correlativo',
        'codigo',
        'dictamen',
        'fecha_evaluacion',
        'id_quien_refiere',
        'id_quien_refiere_otro',
        'revisar_proceso',
        'firma_consentimiento',
        'existe_entidad',
        'lugar_privado',
        'alguien_acompana',
        'alguien_acompana_padre',
        'alguien_acompana_ts',
        'alguien_acompana_otro',
        'apoyo_identificado',
        'informado_presencia',
        'entrevista_cierre',
        'entrevista_cierre_porque',
        'entrevista_seguimiento',
        'observaciones',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return nna_seguridad::class;
    }
}
