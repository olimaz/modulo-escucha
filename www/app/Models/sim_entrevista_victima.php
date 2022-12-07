<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int $id_entrevista_victima
 * @property string $titulo
 * @property string $creador
 * @property string $fecha_inicio_entrevista
 * @property string $fecha_fin_entrevista
 * @property string $tipo_recurso
 * @property string $tipo_entrevista
 * @property string $identificador
 * @property string $nivel_descripcion
 * @property int $derechos_acceso
 * @property string $fecha_carga
 * @property string $cobertura_temporal_inicio
 * @property string $cobertura_temporal_fin
 * @property string $cobertura_geografica
 * @property string $lugar_entrevista
 * @property string $poblacion
 * @property string $derechos
 * @property string $actores_conflicto
 * @property string $hecho_victimizante
 * @property string $territorio
 * @property string $areas_interes
 * @property string $adjuntos
 * @property string $transcripcion
 * @property string $transcripcion_txt
 * @property string $etiquetado_json
 * @property string $titulo_entrevista
 * @property string $sintesis_entrevista
 */
class sim_entrevista_victima extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sim.entrevista_victima';
    //Para textos fijos
    protected $txt_cev = "Comisión para el Esclarecimiento de la Verdad, la Convivencia y la No Repetición - CEV";

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_victima';

    /**
     * @var array
     */
    protected $fillable = ['titulo', 'creador', 'fecha_inicio_entrevista', 'fecha_fin_entrevista', 'tipo_recurso', 'identificador', 'nivel_descripcion', 'derechos_acceso', 'fecha_carga', 'cobertura_temporal_inicio', 'cobertura_temporal_fin', 'cobertura_geografica', 'lugar_entrevista', 'poblacion', 'derechos', 'actores_conflicto', 'hecho_victimizante', 'territorio', 'areas_interes','adjuntos','transcripcion'];

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



    /*
     * Poblar la tabla
     */
    public static function generar_plana($truncar=true) {
        $inicio = Carbon::now();

        Log::notice("ETL de integración de datos de entrevistas a víctimas: inicio del proceso");

        if($truncar) {
            sim_entrevista_victima::truncate();
        }


        $total_filas=0;
        $total_errores=0;

        $individual = sim_entrevista_victima::procesar_e_individual();
        $colectiva = sim_entrevista_victima::procesar_e_colectiva();
        $etnica = sim_entrevista_victima::procesar_e_etnica();
        $pr = sim_entrevista_victima::procesar_e_profundidad();
        $dc = sim_entrevista_victima::procesar_d_comunitario();
        $hv = sim_entrevista_victima::procesar_h_vida();


        $total_filas =   $individual['si'] + $colectiva['si'] + $etnica['si'] + $pr['si'] + $dc['si'] + $hv['si'];
        $total_errores = $individual['no'] + $colectiva['no'] + $etnica['no'] + $pr['no'] + $dc['no'] + $hv['no'];

        $fin = Carbon::now();

        $r = new \stdClass();
        $r->individual = $individual['si'];
        $r->colectiva  = $colectiva['si'];
        $r->etnica  = $etnica['si'];
        $r->profundidad  = $pr['si'];
        $r->diagnostico_comunitario  = $dc['si'];
        $r->historia_vida  = $hv['si'];
        $r->inicio = $inicio;
        $r->fin = $fin;
        $r->duracion = $fin->diffForHumans($inicio);
        $r->total_filas = $total_filas;
        $r->total_errores = $total_errores;

        if($total_errores>0) {
            Log::error("ETL de sim_entrevista_victima finalizada con  $total_errores errores");
        }



        //Registrar el fin del proceso
        Log::info("ETL de integración de datos de entrevistas a víctimas:  fin del proceso, $total_filas filas generadas. Tiempo: $r->duracion.");
        return $r;

    }

    public static function procesar_e_individual()
    {
        //Listado: no borrados (id_activo=1) que sean a víctimas
        $listado = entrevista_individual::id_activo(1)
            ->orderby('entrevista_codigo')
            ->get();
        $total_filas = 0;
        $total_errores = 0;
        foreach ($listado as $fila) {
            $excel = new sim_entrevista_victima();
            $excel->titulo = $fila->entrevista_codigo;
            $excel->creador = "Entrevistador " . $fila->numero_entrevistador;
            //$excel->creador = self::texto_fijo(1);
            $excel->fecha_inicio_entrevista = substr($fila->entrevista_fecha, 0, 10);
            $excel->fecha_fin_entrevista = substr($fila->entrevista_fecha, 0, 10);
            $excel->tipo_recurso = cat_item::describir($fila->id_subserie);
            $excel->tipo_entrevista = cat_item::describir($fila->id_subserie);
            //$excel->tipo_recurso = "Entrevista individual a víctimas, familiares y testigos";
            $excel->identificador = $fila->entrevista_codigo;
            $excel->nivel_descripcion = "Unidad documental compuesta";
            $excel->derechos_acceso = $fila->clasifica_nivel;
            $excel->fecha_carga = substr($fila->fh_insert, 0, 10);
            $excel->cobertura_temporal_inicio = substr($fila->hechos_del, 0, 4);
            $excel->cobertura_temporal_fin = substr($fila->hechos_al, 0, 4);
            // Otros datos
            $otros_datos =  array();
            $otros_datos['observaciones'] = $fila->observaciones;
            $excel->otros_datos = \GuzzleHttp\json_encode($otros_datos);

            // Cobertura geográfica
            $geo = $fila->rel_hechos_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->cobertura_geografica = json_encode($ubicacion);
            //Lugar entrevista
            $geo = $fila->rel_entrevista_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->lugar_entrevista = json_encode($ubicacion);
            //
            $catalogo = array();
            $catalogo['id'] = $fila->id_sector;
            $catalogo['descripcion'] = $fila->fmt_id_sector;
            $excel->poblacion = json_encode($catalogo);
            //
            //$excel->derechos = "Comisión de la verdad";
            $excel->derechos = self::texto_fijo(1);
            //Fuerzas responsables
            $aa = $fila->rel_fr;
            $listado_aa = array();
            foreach ($aa as $item) {
                $listado_aa[] = $item->rel_id_fr->descripcion;
            }
            $excel->actores_conflicto = json_encode($listado_aa);
            //Hecho victimizante
            $listado_viol = array();
            $aa = $fila->rel_tv;
            foreach ($aa as $item) {
                $listado_viol[] = $item->rel_id_tv->descripcion;
            }
            $excel->hecho_victimizante = json_encode($listado_viol);
            // Territorio
            $territorio['macroterritorio']['id'] = $fila->id_macroterritorio;
            $territorio['macroterritorio']['descripcion'] = $fila->fmt_id_macroterritorio;
            $territorio['territorio']['id'] = $fila->id_territorio;
            $territorio['territorio']['descripcion'] = $fila->fmt_id_territorio;
            $excel->territorio = json_encode($territorio);
            //Areas de interes
            $listado_areas = array();

            //Interes
            $aa = $fila->rel_interes;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }
            //Interes_area
            $aa = $fila->rel_interes_area;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_mandato->descripcion;
            }

            $excel->areas_interes = json_encode($listado_areas);


            //Adjuntos
            $lis_adjuntos = self::procesar_adjunto($fila);
            $excel->adjuntos = json_encode($lis_adjuntos);


            //$excel->transcripcion = $otranscribe;
            //Campos nuevos
            $excel->titulo_entrevista = $fila->titulo;
            $entrevistado = $fila->rel_ficha_persona_entrevistada;
            if ($entrevistado) {
                $excel->sintesis_entrevista = $entrevistado->sintesis_relato;
            }
            //Transcripcion y etiquetado
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            $excel->etiquetado_json = $fila->json_etiquetado;

            //Información del procesamiento de la entrevista
            $procesamiento = self::datos_procesamiento($fila);
            $excel->procesamiento = json_encode($procesamiento);

            //Marcas
            $excel->entrevista_codigo = $fila->entrevista_codigo;
            if(!is_null($fila->fh_insert)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m-d");
            }
            if(!is_null($fila->fh_update)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_update)->format("Y-m-d");
            }
            //JSON con priorizacion
            $excel->priorizacion = self::procesar_prioridad($fila, $fila->id_subserie);
            //JSON con consentimiento informado
            $excel->consentimiento_informado = self::procesar_consentimiento($fila);


            //Remiendo temporal, para ocultar las R-1
            if($fila->clasificacion_nivel > 1) {
                try {
                    $excel->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de sim_entrevista_victima-VI: ".PHP_EOL.$e->getMessage());
                }
            }
        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;
    }

    public static function procesar_e_colectiva()
    {
        //Listado: no borrados (id_activo=1) que sean a víctimas
        $listado = entrevista_colectiva::id_activo(1)
            ->orderby('entrevista_codigo')
            ->get();
        $total_filas = 0;
        $total_errores = 0;
        foreach ($listado as $fila) {
            $excel = new sim_entrevista_victima();
            $excel->titulo = $fila->entrevista_codigo;
            $excel->creador = "Entrevistador " . $fila->numero_entrevistador;
            //$excel->creador = self::texto_fijo(1);
            $excel->fecha_inicio_entrevista = substr($fila->entrevista_fecha_inicio, 0, 10);
            $excel->fecha_fin_entrevista = substr($fila->entrevista_fecha_final, 0, 10);
            $excel->tipo_recurso = cat_item::describir(config('expedientes.co'));
            $excel->tipo_entrevista = cat_item::describir(config('expedientes.co'));
            $excel->identificador = $fila->entrevista_codigo;
            $excel->nivel_descripcion = "Unidad documental compuesta";
            $excel->derechos_acceso = $fila->clasificacion_nivel;
            $excel->fecha_carga = substr($fila->created_at, 0, 10);
            $excel->cobertura_temporal_inicio = substr($fila->tema_del, 0, 4);
            $excel->cobertura_temporal_fin = substr($fila->tema_al, 0, 4);
            // Otros datos
            $otros_datos =  array();
            $otros_datos['cantidad_participantes'] = $fila->cantidad_participantes;
            $otros_datos['tema_objetivo'] = $fila->tema_objetivo;
            $otros_datos['tema_descripcion'] = $fila->tema_descripcion;
            $otros_datos['eventos_descripcion'] = $fila->eventos_descripcion;
            $otros_datos['observaciones'] = $fila->observaciones;
            $excel->otros_datos = \GuzzleHttp\json_encode($otros_datos);

            // Cobertura geográfica
            $geo = $fila->rel_tema_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->cobertura_geografica = json_encode($ubicacion);
            //Lugar entrevista
            $geo = $fila->rel_entrevista_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->lugar_entrevista = json_encode($ubicacion);
            //
            $catalogo = array();
            $catalogo['id'] = $fila->id_sector;
            $catalogo['descripcion'] = $fila->fmt_id_sector;
            $excel->poblacion = json_encode($catalogo);
            //
            //$excel->derechos = "Comisión de la verdad";
            $excel->derechos = self::texto_fijo(1);

            // Territorio
            $territorio['macroterritorio']['id'] = $fila->id_macroterritorio;
            $territorio['macroterritorio']['descripcion'] = $fila->fmt_id_macroterritorio;
            $territorio['territorio']['id'] = $fila->id_territorio;
            $territorio['territorio']['descripcion'] = $fila->fmt_id_territorio;
            $excel->territorio = json_encode($territorio);
            //Areas de interes
            $listado_areas = array();

            //Interes
            $aa = $fila->rel_interes;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_mandato->descripcion;
            }

            $excel->areas_interes = json_encode($listado_areas);


            //Adjuntos
            $lis_adjuntos = self::procesar_adjunto($fila);
            $excel->adjuntos = json_encode($lis_adjuntos);

            //Campos nuevos
            $excel->titulo_entrevista = $fila->titulo;
            $entrevistado = $fila->rel_ficha_persona_entrevistada;

            //Transcripcion y etiquetado
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            $excel->etiquetado_json = $fila->json_etiquetado;

            //Información del procesamiento de la entrevista
            $procesamiento = self::datos_procesamiento($fila);
            $excel->procesamiento = json_encode($procesamiento);

            //Marcas
            $excel->entrevista_codigo = $fila->entrevista_codigo;
            if(!is_null($fila->created_at)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
            }
            if(!is_null($fila->updated_at)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at)->format("Y-m-d");
            }

            //JSON con priorizacion
            $excel->priorizacion = self::procesar_prioridad($fila, config('expedientes.co'));
            //JSON con consentimiento informado
            $excel->consentimiento_informado = self::procesar_consentimiento($fila);

            //Remiendo temporal, para ocultar las R-1
            if($fila->clasificacion_nivel > 1) {
                try {
                    $excel->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de sim_entrevista_victima-CO: ".PHP_EOL.$e->getMessage());
                }
            }


        }
        $res['si'] = $total_filas;
        $res['no'] = $total_errores;
        return $res;
    }

    public static function procesar_e_etnica()
    {
        //Listado: no borrados (id_activo=1) que sean a víctimas
        $listado = entrevista_etnica::id_activo(1)
            ->orderby('entrevista_codigo')
            ->get();
        $total_filas = 0;
        $total_errores = 0;
        foreach ($listado as $fila) {
            $excel = new sim_entrevista_victima();
            $excel->titulo = $fila->entrevista_codigo;
            $excel->creador = "Entrevistador " . $fila->numero_entrevistador;
            //$excel->creador = self::texto_fijo(1);
            $excel->fecha_inicio_entrevista = substr($fila->entrevista_fecha_inicio, 0, 10);
            $excel->fecha_fin_entrevista = substr($fila->entrevista_fecha_final, 0, 10);
            $excel->tipo_recurso = cat_item::describir(config('expedientes.ee'));
            $excel->tipo_entrevista = cat_item::describir(config('expedientes.ee'));
            $excel->identificador = $fila->entrevista_codigo;
            $excel->nivel_descripcion = "Unidad documental compuesta";
            $excel->derechos_acceso = $fila->clasificacion_nivel;
            $excel->fecha_carga = substr($fila->created_at, 0, 10);
            $excel->cobertura_temporal_inicio = substr($fila->tema_del, 0, 4);
            $excel->cobertura_temporal_fin = substr($fila->tema_al, 0, 4);
            $excel->titulo_entrevista = $fila->titulo;
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            // Otros datos
            $otros_datos =  array();
            $otros_datos['cantidad_participantes'] = $fila->cantidad_participantes;
            $otros_datos['tema_objetivo'] = $fila->tema_objetivo;
            $otros_datos['tema_descripcion'] = $fila->tema_descripcion;
            $otros_datos['tipo_entrevista'] = cat_item::describir($fila->id_tipo_entrevista);
            $otros_datos['tipo_sujeto'] = cat_item::describir($fila->id_tipo_sujeto);
            $otros_datos['observaciones'] = $fila->observaciones;
            //grupos indigenas
            $arreglo = array();
            $listado = $fila->rel_indigena;
            foreach($listado as $i) {
                $arreglo[] = cat_item::describir($i->id_indigena);
            }
            $otros_datos['grupos_indigenas'] = $arreglo;

            //grupos afro
            $arreglo = array();
            $listado = $fila->rel_narp;
            foreach($listado as $i) {
                $arreglo[] = cat_item::describir($i->id_narf);
            }
            $otros_datos['grupos_afro'] = $arreglo;

            //grupos rrom
            $arreglo = array();
            $listado = $fila->rel_rrom;
            foreach($listado as $i) {
                $arreglo[] = cat_item::describir($i->id_rrom);
            }
            $otros_datos['grupos_rrom'] = $arreglo;


            $excel->otros_datos = \GuzzleHttp\json_encode($otros_datos);

            // Cobertura geográfica
            $geo = $fila->rel_tema_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->cobertura_geografica = json_encode($ubicacion);
            //Lugar entrevista
            $geo = $fila->rel_entrevista_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->lugar_entrevista = json_encode($ubicacion);
            //
            $catalogo = array();
            $catalogo['id'] = $fila->id_sector;
            $catalogo['descripcion'] = $fila->fmt_id_sector;
            $excel->poblacion = json_encode($catalogo);
            //
            //$excel->derechos = "Comisión de la verdad";
            $excel->derechos = self::texto_fijo(1);

            // Territorio
            $territorio['macroterritorio']['id'] = $fila->id_macroterritorio;
            $territorio['macroterritorio']['descripcion'] = $fila->fmt_id_macroterritorio;
            $territorio['territorio']['id'] = $fila->id_territorio;
            $territorio['territorio']['descripcion'] = $fila->fmt_id_territorio;
            $excel->territorio = json_encode($territorio);
            //Areas de interes
            $listado_areas = array();

            //Interes
            $aa = $fila->rel_interes;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_mandato->descripcion;
            }

            $excel->areas_interes = json_encode($listado_areas);

            //Adjuntos
            $lis_adjuntos = self::procesar_adjunto($fila);
            $excel->adjuntos = json_encode($lis_adjuntos);

            //Transcripcion y etiquetado
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            $excel->etiquetado_json = $fila->json_etiquetado;

            //Información del procesamiento de la entrevista
            $procesamiento = self::datos_procesamiento($fila);
            $excel->procesamiento = json_encode($procesamiento);

            //Marcas
            $excel->entrevista_codigo = $fila->entrevista_codigo;
            if(!is_null($fila->created_at)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
            }
            if(!is_null($fila->updated_at)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at)->format("Y-m-d");
            }

            //JSON con priorizacion
            $excel->priorizacion = self::procesar_prioridad($fila, config('expedientes.ee'));
            //JSON con consentimiento informado
            $excel->consentimiento_informado = self::procesar_consentimiento($fila);


            //Remiendo temporal, para ocultar las R-1
            if($fila->clasificacion_nivel > 1) {
                try {
                    $excel->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de sim_entrevista_victima-EE: ".PHP_EOL.$e->getMessage());
                }
            }


        }
        $res['si']=$total_filas;
        $res['no']=$total_errores;
        return $res;

    }

    public static function procesar_e_profundidad()
    {
        //Listado: no borrados (id_activo=1) que sean a víctimas
        $listado = entrevista_profundidad::id_activo(1)
            ->orderby('entrevista_codigo')
            ->get();
        $total_filas = 0;
        $total_errores = 0;
        foreach ($listado as $fila) {
            $excel = new sim_entrevista_victima();
            $excel->titulo = $fila->entrevista_codigo;
            $excel->creador = "Entrevistador " . $fila->numero_entrevistador;
            //$excel->creador = self::texto_fijo(1);
            $excel->fecha_inicio_entrevista = substr($fila->entrevista_fecha_inicio, 0, 10);
            $excel->fecha_fin_entrevista = substr($fila->entrevista_fecha_final, 0, 10);
            $excel->tipo_recurso = cat_item::describir(config('expedientes.pr'))." - ".$fila->entrevistado_nombres." ".$fila->enrevsitado_apellidos;
            $excel->tipo_entrevista = cat_item::describir(config('expedientes.pr'));
            $excel->identificador = $fila->entrevista_codigo;
            $excel->nivel_descripcion = "Unidad documental compuesta";
            $excel->derechos_acceso = $fila->clasificacion_nivel;
            $excel->fecha_carga = substr($fila->created_at, 0, 10);
            //$excel->derechos = "Comisión de la verdad";
            $excel->derechos = self::texto_fijo(1);
            //$excel->cobertura_temporal_inicio = substr($fila->tema_del, 0, 4);
            //$excel->cobertura_temporal_fin = substr($fila->tema_al, 0, 4);
            $excel->titulo_entrevista = $fila->titulo;
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            //Sector al que pertenece
            $catalogo = array();
            $catalogo['id'] = $fila->id_sector;
            $catalogo['descripcion'] = $fila->fmt_id_sector;
            $excel->poblacion = json_encode($catalogo);
            // Territorio
            $territorio['macroterritorio']['id'] = $fila->id_macroterritorio;
            $territorio['macroterritorio']['descripcion'] = $fila->fmt_id_macroterritorio;
            $territorio['territorio']['id'] = $fila->id_territorio;
            $territorio['territorio']['descripcion'] = $fila->fmt_id_territorio;
            $excel->territorio = json_encode($territorio);


            // Otros datos
            $otros_datos =  array();
            $otros_datos['entrevista_objetivo'] = $fila->entrevista_objetivo;
            $otros_datos['observaciones'] = $fila->observaciones;
            $otros_datos['tipo_entrevista'] = criterio_fijo::describir(15,$fila->id_tipo);
            $otros_datos['policia']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_policia_parte);
            $otros_datos['policia']['rango'] = cat_item::describir($fila->id_policia_rango);
            $otros_datos['paramilitar']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_paramilitar_parte);
            $otros_datos['paramilitar']['rango'] = cat_item::describir($fila->id_paramilitar_rango);
            $otros_datos['guerrilla']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_guerrilla_parte);
            $otros_datos['guerrilla']['rango'] = cat_item::describir($fila->id_guerrilla_rango);
            $otros_datos['ejercito']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_ejercito_parte);
            $otros_datos['ejercito']['rango'] = cat_item::describir($fila->id_ejercito_rango);
            $otros_datos['fuerza_aerea']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_fuerza_aerea_parte);
            $otros_datos['fuerza_aerea']['rango'] = cat_item::describir($fila->id_fuerza_aerea_rango);
            $otros_datos['fuerza_naval']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_fuerza_naval_parte);
            $otros_datos['fuerza_naval']['rango'] = cat_item::describir($fila->id_fuerza_naval_rango);
            $otros_datos['tercero_civil']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_tercero_civil_parte);
            $otros_datos['tercero_civil']['cual'] = $fila->id_tercero_civil_cual;
            $otros_datos['agente_estado']['hizo_parte'] = criterio_fijo::describir(2,$fila->id_agente_estado_parte);
            $otros_datos['agente_estado']['cual'] =  $fila->id_agente_estado_cual;
            $excel->otros_datos = \GuzzleHttp\json_encode($otros_datos);


            //Lugar entrevista
            $geo = $fila->rel_entrevista_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->lugar_entrevista = json_encode($ubicacion);



            //Areas de interes
            $listado_areas = array();
            $aa = $fila->rel_interes;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }

            //Mandato
            $aa = $fila->rel_mandato;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_mandato->descripcion;
            }

            $excel->areas_interes = json_encode($listado_areas);

            //Hecho victimizante
            $listado_viol = array();
            $aa = $fila->rel_violencia_victima;
            foreach ($aa as $item) {
                $listado_viol[] = $item->rel_id_violencia->descripcion;
            }
            $aa = $fila->rel_violencia_actor;
            foreach ($aa as $item) {
                $listado_viol[] = $item->rel_id_violencia->descripcion;
            }
            $excel->hecho_victimizante = json_encode($listado_viol);

            //Adjuntos
            $lis_adjuntos = self::procesar_adjunto($fila);
            $excel->adjuntos = json_encode($lis_adjuntos);

            //Transcripcion y etiquetado
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            $excel->etiquetado_json = $fila->json_etiquetado;
            //Información del procesamiento de la entrevista
            $procesamiento = self::datos_procesamiento($fila);
            $excel->procesamiento = json_encode($procesamiento);

            //codigo
            $excel->entrevista_codigo = $fila->entrevista_codigo;
            if(!is_null($fila->created_at)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
            }
            if(!is_null($fila->updated_at)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at)->format("Y-m-d");
            }

            //JSON con priorizacion
            $excel->priorizacion = self::procesar_prioridad($fila, config('expedientes.pr'));
            //JSON con consentimiento informado
            $excel->consentimiento_informado = self::procesar_consentimiento($fila);

            //Remiendo temporal, para ocultar las R-1
            if($fila->clasificacion_nivel > 1) {
                try {
                    $excel->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de sim_entrevista_victima-PR: ".PHP_EOL.$e->getMessage());
                }
            }


        }
        $res['si'] = $total_filas;
        $res['no'] = $total_errores;
        return $res;
    }

    public static function procesar_d_comunitario()
    {
        //Listado: no borrados (id_activo=1) que sean a víctimas
        $listado = diagnostico_comunitario::id_activo(1)
            ->orderby('entrevista_codigo')
            ->get();
        $total_filas = 0;
        $total_errores = 0;
        foreach ($listado as $fila) {
            $excel = new sim_entrevista_victima();
            $excel->titulo = $fila->entrevista_codigo;
            $excel->creador = "Entrevistador " . $fila->numero_entrevistador;
            //$excel->creador = self::texto_fijo(1);
            $excel->fecha_inicio_entrevista = substr($fila->entrevista_fecha_inicio, 0, 10);
            $excel->fecha_fin_entrevista = substr($fila->entrevista_fecha_final, 0, 10);
            $excel->tipo_recurso = cat_item::describir(config('expedientes.dc')). " - ".$fila->tema_comunidad;
            $excel->tipo_entrevista = cat_item::describir(config('expedientes.dc'));
            $excel->identificador = $fila->entrevista_codigo;
            $excel->nivel_descripcion = "Unidad documental compuesta";
            //$excel->derechos = "Comisión de la verdad";
            $excel->derechos = self::texto_fijo(1);
            $excel->derechos_acceso = $fila->clasificacion_nivel;
            $excel->fecha_carga = substr($fila->created_at, 0, 10);
            $excel->cobertura_temporal_inicio = substr($fila->tema_del, 0, 4);
            $excel->cobertura_temporal_fin = substr($fila->tema_al, 0, 4);
            $excel->titulo_entrevista = $fila->titulo;
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            //id_sector
            $catalogo = array();
            $catalogo['id'] = $fila->id_sector;
            $catalogo['descripcion'] = $fila->fmt_id_sector;
            $excel->poblacion = json_encode($catalogo);
            // Territorio
            $territorio['macroterritorio']['id'] = $fila->id_macroterritorio;
            $territorio['macroterritorio']['descripcion'] = $fila->fmt_id_macroterritorio;
            $territorio['territorio']['id'] = $fila->id_territorio;
            $territorio['territorio']['descripcion'] = $fila->fmt_id_territorio;
            $excel->territorio = json_encode($territorio);
            // Otros datos
            $otros_datos =  array();
            $otros_datos['cantidad_participantes'] = $fila->cantidad_participantes;
            $otros_datos['objetivo_entrevista'] = $fila->tema_objetivo;
            $otros_datos['dinamicas_identificadas'] = $fila->tema_dinamica;
            $otros_datos['observaciones'] = $fila->observaciones;
            $excel->otros_datos = \GuzzleHttp\json_encode($otros_datos);

            // Cobertura geográfica
            $geo = $fila->rel_tema_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->cobertura_geografica = json_encode($ubicacion);
            //Lugar entrevista
            $geo = $fila->rel_entrevista_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->lugar_entrevista = json_encode($ubicacion);

            //Areas de interes
            $listado_areas = array();
            //Interes
            $aa = $fila->rel_interes;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_mandato->descripcion;
            }
            $excel->areas_interes = json_encode($listado_areas);

            //Adjuntos
            $lis_adjuntos = self::procesar_adjunto($fila);
            $excel->adjuntos = json_encode($lis_adjuntos);


            //Campos nuevos
            //Transcripcion y etiquetado
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            $excel->etiquetado_json = $fila->json_etiquetado;
            //Información del procesamiento de la entrevista
            $procesamiento = self::datos_procesamiento($fila);
            $excel->procesamiento = json_encode($procesamiento);
            //codigo
            $excel->entrevista_codigo = $fila->entrevista_codigo;
            if(!is_null($fila->created_at)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
            }
            if(!is_null($fila->updated_at)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at)->format("Y-m-d");
            }

            //JSON con priorizacion
            $excel->priorizacion = self::procesar_prioridad($fila, config('expedientes.dc'));
            //JSON con consentimiento informado
            $excel->consentimiento_informado = self::procesar_consentimiento($fila);

            //Remiendo temporal, para ocultar las R-1
            if($fila->clasificacion_nivel > 1) {
                try {
                    $excel->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de sim_entrevista_victima-DC: ".PHP_EOL.$e->getMessage());
                }
            }


        }
        $res['si'] = $total_filas;
        $res['no'] = $total_errores;
        return $res;
    }

    public static function procesar_h_vida()
    {
        //Listado: no borrados (id_activo=1) que sean a víctimas
        $listado = historia_vida::id_activo(1)
            ->orderby('entrevista_codigo')
            ->get();
        $total_filas = 0;
        $total_errores = 0;
        foreach ($listado as $fila) {
            $excel = new sim_entrevista_victima();
            $excel->titulo = $fila->entrevista_codigo;
            $excel->creador = "Entrevistador " . $fila->numero_entrevistador;
            //$excel->creador = self::texto_fijo(1);
            $excel->fecha_inicio_entrevista = substr($fila->entrevista_fecha_inicio, 0, 10);
            $excel->fecha_fin_entrevista = substr($fila->entrevista_fecha_final, 0, 10);
            if(strlen($fila->entrevistado_otros_nombres)>0) {
                $otros=" ($fila->entrevistado_otros_nombres)";
            }
            else {
                $otros="";
            }
            $excel->tipo_recurso = cat_item::describir(config('expedientes.hv')). " - ".$fila->entrevistado_nombres. " ".$fila->entrevistado_apellidos.$otros;
            $excel->tipo_entrevista = cat_item::describir(config('expedientes.hv'));

            $excel->identificador = $fila->entrevista_codigo;
            $excel->nivel_descripcion = "Unidad documental compuesta";
            //$excel->derechos = "Comisión de la verdad";
            $excel->derechos = self::texto_fijo(1);
            $excel->derechos_acceso = $fila->clasificacion_nivel;
            $excel->fecha_carga = substr($fila->created_at, 0, 10);
            //$excel->cobertura_temporal_inicio = substr($fila->tema_del, 0, 4);
            //$excel->cobertura_temporal_fin = substr($fila->tema_al, 0, 4);
            $excel->titulo_entrevista = $fila->titulo;
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            //id_sector
            $catalogo = array();
            $catalogo['id'] = $fila->id_sector;
            $catalogo['descripcion'] = $fila->fmt_id_sector;
            $excel->poblacion = json_encode($catalogo);
            // Territorio
            $territorio['macroterritorio']['id'] = $fila->id_macroterritorio;
            $territorio['macroterritorio']['descripcion'] = $fila->fmt_id_macroterritorio;
            $territorio['territorio']['id'] = $fila->id_territorio;
            $territorio['territorio']['descripcion'] = $fila->fmt_id_territorio;
            $excel->territorio = json_encode($territorio);
            // Otros datos
            $otros_datos =  array();
            $otros_datos['objetivo_entrevista'] = $fila->entrevista_objetivo;
            $otros_datos['observaciones'] = $fila->observaciones;
            $otros_datos['sexo'] = cat_item::describir($fila->id_sexo);
            $otros_datos['orientacion_sexual'] = cat_item::describir($fila->id_orientacion_sexual);
            $otros_datos['identidad_genero'] = cat_item::describir($fila->id_identidad_genero);
            $otros_datos['pertenencia_etnico_racial'] = cat_item::describir($fila->id_pertenencia_etnico_racial);
            $excel->otros_datos = \GuzzleHttp\json_encode($otros_datos);


            //Lugar entrevista
            $geo = $fila->rel_entrevista_lugar;
            $ubicacion = array();
            if ($geo) {
                $ubicacion['n3']['codigo'] = $geo->codigo;
                $ubicacion['n3']['descripcion'] = $geo->descripcion;
                $ubicacion['n3']['lat'] = $geo->lat;
                $ubicacion['n3']['lon'] = $geo->lon;
                $geo = geo::find($geo->id_padre);
                if ($geo) {
                    $ubicacion['n2']['codigo'] = $geo->codigo;
                    $ubicacion['n2']['descripcion'] = $geo->descripcion;
                    $geo = geo::find($geo->id_padre);
                    if ($geo) {
                        $ubicacion['n1']['codigo'] = $geo->codigo;
                        $ubicacion['n1']['descripcion'] = $geo->descripcion;
                    }
                }
            }
            $excel->lugar_entrevista = json_encode($ubicacion);

            //Areas de interes
            $listado_areas = array();
            //Interes
            $aa = $fila->rel_interes;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_interes->descripcion;
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach ($aa as $item) {
                $listado_areas[] = $item->rel_id_mandato->descripcion;
            }
            $excel->areas_interes = json_encode($listado_areas);

            //Adjuntos
            $lis_adjuntos = self::procesar_adjunto($fila);
            $excel->adjuntos = json_encode($lis_adjuntos);

            //Campos nuevos
            //Transcripcion y etiquetado
            $excel->transcripcion = $fila->html_transcripcion;
            $excel->transcripcion_txt = $fila->extraer_texto_transcripcion();
            $excel->etiquetado_json = $fila->json_etiquetado;
            //Información del procesamiento de la entrevista
            $procesamiento = self::datos_procesamiento($fila);
            $excel->procesamiento = json_encode($procesamiento);
            //Marcas
            $excel->entrevista_codigo = $fila->entrevista_codigo;
            if(!is_null($fila->created_at)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at)->format("Y-m-d");
            }
            if(!is_null($fila->updated_at)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->updated_at)->format("Y-m-d");
            }

            //
            //JSON con priorizacion
            $excel->priorizacion = self::procesar_prioridad($fila, config('expedientes.hv'));
            //JSON con consentimiento informado
            $excel->consentimiento_informado = self::procesar_consentimiento($fila);

            //Remiendo temporal, para ocultar las R-1
            if($fila->clasificacion_nivel > 1) {
                try {
                    $excel->save();
                    $total_filas++;
                }
                catch(\Exception $e) {
                    $total_errores++;
                    Log::debug("Error en generar registro de sim_entrevista_victima-HV: ".PHP_EOL.$e->getMessage());
                }
            }
        }
        $res['si'] = $total_filas;
        $res['no'] = $total_errores;
        return $res;
    }

    public static function datos_procesamiento($fila) {
        //Para determinar los tiempos
        $tiempo[1]=0;
        $tiempo[2]=0;
        $tiempo[3]=0;
        //Procesamiento
        $procesamiento = new \stdClass();
        $procesamiento->transcrita = strlen($fila->html_transcripcion) > 0 ? 1 : 0;
        $procesamiento->etiquetada = strlen($fila->json_etiquetado) > 0 ? 1 : 0;
        $procesamiento->cerrada = $fila->id_cerrado == 1 ? 1 : 0;
        $procesamiento->es_virtual = $fila->es_virtual==1 ? 1 : 0;
        $tiempo_entrevista = 0;
        //Transcripciones
        $procesamiento->transcripcion = array();
        foreach($fila->rel_transcripcion as $asignacion) {
            $a = new \stdClass();
            $a->id_asignacion = $asignacion->id_transcribir_asignacion;
            $a->fh_asignado = is_null($asignacion->fh_asignado) ? null : $asignacion->fh_asignado->format("Y-m-d H:i:s");
            $a->fh_transcrito = is_null($asignacion->fh_transcrito) ? null : $asignacion->fh_transcrito->format("Y-m-d H:i:s");
            $a->fh_revocado = is_null($asignacion->fh_revocado) ? null : $asignacion->fh_revocado->format("Y-m-d H:i:s");
            $a->fh_anulado = is_null($asignacion->fh_anulado) ? null : $asignacion->fh_anulado->format("Y-m-d H:i:s");
            $a->asignado_por = $asignacion->rel_id_autoriza->fmt_numero_entrevistador;
            $a->asignado_a = $asignacion->rel_id_transcriptor->fmt_numero_entrevistador;
            $a->situacion = $asignacion->fmt_id_situacion;
            $a->porque_no = $asignacion->fmt_id_causa;
            $a->tiempo_transcripcion_minutos = $asignacion->duracion_transcripcion_minutos;
            $a->observaciones = $asignacion->observaciones;
            $procesamiento->transcripcion[]=$a;
            //Tiempos
            if($asignacion->duracion_entrevista_minutos > $tiempo_entrevista) {
                $tiempo_entrevista = $asignacion->duracion_entrevista_minutos;
            }
            $datos = procesamiento_tiempo::where('id_transcribir_asignacion',$asignacion->id_transcribir_asignacion)->pluck('tiempo_minutos','id_tipo_medicion');
            foreach($datos as $id => $duracion) {
                if($duracion > $tiempo[$id] ) {
                    $tiempo[$id] = $duracion;
                }
            }

        }
        //Etiquetado
        $procesamiento->etiquetado = array();
        foreach($fila->rel_etiquetado as $asignacion) {
            $a = new \stdClass();
            $a->id_asignacion = $asignacion->id_etiquetar_asignacion;
            $a->fh_asignado = is_null($asignacion->fh_asignado) ? null : $asignacion->fh_asignado->format("Y-m-d H:i:s");
            $a->fh_eitquetado = is_null($asignacion->fh_transcrito) ? null : $asignacion->fh_transcrito->format("Y-m-d H:i:s");
            $a->fh_revocado = is_null($asignacion->fh_revocado) ? null : $asignacion->fh_revocado->format("Y-m-d H:i:s");
            $a->fh_anulado = is_null($asignacion->fh_anulado) ? null : $asignacion->fh_anulado->format("Y-m-d H:i:s");
            $a->asignado_por = $asignacion->rel_id_autoriza->fmt_numero_entrevistador;
            $a->asignado_a = $asignacion->rel_id_transcriptor->fmt_numero_entrevistador;
            $a->situacion = $asignacion->fmt_id_situacion;
            $a->porque_no = $asignacion->fmt_id_causa;
            $a->tiempo_etiquetado_minutos = $asignacion->duracion_etiquetado_minutos;
            $a->observaciones = $asignacion->observaciones;
            $procesamiento->etiquetado[]=$a;
            //Tiempos
            if($asignacion->duracion_entrevista_minutos > $tiempo_entrevista) {
                $tiempo_entrevista = $asignacion->duracion_entrevista_minutos;
            }
            $datos = procesamiento_tiempo::where('id_etiquetar_asignacion',$asignacion->id_etiquetar_asignacion)->pluck('tiempo_minutos','id_tipo_medicion');
            foreach($datos as $id => $duracion) {
                if($duracion > $tiempo[$id] ) {
                    $tiempo[$id] = $duracion;
                }
            }
        }
        //Tiempo
        if($tiempo_entrevista==0 && $fila->tiempo_entrevista > 0) {
            $tiempo_entrevista = $fila->tiempo_entrevista;
        }

        $procesamiento->tiempos = new \stdClass();
        $procesamiento->tiempos->entrevista = $tiempo_entrevista;
        $procesamiento->tiempos->transcripcion = $tiempo[1];
        $procesamiento->tiempos->etiquetado = $tiempo[2];
        $procesamiento->tiempos->fichas = $tiempo[3];
        return $procesamiento;
    }



    //Para usarla en todos los instrumentos
    public static function procesar_prioridad($fila,$id_subserie) {
        $res=new \stdClass();
        $res->entrevistador= new \stdClass();
        $res->transcriptor = new \stdClass();

        //Priorizacion el entrevistador
        $prioridad = $fila->rel_prioridad()
            ->where('prioridad.id_subserie',$fila->id_subserie)
            ->where('prioridad.id_tipo',1)
            ->orderby('prioridad.fecha_hora','desc')
            ->first();
        if($prioridad) {
            $p = new \stdClass();
            $p->fecha = substr($prioridad->fecha_hora,0,10);
            $p->fluidez = $prioridad->fluidez;
            $p->d_hecho = $prioridad->d_hecho;
            $p->d_contexto = $prioridad->d_contexto;
            $p->d_impacto = $prioridad->d_impacto;
            $p->d_justicia = $prioridad->d_justicia;
            $p->cierre = $prioridad->cierre;
            $p->ponderacion = $prioridad->ponderacion;
            $p->ahora_entiendo = $prioridad->ahora_entiendo;
            $p->cambio_perspectiva = $prioridad->cambio_perspectiva;
            $res->entrevistador = $p;
        }

        //Priorizacion del transcriptor
        $prioridad = $fila->rel_prioridad()
            ->where('prioridad.id_subserie',$fila->id_subserie)
            ->where('prioridad.id_tipo',2)
            ->orderby('prioridad.fecha_hora','desc')
            ->first();
        if($prioridad) {
            $p = new \stdClass();
            $p->fecha = substr($prioridad->fecha_hora,0,10);
            $p->fluidez = $prioridad->fluidez;
            $p->d_hecho = $prioridad->d_hecho;
            $p->d_contexto = $prioridad->d_contexto;
            $p->d_impacto = $prioridad->d_impacto;
            $p->d_justicia = $prioridad->d_justicia;
            $p->cierre = $prioridad->cierre;
            $p->ponderacion = $prioridad->ponderacion;
            $p->ahora_entiendo = $prioridad->ahora_entiendo;
            $p->cambio_perspectiva = $prioridad->cambio_perspectiva;
            $res->transcriptor = $p;
        }
        return json_encode($res);

    }
    // Para todos los instrumentos
    public static function procesar_consentimiento($entrevista) {

        $consentimiento = $entrevista->rel_consentimiento;


        if($consentimiento instanceof entrevista) {
            $res = new \stdClass();
            $res->condecer_entrevista = $consentimiento->conceder_entrevista==1 ? true : false;
            $res->grabar_audio = $consentimiento->grabar_audio==1 ? true : false;
            $res->elaborar_informe = $consentimiento->elaborar_informe==1 ? true : false;
            $res->tratamiento_datos_analizar = $consentimiento->tratamiento_datos_analizar==1 ? true : false;
            $res->tratamiento_datos_analizar_sensible = $consentimiento->tratamiento_datos_analizar_sensible==1 ? true : false;
            $res->tratamiento_datos_utilizar = $consentimiento->tratamiento_datos_utilizar==1 ? true : false;
            $res->tratamiento_datos_utilizar_sensible = $consentimiento->tratamiento_datos_utilizar_sensible==1 ? true : false;
            $res->tratamiento_datos_publicar = $consentimiento->tratamiento_datos_publicar==1 ? true : false;
            return \GuzzleHttp\json_encode($res);
        }
        elseif($consentimiento instanceof Collection) {
            if(count($consentimiento)>0) {
                $tmp=[];
                $listado =  $consentimiento;
                foreach($listado  as $consentimiento ) {
                    $res = new \stdClass();
                    $res->condecer_entrevista = $consentimiento->conceder_entrevista==1 ? true : false;
                    $res->grabar_audio = $consentimiento->grabar_audio==1 ? true : false;
                    $res->elaborar_informe = $consentimiento->elaborar_informe==1 ? true : false;
                    $res->tratamiento_datos_analizar = $consentimiento->tratamiento_datos_analizar==1 ? true : false;
                    $res->tratamiento_datos_analizar_sensible = $consentimiento->tratamiento_datos_analizar_sensible==1 ? true : false;
                    $res->tratamiento_datos_utilizar = $consentimiento->tratamiento_datos_utilizar==1 ? true : false;
                    $res->tratamiento_datos_utilizar_sensible = $consentimiento->tratamiento_datos_utilizar_sensible==1 ? true : false;
                    $res->tratamiento_datos_publicar = $consentimiento->tratamiento_datos_publicar==1 ? true : false;
                    $tmp[]=$res;
                }
                return \GuzzleHttp\json_encode($tmp);
            }
            else {
                return null;
            }

        }

        return null;


    }

    //Para usarla en todos los instrumentos
    public static function procesar_prioridad_t($excel,$prioridad) {
        if($prioridad) { //Puedo recibir valores nulos
            $excel->prioridad_t_fecha = substr($prioridad->fecha_hora,0,10);
            $excel->prioridad_t_fluidez = $prioridad->fluidez;
            $excel->prioridad_t_d_hecho = $prioridad->d_hecho;
            $excel->prioridad_t_d_contexto = $prioridad->d_contexto;
            $excel->prioridad_t_d_impacto = $prioridad->d_impacto;
            $excel->prioridad_t_d_justicia = $prioridad->d_justicia;
            $excel->prioridad_t_cierre = $prioridad->cierre;
            $excel->prioridad_t_ponderacion = $prioridad->ponderacion;
            $excel->prioridad_t_ahora_entiendo = $prioridad->ahora_entiendo;
            $excel->prioridad_t_cambio_perspectiva = $prioridad->cambio_perspectiva;
        }
    }



    //Para llamar estaticamente
    public static function texto_fijo($cual=1) {
        if($cual==1) {
            return "Comisión para el Esclarecimiento de la Verdad, la Convivencia y la No Repetición - CEV";
        }
    }

    //Calificacion de adjuntos
    public static function procesar_adjunto($entrevista) {
        $lis_adjuntos = array();
        foreach ($entrevista->rel_adjunto as $adjuntado) {
            if ($adjuntado->rel_id_adjunto) {
                $registro = array();
                $registro['id_adjunto'] = $adjuntado->id_adjunto;
                $registro['tamano_en_bytes'] = $adjuntado->rel_id_adjunto->tamano_bruto;
                $registro['id_tipo'] = $adjuntado->id_tipo;
                $registro['tipo'] = criterio_fijo::describir(1, $adjuntado->id_tipo);
                $registro['archivo'] = storage_path('app/public') . $adjuntado->rel_id_adjunto->ubicacion;
                $registro['nombre_original'] = $adjuntado->rel_id_adjunto->nombre_original;
                $registro['fecha_archivo'] = $adjuntado->rel_id_adjunto->fecha_ruso;
                //
                $adjunto = $adjuntado->rel_id_adjunto;
                $acceso = new \stdClass();
                $acceso->calificacion = new \stdClass();
                $acceso->calificacion->id = $adjunto->id_calificacion;
                $acceso->calificacion->txt = $adjunto->fmt_id_calificacion;
                $a_justificacion=array();
                if(count($adjunto->rel_justificacion) >0) {
                    foreach($adjunto->rel_justificacion as $justificacion) {
                        $tmp = new \stdClass();
                        $tmp->id = $justificacion->id_justificacion;
                        $tmp->txt = $justificacion->fmt_id_justificacion;
                        $a_justificacion[]=$tmp;
                    }
                }
                $acceso->justificacion=$a_justificacion;
                $registro['calificacion']=$acceso;
                $lis_adjuntos[] = $registro;
            }
        }
        return $lis_adjuntos;
    }

}
