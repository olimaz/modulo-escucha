<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;

/**
 * Class mis_casos_adjunto_compartir
 * @package App\Models
 * @version September 26, 2020, 1:27 pm -05
 *
 * @property \App\Models\Esclarecimiento.misCasosAdjunto idMisCasosAdjunto
 * @property \App\Models\Esclarecimiento.entrevistador idAutorizador
 * @property \App\Models\Esclarecimiento.entrevistador idAutorizado
 * @property integer id_mis_casos_adjunto_compartir
 * @property integer id_mis_casos_adjunto
 * @property integer id_autorizador
 * @property integer id_autorizado
 * @property string anotaciones
 * @property integer id_situacion
 * @property string|\Carbon\Carbon fh_autorizado
 * @property string|\Carbon\Carbon fh_revocado
 */
class mis_casos_adjunto_compartir extends Model
{

    public $table = 'esclarecimiento.mis_casos_adjunto_compartir';
    protected $primaryKey = 'id_mis_casos_adjunto_compartir';
    
    public $timestamps = false;
    protected $dateFormat = 'Y-m-d H:i:s';




    public $fillable = [
        'id_mis_casos_adjunto_compartir',
        'id_mis_casos_adjunto',
        'id_autorizador',
        'id_autorizado',
        'anotaciones',
        'id_situacion',
        'fh_autorizado',
        'fh_revocado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_mis_casos_adjunto_compartir' => 'integer',
        'id_mis_casos_adjunto' => 'integer',
        'id_autorizador' => 'integer',
        'id_autorizado' => 'integer',
        'anotaciones' => 'string',
        'id_situacion' => 'integer',
        //'fh_autorizado' => 'datetime',
        //'fh_revocado' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_mis_casos_adjunto_compartir' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_mis_casos_adjunto()
    {
        return $this->belongsTo(mis_casos_adjunto::class, 'id_mis_casos_adjunto', 'id_mis_casos_adjunto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_autorizador()
    {
        return $this->belongsTo(entrevistador::class, 'id_autorizador','id_entrevistador');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_autorizado()
    {
        return $this->belongsTo(entrevistador::class, 'id_autorizado','id_entrevistador');
    }

    public function getFmtIdSituacionAttribute() {
        $texto = criterio_fijo::describir(11,$this->id_situacion);
        if($this->id_situacion==1) {
            $texto = "<span class='text-success'>$texto</span>";
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s.u",$this->fh_autorizado);
        }
        else {
            $texto = "<span class='text-danger'>$texto</span>";
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$this->fh_revocado);
        }
        $formato=$fecha->format("d-m-Y");
        $texto .=" ($formato)";
        return $texto;
    }
    public function getFmtIdAutorizadoAttribute() {
        $e = $this->rel_id_autorizado;
        $nombre= "Desconocido";
        if($e) {
            $nombre = $e->nombre;
        }
        return $nombre;
    }
    public function getFmtIdAutorizadorAttribute() {
        $e = $this->rel_id_autorizador;
        $nombre= "Desconocido";
        if($e) {
            $nombre = $e->nombre;
        }
        return $nombre;
    }

}
