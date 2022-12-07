<?php

namespace App\Models;
use \App\Models\entrevista;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_entrevista_testigo
 * @property int $id_entrevista
 * @property string $nombre
 * @property string $contacto
 * @property string $created_at
 * @property string $updated_at
 * @property Fichas.entrevistum $fichas.entrevistum
 */
class entrevista_testigo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fichas.entrevista_testigo';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_entrevista_testigo';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'nombre', 'contacto', 'created_at', 'updated_at'];

    public static $rules = [
        //'id_e_ind_fvt' => 'required',
        'nombre' => 'max:200',
        'contacto' => 'max:200'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_entrevista()
    {
        return $this->belongsTo(entrevista::class, 'id_entrevista', 'id_entrevista');
    }
}
