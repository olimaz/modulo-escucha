<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class victima_duplicada extends Model
{
    protected $table = "fichas.victima_duplicada";
    public $primaryKey = "id_victima_duplicada";

    protected $fillable = ['id_victima', 'id_e_inv_fvt_nueva', 'id_e_inv_fvt_existente', 'estado'];

    public function __construct($att=[])
    {
        parent::__construct($att);
    }

    public function rel_victima() {
        return $this->belongsTo(victima::class, 'id_victima');
    }

}
