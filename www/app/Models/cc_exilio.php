<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_cc_exilio
 * @property int $id_entrevista
 * @property string $codigo_entrevista
 * @property string $macroterritorio
 * @property string $territorio
 * @property string $entrevistador
 * @property string $fecha_entrevista
 * @property int $metadato
 * @property int $ficha_exilio
 * @property int $ficha_larga
 * @property int $clasificacion
 * @property string $created_at
 * @property Esclarecimiento.eIndFvt $esclarecimiento.eIndFvt
 */
class cc_exilio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.cc_exilio';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cc_exilio';

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'codigo_entrevista', 'macroterritorio', 'territorio', 'entrevistador', 'fecha_entrevista', 'metadato', 'ficha_exilio', 'ficha_larga', 'created_at'];

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
    public function rel_id_entrevista()
    {
        return $this->belongsTo(entrevista_individual::class, 'id_entrevista', 'id_e_ind_fvt');
    }

    public static function generar_plana() {
        $inicio = Carbon::now();
        $total_filas=0;
        $total_errores=0;
        //Registrar el evento
        Log::notice("Tabla de control de calidad de exilio: inicio del proceso");
        //Inicializar la tabla
        cc_exilio::truncate();

        //Primer grupo: entrevistas de la macro internacional
        $listado_macro_internacional = entrevista_individual::join('catalogos.cev','id_macroterritorio','id_geo')
                                        ->where('id_activo',1)
                                        ->where('id_subserie',config('expedientes.vi'))
                                        ->where('cev.descripcion', 'ilike','internacional')
                                        ->orderby('entrevista_codigo')
            ->pluck('entrevista_codigo');
        $listados['macro']=$listado_macro_internacional;

        //Segundo grupo: entrevistas del resto de macros que tengan uno de los tres criterios
        // Con ficha de exilio
        $listado_con_ficha_exilio =  entrevista_individual::join('fichas.exilio','e_ind_fvt.id_e_ind_fvt','exilio.id_e_ind_fvt')
            ->join('fichas.exilio_movimiento','exilio.id_exilio','exilio_movimiento.id_exilio')
            ->join('catalogos.cev','id_macroterritorio','id_geo')
            ->where('id_tipo_movimiento',1)  //con movimiento de salida como minimo
            ->where('id_activo',1)
            ->where('id_subserie',config('expedientes.vi'))
            ->where('cev.descripcion', 'not ilike','internacional') //No macro internacional
            ->orderby('entrevista_codigo')
            ->distinct()
            ->pluck('entrevista_codigo');
        $listados['con_ficha_exilio']=$listado_con_ficha_exilio;

        //Con metadato de exilio como violencia
        $listado_con_metadato_exilio  = entrevista_individual::join('esclarecimiento.e_ind_fvt_tv','e_ind_fvt.id_e_ind_fvt','e_ind_fvt_tv.id_e_ind_fvt')
            ->join('catalogos.cat_item','id_tv','id_item')
            ->join('catalogos.cev','id_macroterritorio','id_geo')
            ->where('id_activo',1)
            ->where('id_subserie',config('expedientes.vi'))
            ->where('cev.descripcion', 'not ilike','internacional')  // no macro internaciona
            ->where('cat_item.descripcion', 'ilike','exilio') //exilio en metadato
            ->orderby('entrevista_codigo')
            ->distinct()
            ->pluck('entrevista_codigo');
        $listados['con_metadato']=$listado_con_metadato_exilio;

        //Con exilio como violencia en la ficha de hechos
        $listado_con_violencia_exilio  = entrevista_individual::join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
            ->join('catalogos.violencia','id_tipo_violencia','violencia.id_geo')
            ->join('catalogos.cev','id_macroterritorio','cev.id_geo')
            ->where('id_activo',1)
            ->where('id_subserie',config('expedientes.vi'))
            ->where('cev.descripcion', 'not ilike','internacional') //No macro internacional
            ->where('violencia.descripcion', 'ilike','exilio')  // exilio en violencia
            ->orderby('entrevista_codigo')
            ->pluck('entrevista_codigo');
        $listados['con_violencia']=$listado_con_violencia_exilio;




        $conteos = array();
        $arreglo_final=array();
        foreach($listados as $cual=>$lista) {
            $conteos[$cual] = count($lista);
            foreach($lista as $codigo) {
                $arreglo_final[$codigo]=$cual;
            }
        }
        //dd($conteos);

        //dd($listado_unificado);


        // Revisar el listado y completar la tabla
        $metadato = cat_item::where('id_cat',5)->where('descripcion','ilike','exilio')->first();
        $violencia = tipo_violencia::where('codigo','22')->first();
        //dd($violencia);

        foreach($arreglo_final as $codigo=>$grupo) {
            $nuevo = new cc_exilio();
            $e = entrevista_individual::where('entrevista_codigo',$codigo)->first();
            $nuevo->id_entrevista = $e->id_e_ind_fvt;
            $nuevo->codigo_entrevista = $e->entrevista_codigo;
            $nuevo->macroterritorio = $e->fmt_id_macroterritorio;
            $nuevo->territorio = $e->fmt_id_territorio;
            $nuevo->entrevistador = $e->fmt_id_entrevistador;
            $nuevo->fecha_entrevista = substr( $e->entrevista_fecha,0,10);
            $nuevo->clasificacion = $e->clasifica_nivel;
            $nuevo->grupo = $grupo;
            //Tiene metadato?
            $conteo = $e->rel_tv()->where('id_tv',$metadato->id_item)->count();
            $nuevo->metadato = $conteo>0 ? 'Sí' : 'No';
            //Cuantas fichas de exilio
            $conteo = $e->rel_exilio_ficha()->count();
            $nuevo->ficha_exilio = $conteo>0 ? 'Sí' : 'No';
            //Cuantas violencias con exilio
            $conteo = hecho::join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
                            ->where('hecho.id_e_ind_fvt',$e->id_e_ind_fvt)
                            ->where('id_tipo_violencia',$violencia->id_geo)
                            ->count();
            $nuevo->ficha_larga = $conteo>0 ? 'Sí' : 'No';
            $nuevo->save();
            $total_filas++;
            if($nuevo->ficha_larga=="No" || $nuevo->ficha_exilio=="No" || $nuevo->metadato=="No") {
                $total_errores++;
            }
        }


        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        //$respuesta->listados = $listados;
        $respuesta->conteos = $conteos;
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;


        Log::info("Tabla de control de calidad de exilio: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;
    }

    //Correccion manual: crear hecho con exilio para los que tienen ficha de exilio pero no tienen ningún hecho de exilio
    public static function corregir_falta_de_exilio() {
        //Controles
        $inicio = Carbon::now();
        $total_errores=[];
        $entrevistas_corregidas=array();
        Log::notice("Crear hecho con exilio para entrevistas con ficha de exilio: inicio del proceso");

        //1: identificar las entrevistas involucradas: con ficha de exilio, sin exilio como hecho

        //1.a: entrevistas con ficha de exilio
        $listado_con_ficha_exilio =  entrevista_individual::join('fichas.exilio','e_ind_fvt.id_e_ind_fvt','exilio.id_e_ind_fvt')
            ->join('fichas.exilio_movimiento','exilio.id_exilio','exilio_movimiento.id_exilio')
            ->join('catalogos.cev','id_macroterritorio','id_geo')
            ->where('id_tipo_movimiento',1)  //con movimiento de salida como minimo
            ->where('id_activo',1)  //soft delete
            ->where('id_subserie',config('expedientes.vi'))  // VI
            ->distinct()
            ->pluck('e_ind_fvt.id_e_ind_fvt');

        //1.b  entrevistas que  tienen exilio como violencia
        $listado_con_violencia_exilio  = entrevista_individual::join('fichas.hecho','e_ind_fvt.id_e_ind_fvt','hecho.id_e_ind_fvt')
            ->join('fichas.hecho_violencia','hecho.id_hecho','hecho_violencia.id_hecho')
            ->join('catalogos.violencia','id_tipo_violencia','violencia.id_geo')
            ->join('catalogos.cev','id_macroterritorio','cev.id_geo')
            ->where('id_activo',1)
            ->where('id_subserie',config('expedientes.vi'))
            ->where('violencia.descripcion', 'ilike','exilio')  // exilio en violencia
            ->distinct()
            ->pluck('e_ind_fvt.id_e_ind_fvt');

        //1.c: entrevistas afectadas
        $listado_por_arreglar = entrevista_individual::wherein('id_e_ind_fvt',$listado_con_ficha_exilio)  //Con ficha exilio
                                        ->whereNotIn('id_e_ind_fvt',$listado_con_violencia_exilio)  //Sin exilio como violencia
                                        ->distinct()
                                        ->orderby('id_e_ind_fvt')
                                        ->pluck('entrevista_codigo','e_ind_fvt.id_e_ind_fvt');

        //Procesar las entrevistas
        $tipos_errores[1]=0;  //entrevista en Colombia
        $tipos_errores[2]=0;  //Si ficha de persona entrevistaa
        foreach($listado_por_arreglar as $id_entrevista=>$codigo_entrevista) {
            $cambio = self::agregar_hecho_exilio($id_entrevista);
            if($cambio->exito) {
                $entrevistas_corregidas[] = $codigo_entrevista;
            }
            else {
                $total_errores[] = $cambio->mensaje;
                $tipos_errores[$cambio->mensaje_tipo]++;
            }
        }
        //Generar la respuesta y el registro en bitácora

        $fin = Carbon::now();
        $respuesta= new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->con_ficha_exilio=$listado_con_ficha_exilio;
        $respuesta->con_violencia_exilio = $listado_con_violencia_exilio;
        $respuesta->por_arreglar = $listado_por_arreglar;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->conteo_con_ficha = $listado_con_ficha_exilio->count();
        $respuesta->conteo_con_violencia = $listado_con_violencia_exilio->count();
        $respuesta->conteo_por_arreglar = $listado_por_arreglar->count();
        $respuesta->total_correcciones = count($entrevistas_corregidas);
        $respuesta->total_errores = count($total_errores);


        if($total_errores>0) {
            $fuera_colombia=$tipos_errores[1];
            $sin_pe = $tipos_errores[2];
            Log::error("Crear hecho con exilio para entrevistas con ficha de exilio finalizada con   $respuesta->total_errores errores: $sin_pe sin ficha de persona entrevistada, $fuera_colombia entrevistas en Colombia ".PHP_EOL.implode(' ; ',$total_errores));
        }

        Log::info("Crear hecho con exilio para entrevistas con ficha de exilio: fin del proceso, $respuesta->total_correcciones entrevistas corregidas, $respuesta->total_errores con problemas. Tiempo: $respuesta->duracion.".PHP_EOL."Corregidas: ".implode(', ',$entrevistas_corregidas));
        return $respuesta;


        //2:
    }
    //Recibe una entrevista y le agrega un heche de exilio
    public static function agregar_hecho_exilio($id_entrevista) {
        $entrevista = entrevista_individual::find($id_entrevista);
        $res = new \stdClass();
        $res->mensaje = null;
        $res->mensaje_tipo=0;
        $res->exito = false;
        //Llaves foraneas
        $id_entrevistador = 10;  //Quien hace la ficha, entrevistador sim@
        $id_usuario = 2;  // id_usuario del entrevistador sim@
        $violencia = tipo_violencia::where('codigo','2201')->first();
        $id_tipo_violencia = $violencia->id_padre;
        $id_subtipo_voilencia = $violencia->id_geo;
        $actor = tipo_aa::where('codigo','0501')->first();
        $aa_id_subtipo = $actor->id_geo;
        $aa_id_tipo = $actor->id_padre;

        //Validaciones: que la entrevista haya sido tomada en el exterior
        $codigo_lugar = optional($entrevista->rel_entrevista_lugar)->codigo;
        $codigo_lugar =  mb_strtolower(substr($codigo_lugar,0,2));
        if($codigo_lugar <> 'ii') {
            $res->mensaje="Lugar de entrevista en Colombia, $entrevista->entrevista_codigo";
            $res->mensaje_tipo=1;
            $res->exito = false;
            return $res;
        }

        //Revisar que haya ficha de entrevistado
        $entrevistado = $entrevista->rel_persona_entrevistada;
        if(!$entrevistado) {
            $res->mensaje="No hay ficha de persona entrevistada, $entrevista->entrevista_codigo";
            $res->mensaje_tipo=2;
            $res->exito = false;
            return $res;
        }
        //Revisar si tiene ficha de victima
        $victima = victima::where('id_persona',$entrevistado->id_persona)->where('id_e_ind_fvt',$entrevista->id_e_ind_fvt)->first();
        if(!$victima) {  //No hay ficha de victima
            $victima = new victima();
            $victima->id_persona = $entrevistado->id_persona;
            $victima->id_e_ind_fvt = $entrevista->id_e_ind_fvt;
            $victima->insert_ent = $id_entrevistador;
            $victima->insert_ip='127.0.0.1';
            $victima->insert_fh=Carbon::now();
            $victima->save();
            //Actualizar que la persona entrevistada es víctima
            if($entrevistado->es_victima <> 1) {
                $entrevistado->es_victima=1;
                $entrevistado->save();
            }
        }
        //Crear el hecho
        $exilio_salida = exilio::join('fichas.exilio_movimiento','exilio.id_exilio','exilio_movimiento.id_exilio')
                            ->where('exilio.id_e_ind_fvt',$entrevista->id_e_ind_fvt)
                            ->where('exilio_movimiento.id_tipo_movimiento',1)
                            ->orderby('exilio.id_exilio')
                            ->orderby('id_exilio_movimiento')
                            ->first();
        $hecho = new hecho();
        $hecho->id_e_ind_fvt = $entrevista->id_e_ind_fvt;
        $hecho->cantidad_victimas = $exilio_salida->cant_personas_salieron > 0 ? $exilio_salida->cant_personas_salieron : 1;
        $hecho->id_lugar = $exilio_salida->id_lugar_salida;
        $hecho->sitio_especifico = $exilio_salida->salida_ciudad;
        $hecho->fecha_ocurrencia_a = $exilio_salida->fecha_salida_a;
        $hecho->fecha_ocurrencia_m = $exilio_salida->fecha_salida_m;
        $hecho->fecha_ocurrencia_d = $exilio_salida->fecha_salida_d;
        $hecho->aun_continuan=2;
        $hecho->observaciones = "Hecho ingresado automáticamente a partir de la ficha de exilio";
        $hecho->insert_ent = $id_entrevistador;
        $hecho->insert_ip='127.0.0.1';
        $hecho->insert_fh=Carbon::now();
        $hecho->save();
        //Definir exilio como violencia
        $hecho_violencia = new hecho_violencia();
        $hecho_violencia->id_hecho = $hecho->id_hecho;
        $hecho_violencia->id_tipo_violencia = $id_tipo_violencia;
        $hecho_violencia->id_subtipo_violencia = $id_subtipo_voilencia;
        $hecho_violencia->save();
        //Definir responsable como NS/NR
        $hecho_responsabilidad = new hecho_responsabilidad();
        $hecho_responsabilidad->id_hecho = $hecho->id_hecho;
        $hecho_responsabilidad->aa_id_tipo = $aa_id_tipo;
        $hecho_responsabilidad->aa_id_subtipo = $aa_id_subtipo;
        $hecho_responsabilidad->save();
        //Agregar víctima al hecho
        $hecho_victima = new hecho_victima();
        $hecho_victima->id_hecho = $hecho->id_hecho;
        $hecho_victima->id_victima = $victima->id_victima;
        $hecho_victima->edad = $hecho_victima->calcular_edad();
        $hecho_victima->save();
        //Traza de actividad
        traza_actividad::create(['id_objeto'=>112, 'id_accion'=>3, 'codigo'=>$entrevista->entrevista_codigo, 'id_primaria'=>$entrevista->id_e_ind_fvt]);
        //Fin


        $res->exito=true;
        return $res;









    }

    //Corregir falta de metadato
    public static function corregir_falta_metadato() {
        $inicio = Carbon::now();
        $arregladas=array();
        $no_arregladas=array();
        Log::notice("Crear metadato 'exilio' para entrevistas de interes de exilio: inicio del proceso");


        $listado = cc_exilio::where('metadato','No')->orderby('id_entrevista')->pluck('codigo_entrevista','id_entrevista');
        $id_exilio = 47;  //id_cat_item para exilio (id_cat=5)
        foreach($listado as $id_entrevista=>$codigo) {
            $arreglo['id_e_ind_fvt']=$id_entrevista;
            $arreglo['id_tv']=$id_exilio;
            $existe = entrevista_individual_tv::where('id_e_ind_fvt',$id_entrevista)->where('id_tv',$id_exilio)->count();
            if($existe==0) {
                entrevista_individual_tv::create($arreglo);
                $arregladas[]=$codigo;
            }
            else {
                $no_arregladas[]=$codigo;
            }

        }
        $fin = Carbon::now();
        $respuesta= new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->corregidas = $arregladas;
        $respuesta->no_corregidas = $no_arregladas;
        $respuesta->conteo_corregidas = count($arregladas);
        $respuesta->conteo_no_corregidas = count($no_arregladas);
        Log::info("Crear metadato 'exilio' para entrevistas de interes de exilio: fin del proceso, $respuesta->conteo_corregidas entrevistas corregidas,  $respuesta->conteo_no_corregidas no fue necesario corregir. Tiempo: $respuesta->duracion.".PHP_EOL."Corregidas: ".implode(', ',$arregladas));
        return $respuesta;
    }

}
