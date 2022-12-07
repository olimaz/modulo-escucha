<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_exilio_movimiento
 * @property int $id_exilio
 * @property int $id_lugar_salida
 * @property int $id_lugar_llegada
 * @property int $id_lugar_llegada_2
 * @property int $id_modalidad
 * @property int $id_solicitado_proteccion
 * @property int $id_estado_proteccion
 * @property int $id_aprobada_proteccion
 * @property int $id_denegada_proteccion
 * @property int $id_residencia_proteccion
 * @property int $id_expulsion
 * @property int $id_tipo_movimiento
 * @property int $fecha_salida_d
 * @property int $fecha_salida_m
 * @property int $fecha_salida_a
 * @property string $salida_pais
 * @property string $salida_estado
 * @property string $salida_ciudad
 * @property int $fecha_llegada_d
 * @property int $fecha_llegada_m
 * @property int $fecha_llegada_a
 * @property string $llegada_pais
 * @property string $llegada_estado
 * @property string $llegada_ciudad
 * @property string $llegada_2_pais
 * @property string $llegada_2_estado
 * @property string $llegada_2_ciudad
 * @property int $fecha_asentamiento_d
 * @property int $fecha_asentamiento_m
 * @property int $fecha_asentamiento_a
 * @property int $cant_personas_salieron
 * @property int $cant_personas_familia_salieron
 * @property int $cant_personas_familia_quedaron
 * @property string $created_at
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Fichas.exilio $fichas.exilio
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.geo $catalogos.geo
 * @property Catalogos.geo $catalogos.geo
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Catalogos.catItem $catalogos.catItem
 * @property Fichas.exilioMovimientoProteccion[] $fichas.exilioMovimientoProteccions
 */
