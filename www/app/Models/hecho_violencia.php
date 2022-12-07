<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hecho_violencia
 * @property int $id_hecho
 * @property int $id_tipo_violencia
 * @property int $id_subtipo_violencia
 * @property int $id_lugar_salida
 * @property int $id_lugar_llegada
 * @property int $id_lugar_llegada_tipo
 * @property int $id_sentido_desplazamiento
 * @property int $id_tuvo_retorno_tipo
 * @property int $id_lugar_llegada_2
 * @property int $id_lugar_llegada_2_tipo
 * @property int $id_sentido_desplazamiento_2
 * @property string $otro_cual
 * @property int $cantidad_muertos
 * @property int $id_individual_colectiva
 * @property int $id_frente_otros
 * @property int $id_cometido_varios
 * @property int $id_hubo_embarazo
 * @property int $id_hubo_nacimiento
 * @property int $id_ind_fam_col
 * @property int $despojo_hectareas
 * @property int $despojo_recupero_tierras
 * @property int $despojo_recupero_derechos
 * @property int $id_tuvo_retorno
 * @property int $id_tuvo_otros_desplazamientos
 * @property string $created_at
 * @property Fichas.hecho $fichas.hecho
 * @property Catalogos.violencium $catalogos.violencium
 * @property Catalogos.violencium $catalogos.violencium
 * @property Catalogos.geo $catalogos.geo
 * @property Catalogos.geo $catalogos.geo
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.geo $catalogos.geo
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Fichas.hechoViolenciaMecanismo[] $fichas.hechoViolenciaMecanismos
 */
