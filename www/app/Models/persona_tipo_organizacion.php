<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona_tipo_organizacion extends Model
{
    protected $table = 'fichas.persona_tipo_organizacion';
    
    protected $primaryKey = 'id_persona_tipo_organizacion';

    protected $fillable = ['id_tipo_organizacion'];


    public function __construct($att=[]) {

        parent::__construct($att);
    }

    public function detalle() {
        return $this->belongsTo(cat_item::class, 'id_tipo_organizacion');
    }    
}
