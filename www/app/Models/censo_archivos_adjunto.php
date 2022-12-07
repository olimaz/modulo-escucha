<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id_censo_archivos_adjunto
 * @property int $id_censo_archivos
 * @property int $id_adjunto
 * @property string $descripcion
 * @property string $fh_insert
 * @property string $codigo_adjunto
 * @property int $correlativo_caso
 * @property Esclarecimiento.censoArchivo $esclarecimiento.censoArchivo
 * @property Esclarecimiento.adjunto $esclarecimiento.adjunto
 */
class censo_archivos_adjunto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.censo_archivos_adjunto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_censo_archivos_adjunto';

    /**
     * @var array
     */
    protected $fillable = ['id_censo_archivos', 'id_adjunto', 'descripcion', 'fh_insert', 'codigo_adjunto', 'correlativo_caso'];

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
    public function rel_id_censo_archivos()
    {
        return $this->belongsTo(censo_archivos::class, 'id_censo_archivos', 'id_censo_archivos');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_adjunto()
    {
        return $this->belongsTo(adjunto::class, 'id_adjunto', 'id_adjunto');
    }


    public function getLinkAttribute() {
        $adjunto = $this->rel_id_adjunto;
        if($adjunto) {
            $nombre = $adjunto->nombre_ca;
            $nombre_descarga = $adjunto->nombre_descarga($nombre); //Le agrega el nombre original
            $ubica="public/".$adjunto->ubicacion;
            if(Storage::exists($ubica)) {
                $link = action('adjuntoController@show_ca',$adjunto->id_adjunto);
                $url = "<a target='_blank' href='".$link."'>$adjunto->nombre_original</a>";
            }
            else {
                $url = $nombre;
            }
        }
        else {
            $url = "Adjunto ($this->id_adjunto) no encontrado";
        }
        return $url;
    }
    //Para la edicion
    public function getNombreArchivoAttribute() {
        $existe=$this->rel_id_adjunto;
        if($existe) {
            return $existe->ubicacion;
        }
        else {
            return null;
        }
    }

    //Correlativo para el adjunto
    public function cual_toca() {
        $max=self::where('id_censo_archivos',$this->id_mis_casos)
            ->max('correlativo_caso');
        $nuevo=intval($max)+1;
        return $nuevo;
    }

    public function calcular_codigo() {
        if(intval($this->correlativo_caso) == 0) {
            $this->correlativo_caso = $this->cual_toca();
        }
        $e = $this->rel_id_censo_archivos;
        $codigo = $e->entrevista_codigo."-".str_pad($this->correlativo_caso,5,"0",STR_PAD_LEFT);
        return $codigo;
    }
}
