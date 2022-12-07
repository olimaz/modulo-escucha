<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona_aut_etnico_ter extends Model
{
    protected $table = "fichas.persona_aut_etnico_ter";

    protected $primaryKey = "id_persona_aut_etnico_ter";

    protected $fillable = ['id_aut_etnico_ter'];

    public function __construct($att = []) {
        parent::__construct($att);
    }

    public function detalle() {
        return $this->belongsTo(cat_item::class, 'id_aut_etnico_ter');
    }
}