class exilio_movimiento extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'fichas.exilio_movimiento';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exilio_movimiento';

    /**
     * @var array
     */
    protected $fillable = ['id_exilio', 'id_lugar_salida', 'id_lugar_llegada', 'id_lugar_llegada_2','id_modalidad', 'id_solicitado_proteccion', 'id_estado_proteccion', 'id_aprobada_proteccion', 'id_denegada_proteccion', 'id_residencia_proteccion', 'id_expulsion', 'id_tipo_movimiento', 'fecha_salida_d', 'fecha_salida_m', 'fecha_salida_a', 'salida_pais', 'salida_estado', 'salida_ciudad', 'fecha_llegada_d', 'fecha_llegada_m', 'fecha_llegada_a', 'llegada_pais', 'llegada_estado', 'llegada_ciudad', 'llegada_2_pais', 'llegada_2_estado', 'llegada_2_ciudad', 'fecha_asentamiento_d', 'fecha_asentamiento_m', 'fecha_asentamiento_a', 'cant_personas_salieron', 'cant_personas_familia_salieron', 'cant_personas_familia_quedaron', 'created_at'];

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


    public function rel_id_exilio() {
        return $this->belongsTo(exilio::class,'id_exilio','id_exilio');
    }
    public function rel_id_lugar_salida() {
        return $this->belongsTo(geo::class,'id_lugar_salida','id_item');
    }
    public function rel_id_lugar_llegada() {
        return $this->belongsTo(geo::class,'id_lugar_llegada','id_item');
    }
    //Entidades debiles
    public function rel_exilio_movimiento_proteccion() {
        return $this->hasMany(exilio_movimiento_proteccion::class,'id_exilio_movimiento','id_exilio_movimiento');
    }
    public function rel_exilio_movimiento_motivo() {
        return $this->hasMany(exilio_movimiento_motivo::class,'id_exilio_movimiento','id_exilio_movimiento');
    }


    /*
     * GETTERS
     */

    //Edicion de controles multiples
    public function getArregloIdProteccionAttribute() {
        $arreglo=array();
        foreach($this->rel_exilio_movimiento_proteccion as $cual) {
            if($cual->rel_id_proteccion->id_cat == 203) {
                $arreglo[]=$cual->id_proteccion;
            }
        }
        return $arreglo;
    }
    public function getArregloIdAcompanamientoAttribute() {
        $arreglo=array();
        foreach($this->rel_exilio_movimiento_proteccion as $cual) {
            if($cual->rel_id_proteccion->id_cat == 218) {
                $arreglo[]=$cual->id_proteccion;
            }
        }
        return $arreglo;
    }
    public function getArregloIdMotivoAttribute() {
        $arreglo=array();
        foreach($this->rel_exilio_movimiento_motivo as $cual) {
                $arreglo[]=$cual->id_motivo;
        }
        return $arreglo;
    }
    //Para editar los motivos, le paso el id_cat porque todos hay varios que usan la misma tabla, solo cambia el catalogo
    public function arreglo_motivo($id_cat) {
        $arreglo=array();
        foreach($this->rel_exilio_movimiento_motivo as $item) {
            if($item->rel_id_motivo->id_cat == $id_cat) {
                $arreglo[]=$item->id_motivo;
            }
        }
        return $arreglo;
    }
    //Para editar los acompañamientos y protecciones, le paso el id_cat porque todos hay varios que usan la misma tabla, solo cambia el catalogo
    public function arreglo_proteccion($id_cat,$id_tipo=1) {
        $arreglo=array();
        foreach($this->rel_exilio_movimiento_proteccion()->where('id_tipo',$id_tipo)->get() as $item) {
            if($item->rel_id_proteccion->id_cat == $id_cat) {
                $arreglo[]=$item->id_proteccion;
            }
        }
        return $arreglo;
    }


    //Mostrar detalle de controles multiples
    public function getArregloFmtIdMotivoAttribute() {
        $arreglo = array();
        foreach($this->rel_exilio_movimiento_motivo as $categoria) {

            $arreglo[] = $categoria->fmt_id_motivo;
        }
        if(count($arreglo)==0) {
            $arreglo[]="Sin especificar";
        }
        return $arreglo;
    }
    public function getArregloFmtIdAcompanamientoAttribute() {
        $arreglo = array();
        foreach($this->rel_exilio_movimiento_proteccion as $cual) {
            if($cual->rel_id_proteccion->id_cat == 218) {
                $arreglo[]=cat_item::describir($cual->id_proteccion);
            }
        }
        if(count($arreglo)==0) {
            $arreglo[]="Sin especificar";
        }
        return $arreglo;
    }
    public function getArregloFmtIdProteccionAttribute() {
        $arreglo = array();
        foreach($this->rel_exilio_movimiento_proteccion as $cual) {
            if($cual->rel_id_proteccion->id_cat == 203) {
                $arreglo[]=cat_item::describir($cual->id_proteccion);
            }
        }
        if(count($arreglo)==0) {
            $arreglo[]="Sin especificar";
        }
        return $arreglo;
    }
    public function getfmtIdLugarSalidaAttribute() {
        return geo::nombre_completo($this->id_lugar_salida);
    }
    public function  getFmtIdLugarLlegadaAttribute() {
        return geo::nombre_completo($this->id_lugar_llegada);
    }
    public function  getFmtIdLugarLlegada2Attribute() {
        return geo::nombre_completo($this->id_lugar_llegada_2);
    }
    public function getFmtLugarSalidaAttribute() {
        $pieza=array();
        $pieza[]=$this->salida_pais;
        $pieza[]=$this->salida_estado;
        $pieza[]=$this->salida_ciudad;
        if(count($pieza)==0) {
            return "Sin especificar";
        }
        else {
            return implode(", ",$pieza);
        }
    }
    public function getFmtLugarLlegadaAttribute() {
        $pieza=array();
        $pieza[]=$this->llegada_pais;
        $pieza[]=$this->llegada_estado;
        $pieza[]=$this->llegada_ciudad;
        if(count($pieza)==0) {
            return "Sin especificar";
        }
        else {
            return implode(", ",$pieza);
        }
    }
    public function getFmtLugarLlegada2Attribute() {
        $pieza=array();
        $pieza[]=$this->llegada_2_pais;
        $pieza[]=$this->llegada_2_estado;
        $pieza[]=$this->llegada_2_ciudad;
        if(count($pieza)==0) {
            return "No aplica /Sin especificar";
        }
        else {
            return implode(", ",$pieza);
        }
    }
    public function getFmtIdModalidadAttribute() {
        return cat_item::describir($this->id_modalidad);
    }
    public function getFmtIdSolicitadoProteccionAttribute() {
        if(empty($this->id_solicitado_proteccion)) {
            return "No";
        }
        else {
            return cat_item::describir($this->id_solicitado_proteccion);
        }
    }
    public function getFmtIdEstadoProteccionAttribute() {
        return empty($this->id_estado_proteccion) ? "No aplica" : cat_item::describir($this->id_estado_proteccion);
    }
    public function getFmtIdAprobadaProteccionAttribute() {
        return empty($this->id_aprobada_proteccion) ? "No aplica" : cat_item::describir($this->id_aprobada_proteccion);
    }
    public function getFmtIdDenegadaProteccionAttribute() {
        return empty($this->id_denegada_proteccion) ? "No aplica" : cat_item::describir($this->id_denegada_proteccion);
    }
    public function getFmtIdResidenciaProteccionAttribute() {
        return empty($this->id_residencia_proteccion) ? "No aplica" : cat_item::describir($this->id_residencia_proteccion);
    }
    public function getFmtIdExpulsionAttribute() {
        return $this->id_expulsion==1 ? "Sí" : "No";
    }

    //Fechas
    public function getFmtFechaSalidaAttribute() {
        return hecho::mostrar_fecha_incompleta($this->fecha_salida_d, $this->fecha_salida_m,$this->fecha_salida_a);
    }
    public function getFmtFechaLlegadaAttribute() {
        return hecho::mostrar_fecha_incompleta($this->fecha_llegada_d, $this->fecha_llegada_m, $this->fecha_llegada_a);
    }
    public function getFmtFechaAsentamientoAttribute() {
        return hecho::mostrar_fecha_incompleta($this->fecha_asentamiento_d, $this->fecha_asentamiento_m, $this->fecha_asentamiento_a);
    }
    //Para la edicion
    public function getFechaSalidaAttribute() {
        return hecho::editar_fecha_incompleta($this->fecha_salida_d, $this->fecha_salida_m,$this->fecha_salida_a);
    }
    public function getFechaLlegadaAttribute() {
        return hecho::editar_fecha_incompleta($this->fecha_llegada_d, $this->fecha_llegada_m, $this->fecha_llegada_a);
    }
    public function getFechaAsentamientoAttribute() {
        return hecho::editar_fecha_incompleta($this->fecha_asentamiento_d, $this->fecha_asentamiento_m, $this->fecha_asentamiento_a);
    }


    /*
     * SETTERS
     */
    //Para ahorrarme validaciones
    public function setIdLugarSalidaAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_lugar_salida']=$val;
    }
    public function setIdLugarLlegadaAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_lugar_llegada']=$val;
    }
    public function setIdLugarLlegada2Attribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_lugar_llegada_2']=$val;
    }
    public function setIdSolicitadoProteccionAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_solicitado_proteccion']=$val;
    }
    public function setIdEstadoProteccionAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_estado_proteccion']=$val;
    }
    public function setIdAprobadaProteccionAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_aprobada_proteccion']=$val;
    }
    public function setIdDenegadaProteccionAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_denegada_proteccion']=$val;
    }
    public function setIdResidenciaProteccionAttribute($val) {
        $val = $val > 0 ? $val : null;
        $this->attributes['id_residencia_proteccion']=$val;
    }
    //si no hay retorno, valores a cero
    public function setCantPersonasSalieronAttribute($val) {
        $val = $val == null ? 0 : $val;
        $this->attributes['cant_personas_salieron']=$val;
    }
    public function setCantPersonasFamiliaSalieronAttribute($val) {
        $val = $val == null ? 0 : $val;
        $this->attributes['cant_personas_familia_salieron']=$val;
    }
    public function setCantPersonasFamiliaQuedaronAttribute($val) {
        $val = $val == null ? 0 : $val;
        $this->attributes['cant_personas_familia_quedaron']=$val;
    }
    //Fecha de salida
    public function setFechaSalidaDAttribute($val) {
        $val=(int)$val;
        $val = $val <= 0 ? 0 : $val;
        $this->attributes['fecha_salida_d']=$val;
    }
    public function setFechaSalidaMAttribute($val) {
        $val=(int)$val;
        $val = $val <= 0 ? 0 : $val;
        $this->attributes['fecha_salida_m']=$val;
    }
    public function setFechaSalidaAAttribute($val) {
        $val=(int)$val;
        $val = $val <= 1900 ? 0 : $val;
        $this->attributes['fecha_salida_a']=$val;
    }

    //Fecha de llegada
    public function setFechaLlegadaDAttribute($val) {
        $val=(int)$val;
        $val = $val <= 0 ? 0 : $val;
        $this->attributes['fecha_llegada_d']=$val;
    }
    public function setFechaLlegadaMAttribute($val) {
        $val=(int)$val;
        $val = $val <= 0 ? 0 : $val;
        $this->attributes['fecha_llegada_m']=$val;
    }
    public function setFechaLlegadaAAttribute($val) {
        $val=(int)$val;
        $val = $val <= 1900 ? 0 : $val;
        $this->attributes['fecha_llegada_a']=$val;
    }

    //Fecha de asentamiento
    public function setFechaAsentamientoDAttribute($val) {
        $val=(int)$val;
        $val = $val <= 0 ? 0 : $val;
        $this->attributes['fecha_asentamiento_d']=$val;
    }
    public function setFechaAsentamientoMAttribute($val) {
        $val=(int)$val;
        $val = $val <= 0 ? 0 : $val;
        $this->attributes['fecha_asentamiento_m']=$val;
    }
    public function setFechaAsentamientoAAttribute($val) {
        $val=(int)$val;
        $val = $val <= 1900 ? 0 : $val;
        if($val==0) {
            $this->attributes['fecha_asentamiento_d']=$val;
            $this->attributes['fecha_asentamiento_m']=$val;
            $this->attributes['fecha_asentamiento_a']=$val;
        }
        else {
            $this->attributes['fecha_asentamiento_a']=$val;
        }

        //dd($val);
    }






    /*
     * LOGICA propia del modelo
     */

    //Procesar el request
    public function procesar_detalle($request) {
        $this->rel_exilio_movimiento_proteccion()->delete();
        if(isset($request->id_proteccion)) { //si no hay retorno, estos datos no vienen
            foreach($request->id_proteccion as $id) {
                if($id>0) {
                    $nuevo=new exilio_movimiento_proteccion();
                    $nuevo->id_exilio_movimiento = $this->id_exilio_movimiento;
                    $nuevo->id_proteccion = $id;
                    $nuevo->id_tipo=1;
                    $nuevo->save();
                    //dd("Mirame");
                }
            }
        }

        if(isset($request->id_proteccion_2)) { //proteccion en el retorno
            foreach($request->id_proteccion_2 as $id) {
                if($id>0) {
                    $nuevo=new exilio_movimiento_proteccion();
                    $nuevo->id_exilio_movimiento = $this->id_exilio_movimiento;
                    $nuevo->id_proteccion = $id;
                    $nuevo->id_tipo=2;
                    $nuevo->save();
                }
            }
        }

        $this->rel_exilio_movimiento_motivo()->delete();
        if(isset($request->id_motivo)) {
            foreach($request->id_motivo as $id) {
                if($id>0) {
                    $nuevo=new exilio_movimiento_motivo();
                    $nuevo->id_exilio_movimiento = $this->id_exilio_movimiento;
                    $nuevo->id_motivo = $id;
                    $nuevo->save();
                }
            }
        }
    }

    /*
     * FILTROS
     */
    public function scopeOrdenado($query) {
        $query->orderby('fecha_salida_a')
            ->orderby('fecha_salida_m')
            ->orderby('fecha_salida_d');
    }


    public function completar_traza_insert() {
        $this->insert_ent = \Auth::user()->id_entrevistador;
        $this->insert_fh = \Carbon\Carbon::now();
        $this->insert_ip = \Request::ip();
    }
    public function completar_traza_update() {
        $this->update_ent = \Auth::user()->id_entrevistador;
        $this->update_fh = \Carbon\Carbon::now();
        $this->update_ip = \Request::ip();
    }





}
