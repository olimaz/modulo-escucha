<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona_organizacion extends Model
{
    protected $table = "fichas.persona_organizacion";
    protected $primaryKey = "id_persona_organizacion";
    protected $fillable = ['nombre', 'rol', 'id_tipo_organizacion'];

    public function __construct($att=[]) {
        parent::__construct($att);
    }

    public function detalle() {
        return $this->belongsTo(cat_item::class, 'id_tipo_organizacion');
    }
    //AutoFill
    public static function listar_opciones_campo($campo,$criterio="") {
        $criterio=trim($criterio);
        $criterio = str_replace(" ","%",$criterio);
        $opciones= self::where($campo,'ilike',"%$criterio%")->distinct()->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }
}
