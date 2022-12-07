<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class entrevistador_acceso extends Model
{
    //
    public $table = 'esclarecimiento.entrevistador_acceso';
    protected $primaryKey = 'id_entrevistador_acceso';

    public $timestamps = false;



    public $fillable = [
        'id_entrevistador',
        'id_grupo_acceso',
        'id_nivel',
        ];

    public function rel_id_grupo_acceso() {
        return $this->belongsTo(criterio_fijo::class,'id_grupo_acceso','id_opcion')->where('criterio_fijo.id_grupo',5);
    }
    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
    }

    public function getFmtIdGrupoAccesoAttribute() {
        $item = $this->rel_id_grupo_acceso;
        if($item) {
            return $item->descripcion;
        }
        else {
            return "Grupo ($this->id_grupo_acceso) no encontrado.";
        }
    }


}