class hecho_violencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.hecho_violencia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho_violencia';

    /**
     * @var array
     */
    protected $fillable = ['id_hecho', 'id_tipo_violencia', 'id_subtipo_violencia', 'id_lugar_salida', 'id_lugar_llegada', 'id_lugar_llegada_tipo', 'id_sentido_desplazamiento', 'id_tuvo_retorno_tipo', 'id_lugar_llegada_2', 'id_lugar_llegada_2_tipo', 'id_sentido_desplazamiento_2', 'otro_cual', 'cantidad_muertos', 'id_individual_colectiva', 'id_frente_otros', 'id_cometido_varios', 'id_hubo_embarazo', 'id_hubo_nacimiento', 'id_ind_fam_col', 'despojo_hectareas', 'despojo_recupero_tierras', 'despojo_recupero_derechos', 'id_tuvo_retorno', 'id_tuvo_otros_desplazamientos', 'created_at'];

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
     * @return hecho
     */
    public function rel_id_hecho()
    {
        return $this->belongsTo(hecho::class, 'id_hecho', 'id_hecho');
    }

    /**
     * @return tipo_violencia
     */
    public function rel_id_tipo_violencia()
    {
        return $this->belongsTo(tipo_violencia::class, 'id_tipo_violencia', 'id_geo');
    }

    /**
     * @return tipo_violencia
     */
    public function rel_id_subtipo_violencia()
    {
        return $this->belongsTo(tipo_violencia::class, 'id_subtipo_violencia', 'id_geo');
    }

    /**
     * @return geo
     */
    public function rel_id_lugar_salida()
    {
        return $this->belongsTo(geo::class, 'id_lugar_salida', 'id_geo');
    }

    /**
     * @return \App\Models\geo
     */
    public function rel_id_lugar_llegada()
    {
        return $this->belongsTo(geo::class, 'id_lugar_llegada', 'id_geo');
    }

    /**
     * @return cat_item
     */
    public function rel_id_lugar_llegada_tipo()
    {
        return $this->belongsTo(cat_item::class, 'id_lugar_llegada_tipo', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_sentido_desplazamiento()
    {
        return $this->belongsTo(cat_item::class, 'id_sentido_desplazamiento', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_tuvo_retorno_tipo()
    {
        return $this->belongsTo(cat_item::class, 'id_tuvo_retorno_tipo', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_lugar_llegada_2()
    {
        return $this->belongsTo(geo::class, 'id_lugar_llegada_2', 'id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_lugar_llegada_2_tipo()
    {
        return $this->belongsTo(cat_item::class, 'id_lugar_llegada_2_tipo', 'id_item');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_id_sentido_desplazamiento_2()
    {
        return $this->belongsTo(cat_item::class, 'id_sentido_desplazamiento_2', 'id_item');
    }

    //Para los que tienen detalle, como la amenaza
    public function  rel_mecanismo() {
        return $this->hasMany(hecho_violencia_mecanismo::class,'id_hecho_violencia','id_hecho_violencia');
    }
    //Seters
    public function setDespojoHectareasAttribute($val) {
        $val=trim($val);
        $val=str_replace(",","",$val);
        $val=str_replace(".","",$val);
        $this->attributes['despojo_hectareas']=(integer)$val;
    }

    //Formatos
    public function getFmtIdTipoViolenciaAttribute() {
        return tipo_violencia::nombre_completo($this->id_tipo_violencia);
    }
    public function getFmtIdSubTipoViolenciaAttribute() {
        return tipo_violencia::nombrar($this->id_subtipo_violencia);
    }
    public function getFmtViolenciaAttribute() {

        $p[0]=tipo_violencia::nombrar($this->id_tipo_violencia);
        $p[1]=tipo_violencia::nombrar($this->id_subtipo_violencia);
        if($p[0]==$p[1]) {
            unset($p[1]);
        }
        return implode(": ",$p);

    }

    /*
     * Para evitar goles: setters
     */
    public function setIdLugarSalidaAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_lugar_salida']=$val;
    }
    public function setIdLugarLlegadaAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_lugar_llegada']=$val;
    }
    public function setIdLugarLlegadaTipoAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_lugar_llegada_tipo']=$val;
    }
    public function setIdSentidoDesplazamientoAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_sentido_desplazamiento']=$val;
    }
    public function setIdTuvoRetornoAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_tuvo_retorno']=$val;
    }
    public function setIdTuvoRetornoTipoAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_tuvo_retorno_tipo']=$val;
    }
    public function setIdLugarLlegada2Attribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_lugar_llegada_2']=$val;
    }
    public function setIdLugarLlegada2TipoAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_lugar_llegada_2_tipo']=$val;
    }
    public function setIdSentidoDesplazamiento2Attribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_sentido_desplazamiento_2']=$val;
    }
    public function setIdTuvoOtrosDesplazamientosAttribute($val) {
        $val  = $val > 0 ? $val : null;
        $this->attributes['id_tuvo_otros_desplazamientos']=$val;
    }
    // FIN de los setters


    //Para mostrar el detalle
    public function getDescripcionAttribute() {
        $n2=$this->rel_id_subtipo_violencia;
        $n1=tipo_violencia::find($n2->id_padre);  //Para evitar muladas

        $codigo = $n2->codigo;
        /*
        $nombre = '<dl class="dl-horizontal">';
        $nombre .="<dt>";
        $nombre .= $n1->descripcion;
        $nombre .="</dt>";

        if($n1->descripcion <> $n2->descripcion or true) {
            $nombre .="<dd>";
            $nombre .= $n2->descripcion;
            $nombre .="</dd>";
        }
        */



        $detalle="";

        if($codigo=='0502') {
            $detalle="<ul>";
            $detalle.="<li>Cantidad de muertos: $this->cantidad_muertos</li>";
            $detalle.="</ul>";
        }
        if($codigo=='0701') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_individual_colectiva);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $detalle.="<li>Tipo de amenaza</li>";
            $detalle.= $this->formato_mecanismo();
            $detalle.="</ul>";
        }
        if($codigo=='0801') {
            $detalle="<ul>";
            $detalle.="<li>Tipo de desaparición</li>";
            $detalle.= $this->formato_mecanismo();
            $detalle.="</ul>";
        }

        if(substr($codigo,0,2)=='09') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_individual_colectiva);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $si_no=criterio_fijo::describir(2,$this->id_frente_otros);
            $detalle.="<li>Tortura realizada frente a otros:<b>$si_no</b></li>";
            $detalle.="<li>Tipo de tortura</li>";
            $detalle.= $this->formato_mecanismo();
            $detalle.="</ul>";
        }
        if(substr($codigo,0,2)=='10') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_individual_colectiva);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $si_no=criterio_fijo::describir(2,$this->id_frente_otros);
            $detalle.="<li>Los hechos fueron realizados frente a otros: <b>$si_no</b></li>";
            $si_no=criterio_fijo::describir(2,$this->id_cometido_varios);
            $detalle.="<li>Los hechos fueron cometidos por varias personas: <b>$si_no</b></li>";

            if($codigo=='1001') {
                $si_no=criterio_fijo::describir(2,$this->id_hubo_embarazo);
                $detalle.="<li>¿Hubo embarazo como consecuencia de la violación sexual? <b>$si_no</b></li>";
            }

            if($codigo=='1001' || $codigo=='1002' ) {
                $si_no=criterio_fijo::describir(2,$this->id_hubo_nacimiento);
                $detalle.="<li>Si hubo embarazo, ¿nació el bebé? <b>$si_no</b></li>";
            }
            $detalle.= $this->formato_mecanismo();
            $detalle.="</ul>";
        }
        if($codigo=='1101') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_individual_colectiva);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $si_no=criterio_fijo::describir(2,$this->id_frente_otros);
            $detalle.="<li>Los hechos fueron realizados frente a otros: <b>$si_no</b></li>";
            $detalle.="</ul>";
        }

        if($codigo=='1201') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_individual_colectiva);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $si_no=criterio_fijo::describir(2,$this->id_frente_otros);
            $detalle.="<li>Los hechos fueron realizados frente a otros: <b>$si_no</b></li>";
            $detalle.="<li>Tipo de reclutamiento</li>";
            $detalle.= $this->formato_mecanismo();
            $detalle.="</ul>";
        }
        if($codigo=='1301') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_ind_fam_col);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $detalle.="</ul>";
        }
        if($codigo=='1401') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_ind_fam_col);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $si_no=criterio_fijo::describir(2,$this->id_frente_otros);
            $detalle.="<li>Los hechos fueron realizados frente a otros: <b>$si_no</b></li>";
            $detalle.="</ul>";
        }
        if($codigo=='1501') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_ind_fam_col);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $detalle.="</ul>";
        }
        if($codigo=='2001') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_ind_fam_col);
            $detalle.="<li>Los hechos fueron realizados de forma <b>$tipo</b></li>";
            $detalle.="<li>Modalidad del despojo</li>";
            $detalle.= $this->formato_mecanismo();

            $detalle.="<li>Hectáreas despojadas <b>$this->despojo_hectareas</b></li>";
            $si_no=criterio_fijo::describir(10,$this->despojo_recupero_tierras);
            $detalle.="<li>Recuperó sus tierras: <b>$si_no</b></li>";
            $si_no=criterio_fijo::describir(2,$this->despojo_recupero_derechos);
            $detalle.="<li>Recuperó sus derechos territoriales: <b>$si_no</b></li>";
            $detalle.="</ul>";
        }

        if($codigo=='2101') {
            $detalle="<ul>";
            $tipo=cat_item::describir($this->id_ind_fam_col);
            $detalle.="<li>Desplazamiento realizado de forma <b>$tipo</b></li>";

            $geo = geo::nombre_completo($this->id_lugar_salida);
            $detalle.="<li>Lugar de orígen: <b>$geo</b></li>";

            $geo = geo::nombre_completo($this->id_lugar_llegada);
            $detalle.="<li>Lugar de llegada: <b>$geo</b></li>";

            /*
            $tipo=cat_item::describir($this->id_lugar_llegada_tipo);
            $detalle.="<li>Tipo de lugar de llegada: <b>$tipo</b></li>";
            */

            $tipo=cat_item::describir($this->id_sentido_desplazamiento);
            $detalle.="<li>Sentido del desplazamiento: <b>$tipo</b></li>";

            if($this->id_lugar_llegada_2 > 0) {
                $geo = geo::nombre_completo($this->id_lugar_llegada_2);
                $detalle.="<li>Lugar de SEGUNDA llegada: <b>$geo</b></li>";

                $tipo=cat_item::describir($this->id_sentido_desplazamiento_2);
                $detalle.="<li>Sentido del desplazamiento: <b>$tipo</b></li>";
            }
            /*
            $si_no=criterio_fijo::describir(2,$this->id_tuvo_otros_desplazamientos);
            $detalle.="<li>Tuvo otros desplazamientos posteriores: <b>$si_no</b></li>";
            */

            $si_no=criterio_fijo::describir(2,$this->id_tuvo_retorno);
            $detalle.="<li>La persona ha tenido algún proceso de retorno: <b>$si_no</b></li>";
            if($this->id_tuvo_retorno_tipo > 0) {
                $tipo=cat_item::describir($this->id_tuvo_retorno_tipo);
                $detalle.="<li>Tipo de proceso de retorno: <b>$tipo</b></li>";
            }


            $detalle.="</ul>";
        }

        $nombre="<div class='row'>
                    <div class='text-right text-bold col-xs-4'>$n1->descripcion</div>
                    <div class='col-xs-8'>
                        $n2->descripcion
                        <br>
                        $detalle
                    </div>
                 </div>";


        //Unir
        $respuesta = new \stdClass();
        $respuesta->nombre = $nombre;
        $respuesta->detalle = $detalle;
        return $respuesta;
    }

    function formato_mecanismo() {
        $detalle="<ol>";
        foreach($this->rel_mecanismo as $mecanismo) {
            $txt = cat_item::describir($mecanismo->id_mecanismo);
            $detalle.="<li>$txt</li>";
        }
        $detalle.="</ol>";
        return $detalle;

    }

    function getFmtIdLugarSalidaAttribute() {
       return geo::nombre_completo($this->id_lugar_salida);
    }
    function getFmtIdLugarLlegadaAttribute() {
        return geo::nombre_completo($this->id_lugar_llegada);
    }



}
