<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona_discapacidad extends Model
{
    protected $table = "fichas.persona_discapacidad";
    public $primaryKey = "id_persona_discapacidad";

    protected $fillable = ['id_discapacidad'];

    public function __construct(array $attr=[]) {
        parent::__construct($attr);
    }


    public function detalle() {
        return $this->belongsTo(cat_item::class, 'id_discapacidad');
    }
}
