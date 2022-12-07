<?php

namespace App\Repositories;

use App\Models\blog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class blogRepository
 * @package App\Repositories
 * @version June 19, 2020, 12:24 pm -05
 *
 * @method blog findWithoutFail($id, $columns = ['*'])
 * @method blog find($id, $columns = ['*'])
 * @method blog first($columns = ['*'])
*/
class blogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id_entrevistador',
        'fecha_hora',
        'titulo',
        'html',
        'texto',
        'id_activo',
        'id_blog_respondido',
        'fh_update'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return blog::class;
    }
}
