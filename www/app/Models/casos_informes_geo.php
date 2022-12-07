<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_casos_informes_geo
 * @property int $id_casos_informes
 * @property int $id_geo
 * @property int $insert_id_entrevistador
 * @property string $insert_fh
 * @property Esclarecimiento.casosInforme $esclarecimiento.casosInforme
 * @property Catalogos.geo $catalogos.geo
 * @property Esclarecimiento.entrevistador $esclarecimiento.entrevistador
 */
class casos_informes_geo extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.casos_informes_geo';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_casos_informes_geo';

    /**
     * @var array
     */
    protected $fillable = ['id_casos_informes', 'id_geo', 'insert_id_entrevistador', 'insert_fh'];

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
     * @return \App\Models\casos_informes
     */
    public function rel_id_casos_informes()
    {
        return $this->belongsTo(casos_informes::class, 'id_casos_informes', 'id_casos_informes');
    }

    /**
     * @return \App\Models\geo
     */
    public function rel_id_geo()
    {
        return $this->belongsTo(geo::class, 'id_geo', 'id_geo');
    }

    /**
     * @return \App\Models\entrevistador
     */
    public function rel_insert_id_entrevistador()
    {
        return $this->belongsTo(entrevistador::class, 'insert_id_entrevistador', 'id_entrevistador');
    }


    //Getter
    public function getFmtIdGeoAttribute() {
        return geo::nombre_completo($this->id_geo);
    }
}
