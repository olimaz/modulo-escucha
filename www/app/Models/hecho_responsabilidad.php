<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_hecho_responsabilidad
 * @property int $id_hecho
 * @property int $aa_id_tipo
 * @property int $aa_id_subtipo
 * @property int $tc_id_tipo
 * @property int $tc_id_subtipo
 * @property string $aa_nombre_grupo
 * @property string $aa_bloque
 * @property string $aa_frente
 * @property string $aa_unidad
 * @property string $tc_detalle
 * @property string $aa_otro_cual
 * @property string $tc_otro_cual
 * @property string $otro_actor_cual
 * @property string $created_at
 * @property Fichas.hecho $fichas.hecho
 * @property Catalogos.aa $catalogos.aa
 * @property Catalogos.aa $catalogos.aa
 * @property Catalogos.aa $catalogos.aa
 * @property Catalogos.aa $catalogos.aa
 */
class hecho_responsabilidad extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.hecho_responsabilidad';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho_responsabilidad';

    /**
     * @var array
     */
    protected $fillable = ['id_hecho', 'aa_id_tipo', 'aa_id_subtipo', 'tc_id_tipo', 'tc_id_subtipo', 'aa_nombre_grupo', 'aa_bloque', 'aa_frente', 'aa_unidad', 'tc_detalle', 'aa_otro_cual', 'tc_otro_cual', 'otro_actor_cual', 'created_at'];

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
    public function rel_id_hecho()
    {
        return $this->belongsTo(hecho::class, 'id_hecho', 'id_hecho');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_aa_id_tipo()
    {
        return $this->belongsTo(tipo_aa::class, 'aa_id_tipo', 'id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_aa_id_subtipo()
    {
        return $this->belongsTo(tipo_aa::class, 'aa_id_subtipo', 'id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_tc_id_tipo()
    {
        return $this->belongsTo(tipo_tc::class, 'tc_id_tipo', 'id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rel_tc_id_subtipo()
    {
        return $this->belongsTo(tipo_tc::class, 'tc_id_subtipo', 'id_geo');
    }

    public function getFmtResponsabilidadAttribute() {
        $str="xx";
        if($this->aa_id_subtipo > 0) {
            $str = tipo_aa::nombre_completo($this->aa_id_subtipo);
            if(strlen($this->aa_otro_cual)>0) {
                $str.=" ($this->aa_otro_cual)";
            }
        }
        if($this->tc_id_subtipo > 0) {
            $str = tipo_tc::nombre_completo($this->tc_id_subtipo);
            if(strlen($this->tc_otro_cual)>0) {
                $str.= "($this->tc_otro_cual)";
            }
        }
        if(strlen($this->tc_otro_cual)>0) {
            $str.= "($this->otro_actor_cual)";
        }
        return $str;
    }

    //Para diligenciar las fichas, muestra el detalle según se agrega
    //Para mostrar el detalle
    public function getDescripcionAttribute() {

        // Actores Armados
        if(!empty($this->aa_id_subtipo)) {
            $n2 = tipo_aa::find($this->aa_id_subtipo);
            $n1 = tipo_aa::find($n2->id_padre);  //Para evitar muladas
            $codigo = $n2->codigo;

            // Nombre del grupo especificado
            $nombre="<div class='row'>
                    <div class='text-right text-bold col-xs-6'>$n1->descripcion</div>
                    <div class='col-xs-6'>$n2->descripcion</div>
                 </div>";

            //Detalle del grupo especificado
            $detalle="";

            if($codigo=='0101') {
                $detalle="<ul>";
                $detalle.="<li>Grupo: $this->aa_nombre_grupo</li>";
                $detalle.="<li>Bloque: $this->aa_bloque</li>";
                $detalle.="<li>Frente: $this->aa_frente</li>";
                $detalle.="<li>Otra unidad: $this->aa_unidad</li>";
                $detalle.="</ul>";
            }
            elseif($codigo=='0201' || $codigo == "0202") {
                $detalle="<ul>";
                $detalle.="<li>Bloque: $this->aa_bloque</li>";
                $detalle.="<li>Frente: $this->aa_frente</li>";
                $detalle.="<li>Otra unidad: $this->aa_unidad</li>";
                $detalle.="</ul>";
            }
            elseif($codigo=='0203') {
                $detalle="<ul>";
                $detalle.="<li>¿Cuál?: $this->aa_otro_cual</li>";
                $detalle.="</ul>";
            }
            elseif(substr($codigo,0,2)=='03') {
                $detalle="<ul>";
                $detalle.="<li>¿Cuál?: $this->aa_nombre_grupo</li>";
                $detalle.="<li>Detalle unidad: $this->aa_unidad</li>";
                $detalle.="</ul>";
            }
            elseif(substr($codigo,0,2)=='04') {
                $detalle="<ul>";
                $detalle.="<li>¿Cuál?: $this->aa_otro_cual</li>";
                if($this->aa_unidad) {
                    $detalle.="<li>Detalle unidad: $this->aa_unidad</li>";
                }

                $detalle.="</ul>";
            }
            elseif($codigo=='0501') {

                if($this->aa_unidad) {
                    $detalle="<ul>";
                    $detalle.="<li>Detalle unidad: $this->aa_unidad</li>";
                    $detalle.="</ul>";
                }
                else {
                    $detalle="Sin información adicional.";
                }


            }
            //Unir y devolver respuesta
            $respuesta = new \stdClass();
            $respuesta->nombre = $nombre;
            $respuesta->detalle = $detalle;
            return $respuesta;
        }



        //Terceros civiles
        if(!empty($this->tc_id_subtipo)) {
            $n2 = tipo_tc::find($this->tc_id_subtipo);
            $n1 = tipo_tc::find($n2->id_padre);  //Para evitar muladas
            $codigo = $n2->codigo;

            // Nombre del grupo especificado
            $nombre="<div class='row'>
                    <div class='text-right text-bold col-xs-6'>$n1->descripcion</div>
                    <div class='col-xs-6'>$n2->descripcion</div>
                 </div>";

            //Detalle del grupo especificado
            $detalle="";
            if($codigo=='0107' || $codigo=='0205' || $codigo=='0303') {
                $detalle="<ul>";
                $detalle.="<li>¿Cuál?: $this->tc_otro_cual</li>";
                $detalle.="<li>Detalle: $this->tc_detalle</li>";
                $detalle.="</ul>";
            }
            elseif($codigo=='0401') {
                $detalle="<ul>";
                $detalle.="<li>¿Cuál?: $this->otro_actor_cual</li>";
                $detalle.="</ul>";
            }
            else {
                $detalle="<ul>";
                $detalle.="<li>Detalle: $this->tc_detalle</li>";
                $detalle.="</ul>";
            }

            //Unir y devolver respuesta
            $respuesta = new \stdClass();
            $respuesta->nombre = $nombre;
            $respuesta->detalle = $detalle;
            return $respuesta;
        }


    }

    // igual que getDescripción, pero para el timeline
    public function getDetalleAttribute() {

        // Actores Armados
        if(!empty($this->aa_id_subtipo)) {
            $n2 = tipo_aa::find($this->aa_id_subtipo);
            $n1 = tipo_aa::find($n2->id_padre);  //Para evitar muladas
            $codigo = $n2->codigo;

            // Nombre del grupo especificado
            $nombre="$n1->descripcion - $n2->descripcion";

            //Detalle del grupo especificado
            $detalle="";
            $pedazos=array();


            if($codigo=='0101') {
                if(strlen($this->aa_nombre_grupo)>0) {
                    $pedazos['Grupo']=$this->aa_nombre_grupo;
                }
                if(strlen($this->aa_bloque)>0) {
                    $pedazos['Bloque']=$this->aa_bloque;
                }
                if(strlen($this->aa_frente)>0) {
                    $pedazos['Frente']=$this->aa_frente;
                }
                if(strlen($this->aa_unidad)>0) {
                    $pedazos['Otra unidad']=$this->aa_unidad;
                }
                //dd($codigo);
            }
            elseif($codigo=='0201' || $codigo == "0202") {
                if(strlen($this->aa_bloque)>0) {
                    $pedazos['Bloque']=$this->aa_bloque;
                }
                if(strlen($this->aa_frente)>0) {
                    $pedazos['Frente']=$this->aa_frente;
                }
                if(strlen($this->aa_unidad)>0) {
                    $pedazos['Otra unidad']=$this->aa_unidad;
                }
                //dd($this);
            }
            elseif($codigo=='0203') {
                if(strlen($this->aa_otro_cual)>0) {
                    $pedazos['¿Cuál?']=$this->aa_otro_cual;
                }

            }
            elseif(substr($codigo,0,2)=='03') {
                //dd("Gerrilla");
                if(strlen($this->aa_nombre_grupo)>0) {
                    $pedazos['¿Cuál?']=$this->aa_nombre_grupo;
                }
                if(strlen($this->aa_unidad)>0) {
                    $pedazos['Detalle unidad']=$this->aa_unidad;
                }

            }
            elseif(substr($codigo,0,2)=='04') {

                if(strlen($this->aa_otro_cual)>0) {
                    $pedazos['¿Cuál?']=$this->aa_otro_cual;
                }
                if(strlen($this->aa_unidad)>0) {
                    $pedazos['Detalle unidad']=$this->aa_unidad;
                }
            }
            elseif($codigo=='0501') {
                if(strlen($this->aa_unidad)>0) {
                    $pedazos['Detalle unidad']=$this->aa_unidad;
                }
            }
            //Unir y devolver respuesta
            $respuesta = new \stdClass();
            $respuesta->nombre = $nombre;
            $respuesta->pedazos = $pedazos;
            if(count($pedazos)>0) {
                $detalle = ": ".implode(". ",$pedazos);
            }
            else {
                $detalle="";
            }
            $respuesta->detalle = $detalle;
            return $respuesta;
        }



        //Terceros civiles
        $detalle="";
        $pedazos=array();
        if(!empty($this->tc_id_subtipo)) {
            $n2 = tipo_tc::find($this->tc_id_subtipo);
            $n1 = tipo_tc::find($n2->id_padre);  //Para evitar muladas
            $codigo = $n2->codigo;

            // Nombre del grupo especificado
            $nombre="$n1->descripcion - $n2->descripcion";

            //Detalle del grupo especificado
            $detalle="";
            if($codigo=='0107' || $codigo=='0205' || $codigo=='0303') {
                if(strlen($this->tc_otro_cual)>0) {
                    $pedazos['¿Cuál?']=$this->tc_otro_cual;
                }
                if(strlen($this->tc_detalle)>0) {
                    $pedazos['Detalle']=$this->tc_detalle;
                }


            }
            elseif($codigo=='0401') {
                if(strlen($this->otro_actor_cual)>0) {
                    $pedazos['¿Cuál?']=$this->otro_actor_cual;
                }
            }
            else {

                if(strlen($this->tc_detalle)>0) {
                    $pedazos['Detalle']=$this->tc_detalle;
                }

            }

            //Unir y devolver respuesta
            $respuesta = new \stdClass();
            $respuesta->nombre = $nombre;
            $respuesta->pedazos = $pedazos;
            if(count($pedazos)>0) {
                $detalle = ": ".implode(". ",$pedazos);
            }
            else {
                $detalle="";
            }
            $respuesta->detalle = $detalle;
            return $respuesta;
        }


    }

    public function getFmtResponsabilidadOtroAttribute() {

        if($this->aa_id_tipo > 0) {
            $p[0]=tipo_aa::nombrar($this->aa_id_tipo);
            $p[1]=tipo_aa::nombrar($this->aa_id_subtipo);
            if($p[0]==$p[1]) {
                unset($p[1]);
            }
            return implode(": ",$p);
        }
        if($this->tc_id_tipo > 0) {
            $p[0]=tipo_tc::nombrar($this->tc_id_tipo);
            $p[1]=tipo_tc::nombrar($this->tc_id_subtipo);
            if($p[0]==$p[1]) {
                unset($p[1]);
            }
            return implode(": ",$p);
        }

        return "Sin especificar";


    }

}
