<?php

namespace App\Models;

use Eloquent as Model;
use http\Env\Request;

/**
 * Class hecho
 * @package App\Models
 * @version October 13, 2019, 2:05 pm -05
 *
 * @property \App\Models\Catalogos.geo idLugar
 * @property \App\Models\Catalogos.catItem idLugarTipo
 * @property integer id_lugar
 * @property integer id_e_ind_fvt
 * @property string sitio_especifico
 * @property integer id_lugar_tipo
 * @property integer fecha_ocurrencia_d
 * @property integer fecha_ocurrencia_m
 * @property integer fecha_ocurrencia_a
 * @property integer fecha_fin_d
 * @property integer fecha_fin_m
 * @property integer fecha_fin_a
 * @property integer cantidad_victimas
 * @property integer aun_continuan
 * @property string observaciones
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 * @property integer insert_ent
 * @property string insert_ip
 * @property time insert_fh
 * @property integer update_ent
 * @property string update_ip
 * @property time update_fh
 */
class hecho extends Model
{

    public $table = 'fichas.hecho';
    protected $primaryKey = 'id_hecho';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_lugar',
        'cantidad_victimas',
        'sitio_especifico',
        'id_lugar_tipo',
        'fecha_ocurrencia_d',
        'fecha_ocurrencia_m',
        'fecha_ocurrencia_a',
        'fecha_fin_d',
        'fecha_fin_m',
        'fecha_fin_a',
        'aun_continuan',
        'observaciones',
        'created_at',
        'updated_at'
        ,'insert_fh'
        ,'insert_ent'
        ,'insert_ip'
        ,'update_fh'
        ,'update_ent'
        ,'update_ip'
        ,'id_entrevista_etnica'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_hecho' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_lugar' => 'integer',
        'cantidad_victimas' => 'integer',
        'sitio_especifico' => 'string',
        'id_lugar_tipo' => 'integer',
        'fecha_ocurrencia_d' => 'integer',
        'fecha_ocurrencia_m' => 'integer',
        'fecha_ocurrencia_a' => 'integer',
        'fecha_fin_d' => 'integer',
        'fecha_fin_m' => 'integer',
        'fecha_fin_a' => 'integer',
        'aun_continuan' => 'integer',
        'observaciones' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'id_hecho' => 'required',
        'id_lugar' => 'required',
        'id_lugar_tipo' => 'required',
        'aun_continuan' => 'required'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['cantidad_victimas']=1;
    }

    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }

    // Ajuste entrevista colectiva etnica marzo:2020
    public function rel_id_entrevista_etnica() {
        return $this->belongsTo(entrevista_etnica::class,'id_entrevista_etnica','id_entrevista_etnica');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_lugar()
    {
        return $this->belongsTo(geo::class, 'id_lugar','id_geo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function rel_id_lugar_tipo()
    {
        return $this->belongsTo(cat_item::class, 'id_lugar_tipo','id_item');
    }

    /**
     * @return hecho_violencia
     */
    public function rel_violencia()
    {
        return $this->hasMany(hecho_violencia::class, 'id_hecho', 'id_hecho')->orderby('id_hecho_violencia')->orderby('hecho_violencia.id_subtipo_violencia');
    }
    public function rel_responsabilidad()
    {
        return $this->hasMany(hecho_responsabilidad::class, 'id_hecho', 'id_hecho')->orderby('hecho_responsabilidad.aa_id_subtipo')->orderby('hecho_responsabilidad.tc_id_subtipo');
    }
    public function rel_responsable()
    {
        return $this->hasMany(hecho_responsable::class, 'id_hecho', 'id_hecho');
    }
    public function rel_victima()
    {
        return $this->hasMany(hecho_victima::class, 'id_hecho', 'id_hecho');
    }
    public function rel_contexto()
    {
        return $this->hasMany(hecho_contexto::class, 'id_hecho', 'id_hecho');
    }

    //filtros
    public static function scopeOrdenado($query) {
        $query->orderBy('fecha_ocurrencia_a')
            ->orderBy('fecha_ocurrencia_m')
            ->orderBy('fecha_ocurrencia_d')
            ->orderBy('hecho.id_hecho');
    }
    public static function scopeIdEntrevista($query,$criterio=0) {
        if($criterio>0) {
            $query->where('id_e_ind_fvt',$criterio);
        }
    }
    //Formatos para show
    public function getFmtFechaOcurrenciaAttribute() {
        return $this->mostrar_fecha_incompleta($this->fecha_ocurrencia_d,$this->fecha_ocurrencia_m, $this->fecha_ocurrencia_a);
    }
    public function getFmtFechaFinAttribute() {
        return $this->fecha_fin_a > 0 ? $this->mostrar_fecha_incompleta($this->fecha_fin_d,$this->fecha_fin_m, $this->fecha_fin_a) : "No aplica";
    }
    public function getFmtAunContinanAttribute() {
        $this->aun_continuan==1 ?  "Los hechos aún continúan" : "No aplica";
    }
    public function getFmtIdLugarAttribute() {
        return geo::nombre_completo($this->id_lugar);
    }
    public function getFmtViolenciaAttribute() {
        $violencia=array();
        foreach($this->rel_violencia as $viol) {
            $violencia[] = $viol->fmt_id_tipo_violencia;
        }
        if(count($violencia)>0) {
            $str="<ul>";
            foreach($violencia as $txt) {
                $str.="<li>$txt</li>";
            }
            $str.="</ul>";
        }
        else {
            $str = "<span class='text-danger'>Sin especificar</span>";
        }
        return $str;
    }
    public function getFmtResponsabilidadAttribute() {
        $arr=array();
        foreach($this->rel_responsabilidad as $res) {
            $arr[]=$res->fmt_responsabilidad;
        }
        if(count($arr)>0) {
            $str="<ul>";
            foreach($arr as $item) {
                $str.="<li>$item</li>";
            }
            $str.="</ul>";
        }
        else {
            $str = "<span class='text-danger'>Sin especificar</span>";
        }
        return $str;
    }
    public function getFmtIdLugarTipoAttribute() {
        return cat_item::describir($this->id_lugar_tipo);
    }

    public function getFmtResponsableAttribute() {
        $arr=array();
        foreach($this->rel_responsable as $res) {
            $arr[]=$res->rel_id_persona->nombre_completo;
        }
        if(count($arr)>0) {
            $str="<ul>";
            foreach($arr as $item) {
                $str.="<li>$item</li>";
            }
            $str.="</ul>";
        }
        else {
            $str="Sin especifciar";
        }
        return $str;
    }

    //Este getter me permite determinar sin en la interfaz de hechos, muestro el bloque de responsable individual
    public function getFmtIdIdentificaPriAttribute() {
        //$entrevista = $this->rel_id_e_ind_fvt;
        return $this->rel_responsable()->count() > 0 ? 1 : 2;
    }



    //Para la edicion
    public function getFechaOcurrenciaAttribute() {
        return $this->editar_fecha_incompleta($this->fecha_ocurrencia_d, $this->fecha_ocurrencia_m, $this->fecha_ocurrencia_a) ;
    }
    public function getFechaFinAttribute() {
        return $this->editar_fecha_incompleta($this->fecha_fin_d, $this->fecha_fin_m, $this->fecha_fin_a) ;
    }


    // Logica propia

    public function valores_predeterminados($entrevista) {
        
        if(is_object($entrevista)) {
            
            if ($entrevista->tipo() =='individual') {               
                
                $this->id_e_ind_fvt = $entrevista->id_entrevista;
                

                $this->fecha_ocurrencia_d=substr($entrevista->hechos_del,8,2);
                $this->fecha_ocurrencia_m=substr($entrevista->hechos_del,5,2);
                $this->fecha_ocurrencia_a=substr($entrevista->hechos_del,0,4);
                $this->aun_continuan = 2;
                $this->cantidad_victimas = 1;

                if( $entrevista->hechos_lugar >0) {
                    $this->id_lugar = $entrevista->hechos_lugar;
                }
                elseif( $entrevista->entrevista_lugar >0) {
                    $this->id_lugar = $entrevista->entrevista_lugar;
                }
                else {
                    $this->id_lugar=null;
                }                

            } else {
                $this->id_entrevista_etnica = $entrevista->id();
                $this->cantidad_victimas = null;
            }
            // $this->id_e_ind_fvt = $entrevista->id_e_ind_fvt;


            $this->insert_ent=\Auth::user()->id_entrevistador;
            $this->insert_fh=\Carbon\Carbon::now();
            $this->insert_ip=\Request::ip();
        }
    }
    public function getConteoViolacionesAttribute() {          
        $violaciones = $this->rel_violencia()->count();        
        $victimas = $this->cantidad_victimas;
        return $victimas*$violaciones;
    }


    //Para editar el contexto, le paso el id_cat porque todos los contextos usan la misma tabla, solo cambia el catalogo
    public function arreglo_contexto($id_cat) {
        $arreglo=array();
        foreach($this->rel_contexto as $item) {
            if($item->rel_id_contexto->id_cat == $id_cat) {
                $arreglo[]=$item->id_contexto;
            }
        }
        return $arreglo;
    }
    //Para mostrarlos
    public function arreglo_contexto_txt($id_cat) {
        $arreglo=array();
        foreach($this->rel_contexto as $item) {
            if($item->rel_id_contexto->id_cat == $id_cat) {
                $arreglo[$item->id_contexto]=$item->rel_id_contexto->descripcion;
            }
        }
        if(count($arreglo)<1) {
            $arreglo[0]='Sin especificar / No aplica';
        }
        return $arreglo;
    }

    // Determinar si la ficha está completa
    public function getControlCalidadAttribute() {
        $conteos=new \stdClass();
        $conteos->violencia=0;  //Violencias especificadas
        $conteos->responsabilidad=0;  //Responsabilidad especificada
        $conteos->victima=0; //Fichas de victima asociadas
        $conteos->contexto=1; //Contexto especificado
        $conteos->hay_exilio=false;  //Determinar si se ha especificado exilio en los tipos de violencia
        $conteos->exilio=0; //Cantidad de fichas de exilio (calculado por entrevista)
        $conteos->completo=true;
        $conteos->alarma=array();

        //Determinar si se ha especificado exilio como tipo de violencia
        $con_exilio = hecho_violencia::join('catalogos.violencia','hecho_violencia.id_subtipo_violencia','=','violencia.id_geo')
            ->where('hecho_violencia.id_hecho',$this->id_hecho)
            ->where('violencia.codigo','2201')
            ->count();

        if($con_exilio > 0) {
            $conteos->hay_exilio = true;
        }



        //
        $conteos->violencia = $this->rel_violencia()->count();
        if($conteos->violencia==0) {
            $conteos->alarma[] = 'No se han indicado los tipos de violencia';
            $conteos->completo=false;
        }


        if ($this->tipo_expediente()=='individual') {
            $conteos->victima = $this->rel_victima()->count();
            if($conteos->victima==0) {
                $conteos->alarma[] = 'No se han seleccionado las víctimas para el hecho';
                $conteos->completo=false;
            }
        }

        $conteos->responsabilidad = $this->rel_responsabilidad()->count();
        if($conteos->responsabilidad==0) {
            $conteos->alarma[] = 'No se ha indicado la responsabilidad colectiva';
            $conteos->completo=false;
        }

        $conteos->contexto = $this->rel_contexto()->count();
        if($conteos->contexto==0) {
            $conteos->alarma[] = 'No se ha diligenciado la información de contexto';
            $conteos->completo=false;
        }
        /*
        if($conteos->hay_exilio) {
            $entrevista = $this->rel_id_e_ind_fvt;
            $fichas_exilio =$entrevista->rel_ficha_exilio()->count();

            if($fichas_exilio==0) {
                $conteos->alarma[]="Falta completar la información de exilio";
                $conteos->completo=false;
            }
            else {
                //Revisar alertas de las fichas
                foreach($entrevista->rel_ficha_exilio as $f_exilio) {
                    if(!$f_exilio->fmt_completo->completa) {
                        $conteos->completo=false;
                        foreach($f_exilio->fmt_completo->alerta as $txt) {
                            $conteos->alarma[]="Exilio: $txt";
                        }
                    }
                }

            }
        }
        */
        
        $conteos->fmt_completo = $conteos->completo ? '<span class="label label-success">Completa</span>' : '<span class="label label-warning">Pendiente</span>';



        return $conteos;

    }


    //Para mostrar la información del hecho en el show de victima

    /**
     * Para obtener los datos propios de la victima
     * @param int $id_persona
     * @return mixed
     */
    public function datos_victima($id_persona=0) {
        $info = persona::join('fichas.victima','persona.id_persona','=','victima.id_persona')
                        ->join('fichas.hecho_victima','victima.id_victima','=','hecho_victima.id_victima')
                        ->where('persona.id_persona',$id_persona)
                        ->where('hecho_victima.id_hecho', $this->id_hecho)
                        ->first();
        if(is_object($info)) {
            return hecho_victima::find($info->id_hecho_victima);
        }
        else {
            return null;
        }

    }


    /*
     * Manejo de fechas incompletas: para mostrar y para editar
     */

    //Muestra dd-mm-aaaa
    public static function mostrar_fecha_incompleta($d=0,$m=0,$a=0) {
        $pieza=array();
        if($d>0) {
            $pieza[] =   str_pad(intval($d),2,'0',STR_PAD_LEFT);
        }
        if($m>0) {
            $pieza[] =   str_pad(intval($m),2,'0',STR_PAD_LEFT);
        }
        if($a>0) {
            $pieza[] =   str_pad(intval($a),4,'0',STR_PAD_LEFT);
        }
        return count($pieza)==0 ? "Sin especificar" :  implode("-",$pieza);
    }
    //Muestra aaaa-mm-dd
    public static function editar_fecha_incompleta($d=0,$m=0,$a=0) {
        $pieza=array();
        if($a>0) {
            $pieza[] =   str_pad(intval($a),4,'0',STR_PAD_LEFT);
        }
        if($m>0) {
            $pieza[] =   str_pad(intval($m),2,'0',STR_PAD_LEFT);
        }
        if($d>0) {
            $pieza[] =   str_pad(intval($d),2,'0',STR_PAD_LEFT);
        }
        return implode("-",$pieza);
    }

    // Tipo de hecho, segun sea para entrevista individual o para sujeto colectivo étnico

    public function tipo_expediente() {

        if (!empty($this->id_e_ind_fvt) && empty($this->id_entrevista_etnica))
            return 'individual';
        else if (empty($this->id_e_ind_fvt) && !empty($this->id_entrevista_etnica)) {
            return 'etnica';
        }

        return 'error'; 
    }

    public function getIdEntrevistaAttribute() {

        return ($this->tipo_expediente() == 'individual' ? $this->id_e_ind_fvt : $this->id_entrevista_etnica);
    }

    public function getControllerAttribute() {

        return ($this->tipo_expediente() == 'individual' ? 'entrevista_individualController' : 'entrevista_etnicaController');
    }

    public function expediente() {
                
        return ($this->tipo_expediente() == 'individual' ? $this->rel_id_e_ind_fvt : $this->rel_id_entrevista_etnica);
    }

    public function getCampoIdTipoEntrevistaAttribute() {

        return ($this->tipo_expediente() == 'individual' ? 'id_e_ind_fvt' : 'id_entrevista_etnica');
    }

    public static function si_valida_campos() {

        if(isset($_POST['etnica']))
            return false;

        return true;
    }

}
