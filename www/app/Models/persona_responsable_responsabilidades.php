<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona_responsable_responsabilidades extends Model
{
    protected $table = "fichas.persona_responsable_responsabilidades";
    public $primaryKey = "id_persona_responsable_responsabilidades";

    protected $fillable = ['id_responsabilidad','id_hecho'];

    public function __construct(array $attr=[]) {
        parent::__construct($attr);
    }

    public function detalle() {
        return $this->belongsTo(cat_item::class, 'id_responsabilidad');
    }

  
}
