<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_mis_casos_blog
 * @property int $id_mis_casos
 * @property int $id_blog
 * @property string $fh_insert
 * @property Esclarecimiento.misCaso $esclarecimiento.misCaso
 * @property Esclarecimiento.blog $esclarecimiento.blog
 */
class mis_casos_blog extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.mis_casos_blog';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_mis_casos_blog';

    /**
     * @var array
     */
    protected $fillable = ['id_mis_casos', 'id_blog', 'fh_insert'];

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
    public function rel_id_mis_casos()
    {
        return $this->belongsTo(mis_casos::class, 'id_mis_casos', 'id_mis_casos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_blog()
    {
        return $this->belongsTo(blog::class, 'id_blog', 'id_blog');
    }
}
