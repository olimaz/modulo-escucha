<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class relacion_victima extends Model
{
    protected $table = "fichas.per_ent_rel_victima";
    protected $primaryKey = "id_per_ent_rel_victima";
    protected $fillable = ['id_rel_victima'];

    public function __construct($att = []) {
        parent::__construct($att);
    }

    public function detalle() {
        return $this->belongsTo(cat_item::class, 'id_rel_victima');
    }

}