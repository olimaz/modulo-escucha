<?php

namespace App\Repositories;

use App\Models\casos_informes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class casos_informesRepository
 * @package App\Repositories
 * @version May 13, 2019, 2:38 pm -05
 *
 * @method casos_informes findWithoutFail($id, $columns = ['*'])
 * @method casos_informes find($id, $columns = ['*'])
 * @method casos_informes first($columns = ['*'])
*/
class casos_informesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'correlativo',
        'codigo',
        'id_entrevistador',
        'id_macroterritorio',
        'registro_fecha',
        'recepcion_fecha',
        'titulo',
        'autor',
        'descripcion',
        'id_tipo_soporte',
        'contenido_texto',
        'contenido_audiovisual',
        'contenido_fotografia',
        'contenido_sonoro',
        'contenido_base_datos',
        'contenido_otros',
        'contenido_volumen',
        'remitente_nombre',
        'remitente_organizacion',
        'remitente_id_tipo_organizacion',
        'remitente_correo',
        'remitente_telefono',
        'remitente_cedula',
        'entrega_id_geo',
        'entrega_lugar',
        'entrega_id_consentimiento',
        'entrega_id_tratamiento',
        'receptor_nombre',
        'receptor_id_area',
        'receptor_almacenaje',
        'receptor_anotaciones',
        'caracterizacion_fecha_caracterizacion',
        'caracterizacion_id_tipo',
        'caracterizacion_fecha_elaboracion',
        'caracterizacion_fecha_publicacion',
        'caracterizacion_temporalidad',
        'caracterizacion_cobertura',
        'caracterizacion_sectores',
        'fh_insert',
        'fh_update'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return casos_informes::class;
    }
}
