<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
/**
 * @property int $id_exilio
 * @property int $id_e_ind_fvt
 * @property int $id_tipo
 * @property int $id_ha_tenido_retorno
 * @property string $entidad_apoyo_retorno
 * @property int $id_ha_tenido_ayuda
 * @property string $institucion_ayuda
 * @property int $id_retorno
 * @property int $id_otro_exilio
 * @property string $created_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 * @property Fichas.exilioMovimiento[] $fichas.exilioMovimientos
 * @property Fichas.exilioImpacto[] $fichas.exilioImpactos
 * @property Fichas.exilioCategorium[] $fichas.exilioCategorias
 * @property Fichas.exilioMotivo[] $fichas.exilioMotivos
 */
class exilio extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fichas.exilio';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id_exilio';
    
    public $timestamps = false;



    public $fillable = [
        'id_e_ind_fvt',
        'id_tipo',
        'id_ha_tenido_retorno',
        'entidad_apoyo_retorno',
        'id_ha_tenido_ayuda',
        'institucion_ayuda',
        'id_retorno',
        'id_otro_exilio',
        'created_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_exilio' => 'integer',
        'id_e_ind_fvt' => 'integer',
        'id_tipo' => 'integer',
        'id_ha_tenido_retorno' => 'integer',
        'entidad_apoyo_retorno' => 'string',
        'id_ha_tenido_ayuda' => 'integer',
        'institucion_ayuda' => 'string',
        'id_retorno' => 'integer',
        'id_otro_exilio' => 'integer',
        'created_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'id_e_ind_fvt' => 'required',

    ];
    /*
     * RELACIONES a otros modelos
     */

    //Referencias
    public function rel_id_e_ind_fvt() {
        return $this->belongsTo(entrevista_individual::class,'id_e_ind_fvt','id_e_ind_fvt');
    }


    //Detalles
    public function rel_exilio_categoria() {
        return $this->hasMany(exilio_categoria::class,'id_exilio','id_exilio');
    }
    public function rel_exilio_movimiento() {
        return $this->hasMany(exilio_movimiento::class,'id_exilio','id_exilio')->orderby('exilio_movimiento.id_tipo_movimiento')->orderby('exilio_movimiento.id_exilio_movimiento');
    }
    public function rel_exilio_impacto() {
        return $this->hasMany(exilio_impacto::class,'id_exilio','id_exilio');
    }

    /*
     * GETTERS
     */
    //Mostrar el detalle de controles multiiples
    public function getArregloFmtCategoriaAttribute() {
        $arreglo = array();
        foreach($this->rel_exilio_categoria as $categoria) {
            $arreglo[] = $categoria->fmt_id_categoria;
        }
        return $arreglo;
    }

    //Edicion de controles múltiples
    public function getArregloIdCategoriaAttribute() {
        $arreglo=array();
        foreach($this->rel_exilio_categoria as $cual) {
            $arreglo[]=$cual->id_categoria;
        }
        return $arreglo;
    }
    //Para editar losimpactos, le paso el id_cat porque todos hay varios que usan la misma tabla, solo cambia el catalogo
    public function arreglo_impacto($id_cat) {
        $arreglo=array();
        foreach($this->rel_exilio_impacto as $item) {
            if($item->rel_id_impacto->id_cat == $id_cat) {
                $arreglo[]=$item->id_impacto;
            }
        }
        return $arreglo;
    }
    // FORMATOS
    public function getFmtIdHaTenidoRetornoAttribute() {
        return $this->id_ha_tenido_retorno ==1 ? 'Sí' : 'No';
    }
    public function getFmtIdHaTenidoAyudaAttribute() {
        return $this->id_ha_tenido_ayuda ==1 ? 'Sí' : 'No';
    }
    public function getFmtIdOtroExilioAttribute() {
        return $this->id_otro_exilio ==1 ? 'Sí' : 'No';
    }

    /*
     * LOGICA del modelo
     */
    //Para el create/edit
    public function procesar_detalle($request) {
        $this->rel_exilio_categoria()->delete();
        foreach($request->id_categoria as $id) {
            if($id >0) {
                $nuevo =new exilio_categoria();
                $nuevo->id_exilio =$this->id_exilio;
                $nuevo->id_categoria = $id;
                $nuevo->save();
            }
        }
    }
    //Para cuando se crea un retorno
    public function procesar_detalle_retorno($request) {
        //Para no borrar los impactos del exilio, sino que unicamente los impactos del retorno
        foreach($this->rel_exilio_impacto as $impacto) {
            if(in_array($impacto->rel_id_impacto->id_cat,[212,213,214,215,216])) {
                $impacto->delete();
            }
        }
        if($request->id_ha_tenido_retorno==1) {
            if(is_array($request->id_impacto)) {
                foreach ($request->id_impacto as $id) {
                    if ($id > 0) {
                        $nuevo = new exilio_impacto();
                        $nuevo->id_exilio = $this->id_exilio;
                        $nuevo->id_impacto = $id;
                        $nuevo->save();
                    }
                }
            }

        }
    }
    //para cuando se llenan los datos del retorno
    public function actualizar_retorno($request) {
        $this->id_ha_tenido_retorno = $request->id_ha_tenido_retorno;
        if($this->id_ha_tenido_retorno==1) { //Los asigno sólo si ha tenido retorno
            $this->entidad_apoyo_retorno = $request->entidad_apoyo_retorno;
            $this->id_ha_tenido_ayuda = $request->id_ha_tenido_ayuda;
            $this->institucion_ayuda = $request->institucion_ayuda;
            $this->id_otro_exilio = $request->id_otro_exilio;
        }

        $this->save();
        //dd($request);
    }

    //Formulario de impactos
    public function procesar_impactos($request) {
        //Para  borrar los impactos del exilio, y no  los impactos del retorno
        foreach($this->rel_exilio_impacto as $impacto) {
            if(in_array($impacto->rel_id_impacto->id_cat,[208,209,210,211])) {
                $impacto->delete();
            }
        }
        if(is_array($request->id_impacto)) {
            foreach ($request->id_impacto as $id) {
                if ($id > 0) {
                    $nuevo = new exilio_impacto();
                    $nuevo->id_exilio = $this->id_exilio;
                    $nuevo->id_impacto = $id;
                    $nuevo->save();
                }
            }
        }

    }


    public function crear_movimiento($request) {

        //aunque no haya retorno, siempre se crea con valores en blanco, para grabar los motivos por los que no ha retornado.
        $nuevo = new exilio_movimiento();
        $nuevo->completar_traza_insert();
        $input = $request->all();

        if($request->id_tipo_movimiento == 3) {
            if($request->id_ha_tenido_retorno <> 1 ) { //Campos en blanco
                unset($datos);
                $datos['id_tipo_movimiento']=3;
            }
        }


        //Lugar de salida
        if (isset($request->id_lugar_salida)) {
            if ($request->id_lugar_salida < 1) {
                if ($request->id_lugar_salida_muni > 0) {
                    $input['id_lugar_salida'] = $request->id_lugar_salida_muni;
                } elseif ($request->id_lugar_salida_depto > 0) {
                    $input['id_lugar_salida'] = $request->id_lugar_salida_depto;
                }
            }
        }
        //Lugar de llegada
        if (isset($request->id_lugar_llegada)) {
            if ($request->id_lugar_llegada < 1) {
                if ($request->id_lugar_llegada_muni > 0) {
                    $input['id_lugar_llegada'] = $request->id_lugar_llegada_muni;
                } elseif ($request->id_lugar_salida_depto > 0) {
                    $input['id_lugar_llegada'] = $request->id_lugar_llegada_depto;
                }
            }
        }
        // Lugar de asentamiento
        if (isset($request->id_lugar_llegada_2)) {
            if ($request->id_lugar_llegada_2 < 1) {
                if ($request->id_lugar_llegada_2_muni > 0) {
                    $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_muni;
                } elseif ($request->id_lugar_llegada_2_depto > 0) {
                    $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_depto;
                }
            }
        }
        //dd($request);





        $nuevo->fill($input);
        $nuevo->id_exilio=$this->id_exilio;
        $nuevo->save();
        $nuevo->procesar_detalle($request);
        if($request->id_tipo_movimiento == 3) {
            $this->procesar_detalle_retorno($request);
        }
        //Traza
        $exilio = exilio::find($nuevo->id_exilio);
        $entrevista = entrevista_individual::find($exilio->id_e_ind_fvt);
        traza_actividad::create(['id_objeto'=>111, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo,  'id_primaria'=>$nuevo->id_exilio_movimiento]);
    }
    public function actualizar_movimiento($request) {
        $movimiento = exilio_movimiento::find($request->id_exilio_movimiento);


        if($movimiento) {
            $input = $request->all();

            //Lugar de salida
            if (isset($request->id_lugar_salida)) {
                if ($request->id_lugar_salida < 1) {
                    if ($request->id_lugar_salida_muni > 0) {
                        $input['id_lugar_salida'] = $request->id_lugar_salida_muni;
                    } elseif ($request->id_lugar_salida_depto > 0) {
                        $input['id_lugar_salida'] = $request->id_lugar_salida_depto;
                    }
                }
            }
            //Lugar de llegada
            if (isset($request->id_lugar_llegada)) {
                if ($request->id_lugar_llegada < 1) {
                    if ($request->id_lugar_llegada_muni > 0) {
                        $input['id_lugar_llegada'] = $request->id_lugar_llegada_muni;
                    } elseif ($request->id_lugar_salida_depto > 0) {
                        $input['id_lugar_llegada'] = $request->id_lugar_llegada_depto;
                    }
                }
            }
            // Lugar de asentamiento
            if (isset($request->id_lugar_llegada_2)) {
                if ($request->id_lugar_llegada_2 < 1) {
                    if ($request->id_lugar_llegada_2_muni > 0) {
                        $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_muni;
                    } elseif ($request->id_lugar_llegada_2_depto > 0) {
                        $input['id_lugar_llegada_2'] = $request->id_lugar_llegada_2_depto;
                    }
                }
            }

            $movimiento->fill($input);
            $movimiento->completar_traza_update();
            $movimiento->save();
            $movimiento->procesar_detalle($request);
            //Traza
            $exilio = exilio::find($movimiento->id_exilio);
            $entrevista = entrevista_individual::find($exilio->id_e_ind_fvt);
            traza_actividad::create(['id_objeto'=>111, 'id_accion'=>4, 'codigo'=>$entrevista->entrevista_codigo,  'id_primaria'=>$movimiento->id_exilio_movimiento]);
        }

    }
    /*
     * Primera sección de la ficha de exilio
     */
    public function primera_salida() {
        return $this->rel_exilio_movimiento()->where('id_tipo_movimiento',1)->first();
    }
    /*
     * Para mostrar los reasentamientos
     */
    public function listar_reasentamientos() {
        return $this->rel_exilio_movimiento()->where('id_tipo_movimiento',2)->ordenado()->get();
    }
    /*
     * Para mostrar el retorno
     */
    public function retorno() {
        return $this->rel_exilio_movimiento()->where('id_tipo_movimiento',3)->first();
    }

    /*
     * FILTROS
     */
    public function scopeOrdenado($query) {
        $query->leftjoin('fichas.exilio_movimiento as em','exilio.id_exilio','=','em.id_exilio')
                ->where('em.id_tipo_movimiento',1)
                //->orderby('em.id_tipo_movimiento')
                ->orderby('fecha_salida_a')
                ->orderby('fecha_salida_m')
                ->orderby('fecha_salida_d');
    }

    public function getFmtCompletoAttribute() {
        $respuesta = new \stdClass();
        $respuesta->completa=true;
        $respuesta->alerta = array();
        $respuesta->mov_1 = $this->rel_exilio_movimiento()->where('id_tipo_movimiento',1)->count();
        $respuesta->mov_3 = $this->rel_exilio_movimiento()->where('id_tipo_movimiento',3)->count();
        $respuesta->impactos = exilio_impacto::where('id_exilio',$this->id_exilio)
                                    ->join('catalogos.cat_item','id_impacto','=','id_item')
                                    ->wherein('id_cat',[208,209,210,211])
                                    ->count();
        if($respuesta->mov_1==0) {
            $respuesta->completa = false;
            $respuesta->alerta[] ='Falta la información de primera salida';
        }
        if($respuesta->mov_3==0) {
            $respuesta->completa = false;
            $respuesta->alerta[] ='Falta la información de retorno';
        }
        if($respuesta->impactos==0) {
            $respuesta->completa = false;
            $respuesta->alerta[] ='Falta la información de impactos y afrontamiento';
        }

        $respuesta->fmt_completa = $respuesta->completa ? '<span class="label label-success">Completa</span>' : '<span class="label label-warning">Pendiente</span>';

        return $respuesta;

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


    //pruebas de excel
    public static function exportar_excel() {
        $inicio = Carbon::now();
        Log::notice("ETL de fichas de exilio: inicio del proceso");
        $total_filas=0;
        // Este arreglo define la estructura del excel
        $encabezados= [
            'id_entrevista' => 'id_entrevista'
            ,'id_exilio' =>'id_exilio'
            ,'codigo_entrevista' =>'codigo de entrevista'
            ,'macro'=>'Macro territorio'
            ,'territorio'=>'Territorio'
            ,'categoria' => array()
            , 'motivo' =>array()
            , 'fecha_salida_a' => 'Fecha de salida, año'
            , 'fecha_salida_m' => 'Fecha de salida, mes'
            , 'fecha_salida_d' => 'Fecha de salida, día'
            , 'lugar_salida_n1' => 'Lugar de salida, Departamento'
            , 'lugar_salida_n2' => 'Lugar de salida, Municipio'
            , 'lugar_salida_n3' => 'Lugar de salida, Vereda'
            , 'lugar_salida_lat' => 'Lugar de salida, Lat'
            , 'lugar_salida_lon' => 'Lugar de salida, Lon'
            , 'salida_acompaniamiento' => array()
            , 'fecha_llegada_a' => 'Fecha de llegada inicial, año'
            , 'fecha_llegada_m' => 'Fecha de llegada inicial, mes'
            , 'fecha_llegada_d' => 'Fecha de llegada inicial, día'
            , 'lugar_llegada_n1' => 'Lugar de llegada inicial, Región'
            , 'lugar_llegada_n2' => 'Lugar de llegada inicial, País'
            , 'lugar_llegada_n3' => 'Lugar de llegada inicial, Ciudad'
            , 'lugar_llegada_ciudad' => 'Lugar de llegada inicial, lugar específico'
            , 'lugar_llegada_lat' => 'Lugar de llegada inicial, Lat'
            , 'lugar_llegada_lon' => 'Lugar de llegada inicial, Lon'
            , 'fecha_asentamiento_a' => 'Fecha de asentamiento posterior, año'
            , 'fecha_asentamiento_m' => 'Fecha de asentamiento posterior, mes'
            , 'fecha_asentamiento_d' => 'Fecha de asentamiento posterior, día'
            , 'lugar_asentamiento_n1' => 'Lugar de asentamiento posterior, Región'
            , 'lugar_asentamiento_n2' => 'Lugar de asentamiento posterior, País'
            , 'lugar_asentamiento_n3' => 'Lugar de asentamiento posterior, Ciudad'
            , 'lugar_asentamiento_ciudad' => 'Lugar de asentamiento posterior, lugar específico'
            , 'lugar_asentamiento_lat' => 'Lugar de asentamiento posterior, Lat'
            , 'lugar_asentamiento_lon' => 'Lugar de asentamiento posterior, Lon'
            , 'modalidad_salida' => 'Modalidad de la primera salida'
            , 'cantidad_personas_salieron' => 'Cantidad de personas que salieron'
            , 'cantidad_nucleo_salieron' => 'Cantidad de personas del núcleo familiar que salieron'
            , 'cantidad_nucleo_quedaron' => 'Cantidad de personas del núcleo familiar que se quedaron'
            , 'solicitado_proteccion' => array()
            , 'estado_solicitud' => 'Estado de la solicitud'
            , 'aprobada_por' => 'Si aprobada, por'
            , 'denegada_situacion' => 'Si denegada, en condición se encuentra'
            , 'obtenido_residencia' => 'Ha obtenido residencia en el país de acogida'
            , 'sufrido_expulsion' => 'Ha sufrido un proceso de expulsión, deportación y/o devolución'
        ];
        for($i=1;$i<=3;$i++) {
            $encabezados["r".$i."_motivo"]  = array();
            $encabezados["r".$i."_fecha_salida_a"]  = 'Reasentamiento #'.$i.'. Fecha de salida, año';
            $encabezados["r".$i."_fecha_salida_m"]  = 'Reasentamiento #'.$i.'. Fecha de salida, mes';
            $encabezados["r".$i."_fecha_salida_d"]  = 'Reasentamiento #'.$i.'. Fecha de salida, día';
            $encabezados["r".$i."_lugar_salida_n1"]  = 'Reasentamiento #'.$i.'. Lugar de salida, Región';
            $encabezados["r".$i."_lugar_salida_n2"]  = 'Reasentamiento #'.$i.'. Lugar de salida, País';
            $encabezados["r".$i."_lugar_salida_n3"]  = 'Reasentamiento #'.$i.'. Lugar de salida, Ciudad';
            $encabezados["r".$i."_lugar_salida_ciudad"]  = 'Reasentamiento #'.$i.'. Lugar de salida, lugar específico';
            $encabezados["r".$i."_lugar_salida_lat"]  = 'Reasentamiento #'.$i.'. Lugar de salida, lat';
            $encabezados["r".$i."_lugar_salida_lon"]  = 'Reasentamiento #'.$i.'. Lugar de salida, lon';
            $encabezados["r".$i."_salida_acompaniamiento"]  = array();
            $encabezados["r".$i."_fecha_llegada_a"]  = 'Reasentamiento #'.$i.'. Fecha de llegada inicial, año';
            $encabezados["r".$i."_fecha_llegada_m"]  = 'Reasentamiento #'.$i.'. Fecha de llegada inicial, mes';
            $encabezados["r".$i."_fecha_llegada_d"]  = 'Reasentamiento #'.$i.'. Fecha de llegada inicial, día';
            $encabezados["r".$i."_lugar_llegada_n1"]  = 'Reasentamiento #'.$i.'. Lugar de llegada inicial, Región';
            $encabezados["r".$i."_lugar_llegada_n2"]  = 'Reasentamiento #'.$i.'. Lugar de llegada inicial, País';
            $encabezados["r".$i."_lugar_llegada_n3"]  = 'Reasentamiento #'.$i.'. Lugar de llegada inicial, Ciudad';
            $encabezados["r".$i."_lugar_llegada_ciudad"]  = 'Reasentamiento #'.$i.'. Lugar de llegada inicial, lugar específico';
            $encabezados["r".$i."_lugar_llegada_lat"]  = 'Reasentamiento #'.$i.'. Lugar de llegada inicial, lat';
            $encabezados["r".$i."_lugar_llegada_lon"]  = 'Reasentamiento #'.$i.'. Lugar de llegada inicial, lon';
            $encabezados["r".$i."_fecha_asentamiento_a"]  = 'Reasentamiento #'.$i.'. Fecha de asentamiento posterior, año';
            $encabezados["r".$i."_fecha_asentamiento_m"]  = 'Reasentamiento #'.$i.'. Fecha de asentamiento posterior, mes';
            $encabezados["r".$i."_fecha_asentamiento_d"]  = 'Reasentamiento #'.$i.'. Fecha de asentamiento posterior, día';
            $encabezados["r".$i."_lugar_asentamiento_n1"]  = 'Reasentamiento #'.$i.'. Lugar de asentamiento posterior, Región';
            $encabezados["r".$i."_lugar_asentamiento_n2"]  = 'Reasentamiento #'.$i.'. Lugar de asentamiento posterior, País';
            $encabezados["r".$i."_lugar_asentamiento_n3"]  = 'Reasentamiento #'.$i.'. Lugar de asentamiento posterior, Ciudad';
            $encabezados["r".$i."_lugar_asentamiento_ciudad"]  = 'Reasentamiento #'.$i.'. Lugar de asentamiento posterior, lugar específico';
            $encabezados["r".$i."_lugar_asentamiento_lat"]  = 'Reasentamiento #'.$i.'. Lugar de asentamiento posterior, lat';
            $encabezados["r".$i."_lugar_asentamiento_lon"]  = 'Reasentamiento #'.$i.'. Lugar de asentamiento posterior, lon';
            $encabezados["r".$i."_modalidad_salida"]  = 'Reasentamiento #'.$i.'. Modalidad del reasentamiento';
            $encabezados["r".$i."_cantidad_personas_salieron"]  = 'Reasentamiento #'.$i.'. Cantidad de personas que salieron';
            $encabezados["r".$i."_cantidad_nucleo_salieron"]  = 'Reasentamiento #'.$i.'. Cantidad de personas del núcleo familiar que salieron';
            $encabezados["r".$i."_cantidad_nucleo_quedaron"]  = 'Reasentamiento #'.$i.'. Cantidad de personas del núcleo familiar que se quedaron';
            $encabezados["r".$i."_solicitado_proteccion"]  = array();
            $encabezados["r".$i."_estado_solicitud"]  = 'Reasentamiento #'.$i.'. Estado de la solicitud';
            $encabezados["r".$i."_aprobada_por"]  = 'Reasentamiento #'.$i.'. Si aprobada, por';
            $encabezados["r".$i."_denegada_situacion"]  = 'Reasentamiento #'.$i.'. Si denegada, en condición se encuentra';
            $encabezados["r".$i."_obtenido_residencia"]  = 'Reasentamiento #'.$i.'. Ha obtenido residencia en el país de acogida';
            $encabezados["r".$i."_sufrido_expulsion"]  = 'Reasentamiento #'.$i.'. Ha sufrido un proceso de expulsión, deportación y/o devolución';
        }

        // Impactos del exilio
        $encabezados["impactos_primera_salida"]  = array();
        $encabezados["afrontamiento_primera_salida"]  = array();
        $encabezados["impactos_largo_plazo"]  = array();
        $encabezados["afrontamiento_largo_plazo"]  = array();
        //Retorno
        $encabezados["retorno_ha_tenido"]  = 'RETORNO: Ha tenido uno o más procesos de retorno';
        $encabezados["retorno_si"]  = array();
        $encabezados["retorno_pq_no"]  = array();
        $encabezados["retorno_fecha_salida_a"]  = 'Retorno. Fecha de salida, año';
        $encabezados["retorno_fecha_salida_m"]  = 'Retorno. Fecha de salida, mes';
        $encabezados["retorno_fecha_salida_d"]  = 'Retorno. Fecha de salida, día';
        $encabezados["retorno_lugar_salida_n1"]  = 'Retorno. Lugar de salida, Región';
        $encabezados["retorno_lugar_salida_n2"]  = 'Retorno. Lugar de salida, Pais';
        $encabezados["retorno_lugar_salida_n3"]  = 'Retorno. Lugar de salida, Ciudad';
        $encabezados["retorno_lugar_salida_ciudad"]  = 'Retorno. Lugar de salida, lugar específico';
        $encabezados["retorno_lugar_salida_lat"]  = 'Retorno. Lugar de salida, lat';
        $encabezados["retorno_lugar_salida_lon"]  = 'Retorno. Lugar de salida, lon';
        $encabezados["retorno_salida_acompaniamiento"]  = array();
        $encabezados["retorno_salida_entidad"]  = 'Retorno. entidad que acompañó';
        $encabezados["retorno_fecha_llegada_a"]  = 'Retorno. Fecha de llegada inicial, año';
        $encabezados["retorno_fecha_llegada_m"]  = 'Retorno. Fecha de llegada inicial, mes';
        $encabezados["retorno_fecha_llegada_d"]  = 'Retorno. Fecha de llegada inicial, día';
        $encabezados["retorno_lugar_llegada_n1"]  = 'Retorno. Lugar de llegada inicial, Departamento';
        $encabezados["retorno_lugar_llegada_n2"]  = 'Retorno. Lugar de llegada inicial, Municipio';
        $encabezados["retorno_lugar_llegada_n3"]  = 'Retorno. Lugar de llegada inicial, Vereda';
        //$encabezados["retorno_lugar_llegada_ciudad"]  = 'Retorno. Lugar de llegada inicial, lugar específico';
        $encabezados["retorno_lugar_llegada_lat"]  = 'Retorno. Lugar de llegada inicial, lat';
        $encabezados["retorno_lugar_llegada_lon"]  = 'Retorno. Lugar de llegada inicial, lon';
        $encabezados["retorno_modalidad_salida"]  = 'Retorno. Modalidad';
        $encabezados["retorno_cantidad_personas_salieron"]  = 'Retorno. Cantidad de personas que retornaron';
        $encabezados["retorno_cantidad_nucleo_salieron"]  = 'Retorno. Cantidad de personas del núcleo familiar que retornaron';
        $encabezados["retorno_cantidad_nucleo_quedaron"]  = 'Retorno. Cantidad de personas del núcleo familiar que se quedaron';
        $encabezados["retorno_impactos"]  = array();
        $encabezados["retorno_afrontamientos"]  = array();
        $encabezados["retorno_ayuda_colombiana"]  = 'Una vez retornado, tuvo ayuda de alguna institución colombiana';
        $encabezados["retorno_ayuda_colombiana_institucion"]  = 'Institución que le ayudó';
        $encabezados["retorno_ayuda_colombiana_ayuda"]  = array();
        $encabezados["otro_exilio"]  = 'Después del retorno, volvió a exiliarse';

        //Metadatos de la entrevista
        $encabezados['lugar_hechos_n1']= "Lugar de los hechos - Departamento";
        $encabezados['lugar_hechos_n2']= "Lugar de los hechos - Municipio";
        $encabezados['lugar_hechos_n3']= "Lugar de los hechos - Vereda";
        $encabezados['hechos_del']= "Fecha de los hechos - desde";
        $encabezados['hechos_al']= "Fecha de los hechos - hasta";
        $encabezados['lugar_entrevista_n1']= "Lugar de la entrevista - Departamento";
        $encabezados['lugar_entrevista_n2']= "Lugar de la entrevista - Municipio";
        $encabezados['lugar_entrevista_n3']= "Lugar de la entrevista - Vereda";
        $encabezados['anotaciones']= "Anotaciones";
        $encabezados['es_prioritario']='Contiene temas poco documentados';
        $encabezados['prioritario_tema']='Temas poco documentados que contiene';
        $encabezados['sector_victima']='Sector con el que se asocia la víctima';
        $encabezados['interes_etnico']='Es de interés étnico';
        //AA
        $encabezados['aa']=array();
        //Violencia
        $encabezados['violencia']=array();






        $listado = exilio::join('esclarecimiento.e_ind_fvt','exilio.id_e_ind_fvt','=','e_ind_fvt.id_e_ind_fvt')
                            ->select(\DB::raw('exilio.*, e_ind_fvt.entrevista_codigo, e_ind_fvt.id_macroterritorio, e_ind_fvt.id_territorio'))
                            ->orderby('id_e_ind_fvt')
                            ->orderby('id_exilio')
                            ->get();
        $datos=array();
        //$a_cat[30]= array();  //'Se reconoce en la categoria ...'
        //$a_cat[213]= array();  //'Se reconoce en la categoria ...'
        $a_cat=array();
        $mapa = array(); //Me permite saber que arreglo de catalogo es para cada opción que tiene detalle
        $mapa['categoria']=30;
        $mapa['motivo']=31;
        $mapa['salida_acompaniamiento']=218;
        $mapa['solicitado_proteccion']=203;
        //Reasentamientos
        for($i=1;$i<=3;$i++) {
            $mapa['r'.$i.'_motivo']=202;
            $mapa['r'.$i.'_salida_acompaniamiento']=218;
            $mapa['r'.$i.'_solicitado_proteccion']=203;

            $mapa_titulo['r'.$i.'_motivo']="Reasentamiento #$i. ";
            $mapa_titulo['r'.$i.'_salida_acompaniamiento']="Reasentamiento #$i. ";
            $mapa_titulo['r'.$i.'_solicitado_proteccion']="Reasentamiento #$i. ";
        }
        $mapa['retorno_si'] = 212 ;
        $mapa['retorno_pq_no'] = 213 ;
        $mapa['retorno_salida_acompaniamiento'] = 218 ;
        $mapa['retorno_impactos'] = 214 ;
        $mapa['retorno_afrontamientos'] = 215 ;
        $mapa['retorno_ayuda_colombiana_ayuda'] = 216 ;

        //Impactos y afrontamientos
        $mapa['impactos_primera_salida']=208;
        $mapa['afrontamiento_primera_salida']=209;
        $mapa['impactos_largo_plazo']=210;
        $mapa['afrontamiento_largo_plazo']=211;
        //Actores armados y violencia
        $mapa['aa']=4;
        $mapa['violencia']=5;

        foreach($mapa as $id=>$texto) {
            $a_cat[$texto]=array();
        }
        //dd($a_cat);
        $mapa_titulo['retorno_salida_acompaniamiento']="Retorno. ";

        foreach($listado as $exilio) {
            $fila=array();
            $fila['id_entrevista']=$exilio->id_e_ind_fvt;
            $fila['id_exilio']=$exilio->id_exilio;
            $fila['codigo_entrevista']=$exilio->entrevista_codigo;
            $fila['macro']=cev::find($exilio->id_macroterritorio)->descripcion;
            $fila['territorio']=cev::find($exilio->id_territorio)->descripcion;
            //
            $salida = $exilio->rel_exilio_movimiento()->where('id_tipo_movimiento',1)->first();
            if($salida) {  //Tiene información de salida, si no, está incompleto y no lo vamos a procesar
                $total_filas++;
                //Se reconoce como
                $catalogos=array();
                foreach($exilio->rel_exilio_categoria as $det_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['categoria']][$det_cat->id_categoria]=cat_cat::find($mapa['categoria'])->nombre." - ".cat_item::describir($det_cat->id_categoria);
                    //Para esta fila
                    $catalogos[$det_cat->id_categoria]=1;
                }
                $fila['categoria']=$catalogos;
                //--------

                //-- PRIMERA SALIDA --//

                ///Motivos de salida
                $catalogos=array();
                foreach($salida->rel_exilio_movimiento_motivo as $det_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['motivo']][$det_cat->id_motivo]=cat_cat::find($mapa['motivo'])->nombre." - ".cat_item::describir($det_cat->id_motivo);
                    //Para esta fila
                    $catalogos[$det_cat->id_motivo]=1;
                }
                $fila['motivo']=$catalogos;
                //--------
                $fila['fecha_salida_a'] = $salida->fecha_salida_a == 0 ? -99 : $salida->fecha_salida_a;
                $fila['fecha_salida_m'] = $salida->fecha_salida_m == 0 ? -99 : $salida->fecha_salida_m;
                $fila['fecha_salida_d'] = $salida->fecha_salida_d == 0 ? -99 : $salida->fecha_salida_d;

                //Lugar de salida
                $fila['lugar_salida_n1']=-99;
                $fila['lugar_salida_n2']=-99;
                $fila['lugar_salida_n3']=-99;
                $fila['lugar_salida_lat']="";
                $fila['lugar_salida_lon']="";
                $geo = geo::find($salida->id_lugar_salida);
                if($geo) {
                    //$excel->lugar_residencia_codigo = $geo->codigo;
                    $n[1]=null;
                    $n[2]=null;
                    $n[3]=null;
                    $n[$geo->nivel]=$geo->descripcion;
                    if($geo->nivel==3) {
                        $fila['lugar_salida_lat'] = $geo->lat;
                        $fila['lugar_salida_lon'] = $geo->lon;
                    }
                    else {
                        $fila['lugar_salida_lat'] = "";
                        $fila['lugar_salida_lon'] = "";
                    }
                    while($geo = geo::find($geo->id_padre)) {
                        if($geo->nivel > 0 && $geo->nivel < 4) {
                            $n[$geo->nivel]=$geo->descripcion;
                        }
                    }

                    foreach($n as $id_nivel => $texto) {
                        $campo='lugar_salida_n'.$id_nivel;
                        $fila[$campo] = $texto;
                    }
                }

                ///Acompañamiento en la salida salida
                $catalogos=array();
                foreach($salida->arreglo_id_acompanamiento as $id_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['salida_acompaniamiento']][$id_cat]=cat_cat::find($mapa['salida_acompaniamiento'])->nombre." - ".cat_item::describir($id_cat);
                    //Para esta fila
                    $catalogos[$id_cat]=1;
                }
                $fila['salida_acompaniamiento']=$catalogos;
                //--------

                // Fecha de llegada inicial
                $fila['fecha_llegada_a'] = $salida->fecha_llegada_a == 0 ? -99 : $salida->fecha_llegada_a;
                $fila['fecha_llegada_m'] = $salida->fecha_llegada_m == 0 ? -99 : $salida->fecha_llegada_m;
                $fila['fecha_llegada_d'] = $salida->fecha_llegada_d == 0 ? -99 : $salida->fecha_llegada_d;
                //Lugar de llegada inicial
                $fila['lugar_llegada_n1']=-99;
                $fila['lugar_llegada_n2']=-99;
                $fila['lugar_llegada_n3']=-99;
                $fila['lugar_llegada_lat']="";
                $fila['lugar_llegada_lon']="";
                $geo = geo::find($salida->id_lugar_llegada);
                if($geo) {
                    //$excel->lugar_residencia_codigo = $geo->codigo;
                    $n[1]=null;
                    $n[2]=null;
                    $n[3]=null;
                    $n[$geo->nivel]=$geo->descripcion;
                    if($geo->nivel==3) {
                        $fila['lugar_llegada_lat'] = $geo->lat;
                        $fila['lugar_llegada_lon'] = $geo->lon;
                    }
                    else {
                        $fila['lugar_llegada_lat'] = "";
                        $fila['lugar_llegada_lon'] = "";
                    }
                    while($geo = geo::find($geo->id_padre)) {
                        if($geo->nivel > 0 && $geo->nivel < 4) {
                            $n[$geo->nivel]=$geo->descripcion;
                        }
                    }

                    foreach($n as $id_nivel => $texto) {
                        $campo='lugar_llegada_n'.$id_nivel;
                        $fila[$campo] = $texto;
                    }
                }

                $fila['lugar_llegada_ciudad'] = $salida->llegada_ciudad;

                // Fecha de asentamiento
                $fila['fecha_asentamiento_a'] = $salida->fecha_asentamiento_a == 0 ? -99 : $salida->fecha_asentamiento_a;
                $fila['fecha_asentamiento_m'] = $salida->fecha_asentamiento_m == 0 ? -99 : $salida->fecha_asentamiento_m;
                $fila['fecha_asentamiento_d'] = $salida->fecha_asentamiento_d == 0 ? -99 : $salida->fecha_asentamiento_d;
                //Lugar de asentamiento
                $fila['lugar_asentamiento_n1']=-99;
                $fila['lugar_asentamiento_n2']=-99;
                $fila['lugar_asentamiento_n3']=-99;
                $fila['lugar_asentamiento_lat']="";
                $fila['lugar_asentamiento_lon']="";
                $geo = geo::find($salida->id_lugar_llegada_2);
                if($geo) {
                    //$excel->lugar_residencia_codigo = $geo->codigo;
                    $n[1]=null;
                    $n[2]=null;
                    $n[3]=null;
                    $n[$geo->nivel]=$geo->descripcion;
                    if($geo->nivel==3) {
                        $fila['lugar_asentamiento_lat'] = $geo->lat;
                        $fila['lugar_asentamiento_lon'] = $geo->lon;
                    }
                    else {
                        $fila['lugar_asentamiento_lat'] = "";
                        $fila['lugar_asentamiento_lon'] = "";
                    }
                    while($geo = geo::find($geo->id_padre)) {
                        if($geo->nivel > 0 && $geo->nivel < 4) {
                            $n[$geo->nivel]=$geo->descripcion;
                        }
                    }

                    foreach($n as $id_nivel => $texto) {
                        $campo='lugar_asentamiento_n'.$id_nivel;
                        $fila[$campo] = $texto;
                    }
                }

                $fila['lugar_asentamiento_ciudad'] = $salida->llegada_2_ciudad;

                $fila['modalidad_salida'] = cat_item::describir($salida->id_modalidad);
                $fila['cantidad_personas_salieron'] = $salida->cant_personas_salieron > 0 ? $salida->cant_personas_salieron : -99;
                $fila['cantidad_nucleo_salieron'] = $salida->cant_personas_familia_salieron > 0 ? $salida->cant_personas_familia_salieron : -99;
                $fila['cantidad_nucleo_quedaron'] = $salida->cant_personas_familia_quedaron > 0 ? $salida->cant_personas_familia_quedaron : -99;

                ///Ha solicitado protección
                $catalogos=array();
                foreach($salida->rel_exilio_movimiento_proteccion as $det_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['solicitado_proteccion']][$det_cat->id_proteccion]=cat_cat::find($mapa['solicitado_proteccion'])->nombre." - ".cat_item::describir($det_cat->id_proteccion);
                    //Para esta fila
                    $catalogos[$det_cat->id_proteccion]=1;
                }
                $fila['solicitado_proteccion']=$catalogos;
                //--------

                $fila['estado_solicitud'] = cat_item::describir($salida->id_estado_proteccion);
                $fila['aprobada_por'] = cat_item::describir($salida->id_aprobada_proteccion);
                $fila['denegada_situacion'] = cat_item::describir($salida->id_denegada_proteccion);
                $fila['obtenido_residencia'] = cat_item::describir($salida->id_residencia_proteccion);
                $fila['sufrido_expulsion'] = $salida->id_expulsion == 1 ? 1 : 0;


                //---  FIN DE PRIMERA SALIDA --//

                //Reasentamientos
                $max=3;
                $actual=1;
                $reasentamientos =  $exilio->rel_exilio_movimiento()->where('id_tipo_movimiento',2)->get();
                foreach($reasentamientos as $salida) {
                    $prefijo ="r".$actual."_";
                    //-- REASENTAMIENTO--//
                    ///Motivos de salida
                    $catalogos=array();
                    foreach($salida->rel_exilio_movimiento_motivo as $det_cat) {
                        //Para los encabezados
                        $a_cat[$mapa[$prefijo.'motivo']][$det_cat->id_motivo]=cat_cat::find($mapa[$prefijo.'motivo'])->nombre." - ".cat_item::describir($det_cat->id_motivo);
                        //Para esta fila
                        $catalogos[$det_cat->id_motivo]=1;
                    }
                    $fila[$prefijo.'motivo']=$catalogos;
                    //--------
                    $fila[$prefijo.'fecha_salida_a'] = $salida->fecha_salida_a == 0 ? -99 : $salida->fecha_salida_a;
                    $fila[$prefijo.'fecha_salida_m'] = $salida->fecha_salida_m == 0 ? -99 : $salida->fecha_salida_m;
                    $fila[$prefijo.'fecha_salida_d'] = $salida->fecha_salida_d == 0 ? -99 : $salida->fecha_salida_d;

                    //Lugar de salida
                    $fila[$prefijo.'lugar_salida_n1']=-99;
                    $fila[$prefijo.'lugar_salida_n2']=-99;
                    $fila[$prefijo.'lugar_salida_n3']=-99;
                    $fila[$prefijo.'lugar_salida_lat']="";
                    $fila[$prefijo.'lugar_salida_lon']="";
                    $geo = geo::find($salida->id_lugar_salida);
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;
                        if($geo->nivel==3) {
                            $fila[$prefijo.'lugar_salida_lat'] = $geo->lat;
                            $fila[$prefijo.'lugar_salida_lon'] = $geo->lon;
                        }
                        else {
                            $fila[$prefijo.'lugar_salida_lat'] = "";
                            $fila[$prefijo.'lugar_salida_lon'] = "";
                        }
                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }


                        foreach($n as $id_nivel => $texto) {
                            $campo=$prefijo.'lugar_salida_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila[$prefijo.'lugar_salida_ciudad'] = $salida->salida_ciudad;

                    ///Acompañamiento en la salida salida
                    $catalogos=array();
                    foreach($salida->arreglo_id_acompanamiento as $id_cat) {
                        //Para los encabezados
                        $a_cat[$mapa[$prefijo.'salida_acompaniamiento']][$id_cat]=cat_cat::find($mapa[$prefijo.'salida_acompaniamiento'])->nombre." - ".cat_item::describir($id_cat);
                        //Para esta fila
                        $catalogos[$id_cat]=1;
                    }
                    $fila[$prefijo.'salida_acompaniamiento']=$catalogos;
                    //--------

                    // Fecha de llegada inicial
                    $fila[$prefijo.'fecha_llegada_a'] = $salida->fecha_llegada_a == 0 ? -99 : $salida->fecha_llegada_a;
                    $fila[$prefijo.'fecha_llegada_m'] = $salida->fecha_llegada_m == 0 ? -99 : $salida->fecha_llegada_m;
                    $fila[$prefijo.'fecha_llegada_d'] = $salida->fecha_llegada_d == 0 ? -99 : $salida->fecha_llegada_d;
                    //Lugar de llegada inicial
                    $fila[$prefijo.'lugar_llegada_n1']=-99;
                    $fila[$prefijo.'lugar_llegada_n2']=-99;
                    $fila[$prefijo.'lugar_llegada_n3']=-99;
                    $fila[$prefijo.'lugar_llegada_lat']="";
                    $fila[$prefijo.'lugar_llegada_lon']="";
                    $geo = geo::find($salida->id_lugar_llegada);
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;
                        if($geo->nivel==3) {
                            $fila[$prefijo.'lugar_llegada_lat'] = $geo->lat;
                            $fila[$prefijo.'lugar_llegada_lon'] = $geo->lon;
                        }
                        else {
                            $fila[$prefijo.'lugar_llegada_lat'] = "";
                            $fila[$prefijo.'lugar_llegada_lon'] = "";
                        }
                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }

                        foreach($n as $id_nivel => $texto) {
                            $campo=$prefijo.'lugar_llegada_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila[$prefijo.'lugar_llegada_ciudad'] = $salida->llegada_ciudad;

                    // Fecha de asentamiento
                    $fila[$prefijo.'fecha_asentamiento_a'] = $salida->fecha_asentamiento_a == 0 ? -99 : $salida->fecha_asentamiento_a;
                    $fila[$prefijo.'fecha_asentamiento_m'] = $salida->fecha_asentamiento_m == 0 ? -99 : $salida->fecha_asentamiento_m;
                    $fila[$prefijo.'fecha_asentamiento_d'] = $salida->fecha_asentamiento_d == 0 ? -99 : $salida->fecha_asentamiento_d;
                    //Lugar de asentamiento
                    $fila[$prefijo.'lugar_asentamiento_n1']=-99;
                    $fila[$prefijo.'lugar_asentamiento_n2']=-99;
                    $fila[$prefijo.'lugar_asentamiento_n3']=-99;
                    $fila[$prefijo.'lugar_asentamiento_lat']="";
                    $fila[$prefijo.'lugar_asentamiento_lon']="";
                    $geo = geo::find($salida->id_lugar_llegada_2);
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;
                        if($geo->nivel==3) {
                            $fila[$prefijo.'lugar_asentamiento_lat'] = $geo->lat;
                            $fila[$prefijo.'lugar_asentamiento_lon'] = $geo->lon;
                        }
                        else {
                            $fila[$prefijo.'lugar_asentamiento_lat'] = "";
                            $fila[$prefijo.'lugar_asentamiento_lon'] = "";
                        }
                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }

                        foreach($n as $id_nivel => $texto) {
                            $campo=$prefijo.'lugar_asentamiento_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila[$prefijo.'lugar_asentamiento_ciudad'] = $salida->llegada_2_ciudad;

                    $fila[$prefijo.'modalidad_salida'] = cat_item::describir($salida->id_modalidad);
                    $fila[$prefijo.'cantidad_personas_salieron'] = $salida->cant_personas_salieron > 0 ? $salida->cant_personas_salieron : -99;
                    $fila[$prefijo.'cantidad_nucleo_salieron'] = $salida->cant_personas_familia_salieron > 0 ? $salida->cant_personas_familia_salieron : -99;
                    $fila[$prefijo.'cantidad_nucleo_quedaron'] = $salida->cant_personas_familia_quedaron > 0 ? $salida->cant_personas_familia_quedaron : -99;

                    ///Ha solicitado protección
                    $catalogos=array();
                    foreach($salida->rel_exilio_movimiento_proteccion as $det_cat) {
                        //Para los encabezados
                        $a_cat[$mapa[$prefijo.'solicitado_proteccion']][$det_cat->id_proteccion]=cat_cat::find($mapa[$prefijo.'solicitado_proteccion'])->nombre." - ".cat_item::describir($det_cat->id_proteccion);
                        //Para esta fila
                        $catalogos[$det_cat->id_proteccion]=1;
                    }
                    $fila[$prefijo.'solicitado_proteccion']=$catalogos;
                    //--------

                    $fila[$prefijo.'estado_solicitud'] = cat_item::describir($salida->id_estado_proteccion);
                    $fila[$prefijo.'aprobada_por'] = cat_item::describir($salida->id_aprobada_proteccion);
                    $fila[$prefijo.'denegada_situacion'] = cat_item::describir($salida->id_denegada_proteccion);
                    $fila[$prefijo.'obtenido_residencia'] = cat_item::describir($salida->id_residencia_proteccion);
                    $fila[$prefijo.'sufrido_expulsion'] = $salida->id_expulsion == 1 ? 1 : 0;
                    //Hasta tres reasentamientos
                    $actual++;
                    if($actual > $max) {
                        break;
                    }
                }
                //En blanco si no hay reasentamientos menores a tres
                for($i=$actual; $i<=$max; $i++) {
                    $prefijo ="r".$i."_";

                    $fila[$prefijo.'motivo']=array();
                    //salida
                    $fila[$prefijo.'fecha_salida_a'] ="";
                    $fila[$prefijo.'fecha_salida_m'] = "";
                    $fila[$prefijo.'fecha_salida_d'] = "";
                    $fila[$prefijo.'lugar_salida_n1'] = "";
                    $fila[$prefijo.'lugar_salida_n2'] = "";
                    $fila[$prefijo.'lugar_salida_n3'] = "";
                    $fila[$prefijo.'lugar_salida_lat'] = "";
                    $fila[$prefijo.'lugar_salida_lon'] = "";
                    $fila[$prefijo.'lugar_salida_ciudad'] = "";
                    $fila[$prefijo.'salida_acompaniamiento']=array();
                    // llegada
                    $fila[$prefijo.'fecha_llegada_a']  ="";
                    $fila[$prefijo.'fecha_llegada_m']  ="";
                    $fila[$prefijo.'fecha_llegada_d']  ="";
                    $fila[$prefijo.'lugar_llegada_n1'] = "";
                    $fila[$prefijo.'lugar_llegada_n2'] = "";
                    $fila[$prefijo.'lugar_llegada_n3'] = "";
                    $fila[$prefijo.'lugar_llegada_lat'] = "";
                    $fila[$prefijo.'lugar_llegada_lon'] = "";
                    $fila[$prefijo.'lugar_llegada_ciudad'] = "";
                    // asentamiento
                    $fila[$prefijo.'fecha_asentamiento_a'] = "";
                    $fila[$prefijo.'fecha_asentamiento_m'] = "";
                    $fila[$prefijo.'fecha_asentamiento_d'] = "";
                    $fila[$prefijo.'lugar_asentamiento_n1']= "";
                    $fila[$prefijo.'lugar_asentamiento_n2']= "";
                    $fila[$prefijo.'lugar_asentamiento_n3']= "";
                    $fila[$prefijo.'lugar_asentamiento_lat']="";
                    $fila[$prefijo.'lugar_asentamiento_lon']="";
                    $fila[$prefijo.'lugar_asentamiento_ciudad']= "";
                   //Modalidad y conteos
                    $fila[$prefijo.'modalidad_salida'] = "";
                    $fila[$prefijo.'cantidad_personas_salieron'] = "";
                    $fila[$prefijo.'cantidad_nucleo_salieron'] = "";
                    $fila[$prefijo.'cantidad_nucleo_quedaron'] = "";
                    $fila[$prefijo.'solicitado_proteccion']=array();

                    $fila[$prefijo.'estado_solicitud'] = "";
                    $fila[$prefijo.'aprobada_por'] = "";
                    $fila[$prefijo.'denegada_situacion'] = "";
                    $fila[$prefijo.'obtenido_residencia'] = "";
                    $fila[$prefijo.'sufrido_expulsion'] = "";
                }
                ///// FIN DE LOS REASENTAMIENTOS
                ///

                //-- IMPACTOS --//
                ///impactos en la salida salida
                $catalogos=array();
                foreach($exilio->arreglo_impacto(208) as $id_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['impactos_primera_salida']][$id_cat]=cat_cat::find($mapa['impactos_primera_salida'])->nombre." - ".cat_item::describir($id_cat);
                    //Para esta fila
                    $catalogos[$id_cat]=1;
                }
                $fila['impactos_primera_salida']=$catalogos;

                ///afrontamiento en la salida salida
                $catalogos=array();
                foreach($exilio->arreglo_impacto(209) as $id_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['afrontamiento_primera_salida']][$id_cat]=cat_cat::find($mapa['afrontamiento_primera_salida'])->nombre." - ".cat_item::describir($id_cat);
                    //Para esta fila
                    $catalogos[$id_cat]=1;
                }
                $fila['afrontamiento_primera_salida']=$catalogos;

                ///impactos en el largo plazo
                $catalogos=array();
                foreach($exilio->arreglo_impacto(210) as $id_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['impactos_largo_plazo']][$id_cat]=cat_cat::find($mapa['impactos_largo_plazo'])->nombre." - ".cat_item::describir($id_cat);
                    //Para esta fila
                    $catalogos[$id_cat]=1;
                }
                $fila['impactos_largo_plazo']=$catalogos;

                ///afrontamiento en el largo plazo
                $catalogos=array();
                foreach($exilio->arreglo_impacto(211) as $id_cat) {
                    //Para los encabezados
                    $a_cat[$mapa['afrontamiento_largo_plazo']][$id_cat]=cat_cat::find($mapa['afrontamiento_largo_plazo'])->nombre." - ".cat_item::describir($id_cat);
                    //Para esta fila
                    $catalogos[$id_cat]=1;
                }
                $fila['afrontamiento_largo_plazo']=$catalogos;


                //-- RETORNO --//
                //Valores predeterminados

                $fila["retorno_ha_tenido"]  = 2;
                $fila["retorno_si"]  = array();
                $fila["retorno_pq_no"]  = array();
                $fila["retorno_fecha_salida_a"]  = "";
                $fila["retorno_fecha_salida_m"]  = "";
                $fila["retorno_fecha_salida_d"]  = "";
                $fila["retorno_lugar_salida_n1"]  = "";
                $fila["retorno_lugar_salida_n2"]  = "";
                $fila["retorno_lugar_salida_n3"]  = "";
                $fila["retorno_lugar_salida_ciudad"]  = "";
                $fila["retorno_lugar_salida_lat"]  = "";
                $fila["retorno_lugar_salida_lon"]  = "";
                $fila["retorno_salida_acompaniamiento"]  = array();
                $fila["retorno_salida_entidad"]  = "";
                $fila["retorno_fecha_llegada_a"]  = "";
                $fila["retorno_fecha_llegada_m"]  = "";
                $fila["retorno_fecha_llegada_d"]  = "";
                $fila["retorno_lugar_llegada_n1"]  = "";
                $fila["retorno_lugar_llegada_n2"]  = "";
                $fila["retorno_lugar_llegada_n3"]  = "";
                $fila["retorno_lugar_llegada_ciudad"]  = "";
                $fila["retorno_lugar_llegada_lat"]  = "";
                $fila["retorno_lugar_llegada_lon"]  = "";
                $fila["retorno_modalidad_salida"]  = "";
                $fila["retorno_cantidad_personas_salieron"]  = "";
                $fila["retorno_cantidad_nucleo_salieron"]  = "";
                $fila["retorno_cantidad_nucleo_quedaron"]  = "";
                $fila["retorno_impactos"]  = array();
                $fila["retorno_afrontamientos"]  = array();
                $fila["retorno_ayuda_colombiana"]  = "";
                $fila["retorno_ayuda_colombiana_institucion"] = "";
                $fila["retorno_ayuda_colombiana_ayuda"]  = array();
                $fila["otro_exilio"]  = "";

                //

                $salida =  $exilio->rel_exilio_movimiento()->where('id_tipo_movimiento',3)->first();
                if($salida) {
                    $prefijo ="retorno_";  //Para facilitar el copy paste
                    $fila['retorno_ha_tenido']=1;

                    ///Porque sí
                    $catalogos=array();
                    foreach($salida->arreglo_motivo($mapa['retorno_si']) as $id_item) {
                        //Para los encabezados
                        $a_cat[$mapa['retorno_si']][$id_item]=cat_cat::find($mapa['retorno_si'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['retorno_si']=$catalogos;
                    //--------
                    ///Porque no
                    $catalogos=array();
                    foreach($salida->arreglo_motivo($mapa['retorno_pq_no']) as $id_item) {
                        //Para los encabezados
                        $a_cat[$mapa['retorno_pq_no']][$id_item]=cat_cat::find($mapa['retorno_pq_no'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['retorno_pq_no']=$catalogos;



                    //--------
                    $fila[$prefijo.'fecha_salida_a'] = $salida->fecha_salida_a == 0 ? -99 : $salida->fecha_salida_a;
                    $fila[$prefijo.'fecha_salida_m'] = $salida->fecha_salida_m == 0 ? -99 : $salida->fecha_salida_m;
                    $fila[$prefijo.'fecha_salida_d'] = $salida->fecha_salida_d == 0 ? -99 : $salida->fecha_salida_d;

                    //Lugar de salida
                    $fila[$prefijo.'lugar_salida_n1']=-99;
                    $fila[$prefijo.'lugar_salida_n2']=-99;
                    $fila[$prefijo.'lugar_salida_n3']=-99;
                    $fila[$prefijo.'lugar_salida_lat']="";
                    $fila[$prefijo.'lugar_salida_lon']="";
                    $geo = geo::find($salida->id_lugar_salida);
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;
                        if($geo->nivel==3) {
                            $fila[$prefijo.'lugar_salida_lat'] = $geo->lat;
                            $fila[$prefijo.'lugar_salida_lon'] = $geo->lon;
                        }
                        else {
                            $fila[$prefijo.'lugar_salida_lat'] = "";
                            $fila[$prefijo.'lugar_salida_lon'] = "";
                        }
                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }


                        foreach($n as $id_nivel => $texto) {
                            $campo=$prefijo.'lugar_salida_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila[$prefijo.'lugar_salida_ciudad'] = $salida->salida_ciudad;

                    ///Acompañamiento en la salida salida
                    $catalogos=array();
                    foreach($salida->arreglo_proteccion(218,1)as $id_item) {
                        //Para los encabezados
                        $a_cat[$mapa['retorno_salida_acompaniamiento']][$id_item]=cat_cat::find($mapa['retorno_salida_acompaniamiento'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['retorno_salida_acompaniamiento']=$catalogos;
                    //--------
                    $fila['retorno_salida_entidad'] = $exilio->entidad_apoyo_retorno;
                    // Fecha de llegada inicial
                    $fila[$prefijo.'fecha_llegada_a'] = $salida->fecha_llegada_a == 0 ? -99 : $salida->fecha_llegada_a;
                    $fila[$prefijo.'fecha_llegada_m'] = $salida->fecha_llegada_m == 0 ? -99 : $salida->fecha_llegada_m;
                    $fila[$prefijo.'fecha_llegada_d'] = $salida->fecha_llegada_d == 0 ? -99 : $salida->fecha_llegada_d;
                    //Lugar de llegada inicial
                    $fila[$prefijo.'lugar_llegada_n1']=-99;
                    $fila[$prefijo.'lugar_llegada_n2']=-99;
                    $fila[$prefijo.'lugar_llegada_n3']=-99;
                    $fila[$prefijo.'lugar_llegada_lat']="";
                    $fila[$prefijo.'lugar_llegada_lon']="";
                    $geo = geo::find($salida->id_lugar_llegada);
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;
                        if($geo->nivel==3) {
                            $fila[$prefijo.'lugar_llegada_lat'] = $geo->lat;
                            $fila[$prefijo.'lugar_llegada_lon'] = $geo->lon;
                        }
                        else {
                            $fila[$prefijo.'lugar_llegada_lat'] = "";
                            $fila[$prefijo.'lugar_llegada_lon'] = "";
                        }
                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }

                        foreach($n as $id_nivel => $texto) {
                            $campo=$prefijo.'lugar_llegada_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila[$prefijo.'lugar_llegada_ciudad'] = $salida->llegada_ciudad;



                    $fila[$prefijo.'modalidad_salida'] = cat_item::describir($salida->id_modalidad);
                    $fila[$prefijo.'cantidad_personas_salieron'] = $salida->cant_personas_salieron > 0 ? $salida->cant_personas_salieron : -99;
                    $fila[$prefijo.'cantidad_nucleo_salieron'] = $salida->cant_personas_familia_salieron > 0 ? $salida->cant_personas_familia_salieron : -99;
                    $fila[$prefijo.'cantidad_nucleo_quedaron'] = $salida->cant_personas_familia_quedaron > 0 ? $salida->cant_personas_familia_quedaron : -99;

                    ///impactos del retorno
                    $catalogos=array();
                    foreach($exilio->arreglo_impacto(214) as $id_item) {
                        //Para los encabezados
                        $a_cat[$mapa['retorno_impactos']][$id_item]=cat_cat::find($mapa['retorno_impactos'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['retorno_impactos']=$catalogos;
                    //--------
                    ///afrontamientos del retorno
                    $catalogos=array();
                    foreach($exilio->arreglo_impacto(215) as $id_item) {
                        //Para los encabezados
                        $a_cat[$mapa['retorno_afrontamientos']][$id_item]=cat_cat::find($mapa['retorno_afrontamientos'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['retorno_afrontamientos']=$catalogos;
                    //--------

                    $fila["retorno_ayuda_colombiana"]  = $exilio->id_ha_tenido_ayuda == 1 ? 1 : 0;
                    $fila["retorno_ayuda_colombiana_institucion"] = $exilio->institucion_ayuda;
                    ///afrontamientos del retorno
                    $catalogos=array();
                    foreach($exilio->arreglo_impacto(216) as $id_item) {
                        //Para los encabezados
                        $a_cat[$mapa['retorno_ayuda_colombiana_ayuda']][$id_item]=cat_cat::find($mapa['retorno_ayuda_colombiana_ayuda'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['retorno_ayuda_colombiana_ayuda']=$catalogos;
                    //--------

                    $fila["otro_exilio"]  = $exilio->id_otro_exilio == 1 ? 1 : 0;

                    //Metadatos

                    $entrevista = $exilio->rel_id_e_ind_fvt;

                    //Lugar de los hechos
                    $fila['lugar_hechos_n1']=-99;
                    $fila['lugar_hechos_n2']=-99;
                    $fila['lugar_hechos_n3']=-99;
                    $geo =  $entrevista->rel_hechos_lugar;
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;

                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }

                        foreach($n as $id_nivel => $texto) {
                            $campo='lugar_hechos_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila['hechos_del']=$entrevista->fmt_hechos_del;
                    $fila['hechos_al']=$entrevista->fmt_hechos_al;

                    //Lugar de la entrevista
                    $fila['lugar_entrevista_n1']=-99;
                    $fila['lugar_entrevista_n2']=-99;
                    $fila['lugar_entrevista_n3']=-99;
                    $geo = $entrevista->rel_entrevista_lugar;
                    if($geo) {
                        //$excel->lugar_residencia_codigo = $geo->codigo;
                        $n[1]=null;
                        $n[2]=null;
                        $n[3]=null;
                        $n[$geo->nivel]=$geo->descripcion;

                        while($geo = geo::find($geo->id_padre)) {
                            if($geo->nivel > 0 && $geo->nivel < 4) {
                                $n[$geo->nivel]=$geo->descripcion;
                            }
                        }

                        foreach($n as $id_nivel => $texto) {
                            $campo='lugar_entrevista_n'.$id_nivel;
                            $fila[$campo] = $texto;
                        }
                    }

                    $fila['anotaciones']= $entrevista->anotaciones;
                    $fila['es_prioritario']= $entrevista->id_prioritario==1 ? 1 : 0;
                    $fila['prioritario_tema']= $entrevista->prioritario_tema;
                    $fila['sector_victima']= $entrevista->fmt_id_sector;
                    $fila['interes_etnico']= $entrevista->id_etnico == 1 ? 1 : 0 ;
                    ///Actores armados
                    $catalogos=array();
                    foreach($entrevista->rel_fr as $detalle) {
                        $id_item=$detalle->id_fr;
                        //Para los encabezados
                        $a_cat[$mapa['aa']][$id_item]=cat_cat::find($mapa['aa'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['aa']=$catalogos;
                    ///violencia
                    $catalogos=array();
                    foreach($entrevista->rel_tv as $detalle) {
                        $id_item=$detalle->id_tv;
                        //Para los encabezados
                        $a_cat[$mapa['violencia']][$id_item]=cat_cat::find($mapa['violencia'])->nombre." - ".cat_item::describir($id_item);
                        //Para esta fila
                        $catalogos[$id_item]=1;
                    }
                    $fila['violencia']=$catalogos;


                }


                //////////////Fin de procesar la fila, meterla al arreglo
                $datos[]=$fila;
            }

        }
        //dd($a_cat);
        $fin = Carbon::now();

        $respuesta = new \stdClass();
        $respuesta->encabezado=$encabezados;
        $respuesta->detalle=$datos;
        $respuesta->mapa=$mapa;
        $respuesta->mapa_titulo=$mapa_titulo;
        $respuesta->a_cat=$a_cat;
        $respuesta->total_filas=$total_filas;
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        //dd($respuesta);
        Log::info("ETL de fichas de exilio: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;
    }


}
