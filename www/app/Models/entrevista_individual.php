<?php

namespace App\Models;

use App\ClassToXml;
use App\graficador;
use App\Interfaces\EntrevistaIndividual;
use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Html2Text\Html2Text;
use Laracasts\Flash\Flash;
use mysql_xdevapi\Exception;
use SebastianBergmann\CodeCoverage\Report\PHP;

/**
 * Class entrevista_individual
 * @package App\Models
 * @version April 17, 2019, 5:33 pm -05
 *

 * @property integer id_e_ind_fvt
 * @property integer id_subserie
 * @property integer id_remitido
 * @property integer id_prioritario
 * @property text prioritario_tema
 * @property integer id_sector
 * @property integer id_etnico
 * @property integer id_activo
 * @property integer id_entrevistador
 * @property integer entrevista_numero
 * @property string entrevista_codigo
 * @property integer entrevista_correlativo
 * @property integer id_macroterritorio
 * @property integer id_territorio
 * @property time entrevista_fecha
 * @property integer numero_entrevistador
 * @property time hechos_del
 * @property time hechos_al
 * @property integer hechos_lugar
 * @property string anotaciones
 * @property string titulo
 * @property string seguimiento_revisado
 * @property integer seguimiento_finalizado
 * @property string metadatos_ce
 * @property string metadatos_ca
 * @property string metadatos_da
 * @property string metadatos_ac
 * @property integer entrevista_lugar
 * @property integer nna
 * @property integer tiempo_entrevista
 * @property integer clasifica_nna
 * @property integer clasifica_sex
 * @property integer clasifica_res
 * @property integer clasifica_nivel
 * @property integer clasifica_r1
 * @property integer clasifica_r2
 * @property string html_transcripcion
 * @property string json_etiquetado
 * @property string fts
 * @property integer id_cerrado
 * @property string fichas_alarmas
 * @property integer fichas_estado
 * @property integer es_virtual
 * @property integer id_transcrita
 * @property integer id_etiquetada
 */
class entrevista_individual extends Model
{

    public $table = 'esclarecimiento.e_ind_fvt';
    protected $primaryKey = 'id_e_ind_fvt';
    //protected $perPage = 30;



    public $timestamps = false;



    public $fillable = [
        'id_subserie',
        'id_entrevistador',
        'entrevista_numero',
        'entrevista_codigo',
        'entrevista_correlativo',
        'id_macroterritorio',
        'id_territorio',
        'entrevista_fecha',
        'numero_entrevistador',
        'hechos_del',
        'hechos_al',
        'hechos_lugar',
        'anotaciones',
        'seguimiento_revisado',
        'seguimiento_finalizado',
        'metadatos_ce',
        'metadatos_ca',
        'metadatos_da',
        'metadatos_ac',
        'entrevista_lugar',
        'nna',
        'titulo',
        'clasifica_nna',
        'clasifica_sex',
        'clasifica_res',
        'clasifica_nivel',
        'clasifica_r1',
        'clasifica_r2',
        //'id_activo',
        'id_prioritario',
        'prioritario_tema',
        'id_sector',
        'id_etnico',
        'id_remitido',
        'tiempo_entrevista',
        'es_virtual'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt' => 'integer',
        'id_subserie' => 'integer',
        'id_entrevistador' => 'integer',
        'entrevista_numero' => 'integer',
        'entrevista_codigo' => 'string',
        'entrevista_correlativo' => 'integer',
        'id_macroterritorio' => 'integer',
        'id_territorio' => 'integer',
        'numero_entrevistador' => 'integer',
        'hechos_lugar' => 'integer',
        'anotaciones' => 'string',
        'seguimiento_revisado' => 'string',
        'seguimiento_finalizado' => 'integer',
        'metadatos_ce' => 'string',
        'metadatos_ca' => 'string',
        'metadatos_da' => 'string',
        'metadatos_ac' => 'string',
        'entrevista_lugar' => 'integer',
        'nna' => 'integer',
        'id_activo' => 'integer',
        'id_prioritario' => 'integer',
        'prioritario_tema' => 'string',
        'id_sector' => 'integer',
        'id_etnico' => 'integer',
        'id_remitido' => 'integer',
        'tiempo_entrevista' => 'integer',
        'clasifica_nna' => 'integer',
        'clasifica_sex' => 'integer',
        'clasifica_res' => 'integer',
        'clasifica_nivel' => 'integer',
        'clasifica_r1' => 'integer',
        'clasifica_r2' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'entrevista_numero' => 'required',
        'entrevista_fecha' => 'required',
        //'hechos_del' => 'required',
        'hechos_rango' => 'required',
        //'tv' => 'required',
        //'fr' => 'required',
    ];


    //Llaves foraneas
    public function rel_id_subserie() {
        return $this->belongsTo(cat_item::class,'id_subserie','id_item');
    }
    public function rel_id_remitido() {
        return $this->belongsTo(cat_item::class,'id_remitido','id_item');
    }
    public function rel_id_sector() {
        return $this->belongsTo(cat_item::class,'id_sector','id_item');
    }
    public function rel_id_etnico() {
        return $this->belongsTo(cat_item::class,'id_etnico','id_item');
    }

    public function rel_id_entrevistador() {
        return $this->belongsTo(entrevistador::class,'id_entrevistador','id_entrevistador');
    }
    public  function rel_id_macroterritorio() {
        return $this->belongsTo(cev::class,'id_macroterritorio','id_geo');
    }
    public function rel_id_territorio() {
        return $this->belongsTo(cev::class,'id_territorio','id_geo');
    }
    public function rel_hechos_lugar() {
        return $this->belongsTo(geo::class,'hechos_lugar','id_geo');
    }
    public function rel_entrevista_lugar() {
        return $this->belongsTo(geo::class,'entrevista_lugar','id_geo');
    }
    public function rel_fr() {
        return $this->hasMany(entrevista_individual_fr::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_tv() {
        return $this->hasMany(entrevista_individual_tv::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_aa() {
        return $this->hasMany(entrevista_individual_aa::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_tc() {
        return $this->hasMany(entrevista_individual_tc::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_stc() {
        return $this->hasMany(entrevista_individual_stc::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_interes() {
        return $this->hasMany(entrevista_individual_interes::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_interes_area() {
        return $this->hasMany(entrevista_individual_interes_area::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_mandato() {
        return $this->hasMany(entrevista_individual_mandato::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    public function rel_dinamica() {
        return $this->hasMany(entrevista_individual_dinamica::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    // Otras relaciones
    public function rel_adjunto() {
        return $this->hasMany(entrevista_individual_adjunto::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    //Relaciones para el control de calidad de exilio
    // Con ficha de exilio
    public  function rel_exilio_ficha() {
        return $this->hasMany(exilio::class, 'id_e_ind_fvt','id_e_ind_fvt');
    }
    //Metadatos de violencia
    public  function rel_metadatos_violencia() {
        return $this->hasMany(entrevista_individual_tv::class,'id_e_ind_fvt','id_e_ind_fvt');
    }


    //Permisos si fuera reservado-3
    public function rel_acceso_reservado() {
        return $this->hasMany(reservado_acceso::class,'id_primaria','id_e_ind_fvt')->where('reservado_acceso.id_subserie',$this->id_subserie)->where('id_activo',1);
        //return $this->hasMany(reservado_acceso::class,'id_primaria','id_e_ind_fvt')->where('reservado_acceso.id_subserie',config('expedientes.vi'))->where('id_activo',1);
    }

    //Asiganciones de transcripcion
    public function rel_transcripcion() {
        return $this->hasMany(transcribir_asignacion::class,'id_e_ind_fvt','id_e_ind_fvt')->orderby('id_transcribir_asignacion','desc');
    }
    //Asignaciones para etiquetado
    public function rel_etiquetado() {
        return $this->hasMany(etiquetar_asignacion::class,'id_e_ind_fvt','id_e_ind_fvt')->orderby('id_etiquetar_asignacion','desc');;
    }


    public function getFmtIdRemitidoAttribute() {
        return cat_item::describir($this->id_remitido);
    }
    public function getFmtIdPrioritarioAttribute() {
        return $this->id_prioritario==1 ? "Sí" : "No";
    }
    public function getFmtIdSectorAttribute() {
        return cat_item::describir($this->id_sector);
    }
    public function getFmtIdEtnicoAttribute() {
        return $this->id_etnico==1 ? 'Sí' : 'No';
    }
    public function getFmtIdCerradoAttribute() {
        $str="";
        if($this->id_cerrado==1) {
            $str = '<i class="fa fa-lock"  title="Procesamiento finalizado" data-toggle="tooltip" aria-hidden="true"></i>';
        }
        return $str;
    }

    //Prioridad
    public function rel_prioridad() {
        return $this->hasMany(prioridad::class,'id_entrevista','id_e_ind_fvt')->where('id_subserie',$this->id_subserie);;
    }
    //Usa rel_prioridad, lo filtra y organiza
    public function getListadoPrioridadAttribute() {
        return $this->rel_prioridad()->where('prioridad.id_subserie',$this->id_subserie)->orderby('prioridad.id_tipo')->orderby('prioridad.fecha_hora')->get();
    }
    //Tiempo de procesamiento
    public function getTiempoProcesamientoAttribute() {
        $tiempos[0]=0; //Entrevista
        $tiempos[1]=0; //Transcripcion
        $tiempos[2]=0; //Etiquetar
        $tiempos[3]=0; //Diligenciar

        $listado = procesamiento_tiempo::where('id_entrevista',$this->id_e_ind_fvt)
                                ->where('id_subserie',$this->id_subserie)
                                ->select(\DB::raw('id_tipo_medicion, max(tiempo_minutos) as tiempo'))
                                ->groupby('id_tipo_medicion')
                                ->get();


        foreach($listado as $fila) {
            $tiempos[$fila->id_tipo_medicion] = $fila->tiempo;
        }
        $tr = $this->rel_transcripcion()->max('duracion_entrevista_minutos');
        //$et = $this->rel_etiquetado()->max('duracion_entrevista_minutos');
        //$max = $et > $tr ? $et : $tr;
        if(intval($tr) > 0) {
            $tiempos[0]=$tr;
        }
        else {
            $tiempos[0] = $this->tiempo_entrevista;  //Usar el valor de los metadatos
        }

        //Para no desplegar valores a cero
        $hay_tiempo=false;
        foreach($tiempos as $val) {
            if($val>0) {
                $hay_tiempo=true;
            }
        }
        if($hay_tiempo) {
            return $tiempos;
        }
        else {
            return false;
        }

    }

    //Seguimiento
    public function rel_seguimiento() {
        return $this->hasMany(seguimiento::class,'id_entrevista','id_e_ind_fvt')->where('id_subserie',$this->id_subserie)->orderby('fecha_hora');
    }
    public function getSeguimientoAttribute() {
        return $this->rel_seguimiento()->where('id_subserie',$this->id_subserie)->get();
    }


    public function setIdRemitidoAttribute($val) {
        if($val<=0) {
            $val=null;
        }
        $this->attributes['id_remitido']=$val;
    }
    public function setIdEtnicoAttribute($val) {
        if($val<=0) {
            $val=null;
        }
        $this->attributes['id_etnico']=$val;
    }
    public function setIdSectorAttribute($val) {
        if($val<=0) {
            $val=null;
        }
        $this->attributes['id_sector']=$val;
    }
    //Mostrar si está transcrita o etiquetada
    public function getFmtEstadoTranscripcionAttribute() {
        //
        $si = $this->rel_transcripcion()->where('id_situacion',2)->count();
        if($si>0) {
            $et = $this->rel_etiquetado()->where('id_situacion',2)->count();
            if($et >0 ) {
                return "<span class='text-success'>Etiquetada</span>";
            }
            else {
                return "<span class='text-success'>Transcrita</span>";
            }

        }
        else {
            $si = $this->rel_transcripcion()->where('id_situacion',1)->count();
            if($si >0) {
                return "<span class='text-warning'>En proceso</span>";
            }
            else {
                //No transcrita por alguna razón
                $negada = $this->rel_transcripcion()->where('id_situacion',4)->orderby('fh_asignado','desc')->first();
                //dd($negada);
                if($negada) {
                    $estado="No";
                    if($negada->id_causa) {
                        $razon = cat_item::describir($negada->id_causa);
                        $estado .=" - $razon";
                    }
                     return "<span class='text-danger'>$estado</span>";
                }
            }
        }
        //Sin asignación
        return "<span class='text-danger'>No</span>";
    }
    //Es virtual
    public function getFmtEsVirtualAttribute() {
        return criterio_fijo::describir(2,$this->es_virtual);
    }
    //Mostrar si está etiquetada
    public function getFmtEstadoEtiquetadoAttribute() {
        $si = $this->rel_etiquetado()->where('id_situacion',2)->count();
        if($si>0) {
            $et = $this->rel_etiquetado()->where('id_situacion',2)->count();
            if($et >0 ) {
                return "<span class='text-success'>Etiquetada</span>";
            }
            else {
                return "<span class='text-success'>Transcrita</span>";
            }

        }
        else {
            $si = $this->rel_etiquetado()->where('id_situacion',1)->count();
            if($si >0) {
                return "<span class='text-warning'>En proceso</span>";
            }
            else {
                //No transcrita por alguna razón
                $negada = $this->rel_etiquetado()->where('id_situacion',4)->orderby('fh_asignado','desc')->first();
                //dd($negada);
                if($negada) {
                    $estado="No";
                    if($negada->id_causa) {
                        $razon = cat_item::describir($negada->id_causa);
                        $estado .=" - $razon";
                    }
                    return "<span class='text-danger'>$estado</span>";
                }
            }
        }
        //Sin asignación
        return "<span class='text-danger'>No</span>";
    }

    //fmt_estado_transcrita es para los usuarios comunes.
    //  Esta función es para transcriptores.  Es estática para no repetir el mismo código en todas las entrevistas
    // importante que exista rel_transcripcion()
    public static function estado_transcrita($entrevista) {
        $texto="Sin asignar";
        //
        $si = $entrevista->rel_transcripcion()->where('id_situacion',2)->count();
        if($si>0) {
            $texto = "Transcrita";
        }
        else {
            $si = $entrevista->rel_transcripcion()->where('id_situacion',1)->count();
            if($si >0) {
                $texto = "Asignada";
            }
            else {
                //No transcrita por alguna razón
                $negada = $entrevista->rel_transcripcion()->where('id_situacion',4)->orderby('fh_asignado','desc')->first();
                //dd($negada);
                if($negada) {
                    $estado="No";
                    if($negada->id_causa) {
                        $razon = cat_item::describir($negada->id_causa);
                        $estado .=" - $razon";
                    }
                    $texto = $estado;
                }
            }
        }
        //Sin asignación
        return $texto;
    }

    //fmt_estado_etiquetada es para los usuarios comunes.
    //  Esta función es para transcriptores.  Es estática para no repetir el mismo código en todas las entrevistas
    // importante que exista rel_etiquetado()
    public static function estado_etiquetada($entrevista) {
        $texto="Sin asignar";
        //
        $si = $entrevista->rel_etiquetado()->where('id_situacion',2)->count();
        if($si>0) {
            $texto = "Transcrita";
        }
        else {
            $si = $entrevista->rel_etiquetado()->where('id_situacion',1)->count();
            if($si >0) {
                $texto = "Asignada";
            }
            else {
                //No transcrita por alguna razón
                $negada = $entrevista->rel_etiquetado()->where('id_situacion',4)->orderby('fh_asignado','desc')->first();
                //dd($negada);
                if($negada) {
                    $estado="No";
                    if($negada->id_causa) {
                        $razon = cat_item::describir($negada->id_causa);
                        $estado .=" - $razon";
                    }
                    $texto = $estado;
                }
            }
        }
        //Sin asignación
        return $texto;
    }

    //Devuelve la fecha del etiquetado
    public static function fecha_etiquetada($entrevista) {
        $texto="No etiquetada";
        //
        $si = $entrevista->rel_etiquetado()->where('id_situacion',2)->orderby('fh_transcrito','desc')->first();
        if($si) {
            $texto = $si->fh_transcrito;
        }
        //Sin asignación
        return $texto;
    }
    //Devuelve la fecha del etiquetado
    public static function fecha_transcrita($entrevista) {
        $texto="No transcrita";
        //
        $si = $entrevista->rel_transcripcion()->where('id_situacion',2)->orderby('fh_transcrito','desc')->first();
        if($si) {
            $texto = $si->fh_transcrito;
        }
        //Sin asignación
        return $texto;
    }

    // Devuele el código de la entrevista
    public static function codigo($id_e_ind_fvt=null) {
        if($id_e_ind_fvt <= 0) return "Sin Especificar";
        $existe = self::find($id_e_ind_fvt);
        if(empty($existe)) {
            return "Desconocido ($id_e_ind_fvt)";
        }
        else {
            return $existe->entrevista_codigo;
        }
    }




    //Devuelve un listado con los codigos de quienes tienen acceso
    public function getAccesosAutorizadosAttribute() {
        $arreglo=array();
        foreach($this->rel_acceso_reservado as $permiso) {
            $jefe = entrevistador::find($permiso->id_autorizador);
            $gato = entrevistador::find($permiso->id_autorizado);
            $arreglo[]= "Ent. #".$gato->numero_entrevistador. " (Aut: #$jefe->numero_entrevistador)";
        }
        if(count($arreglo)==0) {
            $str="Nadie, solo el propietario.";
        }
        else {
            $str=implode(", ",$arreglo);
        }
        return $str;
    }



    //Para determinar si puede enviarse a transcribir
    public function getPuedeTranscribirseAttribute() {
        if($this->es_virtual==1) {
            $obligatorio=array(2);  //Audio para las virtuales
        }
        else {
            $obligatorio=array(1,2);  //Consentimiento y Audio
        }

        $puede=true;
        foreach($obligatorio as $id_tipo) {
            if($this->rel_adjunto()->where('e_ind_fvt_adjunto.id_tipo',$id_tipo)->count()==0) {
                $puede=false;
                break;
            }
        }
        return $puede;
    }





    // Setters
    public function setPrioritarioTemaAttribute($val) {
        $val=trim($val);
        if(strlen($val)<=0) {
            $this->attributes['prioritario_tema']=null;
        }
        else {
            $this->attributes['prioritario_tema']=$val;
        }
    }
    //Campos tipo fecha
    public function setEntrevistaFechaAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['entrevista_fecha']=$fecha;
    }
    public function setHechosDelAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['hechos_del']=$fecha;
    }
    public function setHechosAlAttribute($val) {
        if(strlen($val)==10) {
            $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$val." 00:00:00");
        }
        else {
            $fecha=null;
        }
        $this->attributes['hechos_al']=$fecha;
    }

    public function setTiempoEntrevistaAttribute($val) {
        $val=intval($val);
        $this->attributes['tiempo_entrevista']=$val;

    }


    //Getters
    public function getFmtEntrevistaFechaAttribute() {
        try {
            $fecha= new Carbon($this->entrevista_fecha);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtEntrevistaLugarAttribute() {
        return geo::nombre_completo($this->entrevista_lugar);
    }
    public function getFmtIdEntrevistadorAttribute() {
        $quien=$this->rel_id_entrevistador;
        if($quien) {
            return $quien->rel_usuario->name;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtIdMacroterritorioAttribute() {
        $ref=$this->rel_id_macroterritorio;
        if($ref) {
            return $ref->descripcion;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtIdTerritorioAttribute() {
        $ref=$this->rel_id_territorio;
        if($ref) {
            return $ref->descripcion;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtIdSubserieAttribute() {
        $ref=$this->rel_id_subserie;
        if($ref) {
            return $ref->descripcion;
        }
        else {
            return "Sin especificar";
        }
    }
    public function getFmtIdSubserieCodigoAttribute() {
        $cual = cat_item::find($this->id_subserie);
        if($cual) {
            return $cual->abreviado;
        }
        else {
            return "XX";
        }
    }
    public function getFmtHechosDelAttribute() {
        try {
            $fecha= new Carbon($this->hechos_del);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }

    }
    public function getFmtHechosAlAttribute() {
        try {
            $fecha= new Carbon($this->hechos_al);
            return $fecha->format("d-m-Y");
        }
        catch(\Exception $e) {
            return "Sin especificar";
        }
    }
    public function getFmtFechaHechosAttribute() {
        if(empty($this->hechos_al) || $this->hechos_del == $this->hechos_al) {
            return $this->fmt_hechos_del;
        }
        else{
            return $this->fmt_hechos_del." al ".$this->fmt_hechos_al;
        }
    }
    //Para la edición del control, le pasa las fechas como rango
    public function getFechaRangoAttribute() {
        if(empty($this->hechos_del)) {
            return null;
        }
        try {
            $del= new Carbon($this->hechos_del);
            $al= new Carbon($this->hechos_al);
            return $del->format("d/m/Y")." - ".$al->format("d/m/Y");
        }
        catch(\Exception $e) {
            return null;
        }

    }
    public function getFmtHechosLugarAttribute() {
        return geo::nombre_completo($this->hechos_lugar);
    }
    // Detalle de fuerzas responsables  (sirve en VI y AA)
    public function getFmtFrAttribute() {
        $arreglo=array();
        foreach($this->rel_fr as $fr) {
            $arreglo[]=$fr->rel_id_fr->descripcion;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de tipos de violacion
    public function getFmtTvAttribute() {
        $arreglo=array();
        foreach($this->rel_tv as $tv) {
            $arreglo[]=$tv->rel_id_tv->descripcion;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de temas con Actor Armado
    public function getFmtAaAttribute() {
        $arreglo=array();
        foreach($this->rel_aa as $aa) {
            $arreglo[]=$aa->rel_id_aa->descripcion;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de temas con Terceros Civiles
    public function getFmtTcAttribute() {
        $arreglo=array();
        foreach($this->rel_tc as $aa) {
            $arreglo[]=$aa->rel_id_tc->descripcion;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de sectores con Terceros Civiles
    public function getFmtStcAttribute() {
        $arreglo=array();
        foreach($this->rel_stc as $item) {
            $arreglo[]=$item->rel_id_stc->descripcion;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de areas de interes como <li>
    public function getFmtInteresAttribute() {
        $arreglo=array();
        foreach($this->rel_interes as $item) {
            $arreglo[]=$item->fmt_id_interes;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de areas de interes como <li>
    public function getFmtInteresAreaAttribute() {
        $arreglo=array();
        foreach($this->rel_interes_area as $item) {
            $arreglo[]=$item->fmt_id_interes;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de puntos del mandato, como <li>
    public function getFmtMandatoAttribute() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[]=$item->fmt_id_mandato;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }
        return $txt;
    }
    // Detalle de dinámicas, como <li>
    public function getFmtDinamicaAttribute() {
        $arreglo=array();
        foreach($this->rel_dinamica as $item) {
            $arreglo[]=$item->dinamica;
        }
        if(count($arreglo)>0) {
            asort($arreglo);
            $txt=implode("<li>",$arreglo);
            $txt="<ul><li>$txt</li></ul>";
        }
        else {
            $txt="(Sin especificar)";
        }

        return $txt;
    }
    //Formato de estado de las fichas
    public function getFmtFichasEstadoAttribute() {
        return criterio_fijo::describir(40,$this->fichas_estado);
    }

    public function getFmtNnaAttribute() {
        if($this->nna==1) {
            return "Sí";
        }
        else {
            return "No";
        }
    }

    //Clasificacion
    public function getFmtClasificaNnaAttribute() {
        return $this->clasifica_nna == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaSexAttribute() {
        return $this->clasifica_sex == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaResAttribute() {
        return $this->clasifica_res == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaR1Attribute() {
        return $this->clasifica_r1 == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaR2Attribute() {
        return $this->clasifica_r2 == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificaAaTcAttribute() {
        return in_array($this->id_subserie,[config('expedientes.aa'),config('expedientes.tc')]) ?  "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getAdjuntosAttribute() {
        return entrevista_individual_adjunto::listado_adjuntos($this->id_e_ind_fvt);
    }
    //Remiendo
    public function getClasificacionNivelAttribute() {
        return $this->clasifica_nivel;
    }
    public function getClasificacionNnaAttribute() {
        return $this->clasifica_nna;
    }
    public function getClasificacionSexAttribute() {
        return $this->clasifica_sex;
    }
    public function getClasificacionResAttribute() {
        return $this->clasifica_res;
    }
    public function getClasificacionR1Attribute() {
        return $this->clasifica_r1;
    }
    public function getClasificacionR2Attribute() {
        return $this->clasifica_r2;
    }
    public function getFmtClasificacionNnaAttribute() {
        return $this->clasifica_nna == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificacionSexAttribute() {
        return $this->clasifica_sex == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificacionResAttribute() {
        return $this->clasifica_res == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificacionR1Attribute() {
        return $this->clasifica_r1 == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificacionR2Attribute() {
        return $this->clasifica_r2 == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    public function getFmtClasificacionAaTcAttribute() {
        return in_array($this->id_subserie,[config('expedientes.aa'),config('expedientes.tc')]) ?  "<span class='text-danger'>Sí</span>" : "No";
    }
    public static function clasificacion_rojo($valor) {
        return $valor == 1 ? "<span class='text-danger'>Sí</span>" : "No";
    }
    //Fin del remiendo


    //Estos getters son Para facilitar la edicion
    public function getArchivoCiAttribute() {
        $existe = $this->rel_adjunto()->where('id_tipo',1)->first();
        if($existe) {
            return $existe->fmt_nombre;
        }
        else {
            return "";
        }
    }
    public function getArchivoAudioAttribute() {
        $existe = $this->rel_adjunto()->where('id_tipo',2)->first();
        if($existe) {
            return $existe->fmt_nombre;
        }
        else {
            return "";
        }
    }
    public function getArchivoFichasAttribute() {
        $existe = $this->rel_adjunto()->where('id_tipo',3)->first();
        if($existe) {
            return $existe->fmt_nombre;
        }
        else {
            return "";
        }
    }
    public function getArchivoOtroAttribute() {
        $existe = $this->rel_adjunto()->where('id_tipo',4)->first();
        if($existe) {
            return $existe->fmt_nombre;
        }
        else {
            return "";
        }
    }
    public function getArchivoTAttribute() {
        $existe = $this->rel_adjunto()->where('id_tipo',6)->first();
        if($existe) {
            return $existe->fmt_nombre;
        }
        else {
            return "";
        }
    }

    //Para controlar si tiene los adjuntos requeridos
    public function verificar_adjunto($tipo=0) {
        return $this->rel_adjunto()->where('id_tipo',$tipo)->count();
    }
    public function getTieneCFAttribute() { //tiene_cf: consentimiento infomado
        return $this->verificar_adjunto(1) > 0 ? 1 : 0;
    }
    public function getTieneAudioAttribute() {  //tiene_audio: Audio
        return $this->verificar_adjunto(2) > 0 ? 1 : 0;
    }
    public function getTieneFcAttribute() { //tiene_fc: Ficha corta
        return $this->verificar_adjunto(3) > 0 ? 1 : 0;
    }
    public function getTieneOtrosAttribute() { //tiene_otros: Otros
        return $this->verificar_adjunto(4) > 0 ? 1 : 0;
    }
    public function getTieneFlAttribute() { //tiene_fl: ficha larga
        return $this->verificar_adjunto(5) > 0 ? 1 : 0;
    }
    public function getTieneTfAttribute() { //tiene_tf: transcripcion final
        return $this->verificar_adjunto(6) > 0 ? 1 : 0;
    }
    public function getTieneRefAttribute() { //tiene_ref: referencias
        return $this->verificar_adjunto(7) > 0 ? 1 : 0;
    }
    public function getTieneTpAttribute() { //tiene_tp: transcripcion preliminar (automática)
        return $this->verificar_adjunto(8) > 0 ? 1 : 0;
    }
    public function getTieneRetroaAttribute() { //tiene_retroa: Retroalimentacion
        return $this->verificar_adjunto(10) > 0 ? 1 : 0;
    }
    public function getTieneRelAttribute() { //tiene_rel: Relatoría
        return $this->verificar_adjunto(11) > 0 ? 1 : 0;
    }
    public function getTieneCertAttribute() { //tiene_cert: Certificaciones
        return $this->verificar_adjunto(12) > 0 ? 1 : 0;
    }
    public function getTieneNevAttribute() { //tiene_nev: NNA: evaluacion de Vulnerabilidad
        return $this->verificar_adjunto(13) > 0 ? 1 : 0;
    }
    public function getTieneNesAttribute() { //tiene_nes: NNA: evaluacion de Seguridad
        return $this->verificar_adjunto(14) > 0 ? 1 : 0;
    }
    //Tiene etiquetado?
    public function getTieneEtiquetadoAttribute() { //Tiene etiquetado
        //return $this->verificar_adjunto(25) > 0 ? 1 : 0;
        return strlen($this->json_etiquetado)>0 ? 1 : 0;
    }
    //Tiene transcripcion?
    public function getTieneTranscripcionAttribute() {
        return strlen($this->html_transcripcion)>0 ? 1 : 0;
    }

    //Determina si tiene asignación pendiente.  PAra no enviar dos veces el mismo
    public function getAsignadoEtiquetadoAttribute() {
        $existe = etiquetar_asignacion::where('id_e_ind_fvt',$this->id_e_ind_fvt)->where('id_situacion',1)->first();
        return $existe ? 1 : 0;
    }





    //////////////////////////Para la edición de select multiple
    //Devuelve arreglo con fuerzas responsables
    public function getArregloFrAttribute() {
        $arreglo=array();
        foreach($this->rel_fr as $fr) {
            $arreglo[]=$fr->id_fr;
        }
        return $arreglo;
    }
    //Devuelve arreglo con tipos de violencia
    public function getArregloTvAttribute() {
        $arreglo=array();
        foreach($this->rel_tv as $tv) {
            $arreglo[]=$tv->id_tv;
        }
        return $arreglo;
    }
    //Devuelve arreglo con actores armados
    public function getArregloAaAttribute() {
        $arreglo=array();
        foreach($this->rel_aa as $aa) {
            $arreglo[]=$aa->id_aa;
        }
        return $arreglo;
    }
    //Devuelve arreglo con terceros civiles
    public function getArregloTcAttribute() {
        $arreglo=array();
        foreach($this->rel_tc as $tc) {
            $arreglo[]=$tc->id_tc;
        }
        return $arreglo;
    }
    //Devuelve arreglo con temas de terceros civiles
    public function getArregloSTcAttribute() {
        $arreglo=array();
        foreach($this->rel_stc as $item) {
            $arreglo[]=$item->id_stc;
        }
        return $arreglo;
    }
    //Devuelve arreglo con nucleos de interés
    public function getArregloInteresAttribute() {
        $arreglo=array();
        foreach($this->rel_interes as $item) {
            $arreglo[]=$item->id_interes;
        }
        return $arreglo;
    }
    //Devuelve arreglo con áreas de interés
    public function getArregloInteresAreaAttribute() {
        $arreglo=array();
        foreach($this->rel_interes_area as $item) {
            $arreglo[]=$item->id_interes;
        }
        return $arreglo;
    }
    //Devuelve arreglo con puntos del mandato
    public function getArregloMandatoAttribute() {
        $arreglo=array();
        foreach($this->rel_mandato as $item) {
            $arreglo[]=$item->id_mandato;
        }
        return $arreglo;
    }
    //Devuelve un arreglo de tres posiciones, sirve para la edicion
    public function getArregloDinamicaAttribute() {
        $arreglo=array(null,null,null);
        $i=0;
        foreach($this->rel_dinamica as $item) {
            $arreglo[$i]=$item->dinamica;
            $i++;
        }
        return $arreglo;
    }
    //Devuelve un ícono para el listado
    public function getIconoAttribute() {
        $ico="";
        $tiene = $this->rel_adjunto()->where('id_tipo',10)->first();

        if($tiene) {
            $ico="<i class='glyphicon glyphicon-star-empty text-yellow'></i>";
            $url=route('entrevistaIndividuals.show',$this->id_e_ind_fvt);
            $ico = "<a data-toggle='tooltip' title='Esta entrevista incluye archivo adjunto de retroalimentación.' class='btn btn-default btn-sm' href='$url'>$ico</a>";
        }
        return $ico;
    }

    ///////////////////////////////// SCOPES
    //Para los filtros
    public static function filtros_default($request = null) {
        $fecha = Carbon::now();
        //Valores por defecto
        $filtro =new \stdClass();
        $filtro->entrevista_del = null;
        $filtro->entrevista_al = null;
        $filtro->entrevista_lugar = -1;
        $filtro->hechos_del = null;
        $filtro->hechos_al = null;
        $filtro->id_periodo = -1; //período de los hechos
        $filtro->hechos_lugar = -1;
        $filtro->id_entrevistador = -1;
        $filtro->id_macroterritorio = -1;
        $filtro->id_territorio = -1;
        $filtro->id_grupo=-1;
        $filtro->id_subserie=-1;
        $filtro->fr = -1;
        $filtro->tv = -1;
        $filtro->aa = -1;
        $filtro->tc = -1;
        $filtro->stc = -1;
        $filtro->interes=-1;
        $filtro->mandato=-1;
        $filtro->dinamica="";
        $filtro->titulo="";

        $filtro->anotaciones = "";
        $filtro->observaciones_diligenciada = "";
        $filtro->br = "";
        $filtro->nna = -1;
        $filtro->entrevista_correlativo=null;
        $filtro->entrevista_codigo=null;

        $filtro->interes_area=-1;
        $filtro->id_activo=1; //Activos por default
        $filtro->id_prioritario=-1;
        $filtro->prioritario_tema=null;
        $filtro->id_sector=-1;
        $filtro->id_etnico=-1;
        $filtro->id_remitido=-1;
        $filtro->fichas_estado=-1;

        $filtro->transcrita=-1;
        $filtro->etiquetada=-1;
        $filtro->id_tesauro = -1;
        //
        $filtro->con_transcripcion=-1;
        $filtro->con_etiquetado=-1;

        //Full text search
        $filtro->fts=null;
        //Tesauro
        $filtro->id_tesauro=-1;
        //Buscadora avanzada
        $filtro->id_tesauro_2=-1;
        $filtro->id_tesauro_3=-1;
        $filtro->d_hecho_min=-1;
        $filtro->d_contexto_min=-1;
        $filtro->d_impacto_min=-1;
        $filtro->d_justicia_min=-1;

        //Marca

        //Marcas
        $filtro->marca=array();
        $filtro->id_cerrado=-1;

        //Seguimiento
        $filtro->con_problemas=-1;
        //Priorizacion
        $filtro->tipo_prioridad=-1;
        $filtro->fluidez=-1;
        $filtro->cierre=-1;
        $filtro->d_hecho=-1;
        $filtro->d_contexto=-1;
        $filtro->d_impacto=-1;
        $filtro->d_justicia=-1;
        $filtro->ahora_entiendo="";
        $filtro->cambio_perspectiva="";
        //Para filtrar fichas
        $filtro->violencia_anio_del="";
        $filtro->violencia_anio_al="";
        $filtro->violencia_tipo=-1;
        $filtro->violencia_lugar=-1;
        //$filtro->violencia_responsabilidad=-1;
        $filtro->violencia_aa=-1;
        $filtro->violencia_tc=-1;

        //Para saber si mostrar el box de filtros.
        $filtro->hay_filtro=false;

        //Filtros sobre fichas
        //Persona entrevistada
        $filtro->pe_id_sexo=-1;
        $filtro->pe_id_etnia=-1;
        $filtro->pe_id_discapacidad=-1;
        $filtro->pe_id_grupo_etario=-1;
        //Victima: filtros para estadísticas
        $filtro->vi_id_grupo_etario=-1;
        $filtro->vi_id_sexo = -1;
        $filtro->vi_id_etnia = -1;
        $filtro->vi_edad_del = "";
        $filtro->vi_edad_al = "";

        //Para uso interno
        $filtro->debug = isset($request->debug);

        //Para calcular estadisticas a una fecha especifica
        $filtro->fecha_corte=null;
        $filtro->fecha_corte = isset($request->fecha_corte) ? $request->fecha_corte : $filtro->fecha_corte;

        //parametro para filtrar por listado de excel
        $filtro->id_excel_listados =  -1;
        $filtro->id_excel_listados = isset($request->id_excel_listados) ? $request->id_excel_listados : $filtro->id_excel_listados;


        //Filtros para estadisticas
        $filtro->vi_id_sexo = $request->vi_id_sexo ?? $filtro->vi_id_sexo;
        $filtro->vi_id_etnia = $request->vi_id_etnia ?? $filtro->vi_id_etnia;
        $filtro->vi_edad_del = $request->vi_edad_del ?? $filtro->vi_edad_del;
        $filtro->vi_edad_al = $request->vi_edad_al ?? $filtro->vi_edad_al;







        //leer formularios de filtros
        $filtro->con_transcripcion = isset($request->con_transcripcion) ? intval($request->con_transcripcion) : $filtro->con_transcripcion;
        $filtro->con_etiquetado = isset($request->con_etiquetado) ? intval($request->con_etiquetado) : $filtro->con_etiquetado;

        $filtro->entrevista_del = isset($request->entrevista_del_submit) ? $request->entrevista_del_submit : $filtro->entrevista_del;
        $filtro->entrevista_al = isset($request->entrevista_al_submit) ? $request->entrevista_al_submit : $filtro->entrevista_al;
        //Determinar si es lp, muni o depto
        if(isset($request->entrevista_lugar_depto)){
            if($request->entrevista_lugar_depto > 0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar_depto;
            }
        }
        if(isset($request->entrevista_lugar_muni)){
            if($request->entrevista_lugar_muni > 0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar_muni;
            }
        }
        if(isset($request->entrevista_lugar)){
            if($request->entrevista_lugar > 0) {
                $filtro->entrevista_lugar=$request->entrevista_lugar;
            }
        }
        $filtro->hechos_del = isset($request->hechos_del_submit) ? $request->hechos_del_submit : $filtro->hechos_del;
        $filtro->hechos_al = isset($request->hechos_al_submit) ? $request->hechos_al_submit : $filtro->hechos_al;
        $filtro->id_periodo = isset($request->id_periodo) ? $request->id_periodo : $filtro->id_periodo;
        if($filtro->id_periodo == 1) {
            $filtro->hechos_del = '1944-01-01';
            $filtro->hechos_al  = '1958-12-31';
        }
        elseif($filtro->id_periodo == 2) {
            $filtro->hechos_del = '1959-01-01';
            $filtro->hechos_al  = '1977-12-31';
        }
        elseif($filtro->id_periodo == 3) {
            $filtro->hechos_del = '1978-01-01';
            $filtro->hechos_al  = '1991-12-31';
        }
        elseif($filtro->id_periodo == 4) {
            $filtro->hechos_del = '1992-01-01';
            $filtro->hechos_al  = '2002-12-31';
        }
        elseif($filtro->id_periodo == 5) {
            $filtro->hechos_del = '2003-01-01';
            $filtro->hechos_al  = '2016-12-31';
        }
        elseif($filtro->id_periodo == 6) {
            $filtro->hechos_del = '2017-01-01';
            $filtro->hechos_al  = date("Y-m-d");
        }
        //Determinar si es lp, muni o depto
        //Determinar si es lp, muni o depto
        if(isset($request->hechos_lugar_depto)){
            if($request->hechos_lugar_depto > 0) {
                $filtro->hechos_lugar=$request->hechos_lugar_depto;
            }
        }
        if(isset($request->hechos_lugar_muni)){
            if($request->hechos_lugar_muni > 0) {
                $filtro->hechos_lugar=$request->hechos_lugar_muni;
            }
        }
        if(isset($request->hechos_lugar)){
            if($request->hechos_lugar > 0) {
                $filtro->hechos_lugar=$request->hechos_lugar;
            }
        }
        //Determinar si es macro o territorio
        if(isset($request->id_territorio)) {
            if($request->id_territorio>0) {
                $filtro->id_territorio=$request->id_territorio;
                $filtro->id_macroterritorio=$request->id_territorio_macro;
            }
            else {
                if($request->id_territorio_macro > 0) {
                    $filtro->id_macroterritorio=$request->id_territorio_macro;
                }
            }
        }
        else {  //Llamada directa desde una grafica
            if(isset($request->id_territorio_macro)) {
                $filtro->id_macroterritorio=$request->id_territorio_macro;
            }
        }


        $filtro->id_entrevistador = isset($request->id_entrevistador) ? $request->id_entrevistador : $filtro->id_entrevistador;
        //$filtro->id_macroterritorio = isset($request->id_macroterritorio) ? $request->id_macroterritorio : $filtro->id_macroterritorio;
        //$filtro->id_territorio = isset($request->id_territorio) ? $request->id_territorio : $filtro->id_territorio;
        $filtro->id_grupo = isset($request->id_grupo) ? $request->id_grupo : $filtro->id_grupo;
        $filtro->id_subserie = isset($request->id_subserie) ? $request->id_subserie : $filtro->id_subserie;
        $filtro->fr = isset($request->fr) ? $request->fr : $filtro->fr;
        $filtro->tv = isset($request->tv) ? $request->tv : $filtro->tv;
        $filtro->aa = isset($request->aa) ? $request->aa : $filtro->aa;
        $filtro->tc = isset($request->tc) ? $request->tc : $filtro->tc;
        $filtro->stc = isset($request->stc) ? $request->stc : $filtro->stc;
        $filtro->interes = isset($request->interes) ? $request->interes : $filtro->interes;


        $filtro->mandato = isset($request->mandato) ? $request->mandato : $filtro->mandato;
        $filtro->dinamica = isset($request->dinamica) ? $request->dinamica : $filtro->dinamica;
        $filtro->anotaciones = isset($request->anotaciones) ? $request->anotaciones : $filtro->anotaciones;
        $filtro->observaciones_diligenciada = isset($request->observaciones_diligenciada) ? $request->observaciones_diligenciada : $filtro->observaciones_diligenciada;
        $filtro->titulo = isset($request->titulo) ? $request->titulo : $filtro->titulo;
        $filtro->br = isset($request->br) ? $request->br : $filtro->br;
        $filtro->nna = isset($request->nna) ? $request->nna : $filtro->nna;

        $filtro->entrevista_correlativo = isset($request->entrevista_correlativo) ? $request->entrevista_correlativo : $filtro->entrevista_correlativo;
        $filtro->entrevista_codigo = isset($request->entrevista_codigo) ? $request->entrevista_codigo : $filtro->entrevista_codigo;

        $filtro->interes_area = isset($request->interes_area) ? $request->interes_area : $filtro->interes_area;
        $filtro->id_activo = isset($request->id_activo) ? $request->id_activo : $filtro->id_activo;
        $filtro->id_prioritario = isset($request->id_prioritario) ? $request->id_prioritario : $filtro->id_prioritario;
        $filtro->prioritario_tema = isset($request->prioritario_tema) ? $request->prioritario_tema : $filtro->prioritario_tema;
        $filtro->id_sector = isset($request->id_sector) ? $request->id_sector : $filtro->id_sector;
        $filtro->id_etnico = isset($request->id_etnico) ? $request->id_etnico : $filtro->id_etnico;
        $filtro->id_remitido = isset($request->id_remitido) ? $request->id_remitido : $filtro->id_remitido;
        $filtro->fichas_estado = isset($request->fichas_estado) ? $request->fichas_estado : $filtro->fichas_estado;
        $filtro->transcrita = isset($request->transcrita) ? intval($request->transcrita) : $filtro->transcrita;
        $filtro->etiquetada = isset($request->etiquetada) ? intval($request->etiquetada) : $filtro->etiquetada;

        //$filtro->id_tesauro = isset($request->id_tesauro) ? intval($request->id_tesauro) : $filtro->id_tesauro;
        $filtro->fts = isset($request->fts) ? $request->fts : $filtro->fts;
        $filtro->id_tesauro = isset($request->id_tesauro) ? $request->id_tesauro : $filtro->id_tesauro;
        $filtro->marca = isset($request->marca) ? $request->marca : $filtro->marca;
        $filtro->con_problemas = isset($request->con_problemas) ? $request->con_problemas : $filtro->con_problemas;
        $filtro->id_cerrado = isset($request->id_cerrado) ? $request->id_cerrado : $filtro->id_cerrado;

        //Tesauro
        if(isset($request->id_tesauro_depto)){
            if($request->id_tesauro_depto > 0) {
                $filtro->id_tesauro=$request->id_tesauro_depto;
            }
        }
        if(isset($request->id_tesauro_muni)){
            if($request->id_tesauro_muni > 0) {
                $filtro->id_tesauro=$request->id_tesauro_muni;
            }
        }
        if(isset($request->id_tesauro)){
            if($request->id_tesauro > 0) {
                $filtro->id_tesauro=$request->id_tesauro;
            }
        }
        //Tesauro_2
        if(isset($request->id_tesauro_2_depto)){
            if($request->id_tesauro_2_depto > 0) {
                $filtro->id_tesauro_2=$request->id_tesauro_2_depto;
            }
        }
        if(isset($request->id_tesauro_2_muni)){
            if($request->id_tesauro_2_muni > 0) {
                $filtro->id_tesauro_2=$request->id_tesauro_2_muni;
            }
        }
        if(isset($request->id_tesauro_2)){
            if($request->id_tesauro_2 > 0) {
                $filtro->id_tesauro_2=$request->id_tesauro_2;
            }
        }
        //Tesauro_3
        if(isset($request->id_tesauro_3_depto)){
            if($request->id_tesauro_3_depto > 0) {
                $filtro->id_tesauro_3=$request->id_tesauro_3_depto;
            }
        }
        if(isset($request->id_tesauro_3_muni)){
            if($request->id_tesauro_3_muni > 0) {
                $filtro->id_tesauro_3=$request->id_tesauro_3_muni;
            }
        }
        if(isset($request->id_tesauro_3)){
            if($request->id_tesauro_3 > 0) {
                $filtro->id_tesauro_3=$request->id_tesauro_3;
            }
        }



        ///Priorizacion
        $filtro->tipo_prioridad = isset($request->tipo_prioridad) ? $request->tipo_prioridad : $filtro->tipo_prioridad;
        $filtro->fluidez = isset($request->fluidez) ? $request->fluidez : $filtro->fluidez;
        $filtro->cierre = isset($request->cierre) ? $request->cierre : $filtro->cierre;
        $filtro->d_hecho = isset($request->d_hecho) ? $request->d_hecho : $filtro->d_hecho;
        $filtro->d_contexto = isset($request->d_contexto) ? $request->d_contexto : $filtro->d_contexto;
        $filtro->d_impacto = isset($request->d_impacto) ? $request->d_impacto : $filtro->d_impacto;
        $filtro->d_justicia = isset($request->d_justicia) ? $request->d_justicia : $filtro->d_justicia;
        $filtro->ahora_entiendo = isset($request->ahora_entiendo) ? $request->ahora_entiendo : $filtro->ahora_entiendo;
        $filtro->cambio_perspectiva = isset($request->cambio_perspectiva) ? $request->cambio_perspectiva : $filtro->cambio_perspectiva;
        //Priorizacion como valor minimo
        $filtro->d_hecho_min = isset($request->d_hecho_min) ? $request->d_hecho_min : $filtro->d_hecho_min;
        $filtro->d_contexto_min = isset($request->d_contexto_min) ? $request->d_contexto_min : $filtro->d_contexto_min;
        $filtro->d_impacto_min = isset($request->d_impacto_min) ? $request->d_impacto_min : $filtro->d_impacto_min;
        $filtro->d_justicia_min = isset($request->d_justicia_min) ? $request->d_justicia_min : $filtro->d_justicia_min;
        //Para filtrar fichas
        $filtro->violencia_anio_del = isset($request->violencia_anio_del) ? $request->violencia_anio_del : $filtro->violencia_anio_del;
        $filtro->violencia_anio_al = isset($request->violencia_anio_al) ? $request->violencia_anio_al : $filtro->violencia_anio_al;
        //$filtro->violencia_responsabilidad = isset($request->violencia_responsabilidad) ? $request->violencia_responsabilidad : $filtro->violencia_responsabilidad;
        $filtro->violencia_tipo = isset($request->violencia_tipo) ? $request->violencia_tipo : $filtro->violencia_tipo;

        //tipo y subtipo de violencia
        if(isset($request->violencia_tipo_depto)) {
            if($request->violencia_tipo_depto > 0) {
                $filtro->violencia_tipo=$request->violencia_tipo_depto;
            }
        }
        if(isset($request->violencia_tipo)) {
            if($request->violencia_tipo > 0) {
                $filtro->violencia_tipo=$request->violencia_tipo;
            }
        }
        //Geo3
        if(isset($request->violencia_lugar_depto)){
            if($request->violencia_lugar_depto > 0) {
                $filtro->violencia_lugar=$request->violencia_lugar_depto;
            }
        }
        if(isset($request->violencia_lugar_muni)){
            if($request->violencia_lugar_muni > 0) {
                $filtro->violencia_lugar=$request->violencia_lugar_muni;
            }
        }
        if(isset($request->violencia_lugar)){
            if($request->violencia_lugar > 0) {
                $filtro->violencia_lugar=$request->violencia_lugar;
            }
        }
        //Actor Armado
        if(isset($request->violencia_aa_depto)) {
            if($request->violencia_aa_depto > 0) {
                $filtro->violencia_aa=$request->violencia_aa_depto;
            }
        }
        if(isset($request->violencia_aa)) {
            if($request->violencia_aa > 0) {
                $filtro->violencia_aa=$request->violencia_aa;
            }
        }
        //Tercero civil
        if(isset($request->violencia_tc_depto)) {
            if($request->violencia_tc_depto > 0) {
                $filtro->violencia_tc=$request->violencia_tc_depto;
            }
        }
        if(isset($request->violencia_tc)) {
            if($request->violencia_tc > 0) {
                $filtro->violencia_tc=$request->violencia_tc;
            }
        }

        //$filtro->violencia_lugar = isset($request->cambio_perspectiva) ? $request->cambio_perspectiva : $filtro->cambio_perspectiva;

        //Para ocultar el formulario de filtros de las estadisticas
        if($filtro->id_territorio > 0)
            $filtro->hay_filtro = true;
        if($filtro->id_macroterritorio > 0)
            $filtro->hay_filtro = true;
        if($filtro->violencia_anio_del > 0)
            $filtro->hay_filtro = true;
        if($filtro->violencia_anio_al > 0)
            $filtro->hay_filtro = true;
        if($filtro->violencia_tipo > 0)
            $filtro->hay_filtro = true;
        if($filtro->violencia_lugar > 0)
            $filtro->hay_filtro = true;
        if($filtro->violencia_aa > 0)
            $filtro->hay_filtro = true;
        if($filtro->violencia_tc > 0)
            $filtro->hay_filtro = true;

        //En la buscadora, me permite saber si mostrar/contraer los filtros
        $filtro->hay_filtro_buscadora=false;
        if($filtro->id_tesauro_2 > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->id_tesauro_3 > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->mandato > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->interes > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->id_sector > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->d_hecho_min > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->d_impacto_min > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->d_contexto_min > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->d_justicia_min > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->id_etnico > 0) $filtro->hay_filtro_buscadora=true;
        if($filtro->id_excel_listados > 0) $filtro->hay_filtro_buscadora=true;
        if(strlen($filtro->fts)>0) $filtro->hay_filtro_buscadora=true;

        //Filtros de fichcas
        $filtro->pe_id_sexo = isset($request->pe_id_sexo) ? $request->pe_id_sexo : $filtro->pe_id_sexo;
        $filtro->pe_id_etnia = isset($request->pe_id_etnia) ? $request->pe_id_etnia : $filtro->pe_id_etnia;
        $filtro->pe_id_discapacidad = isset($request->pe_id_discapacidad) ? $request->pe_id_discapacidad : $filtro->pe_id_discapacidad;
        $filtro->pe_id_grupo_etario = isset($request->pe_id_grupo_etario) ? $request->pe_id_grupo_etario : $filtro->pe_id_grupo_etario;
        $filtro->vi_id_grupo_etario = isset($request->vi_id_grupo_etario) ? $request->vi_id_grupo_etario : $filtro->vi_id_grupo_etario;






        //Filtro por grupo
        if(\Auth::check()) {
            $usuario =\Auth::user();
            //Aplicar filtros por grupo
            if(in_array($usuario->id_nivel,[2,3,4])) {
                if($usuario->id_grupo <> 1) {
                    $filtro->id_grupo = $usuario->id_grupo;
                }
            }
        }

        //Para poder agregar el query string a a los links por GET
        if(is_object($request)) {
            if(method_exists($request,'fullUrl')) {
                $url = $request->fullUrl();
                $pedazos = explode("?",$url);
                if(isset($pedazos[1])) {
                    $filtro->url = $pedazos[1]."&";

                }
                else {
                    $filtro->url="";
                }
            }

        }
        //dd($filtro);

        //Para panel de fichas
        $filtro->hay_filtro=0;



        return $filtro;
    }

    //identificar los filtros usados en panel de estadisticas
    public static function contar_filtros_stats($filtros) {
        $conteo=0;
        //dd($filtros);
        if($filtros->entrevista_lugar>0) {
            $cual = geo::find($filtros->entrevista_lugar);
            //dd($cual);
            if($cual) {
                if ($cual->nivel == 3) {
                    $conteo++;
                    $conteo++;
                    $conteo++;
                }
                elseif ($cual->nivel == 2) {
                    $conteo++;
                    $conteo++;
                }
                else {
                    $conteo++;
                }
            }
        }
        if($filtros->id_territorio>0 ) {
            $conteo++;
        }
        if( $filtros->id_macroterritorio >0) {
            $conteo++;
        }

        if($filtros->violencia_tipo > 0 ) {
            $cual = tipo_violencia::find($filtros->violencia_tipo);
            if($cual) {
                if ($cual->nivel == 2) {
                    $conteo++;
                    $conteo++;
                } else {
                    $conteo++;
                }
            }

        }
        if($filtros->violencia_lugar>0 ) {
            $cual = geo::find($filtros->violencia_lugar);
            //dd($cual);
            if($cual) {
                if ($cual->nivel == 3) {
                    $conteo++;
                    $conteo++;
                    $conteo++;
                }
                elseif ($cual->nivel == 2) {
                    $conteo++;
                    $conteo++;
                }
                else {
                    $conteo++;
                }
            }
        }
        if($filtros->violencia_anio_del>0 ) {
            $conteo++;
        }
        if($filtros->violencia_anio_al>0 ) {
            $conteo++;
        }
        if($filtros->violencia_aa>0 ) {
            $cual = tipo_aa::find($filtros->violencia_aa);
            if($cual) {
                if ($cual->nivel == 2) {
                    $conteo++;
                    $conteo++;
                } else {
                    $conteo++;
                }
            }
        }
        if($filtros->violencia_tc>0 ) {
            $cual = tipo_tc::find($filtros->violencia_tc);
            if($cual) {
                if ($cual->nivel == 2) {
                    $conteo++;
                    $conteo++;
                } else {
                    $conteo++;
                }
            }
        }
        if($filtros->id_excel_listados > 0) {
            $listado = excel_listados::find($filtros->id_excel_listados);
            if($listado) {
                $conteo++;
                //Flash::warning("Aplicando filtrado general según el listado de códigos '$listado->descripcion'");
            }


        }
        //dd($filtros);
        return $conteo;

    }
    //Criterios de filtrado
    public static function scopeOrdenar($query) {
        $query->orderby('entrevista_correlativo');
    }
    public static function scopeId_Subserie($query,$id_subserie=-1) {
        $id_subserie=(integer)$id_subserie;
        if($id_subserie>0) {
            $query->where('e_ind_fvt.id_subserie',$id_subserie);
        }
    }
    public static function scopeId_activo($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('e_ind_fvt.id_activo',$criterio);
        }
    }
    public static function scopeFichas_Estado($query,$criterio=-1) {
        if($criterio>=0) {
            $query->where('e_ind_fvt.fichas_estado',$criterio);
        }
    }
    public static function scopeId_prioritario($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('id_prioritario',$criterio);
        }
    }
    public static function scopePrioritario_tema($query,$criterio=null) {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->where('prioritario_tema','ilike',"%$criterio%");
        }
    }
    public static function scopeId_Sector($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->wherein('id_sector',$criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->where('id_sector',$criterio);
            }
        }
    }
    public static function scopeId_Etnico($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('id_etnico',$criterio);
        }
    }
    public static function scopeId_Remitido($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('id_remitido',$criterio);
        }
    }
    //Para asingar etiquetado/transcripcion
    public static function scopeProcesable($query) {
        $a=array();
        $b=array();
        $c=array();
        //Primer grupo: virtuales
        $a = entrevista_individual::join('esclarecimiento.e_ind_fvt_adjunto as a_au','e_ind_fvt.id_e_ind_fvt','=','a_au.id_e_ind_fvt')
                                    ->where('a_au.id_tipo',2)
                                    ->where('es_virtual',1)->distinct()->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
        //Segundo grupo: no virtuales
        $b = entrevista_individual::join('esclarecimiento.e_ind_fvt_adjunto as a_au','e_ind_fvt.id_e_ind_fvt','=','a_au.id_e_ind_fvt')
            ->where('a_au.id_tipo',2)
            ->join('esclarecimiento.e_ind_fvt_adjunto as a_ci','e_ind_fvt.id_e_ind_fvt','=','a_ci.id_e_ind_fvt')
            ->where('a_ci.id_tipo',1)
            ->where('es_virtual',2)->distinct()->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();

        $c = array_merge($a, $b);
        $query->wherein('e_ind_fvt.id_e_ind_fvt',$c);


    }

    //Priorizacion
    public static function scopeTipo_prioridad($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp0','e_ind_fvt.id_e_ind_fvt','=','fp0.id_entrevista')
                ->whereraw(\DB::raw('fp0.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp0.id_tipo',$criterio);
        }
    }
    public static function scopeFluidez($query,$criterio=-1) {
        //dd("Filtrar $criterio");
        if($criterio>=0) {
            $query->join('prioridad as fp1','e_ind_fvt.id_e_ind_fvt','=','fp1.id_entrevista')
                    ->whereraw(\DB::raw('fp1.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                    //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                    ->where('fp1.fluidez',$criterio);
        }
    }
    public static function scopeCierre($query,$criterio=-1) {
        if($criterio>=0) {
            $query->join('prioridad as fp2','e_ind_fvt.id_e_ind_fvt','=','fp2.id_entrevista')
                ->whereraw(\DB::raw('fp2.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp2.cierre',$criterio);
        }
    }
    public static function scopeD_hecho($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','e_ind_fvt.id_e_ind_fvt','=','fp3.id_entrevista')
                ->whereraw(\DB::raw('fp3.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp3.d_hecho',$criterio);
        }
    }
    public static function scopeD_impacto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','e_ind_fvt.id_e_ind_fvt','=','fp4.id_entrevista')
                ->whereraw(\DB::raw('fp4.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp4.d_impacto',$criterio);
        }
    }
    public static function scopeD_contexto($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','e_ind_fvt.id_e_ind_fvt','=','fp5.id_entrevista')
                ->whereraw(\DB::raw('fp5.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp5.d_contexto',$criterio);
        }
    }
    public static function scopeD_justicia($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','e_ind_fvt.id_e_ind_fvt','=','fp6.id_entrevista')
                ->whereraw(\DB::raw('fp6.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp6.d_justicia',$criterio);
        }
    }
    public static function scopeAhora_entiendo($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp7','e_ind_fvt.id_e_ind_fvt','=','fp7.id_entrevista')
                ->whereraw(\DB::raw('fp7.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp7.ahora_entiendo','ilike',"%$criterio%");
        }
    }
    public static function scopeCambio_perspectiva($query,$criterio="") {
        $criterio = trim($criterio);
        if(strlen($criterio) > 0) {
            $criterio = str_replace(" ", "%",$criterio);
            $query->join('prioridad as fp8','e_ind_fvt.id_e_ind_fvt','=','fp8.id_entrevista')
                ->whereraw(\DB::raw('fp8.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp8.cambio_perspectiva','ilike',"%$criterio%");
        }
    }
    //Valores minimos
    public static function scopeD_hecho_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp3','e_ind_fvt.id_e_ind_fvt','=','fp3.id_entrevista')
                ->whereraw(\DB::raw('fp3.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp3.d_hecho','>=',$criterio);
        }
    }
    public static function scopeD_impacto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp4','e_ind_fvt.id_e_ind_fvt','=','fp4.id_entrevista')
                ->whereraw(\DB::raw('fp4.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp4.d_impacto','>=',$criterio);
        }
    }
    public static function scopeD_contexto_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp5','e_ind_fvt.id_e_ind_fvt','=','fp5.id_entrevista')
                ->whereraw(\DB::raw('fp5.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp5.d_contexto','>=',$criterio);
        }
    }
    public static function scopeD_justicia_min($query,$criterio=-1) {
        if($criterio > 0) {
            $query->join('prioridad as fp6','e_ind_fvt.id_e_ind_fvt','=','fp6.id_entrevista')
                ->whereraw(\DB::raw('fp6.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                //->where('fp1.id_subserie','=','e_ind_fvt.id_subserie')
                ->where('fp6.d_justicia','>=',$criterio);
        }
    }


    /*
     * SEGURIDAD
     * Además del scopePermisos, aplicar estas reglas
     */

    //De acuerdo al perfil, aplica los permisos
    public static function scopePermisos_bak($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->wherein('e_ind_fvt.id_entrevistador',$arreglo_entrevistadores);

        if(\Auth::check()) {  //Transcriptores
            if(\Auth::user()->id_nivel==11) {
                $asignadas = transcribir_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                                ->where('id_situacion',1)
                                ->pluck('id_e_ind_fvt');
                //dd($asignadas);

                $query->wherein('e_ind_fvt.id_e_ind_fvt',$asignadas);

            }
        }
    }

    //Scope para filtrar por listados cargados en excel
    public static function scopeId_excel_listados($query,$criterio) {
        if($criterio > 0) {
            $listado = excel_listados::find($criterio);
            if($listado) {
                $codigos = excel_listados::arreglo_codigos($criterio);
                $query->wherein('entrevista_codigo',$codigos);
            }
        }
    }

    //De acuerdo al perfil, aplica los permisos.  Nueva versión de acuerdo al perfil
    /* LOGICA:
     * 1. Determina el acceso según el nivel (entrevistador, coord. territorio, coord. macro, etc.)
     * 2. Quita confidenciales  (ajenos)
     * 3. aplica filtro por grupo  (solo ruta pacifica, oim, etc.)
     */
    public static function scopePermisos($query) {
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            $asignadas = entrevista_individual::arreglo_asignaciones(config("expedientes.vi"),'id_e_ind_fvt'); //el 'expedientes.vi'es ignorado
            if(count($asignadas) > 0) {
                $id_macroterritorio=\Auth::user()->id_macroterritorio;
                $asignadas_where=implode(",",$asignadas);
                $query->whereraw(DB::raw("( e_ind_fvt.id_macroterritorio = $id_macroterritorio  OR e_ind_fvt.id_e_ind_fvt in ($asignadas_where) )"));
            }
            else {
                $query->where('e_ind_fvt.id_macroterritorio',\Auth::user()->id_macroterritorio);
            }

        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            $asignadas = entrevista_individual::arreglo_asignaciones();
            if(count($asignadas) > 0) {
                $id_territorio=\Auth::user()->id_territorio;
                $asignadas_where=implode(",",$asignadas); //Arreglo de entrevistas asignadas
                $sql="( e_ind_fvt.id_territorio = $id_territorio  OR e_ind_fvt.id_e_ind_fvt in ($asignadas_where) )";
                $query->whereraw(DB::raw($sql));
            }
            else {
                $query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
            }
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas(); //Asignación de otros entrevistadores
            $asignadas = entrevista_individual::arreglo_asignaciones(config("expedientes.vi"),'id_e_ind_fvt');
            if(count($asignadas) > 0) {
                $id_macroterritorio=\Auth::user()->id_macroterritorio;
                $asignadas_where=implode(",",$asignadas); //Arreglo de entrevistas asignadas
                $entrevistadores_where = implode(",", $arreglo_entrevistadores);  //Arreglo de entrevistadores asignados
                $query->whereraw(DB::raw("( e_ind_fvt.id_entrevistador in ($entrevistadores_where)  OR e_ind_fvt.id_e_ind_fvt in ($asignadas_where) )"));
            }
            else {
                $query->wherein('e_ind_fvt.id_entrevistador',$arreglo_entrevistadores);
            }

        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            // Entrevistas asignadas
            $asignadas = entrevista_individual::arreglo_asignaciones();
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$asignadas);
        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('e_ind_fvt.id_entrevistador',-1); //Ninguno
        }

        /*
        //Siempre quitar los otros confidenciales
        if(\Auth::check()) {
            $id_entrevistador = \Auth::user()->id_entrevistador;
        }
        else {
            $id_entrevistador = 0;
        }
        $otros_confidenciales=entrevistador::where('id_nivel',6)
            ->where('id_entrevistador','<>',$id_entrevistador)
            ->pluck('id_entrevistador')->toArray();
        $query->whereNotIn('e_ind_fvt.id_entrevistador',$otros_confidenciales);
        */
        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);

        //Si es de un grupo ajeno, agregar el filtro del grupo  (ruta pacifica, oim, etc).  Esto reduce la cantidad para los niveles superiores
        // OJO: este filtro hace conflicto con las asignaciones.
        if(Gate::allows('grupo-ajeno')) {
            $query->join('esclarecimiento.entrevistador as fsg','e_ind_fvt.id_entrevistador','=','fsg.id_entrevistador')
                ->where('fsg.id_grupo',\Auth::user()->id_grupo);
        }


    }

    //De acuerdo al perfil, aplica los permisos.  Nueva versión de acuerdo al perfil
    /* LOGICA:
     * 1. Determina el acceso según el nivel (entrevistador, coord. territorio, coord. macro, etc.)
     * 2. Quita confidenciales  (ajenos)
     * 3. aplica filtro por grupo  (solo ruta pacifica, oim, etc.)
     * Actualizacion a 17-feb.  Todos pueden ver los metadatos
     */
    public static function scopePermisos_new($query) {
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //Sin filtro, acceso total
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','e_ind_fvt.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo);
            }
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','e_ind_fvt.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('e_ind_fvt.id_macroterritorio',\Auth::user()->id_macroterritorio);
            }
            //$query->where('e_ind_fvt.id_macroterritorio',\Auth::user()->id_macroterritorio);
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','e_ind_fvt.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
            }
            //$query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            if(Gate::allows('grupo-ajeno')) {
                $query->join('esclarecimiento.entrevistador as fsg','e_ind_fvt.id_entrevistador','=','fsg.id_entrevistador')
                    ->where('fsg.id_grupo',\Auth::user()->id_grupo)
                    ->where('e_ind_fvt.id_entrevistador',\Auth::user()->id_entrevistador);
            }
        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            //Ni maiz
            $query->where('e_ind_fvt.id_entrevistador',-1);
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            //Sin filtro, acceso total
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            // Entrevistas asignadas
            $asignadas_t = transcribir_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                ->where('id_situacion',1)
                ->pluck('id_e_ind_fvt')->toArray();
            $asignadas_e = etiquetar_asignacion::where('id_transcriptor',\Auth::user()->id_entrevistador)
                ->where('id_situacion',1)
                ->pluck('id_e_ind_fvt')->toArray();

            $asignaciones = array_merge($asignadas_t, $asignadas_e);

            $query->wherein('e_ind_fvt.id_e_ind_fvt',$asignaciones);

        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            $query->where('e_ind_fvt.id_entrevistador',-1); //Ninguno
        }

        //Siempre quitar los otros confidenciales
        /*
        if(\Auth::check()) {
            $id_entrevistador = \Auth::user()->id_entrevistador;
        }
        else {
            $id_entrevistador = 0;
        }
        $otros_confidenciales=entrevistador::where('id_nivel',6)
            ->where('id_entrevistador','<>',$id_entrevistador)
            ->pluck('id_entrevistador')->toArray();
        $query->whereNotIn('e_ind_fvt.id_entrevistador',$otros_confidenciales);

        $debug['sql']= nl2br($query->toSql());
        $debug['criterios']=$query->getBindings();
        //dd($debug);
        */



    }


    // Funcion que me evita que todas las entrevistas tengan copy+paste de la misma funcion getPuedeAccederEntrevistaAttribute
    // Importante que usa funciones comunes: revisar_asignacion(), rel_id_entrevistador()
    //Recibe como parametro, la entrevista misma
    //Esta versión permite que todos accedan a todas las entrevistas. Fue desactivada el 24/feb/20
    public static function revisar_acceso_a_entrevista_full_power($entrevista) {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }

        //dd("Mirame");


        if(Gate::allows('revisar-m-nivel',array([1,2,3,4,5])) ) { //Admin, Esclarecimiento, coordinador macro, coordinador territorio, entrevistador.  Ojo con los de otros grupos
            if(Gate::allows('grupo-ajeno')) {
                $activo = \Auth::user()->rel_entrevistador;
                //dd($activo);
                $puede = in_array($entrevista->id_entrevistador, $activo->arreglo_mismo_grupo());
            }
            else {
                $puede=true;
            }

            return $puede;
        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            return true;
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            return false;
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            return true;
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            return $entrevista->revisar_asignacion();
        }
        else {  //Otros, incluye deshabilitados.  Por defecto se deniega el acceso
            return false;
        }
    }
    //Cambio del 24/2/20:  Regreso a como estaba antes, según el nivel.
    public static function revisar_acceso_a_entrevista($entrevista) {
        if(Gate::check('permisos-legado')) {
            return true;
        }
        if(\Auth::check()) {
            $usuario=\Auth::user();
            $activo = \Auth::user()->rel_entrevistador;
        }
        else {
            return false;
        }

        //Si es propia entrevista, se puede
        if(Gate::check('es-propio',$entrevista->id_entrevistador)) {
            return true;
        }

        //Si tiene asignado el grupo, se vale
        //Grupos asignados (ruta pacifica, oim, etc.
        $arreglo_asignados=entrevistador::entrevistadores_asignados($activo->id_entrevistador);
        if(in_array($entrevista->id_entrevistador, $arreglo_asignados)) {
            return true;
        }


        //No se hace el else, porque hay que evaluar según el perfil

        //Verificar si le han compartido alguna entrevista.
        //  Esta función debe existir en c/modelo ya que en esa función se especifica la llave primaria y el id_subserie
        if($entrevista->revisar_asignacion()) {
            return true;
        }


        if(Gate::allows('nivel-1-2')) { //Admin, Esclarecimiento, coordinador macro, coordinador territorio, entrevistador.  Ojo con los de otros grupos
            if(Gate::allows('grupo-ajeno')) {
                $puede = in_array($entrevista->id_entrevistador, $activo->arreglo_mismo_grupo());
            }
            else {
                $puede=true;
            }
            return $puede;
        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador macro
            if(Gate::allows('grupo-ajeno')) {
                $puede = in_array($entrevista->id_entrevistador, $activo->arreglo_mismo_grupo());
            }
            else {
                return $entrevista->id_macroterritorio == $activo->id_macroterritorio;
            }

        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            if(Gate::allows('grupo-ajeno')) {
                $puede = in_array($entrevista->id_entrevistador, $activo->arreglo_mismo_grupo());
            }
            else {
                return $entrevista->id_territorio == $activo->id_territorio;
            }
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //entrevistador
            return $entrevista->id_entrevistador == $activo->id_entrevistador;
        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            return true;
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            return false;
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            return true;
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            return $entrevista->revisar_asignacion();
        }
        else {  //Otros, incluye deshabilitados.  Por defecto se deniega el acceso
            return false;
        }
    }

    //Igual, me ahorra copy+paste y establece un punto unico de mantenimiento
    public static function revisar_modificar_entrevista($entrevista) {
        if(Gate::check('sistema-cerrado')) {
            return false;
        }

        $id_entrevistador = $entrevista->id_entrevistador;

        //Expedientes ya procesados, no se pueden modificar, por nadie
        if($entrevista->id_cerrado == 1) {
            if(Gate::allows('nivel-1-2-super') ) { //Administrador
                return true;
            }
            return false;
        }


        //Verificar si le han compartido alguna entrevista.
        //  Esta función debe existir en c/modelo ya que en esa función se especifica la llave primaria y el id_subserie
        if($entrevista->revisar_asignacion()) {
            return true;
        }


        if(Gate::allows('es-propio',$entrevista->id_entrevistador)) {
            return true;
        }




        //Revisar según el perfil
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            return true;
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            $puede=false;
            if(Gate::allows('solo-lectura')) {
                $puede=false;
            }
            else {
                if(Gate::allows('grupo-ajeno')) {
                    $activo = \Auth::user()->rel_entrevistador;
                    $puede = in_array($id_entrevistador, $activo->arreglo_mismo_grupo());
                }
                else {
                    $puede=true;
                }
            }
            return $puede;

        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro

            $puede=false;
            if(Gate::allows('solo-lectura')) {
                $puede=false;
            }
            else {
                if (Gate::allows('grupo-ajeno')) {

                    $activo = \Auth::user()->rel_entrevistador;
                    //dd($activo->arreglo_mismo_grupo());
                    $puede = in_array($id_entrevistador, $activo->arreglo_mismo_grupo());
                    //dd($id_entrevistador);
                } else {
                    $puede = $entrevista->id_macroterritorio == \Auth::user()->id_macroterritorio;  //Misma macro;
                }
            }
            return $puede;
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            $puede=false;
            if(Gate::allows('solo-lectura')) {
                $puede=false;
            }
            else {
                if (Gate::allows('grupo-ajeno')) {
                    $activo = \Auth::user()->rel_entrevistador;
                    $puede = in_array($id_entrevistador, $activo->arreglo_mismo_grupo());
                } else {
                    $puede = $entrevista->id_territorio == \Auth::user()->id_territorio;  //Mismo territorio
                }
            }
            return $puede;
            //$query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador

            //que sea propio, o de los grupos que se asignaron
            return Gate::allows('es-propio',$entrevista->id_entrevistador);  //verifica 'a nombre de...'

        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial: que no puedan cambiar cosas
            //return true;
            return Gate::allows('es-propio',$entrevista->id_entrevistador);  //verifica 'a nombre de...'
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            return false;
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            return true;
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores

            return $entrevista->revisar_asignacion();
        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            return false;
        }

        //Por si acaso
        return false;
    }



    // Otra funcion estática para ver acceso a adjuntos R3 y R4
    // Las clases deben tener ->rel_acceso_reservado()  ->revisar_asignacion()
    public static function revisar_acceso_adjuntos($entrevista) {
        if(Gate::check('permisos-legado')) {
            return true;
        }
        if(\Auth::check()) {
            $entrevistador = \Auth::user()->rel_entrevistador;
        }
        else {
            return false;
        }

        //Siempre puede ver las propias
        if(Gate::allows('es-propio',$entrevista->id_entrevistador)) {
            return true;
        }

        //Siempre que esté asignada para transcribir/editar, conceder acceso.
        if($entrevista->revisar_asignacion()) {
            return true;
        }

        //Siempre que haya sido compartida, puede acceder
        $hay_autorizacion = entrevista_individual::revisar_acceso_edicion($entrevista);
        if($hay_autorizacion) {
            return true;
        }

        //El campo se llama diferente en la tabla de entrevistas individuales (puro mula)
        $nivel = isset($entrevista->clasifica_nivel) ? $entrevista->clasifica_nivel : $entrevista->clasificacion_nivel;


        //R-4: acceso sin restricciones
        if($nivel == 4) {
            return true;
        }

        //Permisos asignados explícitamente (desclasificada)
        $existe = $entrevista->rel_acceso_reservado()->where('id_autorizado',$entrevistador->id_entrevistador)
            ->where('fh_del','<=',Carbon::now()->format("Y-m-d 00:00:00"))
            ->where('fh_al','>=',Carbon::now()->format("Y-m-d 23:59:59"))
            ->first();
        if($existe) {
            return true;
        }

        //R-1: Solo el dueño o a quien el dueño autorice (ya revisado previamente en las lineas anteriores)
        if($nivel == 1) {
            //Ya se revisaron todas las excepciones, se coloca esta validación para no continuar con el resto de validaciones para R-2 y R-3
            return false;
        }



        //Perfiles que liberan algunos R-3, según la condición
        if($nivel==3) {
            //Violencia Sexual
            if($entrevistador->r3_vs == 1) {
                $sex = isset($entrevista->clasifica_sex) ? $entrevista->clasifica_sex : $entrevista->clasificacion_sex;
                if($sex==1) {
                    return true;
                }
            }
            //NNA
            if($entrevistador->r3_nna == 1) {
                $nna = isset($entrevista->clasifica_nna) ? $entrevista->clasifica_nna : $entrevista->clasificacion_nna;
                if($nna==1) {
                    return true;
                }
            }
            //Reconocimiento de responsabilidades
            if($entrevistador->r3_ri == 1) {
                $res = isset($entrevista->clasifica_res) ? $entrevista->clasifica_res : $entrevista->clasificacion_res;
                if($res==1) {
                    return true;
                }
            }
            //AA o TC
            if($entrevistador->r3_aa == 1) {
                if(isset($entrevista->id_subserie)){
                    if($entrevista->id_subserie==config('expedientes.aa') || $entrevista->id_subserie==config('expedientes.tc')){
                        return true;
                    }
                }
            }
        }





        //Solo lectura: denegado, independiente del nivel de acceso
        if(Gate::allows('solo-lectura')) {
             return false;
        }


        //Revisar según el perfil
        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            return true;
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            $puede=false;
            if(Gate::allows('solo-lectura')) {  //Ya revisado, pero por si acaso
                $puede=false;
            }
            else {
                if(Gate::allows('grupo-ajeno')) {
                    $puede = in_array($entrevistador->id_entrevistador, $entrevistador->arreglo_mismo_grupo());
                }
                else {
                    $puede=true;
                }
            }
            return $puede;

        }
        elseif(Gate::allows('revisar-nivel',3) ) { //Coordinador Macro
            if(Gate::allows('solo-lectura')) {  //Ya revisado, pero por si acaso
                $puede=false;
            }
            else {
                if (Gate::allows('grupo-ajeno')) {
                    $puede = in_array($entrevistador->id_entrevistador, $entrevistador->arreglo_mismo_grupo());
                } else {
                    $puede = $entrevista->id_macroterritorio == $entrevistador->id_macroterritorio;  //Misma macro;
                }
            }
            //dd($entrevistador);
            return $puede;
        }
        elseif(Gate::allows('revisar-nivel',4) ) { //Coordinador territorio
            if(Gate::allows('solo-lectura')) {  //Ya revisado, pero por si acaso
                $puede=false;
            }
            else {
                if (Gate::allows('grupo-ajeno')) {
                    $puede = in_array($entrevistador->id_entrevistador, $entrevistador->arreglo_mismo_grupo());
                } else {
                    $puede = $entrevista->id_territorio == $entrevistador->id_territorio;  //Mismo territorio
                }

            }
            return $puede;
            //$query->where('e_ind_fvt.id_territorio',\Auth::user()->id_territorio);
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            //que sea propio, o de los grupos que se asignaron
            return Gate::allows('es-propio',$entrevista->id_entrevistador);  //verifica 'a nombre de...'
        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            return true;
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            return false;
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            return true;
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
            return $entrevista->revisar_asignacion();  //Ya se hizo antes, pero por si acaso
        }
        else {  //Otros, incluye deshabilitados.  Por defecto ninguno
            return false;
        }

        //Por si acaso
        return false;
    }


    //Para saber si puede conceder acceso en el modulo de conceder acceso
    public static function revisar_conceder_acceso($entrevista) {
        if(Gate::check('sistema-cerrado')) {
            return false;
        }
        if(\Auth::check()) {
            $entrevistador = \Auth::user()->rel_entrevistador;
        }
        else {
            return false;
        }



        //Nueva regla: el propietario solo si es R3
        $nivel = isset($entrevista->clasifica_nivel) ? $entrevista->clasifica_nivel : $entrevista->clasificacion_nivel;

        //R-1: solo por propietarios
        if($nivel == 1 ) {
            return Gate::allows('es-propio',$entrevista->id_entrevistador);
        }

        //Los propios, siempre
        if( Gate::allows('es-propio',$entrevista->id_entrevistador)) {
            if($nivel<=2) {
                return true;  //Cambio solicitado por andres emdina el 20 marzo
            }
            return true;
        }

        if(Gate::allows('revisar-nivel',1) ) { //Administrador
            return true;
        }
        elseif(Gate::allows('revisar-nivel',2) ) { //Esclarecimiento
            //nueva regla: no puede si es R2
            if($nivel<=2) {
                return false;
            }

            $puede=false;
            if(Gate::allows('solo-lectura')) {
                $puede=false;
            }
            else {
                if(Gate::allows('grupo-ajeno')) {
                    $puede = in_array($entrevistador->id_entrevistador, $entrevistador->arreglo_mismo_grupo());
                }
                else {
                    $puede=true;
                }
            }
            return $puede;
        }
        elseif(Gate::allows('revisar-nivel',5) ) { //Entrevistador
            if($nivel<=2) {
                return false;
            }

            //que sea propio, o de los grupos que se asignaron
            return Gate::allows('es-propio',$entrevista->id_entrevistador);  //verifica 'a nombre de...'

        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            //que sea propio, o de los grupos que se asignaron
            return Gate::allows('es-propio',$entrevista->id_entrevistador);  //verifica 'a nombre de...'

        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
            return true;
        }

        //Si no aceptó ninguno de los anteriores, no se puede
        return false;
    }

    //Para saber si se le ha facilitado acceso de escritura por medio del modulo de conceder acceso
    public static function revisar_acceso_edicion($entrevista) {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }

        if(isset($entrevista->id_e_ind_fvt)) {
            //$id_subserie=config('expedientes.vi');
            $id_subserie=$entrevista->id_subserie;
            $id_primaria = $entrevista->id_e_ind_fvt;
        }
        else if(isset($entrevista->id_entrevista_colectiva)) {
            $id_subserie=config('expedientes.co');
            $id_primaria = $entrevista->id_entrevista_colectiva;
        }
        elseif(isset($entrevista->id_entrevista_etnica)) {
            $id_subserie=config('expedientes.ee');
            $id_primaria = $entrevista->id_entrevista_etnica;
        }
        elseif(isset($entrevista->id_entrevista_profundidad)) {
            $id_subserie=config('expedientes.pr');
            $id_primaria = $entrevista->id_entrevista_profundidad;
        }
        elseif(isset($entrevista->id_diagnostico_comunitario)) {
            $id_subserie=config('expedientes.dc');
            $id_primaria = $entrevista->id_diagnostico_comunitario;
        }
        elseif(isset($entrevista->id_historia_vida)) {
            $id_subserie=config('expedientes.hv');
            $id_primaria = $entrevista->id_historia_vida;
        }
        else {
            return false;
        }

        $hay_autorizacion = acceso_edicion::where('id_subserie',$id_subserie)
                                    ->where('id_entrevista',$id_primaria)
                                    ->where('id_situacion',1)
                                    ->where('id_autorizado',$usuario->id_entrevistador)
                                    ->first();
        return $hay_autorizacion;
    }


    //Funcion para el controller, me permite determinar si se puede acceder o no a la entrevista en sí (usado en show y edit)
    public function getPuedeAccederEntrevistaAttribute() {

        return entrevista_individual::revisar_acceso_a_entrevista($this);

        /*
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }


        if(Gate::allows('revisar-m-nivel',array([1,2,3,4,5])) ) { //Admin, Esclarecimiento, coordinador macro, coordinador territorio, entrevistador.  Ojo con los de otros grupos
            if(Gate::allows('grupo-ajeno')) {
                $activo = \Auth::user()->rel_entrevistador;
                $puede = in_array($this->id_entrevistador, $activo->arreglo_mismo_grupo());
            }
            else {
                $puede=true;
            }
            return true;
        }
        elseif(Gate::allows('revisar-nivel',6) ) { //Confidencial
            return true;
        }
        elseif(Gate::allows('revisar-nivel',7) ) { //Estadistico
            return false;
        }
        elseif(Gate::allows('revisar-nivel',10) ) { //Coordinador transcriptores
           return true;
        }
        elseif(Gate::allows('revisar-nivel',11) ) { //Transcriptores
           return $this->revisar_asignacion();
        }
        else {  //Otros, incluye deshabilitados.  Por defecto se deniega el acceso
            return false;
        }
        */

    }

    // Para evaluar el acceso a adjuntos  (r3 y r2)
    public function puede_acceder_adjuntos($id_entrevistador=0) {
        return   entrevista_individual::revisar_acceso_adjuntos($this);

    }

    public function puede_modificar_entrevista($id_entrevistador = 0) {
        return entrevista_individual::revisar_modificar_entrevista($this);
    }

    //igual a puede_modificar_entrevista, pero no revisa que esté cerrada
    public function puede_desclasificar_entrevista() {
        return entrevista_individual::revisar_conceder_acceso($this);

    }

    //Ver si fue asignada para transcribir
    public function revisar_asignacion() {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }

        $asignaciones = $this->arreglo_asignaciones();


        return in_array($this->id_e_ind_fvt,$asignaciones);
    }

    //Para el scope de permisos
    public static function arreglo_asignaciones($id_subserie=0,$llave_primaria="") {
        if(\Auth::check()) {
            $usuario=\Auth::user();
        }
        else {
            return false;
        }
        //$id_subserie = $id_subserie > 0 ? $id_subserie : config("expedientes.vi");
        $llave_primaria = strlen($llave_primaria) > 0 ? $llave_primaria : 'id_e_ind_fvt';
        $asignadas_t = transcribir_asignacion::where('id_transcriptor',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->pluck($llave_primaria)->toArray();

        $asignadas_e = etiquetar_asignacion::where('id_transcriptor',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->pluck($llave_primaria)->toArray();

        $asignadas_m = acceso_edicion::where('id_autorizado',$usuario->id_entrevistador)
            ->where('id_situacion',1)
            ->wherein('id_subserie',array(config('expedientes.vi'), config('expedientes.aa'), config('expedientes.tc') ))
            ->pluck('id_entrevista')->toArray();


        $asignaciones = array_merge($asignadas_t, $asignadas_e, $asignadas_m);
        //Eliminar los valores no validos como null
        $limpio=array();
        foreach($asignaciones as $val) {
            if($val > 0) {
                $limpio[]=$val;
            }
        }
        return $limpio;
    }

    /////////////////////// FIN de controles de seguridad //////////



    public static function scopeentrevista_del($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("entrevista_fecha",'>=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeEntrevista_al($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("entrevista_fecha",'<=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeEntrevista_Lugar($query,$id_geo=-1) {
        if($id_geo>0) {
            $query->wherein('entrevista_lugar',geo::arreglo_contenidos($id_geo));
        }
    }
    public static function scopeHechos_del($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("hechos_del",'>=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeHechos_al($query, $criterio="") {
        if(strlen($criterio)>=8) {
            try {
                $fecha=Carbon::createFromFormat("Y-m-d H:i:s",$criterio." 00:00:00");
                $query->where("hechos_al",'<=',$fecha);
            }
            catch(\Exception $e) {
                //No pasa nada, fecha invalida
            }
        }
    }
    public static function scopeHechos_Lugar($query,$id_geo=-1) {
        if($id_geo>0) {
            $query->wherein('hechos_lugar',geo::arreglo_contenidos($id_geo));
        }
    }
    public static function scopeId_entrevistador($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->wherein('esclarecimiento.e_ind_fvt.id_entrevistador',$criterio);
        }
        elseif($criterio>0) {
            $query->where('esclarecimiento.e_ind_fvt.id_entrevistador',$criterio);
        }
    }
    public static function scopeId_macroterritorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('e_ind_fvt.id_macroterritorio',$criterio);
        }
    }
    public static function scopeId_territorio($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('e_ind_fvt.id_territorio',$criterio);
        }
    }
    public static function scopeId_grupo($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('esclarecimiento.entrevistador as fe','e_ind_fvt.id_entrevistador','=','fe.id_entrevistador')
                ->where('fe.id_grupo',$criterio);
        }
    }
    public static function scopeNna($query,$criterio=-1) {
        if($criterio>0) {
            $query->where('nna',$criterio);
        }
    }
    public static function scopeAnotaciones($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('anotaciones','ilike',"%$criterio%");
        }
    }
    public static function scopeEntrevista_correlativo($query,$criterio=-1) {
        $criterio=intval($criterio);
        if($criterio>0) {
            $query->where('entrevista_correlativo',$criterio);
        }
    }
    public static function scopeEntrevista_codigo($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $query->where('entrevista_codigo','ilike',"%$criterio%");
        }
    }
    //Busqueda rapida
    public static function scopeBR($query,$criterio="") {
        $criterio=trim($criterio);
        if(is_numeric($criterio) and intval($criterio)>0) {
            $query->where('entrevista_correlativo',$criterio);
        }
        elseif(strlen($criterio) > 0) {
            $criterio=str_replace(" ","%",$criterio);
            $where[]="anotaciones ilike '%$criterio%'";
            $where[]="entrevista_codigo ilike '%$criterio%'";
            $where[]="titulo ilike '%$criterio%'";
            $where[]="prioritario_tema ilike '%$criterio%'";
            //$where[]="dinamica ilike "%$criterio%"";
            $str_where=implode(" or ",$where);
            //$query->join('esclarecimiento.e_ind_fvt_dinamica as fd','e_ind_fvt.id_e_ind_fvt','=','fd.id_e_ind_fvt')
             //       ->whereraw("( $str_where )");
            $query->whereraw(" ( $str_where )");

        }
    }
    public static function scopeFr($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->join('esclarecimiento.e_ind_fvt_fr as ffr','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','ffr.id_e_ind_fvt')
                    ->wherein('id_fr',$criterio);
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_fr as ffr','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','ffr.id_e_ind_fvt')
                    ->where('id_fr',$criterio);
            }
        }
    }
    public static function scopeTv($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->join('esclarecimiento.e_ind_fvt_tv as ftv','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','ftv.id_e_ind_fvt')
                ->wherein('id_tv',$criterio);
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_tv as ftv','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','ftv.id_e_ind_fvt')
                    ->where('id_tv',$criterio);
            }
        }
    }
    public static function scopeAa($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->join('esclarecimiento.e_ind_fvt_aa as faa','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','faa.id_e_ind_fvt')
                ->wherein('id_aa',$criterio);
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_aa as faa','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','faa.id_e_ind_fvt')
                    ->where('id_tv',$criterio);
            }
        }
    }
    public static function scopeTc($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->join('esclarecimiento.e_ind_fvt_tc as ftc','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','ftc.id_e_ind_fvt')
                ->wherein('id_tc',$criterio);
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_tc as ftc','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','ftc.id_e_ind_fvt')
                    ->where('id_tc',$criterio);
            }
        }
    }
    public static function scopeStc($query,$criterio=-1) {
        if(is_array($criterio)) {
            $query->join('esclarecimiento.e_ind_fvt_stc as fstc','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','fstc.id_e_ind_fvt')
                ->wherein('id_stc',$criterio);
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_stc as fstc','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','fstc.id_e_ind_fvt')
                    ->where('id_stc',$criterio);
            }
        }
    }
    public static function scopeInteres($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.e_ind_fvt_interes as finteres', 'esclarecimiento.e_ind_fvt.id_e_ind_fvt', '=', 'finteres.id_e_ind_fvt')
                    ->wherein('finteres.id_interes', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_interes as finteres','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','finteres.id_e_ind_fvt')
                    ->where('finteres.id_interes',$criterio);
            }
        }
    }
    public static function scopeInteres_Area($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.e_ind_fvt_interes_area as finteresa', 'esclarecimiento.e_ind_fvt.id_e_ind_fvt', '=', 'finteresa.id_e_ind_fvt')
                    ->wherein('finteresa.id_interes', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_interes_area as finteresa', 'esclarecimiento.e_ind_fvt.id_e_ind_fvt', '=', 'finteresa.id_e_ind_fvt')
                    ->where('finteresa.id_interes', $criterio);
            }
        }
    }
    public static function scopeMandato($query,$criterio=-1) {
        if(is_array($criterio)) {
            if(!in_array(-1,$criterio)) {
                $query->join('esclarecimiento.e_ind_fvt_mandato as fmandato', 'esclarecimiento.e_ind_fvt.id_e_ind_fvt', '=', 'fmandato.id_e_ind_fvt')
                    ->wherein('id_mandato', $criterio);
            }
        }
        else {
            if($criterio>0) {
                $query->join('esclarecimiento.e_ind_fvt_mandato as fmandato','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','fmandato.id_e_ind_fvt')
                    ->where('id_mandato',$criterio);
            }
        }
    }
    public static function scopeDinamica($query,$criterio="") {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->join('esclarecimiento.e_ind_fvt_dinamica as fdinamica','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','fdinamica.id_e_ind_fvt')
                ->where('dinamica','ilike',"%$criterio%");
        }
    }
    public static function scopeTitulo($query,$criterio="" ) {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->where('titulo','ilike',"%$criterio%");
        }
    }
    public static function scopeObservaciones_Diligenciada($query,$criterio="" ) {
        $criterio=trim($criterio); $criterio=str_replace(" ","%",$criterio);
        if(strlen($criterio)>0) {
            $query->where('observaciones_diligenciada','ilike',"%$criterio%");
        }
    }
    //Filtro usado por jefe de transcriptores, utiliza la asiganción para filtrar
    public static function scopeTranscrita($query,$criterio=-1) {
        //dd($criterio);
        if($criterio==0) { //Sin asignar
            $query->wherenull('e_ind_fvt.id_transcrita');
        }
        elseif($criterio>0) {
                $query->where('e_ind_fvt.id_transcrita',$criterio);
        }
    }
    //Filtros basados en el campo, no en la asignación
    public static function scopeCon_Transcripcion($query, $criterio=-1) {
        if($criterio > 0) {
            if($criterio==1) {  //Sí
                $query->whereNotNull('html_transcripcion');
            }
            else { //No
                $query->whereNull('html_transcripcion');
            }
        }
    }
    public static function scopeCon_Etiquetado($query, $criterio=-1) {
        if($criterio > 0) {
            if($criterio==1) {  //Sí
                $query->whereNotNull('json_etiquetado');
            }
            else { //No
                $query->whereNull('json_etiquetado');
            }
        }
    }

    public static function scopeQuienTranscribe($query,$criterio=-1) {
        if($criterio>0) {
            $query->join('public.transcribir_asignacion as taa','e_ind_fvt.id_e_ind_fvt','=','taa.id_e_ind_fvt')
                ->where('taa.id_situacion',2)
                ->where('taa.id_transcriptor',$criterio);
        }
    }
    public static function scopeEtiquetada($query,$criterio=-1) {
        if($criterio==0) { //Sin asignar
            $query->wherenull('e_ind_fvt.id_etiquetada');
        }
        elseif($criterio>0) {
            $query->where('e_ind_fvt.id_etiquetada',$criterio);
        }
    }


    //Para saber si se cerró el procesamiento
    public static function scopeId_Cerrado($query, $criterio=-1){
        if($criterio>0) {
            $query->where('e_ind_fvt.id_cerrado',$criterio);
        }
    }
    //Filtrar las que tienen algo pendiente
    public static function scopeCon_Problemas($query,$criterio=-1) {
        if($criterio==1) {
            $query->join('seguimiento','e_ind_fvt.id_e_ind_fvt','=','seguimiento.id_entrevista')
                    ->whereraw(\DB::raw('seguimiento.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque el laravel pela cables con un join normal
                    ->join('seguimiento_problema','seguimiento.id_seguimiento','=','seguimiento_problema.id_seguimiento');

        }
        elseif($criterio==2) { //Ojo: tiene seguimiento, pero no problema.  No es lo mismo que no tenga ni seguimiento
            $query->join('seguimiento','e_ind_fvt.id_e_ind_fvt','=','seguimiento.id_entrevista')
                ->whereraw(\DB::raw('seguimiento.id_subserie = e_ind_fvt.id_subserie'))  //Chapulin porque laravel pela cables con un join normal
                ->leftjoin('seguimiento_problema','seguimiento.id_seguimiento','=','seguimiento_problema.id_seguimiento')
                ->wherenull('id_seguimiento_problema');

        }

    }

    //Indicar si está  transcrita


    public static function scopeMarca($query, $criterio=0) {
        if(!is_array($criterio)) {
            if($criterio>0) {
                $criterio = array($criterio);
            }
        }
        if(count($criterio)>0) {
            $id_entrevistador = \Auth::check() ? \Auth::user()->id_entrevistador : 0;


            //Consultar personales y de grupo
            $grupos = \DB::table('esclarecimiento.marca_grupo_entrevistador')->where('id_entrevistador',$id_entrevistador)->pluck('id_marca_grupo');
            if(count($grupos)>0) {
                $otros=\DB::table('esclarecimiento.marca_grupo_entrevistador')->distinct()->wherein('id_marca_grupo',$grupos)->pluck('id_entrevistador');
            }
            else {
                $otros = array($id_entrevistador);
            }
            //dd($otros);
            $query->join('esclarecimiento.marca_entrevista as filtro_marca','e_ind_fvt.id_e_ind_fvt','=','filtro_marca.id_entrevista')
                ->whereRaw(\DB::raw('filtro_marca.id_subserie =e_ind_fvt.id_subserie'))
                ->wherein('filtro_marca.id_entrevistador',$otros)
                ->wherein('id_marca',$criterio);

        }
    }

    //Me sirve para las busquedas en otros tipos de entrevista
    public static function procesar_texto_fts($criterio) {
        $criterio = str_replace(["&","|","!", ">", "<"],[ " "," "," "," "," "],$criterio);  //Quitar operadores

        $criterio = trim($criterio);
        $criterio = preg_replace('!\s+!', ' ', $criterio); // quitar dobles espacios en blanco



        $txt=array();
        //Quitar doble espacio en blanco
        if(strlen($criterio)>0) {
            //cambiar apostrofes a comillas
            $criterio = str_replace("'", '"', $criterio);
            //buscar comillas
            $existe = preg_match("/(?:(?:\"(?:\\\\\"|[^\"])+\")|(?:'(?:\\\'|[^'])+'))/is", $criterio, $match);
            if ($existe > 0) {
                $exacto = $match[0];
                $exacto = substr($exacto, 1, -1);  // quitar comillas iniciales y finales
                //$exacto = preg_replace("/[^A-Za-z0-9 ]/", '', $exacto);  //Quitar caracteres raros
                $exacto = trim($exacto); //por si pusieron ' hola mundo' quitar el espacio antes de la h
                $inexacto = trim(str_replace('"' . $exacto . '"', '', $criterio));  //quitar espacios en blanco al final para evitar &&
                if (strlen(trim($inexacto)) > 0) {
                    $txt[] = str_replace(" ", " & ", $inexacto);
                }
                $txt[] = str_replace(" ", " <-> ", $exacto);  // cambiar espacio en blanco por <->
            } else {
                //$criterio = preg_replace("/[^A-Za-z0-9 ]/", '', $criterio); //Quitar caracteres raros
                //$criterio = preg_replace("/[^\w\space\pL]/", '', $criterio); //Quitar caracteres raros
                $criterio=trim($criterio);
                $txt[] = str_replace(" ", " & ", $criterio);
            }
            //Verificación final
            $final=array();
            foreach($txt as $val) {
                $limpio = trim($val);
                if(strlen($limpio)>0) {
                    $final[]=$limpio;
                }
            }
            $buscar = implode(" & ", $final);
        }
        else {
            $buscar = $criterio;
        }

        return $buscar;
    }
    //Busqueda de full text search
    public static function scopeFTS($query,$criterio="")  {
        $buscar = entrevista_individual::procesar_texto_fts($criterio);  //Agrega conectores logicos, quita caracteres especiales, etc.
        if(strlen($buscar)>0) {
            $query->addSelect(\DB::raw("ts_rank('fts', to_tsquery('pg_catalog.spanish',unaccent('$buscar'))) as rank1, e_ind_fvt.id_e_ind_fvt"));
            $query->whereraw(\DB::raw("fts @@ to_tsquery('pg_catalog.spanish',unaccent('$buscar'))"));
        }
    }

    /*
     * filtros basados en fichas
     */

    //Persona Entrevistada: Sexo
    public static function scopePe_id_sexo($query, $criterio=-1) {
        if($criterio >= 0) {
            //Para facilitar los join, este codigo me evita un alias distinto por cada criterio
            $cuales = persona_entrevistada::join('fichas.persona','persona_entrevistada.id_persona','persona.id_persona');
            if($criterio==0) {
                $cuales->wherenull('persona.id_sexo');
            }
            else {
                $cuales->where('persona.id_sexo',$criterio);
            }
            $arreglo = $cuales->pluck('persona_entrevistada.id_e_ind_fvt')->toArray();
            //
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$arreglo);
        }

    }
    public static function scopePe_id_etnia($query, $criterio=-1) {
        if($criterio >= 0) {
            //Para facilitar los join, este codigo me evita un alias distinto por cada criterio
            $cuales = persona_entrevistada::join('fichas.persona','persona_entrevistada.id_persona','persona.id_persona');
            if($criterio==0) {
                $cuales->wherenull('persona.id_etnia');
            }
            else {
                $cuales->where('persona.id_etnia',$criterio);
            }
            $arreglo = $cuales->pluck('persona_entrevistada.id_e_ind_fvt')->toArray();
            //
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$arreglo);
        }
    }
    //Discapacidad
    public static function scopePe_id_discapacidad($query, $criterio=-1) {
        if($criterio > 0) {
            //Para facilitar los join, este codigo me evita un alias distinto por cada criterio
            $cuales = persona_entrevistada::join('fichas.persona','persona_entrevistada.id_persona','persona.id_persona')
                                            ->join('fichas.persona_discapacidad','persona.id_persona','persona_discapacidad.id_persona')
                                            ->where('persona_discapacidad.id_discapacidad',$criterio);
            $arreglo = $cuales->distinct()->pluck('persona_entrevistada.id_e_ind_fvt')->toArray();
            //
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$arreglo);
        }
    }
    //Grupo etario
    public static function scopePe_id_grupo_etario($query, $criterio=-1) {
        if($criterio >= 0) {
            if($criterio == 0) {
                $cuales = persona_entrevistada::whereRAw(\DB::raw('(edad is null or edad < 0 )'));
            }
            elseif($criterio == 1 ) {
                $cuales = persona_entrevistada::wherebetween('edad',[0,17]);
            }
            elseif($criterio == 2) {
                $cuales = persona_entrevistada::wherebetween('edad',[18,26]);
            }
            elseif($criterio == 3) {
                $cuales = persona_entrevistada::wherebetween('edad',[27,59]);
            }
            else {
                $cuales = persona_entrevistada::where('edad','>=',60);
            }
            //Aplicar el filtro al query de entrevistas
            $arreglo = $cuales->distinct()->pluck('persona_entrevistada.id_e_ind_fvt')->toArray();
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$arreglo);

        }

    }

    //Victima: grupo etario
    public static function scopeVi_id_grupo_etario($query, $criterio=-1) {
        if($criterio >= 0) {
            $cuales = entrevista_individual::join('fichas.victima','e_ind_fvt.id_e_ind_fvt','victima.id_e_ind_fvt')
                            ->join('fichas.hecho_victima','hecho_victima.id_victima','victima.id_victima');
            if($criterio==0) {
                $cuales->whereraw(\DB::Raw('( hecho_victima.edad is null or hecho_victima.edad < 0)'));
            }
            elseif($criterio==1) {
                $cuales->whereBetween('hecho_victima.edad', [0,17]);
            }
            elseif($criterio==2) {
                $cuales->whereBetween('hecho_victima.edad', [18,26]);
            }
            elseif($criterio==3) {
                $cuales->whereBetween('hecho_victima.edad', [27,59]);
            }
            else {
                $cuales->where('hecho_victima.edad','>=',60);
            }
            $arreglo = $cuales->distinct()->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            //Aplicar filtro al query general
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$arreglo);

        }
    }

    //Aplicar todos los filtros
    public static function scopeFiltrar($query, $criterios) {
        if(!is_object($criterios)) {
            $criterios=self::filtros_default();
        }

        $query->entrevista_del($criterios->entrevista_del)
                        ->entrevista_al($criterios->entrevista_al)
                        ->entrevista_lugar($criterios->entrevista_lugar)
                        ->hechos_del($criterios->hechos_del)
                        ->hechos_al($criterios->hechos_al)
                        ->hechos_lugar($criterios->hechos_lugar)
                        ->id_entrevistador($criterios->id_entrevistador)
                        ->id_macroterritorio($criterios->id_macroterritorio)
                        ->id_territorio($criterios->id_territorio)
                        ->id_grupo($criterios->id_grupo)
                        ->id_subserie($criterios->id_subserie)
                        ->fr($criterios->fr)
                        ->tv($criterios->tv)
                        ->aa($criterios->aa)
                        ->tc($criterios->tc)
                        ->stc($criterios->stc)
                        ->anotaciones($criterios->anotaciones)
                        ->observaciones_diligenciada($criterios->observaciones_diligenciada)
                        ->nna($criterios->nna)
                        ->entrevista_correlativo($criterios->entrevista_correlativo)
                        ->entrevista_codigo($criterios->entrevista_codigo)
                        ->br($criterios->br)
                        ->interes($criterios->interes)
                        ->mandato($criterios->mandato)
                        ->dinamica($criterios->dinamica)
                        ->titulo($criterios->titulo)
                        ->interes_area($criterios->interes_area)
                        ->id_activo($criterios->id_activo)
                        ->fichas_estado($criterios->fichas_estado)
                        ->id_prioritario($criterios->id_prioritario)
                        ->prioritario_tema($criterios->prioritario_tema)
                        ->id_sector($criterios->id_sector)
                        ->id_etnico($criterios->id_etnico)
                        ->id_remitido($criterios->id_remitido)
                        ->transcrita($criterios->transcrita)
                        ->etiquetada($criterios->etiquetada)
                        ->tesauro($criterios->id_tesauro)
                        ->tesauro($criterios->id_tesauro_2)
                        ->tesauro($criterios->id_tesauro_3)
                        ->fts($criterios->fts) //Full text search
                        ->marca($criterios->marca)
                        ->con_problemas($criterios->con_problemas)
                        ->id_cerrado($criterios->id_cerrado)
                        //priorizacion
                        ->tipo_prioridad($criterios->tipo_prioridad)
                        ->fluidez($criterios->fluidez)
                        ->cierre($criterios->cierre)
                        ->d_hecho($criterios->d_hecho)
                        ->d_impacto($criterios->d_impacto)
                        ->d_contexto($criterios->d_contexto)
                        ->d_justicia($criterios->d_justicia)
                        ->ahora_entiendo($criterios->ahora_entiendo)
                        ->cambio_perspectiva($criterios->cambio_perspectiva)
                        //priorizacion minima
                        ->d_hecho_min($criterios->d_hecho_min)
                        ->d_impacto_min($criterios->d_impacto_min)
                        ->d_contexto_min($criterios->d_contexto_min)
                        ->d_justicia_min($criterios->d_justicia_min)
                        // Con base al campo
                        ->con_transcripcion($criterios->con_transcripcion)
                        ->con_etiquetado($criterios->con_etiquetado)
                        //Fichas
                        ->pe_id_sexo($criterios->pe_id_sexo)
                        ->pe_id_etnia($criterios->pe_id_etnia)
                        ->pe_id_discapacidad($criterios->pe_id_discapacidad)
                        ->pe_id_grupo_etario($criterios->pe_id_grupo_etario)
                        ->vi_id_grupo_etario($criterios->vi_id_grupo_etario)
                        //Filtros por listado
                        ->id_excel_listados($criterios->id_excel_listados);
        if(\Gate::denies('permisos-legado')) {
            $query->permisos();
        }




    }

    ///////////Lógica interna
    //Calcula el correlativo general que se asigna a cada entrevista, según su subserie
    public function calcular_correlativo() {
        $fila = correlativo::where('id_subserie',$this->id_subserie)->first();
        if(empty($fila)) {
            correlativo::create(['id_subserie'=>$this->id_subserie, 'correlativo'=>1]);
            return 1;
        }
        else {
            $fila->correlativo++;
            $fila->save();
            return $fila->correlativo;
        }

    }


    //Indica el número de entrevista que le toca al entrevistador
    public  function cual_toca() {
        $max=self::where('id_entrevistador',$this->id_entrevistador)
            ->where('id_subserie',$this->id_subserie)
            ->max('entrevista_numero');
        $nuevo=intval($max)+1;
        return $nuevo;
    }

    //Con los datos que tiene, calcula el código
    public function calcular_codigo() {
        $txt = $this->prefijo_codigo();
        $corr = str_pad($this->entrevista_numero,5,"0",STR_PAD_LEFT);
        return $txt.$corr;

    }

    // Para cuando se cambia el id_entrevistador
    public function reasignar_entrevistador($id_entrevistador=0) {
        if($id_entrevistador <= 0) {
            return false;
        }
        $this->id_entrevistador = $id_entrevistador;
        //$this->save();
        $this->entrevista_numero = $this->cual_toca();
        $this->entrevista_codigo = $this->calcular_codigo();
        $this->save();
        return $this;
    }

    //Para calcular el codigo, me devuelve el texto hasta antes del correlativo
    public function prefijo_codigo() {
        //Defaults, si no está autenticado (para pruebas)
        $txt="XX";
        $entrev="eee";
        $cual = cat_item::find($this->id_subserie);

        if($cual) {
            if(strlen($cual->abreviado) > 0) {
                $txt= $cual->abreviado;
            }

        }
        $quien = entrevistador::find($this->id_entrevistador);
        if($quien) {
            $entrev = $quien->fmt_numero_entrevistador;
        }
        $codigo = $entrev."-".$txt."-";
        return $codigo;
    }

    //Determina el nivel de clasificacion del expediente
    public function clasificar_acceso() {
        $nivel=4;
        if($this->clasifica_nna==1) {
            $nivel=3;
        }
        if($this->clasifica_res==1) {
            $nivel=3;
        }
        if($this->clasifica_sex==1) {
            $nivel=3;
        }

        //Comisionados: R2
        if(isset($this->id_entrevistador)) {   //update
            $e = entrevistador::find($this->id_entrevistador);
            if($e) {
                if ($e->id_nivel==6) {
                    $nivel=2;
                }
            }
        }
        else { //insert
            if(Gate::allows('nivel-6')) {
                $nivel=2;
            }
        }


        // AA y TC: R-2 fijo  (antes era R3 el criterio, pero se cambia a partir del 28-jul)
        $arreglo[]=config('expedientes.aa');
        $arreglo[]=config('expedientes.tc');
        if(in_array($this->id_subserie , $arreglo)) {
            $nivel=2;
            $this->clasifica_r2=1; //Forzarlo, aunque no lo haya seleccionado.
        }

        if($this->clasifica_r2==1) {
            $nivel=2;
        }
        if($this->clasifica_r1==1) {
            $nivel=1;
        }

        $this->clasifica_nivel=$nivel;
        return $nivel;

    }


    /**
     * ESTADISTICAS
     */
    //Generar estadisticas por día
    public static function datos_dia($filtros=null) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->select(\DB::raw("TO_CHAR(entrevista_fecha::DATE, 'yyyy-mm-dd') as txt, count(1) as conteo"))
            ->orderby(\DB::raw("1"))
            ->groupBy(\DB::raw("1"));


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();
        //dd($debug);

        $info = $query->get();

        $datos=array();
        $fechas=array();
        foreach($info as $fila) {
            $datos[$fila->txt] = $fila->conteo;
            $fechas[$fila->txt] = new Carbon($fila->txt);
        }


        //Agregarle entrevistas colectivas
        $filtros_tmp = entrevista_colectiva::filtros_default($filtros);
        $query=entrevista_colectiva::filtrar($filtros_tmp)
            ->select(\DB::raw("TO_CHAR(entrevista_fecha_inicio::DATE, 'yyyy-mm-dd') as txt, count(1) as conteo"))
            ->orderby(\DB::raw("1"))
            ->groupBy(\DB::raw("1"));

        $info = $query->get();

        foreach($info as $fila) {
            if(isset($datos[$fila->txt] )) {
                $datos[$fila->txt] += $fila->conteo;
            }
            else {
                $datos[$fila->txt] = $fila->conteo;
                $fechas[$fila->txt] = new Carbon($fila->txt);
            }
        }
        //Agregarle entrevistas etnicas
        $filtros_tmp = entrevista_etnica::filtros_default($filtros);
        $query=entrevista_etnica::filtrar($filtros_tmp)
            ->select(\DB::raw("TO_CHAR(entrevista_fecha_inicio::DATE, 'yyyy-mm-dd') as txt, count(1) as conteo"))
            ->orderby(\DB::raw("1"))
            ->groupBy(\DB::raw("1"));

        $info = $query->get();

        foreach($info as $fila) {
            if(isset($datos[$fila->txt] )) {
                $datos[$fila->txt] += $fila->conteo;
            }
            else {
                $datos[$fila->txt] = $fila->conteo;
                $fechas[$fila->txt] = new Carbon($fila->txt);
            }
        }
        //Agregarle entrevistas profundidad
        $filtros_tmp = entrevista_profundidad::filtros_default($filtros);
        $query=entrevista_profundidad::filtrar($filtros_tmp)
            ->select(\DB::raw("TO_CHAR(entrevista_fecha_inicio::DATE, 'yyyy-mm-dd') as txt, count(1) as conteo"))
            ->orderby(\DB::raw("1"))
            ->groupBy(\DB::raw("1"));

        $info = $query->get();

        foreach($info as $fila) {
            if(isset($datos[$fila->txt] )) {
                $datos[$fila->txt] += $fila->conteo;
            }
            else {
                $datos[$fila->txt] = $fila->conteo;
                $fechas[$fila->txt] = new Carbon($fila->txt);
            }
        }
        //Agregarle diagnosticos
        $filtros_tmp = diagnostico_comunitario::filtros_default($filtros);
        $query=diagnostico_comunitario::filtrar($filtros_tmp)
            ->select(\DB::raw("TO_CHAR(entrevista_fecha_inicio::DATE, 'yyyy-mm-dd') as txt, count(1) as conteo"))
            ->orderby(\DB::raw("1"))
            ->groupBy(\DB::raw("1"));

        $info = $query->get();

        foreach($info as $fila) {
            if(isset($datos[$fila->txt] )) {
                $datos[$fila->txt] += $fila->conteo;
            }
            else {
                $datos[$fila->txt] = $fila->conteo;
                $fechas[$fila->txt] = new Carbon($fila->txt);
            }
        }
        //Agregarle hv
        $filtros_tmp = historia_vida::filtros_default($filtros);
        $query=historia_vida::filtrar($filtros_tmp)
            ->select(\DB::raw("TO_CHAR(entrevista_fecha_inicio::DATE, 'yyyy-mm-dd') as txt, count(1) as conteo"))
            ->orderby(\DB::raw("1"))
            ->groupBy(\DB::raw("1"));

        $info = $query->get();

        foreach($info as $fila) {
            if(isset($datos[$fila->txt] )) {
                $datos[$fila->txt] += $fila->conteo;
            }
            else {
                $datos[$fila->txt] = $fila->conteo;
                $fechas[$fila->txt] = new Carbon($fila->txt);
            }
        }

        //dd($datos);



        //Ver que haya datos para todos los dias


        $listado = collect($fechas);
        if(count($listado)>0) {
            $inicio = $listado->min();
            $final = $listado->max();
        }
        else {
            $inicio =  Carbon::now();
            $final =  Carbon::now();
        }


        $min = clone $inicio;
        while($min <= $final) {
            if(!isset($fechas[$min->format("Y-m-d")])) {
                $fechas[$min->format("Y-m-d")] = clone $min;
                $datos[$min->format("Y-m-d")] = 0;
            }
            $min->addDay(1);
        }
        ksort($fechas);
        ksort($datos);
        //Convertir los carbon a texto
        $categorias = array();
        foreach ($fechas as $id=>$carbon) {
            $categorias[$id]=$carbon->formatlocalized("%d-%b-%y");
        }

        //Calcular acumulado
        $acumulado=array();
        $total=0;
        foreach($datos as $fecha=>$cantidad) {
            $total+=$cantidad;
            $acumulado[$fecha]=$total;
        }


        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->inicio = $inicio;
        $respuesta->final = $final;
        $respuesta->a_serie[] = $acumulado;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Acumulado general";
        $respuesta->nombre_serie[]="Entrevistas diarias";
        $respuesta->tipo_serie[]="line";
        $respuesta->tipo_serie[]="bar";
        $respuesta->descarga="entrevistas_diarias";



        return $respuesta;



    }


    //Dashboard general de metadatos
    public static function conteos($request=null){
        $filtros_vi=entrevista_individual::filtros_default($request);
        \Carbon\Carbon::setWeekStartsAt(\Carbon\Carbon::MONDAY);

        $transcritas = array();
        $etiquetadas = array();
        //Uso filtrar para que le aplique filtros de usuarios, permisos, macro, etc.
        $filtros_vi->id_subserie=config('expedientes.vi');
        $vi=self::filtrar($filtros_vi)->count();
        $transcritas['vi']=self::filtrar($filtros_vi)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['vi']=self::filtrar($filtros_vi)->whereNotNull('json_etiquetado')->count();

        $filtros_vi->id_subserie=config('expedientes.aa');
        $aa=self::filtrar($filtros_vi)->count();
        $transcritas['aa']=self::filtrar($filtros_vi)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['aa']=self::filtrar($filtros_vi)->whereNotNull('json_etiquetado')->count();
        $filtros_vi->id_subserie=config('expedientes.tc');
        $tc=self::filtrar($filtros_vi)->count();
        $transcritas['tc']=self::filtrar($filtros_vi)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['tc']=self::filtrar($filtros_vi)->whereNotNull('json_etiquetado')->count();
        //  $entrevistadores=entrevistador::filtrar(entrevistador::filtros_default())->count();
        $arreglo_entrevistadores_permisos = entrevistador::filtrar(entrevistador::filtros_default($request))->pluck('id_entrevistador')->toArray();
        $arreglo_entrevistadores_con_entrevistas = entrevista_individual::pluck('id_entrevistador')->toArray();

        $entrevistadores = entrevistador::wherein('id_entrevistador',$arreglo_entrevistadores_permisos)->wherein('id_entrevistador',$arreglo_entrevistadores_con_entrevistas)->count();



        $filtros_co=entrevista_colectiva::filtros_default($request);
        $co = entrevista_colectiva::filtrar($filtros_co)->count();
        $personas_co = entrevista_colectiva::filtrar($filtros_co)->sum('cantidad_participantes');
        $transcritas['co']=entrevista_colectiva::filtrar($filtros_co)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['co']=entrevista_colectiva::filtrar($filtros_co)->whereNotNull('json_etiquetado')->count();
        $filtros_ee=entrevista_etnica::filtros_default($request);
        $ee = entrevista_etnica::filtrar($filtros_ee)->count();
        $personas_ee = entrevista_etnica::filtrar($filtros_ee)->sum('cantidad_participantes');
        $transcritas['ee']=entrevista_etnica::filtrar($filtros_ee)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['ee']=entrevista_etnica::filtrar($filtros_ee)->whereNotNull('json_etiquetado')->count();
        $filtros_pr=entrevista_profundidad::filtros_default($request);
        $pr = entrevista_profundidad::filtrar($filtros_pr)->count();
        $transcritas['pr']=entrevista_profundidad::filtrar($filtros_pr)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['pr']=entrevista_profundidad::filtrar($filtros_pr)->whereNotNull('json_etiquetado')->count();
        $filtros_dc=diagnostico_comunitario::filtros_default($request);
        $dc = diagnostico_comunitario::filtrar($filtros_dc)->count();
        $personas_dc = diagnostico_comunitario::filtrar($filtros_dc)->sum('cantidad_participantes');
        $transcritas['dc']=diagnostico_comunitario::filtrar($filtros_dc)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['dc']=diagnostico_comunitario::filtrar($filtros_dc)->whereNotNull('json_etiquetado')->count();
        $filtros_hv=historia_vida::filtros_default($request);
        $hv = historia_vida::filtrar($filtros_hv)->count();
        $transcritas['hv']=historia_vida::filtrar($filtros_hv)->whereNotNull('html_transcripcion')->count();
        $etiquetadas['hv']=historia_vida::filtrar($filtros_hv)->whereNotNull('json_etiquetado')->count();
        $filtros_ci=casos_informes::filtros_default($request);
        $ci = casos_informes::filtrar($filtros_ci)->count();


        //Transcritos



        //Cantidad de personas entrevistadas
        $personas_total=$vi+$aa+$tc+$pr+$personas_co+$personas_dc+$personas_ee;
        //
        $conteos = new \stdClass();
        $conteos->vi=$vi;
        $conteos->aa=$aa;
        $conteos->tc=$tc;


        $conteos->co = $co;
        $conteos->ee = $ee;
        $conteos->pr = $pr;
        $conteos->dc = $dc;
        $conteos->hv = $hv;
        $conteos->ci = $ci;
        $conteos->vi_f="id_subserie=".config('expedientes.vi');
        $conteos->aa_f="id_subserie=".config('expedientes.aa');
        $conteos->tc_f="id_subserie=".config('expedientes.tc');
        //Entrevistas realizadas
        $conteos->entrevistas_total = $conteos->vi + $conteos->aa + $conteos->tc + $conteos->co + $conteos->ee + $conteos->pr + $conteos->dc + $conteos->hv;
        $conteos->entrevistadores=$entrevistadores;
        //Totales por tipo
        $conteos->a_transcritas = $transcritas;
        $conteos->a_etiquetadas = $etiquetadas;
        //dd($conteos);


        //Personas entrevistadas
        $conteos->entrevistados = new \stdClass();
        $conteos->entrevistados->individual=$vi+$aa+$tc+$pr;
        $conteos->entrevistados->co=$personas_co;
        $conteos->entrevistados->dc=$personas_dc;
        $conteos->entrevistados->ee=$personas_ee;
        $conteos->entrevistados->colectivo=$personas_dc+$personas_co+$personas_ee;
        $conteos->entrevistados->total=$personas_total;


        //Entrevistas transcritas
        //$transcritas = transcribir_asignacion::where('id_situacion',2)->distinct()->count('codigo');
        $filtros_vi->id_subserie=-1;
        $vi = entrevista_individual::filtrar($filtros_vi)->whereNotNull('html_transcripcion')->count();
        $co = entrevista_colectiva::filtrar($filtros_co)->whereNotNull('html_transcripcion')->count();
        $ee = entrevista_etnica::filtrar($filtros_ee)->whereNotNull('html_transcripcion')->count();
        $pr = entrevista_profundidad::filtrar($filtros_pr)->whereNotNull('html_transcripcion')->count();
        $dc = diagnostico_comunitario::filtrar($filtros_dc)->whereNotNull('html_transcripcion')->count();
        $hv = historia_vida::filtrar($filtros_hv)->whereNotNull('html_transcripcion')->count();
        $transcritas = $vi + $co + $ee + $pr + $dc + $hv;
        //$transcritas = $co;
        $minutos = transcribir_asignacion::where('id_situacion',2)->sum('duracion_entrevista_minutos');

        //Entrevistas etiquetadas
        //$etiquetadas = etiquetar_asignacion::where('id_situacion',2)->distinct()->count('codigo');
        $vi = entrevista_individual::filtrar($filtros_vi)->whereNotNull('json_etiquetado')->count();
        $co = entrevista_colectiva::filtrar($filtros_co)->whereNotNull('json_etiquetado')->count();
        $ee = entrevista_etnica::filtrar($filtros_ee)->whereNotNull('json_etiquetado')->count();
        $pr = entrevista_profundidad::filtrar($filtros_pr)->whereNotNull('json_etiquetado')->count();
        $dc = diagnostico_comunitario::filtrar($filtros_dc)->whereNotNull('json_etiquetado')->count();
        $hv = historia_vida::filtrar($filtros_hv)->whereNotNull('json_etiquetado')->count();
        $etiquetadas = $vi + $co + $ee + $pr + $dc + $hv;



        $conteos->transcripcion = new \stdClass();
        if($transcritas > 0) {
            $conteos->transcripcion->entrevistas = $transcritas;
            $conteos->transcripcion->minutos = $minutos;
            $conteos->transcripcion->minutos_horas = transcribir_asignacion::en_horas($minutos);
            $conteos->transcripcion->promedio = $minutos/$transcritas;
            $conteos->transcripcion->promedio_horas = transcribir_asignacion::en_horas($conteos->transcripcion->promedio);
        }
        else {
            $conteos->transcripcion->entrevistas = 0;
            $conteos->transcripcion->minutos = 0;
            $conteos->transcripcion->minutos_horas = "00:00";
            $conteos->transcripcion->promedio = 0;
            $conteos->transcripcion->promedio_horas = 0;
        }

        $conteos->etiquetadas = $etiquetadas;

        //Cerradas
        $vi = entrevista_individual::where('id_cerrado',1)->count();
        $co = entrevista_colectiva::where('id_cerrado',1)->count();
        $ee = entrevista_etnica::where('id_cerrado',1)->count();
        $pr = entrevista_profundidad::where('id_cerrado',1)->count();
        $dc = diagnostico_comunitario::where('id_cerrado',1)->count();
        $hv = historia_vida::where('id_cerrado',1)->count();
        $conteos->cerradas = $vi+$co+$ee+$pr+$dc+$hv;


        return $conteos;
    }

    //Totales por entrevistador
    public static function datos_entrevistador($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.entrevistador','esclarecimiento.e_ind_fvt.id_entrevistador','=','esclarecimiento.entrevistador.id_entrevistador')
            ->select(\DB::raw("esclarecimiento.entrevistador.id_entrevistador as id_item, esclarecimiento.entrevistador.numero_entrevistador as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->where('id_subserie',config('expedientes.vi'))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="por_entrevistador";


        return $respuesta;
    }

    //Totales por grupo al que pertenece el entrevistador
    public static function datos_entrevistador_grupo($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.entrevistador','esclarecimiento.e_ind_fvt.id_entrevistador','=','esclarecimiento.entrevistador.id_entrevistador')
            ->join('catalogos.criterio_fijo','entrevistador.id_grupo','=','criterio_fijo.id_opcion')
            ->select(\DB::raw("entrevistador.id_grupo as id_item, criterio_fijo.descripcion as txt, count(1) as conteo"))
            ->where('criterio_fijo.id_grupo',5)
            ->where('id_subserie',config('expedientes.vi'))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="por_grupo";


        return $respuesta;
    }

    //Totales por macroregion
    public static function datos_macro($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        // A víctimas, TC y AA
        $query=self::filtrar($filtros)
            ->join('catalogos.cev','e_ind_fvt.id_macroterritorio','=','id_geo')
            ->select(\DB::raw("e_ind_fvt.id_macroterritorio as id_item, catalogos.cev.descripcion as txt, e_ind_fvt.id_subserie, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2,3"))
            ->orderby('conteo','desc');
        $info = $query->get();
        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item][$fila->id_subserie] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        //Colectiva
        $id = config('expedientes.co');
        $filtros = entrevista_colectiva::filtros_default($filtros);
        $query=entrevista_colectiva::filtrar($filtros)
            ->join('catalogos.cev','entrevista_colectiva.id_macroterritorio','=','id_geo')
            ->select(\DB::raw("entrevista_colectiva.id_macroterritorio as id_item, catalogos.cev.descripcion as txt, $id id_subserie, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2,3"))
            ->orderby('conteo','desc');
        $info = $query->get();

        foreach($info as $fila) {
            $datos[$fila->id_item][$fila->id_subserie] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }
        //Etnica
        $id = config('expedientes.ee');
        $filtros = entrevista_etnica::filtros_default($filtros);
        $query=entrevista_etnica::filtrar($filtros)
            ->join('catalogos.cev','entrevista_etnica.id_macroterritorio','=','id_geo')
            ->select(\DB::raw("entrevista_etnica.id_macroterritorio as id_item, catalogos.cev.descripcion as txt, $id id_subserie, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2,3"))
            ->orderby('conteo','desc');

        $info = $query->get();

        foreach($info as $fila) {
            $datos[$fila->id_item][$fila->id_subserie] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        //Profundidad
        $id = config('expedientes.pr');
        $filtros = entrevista_profundidad::filtros_default($filtros);
        $query=entrevista_profundidad::filtrar($filtros)
            ->join('catalogos.cev','entrevista_profundidad.id_macroterritorio','=','id_geo')
            ->select(\DB::raw("entrevista_profundidad.id_macroterritorio as id_item, catalogos.cev.descripcion as txt, $id id_subserie, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2,3"))
            ->orderby('conteo','desc');

        $info = $query->get();
         foreach($info as $fila) {
             $datos[$fila->id_item][$fila->id_subserie] = $fila->conteo;
             $categorias[$fila->id_item] = $fila->txt;
         }

        //Diagnosticos comunitarios
        $id = config('expedientes.dc');
        $filtros = diagnostico_comunitario::filtros_default($filtros);
        $query=diagnostico_comunitario::filtrar($filtros)
            ->join('catalogos.cev','diagnostico_comunitario.id_macroterritorio','=','id_geo')
            ->select(\DB::raw("diagnostico_comunitario.id_macroterritorio as id_item, catalogos.cev.descripcion as txt, $id id_subserie, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2,3"))
            ->orderby('conteo','desc');

        $info = $query->get();

        foreach($info as $fila) {
            $datos[$fila->id_item][$fila->id_subserie] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        // Historia de vida
        $id = config('expedientes.hv');
        $filtros = historia_vida::filtros_default($filtros);
        $query=historia_vida::filtrar($filtros)
            ->join('catalogos.cev','historia_vida.id_macroterritorio','=','id_geo')
            ->select(\DB::raw("historia_vida.id_macroterritorio as id_item, catalogos.cev.descripcion as txt, $id id_subserie, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2,3"))
            ->orderby('conteo','desc');

        $info = $query->get();

        foreach($info as $fila) {
            $datos[$fila->id_item][$fila->id_subserie] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }




        //Ver que esten definidas todas las posiciones del arreglo, si no definirlas con cero.
        $a_entrevistas = array();
        $a_entrevistas[config('expedientes.vi')]="VI: Entrev. a víctimas";
        $a_entrevistas[config('expedientes.aa')]="AA: Entrev. a actores armados";
        $a_entrevistas[config('expedientes.tc')]="TC: Entrev. a terceros civiles";
        $a_entrevistas[config('expedientes.co')]="CO: Entrev. colectivas";
        $a_entrevistas[config('expedientes.ee')]="EE: Entrev. a sujetos colectivos";
        $a_entrevistas[config('expedientes.pr')]="PR: Entrev. a profundidad";
        $a_entrevistas[config('expedientes.dc')]="DC: Diagnóstico comunitario";
        $a_entrevistas[config('expedientes.hv')]="HV: Historia de vida";



        $a_macro = array();
        foreach($categorias as $id_macro => $maiz) {
            $a_macro[$id_macro] = $maiz;
            foreach($a_entrevistas as $id_entrevista => $texto) {
                $datos[$id_macro][$id_entrevista] = isset($datos[$id_macro][$id_entrevista]) ? $datos[$id_macro][$id_entrevista] : 0;
            }
        }
        //dd($categorias);

        //Darle vuelta
        $datos2 = array();
        foreach($datos as $id_macro => $entrevistas) {
            foreach($entrevistas as $id_entrevista => $val) {
                $datos2[$id_entrevista][$id_macro]=$val;
            }
        }




        $respuesta = new \stdClass();
        $respuesta->categorias = $a_macro ;
        $respuesta->nombre_serie = $a_entrevistas;
        $respuesta->a_serie = $datos;
        $respuesta->descarga="por_macro";


        $respuesta->a_barra = $a_macro;
        $respuesta->a_series = $a_entrevistas;
        $respuesta->a_datos = $datos;
        $respuesta->descarga="por_macro";


        //dd($respuesta);

        //Tabla de procesamiento



        return $respuesta;
    }

    //Super resumen de tipo de entrevista, personas escuchadas, procesamiento.  Por territorio y macroterritorio
    public static function datos_procesamiento($request) {

        //Estructura de los territorios
        $a_macro = cev::where('nivel',1)->orderby('descripcion')->pluck('descripcion','id_geo');
        $a_terr = cev::where('nivel',2)->orderby('descripcion')->pluck('descripcion','id_geo')->toArray();
        $estructura = array();
        foreach($a_macro as $id=>$txt) {
            $hijos = cev::where('id_padre',$id)->orderby('descripcion')->pluck('descripcion','id_geo')->toArray();
            $estructura[$id]['hijos']=$hijos;
            $estructura[$id]['nombre']=$txt;
        }
        //Respuesta
        $respuesta = new \stdClass();
        $respuesta->estructura = $estructura;
        $respuesta->tipos_entrevista = array();
        //Por tipo de entrevista: arreglo['id_territorio']['id_tipo']=120;
        $respuesta->entrevistas = new \stdClass();
        $respuesta->entrevistas->datos = array();
        $respuesta->entrevistas->datos_macro = array(); //Totales por macroterritorio
        $respuesta->entrevistas->totales = array();  //Totales por territorio/tipo
        $respuesta->entrevistas->totales_macro = array();  //Totales por territorio/tipo
        // Cantidad de personas escuchadas: arreglo['id_territorio']['id_tipo']=160;
        $respuesta->personas = new \stdClass();
        $respuesta->personas->datos = array();
        $respuesta->personas->datos_macro = array(); //Totales por macroterritorio
        $respuesta->personas->totales = array();  //Totales por territorio/tipo
        $respuesta->personas->totales_macro = array();  //Totales por territorio/tipo
        //Transcritas: arreglo['id_territorio']=20
        $respuesta->transcritas = array();
        $respuesta->transcritas_macro = array();

        //Etiquetadas: arreglo['id_territorio']=15
        $respuesta->etiquetadas = array();
        $respuesta->etiquetadas_macro = array();

        // Para las columnas
        $respuesta->tipos_entrevista[config('expedientes.vi')]=cat_item::find(config('expedientes.vi'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.aa')]=cat_item::find(config('expedientes.aa'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.tc')]=cat_item::find(config('expedientes.tc'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.co')]=cat_item::find(config('expedientes.co'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.ee')]=cat_item::find(config('expedientes.ee'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.pr')]=cat_item::find(config('expedientes.pr'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.dc')]=cat_item::find(config('expedientes.dc'))->abreviado;
        $respuesta->tipos_entrevista[config('expedientes.hv')]=cat_item::find(config('expedientes.hv'))->abreviado;

        //Inicializar matriz de valores con ceros
        foreach($a_terr as $id_terr => $txt_terr) {
            foreach($respuesta->tipos_entrevista as $id_tipo => $txt_tipo) {
                $respuesta->entrevistas->datos[$id_terr][$id_tipo]=0;
                $respuesta->personas->datos[$id_terr][$id_tipo]=0;
            }
            $respuesta->entrevistas->totales[$id_terr]=0;
            $respuesta->personas->totales[$id_terr]=0;
            $respuesta->transcritas[$id_terr]=0;
            $respuesta->etiquetadas[$id_terr]=0;
        }
        foreach($a_macro as $id_terr => $txt_terr) {
            foreach($respuesta->tipos_entrevista as $id_tipo => $txt_tipo) {
                $respuesta->entrevistas->datos_macro[$id_terr][$id_tipo]=0;
                $respuesta->personas->datos_macro[$id_terr][$id_tipo]=0;
            }
            $respuesta->entrevistas->totales_macro[$id_terr]=0;
            $respuesta->personas->totales_macro[$id_terr]=0;
            $respuesta->transcritas_macro[$id_terr]=0;
            $respuesta->etiquetadas_macro[$id_terr]=0;

        }


        ///////////////////// Entrevistas Individuales
        $filtros=self::filtros_default($request);
        $query_base = entrevista_individual::filtrar($filtros); //Para quitar lo que le hayan agregado antes
        $query = clone $query_base;
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_subserie, e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, sum(1) as personas, count(1) as entrevistas"))
                ->join('catalogos.cev','e_ind_fvt.id_territorio','=','cev.id_geo')
                ->join('catalogos.cev as m','e_ind_fvt.id_macroterritorio','=','m.id_geo')
            ->wherein('id_subserie',[config('expedientes.vi'),config('expedientes.aa'),config('expedientes.tc')])
            ->groupby("e_ind_fvt.id_subserie")
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->get();
        $datos=array();
        //dd($respuesta);
        foreach($res as $fila) {
            if(!isset( $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie])) {
                //dd($fila);
            }
            //Entrevistas
            $respuesta->entrevistas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales[$fila->id_territorio] += $fila->entrevistas;
            $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales_macro[$fila->id_macroterritorio] += $fila->entrevistas;
            //Personas escuchadas
            $respuesta->personas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales[$fila->id_territorio] += $fila->personas;
            $respuesta->personas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales_macro[$fila->id_macroterritorio] += $fila->personas;
        }
        //Transcritas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, count(1) as val"))
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->whereNotNull('html_transcripcion')
            ->get();

        foreach($res as $fila) {
            $respuesta->transcritas[$fila->id_territorio] = $fila->val;
            $respuesta->transcritas_macro[$fila->id_macroterritorio] += $fila->val;
        }
        //Etiquetadas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, count(1) as val"))
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->whereNotNull('json_etiquetado')
            ->get();

        foreach($res as $fila) {
            $respuesta->etiquetadas[$fila->id_territorio] = $fila->val;
            $respuesta->etiquetadas_macro[$fila->id_macroterritorio] += $fila->val;
        }



        ////////// Entrevistas Colectivas
        $filtros = entrevista_colectiva::filtros_default($request);
        $query_base = entrevista_colectiva::filtrar($filtros); //Para quitar lo que le hayan agregado antes
        $query = clone $query_base;
        $id_subserie = config('expedientes.co');
        $res = $query->selectraw(\DB::raw("$id_subserie as id_subserie, entrevista_colectiva.id_macroterritorio, entrevista_colectiva.id_territorio, sum(cantidad_participantes) as personas, count(1) as entrevistas"))
            ->join('catalogos.cev','entrevista_colectiva.id_territorio','=','cev.id_geo')
            ->join('catalogos.cev as m','entrevista_colectiva.id_macroterritorio','=','m.id_geo')
            //->groupby("id_subserie")
            ->groupby(\DB::raw("1,2,3"))
            //->groupby("id_territorio")
            ->get();
        $datos=array();
        //dd($respuesta);
        foreach($res as $fila) {
            if(!isset( $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie])) {
                //dd($fila);
            }
            //Entrevistas
            $respuesta->entrevistas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales[$fila->id_territorio] += $fila->entrevistas;
            $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales_macro[$fila->id_macroterritorio] += $fila->entrevistas;
            //Personas escuchadas
            $respuesta->personas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales[$fila->id_territorio] += $fila->personas;
            $respuesta->personas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales_macro[$fila->id_macroterritorio] += $fila->personas;
        }
        //Transcritas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("entrevista_colectiva.id_macroterritorio, entrevista_colectiva.id_territorio, count(1) as val"))
            ->groupby("entrevista_colectiva.id_macroterritorio")
            ->groupby("entrevista_colectiva.id_territorio")
            ->whereNotNull('html_transcripcion')
            ->get();

        foreach($res as $fila) {
            $respuesta->transcritas[$fila->id_territorio] += $fila->val;
            $respuesta->transcritas_macro[$fila->id_macroterritorio] += $fila->val;
        }
        //Etiquetadas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("entrevista_colectiva.id_macroterritorio, entrevista_colectiva.id_territorio, count(1) as val"))
            ->groupby("entrevista_colectiva.id_macroterritorio")
            ->groupby("entrevista_colectiva.id_territorio")
            ->whereNotNull('json_etiquetado')
            ->get();

        foreach($res as $fila) {
            $respuesta->etiquetadas[$fila->id_territorio] += $fila->val;
            $respuesta->etiquetadas_macro[$fila->id_macroterritorio] += $fila->val;
        }

        ////////// Entrevistas Etnicas
        $filtros = entrevista_etnica::filtros_default($request);
        $query_base = entrevista_etnica::filtrar($filtros); //Para quitar lo que le hayan agregado antes
        $query = clone $query_base;
        $id_subserie = config('expedientes.ee');
        $res = $query->selectraw(\DB::raw("$id_subserie as id_subserie, entrevista_etnica.id_macroterritorio, entrevista_etnica.id_territorio, sum(cantidad_participantes) as personas, count(1) as entrevistas"))
            ->join('catalogos.cev','entrevista_etnica.id_territorio','=','cev.id_geo')
            ->join('catalogos.cev as m','entrevista_etnica.id_macroterritorio','=','m.id_geo')
            ->groupby("id_subserie")
            ->groupby("entrevista_etnica.id_macroterritorio")
            ->groupby("entrevista_etnica.id_territorio")
            ->get();
        $datos=array();
        //dd($respuesta);
        foreach($res as $fila) {
            if(!isset( $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie])) {
                //dd($fila);
            }
            //Entrevistas
            $respuesta->entrevistas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales[$fila->id_territorio] += $fila->entrevistas;
            $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales_macro[$fila->id_macroterritorio] += $fila->entrevistas;
            //Personas escuchadas
            $respuesta->personas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales[$fila->id_territorio] += $fila->personas;
            $respuesta->personas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales_macro[$fila->id_macroterritorio] += $fila->personas;
        }
        //Transcritas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("entrevista_etnica.id_macroterritorio, entrevista_etnica.id_territorio, count(1) as val"))
            ->groupby("entrevista_etnica.id_macroterritorio")
            ->groupby("entrevista_etnica.id_territorio")
            ->whereNotNull('html_transcripcion')
            ->get();

        foreach($res as $fila) {
            $respuesta->transcritas[$fila->id_territorio] += $fila->val;
            $respuesta->transcritas_macro[$fila->id_macroterritorio] += $fila->val;
        }
        //Etiquetadas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("entrevista_etnica.id_macroterritorio, entrevista_etnica.id_territorio, count(1) as val"))
            ->groupby("entrevista_etnica.id_macroterritorio")
            ->groupby("entrevista_etnica.id_territorio")
            ->whereNotNull('json_etiquetado')
            ->get();

        foreach($res as $fila) {
            $respuesta->etiquetadas[$fila->id_territorio] += $fila->val;
            $respuesta->etiquetadas_macro[$fila->id_macroterritorio] += $fila->val;
        }

        ////////// Entrevistas Profundidoad
        $filtros = entrevista_profundidad::filtros_default($request);
        $query_base = entrevista_profundidad::filtrar($filtros); //Para quitar lo que le hayan agregado antes
        $query = clone $query_base;
        $id_subserie = config('expedientes.pr');
        $res = $query->selectraw(\DB::raw("$id_subserie as id_subserie, entrevista_profundidad.id_macroterritorio, entrevista_profundidad.id_territorio, sum(1) as personas, count(1) as entrevistas"))
            ->join('catalogos.cev','entrevista_profundidad.id_territorio','=','cev.id_geo')
            ->join('catalogos.cev as m','entrevista_profundidad.id_macroterritorio','=','m.id_geo')
            ->groupby("id_subserie")
            ->groupby("entrevista_profundidad.id_macroterritorio")
            ->groupby("entrevista_profundidad.id_territorio")
            ->get();
        $datos=array();
        //dd($respuesta);
        foreach($res as $fila) {
            if(!isset( $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie])) {
                //dd($fila);
            }
            //Entrevistas
            $respuesta->entrevistas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales[$fila->id_territorio] += $fila->entrevistas;
            $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales_macro[$fila->id_macroterritorio] += $fila->entrevistas;
            //Personas escuchadas
            $respuesta->personas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales[$fila->id_territorio] += $fila->personas;
            $respuesta->personas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales_macro[$fila->id_macroterritorio] += $fila->personas;
        }
        //Transcritas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("entrevista_profundidad.id_macroterritorio, entrevista_profundidad.id_territorio, count(1) as val"))
            ->groupby("entrevista_profundidad.id_macroterritorio")
            ->groupby("entrevista_profundidad.id_territorio")
            ->whereNotNull('html_transcripcion')
            ->get();

        foreach($res as $fila) {
            $respuesta->transcritas[$fila->id_territorio] += $fila->val;
            $respuesta->transcritas_macro[$fila->id_macroterritorio] += $fila->val;
        }
        //Etiquetadas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("entrevista_profundidad.id_macroterritorio, entrevista_profundidad.id_territorio, count(1) as val"))
            ->groupby("entrevista_profundidad.id_macroterritorio")
            ->groupby("entrevista_profundidad.id_territorio")
            ->whereNotNull('json_etiquetado')
            ->get();

        foreach($res as $fila) {
            $respuesta->etiquetadas[$fila->id_territorio] += $fila->val;
            $respuesta->etiquetadas_macro[$fila->id_macroterritorio] += $fila->val;
        }

        ////////// Diagnosticos comunitarios
        $filtros = diagnostico_comunitario::filtros_default($request);
        $query_base = diagnostico_comunitario::filtrar($filtros); //Para quitar lo que le hayan agregado antes
        $query = clone $query_base;
        $id_subserie = config('expedientes.dc');
        $res = $query->selectraw(\DB::raw("$id_subserie as id_subserie, diagnostico_comunitario.id_macroterritorio, diagnostico_comunitario.id_territorio, sum(cantidad_participantes) as personas, count(1) as entrevistas"))
            ->join('catalogos.cev','diagnostico_comunitario.id_territorio','=','cev.id_geo')
            ->join('catalogos.cev as m','diagnostico_comunitario.id_macroterritorio','=','m.id_geo')
            ->groupby("id_subserie")
            ->groupby("diagnostico_comunitario.id_macroterritorio")
            ->groupby("diagnostico_comunitario.id_territorio")
            ->get();
        $datos=array();
        //dd($respuesta);
        foreach($res as $fila) {
            if(!isset( $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie])) {
                //dd($fila);
            }
            //Entrevistas
            $respuesta->entrevistas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales[$fila->id_territorio] += $fila->entrevistas;
            $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales_macro[$fila->id_macroterritorio] += $fila->entrevistas;
            //Personas escuchadas
            $respuesta->personas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales[$fila->id_territorio] += $fila->personas;
            $respuesta->personas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales_macro[$fila->id_macroterritorio] += $fila->personas;
        }
        //Transcritas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("diagnostico_comunitario.id_macroterritorio, diagnostico_comunitario.id_territorio, count(1) as val"))
            ->groupby("diagnostico_comunitario.id_macroterritorio")
            ->groupby("diagnostico_comunitario.id_territorio")
            ->whereNotNull('html_transcripcion')
            ->get();

        foreach($res as $fila) {
            $respuesta->transcritas[$fila->id_territorio] += $fila->val;
            $respuesta->transcritas_macro[$fila->id_macroterritorio] += $fila->val;
        }
        //Etiquetadas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("diagnostico_comunitario.id_macroterritorio, diagnostico_comunitario.id_territorio, count(1) as val"))
            ->groupby("diagnostico_comunitario.id_macroterritorio")
            ->groupby("diagnostico_comunitario.id_territorio")
            ->whereNotNull('json_etiquetado')
            ->get();

        foreach($res as $fila) {
            $respuesta->etiquetadas[$fila->id_territorio] += $fila->val;
            $respuesta->etiquetadas_macro[$fila->id_macroterritorio] += $fila->val;
        }

        ////////// Historia de vida
        $filtros = historia_vida::filtros_default($request);
        $query_base = historia_vida::filtrar($filtros); //Para quitar lo que le hayan agregado antes
        $query = clone $query_base;
        $id_subserie = config('expedientes.hv');
        $res = $query->selectraw(\DB::raw("$id_subserie as id_subserie, historia_vida.id_macroterritorio, historia_vida.id_territorio, sum(1) as personas, count(1) as entrevistas"))
            ->join('catalogos.cev','historia_vida.id_territorio','=','cev.id_geo')
            ->join('catalogos.cev as m','historia_vida.id_macroterritorio','=','m.id_geo')
            ->groupby("id_subserie")
            ->groupby("historia_vida.id_macroterritorio")
            ->groupby("historia_vida.id_territorio")
            ->get();
        $datos=array();
        //dd($respuesta);
        foreach($res as $fila) {
            if(!isset( $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie])) {
                //dd($fila);
            }
            //Entrevistas
            $respuesta->entrevistas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales[$fila->id_territorio] += $fila->entrevistas;
            $respuesta->entrevistas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->entrevistas;
            $respuesta->entrevistas->totales_macro[$fila->id_macroterritorio] += $fila->entrevistas;
            //Personas escuchadas
            $respuesta->personas->datos[$fila->id_territorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales[$fila->id_territorio] += $fila->personas;
            $respuesta->personas->datos_macro[$fila->id_macroterritorio][$fila->id_subserie] += $fila->personas;
            $respuesta->personas->totales_macro[$fila->id_macroterritorio] += $fila->personas;
        }
        //Transcritas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("historia_vida.id_macroterritorio, historia_vida.id_territorio, count(1) as val"))
            ->groupby("historia_vida.id_macroterritorio")
            ->groupby("historia_vida.id_territorio")
            ->whereNotNull('html_transcripcion')
            ->get();

        foreach($res as $fila) {
            $respuesta->transcritas[$fila->id_territorio] += $fila->val;
            $respuesta->transcritas_macro[$fila->id_macroterritorio] += $fila->val;
        }
        //Etiquetadas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("historia_vida.id_macroterritorio, historia_vida.id_territorio, count(1) as val"))
            ->groupby("historia_vida.id_macroterritorio")
            ->groupby("historia_vida.id_territorio")
            ->whereNotNull('json_etiquetado')
            ->get();

        foreach($res as $fila) {
            $respuesta->etiquetadas[$fila->id_territorio] += $fila->val;
            $respuesta->etiquetadas_macro[$fila->id_macroterritorio] += $fila->val;
        }


        ///////

        return $respuesta;
    }

    //Totales por macroregion
    public static function datos_clasificacion($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }
        $filtros->id_subserie=0;

        $query=self::filtrar($filtros)
            ->select(\DB::raw("e_ind_fvt.clasifica_nivel as id_item, count(1) as conteo"))
            ->groupBy(\DB::raw("1"))
            ->where('id_subserie',config('expedientes.vi'))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();


        $t[0]="Sin clasificar";
        $t[1]="Reservado-1";
        $t[2]="Reservado-2";
        $t[3]="Reservado-3";
        $t[4]="Reservado-4";


        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $t[$fila->id_item];
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="por_clasificacion";

        return $respuesta;
    }



    //Totales por fuerza responsable
    public static function datos_fr($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.e_ind_fvt_fr','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','esclarecimiento.e_ind_fvt_fr.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_fr','=','id_item')
            ->where('id_subserie',config('expedientes.vi'))
            ->select(\DB::raw("id_item, catalogos.cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="ind_por_fuerza_responsable";


        return $respuesta;
    }



    //Totales por tipo de violacion
    public static function datos_tv($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.e_ind_fvt_tv','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','esclarecimiento.e_ind_fvt_tv.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_tv','=','id_item')
            ->select(\DB::raw("id_item, catalogos.cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="ind_por_tipo_violacion";


        return $respuesta;
    }

    //Grupos con actores armados
    public static function datos_aa_fr($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.e_ind_fvt_fr','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','esclarecimiento.e_ind_fvt_fr.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_fr','=','id_item')
            ->where('id_subserie',config('expedientes.aa'))
            ->select(\DB::raw("id_item, catalogos.cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="aa_fuerzas";


        return $respuesta;
    }
    //Temas con actores armados
    public static function datos_aa($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.e_ind_fvt_aa','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','esclarecimiento.e_ind_fvt_aa.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_aa','=','id_item')
            ->select(\DB::raw("id_item, catalogos.cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="aa_temas";


        return $respuesta;
    }

    //Temas con terceros civiles
    public static function datos_tc($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.e_ind_fvt_tc','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','esclarecimiento.e_ind_fvt_tc.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_tc','=','id_item')
            ->select(\DB::raw("id_item, catalogos.cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();


        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="tc_temas";


        return $respuesta;
    }

    //Sectores de terceros civiles
    public static function datos_stc($filtros) {
        if(!is_object($filtros)) {
            $filtros=self::filtros_default();
        }

        $query=self::filtrar($filtros)
            ->join('esclarecimiento.e_ind_fvt_stc','esclarecimiento.e_ind_fvt.id_e_ind_fvt','=','esclarecimiento.e_ind_fvt_stc.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_stc','=','id_item')
            ->select(\DB::raw("id_item, catalogos.cat_item.descripcion as txt, count(1) as conteo"))
            ->groupBy(\DB::raw("1,2"))
            ->orderby('conteo','desc');


        $debug['sql']=$query->toSql();
        $debug['par']=$query->getBindings();

        $info = $query->get();

        $datos=array();
        $categorias=array();
        foreach($info as $fila) {
            $datos[$fila->id_item] = $fila->conteo;
            $categorias[$fila->id_item] = $fila->txt;
        }

        $respuesta = new \stdClass();
        $respuesta->categorias = $categorias;
        $respuesta->a_serie[] = $datos;
        $respuesta->nombre_serie[]="Entrevistas";
        $respuesta->descarga="tc_sectores";


        return $respuesta;
    }

    /*
     * Lógica para diligenciar fichas
     */
    //Fichas de víctima
    function rel_ficha_victima() {
        return $this->hasMany(\App\Models\victima::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    //Para el select de victimas
    public function arreglo_victimas($mas_datos=false) {
        $arreglo = array();
        foreach($this->rel_ficha_victima as $victima) {
            $arreglo[$victima->id_victima]=$victima->persona->nombrecompleto;
            if($victima->persona->fec_nac_a > 0) {
                $arreglo[$victima->id_victima].=" (Año ".$victima->persona->fec_nac_a.")";
            }
            if($mas_datos) {
                //Sexo
                if($victima->persona->id_sexo > 0) {
                    $arreglo[$victima->id_victima].=" (".$victima->persona->sexo.")";
                }
                //Etnia
                if($victima->persona->id_etnia > 0) {
                    $arreglo[$victima->id_victima].=" (".$victima->persona->etnia.")";
                }
                //Parentezco
                $arreglo[$victima->id_victima].=" (".$victima->fmt_parentezco.")";

            }

        }
        return $arreglo;
    }
    //Fichas de responsable
    function rel_ficha_responsable() {
        return $this->hasMany(\App\Models\persona_responsable::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    //Para el select de responsables
    public function arreglo_responsables() {
        $arreglo = array();
        foreach($this->rel_ficha_responsable as $responsable) {
            $arreglo[$responsable->id_persona_responsable]=$responsable->persona->nombrecompleto." (".$responsable->persona->alias.")";
        }
        return $arreglo;
    }
    // Ficha de entrevista
    public function rel_ficha_entrevista() {
        return $this->belongsTo(entrevista::class,'id_e_ind_fvt','id_e_ind_fvt')->orderby('restrictiva')->orderby('id_entrevista','desc');
    }
    //Igual que anterior funcion, pero para que  se llame igual que PR, HV,EE
    public function rel_consentimiento() {
        return $this->belongsTo(entrevista::class,'id_e_ind_fvt','id_e_ind_fvt')->orderby('restrictiva')->orderby('id_entrevista','desc');
    }
    //Persona entrevistada: repito esta funcion para el bloque de conteo de fichas para AA y TC
    public function rel_persona_entrevistada() {
        return $this->rel_ficha_persona_entrevistada();
    }
    // Ficha de entrevistado
    public function rel_ficha_persona_entrevistada() {
        //return $this->hasmany(persona_entrevistada::class,'id_e_ind_fvt','id_e_ind_fvt');
        return $this->belongsto(persona_entrevistada::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    // Ficha de exilio
    public function rel_ficha_exilio() {
        return $this->hasmany(exilio::class,'id_e_ind_fvt','id_e_ind_fvt');
    }
    //Fichas de hechos
    public function rel_ficha_hecho() {
        return $this->hasMany(hecho::class,'id_e_ind_fvt','id_e_ind_fvt')
                        ->orderby('hecho.fecha_ocurrencia_a')
                        ->orderby('hecho.fecha_ocurrencia_m')
                        ->orderby('hecho.fecha_ocurrencia_d')
                        ->orderby('hecho.id_hecho');
    }

    //devuelve la ficha de entrevistado
    public function getEntrevistadoAttribute() {
        return persona::join('fichas.persona_entrevistada', 'persona_entrevistada.id_persona', '=', 'persona.id_persona')
                            ->where('persona_entrevistada.id_e_ind_fvt',$this->id_e_ind_fvt)->first();
    }


    //Para persistir el conteo y no estarlo repitiendo
    public function getDiligenciadaAttribute() {
        return $this->conteo_fichas();
    }
    public function getDiligenciadaPeAttribute() {
        return $this->conteo_fichas_pe();
    }


    // LOGICA DE LOS FORMULARIOS COMPLETOS (diligenciar fichas)
    public function conteo_fichas() {
        $conteo = new \stdClass();
        //Para referencias
        $conteo->fichas = new \stdClass();
        $conteo->fichas->entrevista = $this->rel_ficha_entrevista;
        $conteo->fichas->persona_entrevistada = $this->rel_ficha_persona_entrevistada;
        //Consentimiento informado
        $conteo->consentimiento_alertas=array();
        //conteos
        $conteo->entrevista = $this->rel_ficha_entrevista()->count() ;
        $conteo->entrevistado = $this->rel_ficha_persona_entrevistada()->count() ;
        $conteo->victimas  = $this->rel_ficha_victima()->count() ;
        $conteo->victimas_pendientes = $conteo->victimas;
        $conteo->responsables  = $this->rel_ficha_responsable()->count() ;
        $conteo->responsables_pendientes  =$conteo->responsables;
        $conteo->hechos = $this->rel_ficha_hecho()->count() ;
        $conteo->violaciones =  0;
        $conteo->violencia = 0;
        $conteo->impactos = entrevista_impacto::entrevista($this->id_e_ind_fvt)->count();
        $listado = hecho::join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho')
                            ->where('hecho.id_e_ind_fvt',$this->id_e_ind_fvt)->get() ;
        if(count($listado)>0) {
            $conteo->violencia = count($listado);
        }

        foreach($listado as $violacion) { //Cada fila es una tipo de violacion
            $conteo->violaciones = $conteo->violaciones + $violacion->cantidad_victimas;
        }
        $conteo->exilio = $this->rel_ficha_exilio()->count() ; //Fichas de exilio
        $conteo->cierre=0;
        //Determinar si se necesita ficha de exilio: si hay exilio como violencia, debe haber ficha de exilio
        $con_exilio = hecho_violencia::join('fichas.hecho','hecho.id_hecho','=','hecho_violencia.id_hecho')
                            ->join('catalogos.violencia','hecho_violencia.id_subtipo_violencia','=','violencia.id_geo')
                            ->where('hecho.id_e_ind_fvt',$this->id_e_ind_fvt)
                            ->where('violencia.codigo','2201')
                            ->count();



        $conteo->hay_exilio = $con_exilio == 0 ? 0 : 1 ;
        //$conteo->exilio = $this->rel_ficha_exilio->count();
        $conteo->exilio_collapsed = true;  //ocultar

        //Adjuntos
        $conteo->adjuntos = $this->rel_adjunto()->count();

        //Colores
        $conteo->color_victima = $conteo->victimas== 0 ? ' bg-red ' : ' bg-green ';
        $conteo->color_victima_box = $conteo->victimas== 0 ? ' box-danger ' : ' box-success ';
        $conteo->color_hechos = $conteo->hechos== 0 ? ' bg-red ' : ' bg-green ';
        $conteo->color_hechos_box = $conteo->hechos== 0 ? ' box-danger ' : ' box-success ';
        $conteo->color_violaciones = $conteo->violaciones == 0 ? ' bg-red ' : ' bg-green ';
        $conteo->color_responsables = $conteo->responsables == 0 ? ' bg-green' : ' bg-yellow ';
        $conteo->color_responsables_box = $conteo->responsables == 0 ? ' box-default' : ' box-success ';
        $conteo->color_exilio_box =  ' box-success ';

        if($conteo->hay_exilio==1) { //Llenaron hechos con exilio
            $conteo->color_exilio_box = $conteo->exilio == 0 ? ' box-danger ' : ' box-success ';
            $conteo->exilio_collapsed = false;
        }
        if($conteo->exilio > 0) {  //Llenaron ficha de exilio, pero no hay hechos con exilio

            $conteo->color_exilio_box = $conteo->hay_exilio==1 ? ' box-succes ' : ' box-danger ';  //No hay hecho con exilio como violencia
        }


        $conteo->color_adjunto = $conteo->adjuntos == 0  ? ' bg-red ' : ' bg-green ';


        //
        // Alertas
        $conteo->alerta_conteo = 0;
        $conteo->alerta_txt = array();
        //Color de los hechos en amarillo. alguno pendiente
        foreach($this->rel_ficha_hecho as $hecho) {
            if(!$hecho->control_calidad->completo) {
                $conteo->color_hechos_box = ' box-warning ';
                $conteo->alerta_txt[]="Alguna información de hechos se encuentra incompleta";
                break;
            }
        }
        if($conteo->entrevista == 0) {
            $conteo->alerta_txt[]="Falta completar la información de entrevista";
            $conteo->consentimiento_alertas[]="No se ha diligenciado la información del consentimiento informado";
        }
        else {
            if ($conteo->fichas->entrevista->conceder_entrevista <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó esta entrevista";
            }
            if ($conteo->fichas->entrevista->grabar_audio  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó grabar la entrevista";
            }
            if ($conteo->fichas->entrevista->elaborar_informe  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no está de acuerdo en que su entrevista sea utilizada para elaborar el Informe Final";
            }
            if ($conteo->fichas->entrevista->tratamiento_datos_analizar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos personales para ser analizados";
            }
            if ($conteo->fichas->entrevista->tratamiento_datos_analizar_sensible  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos sensibles para ser analizados";
            }
            if ($conteo->fichas->entrevista->tratamiento_datos_utilizar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos personales para la elaboración del informe final";
            }
            if ($conteo->fichas->entrevista->tratamiento_datos_utilizar_sensible  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos sensibles para la elaboración del informe final";
            }
            if ($conteo->fichas->entrevista->tratamiento_datos_publicar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza publicar su nombre en el informe final";
            }

        }
        if($conteo->entrevistado == 0) {
            $conteo->alerta_txt[]="Falta completar la información de persona entrevistada";
        }

        if($conteo->victimas == 0) {
            $conteo->alerta_txt[]="Falta completar información de al menos una víctima";
        }
        else {
            //Victimas sin hechos
            $arreglo_victimas = victima::where('id_e_ind_fvt',$this->id_e_ind_fvt)->pluck('id_victima')->toarray();
            $arreglo_victimas_en_hechos = hecho::where('id_e_ind_fvt',$this->id_e_ind_fvt)
                                                ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
                                                ->pluck('id_victima')->toarray();
            $pendiente=0;
            foreach($arreglo_victimas as $id_victima) {
                if(!in_array($id_victima,$arreglo_victimas_en_hechos)) {
                    $pendiente++;
                }
            }
            $conteo->victimas_pendientes=$pendiente;



            if($pendiente > 0) {
                $conteo->color_victima = ' bg-yellow ';
                $conteo->color_victima_box = ' box-warning ';
                $conteo->alerta_txt[]="Existen víctimas no incluidas en ningún hecho";
            }
            else {
                $conteo->color_victima = ' bg-green ';
                $conteo->color_victima_box = ' box-success ';
            }


        }
        if($conteo->responsables > 0) {
            //Revisar responsables sin violaciones
            $a_responsable = persona_responsable::where('id_e_ind_fvt',$this->id_e_ind_fvt)->pluck('id_persona_responsable')->toarray();
            $a_responsable_en_hechos = hecho::where('id_e_ind_fvt',$this->id_e_ind_fvt)
                                            ->join('fichas.hecho_responsable','hecho.id_hecho','=','hecho_responsable.id_hecho')
                                            ->pluck('id_persona_responsable')->toarray();
            $pendiente=0;
            foreach($a_responsable as $id_responsable) {
                if(!in_array($id_responsable,$a_responsable_en_hechos)) {
                    $pendiente++;
                }
            }
            $conteo->responsables_pendientes=$pendiente;
            if($pendiente > 0) {
                $conteo->color_responsables = ' bg-yellow ';
                $conteo->color_responsable_box = ' box-warning ';
                $conteo->color_hechos_box = ' box-warning ';
                $conteo->alerta_txt[]="Existen responsables no incluidos en ningún hecho";
            }
            else {
                $conteo->color_responsables = ' bg-green ';
                $conteo->color_responsable_box = ' box-success ';
            }

        }

        if($conteo->hechos == 0) {
            $conteo->alerta_txt[]="Falta completar la información de de los hechos";
        }
        /*
        if($conteo->hay_exilio==1 && $conteo->exilio == 0) {
            $conteo->alerta_txt[]="No se ha diligenciado la información del exilio";
            $conteo->color_hechos = ' bg-yellow ';
        }
        */
        if($conteo->impactos == 0) {
            $conteo->alerta_txt[]="Falta diligenciar la información de impactos";
        }
        //Hechos con exilio, sin ficha de exilio
        if($conteo->hay_exilio == 1) {
            if($conteo->exilio==0) {
                $conteo->alerta_txt[]="No se ha diligenciado la información del exilio";
                $conteo->color_exilio_box = ' box-danger ';
            }
        }

        //Fichas de exilio incompletas: el ->ordenado() es para que ignore inconsistencias donde hay exilio sin movimiento de salida.  No debería pasar, pero por si acaso
        foreach($this->rel_ficha_exilio()->ordenado()->get() as $f_exilio) {
            if(!$f_exilio->fmt_completo->completa) {
                $conteo->color_exilio_box = ' box-warning ';

                foreach($f_exilio->fmt_completo->alerta as $txt) {
                    $conteo->alerta_txt[]="Exilio: $txt";
                }
            }
        }

        //Hay ficha de exilio, pero no hay hecho con exilio como violenia
        if($conteo->exilio > 0) {
            if($conteo->hay_exilio == 0) {
                $conteo->alerta_txt[]="Hay ficha de exilio, pero no hay hechos con exilio como violencia";
                $conteo->color_exilio_box = ' box-danger ';
            }
        }


        //Conteo de alertas
        $conteo->alerta_conteo = count($conteo->alerta_txt);

        $conteo->situacion=0;
        if($conteo->entrevista >0 || $conteo->entrevistado > 0 || $conteo->victimas >0 || $conteo->hechos>0 || $conteo->responsables > 0) {
            $conteo->situacion = $conteo->alerta_conteo > 0 ? 2 : 3;
        }
        else {
            $conteo->situacion=1;
        }
        $colores[0]='btn-info';
        $colores[1]='btn-info';
        $colores[1]='btn-info';
        $colores[2]='btn-warning';
        $colores[3]='btn-success';
        $texto[0]='Sin fichas';
        $texto[1]='Sin fichas';
        $texto[2]='Fichas incompletas';
        $texto[3]='Fichas diligenciadas';
        $conteo->situacion_boton=$colores[$conteo->situacion];
        $conteo->situacion_texto=$texto[$conteo->situacion];
        //botones

        //Campo de la tabla e_ind_fvt
        $id_fichas=0;
        if($conteo->situacion == 3) {
            $id_fichas=1;
        }
        elseif($conteo->situacion == 2) {
            $id_fichas=2;
        }
        //Actualizar tabla de entrevistas
        $this->fichas_estado = $id_fichas;
        $this->fichas_alarmas = json_encode($conteo->alerta_txt);
        $this->save();



        //Devolver los datos
        return $conteo;
    }


    //Logica para el formulario de persona entrevistada, usado en AA y TC
    public function conteo_fichas_pe() {
        $conteo = new \stdClass();
        $conteo->existe = false;
        $conteo->existe_persona_entrevistada = false;
        $conteo->btn_consentimiento="";
        $conteo->btn_show="";
        $conteo->consentimiento_alertas = array();
        $conteo->consentimiento = entrevista::where('id_e_ind_fvt',$this->id_e_ind_fvt)->first();
        //$url=action('historia_vidaController@frm_ci',$this->id_historia_vida);
        $url=action('persona_entrevistadaController@create')."?id_e_ind_fvt=$this->id_e_ind_fvt";
        $title='Diligenciar consentimiento informado';
        $color="btn-info";
        if($conteo->consentimiento) {
            $conteo->existe=true;
            if ($conteo->consentimiento->conceder_entrevista <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó esta entrevista";
            }
            if ($conteo->consentimiento->grabar_audio  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autorizó grabar la entrevista";
            }
            if ($conteo->consentimiento->elaborar_informe  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no está de acuerdo en que su entrevista sea utilizada para elaborar el Informe Final";
            }
            if ($conteo->consentimiento->tratamiento_datos_analizar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos personales para ser analizados";
            }
            if ($conteo->consentimiento->tratamiento_datos_analizar_sensible  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos sensibles para ser analizados";
            }
            if ($conteo->consentimiento->tratamiento_datos_utilizar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos personales para la elaboración del informe final";
            }
            if ($conteo->consentimiento->tratamiento_datos_utilizar_sensible  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza el uso de sus datos sensibles para la elaboración del informe final";
            }
            if ($conteo->consentimiento->tratamiento_datos_publicar  <> 1) {
                $conteo->consentimiento_alertas[]="La persona entrevistada no autoriza publicar su nombre en el informe final";
            }
        }
        else {
            $conteo->consentimiento_alertas[] = "No se ha diligenciado el consentimiento informado";
        }

        //Persona entrevistada
        $persona_entrevistada = $this->rel_persona_entrevistada;
        if($persona_entrevistada) {
            $conteo->existe_persona_entrevistada =true;
        }
        else {
            $conteo->consentimiento_alertas[] = "No se ha diligenciado la ficha de persona entrevistada";
        }



        if($conteo->existe && $conteo->existe_persona_entrevistada) {
            $color="btn-success";
            $title = "Se ha diligenciado el consentimiento informado y la ficha de persona entrevistada";
            $url = action('persona_entrevistadaController@show',$this->rel_persona_entrevistada->id_persona_entrevistada);
            $conteo->btn_show = "<a href='$url' class='btn btn-default btn-sm ' title='Mostrar ficha de persona entrevistada' data-toggle='tooltip'><i class='fa fa-send-o'></i></a>";

        }
        elseif(!$conteo->existe && !$conteo->existe_persona_entrevistada) {
            $color="btn-danger";
            $title = "No Se ha diligenciado el consentimiento informado ni la ficha de persona entrevistada";
        }
        else {
            $color="btn-warning";
            if(!$conteo->existe) {
                $title = "No se ha diligenciado el consentimiento informado";
            }
            if(!$conteo->existe_persona_entrevistada) {
                $title = "No se ha diligenciado la ficha de persona entrevistada";
            }
        }

        if($this->puede_modificar_entrevista()) {
            $url=action('persona_entrevistadaController@create')."?id_e_ind_fvt=$this->id_e_ind_fvt";
            $conteo->btn_consentimiento = "<a href='$url' title='$title' data-toggle='tooltip' class='btn $color btn-sm'><i class='fa fa-send'></i></a>";
        }
        else {
            $conteo->btn_consentimiento="";
        }

        return $conteo;

    }

    //Evaluar si el usuario activo puede  ver las fichas
    public function permitir_ver_fichas() {
        $respuesta = new \stdClass();
        $respuesta->permitido=false;
        $respuesta->texto="Sin analizar";

        //
        $activo=\Auth::user();
        if(!$activo) {
            return false;
        }
        $arreglo_asignados=entrevistador::entrevistadores_asignados($activo->id_entrevistador);
        if(in_array($this->id_entrevistador, $arreglo_asignados)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
            return $respuesta;
        }
        //No se hace el else, porque hay que evaluar según el perfil

        //Verificar si le han compartido alguna entrevista.
        //  Esta función debe existir en c/modelo ya que en esa función se especifica la llave primaria y el id_subserie
        if($this->revisar_asignacion()) {
            $respuesta->permitido=true;
            $respuesta->texto="Asignada del usuario";
            return $respuesta;
        }

        if(\Gate::allows('es-propio',$this->id_entrevistador)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
        }
        else {
            //Perfil de solo estadística
            if(Gate::allows('solo-estadistica')) {
                $respuesta->permitido=false;
                $respuesta->texto="Perfil estadístico";
            }
            else {
                //Ver que tenga permisos de acceso a la entrevista
                if (!$this->puede_acceder_entrevista) {
                    $respuesta->texto = "No puede acceder a esta entrevista";
                    $respuesta->permitido = false;
                }
                else {
                    //Segundo chequeo: reservado-3
                    if (!$this->puede_acceder_adjuntos()) { //R3 y R2
                        $respuesta->texto = "Restricciones de analista. No puede consultar las fichas de un expediente RESERVADO.";
                        $respuesta->permitido = false;
                    }
                    else {
                        $respuesta->texto = "Puede acceder a la entrevista y tiene acceso a los adjuntos";
                        $respuesta->permitido = true;
                    }
                }
            }
        }



        return $respuesta;
    }

    //Evaluar si el usuario activo puede  editar las fichas
    public function permitir_modificar_fichas() {

        $respuesta = new \stdClass();
        $respuesta->permitido=false;
        $respuesta->texto="Sin analizar";

        //
        $activo=\Auth::user();
        if(!$activo) {
            return false;
        }
        $arreglo_asignados=entrevistador::entrevistadores_asignados($activo->id_entrevistador);
        if(in_array($this->id_entrevistador, $arreglo_asignados)) {
            $respuesta->permitido=true;
            $respuesta->texto="Usuario entre los asignados";
            return $respuesta;
        }
        if(\Gate::check('es-propio',$this->id_entrevistador)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
            return $respuesta;
        }
        //No se hace el else, porque hay que evaluar según el perfil

        //Verificar si le han compartido alguna entrevista.
        //  Esta función debe existir en c/modelo ya que en esa función se especifica la llave primaria y el id_subserie
        if($this->revisar_asignacion()) {
            $respuesta->permitido=true;
            $respuesta->texto="Asignada del usuario";
            return $respuesta;
        }



        if(\Gate::allows('es-propio',$this->id_entrevistador)) {
            $respuesta->permitido=true;
            $respuesta->texto="Propiedad del usuario";
        }
        else {

            //Perfil de solo estadística
            if(Gate::allows('solo-estadistica')) {
                $respuesta->permitido=false;
                $respuesta->texto="Perfil estadístico";
            }
            else {

                if(Gate::allows('solo-lectura')) {
                    $respuesta->texto="Restricciones de analista. No puede modificar la entrevista.";
                    $respuesta->permitido = false;
                }
                else {
                    //Ver que tenga permisos de acceso a la entrevista
                    if (!$this->puede_acceder_entrevista) {
                        $respuesta->texto = "No puede acceder a esta entrevista";
                        $respuesta->permitido = false;
                    }
                    else {
                        //Segundo chequeo: reservado-3
                        if (!$this->puede_acceder_adjuntos()) { //R3 y R2
                            $respuesta->texto = "Restricciones de analista. No puede consultar las fichas de un expediente RESERVADO.";
                            $respuesta->permitido = false;
                        }
                        else {
                            $respuesta->texto = "Puede acceder a la entrevista y tiene acceso a los adjuntos";
                            $respuesta->permitido = true;
                        }
                    }
                }
            }
        }
        //dd($respuesta);
        return $respuesta;

    }



    //Para el mapa. Tipo=1 lugar entrevista; tipo=2 lugar de los hechos
    public static function json_mapa($filtros, $tipo=1) {
        if(!is_object($filtros)) {
            $filtros = entrevista_individual::filtros_default();
        }
        $listado=entrevista_individual::filtrar($filtros)->get();

        //Crear arreglo de puntos
        $a_puntos=array();
        $tipo_lugar="Sin especificar";
        foreach($listado as $item) {
            if($tipo==1) {
                $lugar= $item->rel_entrevista_lugar;
                $tipo_lugar='Entrevista';
            }
            else {
                $lugar = $item->rel_hechos_lugar;
                $tipo_lugar='Hechos';
            }
            if(is_object($lugar)) {
                if(!is_null($lugar->lon)) {
                    $punto=array();
                    $punto['lon']=$lugar->lon*1;
                    $punto['lat']=$lugar->lat*1;
                    $punto['codigo']=$item->entrevista_codigo;
                    $punto['fecha']=$item->fmt_entrevista_fecha;
                    $punto['id']=$item->id_e_ind_fvt;
                    $punto['titulo']=$item->titulo;
                    $punto['fuente']="e_ind_fvt";
                    $a_puntos[$item->id_e_ind_fvt]=$punto;
                }
            }
        }
        //dd($a_puntos);
        $geojson = entrevista_individual::convertir_geojson($a_puntos);
        $geojson['lugar']=$tipo_lugar;
        return $geojson;
    }

    public static function convertir_geojson($a_puntos) {
        $geojson = array( 'type' => 'FeatureCollection', 'conteo'=>0,'features' => array());
        foreach($a_puntos as $id=>$punto) {
            $marker = array(
                'type' => 'Feature',
                'lugar' => 'Sin especificar',
                'features' => array(
                    'type' => 'Feature',
                    'properties' => $punto,
                    //'weight' => $registro['weight'] ,
                    "geometry" => array(
                        'type' => 'Point',
                        'coordinates' => array(
                            $punto['lon']*1,
                            $punto['lat']*1
                        )
                    )
                )
            );
            array_push($geojson['features'], $marker['features']);
        }
        $geojson['conteo']=count($geojson['features']);

        return $geojson;
    }

    /***
     * Verifica si existe una entrvista a un modelo: persona, entrevista, etc.
     * @Var: Object Model, implementando la interface EntrevistaIndividual
     * @var: $id_e_ind_fvt, código identificador de una entrevista individual
     * @return: Null si no existe el registro del modelo de lo contrario el modelo
     */

    public static function validarExistenciaEntrevistaEnLaFicha(EntrevistaIndividual $modelo, $id_e_ind_fvt) {     

        return $modelo->existeEntrevistaIndividual($id_e_ind_fvt);
    }

    /**
     * Método que valida si existe una entrevista individual 
     * @Var: id_e_ind_fvt, código identificador de una entrevista individual
     */

    public static function existeEntrevista($id_e_ind_fvt) {

        if (entrevista_individual::find($id_e_ind_fvt))
            return true;
        return false;
    }

    //Para mostrar detalle en el panel de fichas
    public function conteo_impactos() {
        $conteos=new \stdClass();
        $conteos->i_individuales=0;
        $conteos->i_relacionales=0;
        $conteos->i_colectivos=0;
        $conteos->a_individual=0;
        $conteos->a_familiar=0;
        $conteos->a_colectivo=0;
        $conteos->denuncia=0;
        $conteos->reparacion=0;

        $base = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
                                    ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item');

        $conteos->i_individuales = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
                                    ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                                    ->wherein('id_cat',[132,133,134])->count();
        $conteos->i_relacionales = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[135,136])->count();
        $conteos->i_colectivos = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[138,139,140,141,142,143])->count();
        $conteos->a_individual = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[144])->count();
        $conteos->a_familiar = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[145])->count();
        $conteos->a_colectivo = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[146,147,148])->count();
        $conteos->denuncia = justicia_institucion::where('id_e_ind_fvt',$this->id_e_ind_fvt)->count();
        $conteos->reparacion = entrevista_impacto::where('id_e_ind_fvt',$this->id_e_ind_fvt)
            ->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
            ->wherein('id_cat',[164,165,166,167,168])->count();


        return $conteos;




    }

    //Para el autofill
    public static function listado_priorizacion($criterio="") {
        $filtros = entrevista_individual::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $campo="prioritario_tema";
        $opciones= entrevista_individual::filtrar($filtros)->where($campo,'ilike',"%$criterio%")->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }
    public static function listado_titulo($criterio="") {
        $filtros = entrevista_individual::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $campo="titulo";
        $opciones= entrevista_individual::filtrar($filtros)->where($campo,'ilike',"%$criterio%")->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }
    public static function listado_anotaciones($criterio="") {
        $filtros = entrevista_individual::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $campo="anotaciones";
        $opciones= entrevista_individual::filtrar($filtros)->where($campo,'ilike',"%$criterio%")->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }
    public static function listado_dinamica($criterio="") {
        $filtros = entrevista_individual::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $campo="dinamica";
        $opciones= entrevista_individual::filtrar($filtros)->join('esclarecimiento.e_ind_fvt_dinamica','e_ind_fvt.id_e_ind_fvt','=','e_ind_fvt_dinamica.id_e_ind_fvt')
                                            ->where($campo,'ilike',"%$criterio%")->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }
    public static function listado_observaciones_diligenciada($criterio="") {
        $filtros = entrevista_individual::filtros_default();  //solo entrevistas permitidas
        $criterio = str_replace(" ","%",$criterio);
        $campo="observaciones_diligenciada";
        $opciones= entrevista_individual::filtrar($filtros)->where($campo,'ilike',"%$criterio%")->limit(30)->orderby($campo)->pluck($campo)->toArray();
        return $opciones;
    }


    //Etiquetas
    public function rel_etiquetas() {
        return $this->hasMany(etiqueta_entrevista::class,'id_entrevista','id_e_ind_fvt')->where('id_subserie',$this->id_subserie)->orderby('del');
    }
    public function listar_etiquetas() {
        return etiqueta_entrevista::where('id_subserie',$this->id_subserie)->where('id_entrevista',$this->id_e_ind_fvt)
                                    ->join('sim.etiqueta','etiqueta_entrevista.id_etiqueta','=','etiqueta.id_etiqueta')
                                    ->leftjoin('catalogos.tesauro','etiqueta.id_etiqueta','=','tesauro.id_etiqueta')
                                    ->orderby('tesauro.codigo')
                                    ->orderby('etiqueta.etiqueta')
                                    ->select(DB::raw('etiqueta_entrevista.*'))
                                    ->get();
    }
    //Devuelve HTML con el etiquetado resaltado
    public function prueba_etiquetado () {
        $texto = $this->html_transcripcion;
        //$texto=str_replace("\n","¬",$texto);

        $posicion=-1;
        $a_secciones=array();
        $a_posiciones=array();
        foreach($this->rel_etiquetas as $marca) {

            if($marca->del >= $posicion ) { //ver que no se traslape.  esto ignoraría parrafos con doble marca y entidades
                $posicion++;
                $hasta=$marca->del+1-$posicion;
                $sin_marca=substr($texto,$posicion,$hasta);
                $a_secciones[]=$sin_marca;  //Texto sin etiqueta
                $a_posiciones[]="$posicion,$hasta";  //Texto sin etiqueta
                $con_marca = substr($texto, $marca->del+1, strlen($marca->texto));  //Extraer el pedazo para el replace
                $etiqueta= etiqueta::find($marca->id_etiqueta);  //Buscar el texto descriptivo para el tooltip
                $nuevo = "<span title='$etiqueta->texto' class='text-green' data-toggle='tooltip'>$con_marca</span>";  //texto con marca
                $a_secciones[] = $nuevo; //Agregar nuevo segmento
                $a_posiciones[]="$marca->del,$marca->al";  //Texto sin etiqueta
                $posicion = $marca->del +  strlen($marca->texto);
            }
            //$texto = str_replace($marca->texto, $nuevo, $texto);
            //$texto = substr_replace($texto, $nuevo, $marca->del+1, $marca->al - $marca->del);
        }
        //Resto del texto
        $posicion++;
        $a_posiciones[]="$posicion";  //
        $a_secciones[] = substr($texto,$posicion);
        //dd($a_secciones);
        //dd($a_posiciones);
        //Unir c/pedazo
        return nl2br(implode("",$a_secciones));
    }
    //Atributos relacionados con el etiquetado
    public function getEtiquetasAttribute() {
        $a_etiquetas=array();
        foreach($this->rel_etiquetas as $marca) {
            $etiqueta =  etiqueta::find($marca->id_etiqueta);
            $a_etiquetas[$etiqueta->etiqueta] =$etiqueta->texto;
        }
        return $a_etiquetas;

    }

    function getEtiquetadoAttribute() {
        $r = new \stdClass();
        $r->a_original=array();
        $r->a_texto = array();
        $r->a_pos = array();
        $r->a_etiquetado = array();
        $salto = 13;  //Ajustar la posición relativa
        $r->texto = $texto = $this->html_transcripcion;
        $posicion=0;
        foreach($this->rel_etiquetas as $marca) {
            if($marca->del >= $posicion  && $marca->del <= strlen($r->texto) ) { //ver que no se traslape.  esto ignoraría parrafos con doble marca y entidades
                $r->a_original[] = $marca->texto;
                $inicio = strpos($r->texto, $marca->texto, $marca->del);
                $texto_etiquetado = substr($r->texto, $inicio, strlen($marca->texto));
                $r->a_texto[] = $texto_etiquetado;
                $pos['del'] = $marca->del;
                $pos['al'] = $marca->al;
                $r->a_pos[] = $pos;
                // Lo que quedó en medio de las etiquetas
                //$posicion++;
                $texto_previo = substr($r->texto,$posicion,$inicio-$posicion);
                $r->a_etiquetado[]=$texto_previo;
                //Resaltar el texto en otra variable para no perder el largo original
                $etiqueta= etiqueta::find($marca->id_etiqueta);  //Buscar el texto descriptivo para el tooltip
                $resaltado = "<span title='$etiqueta->texto' class='text-green' data-toggle='tooltip'>$texto_etiquetado</span>";  //texto con marca
                $r->a_etiquetado[]=$resaltado;
                $posicion = $inicio + strlen($texto_etiquetado);
            }
        }
        $r->a_etiquetado[] = substr($r->texto,$posicion);

        // Unir en un solo texto
        $r->texto_resaltado = nl2br(implode("", $r->a_etiquetado));
        return $r;

    }


    /*
     * INTERCONEXION CON DATATURKS
     */

    //Para facilitar el mantenimiento de las otras entrevisats
    public static function dataturk_crear_y_asignar($entrevista,$id_entrevistador) {
        $res = new \stdClass();
        $res->id_entrevistador = $id_entrevistador;
        $res->mensaje="Hubo problemas";
        $res->exito = false;
        //$res->eliminado = $this->dataturk_eliminar_proyecto(); //Por si acaso
        $res->proyecto = $entrevista->dataturk_crear_proyecto();
        if($res->proyecto->exito) {
            $entrevista->refresh();  //Para que actualice el json_etiquetado
            $res->texto = $entrevista->dataturk_enviar_texto();
            $res->etiquetador = $entrevista->dataturk_asignar_etiquetador($id_entrevistador);
            $res->exito = $res->proyecto->exito && $res->etiquetador->exito && $res->texto->exito;

            if(!$res->exito) {
                $txt['texto'] = "carga de texto: ".$res->texto->mensaje;
                $txt['etiquetador'] = "asignar etiquetador: ".$res->etiquetador->mensaje;
                $res->mensaje = implode ( " || ",$txt);
                Log::debug('Problema al crear proyecto'. PHP_EOL .json_encode($res));
                Log::warning("Problemas al enviar a dataturk la entrevista ($entrevista->entrevista_codigo) con el entrevistador ($id_entrevistador)");
                $entrevista->dataturk_eliminar_proyecto();
                Log::warning("Por problemas en el proceso, se eliminó el proyecto en dataturks ". PHP_EOL .$res->mensaje);
            }
            else {
                $res->mensaje = "ok";
            }
        }
        else {
            $res->log = $res->proyecto->log;
            $res->mensaje = $res->proyecto->mensaje;
            Log::debug('Problema al crear proyecto');
            Log::debug(json_encode($res));
        }

        return $res;
    }


    //Esta función es un wrapper que facilita las cosas
    public function dataturk_enviar_todo($id_entrevistador=10) {
        return entrevista_individual::dataturk_crear_y_asignar($this,$id_entrevistador);
    }



    // Crear el proyecto en dataturks
    public function dataturk_crear_proyecto() {
        $insercion = tesauro::dataturk_crear_proyecto($this);
        return $insercion;
    }

    //Eliminar un proyecto
    public function dataturk_eliminar_proyecto() {
        return tesauro::dataturk_eliminar_proyecto($this->entrevista_codigo);
    }

    //Funcion que envia al dataturk la transcripcion como un solo texto
    public function dataturk_enviar_texto() {
        $cuanto=config('expedientes.turk_limit');
        if(!empty($this->json_etiquetado)) {
            $txt = $this->json_etiquetado;
            $tipo=2;//Etiquetado
        }
        else {
            $txt = $this->extraer_texto_transcripcion();
            //Bug de dataturk que no acepta textos largos
            $txt=substr($txt,0,$cuanto);
            $tipo=1; //texto
        }

        $envio = tesauro::dataturk_subir_archivo($this->entrevista_codigo,$txt,$tipo);
        return $envio;
    }

    public function extraer_texto_transcripcion() {
        return $this->fmt_html_transcripcion;
    }

    public function dataturk_asignar_etiquetador($id_entrevistador=10) {
        $e = entrevistador::find($id_entrevistador);
        $correo = $e ? $e->correo : "invalido_$id_entrevistador@gmail.com";
        $respuesta = tesauro::dataturk_asignar_etiquetador($correo,$this->entrevista_codigo);
        return $respuesta;
    }

    public function dataturk_quitar_etiquetador($id_entrevistador=10) {
        $e = entrevistador::find($id_entrevistador);
        $correo = $e ? $e->correo : "invalido_$id_entrevistador@gmail.com";
        $respuesta = tesauro::dataturk_quitar_etiquetador($correo,$this->entrevista_codigo);
        return $respuesta;
    }



    //Descarga el etiquetado, lo adjunta y lo procesa
    public function dataturk_traer_etiquetado() {
        $respuesta = new \stdClass();
        $respuesta->exito = false;
        $respuesta->etiquetado = null;
        $recibido = tesauro::dataturk_descargar_etiquetado($this->entrevista_codigo);
        if($recibido->exito) {
            //dd($recibido->respuesta);
            $json = $recibido->respuesta;
            $adjunto = adjunto::crear_archivo(json_encode($json));
            $adjuntado = new entrevista_individual_adjunto();
            $adjuntado->id_e_ind_fvt = $this->id_e_ind_fvt;
            $adjuntado->id_adjunto = $adjunto->id_adjunto;
            $adjuntado->id_tipo = 25;
            $adjuntado->save();
            //Traza
            traza_actividad::create(['id_objeto'=>2, 'id_accion'=>3, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$adjuntado->id_adjunto,'referencia'=>"JSON etiquetado"]);
            //Procesar las etiquetas
            $respuesta->etiquetado = $adjuntado->procesar_etiquetas();
            $respuesta->exito = true;
        }
        else {
            Flash::error("No se pudo extraer el texto de dataturk.  ¿faltó darle click a 'Finalizar' en dataturk?");
            Log::warning($recibido->respuesta);
            Log::warning("Problemas al extraer el texto etiquetado del dataturk para la entrevista $this->entrevista_codigo");
            $respuesta->etiquetado = $recibido;
        }
        return $respuesta;
    }

    //Mostrar la transcripcion mas bonita
    public function getFmtHtmlTranscripcionAttribute() {
        $transcripcion = $this->html_transcripcion;

        //Corregir tags de otranscribe
        $quitar= '<p><span> </span></p>';
        $transcripcion = str_ireplace($quitar,'',$transcripcion);

        //Limpiador de html, meterle los retornos de linea como html
        $html = new Html2Text(nl2br($transcripcion),['width'=>0]);
        $txt = $html->getText(0);
        //Quitar retornos de linea dobles
        $txt = preg_replace( "/([\r\n]{4,}|[\n]{2,}|[\r]{2,})/", "\n", $txt);
        //Fin del proceso
        return $txt;
    }




    // Leer html del adjunto
    public function halar_transcripcion() {
        if(strlen($this->json_etiquetado)<=0 && strlen($this->html_transcripcion)<=0) {
            $adjunto = $this->rel_adjunto()->where('id_tipo',6)->orderby('id_adjunto','desc')->first();
            if($adjunto) {
                $transcripcion = $adjunto->rel_id_adjunto;
                if($transcripcion->existe) {
                    $html = Storage::get('public/'.$transcripcion->ubicacion);
                    if($html) {
                        $this->html_transcripcion = $html;
                        $this->save();
                        return true;
                    }
                }
                else {
                    return false;
                }

            }
            else {
                return false;
            }
        }
        else {
            return false;
        }

    }

    //Actualización masiva de las transcripciones.
    public static function actualizar_transcripcion() {
        $a=array();
        foreach(entrevista_individual::wherenull('json_etiquetado')->wherenull('html_transcripcion')->get() as $entrevista) {
            $a[$entrevista->id_e_ind_fvt] = $entrevista->halar_transcripcion();
        }
        return $a;
    }



    // Retorna el tipo de entrevista. Identifica si es indivitual o colectiva étnica
    public function tipo() {
        return 'individual';
    }

    //Desplegar prioridad
    public function getPrioridadAttribute() {
        $existe = prioridad::where('id_entrevista',$this->id_e_ind_fvt)->where('id_subserie',$this->id_subserie)
                                ->orderby('id_tipo','desc')
                                ->orderby('fecha_hora','desc')
                                ->first();
        if($existe) {
            return $existe;
        }
        else {
            return false;
        }
    }


    // Retorna el id de la entrevista segun sea indivitual
    public function getIdEntrevistaAttribute() {
        return $this->id_e_ind_fvt;
    }

    //Buscar en tesauro.  Recibe id_geo
    public function scopeTesauro($query, $criterio=-1) {
        if($criterio > 0) {
            $id_subserie = array(config('expedientes.vi'),config('expedientes.aa'), config('expedientes.tc') );
            $contenidos = tesauro::find($criterio)->arreglo_incluidos();

            $universo =  etiqueta_entrevista::wherein('id_subserie',$id_subserie)
                ->join('catalogos.tesauro as ft','etiqueta_entrevista.id_etiqueta','=','ft.id_etiqueta')
                ->wherein('ft.id_geo',$contenidos)
                ->distinct()
                ->pluck('id_entrevista');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);

        }
    }


    //Usado para el primer despliegue del cambio
    public static function actualizar_estado_diligenciado() {
        $listado = self::where('id_activo',1)->where('fichas_estado',0)->orderby('id_e_ind_fvt')->get();
        $i=0;
        foreach($listado as $e) {
            $e->diligenciada;
            $i++;
        }
        return $i;
    }


    public function tipo_entrevista() {
        return 'individual';
    }    

    /*
     * 16-ABR-20
     * ESTADISTICAS DE LA DILIGENCIADA
     */

    //Estadisticas mostradas como tablas y conteos superiores
    public static function stats_diligenciada_vi($filtros=null) {
        //Log::debug("--- Inicio del calculo de estadisticas ----");
        //$time_start = microtime(true);
        //Estructura de la respuesta
        $respuesta = new \stdClass();
        $respuesta->conteos = new \stdClass();
        //Conteos generales
        $respuesta->conteos->entrevistas = 0;  //Cantidad de entrevistas
        $respuesta->conteos->personas_entrevistadas = 0;  //Cantidad de fichas de persona entrevistas
        $respuesta->conteos->victimas_total = 0;  //Cantidad total de víctimas
        $respuesta->conteos->victimas_conocidas = 0;  //Cantidad total de víctimas que tenemos algún dato
        $respuesta->conteos->personas = 0;  //Cantidad total de personas distintas, independientemente de las violencias sufridas
        $respuesta->conteos->hechos = 0;  //Cantidad de hechos de violencia
        $respuesta->conteos->violencias = 0;  //Cantidad de violencias
        $respuesta->conteos->id_cerrado[1] = 0; //Cantidad de entrevistas cerradas
        $respuesta->conteos->id_cerrado[2] = 0; //Cantidad de entrevistas abiertas
        //Estado de la diligenciada
        $respuesta->conteos->estado[0]= 0; //Nada
        $respuesta->conteos->estado[1]= 0; // Completo
        $respuesta->conteos->estado[2]= 0; // A medias


        //Tiempo promedio
        $tiempos[0]=0; //Entrevista
        $tiempos[1]=0; //Transcribir
        $tiempos[2]=0; //Etiquetar
        $tiempos[3]=0; //Diligenciar
        $respuesta->tiempos = $tiempos;









        //Query Base: aplicar filtros parejo
        //$query_base = entrevista_individual::filtrar($filtros);

        //Aplicar filtros de fecha de los hechos, lugar de los hechos, etc.  Este es el query base a utilizar
        //self::procesar_filtros_persona_entrevistada($query_base,$filtros);

        $query_base_victimas = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho')
            ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima');

        $query_base_violencia = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho');


        $query_base_entrevistas = entrevista_individual::filtrar($filtros);



        //Aplicar filtros de fecha de los hechos, lugar de los hechos, etc.
        self::procesar_filtros_fichas_por_hechos($query_base_victimas,$filtros);
        self::procesar_filtros_fichas_por_entrevista($query_base_entrevistas,$filtros);
        self::procesar_filtros_fichas_por_hechos($query_base_violencia,$filtros);









        if($filtros->debug) {
            $debug['sql_base']=$query_base_entrevistas->toSql();
            $debug['criterios']=$query_base_entrevistas->getBindings();
            $debug['sql_final'] = self::getQueries($query_base_entrevistas);
            dd($debug);
        }


        //Calculos generales



        //Conteos superiores: víctimas totales, víctimas conocidas, hechos
        //Cantidad de entrevistas
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $universo_entrevistas = $query->distinct()->pluck('e_ind_fvt.id_e_ind_fvt');
        $respuesta->conteos->entrevistas = count($universo_entrevistas);

        //Cantidad de personas entrevistadas
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $respuesta->conteos->personas_entrevistadas = $query->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','persona_entrevistada.id_e_ind_fvt')->count();


        //Cantidad de hechos
        $query = clone $query_base_victimas;   //Hechos que tienen al menos una víctima y al menos una violencia
        //dd($query_base_victimas->toSql());
        $universo_hechos = $query->distinct()->pluck('hecho.id_hecho');
        $respuesta->conteos->hechos = count($universo_hechos);

        //Cantidad de violencias
        $query = clone $query_base_victimas;  //Hechos que tienen al menos una víctima y al menos una violencia
        $universo_violencia = $query->distinct()->pluck('hecho_violencia.id_hecho_violencia');
        $respuesta->conteos->violencias = count($universo_violencia);



        //Cantidad de victimas total
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes

        $respuesta->conteos->victimas_total = $query->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                                                    ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                                                    ->sum('cantidad_victimas');
        //Cantidad de víctimas conocidas
        $query = clone $query_base_victimas;  //Para quitar lo que le hayan agregado antes
        $respuesta->conteos->victimas_conocidas = $query->count();


        //Cantidad de personas
        $query = clone $query_base_victimas;  //Para quitar lo que le hayan agregado antes
        $universo_personas = $query->distinct()->pluck('victima.id_persona');
        $respuesta->conteos->personas = count($universo_personas);







        //Estado de cerrado
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->select(\DB::raw('id_cerrado, count(1) as val'))
            ->groupby('id_cerrado')
            ->get();
        foreach($res as $fila) {
            $respuesta->conteos->id_cerrado[$fila->id_cerrado] = $fila->val;
        }
        //Avance en la diligenciada
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->select(\DB::raw('fichas_estado, count(1) as val'))
            ->groupby('fichas_estado')
            ->get();
        foreach($res as $fila) {
            $respuesta->conteos->estado[$fila->fichas_estado] = $fila->val;
        }
        //dd($respuesta->conteos->estado);




        //Otros indicadores
        $query = clone $query_base_entrevistas;
        $respuesta->con_transcripcion = $query->wherenotnull('html_transcripcion')->count();
        if($respuesta->conteos->entrevistas > 0) {
            $respuesta->con_transcripcion_porcentaje =  $respuesta->con_transcripcion / $respuesta->conteos->entrevistas * 100;
        }
        else {
            $respuesta->con_transcripcion_porcentaje = 0;
        }


        $query = clone $query_base_entrevistas;
        $respuesta->con_etiquetado = $query->wherenotnull('json_etiquetado')->count();
        if($respuesta->conteos->entrevistas > 0) {
            $respuesta->con_etiquetado_porcentaje =  $respuesta->con_etiquetado / $respuesta->conteos->entrevistas * 100;
        }
        else {
            $respuesta->con_etiquetado_porcentaje = 0;
        }


        $respuesta->con_fichas = $respuesta->conteos->estado[1];
        if($respuesta->conteos->entrevistas > 0) {
            $respuesta->con_fichas_porcentaje =  $respuesta->con_fichas / $respuesta->conteos->entrevistas * 100;
        }
        else {
            $respuesta->con_fichas_porcentaje = 0;
        }

        //Al menos una victima con violencia
        $query = clone $query_base_entrevistas;
        $universo = hecho::join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                            ->join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                            ->distinct()
                            ->pluck("hecho.id_e_ind_fvt");
        $respuesta->con_victima = $query->wherein('id_e_ind_fvt',$universo)->count();
        if($respuesta->con_victima>0) {
            $respuesta->con_victima_porcentaje =  $respuesta->con_victima / $respuesta->conteos->entrevistas * 100;
        }
        else {
            $respuesta->con_victima_porcentaje = 0;
        }

        //Con datos de persona entrevistada
        $respuesta->con_persona_entrevistada = $respuesta->conteos->personas_entrevistadas;
        if($respuesta->con_persona_entrevistada>0) {
            $respuesta->con_persona_entrevistada_porcentaje =  $respuesta->con_persona_entrevistada / $respuesta->conteos->entrevistas * 100;
        }
        else {
            $respuesta->con_persona_entrevistada_porcentaje = 0;
        }



        //tiempos
        $query = clone $query_base_entrevistas;
        $r = $query->join('procesamiento_tiempo as p', 'e_ind_fvt.id_e_ind_fvt','=','p.id_entrevista')
                        ->where('p.id_subserie','=',config('expedientes.vi'))
                        ->selectraw(\DB::raw('p.id_tipo_medicion, avg(p.tiempo_minutos) as minutos'))
                        ->groupby('id_tipo_medicion')
                        ->get();

        foreach($r as $fila) {
            $tiempos[$fila->id_tipo_medicion] = $fila->minutos;
        }
        $query = clone $query_base_entrevistas;
        $r = $query->join('transcribir_asignacion as t', 'e_ind_fvt.id_e_ind_fvt','=','t.id_e_ind_fvt')
            ->selectraw(\DB::raw(' avg(duracion_entrevista_minutos) as minutos'))
            ->get();
        $tiempos[0]=$r->first()->minutos;

        $respuesta->tiempos = $tiempos;

//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a tiempos: $formato segundos");
//        $time_start = microtime(true);

        //Sectores de las entrevistas

        $query = clone $query_base_entrevistas;
        $query->join('catalogos.cat_item','e_ind_fvt.id_sector','=','cat_item.id_item');
        $res = self::query_simple($query,'cat_item.id_item');
        $res->descripcion = "Sectores asociados a las entrevistas";
        $respuesta->entrevistas = new \stdClass();
        $respuesta->entrevistas->sectores = $res;




        //Entrevistas, etiquetadas, transcritas, por territorial
        //Estructura de los territorios
        $a_macro = cev::where('nivel',1)->orderby('descripcion')->pluck('descripcion','id_geo');
        $a_terr = cev::where('nivel',2)->orderby('descripcion')->pluck('descripcion','id_geo')->toArray();
        $estructura = array();
        foreach($a_macro as $id=>$txt) {
            $hijos = cev::where('id_padre',$id)->orderby('descripcion')->pluck('descripcion','id_geo')->toArray();
            $estructura[$id]['hijos']=$hijos;
            $estructura[$id]['nombre']=$txt;
        }
        //Respuesta
        $respuesta->procesamiento_macro = new \stdClass();
        $respuesta->procesamiento_macro->estructura = $estructura;

        //Transcritas
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, case when html_transcripcion is null then 2 else 1 end as transcrita ,count(1) as val"))
                        ->groupby("e_ind_fvt.id_macroterritorio")
                        ->groupby("e_ind_fvt.id_territorio")
                        ->groupby("transcrita")
                        ->orderby('e_ind_fvt.id_macroterritorio')
                        ->orderby('e_ind_fvt.id_territorio')
                        ->orderby('transcrita')
                        ->get();
        $datos=array();
        foreach($a_terr as $id => $txt) {
            $datos[$id][1]=0;
            $datos[$id][2]=0;
        }
        $datos_macro=array();
        foreach($a_macro as $id=>$txt) {
            $datos_macro[$id][1]=0;
            $datos_macro[$id][2]=0;
        }

        foreach($res as $fila) {
            $datos[$fila->id_territorio][$fila->transcrita]=$fila->val;
            $datos_macro[$fila->id_macroterritorio][$fila->transcrita]+=$fila->val;
        }
        $total=0;
        foreach($datos_macro as $macro=>$val) {
            $total = $total+$val[1];
        }

        //Transcritas
        $respuesta->procesamiento_macro->transcritas = new \stdClass();
        $respuesta->procesamiento_macro->transcritas->categorias = $a_terr;
        $respuesta->procesamiento_macro->transcritas->datos = $datos;
        $respuesta->procesamiento_macro->transcritas->datos_macro = $datos_macro;
        $respuesta->procesamiento_macro->transcritas->total = $total;



        //Etiquetadas
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, case when json_etiquetado is null then 2 else 1 end as etiquetada ,count(1) as val"))
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->groupby("etiquetada")
            ->orderby('e_ind_fvt.id_macroterritorio')
            ->orderby('e_ind_fvt.id_territorio')
            ->orderby('etiquetada')
            ->get();
        $datos=array();
        foreach($a_terr as $id => $txt) {
            $datos[$id][1]=0;
            $datos[$id][2]=0;
        }
        $datos_macro=array();
        foreach($a_macro as $id=>$txt) {
            $datos_macro[$id][1]=0;
            $datos_macro[$id][2]=0;
        }
        foreach($res as $fila) {
            $datos[$fila->id_territorio][$fila->etiquetada]=$fila->val;
            $datos_macro[$fila->id_macroterritorio][$fila->etiquetada]+=$fila->val;

        }
        $total=0;
        foreach($datos_macro as $macro=>$val) {
            $total = $total+$val[1];
        }
        $respuesta->procesamiento_macro->etiquetadas = new \stdClass();
        $respuesta->procesamiento_macro->etiquetadas->categorias = $a_terr;
        $respuesta->procesamiento_macro->etiquetadas->datos = $datos;
        $respuesta->procesamiento_macro->etiquetadas->datos_macro = $datos_macro;
        $respuesta->procesamiento_macro->etiquetadas->total = $total;

        //Fichas diligenciadas
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, fichas_estado ,count(1) as val"))
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->groupby("fichas_estado")
            ->orderby('e_ind_fvt.id_macroterritorio')
            ->orderby('e_ind_fvt.id_territorio')
            ->orderby('fichas_estado')
            ->get();
        $datos=array();
        foreach($a_terr as $id => $txt) {
            $datos[$id][1]=0;
            $datos[$id][2]=0;
        }
        $datos_macro=array();
        foreach($a_macro as $id=>$txt) {
            $datos_macro[$id][1]=0;
            $datos_macro[$id][2]=0;
        }
        foreach($res as $fila) {
            $situacion = $fila->fichas_estado==1 ? 1 : 2;
            $datos[$fila->id_territorio][$situacion]=$fila->val;
            $datos_macro[$fila->id_macroterritorio][$situacion]+=$fila->val;
        }

        $total=0;
        foreach($datos_macro as $macro=>$val) {
            $total = $total+$val[1];
        }


        $respuesta->procesamiento_macro->fichas = new \stdClass();
        $respuesta->procesamiento_macro->fichas->categorias = $a_terr;
        $respuesta->procesamiento_macro->fichas->datos = $datos;
        $respuesta->procesamiento_macro->fichas->datos_macro = $datos_macro;
        $respuesta->procesamiento_macro->fichas->total = $total;

        //Entrevistas cerradas
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio, id_cerrado ,count(1) as val"))
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->groupby("id_cerrado")
            ->orderby('e_ind_fvt.id_macroterritorio')
            ->orderby('e_ind_fvt.id_territorio')
            ->orderby('id_cerrado')
            ->get();
        $datos=array();
        foreach($a_terr as $id => $txt) {
            $datos[$id][1]=0;
            $datos[$id][2]=0;
        }
        $datos_macro=array();
        foreach($a_macro as $id=>$txt) {
            $datos_macro[$id][1]=0;
            $datos_macro[$id][2]=0;
        }
        foreach($res as $fila) {
            $situacion = $fila->id_cerrado==1 ? 1 : 2;
            $datos[$fila->id_territorio][$situacion]=$fila->val;
            $datos_macro[$fila->id_macroterritorio][$situacion]+=$fila->val;
        }
        $total=0;
        foreach($datos_macro as $macro=>$val) {
            $total = $total+$val[1];
        }


        $respuesta->procesamiento_macro->cerrado = new \stdClass();
        $respuesta->procesamiento_macro->cerrado->categorias = $a_terr;
        $respuesta->procesamiento_macro->cerrado->datos = $datos;
        $respuesta->procesamiento_macro->cerrado->datos_macro = $datos_macro;
        $respuesta->procesamiento_macro->cerrado->total = $total;


        //Totales

        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw("e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio ,count(1) as val"))
            ->groupby("e_ind_fvt.id_macroterritorio")
            ->groupby("e_ind_fvt.id_territorio")
            ->orderby('e_ind_fvt.id_macroterritorio')
            ->orderby('e_ind_fvt.id_territorio')
            ->get();
        $datos=array();
        foreach($a_terr as $id => $txt) {
            $datos[$id]=0;
        }
        $datos_macro=array();
        foreach($a_macro as $id=>$txt) {
            $datos_macro[$id]=0;
        }
        foreach($res as $fila) {
            $datos[$fila->id_territorio]=$fila->val;
            $datos_macro[$fila->id_macroterritorio]+=$fila->val;
        }
        $total=0;
        foreach($datos_macro as $macro=>$val) {
            $total = $total+$val;
        }


        $respuesta->procesamiento_macro->entrevistas = new \stdClass();
        $respuesta->procesamiento_macro->entrevistas->categorias = $a_terr;
        $respuesta->procesamiento_macro->entrevistas->datos = $datos;
        $respuesta->procesamiento_macro->entrevistas->datos_macro = $datos_macro;
        $respuesta->procesamiento_macro->entrevistas->total = $total;

        //dd($respuesta->procesamiento_macro);

//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a macros: $formato segundos");
//        $time_start = microtime(true);


        //------ INFORMACION DE PERSONA ENTREVISTADA: total y tablas que no se piden por ajax

        $respuesta->entrevistada = new \stdClass();

        //Reset de conteo de filtros, para que no se acumulen
        $filtros->hay_filtro=0;


        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','=','persona_entrevistada.id_e_ind_fvt')
            ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona');
        self::procesar_filtros_persona_entrevistada($query_base,$filtros);


        //Total de fichas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $respuesta->entrevistada->total = $query->count();

        //Sexo y edad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona.id_sexo, persona_entrevistada.edad,  count(1) as val'))
            ->groupby('id_sexo','edad')
            ->get();

        $g_edades=array();
        $g_edades[0] = "Desconocido";
        $g_edades[1] = "NNA (0-17)";
        $g_edades[2] = "Joven (18-26)";
        $g_edades[3] = "Adulto (27-59)";
        $g_edades[4] = "Persona mayor (60 en adelante)";
        //$g_edades[-99] = "Sin especificar";
        //Limite superior
        $limites=array();
        $limites[0]=-1;
        $limites[1]=17;
        $limites[2]=26;
        $limites[3]=59;

        $x=array();
        $categorias= array(); //inicializarlo
        $categorias['id_sexo']=array();
        $categorias['id_edad']=$g_edades;
        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            $categorias['id_sexo'][$id_sexo] = cat_item::describir($id_sexo);
        }
        //dd($categorias);

        //Llenar todos los resultados a cero
        foreach($categorias['id_sexo'] as $id_sexo => $sexo) {
            foreach($categorias['id_edad'] as $id_edad => $edad) {
                $x[$id_sexo][$id_edad]=0;
            }
        }

        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            //Determinar el grupo de edad
            $id_edad=4; //Si no sale del ciclo
            foreach($limites as $id_categoria => $max) {
                if($fila->edad <= $max ) {
                    $id_edad = $id_categoria;
                    break;
                }
            }
            $x[$id_sexo][$id_edad] += $fila->val;

        }
        //Respuesta
        $respuesta->entrevistada->sexo_edad = new \stdClass();
        $respuesta->entrevistada->sexo_edad->categorias = $categorias;
        $respuesta->entrevistada->sexo_edad->datos = $x;

        //Sexo e Identidad género
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona.id_sexo, persona.id_identidad,  count(1) as val'))
            ->groupby('id_sexo','id_identidad')
            ->get();
        $x=array();
        $categorias= array(); //inicializarlo
        $categorias['id_sexo']=array();
        $categorias['id_identidad']=array();
        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            $id_identidad = $fila->id_identidad > 0 ? $fila->id_identidad : 0;
            $x[$id_sexo][$id_identidad] = $fila->val;
            $categorias['id_sexo'][$id_sexo] = $id_sexo > 0 ? cat_item::describir($id_sexo) : "Sin especificar";
            $categorias['id_identidad'][$id_identidad] =  $id_identidad > 0 ? cat_item::describir($id_identidad) : "Sin especificar";
        }


        //Respuesta
        $respuesta->entrevistada->sexo_identidad = new \stdClass();
        $respuesta->entrevistada->sexo_identidad->categorias = $categorias;
        $respuesta->entrevistada->sexo_identidad->datos = $x;


        //Sexo y orientacion sexual
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona.id_sexo, persona.id_orientacion,  count(1) as val'))
            ->groupby('id_sexo','id_orientacion')
            ->get();
        $x=array();
        $categorias= array(); //inicializarlo
        $categorias['id_sexo']=array();
        $categorias['id_orientacion']=array();
        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            $id_orientacion = $fila->id_orientacion > 0 ? $fila->id_orientacion : 0;
            $x[$id_sexo][$id_orientacion] = $fila->val;
            $categorias['id_sexo'][$id_sexo] = $id_sexo > 0 ? cat_item::describir($id_sexo) : "Sin especificar";
            $categorias['id_orientacion'][$id_orientacion] =  $id_orientacion > 0 ? cat_item::describir($id_orientacion) : "Sin especificar";
        }
        //Respuesta
        $respuesta->entrevistada->sexo_orientacion = new \stdClass();
        $respuesta->entrevistada->sexo_orientacion->categorias = $categorias;
        $respuesta->entrevistada->sexo_orientacion->datos = $x;


        //Organizacion en la que participaba
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->join('fichas.persona_organizacion','persona_entrevistada.id_persona','persona_organizacion.id_persona')
            ->selectraw(\DB::raw('persona_organizacion.nombre as var,  count(1) as val'))
            ->groupby('persona_organizacion.nombre')
            ->orderbyraw(\DB::raw('count(1) desc'))
            ->get();

        $x=array();
        $categorias= array(); //inicializarlo
        foreach($res as $fila) {
            if(!empty(trim($fila->var))) {
                $categorias[$fila->var] = $fila->var;
                $x[$fila->var]=$fila->val;
            }
        }
        //Respuesta
        $respuesta->entrevistada->organizacion = new \stdClass();
        $respuesta->entrevistada->organizacion->categorias = $categorias;
        $respuesta->entrevistada->organizacion->valores = $x;
        $respuesta->entrevistada->organizacion->descripcion = "Nombre de la organización";





        ///---------------------------------------------------------
        //Estadisticas fijas de Víctima: tablas y total, que no se actualizan por JSON

        $respuesta->victima = new \stdClass();

        //Query Base: aplicar filtros parejo
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','=','persona.id_persona')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho');

        //Resetear conteo de filtros
        $filtros->hay_filtro=0;
        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);
        //dd($filtros->hay_filtro);

        //Total de fichas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $respuesta->victima->total = $query->count();

        //dd($query->toSql());

        //Sexo y edad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        //$query->join('fichas.hecho_victima','victima.id_victima','=','hecho_victima.id_victima');

        $res = $query->selectraw(\DB::raw('persona.id_sexo, hecho_victima.edad,  count(1) as val'))
            ->groupby('id_sexo','edad')
            ->get();

        $g_edades=array();
        $g_edades[0] = "Desconocido";
        $g_edades[1] = "NNA (0-17)";
        $g_edades[2] = "Joven (18-26)";
        $g_edades[3] = "Adulto (27-59)";
        $g_edades[4] = "Persona mayor (60 en adelante)";
        //Limite superior
        $limites=array();
        $limites[0]=-1;
        $limites[1]=17;
        $limites[2]=26;
        $limites[3]=59;

        $x=array();
        $categorias= array(); //inicializarlo
        $categorias['id_sexo']=array();
        $categorias['id_edad']=$g_edades;
        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            $categorias['id_sexo'][$id_sexo] = cat_item::describir($id_sexo);
        }
        //dd($categorias);
        //Llenar todos los resultados a cero
        foreach($categorias['id_sexo'] as $id_sexo => $sexo) {
            foreach($categorias['id_edad'] as $id_edad => $edad) {
                $x[$id_sexo][$id_edad]=0;
            }
        }

        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            //Determinar el grupo de edad
            $id_edad=4; //Si no sale del ciclo
            foreach($limites as $id_categoria => $max) {
                if($fila->edad <= $max ) {
                    $id_edad = $id_categoria;
                    break;
                }
            }
            $x[$id_sexo][$id_edad] += $fila->val;

        }
        //Respuesta
        $respuesta->victima->sexo_edad = new \stdClass();
        $respuesta->victima->sexo_edad->categorias = $categorias;
        $respuesta->victima->sexo_edad->datos = $x;


        //Sexo e Identidad género
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona.id_sexo, persona.id_identidad,  count(1) as val'))
            ->groupby('id_sexo','id_identidad')
            ->get();
        $x=array();
        $categorias= array(); //inicializarlo
        $categorias['id_sexo']=array();
        $categorias['id_identidad']=array();
        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            $id_identidad = $fila->id_identidad > 0 ? $fila->id_identidad : 0;
            $x[$id_sexo][$id_identidad] = $fila->val;
            $categorias['id_sexo'][$id_sexo] = $id_sexo > 0 ? cat_item::describir($id_sexo) : "Sin especificar";
            $categorias['id_identidad'][$id_identidad] =  $id_identidad > 0 ? cat_item::describir($id_identidad) : "Sin especificar";
        }


        //Respuesta
        $respuesta->victima->sexo_identidad = new \stdClass();
        $respuesta->victima->sexo_identidad->categorias = $categorias;
        $respuesta->victima->sexo_identidad->datos = $x;


        //Sexo y orientacion sexual
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona.id_sexo, persona.id_orientacion,  count(1) as val'))
            ->groupby('id_sexo','id_orientacion')
            ->get();
        $x=array();
        $categorias= array(); //inicializarlo
        $categorias['id_sexo']=array();
        $categorias['id_orientacion']=array();
        foreach($res as $fila) {
            $id_sexo = $fila->id_sexo > 0 ? $fila->id_sexo : 0;
            $id_orientacion = $fila->id_orientacion > 0 ? $fila->id_orientacion : 0;
            $x[$id_sexo][$id_orientacion] = $fila->val;
            $categorias['id_sexo'][$id_sexo] = $id_sexo > 0 ? cat_item::describir($id_sexo) : "Sin especificar";
            $categorias['id_orientacion'][$id_orientacion] =  $id_orientacion > 0 ? cat_item::describir($id_orientacion) : "Sin especificar";
        }
        //Respuesta
        $respuesta->victima->sexo_orientacion = new \stdClass();
        $respuesta->victima->sexo_orientacion->categorias = $categorias;
        $respuesta->victima->sexo_orientacion->datos = $x;

        //Cuadro de organización en la que participaba
        $query_base = entrevista_individual::filtrar($filtros)  //Contar víctimas, no victimizaciones
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima');

        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base,$filtros);


        $query = clone $query_base;

        $res = $query->join('fichas.persona_organizacion','victima.id_persona','persona_organizacion.id_persona')
            ->selectraw(\DB::raw('persona_organizacion.nombre as var,  count(1) as val'))
            ->groupby('persona_organizacion.nombre')
            ->orderbyraw(\DB::raw('count(1) desc'))
            ->get();

        $x=array();
        $categorias= array(); //inicializarlo
        foreach($res as $fila) {
            if(!empty(trim($fila->var))) {
                $categorias[$fila->var] = $fila->var;
                $x[$fila->var]=$fila->val;
            }
        }
        //Respuesta
        $respuesta->victima->organizacion = new \stdClass();
        $respuesta->victima->organizacion->categorias = $categorias;
        $respuesta->victima->organizacion->valores = $x;
        $respuesta->victima->organizacion->descripcion = "Nombre de la organización";





        //-- Información de PRI -----------------------
        //Query Base: aplicar filtros parejo
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
            ->join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
            ;

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);



        //Total de fichas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $respuesta->pri = new \stdClass();
        $universo_hechos = $query->distinct()->pluck('hecho.id_hecho')->toArray();
        //dd($universo_hechos);
        $pri = $query->join('fichas.hecho_responsable','hecho.id_hecho','=','hecho_responsable.id_hecho')
            ->join('fichas.persona_responsable','hecho_responsable.id_persona_responsable','=','persona_responsable.id_persona_responsable')
            ->join('fichas.persona as persona_res','persona_responsable.id_persona','=','persona_res.id_persona')
            ->wherein('hecho.id_hecho',$universo_hechos)
            ->distinct()
            ->pluck('persona_responsable.id_persona_responsable');

        $respuesta->pri->total = count($pri);




//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a PRI: $formato segundos");
//        $time_start = microtime(true);



        // Información VIOLENCIA ------------
        //Query Base: aplicar filtros parejo.  Conteo de violencias.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho');;

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);






        $respuesta->violencia = new \stdClass();
        $query = clone $query_base;
        //dd($query->toSql());
        $respuesta->violencia->total = $query->selectraw(\DB::raw('distinct hecho_violencia.id_hecho_violencia'))->count();

        //dd("hola mundo");


//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a violencia, antes de tipo: $formato segundos");
//
//        $time_start = microtime(true);


        $respuesta->violencia->tipo = new \stdClass();
        $respuesta->violencia->subtipo = new \stdClass();
        $respuesta->violencia->subtipo->nivel = 0;
        $respuesta->violencia->mecanismos = new \stdClass();
        $respuesta->violencia->mecanismos->nivel = 0;
        $respuesta->violencia->terceros = new \stdClass();
        $respuesta->violencia->terceros->nivel = 0;
        $respuesta->violencia->ifc = new \stdClass();
        $respuesta->violencia->ifc->nivel = 0;
        $respuesta->violencia->tipo_otros = new \stdClass();
        $respuesta->violencia->tipo_otros->nivel = 0;

        //Para la vista inicial, que crea los div y cards.
        if($filtros->violencia_tipo <= 0) {
            $respuesta->violencia->tipo->titulo = "Tipos de violencia";
        }
        else {
            $cual = tipo_violencia::find($filtros->violencia_tipo);
            $codigo = substr($cual->codigo,0,2);
            $respuesta->violencia->tipo->titulo = "Otros tipos de violencia concurrentes";
            $respuesta->violencia->subtipo->titulo = "$cual->descripcion: Subtipos de violencia. ";
            if($codigo=="05" || $codigo=="06" || $codigo=="09" || $codigo=="10" || $codigo=="18" ) {
                $respuesta->violencia->subtipo->nivel = 1;
            }
            $respuesta->violencia->mecanismos->titulo = "$cual->descripcion: Mecanismos de violencia. ";
            if($codigo=="07" || $codigo=="08" || $codigo=="09" || $codigo=="12" || $codigo=="20"  ) {
                $respuesta->violencia->mecanismos->nivel = 1;
            }
            $respuesta->violencia->ifc->titulo = "$cual->descripcion: Modalidades. "; //IC o IFC
            if($codigo=="13" || $codigo=="14" || $codigo=="15" || $codigo=="20" || $codigo=="21" ) {  //ifc
                $respuesta->violencia->ifc->nivel = 1;
            }
            if( $codigo=="07" || $codigo=="09" || $codigo=="10" || $codigo=="11" || $codigo=="12"  ) {  //ic
                $respuesta->violencia->ifc->nivel = 1;
            }

            $respuesta->violencia->terceros->titulo = "$cual->descripcion: Violencia ejercida frente a otros. "; //Terceros
            if($codigo=="09" || $codigo=="10" || $codigo=="11" || $codigo=="12" || $codigo=="14" ) {
                $respuesta->violencia->terceros->nivel = 1;
            }

            if($codigo=="20" ) {
                $respuesta->violencia->tipo_otros->titulo = "$cual->descripcion: Recuperó sus tierras. ";
                $respuesta->violencia->tipo_otros->nivel = 1;
            }
            if($codigo=="21" ) {
                $respuesta->violencia->tipo_otros->titulo = "$cual->descripcion: Sentido del desplazamiento. ";
                $respuesta->violencia->tipo_otros->nivel = 1;
            }



        }


        //titulo si escogen departamento o municipio
        $respuesta->violencia->geo = new \stdClass();


//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a violencia, antes de lugar: $formato segundos");
//        $time_start = microtime(true);

        if($filtros->violencia_lugar > 0) {
            $cual = geo::find($filtros->violencia_lugar);
            $nivel=$cual->nivel;
            if($nivel==1) {  //Mostrar municipio
                $respuesta->violencia->geo->titulo = "$cual->descripcion: distribución por municipio. ";
                $respuesta->violencia->geo->nivel =1;
            }
            else {  //Solo este tipo, ver si tiene modalidad
                $respuesta->violencia->geo->titulo = "$cual->descripcion: distribución por vereda. ";
                $respuesta->violencia->geo->nivel =2;
            }
        }
        else {
            $respuesta->violencia->geo->titulo = "Distribución por departamento ";
            $respuesta->violencia->geo->nivel =0;
        }

//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a violencia, antes de contexto: $formato segundos");
//        $time_start = microtime(true);

        /*
         * CONTEXTO
         */
        //Query base: solo hechos, sin violencia, sin victimas
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ;
        //Aplicar filtros sin unir a hecho_violencia ni hecho_victima
        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base,$filtros);

        //Conteo genertal
        $query = clone $query_base;
        $universo = hecho_contexto::distinct()->pluck('id_hecho');  //Hechos con algo de contexto ingresado
        $query->wherein('hecho.id_hecho',$universo);
        $respuesta->violencia->total_hechos = $query->count();



        //CONTEXTO
        $contexto = [127, 128, 129, 130, 131];
        foreach($contexto as $id_cat) {
            $query = clone $query_base;
            //$query->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt', '=','hecho.id_e_ind_fvt');
            $query->join('fichas.hecho_contexto','hecho.id_hecho','=','hecho_contexto.id_hecho')
                ->join('catalogos.cat_item','hecho_contexto.id_contexto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->violencia->impactos['ctx'][$id_cat] = $res;
        }

        //IMPACTOS Y AFRONTAMIENTO
        //La unidad de conteo es por entrevista, no hay que hacer join a hechos ni nada
        $query_base = entrevista_individual::filtrar($filtros);
        self::procesar_filtros_fichas_por_entrevista($query_base,$filtros);
        //conteo global
        $query = clone $query_base;
        $universo = entrevista_impacto::distinct()->pluck('id_e_ind_fvt'); //Entrevistas con algo de impactos ingresado
        $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
        $respuesta->violencia->total_entrevistas = $query->count();



        $impactos_i = [132,133,134,135,136,137,138];

        foreach($impactos_i as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->violencia->impactos['ind'][$id_cat] = $res;
        }

        $impactos_c = [139,140,141,142,143];
        foreach($impactos_c as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->violencia->impactos['col'][$id_cat] = $res;
        }


        $afrontamiento = [144,145,146,147,148];
        foreach($afrontamiento as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->violencia->impactos['afr'][$id_cat] = $res;
        }


        //Avances: sigue utilizando entrevistas como unidad de conteo


        $avances = [160,161,162,163,164,165,166,167,168,169,171];
        foreach($avances as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->violencia->impactos['av'][$id_cat] = $res;
        }

        //Acceso a la justicia: sigue utilizando entrevistas como unidad de conteo
        $instituciones = [1,2,3];

        foreach($instituciones as $id_tipo) {
            //Institucion
            $query = clone $query_base;
            $query->join('fichas.justicia_institucion','e_ind_fvt.id_e_ind_fvt', '=','justicia_institucion.id_e_ind_fvt');
            $query->join('catalogos.cat_item','justicia_institucion.id_institucion','=','cat_item.id_item')
                ->where('justicia_institucion.id_tipo',$id_tipo);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = "Instituciones a las que accede";
            $respuesta->impactos['aj'][$id_tipo]['ins'] = $res;
            //Objetivo
            $query = clone $query_base;
            $query->join('fichas.justicia_objetivo','e_ind_fvt.id_e_ind_fvt', '=','justicia_objetivo.id_e_ind_fvt');
            $query->join('catalogos.cat_item','justicia_objetivo.id_objetivo','=','cat_item.id_item')
                ->where('justicia_objetivo.id_tipo',$id_tipo);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = "Objetivo de acceder";
            $respuesta->impactos['aj'][$id_tipo]['obj'] = $res;

            //Porqué
            $query = clone $query_base;
            $query->join('fichas.justicia_porque','e_ind_fvt.id_e_ind_fvt', '=','justicia_porque.id_e_ind_fvt');
            $query->join('catalogos.cat_item','justicia_porque.id_porque','=','cat_item.id_item')
                ->where('justicia_porque.id_tipo',$id_tipo);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = "Porqué accedió";
            $respuesta->violencia->impactos['aj'][$id_tipo]['pq'] = $res;
        }

//        $time_end = microtime(true);
//        $time = $time_end - $time_start;
//        $formato= number_format($time,2);
//        Log::debug("Tiempo a violencia: $formato segundos");
//        $time_start = microtime(true);


        ///------------------ Cuadros de EXILIO

        $respuesta->exilio = new \stdClass();
        //Query Base: aplicar filtros parejo.  Conteo de violencias.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.exilio','e_ind_fvt.id_e_ind_fvt','=','exilio.id_e_ind_fvt') //Que tenga exilio
            ->join('fichas.exilio_movimiento','exilio.id_exilio','=','exilio_movimiento.id_exilio'); //que tenga algun movimiento (salida)

        //Filtros de violencia, persistirlos en query_base.
        self::procesar_filtros_fichas_por_entrevista($query_base,$filtros); //Caso especial, el filtro por hecho, duplica las fichas de exilio
        //$debug['sql']=$query_base->toSql();
        //$debug['criterios']=$query_base->getBindings();
        //dd($debug);

        //Total de fichas de exilio
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1);  //Con registro de salida
        $respuesta->exilio->total = $query->count();
        //Impactos
        $impactos = [208,209,210,211,214,215];

        foreach($impactos as $id_cat) {
            $query = clone $query_base;
            $query->where('exilio_movimiento.id_tipo_movimiento',1); //Para que no se multipliue por el join a movimientos
            $query->join('fichas.exilio_impacto','exilio.id_exilio', '=','exilio_impacto.id_exilio');
            $query->join('catalogos.cat_item','exilio_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->exilio->impactos[$id_cat] = $res;
        }



        //Concurrencia
        $concurrencia[1]="Violencia";
        $concurrencia[2]="Violencia + Actor Armado";
        $concurrencia[3]="Violencia + Tercero Civil";
        $concurrencia[4]="Actor Armado";
        $concurrencia[5]="Tercero Civil";
        $concurrencia[6]="Actor Armado + Tercero Civil";

        //Mi universo son entrevistas con algún hecho.  En los calculos se une a responsabilidad o violencia
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
        ;
        //Aplicar filtros sin unir a hecho_violencia ni hecho_victima
        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base,$filtros);


        //VIOLENCIA
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.hecho_violencia as t1','hecho.id_hecho','t1.id_hecho')
                ->join('fichas.hecho_violencia as t2','t1.id_hecho','t2.id_hecho')
                ->join('catalogos.violencia as c1','t1.id_tipo_violencia','c1.id_geo')
                ->join('catalogos.violencia as c2','t2.id_tipo_violencia','c2.id_geo')
                ->whereRaw(\db::raw('t1.id_tipo_violencia < t2.id_tipo_violencia'))
                ->whereRaw(\db::raw('c1.descripcion < c2.descripcion'))
                ->selectRaw(\DB::raw('t1.id_tipo_violencia as id1, t2.id_tipo_violencia as id2, c1.descripcion as c1, c2.descripcion as c2'));

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $respuesta->concurrencia[1] = new \stdClass();
        $respuesta->concurrencia[1]->descripcion = $concurrencia[1];
        $respuesta->concurrencia[1]->datos =$result;
        $respuesta->concurrencia[1]->total =$total;


        //VIOLENCIA + AA
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.hecho_violencia as t1','hecho.id_hecho','t1.id_hecho')
            ->join('fichas.hecho_responsabilidad as t2','t1.id_hecho','t2.id_hecho')
            ->join('catalogos.violencia as c1','t1.id_tipo_violencia','c1.id_geo')
            ->join('catalogos.aa as c2','t2.aa_id_subtipo','c2.id_geo')
            //->whereRaw(\db::raw('c1.descripcion <= c2.descripcion'))
            ->selectRaw(\DB::raw('t1.id_tipo_violencia as id1, t2.aa_id_subtipo as id2, c1.descripcion as c1, c2.descripcion as c2'));

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $i=2;
        $respuesta->concurrencia[$i] = new \stdClass();
        $respuesta->concurrencia[$i]->descripcion = $concurrencia[$i];
        $respuesta->concurrencia[$i]->datos =$result;
        $respuesta->concurrencia[$i]->total =$total;


        //VIOLENCIA + TC
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.hecho_violencia as t1','hecho.id_hecho','t1.id_hecho')
            ->join('fichas.hecho_responsabilidad as t2','t1.id_hecho','t2.id_hecho')
            ->join('catalogos.violencia as c1','t1.id_tipo_violencia','c1.id_geo')
            ->join('catalogos.tc as c2','t2.tc_id_subtipo','c2.id_geo')
            //->whereRaw(\db::raw('t1.id_tipo_violencia < t2.id_tipo_violencia'))
            ->selectRaw(\DB::raw('t1.id_tipo_violencia as id1, t2.tc_id_subtipo as id2, c1.descripcion as c1, c2.descripcion as c2'));

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $i=3;
        $respuesta->concurrencia[$i] = new \stdClass();
        $respuesta->concurrencia[$i]->descripcion = $concurrencia[$i];
        $respuesta->concurrencia[$i]->datos =$result;
        $respuesta->concurrencia[$i]->total =$total;

        //AA
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.hecho_responsabilidad as t1','hecho.id_hecho','t1.id_hecho')
            ->join('fichas.hecho_responsabilidad as t2','t1.id_hecho','t2.id_hecho')
            ->join('catalogos.aa as c1','t1.aa_id_subtipo','c1.id_geo')
            ->join('catalogos.aa as c2','t2.aa_id_subtipo','c2.id_geo')
            ->whereRaw(\db::raw('c1.descripcion < c2.descripcion'))
            ->selectRaw(\DB::raw('t1.aa_id_subtipo as id1, t2.aa_id_subtipo as id2, c1.descripcion as c1, c2.descripcion as c2'));

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $i=4;
        $respuesta->concurrencia[$i] = new \stdClass();
        $respuesta->concurrencia[$i]->descripcion = $concurrencia[$i];
        $respuesta->concurrencia[$i]->datos =$result;
        $respuesta->concurrencia[$i]->total =$total;



        //TC
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.hecho_responsabilidad as t1','hecho.id_hecho','t1.id_hecho')
            ->join('fichas.hecho_responsabilidad as t2','t1.id_hecho','t2.id_hecho')
            ->join('catalogos.tc as c1','t1.tc_id_subtipo','c1.id_geo')
            ->join('catalogos.tc as c2','t2.tc_id_subtipo','c2.id_geo')
            ->whereRaw(\db::raw('c1.descripcion < c2.descripcion'))
            ->selectRaw(\DB::raw('t1.tc_id_subtipo as id1, t2.tc_id_subtipo as id2, c1.descripcion as c1, c2.descripcion as c2'));

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $i=5;
        $respuesta->concurrencia[$i] = new \stdClass();
        $respuesta->concurrencia[$i]->descripcion = $concurrencia[$i];
        $respuesta->concurrencia[$i]->datos =$result;
        $respuesta->concurrencia[$i]->total =$total;

        //AA  + TC
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.hecho_responsabilidad as t1','hecho.id_hecho','t1.id_hecho')
            ->join('fichas.hecho_responsabilidad as t2','t1.id_hecho','t2.id_hecho')
            ->join('catalogos.aa as c1','t1.aa_id_subtipo','c1.id_geo')
            ->join('catalogos.tc as c2','t2.tc_id_subtipo','c2.id_geo')
            //->whereRaw(\db::raw('t1.aa_id_subtipo < t2.aa_id_subtipo'))
            ->selectRaw(\DB::raw('t1.aa_id_subtipo as id1, t2.tc_id_subtipo as id2, c1.descripcion as c1, c2.descripcion as c2'));

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $i=6;
        $respuesta->concurrencia[$i] = new \stdClass();
        $respuesta->concurrencia[$i]->descripcion = $concurrencia[$i];
        $respuesta->concurrencia[$i]->datos =$result;
        $respuesta->concurrencia[$i]->total =$total;

        foreach($respuesta->concurrencia as $id_con => $con) {
            $chi = self::calcular_chi($con);
            $respuesta->concurrencia[$id_con]->chi= $chi;

        }

        //dd($respuesta->concurrencia);













        return $respuesta;
    }

    //Analisis de concurrencia por demanda
    //Utilizado para evaluar impactos y afrontamientos
    public static function json_concurrencia_impactos($filtros,$c1,$c2) {
        if(is_null($filtros)) {
            $filtros=entrevista_individual::filtros_default();
        }

        //Mi universo son entrevistas en general. No necesito hechos, violencia ni victimas
        $query_base = entrevista_individual::filtrar($filtros);

        //Aplicar filtros sin unir a hecho_violencia ni hecho_victima
        self::procesar_filtros_fichas_por_entrevista($query_base,$filtros);


        $afrontamiento = [144,145,146,147,148];
        $impactos_c = [139,140,141,142,143];
        $impactos_i = [132,133,134,135,136,137,138];


        //VIOLENCIA
        //Subqery de combinaciones
        $query = clone $query_base;
        $query->join('fichas.entrevista_impacto as t1','e_ind_fvt.id_e_ind_fvt','t1.id_e_ind_fvt')
            ->join('fichas.entrevista_impacto as t2','t1.id_e_ind_fvt','t2.id_e_ind_fvt')
            ->join('catalogos.cat_item as c1','t1.id_impacto','c1.id_item')
            ->join('catalogos.cat_item as c2','t2.id_impacto','c2.id_item')
            ->where('c1.id_cat',$c1)
            ->where('c2.id_cat',$c2)
            ->selectRaw(\DB::raw('t1.id_impacto as id1, t2.id_impacto as id2, c1.descripcion as c1, c2.descripcion as c2'));

        if($c1==$c2) {  //Permutaciones, no combinaciones, si es el mismo catalogo
            $query->whereRaw(\db::raw('c1.descripcion < c2.descripcion'));
        }

        $res= $query->toSql();
        $sub = self::getQueries($query);

        //dd($sub);

        //Query de totales, que utiliza el anterior subquery
        $sql = "select id1,id2,c1,c2,count(1) as conteo 
                        from  ($sub) as concurrencia
                        group by 1,2,3,4
                        order by 5 desc, 3, 4";
        $result  =  \DB::select($sql);
        $total=0; //Para facilitar la vista
        foreach($result as $fila) {
            $total+=$fila->conteo;
        }
        //Meter info al objeto general
        $respuesta = new \stdClass();
        $respuesta->descripcion = "Análisis de concurrencia";
        $respuesta->datos =$result;
        $respuesta->total =$total;
        $respuesta->query = $sub;
        $respuesta->c1 = cat_cat::describir($c1);
        $respuesta->c2 = cat_cat::describir($c2);
        $respuesta->id_c1 = $c1;
        $respuesta->id_c2 = $c2;

        //dd($respuesta);

        $chi = self::calcular_chi($respuesta);
        $respuesta->chi = $chi;

        return $respuesta;
    }


    //CHI CUADRADO
    public static function calcular_chi($info) {
        $n1 = [];
        $n2 = [];
        $significancia = 0.05;
        $gran_total = $info->total;

        //Determinar grados de libertad
        foreach($info->datos as $detalle ) {
            $n1[$detalle->id1] = $detalle->c1;
            $n2[$detalle->id2] = $detalle->c2;
        }

        //Calcular totales de filas y columnas
        $a_totales['c1'] = array(); //Inicializar el arreglo con valores a cero
        $a_totales['c2'] = array(); //Inicializar el arreglo con valores a cero
        $a_celdas['c1']  = array(); //Extraer de los datos, las celdas para las cuales tenemos información
        $a_celdas['c2']  = array(); //Extraer de los datos, las celdas para las cuales tenemos información
        foreach($info->datos as $id => $detalle ) {
            $a_totales['c1'][$detalle->id1]=0;
            $a_totales['c2'][$detalle->id2]=0;
            $a_celdas[$detalle->id1][$detalle->id2]=$detalle->conteo;
        }
        //Calcular totales de c/fila y columna
        foreach($info->datos as $id => $detalle ) {
            $a_totales['c1'][$detalle->id1]+=$detalle->conteo;
            $a_totales['c2'][$detalle->id2]+=$detalle->conteo;
        }
        //Completar celdas que no tuvieron combinaciones, con valores cero.
        //como resultado, tengo la matriz completa en $a_celdas
        foreach($a_totales['c1'] as $id_c1 => $c1) {
            foreach($a_totales['c2'] as $id_c2 => $c2 ) {
                if(!isset($a_celdas[$id_c1][$id_c2])) {
                    $a_celdas[$id_c1][$id_c2]=0;
                }
            }
        }

        //Tabla de valores esperados
        $a_porcentaje=array();
        foreach($a_totales['c1'] as $id_c1 => $c1) {
            foreach($a_totales['c2'] as $id_c2 => $c2 ) {
                $a_porcentaje[$id_c1][$id_c2] = $a_totales['c1'][$id_c1] * $a_totales['c2'][$id_c2] / $gran_total;
            }
        }



        //Valor de chi cuadrado
        $a_chicuadrado = array();
        $chi=0;
        foreach($a_totales['c1'] as $id_c1 => $c1) {
            foreach($a_totales['c2'] as $id_c2 => $c2 ) {
                $resta = $a_celdas[$id_c1][$id_c2] - $a_porcentaje[$id_c1][$id_c2];
                $cuadrado = pow($resta,2);
                $valor = $cuadrado/$a_porcentaje[$id_c1][$id_c2];
                $a_chicuadrado[$id_c1][$id_c2] =  $valor;
                $chi +=$valor;

            }
        }


        $grados = (count($n1)-1)*(count($n2)-1);
        if($grados > 0) {
            $tabla_chi = stats::AChiSq($significancia,$grados);
        }
        else {
            $tabla_chi=0;
        }

        //concluir
        $conclusion="Desconocido";
        if($chi > $tabla_chi) {
            $conclusion = "Existe dependencia entre variables ya que $chi es mayor que $tabla_chi";
            $conclusion_color = "<span class='text-success'>$conclusion</span>";
        }
        else {
            $conclusion = "No existe dependiencia entre variables ya que  $chi es menor que $tabla_chi";
            $conclusion_color = "<span class='text-danger'>$conclusion</span>";
        }







        $res = new \stdClass();
        $res->n1=$n1;
        $res->n2=$n2;
        $res->grados_libertad = (count($n1)-1)*(count($n2)-1);
        $res->significancia = $significancia;
        $res->porcentajes = $a_porcentaje;
        $res->celdas = $a_celdas;
        $res->totales = $a_totales;
        $res->chi_cuadrado = $a_chicuadrado;
        $res->chi = $chi;
        $res->tabla_chi = $tabla_chi;
        $res->conclusion = $conclusion;
        $res->conclusion_color = $conclusion_color;

        return $res;



    }

    //Estadisticas de procesamiento, versión ajax
    public static function json_procesamiento($filtros=null) {

        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Información del procesamiento
        $respuesta->procesamiento = new \stdClass();
        $respuesta->procesamiento->victimas = new \stdClass();  // Vitimas
        $respuesta->procesamiento->pri = new \stdClass(); //Presunto responsable individual
        $respuesta->procesamiento->hechos = new \stdClass(); //hechos y violaciones
        $respuesta->procesamiento->exilio = new \stdClass(); //Exilio
        $respuesta->procesamiento->ci = new \stdClass(); //Consentimiento informado
        //Consentimiento informado
        $respuesta->consentimiento = new \stdClass();
        $respuesta->consentimiento->conceder_entrevista = new \stdClass();
        $respuesta->consentimiento->grabar_audio = new \stdClass();
        $respuesta->consentimiento->elaborar_informe = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_publicar = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_analizar = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_analizar_sensible = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_utilizar = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_utilizar_sensible = new \stdClass();

        //-- Realizar los calculos respectivos --//


        //Query Base: aplicar filtros parejo
        $query_base_victimas = entrevista_individual::filtrar($filtros)
                ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
                ->join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho')
                ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
                ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima')
                ;
        $query_base_entrevistas = entrevista_individual::filtrar($filtros);
        //Aplicar filtros de fecha de los hechos, lugar de los hechos, etc.
        self::procesar_filtros_fichas_por_hechos($query_base_victimas,$filtros);
        self::procesar_filtros_fichas_por_entrevista($query_base_entrevistas,$filtros);


        //Usar los resultados del query_base para wherein
        $query = clone  $query_base_entrevistas;
        //dd($query->toSql());
        $universo_entrevistas = $query->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
        //dd($universo_entrevistas);



        //-------- PROCESAMIENTO ---------//
        //VICTIMAS
        $query = clone $query_base_victimas;
        //dd($query->toSql());

        $victimas_si  = $query->count();

        $query = clone $query_base_entrevistas;
        $victimas_no = $query->join('fichas.victima','e_ind_fvt.id_e_ind_fvt','=','victima.id_e_ind_fvt')
            ->leftjoin('fichas.hecho_victima','victima.id_victima','=','hecho_victima.id_victima')
            ->leftjoin('fichas.hecho','hecho_victima.id_hecho','=','hecho.id_hecho')
            ->leftjoin('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho')
            ->wherenull('hecho_victima.id_hecho')
            ->count();

        $datos=array();
        $datos[1]= $victimas_si;
        $datos[2]= $victimas_no;
        $categorias=array();
        $categorias[1]= "Asignadas";
        $categorias[2]= "Sin asignar";
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $datos;
        $g->nombre_serie[]="Fichas de víctima";
        $g->descarga="procesamiento_victimas";
        //Meterlo en la respuesta
        $respuesta->procesamiento->victimas = new \stdClass();
        $respuesta->procesamiento->victimas->datos = $datos;
        $respuesta->procesamiento->victimas->categorias = $categorias;
        $respuesta->procesamiento->victimas->grafico = graficador::g_pie($g);

        //PRESUNTO RESPONSABLE INDIVIDUAL
        $query = clone $query_base_entrevistas;
        //$universo_hechos = $query->distinct()->pluck('hecho.id_hecho');
        //dd($universo_hechos);
        $si  = $query->join('fichas.persona_responsable','e_ind_fvt.id_e_ind_fvt','=','persona_responsable.id_e_ind_fvt')
            ->join('fichas.hecho_responsable','persona_responsable.id_persona_responsable','=','hecho_responsable.id_persona_responsable')
            ->join('fichas.hecho','hecho_responsable.id_hecho','=','hecho.id_hecho')
            //->wherein('hecho.id_hecho',$universo_hechos)
            ->count();

        $query = clone $query_base_entrevistas;
        $no = $query->join('fichas.persona_responsable','e_ind_fvt.id_e_ind_fvt','=','persona_responsable.id_e_ind_fvt')
            ->leftjoin('fichas.hecho_responsable','persona_responsable.id_persona_responsable','=','hecho_responsable.id_persona_responsable')
            //->leftjoin('fichas.hecho','hecho_responsable.id_hecho','=','hecho.id_hecho')
            //->wherein('hecho.id_hecho',$universo_hechos)  //Nuca se aplica el filtro, este valor siempre es el mismo, ya que no están asignadas a un hecho al cual filtrar
            ->whereNull('hecho_responsable.id_hecho_responsable')
            ->count();
        //dd($no);

        $datos=array();
        $datos[1]= $si;
        $datos[2]= $no;
        $categorias=array();
        $categorias[1]= "Asignados";
        $categorias[2]= "Sin asignar";
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $datos;
        $g->nombre_serie[]="Fichas de Presunto Responsable Individual";
        $g->descarga="procesamiento_pri";
        //Meterlo en la respuesta
        $respuesta->procesamiento->pri = new \stdClass();
        $respuesta->procesamiento->pri->datos = $datos;
        $respuesta->procesamiento->pri->categorias = $categorias;
        $respuesta->procesamiento->pri->grafico = graficador::g_pie($g);

        //Hechos, violencia, victimas
        $query = clone $query_base_victimas;
        $tmp = $query->distinct()->pluck('hecho.id_hecho');
        $hechos = count($tmp);

        $query = clone $query_base_victimas;
        $tmp = $query->distinct()->pluck('hecho_violencia.id_hecho_violencia');
        $violencia  =count($tmp);

        $query = clone $query_base_entrevistas;
        $victimas  = $query->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                            ->sum('hecho.cantidad_victimas');

        $query = clone $query_base_victimas;
        $tmp = $query->distinct()->pluck('hecho_victima.id_hecho_victima');
        $victimas_conocidas  = $query->count();

        $datos=array();
        $datos[]= $hechos;
        $datos[]= $violencia;
        $datos[]= $victimas_conocidas;
        $datos[]= $victimas;

        $categorias=array();
        $categorias[]= "Cantidad de hechos";
        $categorias[]= "Cantidad de violaciones";
        $categorias[]= "Cantidad de víctimas de datos conocidos";
        $categorias[]= "Cantidad de víctimas total";

        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $datos;
        $g->nombre_serie[]="Conteo";
        $g->descarga="procesamiento_h";
        $g->yAxis="Conteos";
        //Meterlo en la respuesta
        $respuesta->procesamiento->hechos = new \stdClass();
        $respuesta->procesamiento->hechos->datos = $datos;
        $respuesta->procesamiento->hechos->categorias = $categorias;
        $respuesta->procesamiento->hechos->grafico = graficador::g_barra($g);

        //EXILIO
        $query = clone $query_base_entrevistas;
        $fichas_exilio  = $query->join('fichas.exilio','e_ind_fvt.id_e_ind_fvt','=','exilio.id_e_ind_fvt')
                                ->join('fichas.exilio_movimiento','exilio.id_exilio','exilio_movimiento.id_exilio')
                                ->where('id_tipo_movimiento',1)
            ->count();
        $query = clone $query_base_victimas;

        $con_exilio = $query->join('catalogos.violencia','hecho_violencia.id_subtipo_violencia','violencia.id_geo')
            ->where('violencia.codigo','2201')
            ->count();

        $datos=array();
        $datos[1]= $con_exilio;
        $datos[2]= $fichas_exilio;
        $categorias=array();
        $categorias[1]= "Hechos con exilio";
        $categorias[2]= "Fichas de exilio";
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $datos;
        $g->nombre_serie[]="Exilio";
        $g->descarga="procesamiento_e";
        //Meterlo en la respuesta
        $respuesta->procesamiento->exilio = new \stdClass();
        $respuesta->procesamiento->exilio->datos = $datos;
        $respuesta->procesamiento->exilio->categorias = $categorias;
        $respuesta->procesamiento->exilio->grafico = graficador::g_columna($g);

        //Consentimiento informado
        $query = clone $query_base_entrevistas;
        $universo_consentimiento  = $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt','=','entrevista.id_e_ind_fvt')
                        ->distinct()
                        ->pluck('e_ind_fvt.id_e_ind_fvt');
        $si=count($universo_consentimiento);




        $query = clone $query_base_entrevistas;
        $no  =  $query->leftjoin('fichas.entrevista','e_ind_fvt.id_e_ind_fvt','=','entrevista.id_e_ind_fvt')
                        ->wherenull('entrevista.id_e_ind_fvt')
                        ->distinct()
                        ->select('e_ind_fvt.id_e_ind_fvt')
                        ->count();

        //dd($no->toSql());

        //dd($no);

        $datos=array();
        $datos[1]= $si;
        $datos[2]= $no;
        $categorias=array();
        $categorias[1]= "Diligenciado";
        $categorias[2]= "Sin diligenciar";
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $datos;
        $g->nombre_serie[]="Información del consentimiento informado";
        $g->descarga="procesamiento_ci";
        //Meterlo en la respuesta
        $respuesta->procesamiento->ci = new \stdClass();
        $respuesta->procesamiento->ci->categorias = $categorias;
        $respuesta->procesamiento->ci->datos = $datos;
        $respuesta->procesamiento->ci->grafico = graficador::g_pie($g);


        // Consentimiento informado
        //Concede entrevista
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
                ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_consentimiento);
        $res = self::query_simple($query,'entrevista.conceder_entrevista',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_conceder";
        $respuesta->consentimiento->conceder_entrevista = new \stdClass();
        $respuesta->consentimiento->conceder_entrevista->categorias =  $res->categorias;
        $respuesta->consentimiento->conceder_entrevista->datos = $res->valores;
        $respuesta->consentimiento->conceder_entrevista->grafico = graficador::g_pie($g);
        //Grabar entrevista
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_consentimiento);
        $res = self::query_simple($query,'entrevista.grabar_audio',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_grabar";
        $respuesta->consentimiento->grabar_audio = new \stdClass();
        $respuesta->consentimiento->grabar_audio->categorias =  $res->categorias;
        $respuesta->consentimiento->grabar_audio->datos = $res->valores;
        $respuesta->consentimiento->grabar_audio->grafico = graficador::g_pie($g);
        //Elaborar informe
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_entrevistas);
        $res = self::query_simple($query,'entrevista.elaborar_informe',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_elaborar_informe";
        $respuesta->consentimiento->elaborar_informe = new \stdClass();
        $respuesta->consentimiento->elaborar_informe->categorias =  $res->categorias;
        $respuesta->consentimiento->elaborar_informe->datos = $res->valores;
        $respuesta->consentimiento->elaborar_informe->grafico = graficador::g_pie($g);
        //Publicar nombre
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_entrevistas);
        $res = self::query_simple($query,'entrevista.tratamiento_datos_publicar',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_tratamiento_datos_publicar";
        $respuesta->consentimiento->tratamiento_datos_publicar = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_publicar->categorias =  $res->categorias;
        $respuesta->consentimiento->tratamiento_datos_publicar->datos = $res->valores;
        $respuesta->consentimiento->tratamiento_datos_publicar->grafico = graficador::g_pie($g);
        //analizar: datos personales
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_entrevistas);
        $res = self::query_simple($query,'entrevista.tratamiento_datos_analizar',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_tratamiento_datos_analizar";
        $respuesta->consentimiento->tratamiento_datos_analizar = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_analizar->categorias =  $res->categorias;
        $respuesta->consentimiento->tratamiento_datos_analizar->datos = $res->valores;
        $respuesta->consentimiento->tratamiento_datos_analizar->grafico = graficador::g_pie($g);
        //analizar: datos sensibles
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_entrevistas);
        $res = self::query_simple($query,'entrevista.tratamiento_datos_analizar_sensible',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_tratamiento_datos_analizar_sensible";
        $respuesta->consentimiento->tratamiento_datos_analizar_sensible = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_analizar_sensible->categorias =  $res->categorias;
        $respuesta->consentimiento->tratamiento_datos_analizar_sensible->datos = $res->valores;
        $respuesta->consentimiento->tratamiento_datos_analizar_sensible->grafico = graficador::g_pie($g);
        //utilizar: datos personales
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_entrevistas);
        $res = self::query_simple($query,'entrevista.tratamiento_datos_utilizar',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_tratamiento_datos_utilizar";
        $respuesta->consentimiento->tratamiento_datos_utilizar = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_utilizar->categorias =  $res->categorias;
        $respuesta->consentimiento->tratamiento_datos_utilizar->datos = $res->valores;
        $respuesta->consentimiento->tratamiento_datos_utilizar->grafico = graficador::g_pie($g);
        //utilizar: datos sensibles
        $query = clone $query_base_entrevistas;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.entrevista','e_ind_fvt.id_e_ind_fvt', '=','entrevista.id_e_ind_fvt')
            ->wherein('e_ind_fvt.id_e_ind_fvt',$universo_entrevistas);
        $res = self::query_simple($query,'entrevista.tratamiento_datos_utilizar_sensible',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Entrevistas";
        $g->descarga="ci_tratamiento_datos_utilizar_sensible";
        $respuesta->consentimiento->tratamiento_datos_utilizar_sensible = new \stdClass();
        $respuesta->consentimiento->tratamiento_datos_utilizar_sensible->categorias =  $res->categorias;
        $respuesta->consentimiento->tratamiento_datos_utilizar_sensible->datos = $res->valores;
        $respuesta->consentimiento->tratamiento_datos_utilizar_sensible->grafico = graficador::g_pie($g);


        return $respuesta;
    }




    //Estadísticas de persona entrevistada, versión ajax
    public static function json_entrevistada($filtros=null)
    {


        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad e fichas de víctima
        $respuesta->total = 0;
        //Información del procesamiento
        $respuesta->es_victima = new \stdClass(); // es victima?
        $respuesta->es_victima->categorias = array();
        $respuesta->es_victima->datos = array();
        $respuesta->es_victima->grafico = null;
        $respuesta->es_testigo = new \stdClass(); // es testigo?
        $respuesta->es_testigo->categorias = array();
        $respuesta->es_testigo->datos = array();
        $respuesta->es_testigo->grafico = null;
        $respuesta->lugar_n = new \stdClass(); // Lugar de nacimiento
        $respuesta->lugar_n->categorias = array();
        $respuesta->lugar_n->datos = array();
        $respuesta->lugar_n->grafico = null;
        $respuesta->lugar_r = new \stdClass(); // Lugar de residencia
        $respuesta->lugar_r->categorias = array();
        $respuesta->lugar_r->datos = array();
        $respuesta->lugar_r->grafico = null;
        // SExo, orientacion e identidad
        $respuesta->sexo = new \stdClass(); // SExo
        $respuesta->sexo->categorias = array();
        $respuesta->sexo->datos = array();
        $respuesta->sexo->grafico = null;
        $respuesta->orientacion = new \stdClass(); // Orientacion sexual
        $respuesta->orientacion->categorias = array();
        $respuesta->orientacion->datos = array();
        $respuesta->orientacion->grafico = null;
        $respuesta->identidad_g = new \stdClass(); // Identidad Género
        $respuesta->identidad_g->categorias = array();
        $respuesta->identidad_g->datos = array();
        $respuesta->identidad_g->grafico = null;
        $respuesta->sexo_identidad = new \stdClass(); // Sexo - Identidad Género
        $respuesta->sexo_identidad->categorias = array();
        $respuesta->sexo_identidad->datos = array();
        $respuesta->sexo_orientacion = new \stdClass(); // Sexo - Orientacion sexual
        $respuesta->sexo_orientacion->categorias = array();
        $respuesta->sexo_orientacion->datos = array();
        // Pertencencia etnica
        $respuesta->etnia = new \stdClass(); // Pertenencia étnica
        $respuesta->etnia->categorias = array();
        $respuesta->etnia->datos = array();
        $respuesta->etnia->grafico = null;
        $respuesta->indigena = new \stdClass(); // Pertenencia indígena
        $respuesta->indigena->categorias = array();
        $respuesta->indigena->datos = array();
        $respuesta->indigena->grafico = null;
        //
        $respuesta->estado_civil = new \stdClass(); // Estado civil
        $respuesta->estado_civil->categorias = array();
        $respuesta->estado_civil->datos = array();
        $respuesta->estado_civil->grafico = null;
        $respuesta->discapacidad = new \stdClass(); // Discapacidad
        $respuesta->discapacidad->categorias = array();
        $respuesta->discapacidad->datos = array();
        $respuesta->discapacidad->grafico = null;
        $respuesta->educacion = new \stdClass(); // Educacion formal
        $respuesta->educacion->categorias = array();
        $respuesta->educacion->datos = array();
        $respuesta->educacion->grafico = null;
        $respuesta->cargo = new \stdClass(); // Cargo publico
        $respuesta->cargo->categorias = array();
        $respuesta->cargo->datos = array();
        $respuesta->cargo->grafico = null;
        $respuesta->autoridad = new \stdClass(); // autoridad etnica
        $respuesta->autoridad->categorias = array();
        $respuesta->autoridad->datos = array();
        $respuesta->autoridad->grafico = null;
        $respuesta->f_publica = new \stdClass(); // fuerza publica
        $respuesta->f_publica->categorias = array();
        $respuesta->f_publica->datos = array();
        $respuesta->f_publica->grafico = null;
        $respuesta->actor = new \stdClass(); // actor armado ilegal
        $respuesta->actor->categorias = array();
        $respuesta->actor->datos = array();
        $respuesta->actor->grafico = null;
        $respuesta->organizacion = new \stdClass(); // Participa en organizacion
        $respuesta->organizacion->categorias = array();
        $respuesta->organizacion->datos = array();
        $respuesta->organizacion->grafico = null;
        $respuesta->organizacion_tipo = new \stdClass(); // Tipo de organizacion
        $respuesta->organizacion_tipo->categorias = array();
        $respuesta->organizacion_tipo->datos = array();
        $respuesta->organizacion_tipo->grafico = null;
        $respuesta->nacionalidad = new \stdClass(); // Tipo de organizacion
        $respuesta->nacionalidad->categorias = array();
        $respuesta->nacionalidad->datos = array();
        $respuesta->nacionalidad->grafico = null;








        //Query Base: aplicar filtros parejo
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','=','persona_entrevistada.id_e_ind_fvt')
            ->join('fichas.persona','persona_entrevistada.id_persona','=','persona.id_persona');

        //self::procesar_filtros_fichas_por_hechos($query_base,$filtros);
        self::procesar_filtros_persona_entrevistada($query_base,$filtros);







        //Es victima:
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona_entrevistada.es_victima as var, count(1) as val'))
            ->groupby('es_victima')
            ->get();
        //dd($res);
        $x=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
        }

        $categorias=criterio_fijo::listado_items(2);
        //Que existan valores para todas las categorias
        foreach($categorias as $id=>$val) {
            $x[$id] = isset($x[$id]) ? $x[$id] : 0;
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Respuestas";
        $g->descarga="entrevistada_es_victima";
        //Respuesta
        $respuesta->es_victima->categorias = $categorias;
        $respuesta->es_victima->datos = $x;
        $respuesta->es_victima->grafico = graficador::g_pie($g);
        //dd($respuesta->es_victima);

        //Es testigo:
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona_entrevistada.es_testigo as var, count(1) as val'))
            ->groupby('es_testigo')
            ->where('es_victima',2)
            ->get();
        $x=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
        }

        $categorias=criterio_fijo::listado_items(2);
        //Que existan valores para todas las categorias
        foreach($categorias as $id=>$val) {
            $x[$id] = isset($x[$id]) ? $x[$id] : 0;
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Respuestas";
        $g->descarga="entrevistada_es_testigo";
        //Respuesta
        $respuesta->es_testigo->categorias = $categorias;
        $respuesta->es_testigo->datos = $x;
        $respuesta->es_testigo->grafico = graficador::g_pie($g);

        //Edad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->selectraw(\DB::raw('persona_entrevistada.edad as var, count(1) as val'))
            ->groupby('edad')
            ->get();
        $categorias=array();
        $categorias[0] = "Desconocido";
        $categorias[1] = "NNA (0-17)";
        $categorias[2] = "Joven (18-26)";
        $categorias[3] = "Adulto (27-59)";
        $categorias[4] = "Persona mayor (60 en adelante)";
        //Limite superior
        $limites[0]=-1;
        $limites[1]=17;
        $limites[2]=26;
        $limites[3]=59;
        $limites[4]=100;
        //inicializar arreglo con valores
        $x=array();
        foreach($categorias as $id=>$txt) {
            $x[$id]=0;
        }


        foreach($res as $fila) {
            foreach($limites as $id_categoria => $max) {
                $cual_categoria=4;
                if($fila->var <= $max ) {
                    $cual_categoria = $id_categoria;
                    break;
                }
            }
            $x[$cual_categoria]+= $fila->val;
        }

        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_edad";
        //Respuesta
        $respuesta->edad = new \stdClass();
        $respuesta->edad->categorias = $categorias;
        $respuesta->edad->datos = $x;
        $respuesta->edad->grafico = graficador::g_columna($g);




        //-----Lugar de nacimiento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->orderby('id_persona')->pluck('persona.id_persona')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';
        $sql = "select n1.id_geo as id_geo_n1, 3 as nivel,  count(1) as conteo
                        from fichas.persona as p
                            join catalogos.geo as n3 on p.id_lugar_nacimiento=n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where p.id_persona in ($universo)
                        group by 1,2

                    union 

                select n1.id_geo as id_geo_n1, 2 as nivel, count(1) as conteo
                        from fichas.persona as p
                            join catalogos.geo as n2 on p.id_lugar_nacimiento=n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where p.id_persona in ($universo)
                        group by 1,2
                    union 
                select n1.id_geo as id_geo_n1, 1 as nivel,  count(1) as conteo
                        from fichas.persona as p
                            join catalogos.geo as n1 on p.id_lugar_nacimiento=n1.id_geo and n1.nivel =1                                                    
                        where p.id_persona in ($universo)
                        group by 1,2
                    union
                select -1 as id_geo_n1, 0 as nivel,  count(1) as conteo
                        from fichas.persona as p
                            left join catalogos.geo as n2 on p.id_lugar_nacimiento=n2.id_geo                   
                            
                        where p.id_persona in ($universo) and n2.id_geo is null
                        group by 1,2
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_l_nacimiento";
        //Respuesta
        $respuesta->lugar_n->categorias = $categorias;
        $respuesta->lugar_n->datos = $x;
        $respuesta->lugar_n->grafico = graficador::g_barra($g);


        //-----Lugar de residencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = $query->orderby('id_persona')->pluck('persona.id_persona')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';
        $sql = "select n1.id_geo as id_geo_n1, 3 as nivel,  count(1) as conteo
                        from fichas.persona as p
                            join catalogos.geo as n3 on p.id_lugar_residencia=n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where p.id_persona in ($universo)
                        group by 1,2

                    union 

                select n1.id_geo as id_geo_n1, 2 as nivel, count(1) as conteo
                        from fichas.persona as p
                            join catalogos.geo as n2 on p.id_lugar_residencia=n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where p.id_persona in ($universo)
                        group by 1,2
                    union 
                select n1.id_geo as id_geo_n1, 1 as nivel,  count(1) as conteo
                        from fichas.persona as p
                            join catalogos.geo as n1 on p.id_lugar_residencia=n1.id_geo and n1.nivel =1                                                    
                        where p.id_persona in ($universo)
                        group by 1,2
                    union
                select -1 as id_geo_n1, 0 as nivel,  count(1) as conteo
                        from fichas.persona as p
                            left join catalogos.geo as n2 on p.id_lugar_residencia=n2.id_geo                   
                            
                        where p.id_persona in ($universo) and n2.id_geo is null
                        group by 1,2
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_l_residencia";
        //Respuesta
        $respuesta->lugar_r->categorias = $categorias;
        $respuesta->lugar_r->datos = $x;
        $respuesta->lugar_r->grafico = graficador::g_barra($g);


        //Sexo
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_sexo', null, $filtros->debug);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_sexo";
        //Respuesta
        $respuesta->sexo->categorias = $res->categorias;
        $respuesta->sexo->datos = $res->valores;
        $respuesta->sexo->grafico = graficador::g_pie($g);

        //Orientacion sexual
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_orientacion');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_orientacion_sexual";
        //Respuesta
        $respuesta->orientacion->categorias = $res->categorias;
        $respuesta->orientacion->datos = $res->valores;
        $respuesta->orientacion->grafico = graficador::g_pie($g);

        //Identidad género
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_identidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_identidad_generao";
        //Respuesta
        $respuesta->identidad_g->categorias = $res->categorias;
        $respuesta->identidad_g->datos = $res->valores;
        $respuesta->identidad_g->grafico = graficador::g_pie($g);





        //Pertenencia etnica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_etnia');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_etnia";
        //Respuesta
        $respuesta->etnia->categorias = $res->categorias;
        $respuesta->etnia->datos = $res->valores;
        $respuesta->etnia->grafico = graficador::g_columna($g);

        //Pertenencia indigena
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_etnia_indigena');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_indigena";
        //Respuesta
        $respuesta->indigena->categorias =  $res->categorias;
        $respuesta->indigena->datos = $res->valores;
        $respuesta->indigena->grafico = graficador::g_barra($g);

        //Estado ciivl
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_estado_civil');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_estado_civil";
        //Respuesta
        $respuesta->estado_civil->categorias =  $res->categorias;
        $respuesta->estado_civil->datos = $res->valores;
        $respuesta->estado_civil->grafico = graficador::g_pie($g);

        //Discapacidadd
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_discapacidad','persona.id_persona','=','persona_discapacidad.id_persona');
        $res = self::query_simple($query,'persona_discapacidad.id_discapacidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_discapacidad";
        //Respuesta
        $respuesta->discapacidad->categorias =  $res->categorias;
        $respuesta->discapacidad->datos = $res->valores;
        $respuesta->discapacidad->grafico = graficador::g_columna($g);

        //Educacion
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_edu_formal');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_edu_formal";
        //Respuesta
        $respuesta->educacion->categorias =  $res->categorias;
        $respuesta->educacion->datos = $res->valores;
        $respuesta->educacion->grafico = graficador::g_columna($g);

        //Cargo publico
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.cargo_publico',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_cargo_publico";
        //Respuesta
        $respuesta->cargo->categorias =  $res->categorias;
        $respuesta->cargo->datos = $res->valores;
        $respuesta->cargo->grafico = graficador::g_columna($g);

        //Autoridad etnica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_aut_etnico_ter','persona.id_persona', '=','persona_aut_etnico_ter.id_persona');
        $res = self::query_simple($query,'persona_aut_etnico_ter.id_aut_etnico_ter');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_autoridad_e_t";
        //Respuesta
        $respuesta->autoridad->categorias =  $res->categorias;
        $respuesta->autoridad->datos = $res->valores;
        $respuesta->autoridad->grafico = graficador::g_barra($g);

        //Miembro de la fuerza publica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_fuerza_publica');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos

        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_fuerza_publica";


        //Respuesta
        $respuesta->f_publica->categorias =  $res->categorias;
        $respuesta->f_publica->datos = $res->valores;
        $respuesta->f_publica->grafico = graficador::g_pie($g);

        //Miembro Actor Armado Ilegal
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_actor_armado');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_aai";
        //Respuesta
        $respuesta->actor->categorias =  $res->categorias;
        $respuesta->actor->datos = $res->valores;
        $respuesta->actor->grafico = graficador::g_pie($g);

        //Participa en organización
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.organizacion_colectivo',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_organizacion_participa";
        //Respuesta
        $respuesta->organizacion->categorias =  $res->categorias;
        $respuesta->organizacion->datos = $res->valores;
        $respuesta->organizacion->grafico = graficador::g_pie($g);

        //Tipo de organizacion en la que participa
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_organizacion','persona.id_persona', '=','persona_organizacion.id_persona');
        $res = self::query_simple($query,'persona_organizacion.id_tipo_organizacion');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_organizacion_tipo";
        //Respuesta
        $respuesta->organizacion_tipo->categorias = $res->categorias;
        $respuesta->organizacion_tipo->datos = $res->valores;
        $respuesta->organizacion_tipo->grafico = graficador::g_barra($g);


        //Nacionalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_nacionalidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="entrevistada_nacionalidad";
        //Respuesta
        $respuesta->nacionalidad->categorias =  $res->categorias;
        $respuesta->nacionalidad->datos = $res->valores;
        $respuesta->nacionalidad->grafico = graficador::g_barra($g);

        //dd($respuesta->sexo_orientacion);

        return $respuesta;

    }



    //Estadísticas de víctima, versión ajax
    public static function json_victima($filtros=null)
    {

        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad e fichas de víctima
        $respuesta->total = 0;
        //Información del procesamiento
        $respuesta->lugar_n = new \stdClass(); // Lugar de nacimiento
        $respuesta->lugar_n->categorias = array();
        $respuesta->lugar_n->datos = array();
        $respuesta->lugar_n->grafico = null;
        $respuesta->lugar_r = new \stdClass(); // Lugar de residencia
        $respuesta->lugar_r->categorias = array();
        $respuesta->lugar_r->datos = array();
        $respuesta->lugar_r->grafico = null;
        // SExo, orientacion e identidad
        $respuesta->sexo = new \stdClass(); // SExo
        $respuesta->sexo->categorias = array();
        $respuesta->sexo->datos = array();
        $respuesta->sexo->grafico = null;
        $respuesta->orientacion = new \stdClass(); // Orientacion sexual
        $respuesta->orientacion->categorias = array();
        $respuesta->orientacion->datos = array();
        $respuesta->orientacion->grafico = null;
        $respuesta->identidad_g = new \stdClass(); // Identidad Género
        $respuesta->identidad_g->categorias = array();
        $respuesta->identidad_g->datos = array();
        $respuesta->identidad_g->grafico = null;
        $respuesta->sexo_identidad = new \stdClass(); // Sexo - Identidad Género
        $respuesta->sexo_identidad->categorias = array();
        $respuesta->sexo_identidad->datos = array();
        $respuesta->sexo_orientacion = new \stdClass(); // Sexo - Orientacion sexual
        $respuesta->sexo_orientacion->categorias = array();
        $respuesta->sexo_orientacion->datos = array();
        // Pertencencia etnica
        $respuesta->etnia = new \stdClass(); // Pertenencia étnica
        $respuesta->etnia->categorias = array();
        $respuesta->etnia->datos = array();
        $respuesta->etnia->grafico = null;
        $respuesta->indigena = new \stdClass(); // Pertenencia indígena
        $respuesta->indigena->categorias = array();
        $respuesta->indigena->datos = array();
        $respuesta->indigena->grafico = null;
        //
        $respuesta->estado_civil = new \stdClass(); // Estado civil
        $respuesta->estado_civil->categorias = array();
        $respuesta->estado_civil->datos = array();
        $respuesta->estado_civil->grafico = null;
        $respuesta->discapacidad = new \stdClass(); // Discapacidad
        $respuesta->discapacidad->categorias = array();
        $respuesta->discapacidad->datos = array();
        $respuesta->discapacidad->grafico = null;
        $respuesta->educacion = new \stdClass(); // Educacion formal
        $respuesta->educacion->categorias = array();
        $respuesta->educacion->datos = array();
        $respuesta->educacion->grafico = null;
        $respuesta->cargo = new \stdClass(); // Cargo publico
        $respuesta->cargo->categorias = array();
        $respuesta->cargo->datos = array();
        $respuesta->cargo->grafico = null;
        $respuesta->autoridad = new \stdClass(); // autoridad etnica
        $respuesta->autoridad->categorias = array();
        $respuesta->autoridad->datos = array();
        $respuesta->autoridad->grafico = null;
        $respuesta->f_publica = new \stdClass(); // fuerza publica
        $respuesta->f_publica->categorias = array();
        $respuesta->f_publica->datos = array();
        $respuesta->f_publica->grafico = null;
        $respuesta->actor = new \stdClass(); // actor armado ilegal
        $respuesta->actor->categorias = array();
        $respuesta->actor->datos = array();
        $respuesta->actor->grafico = null;
        $respuesta->organizacion = new \stdClass(); // Participa en organizacion
        $respuesta->organizacion->categorias = array();
        $respuesta->organizacion->datos = array();
        $respuesta->organizacion->grafico = null;
        $respuesta->organizacion_tipo = new \stdClass(); // Tipo de organizacion
        $respuesta->organizacion_tipo->categorias = array();
        $respuesta->organizacion_tipo->datos = array();
        $respuesta->organizacion_tipo->grafico = null;
        $respuesta->nacionalidad = new \stdClass(); // Tipo de organizacion
        $respuesta->nacionalidad->categorias = array();
        $respuesta->nacionalidad->datos = array();
        $respuesta->nacionalidad->grafico = null;





        //Query Base: aplicar filtros parejo
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','=','persona.id_persona')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho');


        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);

        //Total de fichas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $respuesta->total = $query->count();



        //-----Lugar de nacimiento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes

        //Determinar el departamento de todas las victimas del query
        $sql_depto = "(
                    select n1.id_geo as id_depto, id_persona
                        from fichas.persona as p
                            join catalogos.geo as n3 on p.id_lugar_nacimiento=n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                                        

                    union 

                    select n1.id_geo as id_depto, id_persona
                            from fichas.persona as p
                                join catalogos.geo as n2 on p.id_lugar_nacimiento=n2.id_geo and n2.nivel =2                        
                                join catalogos.geo as n1 on n2.id_padre = n1.id_geo                    
                            
                        union 
                    select n1.id_geo as id_depto, id_persona
                            from fichas.persona as p
                                join catalogos.geo as n1 on p.id_lugar_nacimiento=n1.id_geo and n1.nivel =1
                                )                                                                        
                    depto
                    "
                    ;

        //$subquery = \DB::raw($sql_depto);

        $sql_general =  $query->leftjoin(\DB::raw($sql_depto), function ($join) {
                                        $join->on('persona.id_persona', '=', 'depto.id_persona');
                                    })
                            ->selectraw(\DB::raw(" hecho_victima.id_hecho_victima, depto.id_depto "));
        $query_general = entrevista_individual::getQueries($sql_general);





        $res  = \DB::table(\DB::raw("($query_general) as general" ))
                        ->selectraw(\DB::raw('general.id_depto as var, count(1) as val'))
                        ->groupBy("general.id_depto")
                        ->orderby('val','desc')
                        ->get();

        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_l_nacimiento";
        //Respuesta
        $respuesta->lugar_n->categorias = $categorias;
        $respuesta->lugar_n->datos = $x;
        $respuesta->lugar_n->grafico = graficador::g_barra($g);


        //-----Lugar de residencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes

        //Determinar el departamento de todas las victimas del query
        $sql_depto = "(
                    select n1.id_geo as id_depto, id_persona
                        from fichas.persona as p
                            join catalogos.geo as n3 on p.id_lugar_residencia=n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                                        

                    union 

                    select n1.id_geo as id_depto, id_persona
                            from fichas.persona as p
                                join catalogos.geo as n2 on p.id_lugar_residencia=n2.id_geo and n2.nivel =2                        
                                join catalogos.geo as n1 on n2.id_padre = n1.id_geo                    
                            
                        union 
                    select n1.id_geo as id_depto, id_persona
                            from fichas.persona as p
                                join catalogos.geo as n1 on p.id_lugar_residencia=n1.id_geo and n1.nivel =1
                                )                                                                        
                    depto
                    "
        ;

        //$subquery = \DB::raw($sql_depto);

        $sql_general =  $query->leftjoin(\DB::raw($sql_depto), function ($join) {
            $join->on('persona.id_persona', '=', 'depto.id_persona');
        })
            ->selectraw(\DB::raw(" hecho_victima.id_hecho_victima, depto.id_depto "));


        $query_general = entrevista_individual::getQueries($sql_general);
        //dd($query_general);





        $res  = \DB::table(\DB::raw("($query_general) as general" ))
            ->selectraw(\DB::raw('general.id_depto as var, count(1) as val'))
            ->groupBy("general.id_depto")
            ->orderby('val','desc')
            ->get();



        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_l_residencia";
        //Respuesta
        $respuesta->lugar_r->categorias = $categorias;
        $respuesta->lugar_r->datos = $x;
        $respuesta->lugar_r->grafico = graficador::g_barra($g);

        //Edad de la victima al momento de los hechos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        //$query->join('fichas.hecho_victima','victima.id_victima','=','hecho_victima.id_victima');

        $res = $query->selectraw(\DB::raw('hecho_victima.edad as var, count(1) as val'))
            ->groupby('edad')
            ->get();

        $categorias=array();
        $categorias[0] = "Desconocido";
        $categorias[1] = "NNA (0-17)";
        $categorias[2] = "Joven (18-26)";
        $categorias[3] = "Adulto (27-59)";
        $categorias[4] = "Persona mayor (60 en adelante)";
        //Limite superior
        $limites[0]=-1;
        $limites[1]=17;
        $limites[2]=26;
        $limites[3]=59;
        $limites[4]=100;
        //inicializar arreglo con valores
        $x=array();
        foreach($categorias as $id=>$txt) {
            $x[$id]=0;
        }


        foreach($res as $fila) {
            foreach($limites as $id_categoria => $max) {
                $cual_categoria=4;
                if($fila->var <= $max ) {
                    $cual_categoria = $id_categoria;
                    break;
                }
            }
            $x[$cual_categoria]+= $fila->val;
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_edad";
        //Respuesta
        $respuesta->edad = new \stdClass();
        $respuesta->edad->categorias = $categorias;
        $respuesta->edad->datos = $x;
        $respuesta->edad->grafico = graficador::g_columna($g);


        //Sexo
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        if($filtros->debug==100) {

            self::getQueries($query);
        }
        $res = self::query_simple($query,'persona.id_sexo',null,$filtros->debug);

        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_sexo";
        //Respuesta
        $respuesta->sexo->categorias = $res->categorias;
        $respuesta->sexo->datos = $res->valores;
        $respuesta->sexo->grafico = graficador::g_pie($g);

        //Orientacion sexual
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_orientacion');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_orientacion_sexual";
        //Respuesta
        $respuesta->orientacion->categorias = $res->categorias;
        $respuesta->orientacion->datos =$res->valores;
        $respuesta->orientacion->grafico = graficador::g_pie($g);

        //Identidad género
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_identidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_identidad_generao";
        //Respuesta
        $respuesta->identidad_g->categorias = $res->categorias;
        $respuesta->identidad_g->datos = $res->valores;
        $respuesta->identidad_g->grafico = graficador::g_pie($g);





        //Pertenencia etnica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_etnia');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_etnia";
        //Respuesta
        $respuesta->etnia->categorias = $res->categorias;
        $respuesta->etnia->datos = $res->valores;
        $respuesta->etnia->grafico = graficador::g_columna($g);

        //Pertenencia indigena
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_etnia_indigena');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_indigena";
        //Respuesta
        $respuesta->indigena->categorias =  $res->categorias;
        $respuesta->indigena->datos = $res->valores;
        $respuesta->indigena->grafico = graficador::g_barra($g);

        //Estado ciivl
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_estado_civil');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_estado_civil";
        //Respuesta
        $respuesta->estado_civil->categorias =  $res->categorias;
        $respuesta->estado_civil->datos = $res->valores;
        $respuesta->estado_civil->grafico = graficador::g_pie($g);

        //Discapacidadd
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_discapacidad','persona.id_persona','=','persona_discapacidad.id_persona');
        $res = self::query_simple($query,'persona_discapacidad.id_discapacidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_discapacidad";
        //Respuesta
        $respuesta->discapacidad->categorias =  $res->categorias;
        $respuesta->discapacidad->datos = $res->valores;
        $respuesta->discapacidad->grafico = graficador::g_columna($g);

        //Educacion
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_edu_formal');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_edu_formal";
        //Respuesta
        $respuesta->educacion->categorias =  $res->categorias;
        $respuesta->educacion->datos = $res->valores;
        $respuesta->educacion->grafico = graficador::g_columna($g);

        //Cargo publico
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.cargo_publico',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_cargo_publico";
        //Respuesta
        $respuesta->cargo->categorias = $res->categorias;
        $respuesta->cargo->datos = $res->valores;
        $respuesta->cargo->grafico = graficador::g_columna($g);

        //Autoridad etnica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_aut_etnico_ter','persona.id_persona', '=','persona_aut_etnico_ter.id_persona');
        $res = self::query_simple($query,'persona_aut_etnico_ter.id_aut_etnico_ter');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_autoridad_e_t";
        //Respuesta
        $respuesta->autoridad->categorias = $res->categorias;
        $respuesta->autoridad->datos = $res->valores;
        $respuesta->autoridad->grafico = graficador::g_barra($g);

        //Miembro de la fuerza publica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_fuerza_publica');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos

        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_fuerza_publica";


        //Respuesta
        $respuesta->f_publica->categorias =  $res->categorias;
        $respuesta->f_publica->datos = $res->valores;
        $respuesta->f_publica->grafico = graficador::g_pie($g);

        //Miembro Actor Armado Ilegal
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_actor_armado');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_aai";
        //Respuesta
        $respuesta->actor->categorias =  $res->categorias;
        $respuesta->actor->datos = $res->valores;
        $respuesta->actor->grafico = graficador::g_pie($g);


        //Nacionalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_nacionalidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_nacionalidad";
        //Respuesta
        $respuesta->nacionalidad->categorias = $res->categorias;
        $respuesta->nacionalidad->datos = $res->valores;
        $respuesta->nacionalidad->grafico = graficador::g_barra($g);

        //Participa en organización
        $query_base = entrevista_individual::filtrar($filtros)  //Contar víctimas, no victimizaciones
        ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_victima','hecho.id_hecho','=','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','=','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','=','persona.id_persona');

        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base,$filtros);
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.organizacion_colectivo',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_organizacion_participa";
        //Respuesta
        $respuesta->organizacion->categorias =  $res->categorias;
        $respuesta->organizacion->datos = $res->valores;
        $respuesta->organizacion->grafico = graficador::g_pie($g);

        //Tipo de organizacion en la que participa
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_organizacion','persona.id_persona', '=','persona_organizacion.id_persona');
        $res = self::query_simple($query,'persona_organizacion.id_tipo_organizacion');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="victima_organizacion_tipo";
        //Respuesta
        $respuesta->organizacion_tipo->categorias = $res->categorias;
        $respuesta->organizacion_tipo->datos = $res->valores;
        $respuesta->organizacion_tipo->grafico = graficador::g_barra($g);



        return $respuesta;

    }


    //Estadisticas de presunto responsable individual
    public static function stats_pri($filtros=null)
    {

        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad e fichas de víctima
        $respuesta->total = 0;

        // Dato sociodemograficaso
        $respuesta->sexo = new \stdClass(); // SExo
        $respuesta->sexo->categorias = array();
        $respuesta->sexo->datos = array();
        $respuesta->sexo->grafico = null;
        $respuesta->etnia = new \stdClass(); // Pertenencia etnica
        $respuesta->etnia->categorias = array();
        $respuesta->etnia->datos = array();
        $respuesta->etnia->grafico = null;
        $respuesta->edad = new \stdClass(); // Edad
        $respuesta->edad->categorias = array();
        $respuesta->edad->datos = array();
        $respuesta->edad->grafico = null;
        // Responsabilidad
        $respuesta->actor = new \stdClass(); // Actor del que hacía parte
        $respuesta->actor->categorias = array();
        $respuesta->actor->datos = array();
        $respuesta->actor->grafico = null;
        $respuesta->rango_para = new \stdClass(); // Rango paramilitar
        $respuesta->rango_para->categorias = array();
        $respuesta->rango_para->datos = array();
        $respuesta->rango_para->grafico = null;
        $respuesta->rango_gue = new \stdClass(); // Rango guerrilla
        $respuesta->rango_gue->categorias = array();
        $respuesta->rango_gue->datos = array();
        $respuesta->rango_gue->grafico = null;
        $respuesta->rango_fp = new \stdClass(); // Rango fuerza publica
        $respuesta->rango_fp->categorias = array();
        $respuesta->rango_fp->datos = array();
        $respuesta->rango_fp->grafico = null;
        $respuesta->responsabilidad = new \stdClass(); // Presunta responsabilidad
        $respuesta->responsabilidad->categorias = array();
        $respuesta->responsabilidad->datos = array();
        $respuesta->responsabilidad->grafico = null;
        // Pertencencia etnica
        $respuesta->ahora = new \stdClass(); // Sabe donde está ahora
        $respuesta->ahora->categorias = array();
        $respuesta->ahora->datos = array();
        $respuesta->ahora->grafico = null;
        $respuesta->otros = new \stdClass(); // Participo en otros hechos
        $respuesta->otros->categorias = array();
        $respuesta->otros->datos = array();
        $respuesta->otros->grafico = null;


        //Query Base: aplicar filtros parejo
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.persona_responsable','e_ind_fvt.id_e_ind_fvt','=','persona_responsable.id_e_ind_fvt')
            ->join('fichas.persona','persona_responsable.id_persona','=','persona.id_persona');

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);

        //Total de fichas
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $respuesta->total = $query->count();


        //Sexo
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_sexo');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_sexo";
        //Respuesta
        $respuesta->sexo->categorias = $res->categorias;
        $respuesta->sexo->datos = $res->valores;
        $respuesta->sexo->grafico = graficador::g_pie($g);

        //Edad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_edad_aproximada');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_edad";
        //Respuesta
        $respuesta->edad->categorias = $res->categorias;
        $respuesta->edad->datos =$res->valores;
        $respuesta->edad->grafico = graficador::g_columna($g);



        //Pertenencia etnica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona.id_etnia');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_etnia";
        //Respuesta
        $respuesta->etnia->categorias = $res->categorias;
        $respuesta->etnia->datos = $res->valores;
        $respuesta->etnia->grafico = graficador::g_columna($g);

        //Actor del que hace parte
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_rango_cargo');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_actor_parte";
        //Respuesta
        $respuesta->actor->categorias =  $res->categorias;
        $respuesta->actor->datos = $res->valores;
        $respuesta->actor->grafico = graficador::g_barra($g);

        //RAngo, paramilitares
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_grupo_paramilitar');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_rango_paramilitar";
        //Respuesta
        $respuesta->rango_para->categorias =  $res->categorias;
        $respuesta->rango_para->datos = $res->valores;
        $respuesta->rango_para->grafico = graficador::g_columna($g);

        //RAngo, guerrilla
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_guerrilla');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_rango_guerrilla";
        //Respuesta
        $respuesta->rango_gue->categorias =  $res->categorias;
        $respuesta->rango_gue->datos = $res->valores;
        $respuesta->rango_gue->grafico = graficador::g_columna($g);

        //RAngo, fuerza publica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_fuerza_publica');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_rango_fuerza_publica";
        //Respuesta
        $respuesta->rango_fp->categorias =  $res->categorias;
        $respuesta->rango_fp->datos = $res->valores;
        $respuesta->rango_fp->grafico = graficador::g_columna($g);

        //Responsabilidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_responsable_responsabilidades','persona_responsable_responsabilidades.id_persona_responsable','=','persona_responsable.id_persona_responsable');
        $res = self::query_simple($query,'persona_responsable_responsabilidades.id_responsabilidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_responsabilidad";
        //Respuesta
        $respuesta->responsabilidad->categorias =  $res->categorias;
        $respuesta->responsabilidad->datos = $res->valores;
        $respuesta->responsabilidad->grafico = graficador::g_columna($g);

        //sabe que hace ahora
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.conoce_info',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_sabe_que_hace_ahora";
        //Respuesta
        $respuesta->ahora->categorias =  $res->categorias;
        $respuesta->ahora->datos = $res->valores;
        $respuesta->ahora->grafico = graficador::g_columna($g);

        //Participo en otros hechos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.otros_hechos',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_otros_hechos";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->otros->categorias = $res->categorias;
        $respuesta->otros->datos = $res->valores;
        $respuesta->otros->grafico = graficador::g_columna($g);


        //dd($respuesta);

        return $respuesta;

    }
    //Estadisticas de presunto responsable individual, versión ajax
    public static function json_pri($filtros=null)
    {

        //Estructura de la respuesta
        $respuesta = new \stdClass();
        // Dato sociodemograficaso
        $respuesta->sexo = new \stdClass(); // SExo
        $respuesta->etnia = new \stdClass(); // Pertenencia etnica
        $respuesta->edad = new \stdClass(); // Edad
        // Responsabilidad
        $respuesta->actor = new \stdClass(); // Actor del que hacía parte
        $respuesta->rango_para = new \stdClass(); // Rango paramilitar
        $respuesta->rango_gue = new \stdClass(); // Rango guerrilla
        $respuesta->rango_fp = new \stdClass(); // Rango fuerza publica
        $respuesta->responsabilidad = new \stdClass(); // Presunta responsabilidad
        $respuesta->ahora = new \stdClass(); // Sabe donde está ahora
        $respuesta->otros = new \stdClass(); // Participo en otros hechos



        //Query Base: aplicar filtros parejo
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.persona_responsable','e_ind_fvt.id_e_ind_fvt','=','persona_responsable.id_e_ind_fvt')
            ->join('fichas.persona as res_persona','persona_responsable.id_persona','=','res_persona.id_persona')  //uso alias por el filtro de sexo de vicitma usa tabla persona
            ->join('fichas.hecho_responsable','persona_responsable.id_persona_responsable','hecho_responsable.id_persona_responsable')
            ->join('fichas.hecho','hecho_responsable.id_hecho','hecho.id_hecho')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho');


        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);

        //Usar wherein para evitar que hecho_violencia multiplique los PRI
        $query = clone $query_base;
        $universo_hechos=$query_base->distinct()->pluck('hecho.id_hecho')->toArray();


        //Nuevo $query_base, sin join a violencia, con los filtros aplicados
        $query_base = entrevista_individual::join('fichas.persona_responsable','e_ind_fvt.id_e_ind_fvt','=','persona_responsable.id_e_ind_fvt')
                        ->join('fichas.persona as res_persona','persona_responsable.id_persona','=','res_persona.id_persona') //uso alias por el filtro de sexo de vicitma usa tabla persona
                        ->join('fichas.hecho_responsable','persona_responsable.id_persona_responsable','hecho_responsable.id_persona_responsable')
                        ->join('fichas.hecho','hecho_responsable.id_hecho','hecho.id_hecho')
                        ->wherein('hecho.id_hecho',$universo_hechos);


        //Sexo
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'res_persona.id_sexo');

        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_sexo";
        //Respuesta
        $respuesta->sexo->categorias = $res->categorias;
        $respuesta->sexo->datos = $res->valores;
        $respuesta->sexo->grafico = graficador::g_pie($g);

        //Edad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_edad_aproximada');
        //unset($res->categorias[0]); //Que no grafique los desconocidos
        //unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_edad";
        //Respuesta
        $respuesta->edad->categorias = $res->categorias;
        $respuesta->edad->datos =$res->valores;
        $respuesta->edad->grafico = graficador::g_columna($g);



        //Pertenencia etnica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'res_persona.id_etnia');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_etnia";
        //Respuesta
        $respuesta->etnia->categorias = $res->categorias;
        $respuesta->etnia->datos = $res->valores;
        $respuesta->etnia->grafico = graficador::g_columna($g);

        //Actor del que hace parte
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_rango_cargo');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_actor_parte";
        //Respuesta
        $respuesta->actor->categorias =  $res->categorias;
        $respuesta->actor->datos = $res->valores;
        $respuesta->actor->grafico = graficador::g_barra($g);

        //RAngo, paramilitares
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_grupo_paramilitar');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_rango_paramilitar";
        //Respuesta
        $respuesta->rango_para->categorias =  $res->categorias;
        $respuesta->rango_para->datos = $res->valores;
        $respuesta->rango_para->grafico = graficador::g_columna($g);

        //RAngo, guerrilla
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_guerrilla');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_rango_guerrilla";
        //Respuesta
        $respuesta->rango_gue->categorias =  $res->categorias;
        $respuesta->rango_gue->datos = $res->valores;
        $respuesta->rango_gue->grafico = graficador::g_columna($g);

        //RAngo, fuerza publica
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.id_fuerza_publica');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_rango_fuerza_publica";
        //Respuesta
        $respuesta->rango_fp->categorias =  $res->categorias;
        $respuesta->rango_fp->datos = $res->valores;
        $respuesta->rango_fp->grafico = graficador::g_columna($g);

        //Responsabilidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.persona_responsable_responsabilidades','persona_responsable_responsabilidades.id_persona_responsable','=','persona_responsable.id_persona_responsable');
        $res = self::query_simple($query,'persona_responsable_responsabilidades.id_responsabilidad');
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_responsabilidad";
        //Respuesta
        $respuesta->responsabilidad->categorias =  $res->categorias;
        $respuesta->responsabilidad->datos = $res->valores;
        $respuesta->responsabilidad->grafico = graficador::g_columna($g);

        //sabe que hace ahora
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.conoce_info',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_sabe_que_hace_ahora";
        //Respuesta
        $respuesta->ahora->categorias =  $res->categorias;
        $respuesta->ahora->datos = $res->valores;
        $respuesta->ahora->grafico = graficador::g_columna($g);

        //Participo en otros hechos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res = self::query_simple($query,'persona_responsable.otros_hechos',2);
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="pri_otros_hechos";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->otros->categorias = $res->categorias;
        $respuesta->otros->datos = $res->valores;
        $respuesta->otros->grafico = graficador::g_columna($g);


        //dd($respuesta);

        return $respuesta;

    }

    //Información de hechos y violencia
    public static function stats_violencia($filtros=null)
    {

        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad e fichas de víctima
        $respuesta->total = 0;

        // Tipo de violencia
        $respuesta->tipo = new \stdClass(); // Tipo de violencia
        $respuesta->tipo->categorias = array();
        $respuesta->tipo->datos = array();
        $respuesta->tipo->nivel = 1;
        $respuesta->tipo->titulo = "Tipos de violencia";
        $respuesta->tipo->grafico = null;

        // Subtipo de violencia
        $respuesta->subtipo = new \stdClass(); // Subtipo de violencia
        $respuesta->subtipo->categorias = array();
        $respuesta->subtipo->datos = array();
        $respuesta->subtipo->nivel = 0;  //No aplica
        $respuesta->subtipo->titulo = "Tipo de violencia";
        $respuesta->subtipo->grafico = null;

        // Mecanismos
        $respuesta->mecanismos = new \stdClass();
        $respuesta->mecanismos->categorias = array();
        $respuesta->mecanismos->datos = array();
        $respuesta->mecanismos->nivel = 0;  //No aplica
        $respuesta->mecanismos->titulo = "Tipo de violencia";
        $respuesta->mecanismos->grafico = null;

        // Individual, colectivo, familiar
        $respuesta->ifc = new \stdClass();
        $respuesta->ifc->categorias = array();
        $respuesta->ifc->datos = array();
        $respuesta->ifc->nivel = 0;  //No aplica
        $respuesta->ifc->titulo = "Subtipos de violencia";
        $respuesta->ifc->grafico = null;

        // Frente a terceros
        $respuesta->terceros = new \stdClass();
        $respuesta->terceros->categorias = array();
        $respuesta->terceros->datos = array();
        $respuesta->terceros->nivel = 0;  //No aplica
        $respuesta->terceros->titulo = "Mecanismos de violencia";
        $respuesta->terceros->grafico = null;

        // Otros: sentido del desplazamiento, recupero tierras
        $respuesta->tipo_otros = new \stdClass();
        $respuesta->tipo_otros->categorias = array();
        $respuesta->tipo_otros->datos = array();
        $respuesta->tipo_otros->nivel = 0;  //No aplica
        $respuesta->tipo_otros->titulo = "Tipo de violencia";
        $respuesta->tipo_otros->grafico = null;





        $respuesta->anio = new \stdClass(); // Año de la violencia
        $respuesta->anio->categorias = array();
        $respuesta->anio->datos = array();
        $respuesta->anio->grafico = null;
        $respuesta->geo = new \stdClass(); // Departamento de la violencia
        $respuesta->geo->categorias = array();
        $respuesta->geo->datos = array();
        $respuesta->geo->grafico = null;
        $respuesta->respo_aa = new \stdClass(); // Responsabilidad colectiva, actor armado
        $respuesta->respo_aa->categorias = array();
        $respuesta->respo_aa->datos = array();
        $respuesta->respo_aa->grafico = null;
        $respuesta->respo_tc = new \stdClass(); // Responsabilidad colectiva, tercero civil
        $respuesta->respo_tc->categorias = array();
        $respuesta->respo_tc->datos = array();
        $respuesta->respo_tc->grafico = null;
        $respuesta->impactos = array();


        //Query Base: aplicar filtros parejo.  Conteo de violencias.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho');;

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);


        //Para evitar productos cartesianos
        if($filtros->violencia_tipo > 0) {
            $query_base->whereraw(\DB::raw('hecho_violencia.id_hecho_violencia = f_hecho_violencia.id_hecho_violencia')); //Para evitar un producto cartesiano
        }
        if($filtros->violencia_lugar > 0) {
            $query_base->whereraw(\DB::raw('hecho.id_hecho = f_hecho.id_hecho')); //Para evitar un producto cartesiano
            //$query_base->whereraw(\DB::raw('gv.id_hecho_violencia = fvg.id_hecho_violencia')); //Para evitar un producto cartesiano
        }

        if($filtros->violencia_lugar > 0 && $filtros->violencia_tipo > 0) {
            //$query_base->whereraw(\DB::raw('fvv.id_hecho_violencia = fvg.id_hecho_violencia')); //Para evitar un producto cartesiano
        }
        if($filtros->violencia_anio_al > 0) {
            $query_base->whereraw(\DB::raw('hecho.id_hecho = f_hecho.id_hecho')); //Para evitar un producto cartesiano
        }
        if($filtros->violencia_anio_del > 0) {
            $query_base->whereraw(\DB::raw('hecho.id_hecho = f_hecho.id_hecho')); //Para evitar un producto cartesiano
        }
        if($filtros->violencia_aa > 0) {
            $query_base->whereraw(\DB::raw('hecho.id_hecho = f_hecho.id_hecho')); //Para evitar un producto cartesiano
        }
        if($filtros->violencia_tc > 0) {
            $query_base->whereraw(\DB::raw('hecho.id_hecho = f_hecho.id_hecho')); //Para evitar un producto cartesiano
        }





        $respuesta->total = count($query_base->distinct()->get());

        $debug['sql']= nl2br($query_base->toSql());
        $debug['criterios']=$query_base->getBindings();
        //dd($debug);

        $a_universo = $query_base->distinct()->pluck('hecho_violencia.id_hecho_violencia')->toArray();
        $universo = count($a_universo) > 0 ? implode(",",$a_universo) : '-1';
        //dd(count($a_universo));


        //dd($query_base->toSql());

        //Por tipo
        $query = clone $query_base;  //Query con filtros

        $res  = $query->selectraw(\DB::raw("hecho_violencia.id_tipo_violencia as var, count(1) as val"))
            ->groupby('hecho_violencia.id_tipo_violencia')
            ->orderby('val','desc')
            ->get();
        //Procesar resultados
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
            if($respuesta->tipo->nivel == 2) {  //Mecanismos
                $categorias[$fila->var] = cat_item::describir($fila->var);
            }
            else {
                $categorias[$fila->var] = tipo_violencia::nombrar($fila->var);
            }
        }
        //Para el gráfico
        $res = new \stdClass();
        $res->categorias = $categorias;
        $res->valores = $x;

        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Violencia";
        $g->yAxis = "Violencia";
        $g->descarga="violencia_tipo";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->tipo->titulo = "Tipos de violencia";
        $respuesta->tipo->nivel = 1;
        $respuesta->tipo->categorias = $res->categorias;
        $respuesta->tipo->datos = $res->valores;
        $respuesta->tipo->grafico = graficador::g_columna($g);


        //Cuando escogen tipo/subtipo, hay que calcular detalle: mecanismos, subtipos, etc.
        if($filtros->violencia_tipo > 0) {
            $cual_violencia = tipo_violencia::find($filtros->violencia_tipo);
            $codigo = substr($cual_violencia->codigo,0,2);

            //Violencias con subtipo
            if($codigo=="05" || $codigo=="06" || $codigo=="09" || $codigo=="10" || $codigo=="18" ) {
                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.id_subtipo_violencia as var, count(1) as val"))
                    ->wherein('hecho_violencia.id_hecho_violencia',$a_universo)
                    ->groupby('hecho_violencia.id_subtipo_violencia')
                    ->orderby('val','desc');
                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = tipo_violencia::nombrar($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Subtipos de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_subtipo";

                //Respuesta
                $respuesta->subtipo->titulo = "$cual_violencia->descripcion: Subtipos de violencia";
                $respuesta->subtipo->nivel = 1; //bandera para la vista
                $respuesta->subtipo->categorias = $res->categorias;
                $respuesta->subtipo->datos = $res->valores;
                $respuesta->subtipo->grafico = graficador::g_columna($g);
            }

            //Violencias con mecanismos
            if($codigo=="07" || $codigo=="08" || $codigo=="09" || $codigo=="12" || $codigo=="20"  ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->join('fichas.hecho_violencia_mecanismo','hecho_violencia.id_hecho_violencia', '=', 'hecho_violencia_mecanismo.id_hecho_violencia')
                    ->selectraw(\DB::raw("hecho_violencia_mecanismo.id_mecanismo as var, count(1) as val"))
                    ->groupby('hecho_violencia_mecanismo.id_mecanismo')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Mecanismos de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_mecanismos";

                //Respuesta
                $respuesta->mecanismos->titulo = "$cual_violencia->descripcion: Mecanismos de violencia";
                $respuesta->mecanismos->nivel = 1; //bandera para la vista
                $respuesta->mecanismos->categorias = $res->categorias;
                $respuesta->mecanismos->datos = $res->valores;
                $respuesta->mecanismos->grafico = graficador::g_columna($g);
            }


            // Modalidad de la violencia (individual, colectivo)
            if($codigo=="07" || $codigo=="09" || $codigo=="10" || $codigo=="11" || $codigo=="12" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $queryselectraw(\DB::raw("hecho_violencia.id_individual_colectiva as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_individual_colectiva')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Modalidad de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_modalidades";

                //Respuesta
                $respuesta->modalidad->titulo = "$cual_violencia->descripcion: Mecanismos de violencia";
                $respuesta->modalidad->nivel = 1; //bandera para la vista
                $respuesta->modalidad->categorias = $res->categorias;
                $respuesta->modalidad->datos = $res->valores;
                $respuesta->modalidad->grafico = graficador::g_columna($g);
            }

            // Modalidad de la violencia (individual, colectivo, familiar)
            if($codigo=="13" || $codigo=="14" || $codigo=="15" || $codigo=="20" || $codigo=="21" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $queryselectraw(\DB::raw("hecho_violencia.id_ind_fam_col as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_ind_fam_col')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Modalidad de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_modalidades";

                //Respuesta
                $respuesta->modalidad->titulo = "$cual_violencia->descripcion: Mecanismos de violencia";
                $respuesta->modalidad->nivel = 1; //bandera para la vista
                $respuesta->modalidad->categorias = $res->categorias;
                $respuesta->modalidad->datos = $res->valores;
                $respuesta->modalidad->grafico = graficador::g_columna($g);
            }

            // Frente a terceros
            if($codigo=="09" || $codigo=="10" || $codigo=="11" || $codigo=="12" || $codigo=="14" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $queryselectraw(\DB::raw("hecho_violencia.id_frente_otros as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_ind_fam_col')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = criterio_fijo::describir(2,$fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Violencia ejercida frente a otros";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_terceros";

                //Respuesta
                $respuesta->terceros->titulo = "$cual_violencia->descripcion: Violencia ejercida frente a otros";
                $respuesta->terceros->nivel = 1; //bandera para la vista
                $respuesta->terceros->categorias = $res->categorias;
                $respuesta->terceros->datos = $res->valores;
                $respuesta->terceros->grafico = graficador::g_area($g);
            }

            // Otros: Despojo, recuperó sus tierras
            if($codigo=="20" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $queryselectraw(\DB::raw("hecho_violencia.despojo_recupero_tierras as var, count(1) as val"))
                    ->groupby('hecho_violencia.despojo_recupero_tierras')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = criterio_fijo::describir(10,$fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Recuperó tierras";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_despojo_recupera";

                //Respuesta
                $respuesta->tipo_otros->titulo = "$cual_violencia->descripcion: Recuperó sus tierras";
                $respuesta->tipo_otros->nivel = 1; //bandera para la vista
                $respuesta->tipo_otros->categorias = $res->categorias;
                $respuesta->tipo_otros->datos = $res->valores;
                $respuesta->tipo_otros->grafico = graficador::g_area($g);
            }

        }










        //-------- Por año
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res  = $query->selectraw(\DB::raw("hecho.fecha_ocurrencia_a as var, count(1) as val"))
                ->groupby('hecho.fecha_ocurrencia_a')
                ->orderby('hecho.fecha_ocurrencia_a')
                ->get();
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
            $categorias[(integer)$fila->var] = (integer)$fila->var;

        }

        //Poner a cero los años que hagan falta
        ksort($categorias);
        $min = array_key_first($categorias);
        $max = array_key_last($categorias);
        for($i=$min; $i<$max; $i++) {
            if(!isset($categorias[$i])) {
                $categorias[$i] = $i;
                $x[$i]=0;
            }
        }
        ksort($categorias);
        //Para el gráfico
        $res = new \stdClass();
        $res->categorias = $categorias;
        $res->valores = $x;

        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Violencia";
        $g->yAxis="Violencia";
        $g->descarga="violencia_anyo";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->anio->categorias = $res->categorias;
        $respuesta->anio->datos = $res->valores;
        $respuesta->anio->grafico = graficador::g_area($g);


        //----- GEO
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.hecho_violencia as gv','hecho.id_hecho','=','gv.id_hecho')
                    ->orderby('gv.id_hecho_violencia');
        if($filtros->violencia_tipo > 0) {
            $query->whereraw(\DB::raw('gv.id_hecho_violencia = fvv.id_hecho_violencia')); //Para evitar un producto cartesiano
            //$query_base->whereraw(\DB::raw('gv.id_hecho_violencia = fvg.id_hecho_violencia')); //Para evitar un producto cartesiano
        }
         $res = $query->pluck('gv.id_hecho_violencia')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';
        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n3 on h.id_lugar = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n2 on h.id_lugar = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n1 on h.id_lugar = n1.id_geo and n1.nivel =1                                                    
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            left join catalogos.geo as n2 on h.id_lugar = n2.id_geo                                           
                        where hv.id_hecho_violencia in ($universo) and n2.id_geo is null
                        group by 1,2,3
                ";

        //Por tipo
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        if($filtros->violencia_lugar > 0) {
            $cual = geo::find($filtros->violencia_lugar);
            $nivel=$cual->nivel;
            if($nivel==1) {  //Mostrar municipio
                $respuesta->geo->titulo = "$cual->descripcion: distribución por municipio. ";
                $respuesta->geo->nivel =1;
                $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    where id_geo_n1 = $filtros->violencia_lugar
                    group by 1
                    order by 2 desc
                    ";
                $res  = \DB::select($sql2);

            }
            else {  //Solo este tipo, ver si tiene modalidad
                $respuesta->geo->titulo = "$cual->descripcion: distribución por vereda. ";
                $respuesta->geo->nivel =2;
                $sql2 = "select id_geo_n3 as var, sum(conteo) as val
                    from ($sql) as unidos
                    where id_geo_n2 = $filtros->violencia_lugar
                    group by 1
                    order by 2 desc
                    ";
                $res  = \DB::select($sql2);
            }
        }
        else {
            $respuesta->geo->titulo = "Distribución por departamento ";
            $respuesta->geo->nivel =0;
            $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos                
                    group by 1
                    order by 2 desc
                    ";
            $res  = \DB::select($sql2);
        }
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
            $categorias[$fila->var] = geo::nombrar($fila->var);

        }
        //Para el gráfico
        $res = new \stdClass();
        $res->categorias = $categorias;
        $res->valores = $x;

        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Violencia";
        $g->yAxis = "Violencia";
        $g->descarga="violencia_geo";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->geo->categorias = $res->categorias;
        $respuesta->geo->datos = $res->valores;
        $respuesta->geo->grafico = graficador::g_columna($g);

        //Responsabilidad colectiva: AA
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.hecho_responsabilidad','hecho.id_hecho', '=','hecho_responsabilidad.id_hecho');
        $res = self::query_simple($query,'hecho_responsabilidad.aa_id_subtipo');
        foreach($res->categorias as $id=>$txt) {
            $res->categorias[$id] = tipo_aa::nombre_completo($id);
        }
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="violencia_aa";
        //Respuesta
        $respuesta->respo_aa->categorias =  $res->categorias;
        $respuesta->respo_aa->datos = $res->valores;
        $respuesta->respo_aa->grafico = graficador::g_barra($g);


        //Responsabilidad colectiva: TC
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.hecho_responsabilidad','hecho.id_hecho', '=','hecho_responsabilidad.id_hecho');
        $res = self::query_simple($query,'hecho_responsabilidad.tc_id_subtipo');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        foreach($res->categorias as $id=>$txt) {
            $res->categorias[$id] = tipo_tc::nombrar($id);
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="violencia_tc";
        //Respuesta
        $respuesta->respo_tc->categorias =  $res->categorias;
        $respuesta->respo_tc->datos = $res->valores;
        $respuesta->respo_tc->grafico = graficador::g_barra($g);

        //Contexto

        $contexto = [127, 128, 129, 130, 131];
        foreach($contexto as $id_cat) {
            $query = clone $query_base;
            //$query->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt', '=','hecho.id_e_ind_fvt');
            $query->join('fichas.hecho_contexto','hecho.id_hecho','=','hecho_contexto.id_hecho')
                    ->join('catalogos.cat_item','hecho_contexto.id_contexto','=','cat_item.id_item')
                    ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->impactos['ctx'][$id_cat] = $res;
        }


        $impactos_i = [132,133,134,135,136,137,138];

        foreach($impactos_i as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                    ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->impactos['ind'][$id_cat] = $res;
        }

        $impactos_c = [139,140,141,142,143];
        foreach($impactos_c as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->impactos['col'][$id_cat] = $res;
        }


        $afrontamiento = [144,145,146,147,148];
        foreach($afrontamiento as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->impactos['afr'][$id_cat] = $res;
        }


        $avances = [160,161,162,163,164,165,166,167,168,169,171];
        foreach($avances as $id_cat) {
            $query = clone $query_base;
            $query->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt', '=','entrevista_impacto.id_e_ind_fvt');
            $query->join('catalogos.cat_item','entrevista_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->impactos['av'][$id_cat] = $res;
        }

        //Acceso a la justicia
        $instituciones = [1,2,3];

        foreach($instituciones as $id_tipo) {
            //Institucion
            $query = clone $query_base;
            $query->join('fichas.justicia_institucion','e_ind_fvt.id_e_ind_fvt', '=','justicia_institucion.id_e_ind_fvt');
            $query->join('catalogos.cat_item','justicia_institucion.id_institucion','=','cat_item.id_item')
                ->where('justicia_institucion.id_tipo',$id_tipo);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = "Instituciones a las que accede";
            $respuesta->impactos['aj'][$id_tipo]['ins'] = $res;
            //Objetivo
            $query = clone $query_base;
            $query->join('fichas.justicia_objetivo','e_ind_fvt.id_e_ind_fvt', '=','justicia_objetivo.id_e_ind_fvt');
            $query->join('catalogos.cat_item','justicia_objetivo.id_objetivo','=','cat_item.id_item')
                ->where('justicia_objetivo.id_tipo',$id_tipo);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = "Objetivo de acceder";
            $respuesta->impactos['aj'][$id_tipo]['obj'] = $res;

            //Porqué
            $query = clone $query_base;
            $query->join('fichas.justicia_porque','e_ind_fvt.id_e_ind_fvt', '=','justicia_porque.id_e_ind_fvt');
            $query->join('catalogos.cat_item','justicia_porque.id_porque','=','cat_item.id_item')
                ->where('justicia_porque.id_tipo',$id_tipo);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = "Porqué accedió";
            $respuesta->impactos['aj'][$id_tipo]['pq'] = $res;
        }
        //Estado












        return $respuesta;

    }
    //Información de hechos y violencia, versión ajax
    public static function json_violencia($filtros=null)
    {
        $log=false;
        if($log) {
            Log::debug("--- Inicio del calculo de estadisticas de violencia----");
            $time_start = microtime(true);
        }


        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad e fichas de víctima
        $respuesta->total = 0;

        // Por tipo de violencia, cuadro general
        $respuesta->tipo = new \stdClass(); // Tipo de violencia
        $respuesta->tipo->nivel = null;
        $respuesta->tipo->titulo = "Tipos de violencia";
        $respuesta->anio = new \stdClass(); // Año de la violencia
        $respuesta->respo_aa = new \stdClass(); // Responsabilidad colectiva, actor armado
        $respuesta->respo_tc = new \stdClass(); // Responsabilidad colectiva, tercero civil
        $respuesta->geo = new \stdClass(); // Departamento de la violencia

        // Subtipo de violencia
        $respuesta->subtipo = new \stdClass(); // Subtipo de violencia
        $respuesta->subtipo->categorias = array();
        $respuesta->subtipo->datos = array();
        $respuesta->subtipo->nivel = 0;  //No aplica
        $respuesta->subtipo->titulo = "Subtipos de violencia";
        $respuesta->subtipo->grafico = null;

        // Mecanismos
        $respuesta->mecanismos = new \stdClass();
        $respuesta->mecanismos->categorias = array();
        $respuesta->mecanismos->datos = array();
        $respuesta->mecanismos->nivel = 0;  //No aplica
        $respuesta->mecanismos->titulo = "Mecanismos de violencia";
        $respuesta->mecanismos->grafico = null;

        // Individual, colectivo, familiar
        $respuesta->ifc = new \stdClass();
        $respuesta->ifc->categorias = array();
        $respuesta->ifc->datos = array();
        $respuesta->ifc->nivel = 0;  //No aplica
        $respuesta->ifc->titulo = "Subtipos de violencia";
        $respuesta->ifc->grafico = null;

        // Frente a terceros
        $respuesta->terceros = new \stdClass();
        $respuesta->terceros->categorias = array();
        $respuesta->terceros->datos = array();
        $respuesta->terceros->nivel = 0;  //No aplica
        $respuesta->terceros->titulo = "Mecanismos de violencia";
        $respuesta->terceros->grafico = null;

        // Otros: sentido del desplazamiento, recupero tierras
        $respuesta->tipo_otros = new \stdClass();
        $respuesta->tipo_otros->categorias = array();
        $respuesta->tipo_otros->datos = array();
        $respuesta->tipo_otros->nivel = 0;  //No aplica
        $respuesta->tipo_otros->titulo = "Otros detalles";
        $respuesta->tipo_otros->grafico = null;




        //Query Base: aplicar filtros parejo.  Conteo de violencias.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','=','hecho_violencia.id_hecho')
            ->join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho');  //Si no agrego la víctima, cuento hechos, no victimizaciones

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos($query_base,$filtros);

        //Calculo de estadísticos

        $query = clone $query_base;

        $respuesta->total = $query_base->distinct()->pluck('hecho_violencia.id_hecho_violencia')->count();

        //$debug['sql']= nl2br($query_base->toSql());
        //$debug['criterios']=$query_base->getBindings();
        //dd($debug);
        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo antes de estimar el universo aplicar: $formato segundos");
            $time_start = microtime(true);
        }
        //Para aplicar los filtros
        $query = clone $query_base;
        $a_universo = $query_base->distinct()->pluck('hecho_violencia.id_hecho_violencia')->toArray();
        $universo = count($a_universo) > 0 ? implode(",",$a_universo) : '-1';
        //dd(count($a_universo));


        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo a antes de tipo de violencia: $formato segundos");
            $time_start = microtime(true);
        }

        //Por tipo
        $query = clone $query_base;  //Query con filtros

        $res  = $query->selectraw(\DB::raw("hecho_violencia.id_tipo_violencia as var, count(1) as val"))
            ->groupby('hecho_violencia.id_tipo_violencia')
            ->orderby('val','desc')
            ->get();
        //Procesar resultados
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
            if($respuesta->tipo->nivel == 2) {  //Mecanismos
                $categorias[$fila->var] = cat_item::describir($fila->var);
            }
            else {
                $categorias[$fila->var] = tipo_violencia::nombrar($fila->var);
            }
        }
        //Para el gráfico
        $res = new \stdClass();
        $res->categorias = $categorias;
        $res->valores = $x;

        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Violencia";
        $g->yAxis = "Violencia";
        $g->descarga="violencia_tipo";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->tipo->titulo = "Tipos de violencia";
        $respuesta->tipo->nivel = 1;
        $respuesta->tipo->categorias = $res->categorias;
        $respuesta->tipo->datos = $res->valores;
        $respuesta->tipo->grafico = graficador::g_columna($g);


        //Cuando escogen tipo/subtipo, hay que calcular detalle: mecanismos, subtipos, etc.
        if($filtros->violencia_tipo > 0) {
            $cual_violencia = tipo_violencia::find($filtros->violencia_tipo);
            $codigo = substr($cual_violencia->codigo,0,2);

            //Violencias con subtipo
            if($codigo=="05" || $codigo=="06" || $codigo=="09" || $codigo=="10" || $codigo=="18" ) {
                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.id_subtipo_violencia as var, count(1) as val"))
                    ->wherein('hecho_violencia.id_hecho_violencia',$a_universo)
                    ->groupby('hecho_violencia.id_subtipo_violencia')
                    ->orderby('val','desc');
                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = tipo_violencia::nombrar($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Subtipos de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_subtipo";

                //Respuesta
                $respuesta->subtipo->titulo = "$cual_violencia->descripcion: Subtipos de violencia";
                $respuesta->subtipo->nivel = 1; //bandera para la vista
                $respuesta->subtipo->categorias = $res->categorias;
                $respuesta->subtipo->datos = $res->valores;
                $respuesta->subtipo->grafico = graficador::g_columna($g);
            }

            //Violencias con mecanismos
            if($codigo=="07" || $codigo=="08" || $codigo=="09" || $codigo=="12" || $codigo=="20"  ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->join('fichas.hecho_violencia_mecanismo','hecho_violencia.id_hecho_violencia', '=', 'hecho_violencia_mecanismo.id_hecho_violencia')
                    ->selectraw(\DB::raw("hecho_violencia_mecanismo.id_mecanismo as var, count(1) as val"))
                    ->groupby('hecho_violencia_mecanismo.id_mecanismo')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Mecanismos de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_mecanismos";

                //Respuesta
                $respuesta->mecanismos->titulo = "$cual_violencia->descripcion: Mecanismos de violencia";
                $respuesta->mecanismos->nivel = 1; //bandera para la vista
                $respuesta->mecanismos->categorias = $res->categorias;
                $respuesta->mecanismos->datos = $res->valores;
                $respuesta->mecanismos->grafico = graficador::g_columna($g);
            }


            // Modalidad de la violencia (individual, colectivo)
            if($codigo=="07" || $codigo=="09" || $codigo=="10" || $codigo=="11" || $codigo=="12" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.id_individual_colectiva as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_individual_colectiva')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Modalidad de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_modalidades";

                //Respuesta
                //dd($cual_violencia);
                $respuesta->ifc->titulo = "$cual_violencia->descripcion: Modalidad de violencia";
                $respuesta->ifc->nivel = 1; //bandera para la vista
                $respuesta->ifc->categorias = $res->categorias;
                $respuesta->ifc->datos = $res->valores;
                $respuesta->ifc->grafico = graficador::g_pie($g);
            }

            // Modalidad de la violencia (individual, colectivo, familiar)
            if($codigo=="13" || $codigo=="14" || $codigo=="15" || $codigo=="20" || $codigo=="21" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.id_ind_fam_col as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_ind_fam_col')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Modalidad de violencia";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_modalidades";

                //Respuesta
                $respuesta->ifc->titulo = "$cual_violencia->descripcion: Modalidad de violencia";
                $respuesta->ifc->nivel = 1; //bandera para la vista
                $respuesta->ifc->categorias = $res->categorias;
                $respuesta->ifc->datos = $res->valores;
                $respuesta->ifc->grafico = graficador::g_pie($g);
            }

            // Frente a terceros
            if($codigo=="09" || $codigo=="10" || $codigo=="11" || $codigo=="12" || $codigo=="14" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.id_frente_otros as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_frente_otros')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = criterio_fijo::describir(2,$fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Violencia ejercida frente a otros";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_terceros";

                //Respuesta
                $respuesta->terceros->titulo = "$cual_violencia->descripcion: Violencia ejercida frente a otros";
                $respuesta->terceros->nivel = 1; //bandera para la vista
                $respuesta->terceros->categorias = $res->categorias;
                $respuesta->terceros->datos = $res->valores;
                $respuesta->terceros->grafico = graficador::g_pie($g);
            }

            // Otros: Despojo, recuperó sus tierras
            if($codigo=="20" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.despojo_recupero_tierras as var, count(1) as val"))
                    ->groupby('hecho_violencia.despojo_recupero_tierras')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = criterio_fijo::describir(10,$fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Recuperó tierras";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_despojo_recupera";

                //Respuesta
                $respuesta->tipo_otros->titulo = "$cual_violencia->descripcion: Recuperó sus tierras";
                $respuesta->tipo_otros->nivel = 1; //bandera para la vista
                $respuesta->tipo_otros->categorias = $res->categorias;
                $respuesta->tipo_otros->datos = $res->valores;
                $respuesta->tipo_otros->grafico = graficador::g_pie($g);
            }

            // Otros: Desplazamiento, sentido del desplazamiento
            if($codigo=="21" ) {

                $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
                $tmp  = $query->selectraw(\DB::raw("hecho_violencia.id_sentido_desplazamiento as var, count(1) as val"))
                    ->groupby('hecho_violencia.id_sentido_desplazamiento')
                    ->orderby('val','desc');

                $res=$tmp->get();
                $x=array();
                $categorias=array();
                foreach($res as $fila) {
                    $x[$fila->var] = $fila->val;
                    $categorias[$fila->var] = cat_item::describir($fila->var);
                }
                //Para el gráfico
                $res = new \stdClass();
                $res->categorias = $categorias;
                $res->valores = $x;

                $g = new \stdClass();
                $g->categorias = $res->categorias;
                $g->a_serie[] = $res->valores;
                $g->nombre_serie[]="Sentido del desplazamiento";
                $g->yAxis = "Victimizaciones";
                $g->descarga="violencia_sentido_desplazamiento";

                //Respuesta
                $respuesta->tipo_otros->titulo = "$cual_violencia->descripcion: Sentido del desplazamiento";
                $respuesta->tipo_otros->nivel = 1; //bandera para la vista
                $respuesta->tipo_otros->categorias = $res->categorias;
                $respuesta->tipo_otros->datos = $res->valores;
                $respuesta->tipo_otros->grafico = graficador::g_pie($g);
            }





        }


        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo a antes de violencia por años: $formato segundos");
            $time_start = microtime(true);
        }

        //-------- Por año
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $res  = $query->selectraw(\DB::raw("hecho.fecha_ocurrencia_a as var, count(1) as val"))
            ->groupby('hecho.fecha_ocurrencia_a')
            ->orderby('hecho.fecha_ocurrencia_a')
            //->where('hecho.fecha_ocurrencia_a','>=',1900)
            ->get();
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
            $categorias[(integer)$fila->var] = (integer)$fila->var;
        }

        //Poner a cero los años que hagan falta
        ksort($categorias);
        $min = array_key_first($categorias);
        $max = array_key_last($categorias);
        for($i=$min; $i<$max; $i++) {
            if(!isset($categorias[$i])) {
                $categorias[$i] = $i;
                $x[$i]=0;
            }
        }
        ksort($categorias);
        //Para el gráfico
        $res = new \stdClass();
        $res->categorias = $categorias;
        $res->valores = $x;

        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Hechos de violencia";
        $g->yAxis="Hechos de violencia";
        $g->descarga="violencia_anyo";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->anio->categorias = $res->categorias;
        $respuesta->anio->datos = $res->valores;
        $respuesta->anio->grafico = graficador::g_area($g, true);

        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo a antes de violencia por geo: $formato segundos");
            $time_start = microtime(true);
        }

        //----- GEO
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->orderby('hecho_violencia.id_hecho_violencia');
        if($filtros->violencia_tipo > 0) {
            //$query->whereraw(\DB::raw('gv.id_hecho_violencia = fvv.id_hecho_violencia')); //Para evitar un producto cartesiano
            //$query_base->whereraw(\DB::raw('gv.id_hecho_violencia = fvg.id_hecho_violencia')); //Para evitar un producto cartesiano
        }
        $res = $query->pluck('hecho_violencia.id_hecho_violencia')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';
        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n3 on h.id_lugar = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n2 on h.id_lugar = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n1 on h.id_lugar = n1.id_geo and n1.nivel =1                                                    
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            left join catalogos.geo as n2 on h.id_lugar = n2.id_geo                                           
                        where hv.id_hecho_violencia in ($universo) and n2.id_geo is null
                        group by 1,2,3
                ";

        //Por lugar de la violencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        if($filtros->violencia_lugar > 0) {
            $cual = geo::find($filtros->violencia_lugar);
            $nivel=$cual->nivel;
            if($nivel==1) {  //Mostrar municipio
                $respuesta->geo->titulo = "$cual->descripcion: distribución por municipio. ";
                $respuesta->geo->nivel =1;
                $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    where id_geo_n1 = $filtros->violencia_lugar
                    group by 1
                    order by 2 desc
                    ";
                $res  = \DB::select($sql2);

            }
            else {  //Solo este tipo, ver si tiene modalidad
                $respuesta->geo->titulo = "$cual->descripcion: distribución por vereda. ";
                $respuesta->geo->nivel =2;
                $sql2 = "select id_geo_n3 as var, sum(conteo) as val
                    from ($sql) as unidos
                    where id_geo_n2 = $filtros->violencia_lugar
                    group by 1
                    order by 2 desc
                    ";
                $res  = \DB::select($sql2);
            }
        }
        else {
            $respuesta->geo->titulo = "Distribución por departamento ";
            $respuesta->geo->nivel =0;
            $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos                
                    group by 1
                    order by 2 desc
                    ";
            $res  = \DB::select($sql2);
        }
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $x[$fila->var] = $fila->val;
            $categorias[$fila->var] = geo::nombrar($fila->var);

        }
        //Para el gráfico
        $res = new \stdClass();
        $res->categorias = $categorias;
        $res->valores = $x;

        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Violencia";
        $g->yAxis = "Violencia";
        $g->descarga="violencia_geo";
        //$g->yAxis = $g->nombre_serie[0];
        //Respuesta
        $respuesta->geo->categorias = $res->categorias;
        $respuesta->geo->datos = $res->valores;
        $respuesta->geo->grafico = graficador::g_columna($g);

        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo a antes de violencia por AA: $formato segundos");
            $time_start = microtime(true);
        }

        //Responsabilidad colectiva: AA
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        //Si hay filtro, ya se hizo el join, sino hay que hacerlo
        if($filtros->violencia_aa > 0 || $filtros->violencia_tc > 0) {
            //No hacer nada, el join ya está hecho
        }
        else {
            $query->join('fichas.hecho_responsabilidad','hecho.id_hecho', '=','hecho_responsabilidad.id_hecho');
        }
        $res = self::query_simple($query,'hecho_responsabilidad.aa_id_subtipo',);
        foreach($res->categorias as $id=>$txt) {
            $res->categorias[$id] = tipo_aa::nombre_completo($id);
        }
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="violencia_aa";
        //Respuesta
        $respuesta->respo_aa->categorias =  $res->categorias;
        $respuesta->respo_aa->datos = $res->valores;
        $respuesta->respo_aa->grafico = graficador::g_barra($g);


        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo a antes de violencia por TC: $formato segundos");
            $time_start = microtime(true);
        }


        //Responsabilidad colectiva: TC
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        //Si hay filtro, ya se hizo el join, sino hay que hacerlo
        if($filtros->violencia_aa > 0 || $filtros->violencia_tc > 0) {
            //No hacer nada, el join ya está hecho
        }
        else {
            $query->join('fichas.hecho_responsabilidad','hecho.id_hecho', '=','hecho_responsabilidad.id_hecho');
        }

        //$query->join('fichas.hecho_responsabilidad','hecho.id_hecho', '=','hecho_responsabilidad.id_hecho');
        $res = self::query_simple($query,'hecho_responsabilidad.tc_id_subtipo');
        unset($res->categorias[0]); //Que no grafique los desconocidos
        unset($res->valores[0]); //Que no grafique los desconocidos
        foreach($res->categorias as $id=>$txt) {
            $res->categorias[$id] = tipo_tc::nombre_completo($id);
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Personas";
        $g->descarga="violencia_tc";
        //Respuesta
        $respuesta->respo_tc->categorias =  $res->categorias;
        $respuesta->respo_tc->datos = $res->valores;
        $respuesta->respo_tc->grafico = graficador::g_barra($g);
        if($log) {
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $formato= number_format($time,2);
            Log::debug("Tiempo a tiempos: $formato segundos");
            $time_start = microtime(true);
        }




        return $respuesta;

    }


    //Para el mapa de violencia: Calcula total de hechos y de entrevistas
    public static function conteo_hechos($filtros=null, $log=false)
    {
        //Query Base: aplicar filtros parejo.  Conteo de Hechos.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho', 'e_ind_fvt.id_e_ind_fvt', '=', 'hecho.id_e_ind_fvt');

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base, $filtros);

        $query_base_entrevistas = entrevista_individual::filtrar($filtros);
        self::procesar_filtros_fichas_por_entrevista($query_base_entrevistas,$filtros);
        $universo_entrevistas = $query_base_entrevistas->distinct()->pluck('e_ind_fvt.id_e_ind_fvt');



        $respuesta= new \stdClass();
        $respuesta->conteos = new \stdClass();
        $respuesta->conteos->entrevistas= count($universo_entrevistas);;
        $respuesta->conteos->hechos=$query_base->count();

        //Conteo

        return $respuesta;
    }
    //Información de hechos y violencia, versión ajax
    public static function json_mapa_violencia($filtros=null, $log=false)
    {

        if($log) {
            Log::debug("--- Inicio del calculo de estadisticas de violencia----");
            $time_start = microtime(true);
        }

        //Query Base: aplicar filtros parejo.  Conteo de Hechos.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt');

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base,$filtros);

        //Determinar las violencias a mapear
        $query = clone $query_base;
        $res = $query->pluck('hecho.id_hecho')->toArray();

        $universo = count($res) > 0 ? implode(",",$res) : '-1';
        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n3 on h.id_lugar = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n2 on h.id_lugar = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n1 on h.id_lugar = n1.id_geo and n1.nivel =1                                                    
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            left join catalogos.geo as n2 on h.id_lugar = n2.id_geo                                           
                        where hv.id_hecho_violencia in ($universo) and n2.id_geo is null
                        group by 1,2,3
                ";

        //Por municipio
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    -- where id_geo_n1 = $filtros->violencia_lugar
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        //dd($res);

        $x=array();
        $categorias=array();
        $i=1;
        foreach($res as $fila) {
            $datos[$fila->var] = $fila->val;
            $muni = geo::find($fila->var);
            if($muni) {
                $categorias[$fila->var]['muni'] = $muni->descripcion;
                $categorias[$fila->var]['lon'] =$muni->lon;
                $categorias[$fila->var]['lat'] =$muni->lat;
                $categorias[$fila->var]['codigo'] =$muni->codigo;
                $categorias[$fila->var]['rank'] =$i++;  //Para colocarlos del mayor al menor
            }
            else {
                //Log::warning("Mapa, no se encontró el id_geo=$fila->var");
            }

        }

        $tipo_lugar='Hechos de violencia';
        $a_puntos =array();
        $max=0;  //Valor mayor
        foreach($categorias as $id_muni=>$info) {
            //determinar lat y lon de un lugar poblado
            $primero = geo::where('id_padre',$id_muni)
                                ->where('lon','<>',0)
                                ->orderby('codigo')
                                ->first();
            if($primero) {
                $punto=array();
                $punto['id']     = $id_muni;
                $punto['codigo'] = $info['codigo'];
                $punto['titulo'] = $info['muni'];
                $punto['conteo'] = $datos[$id_muni] * 1;
                $punto['ref'] = $primero->codigo;

                $punto['lon']    = $primero->lon * 1;
                $punto['lat']    = $primero->lat * 1;
                $punto['rank'] = $info['rank'];  //Para sobreposiciones
                $punto['fuente'] = 'e_ind_fvt'; //Para diferenciar la capa
                $a_puntos[$id_muni]=$punto;
                if($punto['conteo'] > $max) {
                    $max = $punto['conteo'];
                }

            }
            else { //Para referencia
                $punto=array();
                $punto['id']     = $id_muni;
                $punto['codigo'] = $info['codigo'];
                $punto['titulo'] = $info['muni'];
                $punto['conteo'] = $datos[$id_muni] * 1;
                $punto['ref']    = null;
                $punto['lon']    = 0;
                $punto['lat']    = 0;
                //$a_puntos[$id_muni]=$punto;
            }




        }
        //dd($a_puntos);
        $geojson = entrevista_individual::convertir_geojson($a_puntos);
        $geojson['lugar']=$tipo_lugar;
        $geojson['max']=$max;


        return $geojson;

    }

    //Información de hechos y violencia, versión ajax
    //Parecido al anterior, pero genera varias capas: una total y una por c/tipo de violencia
    public static function json_mapa_violencia_v2($filtros=null, $log=false)
    {

        //Colores de las capas
        $a_colores=array();
        //rojo
        $a_colores[0]="#FF0000";
        //Azules:
        $a_colores['05']="#0000FF";
        $a_colores['08']="#00008B";
        //Morados
        $a_colores['09']="#9932CC";
        $a_colores['10']="#8B008B";
        //amarillos
        $a_colores['20']="#ff6600";
        $a_colores['21']="#ff9900";
        $a_colores['22']="#FF9933";
        //Verdes
        $a_colores['12']="#003300";
        $a_colores['14']="#006600";
        $a_colores['16']="#009900";
        $a_colores['17']="#336600";
        //Grises
        $a_colores['06']="#708090";
        $a_colores['07']="#787878";
        $a_colores['11']="#778899";
        $a_colores['13']="#663300";
        $a_colores['15']="#666600";
        $a_colores['18']="#999900";
        $a_colores['19']="#333333";


        //Query Base: aplicar filtros parejo.  Conteo de Hechos.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt');

        //Filtros de violencia
        self::procesar_filtros_fichas_por_hechos_sin_violencia($query_base,$filtros);

        //Determinar las violencias a mapear
        $query = clone $query_base;
        $res = $query->pluck('hecho.id_hecho')->toArray();

        $universo = count($res) > 0 ? implode(",",$res) : '-1';
        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3, hv.id_tipo_violencia,  count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n3 on h.id_lugar = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3,4

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, hv.id_tipo_violencia, count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n2 on h.id_lugar = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3,4
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3, hv.id_tipo_violencia,  count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n1 on h.id_lugar = n1.id_geo and n1.nivel =1                                                    
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3,4
                
                
                ";
        // V2: ignoro los especificados a nivel de departamento
        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3, hv.id_tipo_violencia,  count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n3 on h.id_lugar = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3,4

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, hv.id_tipo_violencia, count(1) as conteo
                        from fichas.hecho as h join fichas.hecho_violencia hv on (h.id_hecho=hv.id_hecho)
                            join catalogos.geo as n2 on h.id_lugar = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where hv.id_hecho_violencia in ($universo)
                        group by 1,2,3,4                        
                ";

        //Por municipio
        $sql2 = "select id_geo_n2 as id_muni, id_tipo_violencia, sum(conteo) as val
                    from ($sql) as unidos            
                    group by 1,2
                    order by 3 desc,2
                    ";
        $res  = \DB::select($sql2);

        //Determinar las capas a mostrar y los municipios a plottear
        $a_capas=array();
        $a_munis=array();
        $a_max=array();
        foreach($res as $fila) {
           //$a_munis[$fila->id_muni]=0;
           $violencia = tipo_violencia::find($fila->id_tipo_violencia);
           $a_capas[$fila->id_tipo_violencia]= $violencia->descripcion;
           $a_capas_color[$fila->id_tipo_violencia] = $a_colores[$violencia->codigo];
           //Calcular capa de total de violencia
            if(isset($a_munis[$fila->id_muni])) {
                $a_munis[$fila->id_muni]  += $fila->val;
            }
            else {
                $a_munis[$fila->id_muni]  = $fila->val;
            }

        }


        //Datos para violencia total
        $max=0;
        $a_capas[0]="Violencia total";
        foreach($a_munis as $var => $val) {
            if($val > $max) {  //Valor maximo para simbolos proporcionales
                $max=$val;
            }
            $datos[0][$var]=$val;
        }

        //información de los municipios
        $a_datos_muni=array();
        foreach($a_munis as $id_muni=>$total) {
            $muni = geo::find($id_muni);
            if($muni) {
                $a_datos_muni[$id_muni]['muni'] = $muni->descripcion;
                $a_datos_muni[$id_muni]['codigo'] =$muni->codigo;
                //Obtener coordenadas del primer lugar poblado del municipio
                $primero = geo::where('id_padre',$id_muni)
                    ->where('lon','<>',0)
                    ->orderby('codigo')
                    ->first();
                if($primero) {
                    $a_datos_muni[$id_muni]['lon']    = $primero->lon * 1;
                    $a_datos_muni[$id_muni]['lat']    = $primero->lat * 1;
                    $a_datos_muni[$id_muni]['ref']    = $primero->codigo;
                }
            }
        }



        //Definir la estructura de c/capa
        $i=1;
        foreach($res as $fila) {
            $capa = $fila->id_tipo_violencia;
            $datos[$capa][$fila->id_muni] = $fila->val * 1;
        }

        //Valores maximos
        $a_max=array();
        foreach($datos as $capa=>$info) {
            $a_max[$capa]=0;
            foreach($info as $id_muni=>$val) {
                if($val > $a_max[$capa]) {
                    $a_max[$capa]=$val;
                }
            }
        }
        //Test: usar como max general el mayor individual y no la sumatoria
        /*
        unset($a_max[0]);
        $a_max[0]=max($a_max);
        //dd($a_max);
        */



        //Generar varios geoJson, uno por cada capa
        $a_final=array();

        foreach($a_capas as $id_capa => $tipo_vi) {
            $tipo_lugar = $tipo_vi;
            $a_puntos = array();
            $rank=1;
            foreach($datos[$id_capa] as $id_muni=>$info) {
                $punto = array();
                $punto['id']     = $id_muni;
                $punto['codigo'] = $a_datos_muni[$id_muni]['codigo'] ;
                $punto['titulo'] = $a_datos_muni[$id_muni]['muni'];

                $punto['conteo'] = $info * 1;
                $punto['ref'] = $a_datos_muni[$id_muni]['ref'];

                $punto['lon']    = $a_datos_muni[$id_muni]['lon'];
                $punto['lat']    = $a_datos_muni[$id_muni]['lat'];
                $punto['rank'] = $rank++;  //Para sobreposiciones
                $punto['fuente'] = $tipo_vi; //Para diferenciar la capa
                $a_puntos[$id_muni]=$punto;

            }
            //dd($a_puntos);
            $geojson = entrevista_individual::convertir_geojson($a_puntos);
            $geojson['tipo']=$tipo_lugar;
            $geojson['max']=$a_max[$id_capa];
            if($id_capa==0) {
                $geojson['color']="#FF0000";  //Rojo para el total
            }
            else {
                $geojson['color']=$a_capas_color[$id_capa];
            }

            $a_final[$id_capa]=$geojson;
        }

        return $a_final;

    }


    //Información del exilio
    public static function stats_exilio($filtros=null)
    {
        //Esto lo uso muchas veces
        $base = new \stdClass();
        $base->categorias = array();
        $base->datos = array();
        $base->grafico = array();


        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad de fichas de exilio
        $respuesta->total = 0;

        // Se reconoce como
        $respuesta->reconoce = clone $base; //Se reconoce como
        //DAtos de primera salida
        $respuesta->salida = new \stdClass();
        $respuesta->salida->motivos = clone $base; //Motivo de la salida
        $respuesta->salida->modalidad = clone $base; //Motivo de la salida
        $respuesta->salida->anio = clone $base; //Motivo de la salida
        $respuesta->salida->lugar_salida = clone $base; //Motivo de la salida
        $respuesta->salida->lugar_llegada = clone $base; //Motivo de la salida
        $respuesta->salida->lugar_asentamiento = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_solicita = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_estado = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_si = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_no = clone $base; //Motivo de la salida
        $respuesta->salida->residencia = clone $base; //Motivo de la salida
        $respuesta->salida->expulsion = clone $base; //Motivo de la salida
        //Datos de reasentamientos
        //$respuesta->reasentamientos = clone $respuesta->salida;
        $respuesta->reasentamientos = new \stdClass();
        $respuesta->reasentamientos->motivos = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->modalidad = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->anio = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->lugar_salida = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->lugar_llegada = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->lugar_asentamiento = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_solicita = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_estado = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_si = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_no = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->residencia = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->expulsion = clone $base; //Motivo de la salida
        //Datos de retorno
        $respuesta->retorno = new \stdClass();
        $respuesta->retorno->ha_retornado = clone $base; //Ha retornado
        $respuesta->retorno->ha_tenido_si = clone $base; //Porqué retornó
        $respuesta->retorno->ha_tenido_no = clone $base; //Porque no ha retornado
        $respuesta->retorno->modalidad = clone $base; //Modalidad de retorno
        $respuesta->retorno->anio = clone $base; //Año del retorno
        $respuesta->retorno->lugar_salida = clone $base; //Lugar de salida
        $respuesta->retorno->lugar_llegada = clone $base; //Lugar de llegada
        $respuesta->retorno->otro_exilio = clone $base; //Ha tenido otro exilio
        //Impactos
        $respuesta->impactos=array();





        //Query Base: aplicar filtros parejo.  Conteo de violencias.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.exilio','e_ind_fvt.id_e_ind_fvt','=','exilio.id_e_ind_fvt') //Que tenga exilio
            ->join('fichas.exilio_movimiento','exilio.id_exilio','=','exilio_movimiento.id_exilio'); //que tenga algun movimiento (salida)

        //Filtros de violencia, persistirlos en query_base.
        self::procesar_filtros_fichas_por_entrevista($query_base,$filtros); //Caso especial, el filtro por hecho, duplica las fichas de exilio

        $debug['sql']=$query_base->toSql();
        $debug['criterios']=$query_base->getBindings();
        //dd($debug);





        //Total de fichas de exilio
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1);
        $respuesta->total = $query->count();

        //Se reconoce como
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->join('fichas.exilio_categoria','exilio.id_exilio', '=','exilio_categoria.id_exilio');
        $res = self::query_simple($query,'exilio_categoria.id_categoria');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_reconoce";
        $respuesta->reconoce->categorias =  $res->categorias;
        $respuesta->reconoce->datos = $res->valores;
        $respuesta->reconoce->grafico = graficador::g_columna($g);

        // ---------------PRIMERA SALIDA
        //Motivos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_motivo.id_motivo');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_motivo";
        $respuesta->salida->motivos->categorias =  $res->categorias;
        $respuesta->salida->motivos->datos = $res->valores;
        $respuesta->salida->motivos->grafico = graficador::g_barra($g);

        //Modalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_modalidad');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_modalidad";
        $respuesta->salida->modalidad->categorias =  $res->categorias;
        $respuesta->salida->modalidad->datos = $res->valores;
        $respuesta->salida->modalidad->grafico = graficador::g_columna($g);

        //Año de salida
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $query->where('exilio_movimiento.fecha_salida_a','>',1900);
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.fecha_salida_a');

        //Llenar arreglo con todos los años y con valor 0 si no tienen información
        $tmp=array();
        foreach($res->categorias as $var => $val) {
            $tmp[]=(integer)$var;
        }
        $a = collect($tmp);
        $min = $a->min();
        $max = $a->max();
        $anios = range($min,$max);
        //dd($anios);
        unset($res->categorias);
        foreach($anios as $anio) {
            $res->categorias[(integer)$anio]=(integer)$anio;
            $res->valores[(integer)$anio]= isset($res->valores[(integer)$anio]) ? $res->valores[(integer)$anio] : 0;
        }
        ksort($res->valores);
        //dd($res);
        //Fin del arreglo de años
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_anio";
        $respuesta->salida->anio->categorias =  $res->categorias;
        $respuesta->salida->anio->datos = $res->valores;
        $respuesta->salida->anio->grafico = graficador::g_area($g);
        //dd($respuesta->salida->anio);




        //Lugar de salida: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_salida = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_salida = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_salida = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_salida = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_lugar";
        //Respuesta
        $respuesta->salida->lugar_salida->categorias = $categorias;
        $respuesta->salida->lugar_salida->datos = $x;
        $respuesta->salida->lugar_salida->grafico = graficador::g_barra($g);


        //Lugar de llegada: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_lugar_ll";
        //Respuesta
        $respuesta->salida->lugar_llegada->categorias = $categorias;
        $respuesta->salida->lugar_llegada->datos = $x;
        $respuesta->salida->lugar_llegada->grafico = graficador::g_barra($g);

        //Lugar de asentamiento: por n2
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada_2 = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada_2 = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada_2 = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada_2 = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            unset($categorias[-1]);

        }
        if(isset($categorias[0])) {
            unset($categorias[0]);
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_lugar_ll_as";
        //Respuesta
        $respuesta->salida->lugar_asentamiento->categorias = $categorias;
        $respuesta->salida->lugar_asentamiento->datos = $x;
        $respuesta->salida->lugar_asentamiento->grafico = graficador::g_barra($g);

        //Solicita proteccion
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $query->join('fichas.exilio_movimiento_proteccion','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_proteccion.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_proteccion.id_proteccion');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_solicitado";
        $respuesta->salida->proteccion_solicita->categorias =  $res->categorias;
        $respuesta->salida->proteccion_solicita->datos = $res->valores;
        $respuesta->salida->proteccion_solicita->grafico = graficador::g_columna($g);

        //Estado de la solicitud
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_estado_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_estado";
        $respuesta->salida->proteccion_estado->categorias =  $res->categorias;
        $respuesta->salida->proteccion_estado->datos = $res->valores;
        $respuesta->salida->proteccion_estado->grafico = graficador::g_columna($g);

        //Aprobada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_aprobada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_si";
        $respuesta->salida->proteccion_si->categorias =  $res->categorias;
        $respuesta->salida->proteccion_si->datos = $res->valores;
        $respuesta->salida->proteccion_si->grafico = graficador::g_columna($g);

        //Denegada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_denegada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_no";
        $respuesta->salida->proteccion_no->categorias =  $res->categorias;
        $respuesta->salida->proteccion_no->datos = $res->valores;
        $respuesta->salida->proteccion_no->grafico = graficador::g_columna($g);


        //Residencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_residencia_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_residencia";
        $respuesta->salida->residencia->categorias =  $res->categorias;
        $respuesta->salida->residencia->datos = $res->valores;
        $respuesta->salida->residencia->grafico = graficador::g_columna($g);

        //Expulsión
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_expulsion',2);
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_expulsion";
        $respuesta->salida->expulsion->categorias =  $res->categorias;
        $respuesta->salida->expulsion->datos = $res->valores;
        $respuesta->salida->expulsion->grafico = graficador::g_columna($g);




        // ---------------Reasentamiento
        //Motivos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_motivo.id_motivo');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_motivo";
        $respuesta->reasentamientos->motivos->categorias =  $res->categorias;
        $respuesta->reasentamientos->motivos->datos = $res->valores;
        $respuesta->reasentamientos->motivos->grafico = graficador::g_barra($g);

        //Modalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_modalidad');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_modalidad";
        $respuesta->reasentamientos->modalidad->categorias =  $res->categorias;
        $respuesta->reasentamientos->modalidad->datos = $res->valores;
        $respuesta->reasentamientos->modalidad->grafico = graficador::g_columna($g);



        //Año de salida
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $query->where('exilio_movimiento.fecha_salida_a','>',1900);
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.fecha_salida_a');
        //Llenar arreglo con todos los años y con valor 0 si no tienen información
        $tmp=array();
        foreach($res->categorias as $var => $val) {
            $tmp[]=$var;
        }
        $a = collect($tmp);
        $min = $a->min();
        $max = $a->max();
        $anios = range($min,$max);
        foreach($anios as $anio) {
            $res->categorias[$anio]=$anio;
            $res->valores[$anio]= isset($res->valores[$anio]) ? $res->valores[$anio] : 0;
        }
        ksort($res->categorias);
        //Fin del arreglo de años
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_anio";

        $respuesta->reasentamientos->anio->categorias =  $res->categorias;
        $respuesta->reasentamientos->anio->datos = $res->valores;
        $respuesta->reasentamientos->anio->grafico = graficador::g_area($g);






        //Lugar de salida: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_salida = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_salida = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_salida = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_salida = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_lugar";
        //Respuesta
        $respuesta->reasentamientos->lugar_salida->categorias = $categorias;
        $respuesta->reasentamientos->lugar_salida->datos = $x;
        $respuesta->reasentamientos->lugar_salida->grafico = graficador::g_barra($g);


        //Lugar de llegada: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_lugar_ll";
        //Respuesta
        $respuesta->reasentamientos->lugar_llegada->categorias = $categorias;
        $respuesta->reasentamientos->lugar_llegada->datos = $x;
        $respuesta->reasentamientos->lugar_llegada->grafico = graficador::g_barra($g);

        //Lugar de asentamiento: por n2
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada_2 = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada_2 = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada_2 = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada_2 = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            unset($categorias[-1]);

        }
        if(isset($categorias[0])) {
            unset($categorias[0]);
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_lugar_ll_as";
        //Respuesta
        $respuesta->reasentamientos->lugar_asentamiento->categorias = $categorias;
        $respuesta->reasentamientos->lugar_asentamiento->datos = $x;
        $respuesta->reasentamientos->lugar_asentamiento->grafico = graficador::g_barra($g);

        //Solicita proteccion
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $query->join('fichas.exilio_movimiento_proteccion','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_proteccion.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_proteccion.id_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_solicitado";
        $respuesta->reasentamientos->proteccion_solicita->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_solicita->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_solicita->grafico = graficador::g_columna($g);

        //Estado de la solicitud
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_estado_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_estado";
        $respuesta->reasentamientos->proteccion_estado->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_estado->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_estado->grafico = graficador::g_columna($g);

        //Aprobada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_aprobada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_si";
        $respuesta->reasentamientos->proteccion_si->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_si->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_si->grafico = graficador::g_columna($g);

        //Denegada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_denegada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_no";
        $respuesta->reasentamientos->proteccion_no->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_no->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_no->grafico = graficador::g_columna($g);


        //Residencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_residencia_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_residencia";
        $respuesta->reasentamientos->residencia->categorias =  $res->categorias;
        $respuesta->reasentamientos->residencia->datos = $res->valores;
        $respuesta->reasentamientos->residencia->grafico = graficador::g_columna($g);

        //Expulsión
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        unset($res->categorias[0]);
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_expulsion',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_expulsion";
        $respuesta->reasentamientos->expulsion->categorias =  $res->categorias;
        $respuesta->reasentamientos->expulsion->datos = $res->valores;
        $respuesta->reasentamientos->expulsion->grafico = graficador::g_columna($g);



        //-------------Retorno

        //Ha retornado
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio.id_retorno',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_retorno";
        $respuesta->retorno->ha_retornado->categorias =  $res->categorias;
        $respuesta->retorno->ha_retornado->datos = $res->valores;
        $respuesta->retorno->ha_retornado->grafico = graficador::g_barra($g);

        //Modalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_modalidad');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_modalidad";
        $respuesta->retorno->modalidad->categorias =  $res->categorias;
        $respuesta->retorno->modalidad->datos = $res->valores;
        $respuesta->retorno->modalidad->grafico = graficador::g_columna($g);




        //Impactos
        $impactos_i = [212,213];
        $pq=array();

        foreach($impactos_i as $id_cat) {
            $query = clone $query_base;
            $query->where('exilio_movimiento.id_tipo_movimiento',3); //Reasentamiento
            $query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
            $query->join('catalogos.cat_item','exilio_movimiento_motivo.id_motivo','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            unset($res->categorias[0]);
            $pq[$id_cat] = $res;
        }
        if(isset($pq[212])) {
            $g = new \stdClass();  //Para el gráfico
            $g->categorias = $pq[212]->categorias;
            $g->a_serie[] = $pq[212]->valores;
            $g->nombre_serie[]="Fichas de exilio";
            $g->descarga="exilio_si_retorna";
            $respuesta->retorno->ha_tenido_si->categorias =  $res->categorias;
            $respuesta->retorno->ha_tenido_si->datos = $res->valores;
            $respuesta->retorno->ha_tenido_si->grafico = graficador::g_columna($g);
        }


        if(isset($pq[213])) {
            $g = new \stdClass();  //Para el gráfico
            $g->categorias = $pq[213]->categorias;
            $g->a_serie[] = $pq[213]->valores;
            $g->nombre_serie[]="Fichas de exilio";
            $g->descarga="exilio_no_retorna";
            $respuesta->retorno->ha_tenido_no->categorias =  $res->categorias;
            $respuesta->retorno->ha_tenido_no->datos = $res->valores;
            $respuesta->retorno->ha_tenido_no->grafico = graficador::g_columna($g);
        }




        //Año de salida
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        $query->where('exilio_movimiento.fecha_salida_a','>',1900);
        $res = self::query_simple($query,'exilio_movimiento.fecha_salida_a');
        //Llenar arreglo con todos los años y con valor 0 si no tienen información
        $tmp=array();
        foreach($res->categorias as $var => $val) {
            $tmp[]=$var;
        }
        $a = collect($tmp);
        $min = $a->min();
        $max = $a->max();
        $anios = range($min,$max);
        foreach($anios as $anio) {
            $res->categorias[$anio]=$anio;
            $res->valores[$anio]= isset($res->valores[$anio]) ? $res->valores[$anio] : 0;
        }
        ksort($res->categorias);
        //Fin del arreglo de años
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_anio";
        $respuesta->retorno->anio->categorias =  $res->categorias;
        $respuesta->retorno->anio->datos = $res->valores;
        $respuesta->retorno->anio->grafico = graficador::g_area($g);




        //Lugar de salida: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_salida = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_salida = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_salida = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_salida = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_lugar";
        //Respuesta
        $respuesta->retorno->lugar_salida->categorias = $categorias;
        $respuesta->retorno->lugar_salida->datos = $x;
        $respuesta->retorno->lugar_salida->grafico = graficador::g_barra($g);


        //Lugar de llegada: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_lugar_ll";
        //Respuesta
        $respuesta->retorno->lugar_llegada->categorias = $categorias;
        $respuesta->retorno->lugar_llegada->datos = $x;
        $respuesta->retorno->lugar_llegada->grafico = graficador::g_barra($g);



        //Volvió a exiliarse
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Para que no se multipliue por el join a movimientos
        $res = self::query_simple($query,'exilio.id_otro_exilio',2);
        //unset($res->categorias[0]);

        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_otro_exilio";
        $respuesta->retorno->otro_exilio->categorias =  $res->categorias;
        $respuesta->retorno->otro_exilio->datos = $res->valores;
        $respuesta->retorno->otro_exilio->grafico = graficador::g_columna($g);


        //Impactos
        $impactos = [208,209,210,211,214,215];

        foreach($impactos as $id_cat) {
            $query = clone $query_base;
            $query->where('exilio_movimiento.id_tipo_movimiento',1); //Para que no se multipliue por el join a movimientos
            $query->join('fichas.exilio_impacto','exilio.id_exilio', '=','exilio_impacto.id_exilio');
            $query->join('catalogos.cat_item','exilio_impacto.id_impacto','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            $res->descripcion = cat_cat::describir($id_cat);
            $respuesta->impactos[$id_cat] = $res;
        }

        //dd($respuesta->salida->lugar_asentamiento);




        ////////////
        return $respuesta;

    }
    //Información del exilio, versión ajax
    public static function json_exilio($filtros=null)
    {
        //Esto lo uso muchas veces
        $base = new \stdClass();
        $base->categorias = array();
        $base->datos = array();
        $base->grafico = array();


        //Estructura de la respuesta
        $respuesta = new \stdClass();
        //Cantidad de fichas de exilio
        $respuesta->total = 0;

        // Se reconoce como
        $respuesta->reconoce = clone $base; //Se reconoce como
        $respuesta->movimientos = clone $base; //Registros de salida, reasentamiento, retorno
        //DAtos de primera salida
        $respuesta->salida = new \stdClass();
        $respuesta->salida->motivos = clone $base; //Motivo de la salida
        $respuesta->salida->modalidad = clone $base; //Motivo de la salida
        $respuesta->salida->anio = clone $base; //Motivo de la salida
        $respuesta->salida->lugar_salida = clone $base; //Motivo de la salida
        $respuesta->salida->lugar_llegada = clone $base; //Motivo de la salida
        $respuesta->salida->lugar_asentamiento = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_solicita = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_estado = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_si = clone $base; //Motivo de la salida
        $respuesta->salida->proteccion_no = clone $base; //Motivo de la salida
        $respuesta->salida->residencia = clone $base; //Motivo de la salida
        $respuesta->salida->expulsion = clone $base; //Motivo de la salida
        //Datos de reasentamientos
        //$respuesta->reasentamientos = clone $respuesta->salida;
        $respuesta->reasentamientos = new \stdClass();
        $respuesta->reasentamientos->motivos = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->modalidad = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->anio = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->lugar_salida = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->lugar_llegada = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->lugar_asentamiento = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_solicita = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_estado = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_si = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->proteccion_no = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->residencia = clone $base; //Motivo de la salida
        $respuesta->reasentamientos->expulsion = clone $base; //Motivo de la salida
        //Datos de retorno
        $respuesta->retorno = new \stdClass();
        $respuesta->retorno->ha_retornado = clone $base; //Ha retornado
        $respuesta->retorno->ha_tenido_si = clone $base; //Porqué retornó
        $respuesta->retorno->ha_tenido_no = clone $base; //Porque no ha retornado
        $respuesta->retorno->modalidad = clone $base; //Modalidad de retorno
        $respuesta->retorno->anio = clone $base; //Año del retorno
        $respuesta->retorno->lugar_salida = clone $base; //Lugar de salida
        $respuesta->retorno->lugar_llegada = clone $base; //Lugar de llegada
        $respuesta->retorno->otro_exilio = clone $base; //Ha tenido otro exilio
        //Impactos
        $respuesta->impactos=array();





        //Query Base: aplicar filtros parejo.  Conteo de violencias.
        $query_base = entrevista_individual::filtrar($filtros)
            ->join('fichas.exilio','e_ind_fvt.id_e_ind_fvt','=','exilio.id_e_ind_fvt') //Que tenga exilio
            ->join('fichas.exilio_movimiento','exilio.id_exilio','=','exilio_movimiento.id_exilio'); //que tenga algun movimiento (salida)



        //Filtros de violencia, persistirlos en query_base.
        self::procesar_filtros_fichas_por_entrevista($query_base,$filtros); //Caso especial, el filtro por hecho, duplica las fichas de exilio

        //dd($query_base->toSql());

        //total de fichas
        $query = clone $query_base;
        //$respuesta->total= $query->count();
        $debug['sql']=$query->toSql();
        $debug['criterios']=$query->getBindings();
        //dd($debug);


        //Se reconoce como
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('id_tipo_movimiento',1);
        $query->join('fichas.exilio_categoria','exilio.id_exilio', '=','exilio_categoria.id_exilio');
        $res = self::query_simple($query,'exilio_categoria.id_categoria');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_reconoce";
        $respuesta->reconoce->categorias =  $res->categorias;
        $respuesta->reconoce->datos = $res->valores;
        $respuesta->reconoce->grafico = graficador::g_barra($g);

        //Movimientos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $salida = $query->where('id_tipo_movimiento',1)
                        ->count();
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $reasentamiento = $query->where('id_tipo_movimiento',2)
                            ->count();
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $retorno = $query->where('id_tipo_movimiento',3)
                        ->count();

        $valores[1]=$salida;
        $valores[2]=$reasentamiento;
        $valores[3]=$retorno;
        $categorias = [1=>'Salida de Colombia', 2=>'Reasentamiento', 3=>'Retorno'];


        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $categorias;
        $g->a_serie[] = $valores;
        $g->nombre_serie[]="Registro de movimientos";
        $g->descarga="exilio_movimientos";
        $respuesta->movimientos->categorias =  $categorias;
        $respuesta->movimientos->datos = $valores;
        $respuesta->movimientos->grafico = graficador::g_barra($g);





        // ---------------PRIMERA SALIDA
        //Motivos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_motivo.id_motivo');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_motivo";
        $respuesta->salida->motivos->categorias =  $res->categorias;
        $respuesta->salida->motivos->datos = $res->valores;
        $respuesta->salida->motivos->grafico = graficador::g_barra($g);

        //Modalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_modalidad');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_modalidad";
        $respuesta->salida->modalidad->categorias =  $res->categorias;
        $respuesta->salida->modalidad->datos = $res->valores;
        $respuesta->salida->modalidad->grafico = graficador::g_pie($g);

        //Año de salida
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $query->where('exilio_movimiento.fecha_salida_a','>',1900);
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.fecha_salida_a');

        //Llenar arreglo con todos los años y con valor 0 si no tienen información
        $tmp=array();
        foreach($res->categorias as $var => $val) {
            $tmp[]=(integer)$var;
        }
        $a = collect($tmp);
        $min = $a->min();
        $max = $a->max();
        $anios = range($min,$max);
        //dd($anios);
        unset($res->categorias);
        foreach($anios as $anio) {
            $res->categorias[(integer)$anio]=(integer)$anio;
            $res->valores[(integer)$anio]= isset($res->valores[(integer)$anio]) ? $res->valores[(integer)$anio] : 0;
        }
        ksort($res->valores);
        //dd($res);
        //Fin del arreglo de años
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_anio";
        $respuesta->salida->anio->categorias =  $res->categorias;
        $respuesta->salida->anio->datos = $res->valores;
        $respuesta->salida->anio->grafico = graficador::g_area($g);
        //dd($respuesta->salida->anio);




        //Lugar de salida: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_salida = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_salida = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_salida = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_salida = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_lugar";
        //Respuesta
        $respuesta->salida->lugar_salida->categorias = $categorias;
        $respuesta->salida->lugar_salida->datos = $x;
        $respuesta->salida->lugar_salida->grafico = graficador::g_barra($g);


        //Lugar de llegada: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_lugar_ll";
        //Respuesta
        $respuesta->salida->lugar_llegada->categorias = $categorias;
        $respuesta->salida->lugar_llegada->datos = $x;
        $respuesta->salida->lugar_llegada->grafico = graficador::g_barra($g);

        //Lugar de asentamiento: por n2
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada_2 = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada_2 = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada_2 = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada_2 = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            unset($categorias[-1]);

        }
        if(isset($categorias[0])) {
            unset($categorias[0]);
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_lugar_ll_as";
        //Respuesta
        $respuesta->salida->lugar_asentamiento->categorias = $categorias;
        $respuesta->salida->lugar_asentamiento->datos = $x;
        $respuesta->salida->lugar_asentamiento->grafico = graficador::g_barra($g);

        //Solicita proteccion
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        $query->join('fichas.exilio_movimiento_proteccion','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_proteccion.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_proteccion.id_proteccion');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_solicitado";
        $respuesta->salida->proteccion_solicita->categorias =  $res->categorias;
        $respuesta->salida->proteccion_solicita->datos = $res->valores;
        $respuesta->salida->proteccion_solicita->grafico = graficador::g_columna($g);

        //Estado de la solicitud
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_estado_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_estado";
        $respuesta->salida->proteccion_estado->categorias =  $res->categorias;
        $respuesta->salida->proteccion_estado->datos = $res->valores;
        $respuesta->salida->proteccion_estado->grafico = graficador::g_pie($g);

        //Aprobada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_aprobada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_si";
        $respuesta->salida->proteccion_si->categorias =  $res->categorias;
        $respuesta->salida->proteccion_si->datos = $res->valores;
        $respuesta->salida->proteccion_si->grafico = graficador::g_pie($g);

        //Denegada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_denegada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_proteccion_no";
        $respuesta->salida->proteccion_no->categorias =  $res->categorias;
        $respuesta->salida->proteccion_no->datos = $res->valores;
        $respuesta->salida->proteccion_no->grafico = graficador::g_pie($g);


        //Residencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_residencia_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_residencia";
        $respuesta->salida->residencia->categorias =  $res->categorias;
        $respuesta->salida->residencia->datos = $res->valores;
        $respuesta->salida->residencia->grafico = graficador::g_pie($g);

        //Expulsión
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Primera salida
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_expulsion',2);
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_salida_expulsion";
        $respuesta->salida->expulsion->categorias =  $res->categorias;
        $respuesta->salida->expulsion->datos = $res->valores;
        $respuesta->salida->expulsion->grafico = graficador::g_pie($g);




        // ---------------Reasentamiento
        //Motivos
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_motivo.id_motivo');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_motivo";
        $respuesta->reasentamientos->motivos->categorias =  $res->categorias;
        $respuesta->reasentamientos->motivos->datos = $res->valores;
        $respuesta->reasentamientos->motivos->grafico = graficador::g_barra($g);

        //Modalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_modalidad');
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_modalidad";
        $respuesta->reasentamientos->modalidad->categorias =  $res->categorias;
        $respuesta->reasentamientos->modalidad->datos = $res->valores;
        $respuesta->reasentamientos->modalidad->grafico = graficador::g_pie($g);



        //Año de salida
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $query->where('exilio_movimiento.fecha_salida_a','>',1900);
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.fecha_salida_a');
        //Llenar arreglo con todos los años y con valor 0 si no tienen información
        $tmp=array();
        foreach($res->categorias as $var => $val) {
            $tmp[]=$var;
        }
        $a = collect($tmp);
        $min = $a->min();
        $max = $a->max();
        $anios = range($min,$max);
        foreach($anios as $anio) {
            $res->categorias[$anio]=$anio;
            $res->valores[$anio]= isset($res->valores[$anio]) ? $res->valores[$anio] : 0;
        }
        ksort($res->categorias);
        //Fin del arreglo de años
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_anio";

        $respuesta->reasentamientos->anio->categorias =  $res->categorias;
        $respuesta->reasentamientos->anio->datos = $res->valores;
        $respuesta->reasentamientos->anio->grafico = graficador::g_area($g);






        //Lugar de salida: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_salida = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_salida = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_salida = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_salida = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_lugar";
        //Respuesta
        $respuesta->reasentamientos->lugar_salida->categorias = $categorias;
        $respuesta->reasentamientos->lugar_salida->datos = $x;
        $respuesta->reasentamientos->lugar_salida->grafico = graficador::g_barra($g);


        //Lugar de llegada: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_lugar_ll";
        //Respuesta
        $respuesta->reasentamientos->lugar_llegada->categorias = $categorias;
        $respuesta->reasentamientos->lugar_llegada->datos = $x;
        $respuesta->reasentamientos->lugar_llegada->grafico = graficador::g_barra($g);

        //Lugar de asentamiento: por n2
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada_2 = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada_2 = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada_2 = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada_2 = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            unset($categorias[-1]);

        }
        if(isset($categorias[0])) {
            unset($categorias[0]);
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_lugar_ll_as";
        //Respuesta
        $respuesta->reasentamientos->lugar_asentamiento->categorias = $categorias;
        $respuesta->reasentamientos->lugar_asentamiento->datos = $x;
        $respuesta->reasentamientos->lugar_asentamiento->grafico = graficador::g_barra($g);

        //Solicita proteccion
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        $query->join('fichas.exilio_movimiento_proteccion','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_proteccion.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento_proteccion.id_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_solicitado";
        $respuesta->reasentamientos->proteccion_solicita->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_solicita->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_solicita->grafico = graficador::g_barra($g);

        //Estado de la solicitud
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_estado_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_estado";
        $respuesta->reasentamientos->proteccion_estado->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_estado->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_estado->grafico = graficador::g_pie($g);

        //Aprobada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_aprobada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_si";
        $respuesta->reasentamientos->proteccion_si->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_si->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_si->grafico = graficador::g_pie($g);

        //Denegada
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_denegada_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_proteccion_no";
        $respuesta->reasentamientos->proteccion_no->categorias =  $res->categorias;
        $respuesta->reasentamientos->proteccion_no->datos = $res->valores;
        $respuesta->reasentamientos->proteccion_no->grafico = graficador::g_pie($g);


        //Residencia
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_residencia_proteccion');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_residencia";
        $respuesta->reasentamientos->residencia->categorias =  $res->categorias;
        $respuesta->reasentamientos->residencia->datos = $res->valores;
        $respuesta->reasentamientos->residencia->grafico = graficador::g_pie($g);

        //Expulsión
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',2); //Reasentamiento
        unset($res->categorias[0]);
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_expulsion',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_rea_expulsion";
        $respuesta->reasentamientos->expulsion->categorias =  $res->categorias;
        $respuesta->reasentamientos->expulsion->datos = $res->valores;
        $respuesta->reasentamientos->expulsion->grafico = graficador::g_pie($g);



        //-------------Retorno

        //Ha retornado
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Reasentamiento
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio.id_retorno',2);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_retorno";
        $respuesta->retorno->ha_retornado->categorias =  $res->categorias;
        $respuesta->retorno->ha_retornado->datos = $res->valores;
        $respuesta->retorno->ha_retornado->grafico = graficador::g_pie($g);

        //Modalidad
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        //$query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
        $res = self::query_simple($query,'exilio_movimiento.id_modalidad');
        unset($res->categorias[0]);
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_modalidad";
        $respuesta->retorno->modalidad->categorias =  $res->categorias;
        $respuesta->retorno->modalidad->datos = $res->valores;
        $respuesta->retorno->modalidad->grafico = graficador::g_pie($g);




        //Impactos
        $impactos_i = [212,213];
        $pq=array();

        foreach($impactos_i as $id_cat) {
            $query = clone $query_base;
            $query->where('exilio_movimiento.id_tipo_movimiento',3); //Reasentamiento
            $query->join('fichas.exilio_movimiento_motivo','exilio_movimiento.id_exilio_movimiento', '=','exilio_movimiento_motivo.id_exilio_movimiento');
            $query->join('catalogos.cat_item','exilio_movimiento_motivo.id_motivo','=','cat_item.id_item')
                ->where('cat_item.id_cat',$id_cat);
            $res = self::query_simple($query,'cat_item.id_item');
            unset($res->categorias[0]);
            $pq[$id_cat] = clone $res;
        }

        if(isset($pq[212])) {
            $g = new \stdClass();  //Para el gráfico
            $g->categorias = $pq[212]->categorias;
            $g->a_serie[] = $pq[212]->valores;
            $g->nombre_serie[]="Fichas de exilio";
            $g->descarga="exilio_si_retorna";
            $respuesta->retorno->ha_tenido_si->categorias =  $pq[212]->categorias;
            $respuesta->retorno->ha_tenido_si->datos = $pq[212]->valores;
            $respuesta->retorno->ha_tenido_si->grafico = graficador::g_columna($g);
        }

        if(isset($pq[213])) {
            $g = new \stdClass();  //Para el gráfico
            $g->categorias = $pq[213]->categorias;
            $g->a_serie[] = $pq[213]->valores;
            $g->nombre_serie[]="Fichas de exilio";
            $g->descarga="exilio_no_retorna";
            $respuesta->retorno->ha_tenido_no->categorias =  $pq[213]->categorias;
            $respuesta->retorno->ha_tenido_no->datos = $pq[213]->valores;
            $respuesta->retorno->ha_tenido_no->grafico = graficador::g_columna($g);
        }
        //dd($pq[213]);




        //Año de salida
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        $query->where('exilio_movimiento.fecha_salida_a','>',1900);
        $res = self::query_simple($query,'exilio_movimiento.fecha_salida_a');
        //Llenar arreglo con todos los años y con valor 0 si no tienen información
        $tmp=array();
        foreach($res->categorias as $var => $val) {
            $tmp[]=$var;
        }
        $a = collect($tmp);
        $min = $a->min();
        $max = $a->max();
        $anios = range($min,$max);
        foreach($anios as $anio) {
            $res->categorias[$anio]=$anio;
            $res->valores[$anio]= isset($res->valores[$anio]) ? $res->valores[$anio] : 0;
        }
        ksort($res->categorias);
        //Fin del arreglo de años
        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_anio";
        $respuesta->retorno->anio->categorias =  $res->categorias;
        $respuesta->retorno->anio->datos = $res->valores;
        $respuesta->retorno->anio->grafico = graficador::g_area($g);




        //Lugar de salida: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_salida = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_salida = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_salida = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_salida = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n2 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_lugar";
        //Respuesta
        $respuesta->retorno->lugar_salida->categorias = $categorias;
        $respuesta->retorno->lugar_salida->datos = $x;
        $respuesta->retorno->lugar_salida->grafico = graficador::g_barra($g);


        //Lugar de llegada: por departamento
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',3); //Retorno
        $res = $query->orderby('exilio_movimiento.id_exilio_movimiento')->pluck('exilio_movimiento.id_exilio_movimiento')->toArray();
        $universo = count($res) > 0 ? implode(",",$res) : '-1';

        $sql = "select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, n3.id_geo as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n3 on h.id_lugar_llegada = n3.id_geo and n3.nivel =3
                            join catalogos.geo as n2 on n3.id_padre = n2.id_geo
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3

                    union 
                select n1.id_geo as id_geo_n1, n2.id_geo as id_geo_n2, 0 as id_geo_n3, count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n2 on h.id_lugar_llegada = n2.id_geo and n2.nivel =2                        
                            join catalogos.geo as n1 on n2.id_padre = n1.id_geo
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union 
                select n1.id_geo as id_geo_n1, 0 as id_geo_n2, 0 as id_geo_n3,  count(1) as conteo
                        from fichas.exilio_movimiento h
                            join catalogos.geo as n1 on h.id_lugar_llegada = n1.id_geo and n1.nivel =1                                                    
                        where h.id_exilio_movimiento in ($universo)
                        group by 1,2,3
                    union
                select 0 as id_geo_n1,  0 as id_geo_n2, 0 as id_geo_n3,   count(1) as conteo
                        from fichas.exilio_movimiento h
                            left join catalogos.geo as g on h.id_lugar_llegada = g.id_geo                                           
                        where h.id_exilio_movimiento in ($universo) and g.id_geo is null
                        group by 1,2,3
                ";
        $sql2 = "select id_geo_n1 as var, sum(conteo) as val
                    from ($sql) as unidos
                    group by 1
                    order by 2 desc
                    ";
        $res  = \DB::select($sql2);
        $x=array();
        $categorias = array();
        foreach($res as $fila) {
            $x[(integer)$fila->var] = (integer)$fila->val;
            $categorias[(integer)$fila->var] = geo::nombrar($fila->var);
        }
        if(isset($categorias[-1])) {
            $categorias[-1] = "Sin especificar";
        }
        if(isset($categorias[0])) {
            $categorias[0] = "Sin especificar";
        }
        //Para el gráfico
        $g = new \stdClass();
        $g->categorias = $categorias;
        $g->a_serie[] = $x;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_ret_lugar_ll";
        //Respuesta
        $respuesta->retorno->lugar_llegada->categorias = $categorias;
        $respuesta->retorno->lugar_llegada->datos = $x;
        $respuesta->retorno->lugar_llegada->grafico = graficador::g_barra($g);



        //Volvió a exiliarse
        $query = clone $query_base;  //Para quitar lo que le hayan agregado antes
        $query->where('exilio_movimiento.id_tipo_movimiento',1); //Para que no se multipliue por el join a movimientos
        $res = self::query_simple($query,'exilio.id_otro_exilio',2);
        //unset($res->categorias[0]);

        $g = new \stdClass();  //Para el gráfico
        $g->categorias = $res->categorias;
        $g->a_serie[] = $res->valores;
        $g->nombre_serie[]="Fichas de exilio";
        $g->descarga="exilio_otro_exilio";
        $respuesta->retorno->otro_exilio->categorias =  $res->categorias;
        $respuesta->retorno->otro_exilio->datos = $res->valores;
        $respuesta->retorno->otro_exilio->grafico = graficador::g_pie($g);




        //dd($respuesta->salida->lugar_asentamiento);




        ////////////
        return $respuesta;

    }

    /*
     * Ejecutar query para un select group_by de un campo
     */

    //Para no hacer tanto copy + paste.  Hace un query agrupado por un valor
    // En el query viene las tablas, join y filtros necesarios
    //$criterio_fijo a cero, significa que usa cat_item
    public static function query_simple($query, $campo='persona.id_etnia_indigena', $criterio_fijo=0, $debug=false) {
         $query->selectraw(\DB::raw("$campo as var, count(1) as val"))
            ->groupby($campo)
            ->orderby('val','desc');
        if($debug==20) {
            dd(self::debug_query($query));
        }
        $res =$query->get();
        $x=array();
        $categorias=array();
        foreach($res as $fila) {
            $id = $fila->var > 0 ? (integer)$fila->var : 0;
            if($criterio_fijo==0) {
                $txt = $id > 0 ? cat_item::describir($id) : "Sin especificar";
            }
            else {
                $txt = $id > 0 ? criterio_fijo::describir($criterio_fijo, $id) : "Sin especificar";
            }
            $x[$id] = (integer)$fila->val;
            $categorias[$id] = $txt;
        }


        //Para el gráfico
        $r = new \stdClass();
        $r->categorias = $categorias;
        $r->valores = $x;
        return $r;
    }

    //Agrega nuevos scopes, para filtrar graficos de stats de victimas, hechos, etc.
    //Este se utiliza para filtrar hechos, ya que el filtro por entrevista resulta muy amplio para filtrar hechos
    //Esto funciona para victimas pero no para persona entrevistada.  Para persona entrevistada se necesita subquery para que no los multiplique (como lo haría con el join a tipos de violencia)
    public static function procesar_filtros_fichas_por_hechos($query, $filtros) {

        if($filtros->id_excel_listados > 0) {
            $filtros->hay_filtro++; //El scope se aplica en los filtros de la entrevista
        }


        //Filtro de fecha de corte
        if(strlen($filtros->fecha_corte)==10) {
            //usar siempre el mismo tipo de filtrado:
            $corte_hecho = hecho_victima::join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->where('victima.updated_at','<',$filtros->fecha_corte)
                ->distinct()
                ->pluck('hecho_victima.id_hecho');

            $query->wherein('hecho.id_hecho',$corte_hecho);
            /* Versión vieja, cambiada por la anterior
            $existe_join_victima = Collection::make($query->getQuery()->joins)->pluck('table')->contains('victima');
            if($existe_join_victima) {
                $query->where('victima.updated_at','<',$filtros->fecha_corte);
            }
            else {
                $corte_hecho = hecho_victima::join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                    ->where('victima.updated_at','<',$filtros->fecha_corte)
                    ->distinct()
                    ->pluck('hecho_victima.id_hecho');

                $query->wherein('hecho.id_hecho',$corte_hecho);
            }
            */
        }




        //violencia, del
        if($filtros->violencia_anio_del > 1900) {
            $query->where('hecho.fecha_ocurrencia_a','>=',$filtros->violencia_anio_del);
            $filtros->hay_filtro++;
        }
        if($filtros->violencia_anio_al > 1900) {
            $query->where('hecho.fecha_ocurrencia_a','<=',$filtros->violencia_anio_al);
            $filtros->hay_filtro++;
        }
        //Tipo de violencia
        if($filtros->violencia_tipo > 0) {
            //Determinar el nivel
            $where=array();
            $cual = tipo_violencia::find($filtros->violencia_tipo);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro++;
                    $filtros->hay_filtro++;
                }
                else {
                    $where = tipo_violencia::where('id_padre',$filtros->violencia_tipo)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }
                //Aplicar el filtro
                $query->wherein('hecho_violencia.id_subtipo_violencia',$where);

            }
        }
        //Lugar de la violencia
        if($filtros->violencia_lugar > 0) {
            //Determinar el nivel
            $where=geo::arreglo_contenidos($filtros->violencia_lugar);
            //dd($where);
            $query->wherein('hecho.id_lugar',$where);
            $filtros->hay_filtro++;
        }

        //Actores armados
        $ya_join_responsabilidad = false;

        if($filtros->violencia_aa > 0) {

            //Determinar el nivel
            $where=array();
            $cual = tipo_aa::find($filtros->violencia_aa);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro++;
                    $filtros->hay_filtro++;
                }
                else {
                    $where = tipo_aa::where('id_padre',$filtros->violencia_aa)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }


                if(!$ya_join_responsabilidad) {

                    $query->join('fichas.hecho_responsabilidad','hecho.id_hecho','=','hecho_responsabilidad.id_hecho');
                    $ya_join_responsabilidad=true;
                }
                //dd($query->toSql());
                $query->wherein('hecho_responsabilidad.aa_id_subtipo',$where);

            }
        }
        //Terceros civiles
        if($filtros->violencia_tc > 0) {
            //Determinar el nivel
            $where=array();
            $cual = tipo_tc::find($filtros->violencia_tc);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro++;
                    $filtros->hay_filtro++;
                }
                else {
                    $where = tipo_tc::where('id_padre',$filtros->violencia_tc)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }
                if(!$ya_join_responsabilidad) {
                    $query->join('fichas.hecho_responsabilidad','hecho.id_hecho','=','hecho_responsabilidad.id_hecho');
                    $ya_join_responsabilidad=true;
                }
                $query->wherein('hecho_responsabilidad.tc_id_subtipo',$where);
                $filtros->hay_filtro++;
            }
        }

        //Esta funcion se llama en algunos calculos que ya tienen join a victima (stats de victima)
        // Pero también en caclulos que no lo tienen (conteo de hechos)
        //Para ser más exacto, en el que no tiene victima, se usa whereIn.  en el que sí lo tiene, se aplican los filtros directos
        $existe_join_victima = Collection::make($query->getQuery()->joins)->pluck('table')->contains('fichas.victima');
        //dd(self::debug_query($query));

        if(!$existe_join_victima) {
            //Datos de victimas: este query lo uso en c/filtro, asi que lo defino una vez y luego lo clono
            $query_victima = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->join('fichas.persona','victima.id_persona','persona.id_persona');

            if($filtros->vi_id_sexo > 0) {
                $query_tmp = clone $query_victima;
                $query_tmp->where('persona.id_sexo',$filtros->vi_id_sexo);
                //Aplicar filtro
                $filtros->hay_filtro++;
                $where = $query_tmp->pluck('hecho.id_hecho');
                $query->wherein('hecho.id_hecho',$where);
            }
            if($filtros->vi_id_etnia > 0) {
                $query_tmp = clone $query_victima;
                $query_tmp->where('persona.id_etnia',$filtros->vi_id_etnia);
                //Aplicar filtro
                $filtros->hay_filtro++;
                $where = $query_tmp->pluck('hecho.id_hecho');
                $query->wherein('hecho.id_hecho',$where);
            }
            if($filtros->vi_edad_del <> "") {
                $query_tmp = clone $query_victima;
                $query_tmp->where('hecho_victima.edad','>=',$filtros->vi_edad_del);
                //Aplicar filtro
                $filtros->hay_filtro++;
                $where = $query_tmp->pluck('hecho.id_hecho');
                $query->wherein('hecho.id_hecho',$where);
            }
            if($filtros->vi_edad_al <> "") {
                $query_tmp = clone $query_victima;
                $query_tmp->where('hecho_victima.edad','<=',$filtros->vi_edad_al);
                //Aplicar filtro
                $filtros->hay_filtro++;
                $where = $query_tmp->pluck('hecho.id_hecho');
                $query->wherein('hecho.id_hecho',$where);
            }
        }
        else {
            //Posi no esta
            $existe_join_persona = Collection::make($query->getQuery()->joins)->pluck('table')->contains('fichas.persona');

            if($filtros->vi_id_sexo > 0) {
                if(!$existe_join_persona) {
                    $query->join('fichas.persona','victima.id_persona','persona.id_persona');
                }
                $query->where('persona.id_sexo',$filtros->vi_id_sexo);
                $filtros->hay_filtro++;
            }
            if($filtros->vi_id_etnia > 0) {
                if(!$existe_join_persona) {
                    $query->join('fichas.persona','victima.id_persona','persona.id_persona');
                }
                $query->where('persona.id_etnia',$filtros->vi_id_etnia);
                $filtros->hay_filtro++;
            }
            if($filtros->vi_edad_del <> "") {
                $query->where('hecho_victima.edad','>=',$filtros->vi_edad_del);
                $filtros->hay_filtro++;
            }
            if($filtros->vi_edad_al <> "") {
                $query->where('hecho_victima.edad','<=',$filtros->vi_edad_al);
                $filtros->hay_filtro++;
            }

        }




    }

    //Para dinámicas y contexto, se evita el join a violencia y a víctimas, para no multiplicar las respuestas artificialmente
    //En otras palabras, la unidad de conteo es id_hecho
    //Para filtros que requieran victimas o violencia, se utiliza whereIn
    public static function procesar_filtros_fichas_por_hechos_sin_violencia($query, $filtros) {

        if($filtros->id_excel_listados > 0) {
            $filtros->hay_filtro++; //El scope se aplica en los filtros de la entrevista
        }


        //Filtro de fecha de corte
        if(strlen($filtros->fecha_corte)==10) {
            //usar siempre el mismo tipo de filtrado:
            $corte_hecho = hecho_victima::join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->where('victima.updated_at','<',$filtros->fecha_corte)
                ->distinct()
                ->pluck('hecho_victima.id_hecho');
            $query->wherein('hecho.id_hecho',$corte_hecho);
        }




        //violencia, del
        if($filtros->violencia_anio_del > 1900) {
            $query->where('hecho.fecha_ocurrencia_a','>=',$filtros->violencia_anio_del);
            $filtros->hay_filtro++;
        }
        if($filtros->violencia_anio_al > 1900) {
            $query->where('hecho.fecha_ocurrencia_a','<=',$filtros->violencia_anio_al);
            $filtros->hay_filtro++;
        }

        //Tipo de violencia
        if($filtros->violencia_tipo > 0) {
            //Determinar el nivel
            $where=array();
            $cual = tipo_violencia::find($filtros->violencia_tipo);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro++;
                    $filtros->hay_filtro++;
                }
                else {
                    $where = tipo_violencia::where('id_padre',$filtros->violencia_tipo)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }
                $universo = hecho_violencia::wherein('hecho_violencia.id_subtipo_violencia',$where)
                    ->pluck('id_hecho');

                //Aplicar el filtro
                $query->wherein('hecho.id_hecho',$universo);

            }
        }
        //Lugar de la violencia
        if($filtros->violencia_lugar > 0) {
            //Determinar el nivel
            $where=geo::arreglo_contenidos($filtros->violencia_lugar);
            //dd($where);
            $query->wherein('hecho.id_lugar',$where);
            $filtros->hay_filtro++;
        }

        //Actores armados
        if($filtros->violencia_aa > 0) {

            //Determinar el nivel
            $where=array();
            $cual = tipo_aa::find($filtros->violencia_aa);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro++;
                    $filtros->hay_filtro++;
                }
                else {
                    $where = tipo_aa::where('id_padre',$filtros->violencia_aa)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }
                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.aa_id_subtipo',$where)
                            ->pluck('id_hecho');
                //Aplicar el filtro al query general
                $query->wherein('hecho.id_hecho',$universo);
                $filtros->hay_filtro++;
            }
        }
        //Terceros civiles
        if($filtros->violencia_tc > 0) {
            //Determinar el nivel
            $where=array();
            $cual = tipo_tc::find($filtros->violencia_tc);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro++;
                    $filtros->hay_filtro++;
                }
                else {
                    $where = tipo_tc::where('id_padre',$filtros->violencia_tc)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }

                $universo = hecho_responsabilidad::wherein('hecho_responsabilidad.tc_id_subtipo',$where)
                    ->pluck('id_hecho');
                //Aplicar el filtro al query general
                $query->wherein('hecho.id_hecho',$universo);
                $filtros->hay_filtro++;
            }
        }

        //Filtros por victimas
        //Datos de victimas: este query lo uso en c/filtro, asi que lo defino una vez y luego lo clono
        $query_victima = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','persona.id_persona');

        if($filtros->vi_id_sexo > 0) {
            $query_tmp = clone $query_victima;
            $query_tmp->where('persona.id_sexo',$filtros->vi_id_sexo);
            //Aplicar filtro
            $filtros->hay_filtro++;
            $where = $query_tmp->pluck('hecho.id_hecho');
            $query->wherein('hecho.id_hecho',$where);
        }
        if($filtros->vi_id_etnia > 0) {
            $query_tmp = clone $query_victima;
            $query_tmp->where('persona.id_etnia',$filtros->vi_id_etnia);
            //Aplicar filtro
            $filtros->hay_filtro++;
            $where = $query_tmp->pluck('hecho.id_hecho');
            $query->wherein('hecho.id_hecho',$where);
        }
        if($filtros->vi_edad_del <> "") {

            $query_tmp = clone $query_victima;
            $query_tmp->where('hecho_victima.edad','>=',$filtros->vi_edad_del);
            //Aplicar filtro
            $filtros->hay_filtro++;
            $where = $query_tmp->pluck('hecho.id_hecho');
            //dd($where);
            $query->wherein('hecho.id_hecho',$where);
        }
        if($filtros->vi_edad_al <> "") {
            $query_tmp = clone $query_victima;
            $query_tmp->where('hecho_victima.edad','<=',$filtros->vi_edad_al);
            //Aplicar filtro
            $filtros->hay_filtro++;
            $where = $query_tmp->pluck('hecho.id_hecho');
            $query->wherein('hecho.id_hecho',$where);
        }

    }

    //Algunos casos como exilio, multiplica los resultados: (una entrevista, con una ficha de exilio  y dos hechos, muestra dos fichas de exilio)
    //Para evitar esta combinación, utilizaremos un whereIn
    //Agrega nuevos scopes, para filtrar graficos de stats de victimas, hechos, etc.
    public static function procesar_filtros_fichas_por_entrevista($query, $filtros) {
        $filtrar=false;
        $universo =array();
        //Al principio, considerar todas las entrevistas
        $universo = entrevista_individual::pluck('id_e_ind_fvt')->toArray();
        //dd($universo);

        if($filtros->id_excel_listados > 0) {
            $filtros->hay_filtro++; //El scope se aplica en los filtros de la entrevista
        }

        //Filtro de fecha de corte
        if(strlen($filtros->fecha_corte)==10) {
            $corte_entrevista = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->where('victima.updated_at','<',$filtros->fecha_corte)
                ->distinct()
                ->pluck('hecho.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$corte_entrevista);
        }

        //violencia, del
        if($filtros->violencia_anio_del > 1900) {
            $filtrar=true;
            $universo = entrevista_individual::join('fichas.hecho as fdel','e_ind_fvt.id_e_ind_fvt','fdel.id_e_ind_fvt')
                ->where('fdel.fecha_ocurrencia_a','>=',$filtros->violencia_anio_del)
                ->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;

        }


        if($filtros->violencia_anio_al > 1900) {
            $filtrar=true;
            $universo = entrevista_individual::join('fichas.hecho as fal','e_ind_fvt.id_e_ind_fvt','fal.id_e_ind_fvt')
                ->where('fal.fecha_ocurrencia_a','<=',$filtros->violencia_anio_al)
                ->wherein('e_ind_fvt.id_e_ind_fvt',$universo)  //Adicionar el universo anterior
                ->pluck('e_ind_fvt.id_e_ind_fvt')
                ->toArray();
            $filtros->hay_filtro++;
        }

        //Tipo de violencia
        if($filtros->violencia_tipo > 0) {
            $filtrar=true;
            //Determinar el nivel
            $where=array();
            $cual = tipo_violencia::find($filtros->violencia_tipo);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                }
                else {
                    $where = tipo_violencia::where('id_padre',$filtros->violencia_tipo)->pluck('id_geo')->toArray();
                }


                $query_universo = entrevista_individual::join('fichas.hecho as fhv','e_ind_fvt.id_e_ind_fvt','fhv.id_e_ind_fvt')
                    ->join('fichas.hecho_violencia as fvv','fhv.id_hecho','=','fvv.id_hecho')
                    ->wherein('fvv.id_subtipo_violencia',$where)
                    ->wherein('e_ind_fvt.id_e_ind_fvt',$universo); //Adicionar el universo anterior
                $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
                //dd($query_universo->toSql());

                $filtros->hay_filtro++;
            }
        }
        //Lugar de la violencia
        if($filtros->violencia_lugar > 0) {
            $filtrar=true;
            //Determinar el nivel
            $where=geo::arreglo_contenidos($filtros->violencia_lugar);
            //dd($where);
            //$cual = tipo_violencia::where('id_geo',$filtros->violencia_tipo)->first();
            $universo = entrevista_individual::join('fichas.hecho as fhg','e_ind_fvt.id_e_ind_fvt','fhg.id_e_ind_fvt')
                ->join('fichas.hecho_violencia as fvg','fhg.id_hecho','=','fvg.id_hecho') //Para los join que evitan producto cartesiano
                ->wherein('fhg.id_lugar',$where)
                ->wherein('e_ind_fvt.id_e_ind_fvt',$universo)  //Adicionar el universo anterior
                ->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }

        //Actor Armado
        if($filtros->violencia_aa > 0) {
            $filtrar=true;
            //Determinar el nivel
            $where=array();
            $cual = tipo_aa::find($filtros->violencia_aa);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                }
                else {
                    $where = tipo_aa::where('id_padre',$filtros->violencia_aa)->pluck('id_geo')->toArray();
                }
                $query_universo =  entrevista_individual::join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                    ->join('fichas.hecho_responsabilidad','hecho.id_hecho','=','hecho_responsabilidad.id_hecho')
                    ->wherein('e_ind_fvt.id_e_ind_fvt',$universo) //Adicionar el universo anterior
                    ->wherein('hecho_responsabilidad.aa_id_subtipo',$where);
                $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
                $filtros->hay_filtro++;
            }
        }

        //Tercero Civil
        if($filtros->violencia_tc > 0) {
            $filtrar=true;
            //Determinar el nivel
            $where=array();
            $cual = tipo_tc::find($filtros->violencia_tc);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                }
                else {
                    $where = tipo_tc::where('id_padre',$filtros->violencia_tc)->pluck('id_geo')->toArray();
                }
                $query_universo =  entrevista_individual::join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                    ->join('fichas.hecho_responsabilidad','hecho.id_hecho','=','hecho_responsabilidad.id_hecho')
                    ->wherein('e_ind_fvt.id_e_ind_fvt',$universo) //Adicionar el universo anterior
                    ->wherein('hecho_responsabilidad.tc_id_subtipo',$where);
                $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
                $filtros->hay_filtro++;
            }
        }

        //Victimas
        //Datos de victimas: este query lo uso en c/filtro, asi que lo defino una vez y luego lo clono
        $query_victima = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','persona.id_persona')
            ->join('esclarecimiento.e_ind_fvt','hecho.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt');

        if($filtros->vi_id_sexo > 0) {
            //Banderita para aplicar todos los filtros de un solo
            $filtrar=true;
            //Determinar las entrevistas involucradas
            $query_universo = clone $query_victima;
            $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo); //Adicionar el universo anterior
            $query_universo->where('persona.id_sexo',$filtros->vi_id_sexo); //Aplicar el filtr

            //Aplicar filtro
            $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }
        if($filtros->vi_id_etnia > 0) {
            //Banderita para aplicar todos los filtros de un solo
            $filtrar=true;
            //Determinar las entrevistas involucradas
            $query_universo = clone $query_victima;
            $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo); //Adicionar el universo anterior
            $query_universo->where('persona.id_etnia',$filtros->vi_id_etnia); //Aplicar el filtro

            //Aplicar filtro
            $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }
        if($filtros->vi_edad_del <> "") {
            //Banderita para aplicar todos los filtros de un solo
            $filtrar=true;
            //Determinar las entrevistas involucradas
            $query_universo = clone $query_victima;
            $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo); //Adicionar el universo anterior
            $query_universo->where('hecho_victima.edad','>=',$filtros->vi_edad_del); //Aplicar el filtro$query_universo->where('persona.id_etnia',$filtros->vi_id_etnia);
            //Aplicar filtro
            $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }
        if($filtros->vi_edad_al <> "") {
            //Banderita para aplicar todos los filtros de un solo
            $filtrar=true;
            //Determinar las entrevistas involucradas
            $query_universo = clone $query_victima;
            $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo); //Adicionar el universo anterior
            $query_universo->where('hecho_victima.edad','<=',$filtros->vi_edad_al); //Aplicar el filtro$query_universo->where('persona.id_etnia',$filtros->vi_id_etnia);
            //Aplicar filtro
            //dd(self::debug_query($query_universo));
            $universo = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }



        if($filtrar) {
            $filtrar=true;

            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo);
        }

    }




    //Versión mejorada: los subqueries se realizan todos juntos
    public static function procesar_filtros_persona_entrevistada($query, $filtros) {

        $filtrar=false;
        $universo =array();

        if($filtros->id_excel_listados > 0) {
            $filtros->hay_filtro++; //El scope se aplica en los filtros de la entrevista
        }


        $universo = entrevista_individual::join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
                                            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                                            ->leftJoin('fichas.hecho_responsabilidad','hecho.id_hecho','=','hecho_responsabilidad.id_hecho');


        //Filtro de fecha de corte
        if(strlen($filtros->fecha_corte)==10) {
            $tmp = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
                ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
                ->where('victima.updated_at','<',$filtros->fecha_corte)
                ->distinct()
                ->pluck('hecho.id_e_ind_fvt');
            $filtrar=true;
            $universo->wherein('e_ind_fvt.id_e_ind_fvt',$tmp);
        }


        //violencia, del
        if($filtros->violencia_anio_del > 1900) {
            $universo->where('hecho.fecha_ocurrencia_a','>=',$filtros->violencia_anio_del);//Aplicar filtro
            //Banderas
            $filtrar=true;
            $filtros->hay_filtro++;

        }


        if($filtros->violencia_anio_al > 1900) {
            $universo->where('hecho.fecha_ocurrencia_a','<=',$filtros->violencia_anio_al);//Aplicar filtro
            //Bandreas
            $filtrar=true;
            $filtros->hay_filtro++;
        }

        //Tipo de violencia
        if($filtros->violencia_tipo > 0) {
            //Determinar el nivel
            $where=array();
            $cual = tipo_violencia::find($filtros->violencia_tipo);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                }
                else {
                    $where = tipo_violencia::where('id_padre',$filtros->violencia_tipo)->pluck('id_geo')->toArray();
                }

                $universo->wherein('hecho_violencia.id_subtipo_violencia',$where); //Aplicar filtro
            }
            //banderas
            $filtrar=true;
            $filtros->hay_filtro++;
        }
        //Lugar de la violencia
        if($filtros->violencia_lugar > 0) {

            //Determinar el nivel
            $where=geo::arreglo_contenidos($filtros->violencia_lugar);
            $universo->wherein('hecho.id_lugar',$where);  //Aplicar filtro
            //Banderas
            $filtrar=true;
            $filtros->hay_filtro++;
        }

        //Actor Armado
        if($filtros->violencia_aa > 0) {
            $filtrar=true;

            //Determinar el nivel
            $where=array();
            $cual = tipo_aa::find($filtros->violencia_aa);
            if($cual) {
                if ($cual->nivel == 2) {
                    $where[] = $cual->id_geo;
                    $filtros->hay_filtro = $filtros->hay_filtro+2;

                } else {
                    $where = tipo_aa::where('id_padre', $filtros->violencia_aa)->pluck('id_geo')->toArray();
                    $filtros->hay_filtro++;
                }
            }

            $universo->wherein('hecho_responsabilidad.aa_id_subtipo',$where);  //Aplicar filtro

        }

        //Tercero Civil
        if($filtros->violencia_tc > 0) {

            //Determinar el nivel
            $where=array();
            $cual = tipo_tc::find($filtros->violencia_tc);
            if($cual) {
                if($cual->nivel==2) {
                    $where[] = $cual->id_geo;
                }
                else {
                    $where = tipo_tc::where('id_padre',$filtros->violencia_tc)->pluck('id_geo')->toArray();
                }
            }

            $universo->wherein('hecho_responsabilidad.tc_id_subtipo',$where);  //Aplicar filtro
            //BAnderas
            $filtrar=true;
            $filtros->hay_filtro++;
        }

        //Filtros por datos de la victima
        //Datos de victimas: este query lo uso en c/filtro, asi que lo defino una vez y luego lo clono
        $query_victima = hecho::join('fichas.hecho_victima','hecho.id_hecho','hecho_victima.id_hecho')
            ->join('fichas.victima','hecho_victima.id_victima','victima.id_victima')
            ->join('fichas.persona','victima.id_persona','persona.id_persona')
            ->join('esclarecimiento.e_ind_fvt','hecho.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt');

        //Primer filtrado, no considera el wherein de universo_victima
        $filtrar_victimas =false;
        if($filtros->vi_id_sexo > 0) {
            //Banderita para aplicar el filtro al query general
            $filtrar_victimas=true;
            //Aplicar filtro y crear el primer subset de entrevistas que aplican
            $query_universo = clone $query_victima;
            $query_universo->where('persona.id_sexo',$filtros->vi_id_sexo); //Aplicar el filtr
            $universo_victima = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }
        //A partir del segundo filtro, los filtros de victimas deben considerar el universo anterior para que sean aplicados como "AND" y no como "OR"
        //esto se logra con el wherein de $universo_victima
        if($filtros->vi_id_etnia > 0) {
            //Banderita para aplicar el filtro al query general
            $filtrar_victimas=true;
            //Aplicar filtro y crear el primer subset de entrevistas que aplican
            $query_universo = clone $query_victima;
            if(isset($universo_victima)) {  //Adicionar el universo anterior, si lo hubiera
                $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo_victima);
            }
            $query_universo->where('persona.id_etnia',$filtros->vi_id_etnia); //Aplicar el filtro
            $universo_victima = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }
        if($filtros->vi_edad_del <> "") {
            //Banderita para aplicar el filtro al query general
            $filtrar_victimas=true;
            //Aplicar filtro y crear el primer subset de entrevistas que aplican
            $query_universo = clone $query_victima;
            if(isset($universo_victima)) {  //Adicionar el universo anterior, si lo hubiera
                $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo_victima);
            }
            $query_universo->where('hecho_victima.edad','>=',$filtros->vi_edad_del); //Aplicar el filtro
            $universo_victima = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }
        if($filtros->vi_edad_al <> "") {
            //Banderita para aplicar el filtro al query general
            $filtrar_victimas=true;
            //Aplicar filtro y crear el primer subset de entrevistas que aplican
            $query_universo = clone $query_victima;
            if(isset($universo_victima)) {  //Adicionar el universo anterior, si lo hubiera
                $query_universo->wherein('e_ind_fvt.id_e_ind_fvt',$universo_victima);
            }
            $query_universo->where('hecho_victima.edad','<=',$filtros->vi_edad_al); //Aplicar el filtro
            $universo_victima = $query_universo->pluck('e_ind_fvt.id_e_ind_fvt')->toArray();
            $filtros->hay_filtro++;
        }



        //Usar wherein
        if($filtrar) {
            $cuales = $universo->pluck('e_ind_fvt.id_e_ind_fvt');
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$cuales);  //Aplicar el filtro final al query original
        }
        //filtros por victimas
        if($filtrar_victimas) {
            $query->wherein('e_ind_fvt.id_e_ind_fvt',$universo_victima);  //Aplicar el filtro de victimas final al query original
        }




    }

    public function getFmtSintesisRelatoAttribute() {
        $quien = $this->rel_ficha_persona_entrevistada()->first();
        if($quien) {
            return $quien->sintesis_relato;
        }
        else {
            return "Sin diligenciar";
        }
    }

    public static function debug_query($query) {
        $debug['sql']=$query->toSql();
        $debug['criterios']=$query->getBindings();
        $debug['query']=self::getQueries($query);
        return $debug;
    }

    //Para Myriam: cambiar una entrevista a otro usuario
    public function trasladar($id_entrevistador=0) {
        $quien=entrevistador::find($id_entrevistador);
        if($quien) {
            if($this->id_entrevistador <> $id_entrevistador) {
                $this->id_entrevistador = $id_entrevistador;
                $this->entrevista_numero = $this->cual_toca();
                $this->entrevista_codigo = $this->calcular_codigo();
                $this->save();
                return $this->entrevista_codigo;
            }
            else {
                echo "Mismo entrevistador";
                return false;
            }

        }
        else {
            echo "No existe el entrevistador $id_entrevistador";
            return false;
        }
    }

    //Conteo de palabras en la transcripcion
    public static function transcripcion_conteo_palabras($entrevista) {
        $conteo = str_word_count(trim(strip_tags($entrevista->html_transcripcion)));
        return $conteo;
    }
    public static function transcripcion_conteo_caracteres($entrevista) {
        $conteo = strlen(trim(strip_tags($entrevista->html_transcripcion)));
        return $conteo;
    }


    //Para el bloqueo de descargas
    public static function puede_descargar($id_entrevistador) {

        //El propietario, siempre puede descargar
        if(\Gate::allows('es-propio',$id_entrevistador)) {  //Los casos e informes sí se pueden descargar
            return true;
        }

        //Verificar bloqueo de descargas con parametro global
        if(config('expedientes.no_descargas')) {
            if(\Gate::allows('puede-descargar')) { //Admin, comisionado, transcriptores
                return true;
            }
            else {
                if(\Gate::allows('rol-descarga')) { //Admin, comisionado, transcriptores
                    return true;
                }
                else {
                    return false;
                }
            }
        }
        else {
            return true;
        }
    }

    //Detectar si lo tengo compartido para editar
    public static function compartido_edicion($entrevista, $id_entrevistador=null) {

        //
        if(is_null($id_entrevistador)) {
            if(\Auth::check()) {
                $id_entrevistador = \Auth::user()->id_entrevistador;
            }
        }
        //Detectar la subserie
        $id_subserie=0;
        $id_entrevista=0;
        if(isset($entrevista->id_e_ind_fvt)) {
            $id_subserie   = $entrevista->id_subserie;
            $id_entrevista = $entrevista->id_e_ind_fvt;
        }
        elseif(isset($entrevista->id_entrevista_colectiva)) {
            $id_subserie   = config("expedientes.co");
            $id_entrevista = $entrevista->id_entrevista_colectiva;
        }
        elseif(isset($entrevista->id_entrevista_etnica)) {
            $id_subserie   = config("expedientes.ee");
            $id_entrevista = $entrevista->id_entrevista_etnica;
        }
        elseif(isset($entrevista->id_entrevista_profundidad)) {
            $id_subserie   = config("expedientes.pr");
            $id_entrevista = $entrevista->id_entrevista_profundidad;
        }
        elseif(isset($entrevista->id_diagnostico_comunitario)) {
            $id_subserie   = config("expedientes.dc");
            $id_entrevista = $entrevista->id_diagnostico_comunitario;
        }
        elseif(isset($entrevista->id_historia_vida)) {
            $id_subserie   = config("expedientes.hv");
            $id_entrevista = $entrevista->id_historia_vida;
        }

        //Verificar
        $compartida = acceso_edicion::where('id_autorizado',$id_entrevistador)
            ->where('id_situacion',1)
            ->where('id_subserie',$id_subserie)
            ->where('id_entrevista',$id_entrevista)
            ->count();
        //Devolver true/false
        if($compartida > 0) {
            return true;
        }
        else {
            return false;
        }

    }

    //Estructura jerarquica para violencia, contexto, impactos
    public static function json_jerarquia_total() {
        $estructura = array();
        $nodo = new \stdClass();
        $nodo->id= 1;
        $nodo->name = "Entrevistas";
        $estructura[]=$nodo;

        $violencia = tipo_violencia::json_jerarquia();
        $contexto = cat_item::json_jerarquia_contexto();
        $impactos = cat_item::json_jerarquia_impactos();
        $res= new \stdClass();
        $res->violencia = $violencia;
        $res->contexto = $contexto;
        $res->impactos=$impactos;
        $res->estructura = array_merge($estructura, $violencia,$contexto->estructura,$impactos->estructura);
        //$estructura =  array_push($estructura, $violencia);// + $contexto + $impactos;
        return $res;

    }

    public static function json_relaciones_contexto($validos_contexto) {
        //relaciones violencia-contexto
        $listado = entrevista_individual::where('id_activo',1)
                        ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
                        ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                        ->join('fichas.hecho_contexto','hecho.id_hecho','=','hecho_contexto.id_hecho')
                        ->wherein('hecho_contexto.id_contexto',$validos_contexto)
                        ->orderby('hecho_violencia.id_subtipo_violencia')
                        ->orderby('hecho_contexto.id_contexto')
                        ->get();
        $relaciones=array();
        foreach($listado as $fila) {
            $nodo = new \stdClass();
            $nodo->source = $fila->id_subtipo_violencia + 100000;
            $nodo->target = $fila->id_contexto;
            $relaciones[]=$nodo;
        }
        return $relaciones;

    }
    public static function json_relaciones_impactos($validos) {
        //relaciones violencia-contexto
        $listado = entrevista_individual::where('id_activo',1)
            ->join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
            ->join('fichas.entrevista_impacto','e_ind_fvt.id_e_ind_fvt','=','entrevista_impacto.id_e_ind_fvt')
            ->wherein('entrevista_impacto.id_impacto',$validos)
            ->orderby('hecho_violencia.id_subtipo_violencia')
            ->orderby('entrevista_impacto.id_impacto')
            ->get();
        $relaciones=array();
        foreach($listado as $fila) {
            $nodo = new \stdClass();
            $nodo->source = $fila->id_subtipo_violencia + 100000;
            $nodo->target = $fila->id_impacto;
            $relaciones[]=$nodo;
        }
        return $relaciones;

    }

    //Armar los nodos y sus relaciones
    public static function armar_grafico_relaciones() {
        $entidades = entrevista_individual::json_jerarquia_total();
        //dd($entidades);

        //Buscar relaciones solo para id_contexto en top 5
        $relaciones_contexto = entrevista_individual::json_relaciones_contexto($entidades->contexto->validos);


        $relaciones_impactos = entrevista_individual::json_relaciones_impactos($entidades->impactos->validos);


        $relaciones = array_merge($relaciones_contexto,$relaciones_impactos);

        $json_entidades= json_encode($entidades->estructura);
        $json_relaciones = json_encode($relaciones);

        $res = new \stdClass();
        $res->json_entidades = $json_entidades;
        $res->json_relaciones = $json_relaciones;
        return $res;


    }
    //Para convertir el tesauro en nube de etiquetas
    public function etiquetas_a_texto() {
        $listado = entrevista_individual::listado_etiquetas($this->id_subserie, $this->id_e_ind_fvt);
        $limpio = array_map('trim', $listado);
        return implode("|",$listado);
    }

    public static function listado_etiquetas($id_subserie=0, $id_entrevista=0) {
        $listado = etiqueta_entrevista::join('sim.etiqueta','etiqueta_entrevista.id_etiqueta','etiqueta.id_etiqueta')
            ->join('catalogos.tesauro','etiqueta.id_etiqueta','tesauro.id_etiqueta')
            ->where('etiqueta_entrevista.id_subserie',$id_subserie)
            ->where('etiqueta_entrevista.id_entrevista',$id_entrevista)
            ->where('tesauro.codigo','>=','010000')
            ->orderby('tesauro.codigo')
            ->pluck('tesauro.etiqueta_completa')
            ->toArray();
        return $listado;
    }
    //Convierte en entrevista a profundidad
    public function trasladar_pr() {
        //Crear PR
        $nueva = new entrevista_profundidad();
        $nueva->id_macroterritorio = $this->id_macroterritorio;
        $nueva->id_territorio = $this->id_territorio;
        $nueva->id_entrevistador = $this->id_entrevistador;
        $nueva->numero_entrevistador = $this->numero_entrevistador;
        $nueva->entrevista_numero = $nueva->cual_toca();
        $nueva->asignar_codigo($nueva->id_entrevistador);
        $nueva->entrevista_lugar = $this->entrevista_lugar;
        $nueva->entrevista_objetivo = "Traslado desde la entrevista $this->entrevista_codigo";
        //Persona entrevistada
        $nueva->entrevistado_apellidos = "Sin especificar";
        $nueva->entrevistado_nombres = "Sin especificar";
        $ficha_pe = $this->rel_ficha_persona_entrevistada;
        if($ficha_pe) {
            $persona = $ficha_pe->rel_id_persona;
            if($persona) {
                $nueva->entrevistado_apellidos = $persona->apellido;
                $nueva->entrevistado_nombres = $persona->nombre;
            }
        }
        if($this->id_sector==null) {
            $nueva->id_sector = config('expedientes.pr_sector');
        }
        else {
            $nueva->id_sector = $this->id_sector;
        }

        $nueva->observaciones = $this->anotaciones;
        $nueva->clasificacion_nna = $this->clasifica_nna;
        $nueva->clasificacion_sex = $this->clasifica_sex;
        $nueva->clasificacion_res = $this->clasifica_res;
        $nueva->clasificacion_r2 = $this->clasifica_r2;
        $nueva->clasificacion_r1 = $this->clasifica_r1;
        $nueva->clasificacion_nivel = $this->clasifica_nivel;
        $nueva->id_usuario = \Auth::user()->id;
        //dd($this->entrevista_fecha);
        $nueva->entrevista_fecha_inicio = substr($this->entrevista_fecha,0,10);
        $nueva->entrevista_fecha_final = substr($this->entrevista_fecha,0,10);
        $nueva->entrevista_avance = config('expedientes.pr_cerrada');
        $nueva->titulo = $nueva->entrevista_objetivo;
        $nueva->tiempo_entrevista = $this->tiempo_entrevista;
        //Defaults
        $nueva->id_tipo = 7; //  Victima/testigo
        $nueva->id_policia_parte = 2; //  No
        $nueva->id_paramilitar_parte = 2; //  No
        $nueva->id_guerrilla_parte = 2; //  No
        $nueva->id_ejercito_parte = 2; //  No
        $nueva->id_fuerza_aerea_parte = 2; //  No
        $nueva->id_fuerza_naval_parte = 2; //  No
        $nueva->id_tercero_civil_parte = 2; //  No
        $nueva->id_agente_estado_parte = 2; //  No
        $nueva->html_transcripcion = $this->html_transcripcion;
        $nueva->json_etiquetado = $this->json_etiquetado;
        $nueva->id_activo =1;
        $nueva->id_cerrado = $this->id_cerrado;
        $nueva->es_virtual = $this->es_virtual;
        //dd($nueva);
        //GRABAR y continuar con el detalle
        try {
            $nueva->save();
            //Detalle: adjuntos, dinamica, interes, mandato, violencia_victima
            foreach($this->rel_adjunto as $item) {
                $tmp = new entrevista_profundidad_adjunto();
                $tmp->id_entrevista_profundidad = $nueva->id_entrevista_profundidad;
                $tmp->id_tipo = $item->id_tipo;
                $tmp->id_adjunto = $item->id_adjunto;
                $tmp->id_transcripcion = $item->id_transcripcion;
                $tmp->save();
            }
            foreach($this->rel_dinamica as $item) {
                $tmp = new entrevista_profundidad_dinamica();
                $tmp->id_entrevista_profundidad = $nueva->id_entrevista_profundidad;
                $tmp->dinamica = $item->dinamica;
                $tmp->save();
            }
            foreach($this->rel_interes as $item) {
                $tmp = new entrevista_profundidad_interes();
                $tmp->id_entrevista_profundidad = $nueva->id_entrevista_profundidad;
                $tmp->id_interes = $item->id_interes;
                $tmp->save();
            }
            foreach($this->rel_mandato as $item) {
                $tmp = new entrevista_profundidad_mandato();
                $tmp->id_entrevista_profundidad = $nueva->id_entrevista_profundidad;
                $tmp->id_mandato = $item->id_mandato;
                $tmp->save();
            }
            foreach($this->rel_tv as $item) {
                $tmp = new entrevista_profundidad_violencia_victima();
                $tmp->id_entrevista_profundidad = $nueva->id_entrevista_profundidad;
                $tmp->id_violencia = $item->id_tv;
                $tmp->save();
            }
            //Etiquetado
            $this->trasladar_pr_etiquetas($nueva);
            //Crear enlace
            $enlace= new enlace();
            $enlace->id_subserie = $this->id_subserie;
            $enlace->id_primaria = $this->id_e_ind_fvt;
            $enlace->id_subserie_e = config('expedientes.pr');
            $enlace->id_primaria_e = $nueva->id_entrevista_profundidad;
            $enlace->id_tipo = 3; //Traslado
            if(\Auth::check()) {
                $enlace->id_entrevistador = \Auth::user()->id_entrevistador;
            }
            $enlace->anotaciones = "Traslado de $this->entrevista_codigo a $nueva->entrevista_codigo";
            $enlace->id_activo=1;
            $enlace->save();
            //Anular
            $this->id_activo=2;
            $this->save();
            //Registrar traza de actividad
            //Traza
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>33, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$this->id_e_ind_fvt, 'referencia'=>"Traslado a $nueva->entrevista_codigo"]);
            traza_actividad::create(['id_objeto'=>11, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_entrevista_profundidad, 'referencia'=>"Traslado desde $this->entrevista_codigo"]);
            //Devolver id_entrevista_profundidad

            return $nueva;
        }
        catch(\Exception $e) {
            Log::error('Problemas al trasladar VI a PR'.PHP_EOL.$e->getMessage());
            return false;
        }
    }
    //Esto lo tuve que hacer por separado para poder hacerlo para algunas ya trasladadas
    //Se incluye en trasladar_pr()
    public function trasladar_pr_etiquetas($entrevista) {
        if(!is_object($entrevista)) {
            return false;
        }
        $conteo=0;
        foreach($this->rel_etiquetas as $antigua) {
            $nueva = new etiqueta_entrevista();
            //Nuevos datos
            $nueva->id_entrevista = $entrevista->id_entrevista_profundidad;
            $nueva->id_subserie = config('expedientes.pr');
            $nueva->codigo = $entrevista->entrevista_codigo;
            //Copiar etiquetado
            $nueva->id_etiqueta = $antigua->id_etiqueta;
            $nueva->texto = $antigua->texto;
            $nueva->del = $antigua->del;
            $nueva->al = $antigua->al;
            $nueva->save();
            $conteo++;
        }
        return $conteo;
    }

    //Trasladar a historias de vida
    public function trasladar_hv() {
        //Crear PR
        $nueva = new historia_vida();
        $nueva->id_macroterritorio = $this->id_macroterritorio;
        $nueva->id_territorio = $this->id_territorio;
        $nueva->id_entrevistador = $this->id_entrevistador;
        $nueva->numero_entrevistador = $this->numero_entrevistador;
        $nueva->entrevista_numero = $nueva->cual_toca();
        $nueva->asignar_codigo($nueva->id_entrevistador);
        $nueva->entrevista_lugar = $this->entrevista_lugar;
        $nueva->entrevista_objetivo = "Traslado desde la entrevista $this->entrevista_codigo";
        //Persona entrevistada
        $nueva->entrevistado_apellidos = "Sin especificar";
        $nueva->entrevistado_nombres = "Sin especificar";
        $ficha_pe = $this->rel_ficha_persona_entrevistada;
        if($ficha_pe) {
            $persona = $ficha_pe->rel_id_persona;
            if($persona) {
                $nueva->entrevistado_apellidos = $persona->apellido;
                $nueva->entrevistado_nombres = $persona->nombre;
            }
        }
        if($this->id_sector==null) {
            $nueva->id_sector = config('expedientes.pr_sector');
        }
        else {
            $nueva->id_sector = $this->id_sector;
        }

        $nueva->observaciones = $this->anotaciones;
        $nueva->clasificacion_nna = $this->clasifica_nna;
        $nueva->clasificacion_sex = $this->clasifica_sex;
        $nueva->clasificacion_res = $this->clasifica_res;
        $nueva->clasificacion_r2 = $this->clasifica_r2;
        $nueva->clasificacion_r1 = $this->clasifica_r1;
        $nueva->clasificacion_nivel = $this->clasifica_nivel;
        if(\Auth::check()) {
            $nueva->id_usuario = \Auth::user()->id;
        }
        else {
            $nueva->id_usuario=1;
        }

        //dd($this->entrevista_fecha);
        $nueva->entrevista_fecha_inicio = substr($this->entrevista_fecha,0,10);
        $nueva->entrevista_fecha_final = substr($this->entrevista_fecha,0,10);
        $nueva->entrevista_avance = config('expedientes.pr_cerrada');
        $nueva->titulo = $nueva->entrevista_objetivo;
        $nueva->tiempo_entrevista = $this->tiempo_entrevista;
        //Transcripcion/etiquetado
        $nueva->html_transcripcion = $this->html_transcripcion;
        $nueva->json_etiquetado = $this->json_etiquetado;
        $nueva->id_activo =1;
        $nueva->id_cerrado = $this->id_cerrado;
        $nueva->es_virtual = $this->es_virtual;
        //dd($nueva);
        //GRABAR y continuar con el detalle
        try {
            $nueva->save();
            //Detalle: adjuntos, dinamica, interes, mandato, violencia_victima
            foreach($this->rel_adjunto as $item) {
                $tmp = new historia_vida_adjunto();
                $tmp->id_historia_vida = $nueva->id_historia_vida;
                $tmp->id_tipo = $item->id_tipo;
                $tmp->id_adjunto = $item->id_adjunto;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->id_transcripcion = $item->id_transcripcion;
                $tmp->save();
            }
            foreach($this->rel_dinamica as $item) {
                $tmp = new historia_vida_dinamica();
                $tmp->id_historia_vida = $nueva->id_historia_vida;
                $tmp->dinamica = $item->dinamica;
                $tmp->save();
            }
            foreach($this->rel_interes as $item) {
                $tmp = new historia_vida_interes();
                $tmp->id_historia_vida = $nueva->id_historia_vida;
                $tmp->id_interes = $item->id_interes;
                $tmp->save();
            }
            foreach($this->rel_mandato as $item) {
                $tmp = new historia_vida_mandato();
                $tmp->id_historia_vida = $nueva->id_historia_vida;
                $tmp->id_mandato = $item->id_mandato;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->save();
            }


            //Etiquetado
            $conteo=0;
            foreach($this->rel_etiquetas as $antigua) {
                $nueva_etiqueta = new etiqueta_entrevista();
                //Nuevos datos
                $nueva_etiqueta->id_entrevista = $nueva->id_historia_vida;
                $nueva_etiqueta->id_subserie = config('expedientes.hv');
                $nueva_etiqueta->codigo = $nueva->entrevista_codigo;
                //Copiar etiquetado
                $nueva_etiqueta->id_etiqueta = $antigua->id_etiqueta;
                $nueva_etiqueta->texto = $antigua->texto;
                $nueva_etiqueta->del = $antigua->del;
                $nueva_etiqueta->al = $antigua->al;
                $nueva_etiqueta->save();
                $conteo++;
            }
            //Crear enlace
            $enlace= new enlace();
            $enlace->id_subserie = $this->id_subserie;
            $enlace->id_primaria = $this->id_e_ind_fvt;
            $enlace->id_subserie_e = config('expedientes.hv');
            $enlace->id_primaria_e = $nueva->id_historia_vida;
            $enlace->id_tipo = 3; //Traslado
            if(\Auth::check()) {
                $enlace->id_entrevistador = \Auth::user()->id_entrevistador;
            }
            else {
                $enlace->id_entrevistador=10;
            }
            $enlace->anotaciones = "Traslado de $this->entrevista_codigo a $nueva->entrevista_codigo";
            $enlace->id_activo=1;
            $enlace->save();
            //Anular
            $this->id_activo=2;
            $this->save();
            //Registrar traza de actividad
            //Traza
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>34, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$this->id_e_ind_fvt, 'referencia'=>"Traslado a $nueva->entrevista_codigo"]);
            traza_actividad::create(['id_objeto'=>12, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_historia_vida, 'referencia'=>"Traslado desde $this->entrevista_codigo"]);
            //Devolver id_entrevista_profundidad

            return $nueva;
        }
        catch(\Exception $e) {
            Log::error('Problemas al trasladar VI a HV'.PHP_EOL.$e->getMessage());
            return false;
        }
    }




    //Convierte en entrevista colectiva
    public function trasladar_co() {
        //Crear CO
        $nueva = new entrevista_colectiva();
        $nueva->id_macroterritorio = $this->id_macroterritorio;
        $nueva->id_territorio = $this->id_territorio;
        $nueva->es_virtual = $this->es_virtual;
        $nueva->id_entrevistador = $this->id_entrevistador;
        $nueva->numero_entrevistador = $this->numero_entrevistador;
        $nueva->entrevista_numero = $nueva->cual_toca();
        $nueva->asignar_codigo($nueva->id_entrevistador);
        $nueva->entrevista_lugar = $this->entrevista_lugar;
        $nueva->titulo = $this->titulo;
        $nueva->observaciones = $this->anotaciones;
        $nueva->clasificacion_nna = $this->clasifica_nna;
        $nueva->clasificacion_sex = $this->clasifica_sex;
        $nueva->clasificacion_res = $this->clasifica_res;
        $nueva->clasificacion_r2 = $this->clasifica_r2;
        $nueva->clasificacion_r1 = $this->clasifica_r1;
        $nueva->clasificacion_nivel = $this->clasifica_nivel;
        $nueva->id_transcrita = $this->id_transcrita;
        $nueva->id_etiquetada = $this->id_etiquetada;
        if($this->id_sector==null) {
            $nueva->id_sector = config('expedientes.pr_sector');
        }
        else {
            $nueva->id_sector = $this->id_sector;
        }

        //Facilitador
        $e = $this->rel_id_entrevistador;
        $nueva->equipo_facilitador = $e->fmt_numero_nombre;
        $nueva->equipo_memorista = $e->fmt_numero_nombre;
        $nueva->tema_objetivo = "Traslado desde la entrevista $this->entrevista_codigo";
        $nueva->tema_descripcion = "Traslado desde la entrevista $this->entrevista_codigo";
        $nueva->tema_del = substr($this->hechos_del,0,10);
        $nueva->tema_al = substr($this->hechos_al, 0, 10);
        $nueva->tema_lugar = $this->hechos_lugar;
        $nueva->cantidad_participantes = 1;
        $nueva->eventos_descripcion = "Sin especificar";



        if(\Auth::check()) {
            $nueva->id_usuario = \Auth::user()->id;
        }
        else {
            $nueva->id_usuario=1;
        }

        //dd($this->entrevista_fecha);
        $nueva->entrevista_fecha_inicio = substr($this->entrevista_fecha,0,10);
        $nueva->entrevista_fecha_final = substr($this->entrevista_fecha,0,10);
        $nueva->entrevista_avance = config('expedientes.pr_cerrada');

        $nueva->tiempo_entrevista = $this->tiempo_entrevista;
        //Transcripcion/etiquetado
        $nueva->html_transcripcion = $this->html_transcripcion;
        $nueva->json_etiquetado = $this->json_etiquetado;
        $nueva->id_activo =1;
        $nueva->id_cerrado = $this->id_cerrado;
        $nueva->es_virtual = $this->es_virtual;
        //dd($nueva);
        //GRABAR y continuar con el detalle
        try {
            $nueva->save();
            //Detalle: adjuntos, dinamica, interes, mandato, violencia_victima
            foreach($this->rel_adjunto as $item) {
                $tmp = new entrevista_colectiva_adjunto();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->id_tipo = $item->id_tipo;
                $tmp->id_adjunto = $item->id_adjunto;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->id_transcripcion = $item->id_transcripcion;
                $tmp->save();
            }
            foreach($this->rel_dinamica as $item) {
                $tmp = new entrevista_colectiva_dinamica();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->dinamica = $item->dinamica;
                $tmp->save();
            }
            foreach($this->rel_interes as $item) {
                $tmp = new entrevista_colectiva_interes();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->id_interes = $item->id_interes;
                $tmp->save();
            }
            foreach($this->rel_mandato as $item) {
                $tmp = new entrevista_colectiva_mandato();
                $tmp->id_entrevista_colectiva = $nueva->id_entrevista_colectiva;
                $tmp->id_mandato = $item->id_mandato;
                $tmp->id_usuario = $nueva->id_usuario;
                $tmp->save();
            }


            //Etiquetado
            $conteo=0;
            foreach($this->rel_etiquetas as $antigua) {
                $nueva_etiqueta = new etiqueta_entrevista();
                //Nuevos datos
                $nueva_etiqueta->id_entrevista = $nueva->id_entrevista_colectiva;
                $nueva_etiqueta->id_subserie = config('expedientes.co');
                $nueva_etiqueta->codigo = $nueva->entrevista_codigo;
                //Copiar etiquetado
                $nueva_etiqueta->id_etiqueta = $antigua->id_etiqueta;
                $nueva_etiqueta->texto = $antigua->texto;
                $nueva_etiqueta->del = $antigua->del;
                $nueva_etiqueta->al = $antigua->al;
                $nueva_etiqueta->save();
                $conteo++;
            }
            //Crear enlace
            $enlace= new enlace();
            $enlace->id_subserie = $this->id_subserie;
            $enlace->id_primaria = $this->id_e_ind_fvt;
            $enlace->id_subserie_e = config('expedientes.co');
            $enlace->id_primaria_e = $nueva->id_entrevista_colectiva;
            $enlace->id_tipo = 3; //Traslado
            if(\Auth::check()) {
                $enlace->id_entrevistador = \Auth::user()->id_entrevistador;
            }
            else {
                $enlace->id_entrevistador=10;
            }
            $enlace->anotaciones = "Traslado de $this->entrevista_codigo a $nueva->entrevista_codigo";
            $enlace->id_activo=1;
            $enlace->save();
            //Anular
            $this->id_activo=2;
            $this->save();
            //Registrar traza de actividad
            //Traza
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>34, 'codigo'=>$this->entrevista_codigo, 'id_primaria'=>$this->id_e_ind_fvt, 'referencia'=>"Traslado a $nueva->entrevista_codigo"]);
            traza_actividad::create(['id_objeto'=>10, 'id_accion'=>3, 'codigo'=>$nueva->entrevista_codigo, 'id_primaria'=>$nueva->id_entrevista_colectiva, 'referencia'=>"Traslado desde $this->entrevista_codigo"]);
            //Devolver id_entrevista_profundidad

            return $nueva;
        }
        catch(\Exception $e) {
            Log::error('Problemas al trasladar VI a CO'.PHP_EOL.$e->getMessage());
            return false;
        }
    }



    //Revisión de que tenga transcripcion, etiquetado y fichas. Si no, no se puede cerrar
    public function puede_cerrarse() {
        $puede=true;
        if(empty($this->html_transcripcion)) {
            $puede=false;
        }
        if(empty($this->json_etiquetado)) {
            $puede=false;
        }
        if($this->fichas_estado <> 1) {
            $puede = false;
        }
        return $puede;
    }

    //Determinar si puedo mostrar el formulario de priorizacion
    public static function puede_priorizarse($entrevista) {
        $res= new \stdClass();
        $res->puede=true;
        $res->prioridad=false;
        $res->txt="";

        $res->prioridad = $entrevista->rel_prioridad()->where('id_tipo',2)->first();
        if($res->prioridad) {
            $res->puede=false;
            $res->txt = "Priorización del transcriptor";
        }
        else {
            $res->prioridad = $entrevista->rel_prioridad()->where('id_tipo',1)->first();
            if($res->prioridad) {
                $res->puede=false;
                $res->txt = "Priorización del entrevistador";
            }
            else {
                if(\Auth::check()) {
                    if(Gate::allows('es-propio',$entrevista->id_entrevistador)) {
                        $res->puede=true;
                    }
                    else {
                        if(Gate::allows('nivel-1')) {
                            $res->puede=true;
                        }
                        else {
                            $res->puede=false;
                            $res->txt = "Sin criterio de priorización. Solo el propietario puede priorizar una entrevista";
                        }
                    }
                }
                else { //Por si acaso
                    $res->puede=false;
                    $res->txt = "Sin criterio de priorización. Usuario no autenticado";
                }
            }


        }

        return $res;
    }

    //Muestra la prioridad y permite establecerla
    public static function ico_prioridad($entrevista) {
        $priorizar = entrevista_individual::puede_priorizarse($entrevista);
        //if($entrevista->id_entrevista_etnica==4) dd($priorizar);
        if($priorizar->puede) {

            //Determinar subserie y llave primaria
            if(isset($entrevista->id_e_ind_fvt)) {
                $id_subserie=$entrevista->id_subserie;
                $id_entrevista = $entrevista->id_e_ind_fvt;
            }
            elseif(isset($entrevista->id_entrevista_colectiva)) {
                $id_subserie = config('expedientes.co');
                $id_entrevista = $entrevista->id_entrevista_colectiva;
            }
            elseif(isset($entrevista->id_entrevista_etnica)) {
                $id_subserie = config('expedientes.ee');
                $id_entrevista = $entrevista->id_entrevista_etnica;
            }
            elseif(isset($entrevista->id_entrevista_profundidad)) {
                $id_subserie = config('expedientes.pr');
                $id_entrevista = $entrevista->id_entrevista_profundidad;
            }
            elseif(isset($entrevista->id_diagnostico_comunitario)) {
                $id_subserie = config('expedientes.dc');
                $id_entrevista = $entrevista->id_diagnostico_comunitario;
            }
            elseif(isset($entrevista->id_historia_vida)) {
                $id_subserie = config('expedientes.hv');
                $id_entrevista = $entrevista->id_historia_vida;
            }
            else {
                $id_subserie=0;
                $id_entrevista=0;
            }
            $codigo=$entrevista->entrevista_codigo;
            $onclick="mostrar_priorizacion($id_subserie, $id_entrevista, \"$codigo\")";
            $ico="<i class='fa fa-star'></i>";
            $btn = "<button class='btn btn-sm btn-default text-primary' onclick='$onclick' title='Definir la  priorización de esta entrevista' data-toggle='tooltip'>$ico</button>";
            return $btn;
        }
        else {
            if($priorizar->prioridad) {
                $dato = $priorizar->prioridad->ponderacion;
                //dd($priorizar);

                $p = $priorizar->prioridad;
                $d[]="Entrevista fluida: $p->fmt_fluidez";
                $d[]="D. de los hechos: $p->fmt_d_hecho";
                $d[]="D. del contexto: $p->fmt_d_contexto";
                $d[]="D. de los impactos: $p->fmt_d_impacto";
                $d[]="D. de acceso a la justicia y NR: $p->fmt_d_justicia";
                $d[]="Se realiza cierre: $p->fmt_cierre";
                $d[]="Ponderación general: <b>$p->ponderacion</b>";
                $detalle = implode("<li>",$d);
                $detalle="<ul><li>$detalle</ul>";
                $titulo = $priorizar->txt;
                $ico="<a  role='button' tabindex='0' class='btn btn-sm btn-default' title='$titulo'  data-content='$detalle'   data-toggle='popover' data-trigger='focus'><i class='fa fa-star text-primary'></i></a>";
                return $ico;
            }
            else {
                $ico="<i class='fa fa-star-o'></i>";
                $btn = "<button class='btn btn-sm btn-default ' title='$priorizar->txt' data-toggle='tooltip'>$ico</button>";
                return $btn;
            }


        }

    }

    //Muestra la prioridad si la tuviera
    public static function ico_prioridad_read_only($entrevista) {
        $priorizar = entrevista_individual::puede_priorizarse($entrevista);
        if($priorizar->prioridad) {
            $dato = $priorizar->prioridad->ponderacion;
            //dd($priorizar);

            $p = $priorizar->prioridad;
            $d[]="Entrevista fluida: $p->fmt_fluidez";
            $d[]="D. de los hechos: $p->fmt_d_hecho";
            $d[]="D. del contexto: $p->fmt_d_contexto";
            $d[]="D. de los impactos: $p->fmt_d_impacto";
            $d[]="D. de acceso a la justicia y NR: $p->fmt_d_justicia";
            $d[]="Se realiza cierre: $p->fmt_cierre";
            $d[]="Ponderación general: <b>$p->ponderacion</b>";
            if(strlen(trim($p->ahora_entiendo))>0) {
                $d[] = "Elementos explicativos: $p->ahora_entiendo";
            }
            if(strlen(trim($p->cambio_perspectiva))>0) {
                $d[] = "Nuevas explicaciones: $p->cambio_perspectiva";
            }
            //$d[]="Ponderación general: <b>$p->ponderacion</b>";

            $detalle = implode("<li>",$d);
            $detalle="<ul><li>$detalle</ul>";
            $titulo = $priorizar->txt;
            $ico="<a  role='button' tabindex='0' class='btn btn-secondary btn-sm' title='$titulo'  data-content='$detalle'   data-toggle='popover' data-trigger='focus'> $p->ponderacion</a>";
            return $ico;
        }
        else {
            //$ico="<i class='fa fa-star-o'></i>";
            //$btn = "<button class='btn btn-sm btn-default ' title='No se ha establecido priorización' data-toggle='tooltip'>$ico</button>";
            //return $btn;
            return null;
        }

    }

    //Cantidad de veces que ha sido consultada
    public static function conteo_hits($entrevista){
        $id_primaria=0;
        $id_objeto=0;
        if(isset($entrevista->id_e_ind_fvt)) {
            $id_primaria=$entrevista->id_e_ind_fvt;
            $id_objeto = traza_actividad::de_subserie_a_traza($entrevista->id_subserie);
        }
        elseif(isset($entrevista->id_entrevista_colectiva)) {
            $id_primaria=$entrevista->id_entrevista_colectiva;
            $id_objeto = traza_actividad::de_subserie_a_traza(config('expedientes.co'));
        }
        elseif(isset($entrevista->id_entrevista_etnica)) {
            $id_primaria=$entrevista->id_entrevista_etnica;
            $id_objeto = traza_actividad::de_subserie_a_traza(config('expedientes.ee'));
        }
        elseif(isset($entrevista->id_entrevista_profundidad)) {
            $id_primaria=$entrevista->id_entrevista_profundidad;
            $id_objeto = traza_actividad::de_subserie_a_traza(config('expedientes.pr'));
        }
        elseif(isset($entrevista->id_diagnostico_comunitario)) {
            $id_primaria=$entrevista->id_diagnostico_comunitario;
            $id_objeto = traza_actividad::de_subserie_a_traza(config('expedientes.dc'));
        }
        elseif(isset($entrevista->id_historia_vida)) {
            $id_primaria=$entrevista->id_historia_vida;
            $id_objeto = traza_actividad::de_subserie_a_traza(config('expedientes.hv'));
        }
        elseif(isset($entrevista->id_casos_informes)) {
            $id_primaria=$entrevista->id_casos_informes;
            $id_objeto = traza_actividad::de_subserie_a_traza(config('expedientes.ci'));
        }
        $conteo = traza_actividad::id_objeto($id_objeto)->id_primaria($id_primaria)->id_accion(6)->count();
        return $conteo;
    }

    //Cambio de código.  Lo recalcula y si hay cambio, registra el cambio y actualiza la traza
    // No cambia nada per se, el cambio (de entrevistador, tipo o correlativo se debe hacer antes de llamar a esta funcion)
    public function cambiar_codigo() {
        $nuevo = $this->calcular_codigo();
        if($this->entrevista_codigo <> $nuevo) {
            $antiguo = $this->entrevista_codigo;
            $this->entrevista_codigo = $nuevo;
            $this->save();
            $id=$this->id_e_ind_fvt;
            traza_actividad::create(['id_objeto'=>1, 'id_accion'=>66, 'codigo'=>$nuevo, 'referencia'=>"codigo anterior: $antiguo", 'id_primaria'=>$id]);
            traza_actividad::where('codigo',$antiguo)
                ->update(['codigo'=>$nuevo]);
            return $nuevo;

        }
        else {
            return false;
        }

    }
    //Metadatos para el legado

    /**
     * Genera la estructura para el legado
     * Acepta "json" como parametro, por defecto devuelve un stdClass()
     * @param string $tipo
     *
     */
    public function generar_estructura_legado($tipo=null) {
        $e = new \stdClass();
        $e->codigo = $this->entrevista_codigo;
        $e->duracion_minutos = $this->tiempo_entrevista;
        $e->macroterritorio = $this->fmt_id_macroterritorio;
        $e->territorio = $this->fmt_id_territorio;
        $e->fecha_entrevista = new \stdClass();
        $e->fecha_entrevista->inicio    = substr($this->entrevista_fecha,0,10);
        $e->fecha_entrevista->fin    = substr($this->entrevista_fecha,0,10);
        $e->lugar_entrevista = entrevista_individual::desagregar_geo($this->entrevista_lugar);
        $e->medios_vituales = $this->fmt_es_virtual;
        //Hechos
        $e->fecha_hechos = new \stdClass();
        $e->fecha_hechos->inicio = substr($this->hechos_del,0,10);
        $e->fecha_hechos->fin = substr($this->hechos_al,0,10);
        $e->lugar_hechos = entrevista_individual::desagregar_geo($this->hechos_lugar);
        $e->violencia_mencionada = array();
        foreach($this->rel_tv() as $d) {
            $e->violencia_mencionada[] = cat_item::describir($d->id_tv);
        }
        $e->responsable_participante = array();
        foreach($this->rel_aa as $d) {
            $e->responsable_participante[] = cat_item::describir($d->id_aa);
        }

        //CAmpos de clasificación
        $e->sector = $this->fmt_id_sector;
        $e->titulo = $this->titulo;
        $e->dinamicas = array();
        foreach($this->rel_dinamica as  $dinamica) {
            $e->dinamicas[] = $dinamica->dinamica;
        }
        $e->interes_areas = array();
        foreach($this->rel_interes as $d) {
            $e->interes_areas[] = cat_item::describir($d->id_interes);
        }
        foreach($this->rel_interes_area as $d) {
            $e->interes_areas[] = cat_item::describir($d->id_interes);
        }
        $e->interes_mandato = array();
        foreach($this->rel_mandato as $d) {
            $e->interes_mandato[] = cat_item::describir($d->id_mandato);
        }
        $e->anotaciones = $this->anotaciones;

        //Consentimiento informado
        $consentimiento = $this->rel_ficha_entrevista;
        $e->consentimiento_informado = entrevista_individual::desagregar_consentimiento($consentimiento);

        //Listado de adjuntos
        $e->listado_adjuntos = entrevista_individual::desagregar_adjuntos($this->rel_adjunto);


        /////// Fin

        if($tipo=='json') {
            return json_encode($e);
        }
        if($tipo=='xml') {
            $xml = entrevista_individual::generar_xml($e);
            return $xml;
        }

        //Default
        return $e;


    }
    public static function desagregar_geo($id_geo=null, $arreglo=null) {
        if($id_geo > 0) {  //Función recursiva
            $cual = geo::find($id_geo);
            if($cual) {
                $arreglo[$cual->nivel]['codigo'] = $cual->codigo;
                $arreglo[$cual->nivel]['descripcion'] = $cual->descripcion;
                if($cual->nivel==3) {
                    $arreglo[$cual->nivel]['lat'] = $cual->lat;
                    $arreglo[$cual->nivel]['lon'] = $cual->lon;
                }
                return entrevista_individual::desagregar_geo($cual->id_padre,$arreglo); //Llamada recursiva
            }
            else {
                return entrevista_individual::desagregar_geo(null,$arreglo); //Llamada recursiva
            }
        }
        else {  //Fin de la recursividad
            $respuesta = new \stdClass();
            $respuesta->departamento = new \stdClass();
            $respuesta->departamento->codigo = isset($arreglo[1]['codigo']) ? $arreglo[1]['codigo'] : "";
            $respuesta->departamento->descripcion = isset($arreglo[1]['descripcion']) ? $arreglo[1]['descripcion'] : "Desconocido / Sin especificar";
            $respuesta->municipio = new \stdClass();
            $respuesta->municipio->codigo = isset($arreglo[2]['codigo']) ? $arreglo[2]['codigo'] : "";
            $respuesta->municipio->descripcion = isset($arreglo[2]['descripcion']) ? $arreglo[2]['descripcion'] : "Desconocido / Sin especificar";
            $respuesta->vereda_o_equivalente = new \stdClass();
            $respuesta->vereda_o_equivalente->codigo = isset($arreglo[3]['codigo']) ? $arreglo[3]['codigo'] : "";
            $respuesta->vereda_o_equivalente->descripcion = isset($arreglo[3]['descripcion']) ? $arreglo[3]['descripcion'] : "Desconocido / Sin especificar";
            $respuesta->vereda_o_equivalente->latitud = isset($arreglo[3]['lat']) ? $arreglo[3]['lat'] : "";
            $respuesta->vereda_o_equivalente->longitud = isset($arreglo[3]['lon']) ? $arreglo[3]['lon'] : "";
            return $respuesta;
        }

    }
    public static function desagregar_consentimiento($registro) {
        $consentimiento = new \stdClass();
        $consentimiento->esta_de_acuerdo = new \stdClass();
        $consentimiento->esta_de_acuerdo->entrevista = criterio_fijo::describir(2,2);
        $consentimiento->esta_de_acuerdo->grabar_audio = criterio_fijo::describir(2,2);
        $consentimiento->esta_de_acuerdo->informe_final = criterio_fijo::describir(2,2);
        $consentimiento->tratamiento_datos = new \stdClass();
        $consentimiento->tratamiento_datos->analizar_personales = criterio_fijo::describir(2,2);
        $consentimiento->tratamiento_datos->analizar_sensibles = criterio_fijo::describir(2,2);
        $consentimiento->tratamiento_datos->utilizar_en_informe_personales = criterio_fijo::describir(2,2);
        $consentimiento->tratamiento_datos->utilizar_en_informe_sensibles = criterio_fijo::describir(2,2);
        $consentimiento->tratamiento_datos->publicar_nombre_en_informe = criterio_fijo::describir(2,2);

        if($registro) {
            $consentimiento->esta_de_acuerdo->entrevista = criterio_fijo::describir(2,$registro->conceder_entrevista);
            $consentimiento->esta_de_acuerdo->grabar_audio = criterio_fijo::describir(2,$registro->grabar_audio);
            $consentimiento->esta_de_acuerdo->informe_final = criterio_fijo::describir(2,$registro->elaborar_informe);
            //
            $consentimiento->tratamiento_datos->analizar_personales = criterio_fijo::describir(2,$registro->tratamiento_datos_analizar);
            $consentimiento->tratamiento_datos->analizar_sensibles = criterio_fijo::describir(2, $registro->tratamiento_datos_analizar_sensible);
            $consentimiento->tratamiento_datos->utilizar_en_informe_personales = criterio_fijo::describir(2, $registro->tratamiento_datos_utilizar);
            $consentimiento->tratamiento_datos->utilizar_en_informe_sensibles =  criterio_fijo::describir(2, $registro->tratamiento_datos_utilizar_sensible);
            $consentimiento->tratamiento_datos->publicar_nombre_en_informe =     criterio_fijo::describir(2, $registro->tratamiento_datos_publicar);
            //
            if($registro->id_entrevista_etnica > 0) {
                $consentimiento->esta_de_acuerdo->grabar_video = criterio_fijo::describir(2, $registro->grabar_video);
                $consentimiento->esta_de_acuerdo->tomar_fotografias = criterio_fijo::describir(2, $registro->tomar_fotografia);
            }
        }
        return $consentimiento;
    }
    public static function desagregar_adjuntos($rel) {
        //dd($rel);
        $adjuntos = array();
        foreach($rel as $d) {
            $i = new  \stdClass();
            $i->tipo = criterio_fijo::describir(1,$d->id_tipo);
            $i->nombre = $d->fmt_nombre_legado;
            $adjuntos[] = $i;
        }
        return $adjuntos;
    }

    //Generar XML
    // function defination to convert array to xml
    public static function generar_xml($objeto) {
        $convertidor = Serializer::create()->build();

        return $convertidor->serialize($objeto,'xml');
    }

    //////////////// panel para explorar fichas /////////
    public static function conteos_dash_fichas() {
        $conteos = new \stdClass();
        $conteos->entrevistas = 0;
        $conteos->victimas = 0;
        $conteos->persona_entrevistada = 0;
        $conteos->responsable_individual = 0;
        //Entrevistas con fichas diligenciadas
        $query_base = entrevista_individual::where('id_activo',1)->where('fichas_estado',1);
        $query = clone $query_base;
        $conteos->entrevistas = $query->count();
        $query = clone $query_base;
        $conteos->victimas = $query->join('fichas.victima','e_ind_fvt.id_e_ind_fvt','=','victima.id_e_ind_fvt')
                                    ->join('fichas.persona','persona.id_persona','=','victima.id_persona')
                                    ->count();
        $query = clone $query_base;
        $conteos->persona_entrevistada = $query->join('fichas.persona_entrevistada','e_ind_fvt.id_e_ind_fvt','=','persona_entrevistada.id_e_ind_fvt')
            ->join('fichas.persona','persona.id_persona','=','persona_entrevistada.id_persona')
            ->count();

        $query = clone $query_base;
        $conteos->responsable_individual = $query->join('fichas.persona_responsable','e_ind_fvt.id_e_ind_fvt','=','persona_responsable.id_e_ind_fvt')
            ->join('fichas.persona','persona.id_persona','=','persona_responsable.id_persona')
            ->count();

        return $conteos;
    }

    //Tipo de entrevista
    public static function subserie_tipo_entrevista($id_subserie) {
        $cual = cat_item::find($id_subserie);
        $txt="XX";
        if($cual) {
            if(strlen($cual->abreviado) > 0) {
                $txt= $cual->abreviado;
            }
        }
        return $txt;
    }

    //Para debuguear queries en la consola directamente
    public static function getQueries( $builder) {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }



    //Para diligenciar persona entrevistada, usado en AA y TC
    public function crear_persona_entrevistada() {
        $nueva_persona = new persona();
        $nueva = new persona_entrevistada();

        //$nueva_persona->nombre = $this->entrevistado_nombres;
        //$nueva_persona->alias = $this->entrevistado_apellidos;
        //$nueva_persona->insert_ent = \Auth::user()->id_entrevistador;
        //$nueva_persona->insert_ip =\Request::ip();
        //$nueva_persona->insert_fh = \Carbon\Carbon::now();

        $consentimiento = entrevista::where('id_entrevista_profundidad',$this->id_entrevista_profundidad)->first();
        if($consentimiento) {
            $nueva_persona->num_documento = substr($consentimiento->identificacion_consentimiento,0,20);
        }
        $nueva_persona->save();
        $nueva = new persona_entrevistada();
        $nueva->id_entrevista_profundidad = $this->id_entrevista_profundidad;
        $nueva->id_persona = $nueva_persona->id_persona;
        $nueva->insert_ent = \Auth::user()->id_entrevistador;
        $nueva->insert_ip =\Request::ip();
        $nueva->insert_fh = \Carbon\Carbon::now();
        $nueva->save();

        return $nueva;


    }

    /**
     * Determina si una entrevista está completa.  Usado para paz y salvo
     */
    public static function esta_completa($entrevista) {
        //VAlores = 0: no Aplica, 1: Sí, 2: No
        $criterio['consentimiento']=1; //Sí
        $criterio['audio']=1; //Sí
        $criterio['relatoria']=0; //N/A
        $criterio['ficha_entrevistado']=0; //N/A
        $criterio['completo']=1;

        //Tiene ficha de persona entrevistada?
        if(isset($entrevista->id_subserie)) {
            if($entrevista->id_subserie == config('expedientes.vi')) {
                if($entrevista->rel_ficha_persona_entrevistada) {
                    $criterio['ficha_entrevistado']=1; //Completo
                }
                else {
                    $criterio['ficha_entrevistado']=2; //Sin ficha
                    $criterio['completo']=2; //Incompleto
                }
            }
            else {
                $criterio['ficha_entrevistado']=0; //No aplica
            }
        }
        else {
            $criterio['ficha_entrevistado']=0; //No aplica
            //Las tablas sin id_subserie son entrevistas que deben tener relatoria
            if($entrevista->rel_adjunto()->where('id_tipo',11)->count() == 0) {
                $criterio['relatoria']=2; //Sin relatoria
                $criterio['completo']=2; //Incompleto
            }

        }
        //Tiene consentimiento informado?
        if($entrevista->es_virtual == 2) {  //Las entrevistas virtuales no requieren consentimiento informado
            if($entrevista->rel_adjunto()->where('id_tipo',1)->count() == 0) {
                $criterio['consentimiento']=2; //Sin consentimiento
                $criterio['completo']=2; //Incompleto
            }
        }

        //Tiene audio?
        if($entrevista->rel_adjunto()->where('id_tipo',2)->count() == 0) {
            $criterio['audio']=2; //Sin audio
            $criterio['completo']=2; //Incompleto
        }

        return $criterio;

    }



    //Para los JSON que se perdieron el 28-oct-20, pero que el contenido está en la BD
    public static function rescatar_etiquetado($entrevista) {
        $creados=0;
        $revisados=0;
        $listado = $entrevista->rel_adjunto()->where('id_tipo',25)->get();
        foreach($listado as $adjuntado) {
            $revisados++;
            $adjunto = $adjuntado->rel_id_adjunto;
            if(!$adjunto->existe) {
                $json = $entrevista->json_etiquetado;
                $nombre = $adjunto->ubicacion;
                Storage::put("public/".$nombre,$json);
                $creados++;
            }
        }
        return ['revisados'=>$revisados, 'creados'=>$creados];
    }
    //Para los OTR que se perdieron el 28-oct-20, pero que el contenido está en la BD
    public static function rescatar_transcripcion($entrevista) {
        $creados=0;
        $revisados=0;
        $listado = $entrevista->rel_adjunto()->where('id_tipo',6)->get();
        foreach($listado as $adjuntado) {
            $revisados++;
            $adjunto = $adjuntado->rel_id_adjunto;
            if(!$adjunto->existe) {
                $nombre = $adjunto->ubicacion;
                Storage::put("public/".$nombre,$entrevista->html_transcripcion);
                $creados++;
            }
        }
        return ['revisados'=>$revisados, 'creados'=>$creados];
    }
    public static function rescatar_otr($entrevista) {
        $creados=0;
        $revisados=0;
        $listado = $entrevista->rel_adjunto()->where('id_tipo',16)->get();
        //$tags="<!DOCTYPE html><html><head><meta charset='utf-8'></head><body>";
        $tags[]="<!DOCTYPE html>";
        $tags[]="<html>";
        $tags[]="</html>";
        $tags[]="<head>";
        $tags[]="</head>";
        $tags[]="<meta charset='utf-8'>";
        $tags[]="<body>";
        $tags[]="</body>";
        foreach($listado as $adjuntado) {
            $revisados++;
            $adjunto = $adjuntado->rel_id_adjunto;
            if(!$adjunto->existe) {
                $transcripcion = str_replace($tags, "",$entrevista->html_transcripcion);
                $tmp['text']=$transcripcion;
                $tmp['media']="";
                $tmp['media-source']="";
                $tmp['media-time']="";
                $json = json_encode($tmp);
                $nombre = $adjunto->ubicacion;
                Storage::put("public/".$nombre,$json);
                $creados++;
            }
        }
        return ['revisados'=>$revisados, 'creados'=>$creados];
    }

    //Arreglar masivamente varias entrevistas
    public static function revision_20220428() {
        $res=[];
        $listado = self::wherein('id_e_ind_fvt',[2195,3592,92,5353,217,8461,7446,8412,8203,8203,8270,8311,8405,8407])->get();
        foreach($listado as $e) {
            $res[] = self::rescatar_etiquetado($e);
        }
        $listado = entrevista_profundidad::wherein('id_entrevista_profundidad',[92,141])->get();
        foreach($listado as $e) {
            $res[] = self::rescatar_etiquetado($e);
        }
        $listado = entrevista_colectiva::wherein('id_entrevista_colectiva',[217])->get();
        foreach($listado as $e) {
            $res[] = self::rescatar_etiquetado($e);
        }



        return $res;
    }
}



