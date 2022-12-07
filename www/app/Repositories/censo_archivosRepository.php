<?php

namespace App\Repositories;

use App\Models\censo_archivos;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class censo_archivosRepository
 * @package App\Repositories
 * @version February 18, 2021, 8:30 pm -05
 *
 * @method censo_archivos findWithoutFail($id, $columns = ['*'])
 * @method censo_archivos find($id, $columns = ['*'])
 * @method censo_archivos first($columns = ['*'])
*/
class censo_archivosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_tipo',
        'custodio',
        'direccion',
        'id_geo',
        'contacto_correo',
        'contacto_telefono',
        'contacto_url',
        'archivo_fisico',
        'archivo_fisico_volumen',
        'archivo_fisico_ubicacion',
        'archivo_electronico',
        'archivo_electronico_volumen',
        'archivo_electronico_ubicacion',
        'archivo_virtual',
        'archivo_virtual_volumen',
        'archivo_virutal_ubicacion',
        'acceso_publico',
        'acceso_publico_volumen',
        'acceso_publico_descripcion',
        'acceso_clasificado',
        'acceso_clasificado_volumen',
        'acceso_clasificado_descripcion',
        'acceso_reservado',
        'acceso_reservado_volumen',
        'acceso_reservado_descripcion',
        'anotaciones',
        'ficha_diligenciada_nombre',
        'ficha_diligenciada_telefono',
        'ficha_diligenciada_correo',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return censo_archivos::class;
    }
}
