<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


/**
 * Class excel_entrevista
 * @package App\Models
 * @version June 5, 2019, 8:32 pm -05
 *

 * @property integer id_e_ind_fvt
 * @property string tipo_entrevista
 * @property integer correlativo
 * @property integer clasificacion
 * @property string codigo_entrevista
 * @property string codigo_entrevistador
 * @property integer macroterritorio_id
 * @property string macroterritorio_txt
 * @property integer territorio_id
 * @property string territorio_txt
 * @property integer grupo_id
 * @property string grupo_txt
 * @property string entrevista_fecha
 * @property integer tiempo_entrevista
 * @property string entrevista_lugar_n1_codigo
 * @property string entrevista_lugar_n1_txt
 * @property string entrevista_lugar_n2_codigo
 * @property string entrevista_lugar_n2_txt
 * @property string entrevista_lugar_n3_codigo
 * @property string entrevista_lugar_n3_txt
 * @property string titulo
 * @property string hechos_lugar_n1_codigo
 * @property string hechos_lugar_n1_txt
 * @property string hechos_lugar_n2_codigo
 * @property string hechos_lugar_n2_txt
 * @property string hechos_lugar_n3_codigo
 * @property string hechos_lugar_n3_txt
 * @property string hechos_del
 * @property string hechos_al
 * @property string anotaciones
 * @property integer es_prioritario
 * @property string prioritario_tema
 * @property string sector_victima
 * @property string interes_etnico
 * @property string remitido
 * @property string transcrita
 * @property string etiquetada
 * @property integer aa_paramilitar
 * @property integer aa_guerrilla
 * @property integer aa_fuerza_publica
 * @property integer aa_terceros_civiles
 * @property integer aa_otro
 * @property integer viol_homicidio
 * @property integer viol_atentado_vida
 * @property integer viol_amenaza_vida
 * @property integer viol_desaparicion_f
 * @property integer viol_tortura
 * @property integer viol_violencia_sexual
 * @property integer viol_esclavitud
 * @property integer viol_detencion_arbitraria
 * @property integer viol_secuestro
 * @property integer viol_confinamiento
 * @property integer viol_pillaje
 * @property integer viol_extorsion
 * @property integer viol_ataque_bien_protegido
 * @property integer viol_ataque_indiscriminado
 * @property integer viol_despojo_tierras
 * @property integer viol_desplazamiento_forzado
 * @property integer viol_exilio
 * @property integer i_objetivo_esclarecimiento
 * @property integer i_objetivo_reconocimiento
 * @property integer i_objetivo_convivencia
 * @property integer i_objetivo_no_repeticion
 * @property integer i_enfoque_genero
 * @property integer i_enfoque_psicosocial
 * @property integer i_enfoque_curso_vida
 * @property integer i_direccion_investigacion
 * @property integer i_direccion_territorios
 * @property integer i_direccion_etnica
 * @property integer i_comisionados
 * @property integer i_estrategia_arte
 * @property integer i_estrategia_comunicacion
 * @property integer i_estrategia_participacion
 * @property integer i_estrategia_pedagogia
 * @property integer i_grupo_acceso_informacion
 * @property integer i_presidencia
 * @property integer i_otra
 * @property integer i_enlace
 * @property integer i_sistema_informacion
 * @property integer mandato_01
 * @property integer mandato_02
 * @property integer mandato_03
 * @property integer mandato_04
 * @property integer mandato_05
 * @property integer mandato_06
 * @property integer mandato_07
 * @property integer mandato_08
 * @property integer mandato_09
 * @property integer mandato_10
 * @property integer mandato_11
 * @property integer mandato_12
 * @property integer mandato_13
 * @property string dinamica_1
 * @property string dinamica_2
 * @property string dinamica_3
 * @property string a_consentimiento
 * @property string a_audio
 * @property string a_ficha_corta
 * @property string a_ficha_larga
 * @property string a_otros
 * @property string a_transcripcion_preliminar
 * @property string a_transcripcion_final
 * @property string a_retroalimentacion
 * @property string a_etiquetado
 * @property float entrevista_lat
 * @property float entrevista_lon
 * @property float hechos_lat
 * @property float hechos_lon
 * @property string transcripcion_html
 * @property string transcripcion_fecha
 * @property string etiquetado_json
 * @property string etiquetado_fecha
 * @property string|\Carbon\Carbon created_at
 * @property string|\Carbon\Carbon updated_at
 */
class excel_entrevista extends Model
{

    public $table = 'esclarecimiento.excel_entrevista_fvt';
    protected $primaryKey = 'id_e_ind_fvt';
    
    public $timestamps = true;



    public $fillable = [
        'correlativo',
        'tipo_entrevista',
        'clasificacion',
        'codigo_entrevista',
        'codigo_entrevistador',
        'macroterritorio_id',
        'macroterritorio_txt',
        'territorio_id',
        'territorio_txt',
        'grupo_id',
        'grupo_txt',
        'entrevista_fecha',
        'tiempo_entrevista',
        'entrevista_lugar_n1_codigo',
        'entrevista_lugar_n1_txt',
        'entrevista_lugar_n2_codigo',
        'entrevista_lugar_n2_txt',
        'entrevista_lugar_n3_codigo',
        'entrevista_lugar_n3_txt',
        'titulo',
        'hechos_lugar_n1_codigo',
        'hechos_lugar_n1_txt',
        'hechos_lugar_n2_codigo',
        'hechos_lugar_n2_txt',
        'hechos_lugar_n3_codigo',
        'hechos_lugar_n3_txt',
        'hechos_del',
        'hechos_al',
        'anotaciones',
        'aa_paramilitar',
        'aa_guerrilla',
        'aa_fuerza_publica',
        'aa_terceros_civiles',
        'aa_otro',
        'viol_homicidio',
        'viol_atentado_vida',
        'viol_amenaza_vida',
        'viol_desaparicion_f',
        'viol_tortura',
        'viol_violencia_sexual',
        'viol_esclavitud',
        'viol_detencion_arbitraria',
        'viol_secuestro',
        'viol_confinamiento',
        'viol_pillaje',
        'viol_extorsion',
        'viol_ataque_bien_protegido',
        'viol_ataque_indiscriminado',
        'viol_despojo_tierras',
        'viol_desplazamiento_forzado',
        'viol_exilio',
        'i_objetivo_esclarecimiento',
        'i_objetivo_reconocimiento',
        'i_objetivo_convivencia',
        'i_objetivo_no_repeticion',
        'i_enfoque_genero',
        'i_enfoque_psicosocial',
        'i_enfoque_curso_vida',
        'i_direccion_investigacion',
        'i_direccion_territorios',
        'i_direccion_etnica',
        'i_comisionados',
        'i_estrategia_arte',
        'i_estrategia_comunicacion',
        'i_estrategia_participacion',
        'i_estrategia_pedagogia',
        'i_grupo_acceso_informacion',
        'i_presidencia',
        'i_otra',
        'i_enlace',
        'i_sistema_informacion',
        'mandato_01',
        'mandato_02',
        'mandato_03',
        'mandato_04',
        'mandato_05',
        'mandato_06',
        'mandato_07',
        'mandato_08',
        'mandato_09',
        'mandato_10',
        'mandato_11',
        'mandato_12',
        'mandato_13',
        'dinamica_1',
        'dinamica_2',
        'dinamica_3',
        'a_consentimiento',
        'a_audio',
        'a_ficha_corta',
        'a_ficha_larga',
        'a_otros',
        'a_transcripcion_preliminar',
        'a_transcripcion_final',
        'a_retroalimentacion',
        'entrevista_lat',
        'entrevista_lon',
        'hechos_lat',
        'hechos_lon',
        'transcripcion_html',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id_e_ind_fvt' => 'integer',
        'tipo_entrevista' => 'string',
        'correlativo' => 'integer',
        'clasificacion' => 'integer',
        'codigo_entrevista' => 'string',
        'codigo_entrevistador' => 'string',
        'macroterritorio_id' => 'integer',
        'macroterritorio_txt' => 'string',
        'territorio_id' => 'integer',
        'territorio_txt' => 'string',
        'grupo_id' => 'integer',
        'grupo_txt' => 'string',
        'entrevista_fecha' => 'string',
        'entrevista_lugar_n1_codigo' => 'string',
        'entrevista_lugar_n1_txt' => 'string',
        'entrevista_lugar_n2_codigo' => 'string',
        'entrevista_lugar_n2_txt' => 'string',
        'entrevista_lugar_n3_codigo' => 'string',
        'entrevista_lugar_n3_txt' => 'string',
        'titulo' => 'string',
        'hechos_lugar_n1_codigo' => 'string',
        'hechos_lugar_n1_txt' => 'string',
        'hechos_lugar_n2_codigo' => 'string',
        'hechos_lugar_n2_txt' => 'string',
        'hechos_lugar_n3_codigo' => 'string',
        'hechos_lugar_n3_txt' => 'string',
        'hechos_del' => 'string',
        'hechos_al' => 'string',
        'anotaciones' => 'string',
        'aa_paramilitar' => 'integer',
        'aa_guerrilla' => 'integer',
        'aa_fuerza_publica' => 'integer',
        'aa_terceros_civiles' => 'integer',
        'aa_otro' => 'integer',
        'viol_homicidio' => 'integer',
        'viol_atentado_vida' => 'integer',
        'viol_amenaza_vida' => 'integer',
        'viol_desaparicion_f' => 'integer',
        'viol_tortura' => 'integer',
        'viol_violencia_sexual' => 'integer',
        'viol_esclavitud' => 'integer',
        'viol_detencion_arbitraria' => 'integer',
        'viol_secuestro' => 'integer',
        'viol_confinamiento' => 'integer',
        'viol_pillaje' => 'integer',
        'viol_extorsion' => 'integer',
        'viol_ataque_bien_protegido' => 'integer',
        'viol_ataque_indiscriminado' => 'integer',
        'viol_despojo_tierras' => 'integer',
        'viol_desplazamiento_forzado' => 'integer',
        'viol_exilio' => 'integer',
        'i_objetivo_esclarecimiento' => 'integer',
        'i_objetivo_reconocimiento' => 'integer',
        'i_objetivo_convivencia' => 'integer',
        'i_objetivo_no_repeticion' => 'integer',
        'i_enfoque_genero' => 'integer',
        'i_enfoque_psicosocial' => 'integer',
        'i_enfoque_curso_vida' => 'integer',
        'i_direccion_investigacion' => 'integer',
        'i_direccion_territorios' => 'integer',
        'i_direccion_etnica' => 'integer',
        'i_comisionados' => 'integer',
        'i_estrategia_arte' => 'integer',
        'i_estrategia_comunicacion' => 'integer',
        'i_estrategia_participacion' => 'integer',
        'i_estrategia_pedagogia' => 'integer',
        'i_grupo_acceso_informacion' => 'integer',
        'i_presidencia' => 'integer',
        'i_otra' => 'integer',
        'i_enlace' => 'integer',
        'i_sistema_informacion' => 'integer',
        'mandato_01' => 'integer',
        'mandato_02' => 'integer',
        'mandato_03' => 'integer',
        'mandato_04' => 'integer',
        'mandato_05' => 'integer',
        'mandato_06' => 'integer',
        'mandato_07' => 'integer',
        'mandato_08' => 'integer',
        'mandato_09' => 'integer',
        'mandato_10' => 'integer',
        'mandato_11' => 'integer',
        'mandato_12' => 'integer',
        'mandato_13' => 'integer',
        'dinamica_1' => 'string',
        'dinamica_2' => 'string',
        'dinamica_3' => 'string',
        'a_consentimiento' => 'string',
        'a_audio' => 'string',
        'a_ficha_corta' => 'string',
        'a_ficha_larga' => 'string',
        'a_otros' => 'string',
        'a_transcripcion_preliminar' => 'string',
        'a_transcripcion_final' => 'string',
        'a_retroalimentacion' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];




    //
    public static function generar_plana($truncar=false) {
        $inicio = Carbon::now();
        // Nueva logica, siempre truncar
        Log::notice("ETL de entrevistas individuales: inicio del proceso");
        $total_filas=0;
        $total_errores=0;
        excel_entrevista::truncate();
        //$listado = entrevista_individual::filtrar($filtros)->orderby('entrevista_correlativo')->get();
        //$listado = entrevista_individual::id_subserie($filtros->id_subserie)->orderby('entrevista_correlativo')->get();
        $listado = entrevista_individual::id_activo(1)->orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_entrevista();
            $excel->id_e_ind_fvt = $fila->id_e_ind_fvt;
            $excel->tipo_entrevista = $fila->fmt_id_subserie_codigo;
            $excel->correlativo = $fila->entrevista_correlativo;
            $excel->clasificacion = $fila->clasifica_nivel;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $excel->macroterritorio_id = $fila->id_macroterritorio;
            $excel->macroterritorio_txt = $fila->fmt_id_macroterritorio;
            $excel->territorio_id = $fila->id_territorio;
            $excel->territorio_txt = $fila->fmt_id_territorio;
            $excel->titulo = $fila->titulo;
            $excel->hechos_del = $fila->fmt_hechos_del;
            $excel->hechos_al = $fila->fmt_hechos_al;
            $excel->anotaciones = $fila->anotaciones;
            //Nuevos campos
            $excel->es_prioritario = $fila->id_prioritario==1 ? 1 : 0;
            $excel->prioritario_tema = $fila->prioritario_tema;
            $excel->sector_victima = $fila->fmt_id_sector;
            $excel->interes_etnico = $fila->id_etnico == 1 ? 1 : 0 ;
            $excel->remitido = $fila->fmt_id_remitido;
            //$excel->transcrita = entrevista_individual::estado_transcrita($fila);
            $excel->transcrita = is_null($fila->html_transcripcion) ? "0" : "1";
            $excel->transcripcion_fecha = entrevista_individual::fecha_transcrita($fila);
            if(substr($excel->transcripcion_fecha,0,2)=="20") {
                $excel->transcripcion_fecha = substr($excel->transcripcion_fecha,0,10);
                $excel->transcripcion_fecha_a = substr($excel->transcripcion_fecha,0,4);
                $excel->transcripcion_fecha_m = substr($excel->transcripcion_fecha,0,7);
            }

            //$excel->etiquetada = entrevista_individual::estado_etiquetada($fila);
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "0" : "1";
            $excel->etiquetado_fecha = entrevista_individual::fecha_etiquetada($fila);
            if(substr($excel->etiquetado_fecha,0,2)=="20") {
                $excel->etiquetado_fecha = substr($excel->etiquetado_fecha, 0, 10);
                $excel->etiquetado_fecha_a = substr($excel->etiquetado_fecha, 0, 4);
                $excel->etiquetado_fecha_m = substr($excel->etiquetado_fecha, 0, 7);
            }
            //Entrevistador
            $quien=$fila->rel_id_entrevistador;
            $excel->id_entrevistador = $fila->id_entrevistador;
            $excel->grupo_id = $quien->id_grupo;
            $excel->grupo_txt = $quien->fmt_grupo;
            $excel->entrevista_fecha = $fila->fmt_entrevista_fecha;
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            //Transcripcion y etiquetado
            $excel->transcripcion_html = $fila->html_transcripcion;
            $excel->etiquetado_json = $fila->json_etiquetado;



            //Lugar de la entrevista
            $geo = $fila->rel_entrevista_lugar;
            if($geo) {
                $excel->entrevista_lugar_n3_codigo = $geo->codigo;
                $excel->entrevista_lugar_n3_txt = $geo->descripcion;
                $excel->entrevista_lat = $geo->lat;
                $excel->entrevista_lon = $geo->lon;

                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->entrevista_lugar_n2_codigo = $geo->codigo;
                    $excel->entrevista_lugar_n2_txt = $geo->descripcion;
                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->entrevista_lugar_n1_codigo = $geo->codigo;
                        $excel->entrevista_lugar_n1_txt = $geo->descripcion;
                    }
                }
            }


            // Lugar de los hechos
            $geo = $fila->rel_hechos_lugar;
            if($geo) {
                $excel->hechos_lugar_n3_codigo = $geo->codigo;
                $excel->hechos_lugar_n3_txt = $geo->descripcion;
                $excel->hechos_lat = $geo->lat;
                $excel->hechos_lon = $geo->lon;

                $geo=geo::find($geo->id_padre);
                if($geo) {
                    $excel->hechos_lugar_n2_codigo = $geo->codigo;
                    $excel->hechos_lugar_n2_txt = $geo->descripcion;

                    $geo=geo::find($geo->id_padre);
                    if($geo) {
                        $excel->hechos_lugar_n1_codigo = $geo->codigo;
                        $excel->hechos_lugar_n1_txt = $geo->descripcion;
                    }
                }

            }

            //Fuerzas responsables
            $aa = $fila->rel_fr;
            foreach($aa as $item) {
                $campo=$item->rel_id_fr->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Violencia
            $aa = $fila->rel_tv;
            foreach($aa as $item) {
                $campo=$item->rel_id_tv->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Interes
            $aa = $fila->rel_interes;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                //dd($campo);
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
            }
            //Interes_area
            $aa = $fila->rel_interes_area;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
                //dd($campo);
            }
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $tmp = $item->rel_id_mandato;
                if($tmp) {
                    $campo = $tmp->otro;
                    if(strlen($campo)>0) {
                        $excel->$campo=1;
                    }
                }
            }
            //Dinamicas
            $i=1;
            $aa = $fila->rel_dinamica;
            foreach($aa as $item) {
                $campo="dinamica_$i";
                if($i<=3) {
                    $excel->$campo=$item->dinamica;
                }
                $i++;
            }
            //Rellenar
            $j=$i;
            while($j <= 3) {
                $campo="dinamica_$j";
                $excel->$campo="(Sin Especificar)";
                $j++;
            }

            // Revisar adjuntos
            $adjuntos[1]="a_consentimiento";
            $adjuntos[2]="a_audio";
            $adjuntos[3]="a_ficha_corta";
            $adjuntos[5]="a_ficha_larga";
            $adjuntos[4]="a_otros";
            $adjuntos[8]="a_transcripcion_preliminar";
            $adjuntos[6]="a_transcripcion_final";
            $adjuntos[10]="a_retroalimentacion";
            $adjuntos[11]="a_relatoria";
            $adjuntos[17]="a_certificacion_inicial";
            $adjuntos[18]="a_certificacion_final";
            $adjuntos[21]="a_plan_trabajo";
            $adjuntos[22]="a_valoracion";
            $adjuntos[25]="a_etiquetado";
            foreach($fila->rel_adjunto as $adjunto) {
                if(isset($adjuntos[$adjunto->id_tipo])) {
                    $campo=$adjuntos[$adjunto->id_tipo];
                    $excel->$campo=1;
                }
            }




            //dd($fila->fh_insert);
            if(!is_null($fila->fh_insert)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert);
                $excel->created_at_month = Carbon::createFromFormat('Y-m-d H:i:s.u',$fila->fh_insert)->format("Y-m");
            }

            if(!is_null($fila->fh_update)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s.u', $fila->fh_update);
            }

            //Nuevos campos a partir del diligenciamiento de formularios
            $ficha = $fila->rel_ficha_entrevista;
            if($ficha) {
                $excel->ficha_priorizar_entrevista = $ficha->priorizar_entrevista==1 ? 1 : 0;
                $excel->ficha_priorizar_entrevista_asuntos = $ficha->priorizar_entrevista_asuntos;
                $excel->ficha_contiene_patrones = $ficha->contiene_patrones==1 ? 1 : 0;
                $excel->ficha_contiene_patrones_cuales = $ficha->contiene_patrones_cuales;
                $excel->ci_conceder_entrevista = $ficha->conceder_entrevista==1 ? 1 : 0;
                $excel->ci_grabar_audio =$ficha->grabar_audio==1 ? 1 : 0;
                $excel->ci_elaborar_informe = $ficha->elabrorar_informe==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_analizar = $ficha->tratamiento_datos_analizar==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_analizar_sensible = $ficha->tratamiento_datos_analizar_sensible==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_utilizar = $ficha->tratamiento_datos_utilizar==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_utilizar_sensible = $ficha->tratamiento_datos_utilizar_sensible==1 ? 1 : 0;
                $excel->ci_tratamiento_datos_publicar = $ficha->tratamiento_datos_publicar==1 ? 1 : 0;
            }
            $persona = $fila->rel_ficha_persona_entrevistada;
            if($persona) {
                $excel->sintesis_relato  = $persona->sintesis_relato;
                $excel->persona_entrevistada_es_victima  = $persona->es_victima==1 ? 1 : 0;
                $excel->persona_entrevistada_es_testigo  = $persona->es_testigo==1 ? 1 : 0;
                $p = $persona->rel_id_persona;
                if($p) {
                    $excel->persona_entrevistada_sexo = cat_item::describir($p->id_sexo);
                }
            }

            $conteo = $fila->conteo_fichas();
            $excel->cantidad_fichas_victima = $conteo->victimas;
            $excel->cantidad_fichas_exilio = $conteo->exilio;

            //Prioridad
            $prioridad = $fila->prioridad;
            if($prioridad) {
                $excel->prioridad_fluidez = $prioridad->fluidez;
                $excel->prioridad_d_hecho = $prioridad->d_hecho;
                $excel->prioridad_d_contexto = $prioridad->d_contexto;
                $excel->prioridad_d_impacto = $prioridad->d_impacto;
                $excel->prioridad_d_justicia = $prioridad->d_justicia;
                $excel->prioridad_cierre = $prioridad->cierre;
                $excel->prioridad_ponderacion = $prioridad->ponderacion;
                $excel->prioridad_ahora_entiendo = $prioridad->ahora_entiendo;
                $excel->prioridad_cambio_perspectiva = $prioridad->cambio_perspectiva;
            }

            //Es una entrevista virtual
            $excel->es_virtual = $fila->es_virtual == 1 ? 1 : 0 ;
            //Es procesable
            $excel->procesamiento_requisitos_minimos = $fila->puede_transcribirse ? 1 : 0;
            // Es de interes para exilio
            $res=0;
            if($fila->rel_id_macroterritorio->codigo=='IN') {
                $res=1;
            }
            $hay_violencia = entrevista_individual_tv::join('catalogos.cat_item','e_ind_fvt_tv.id_tv','=','id_item')
                ->where('e_ind_fvt_tv.id_e_ind_fvt',$fila->id_e_ind_fvt)
                ->where('cat_item.descripcion','ilike','exilio')
                ->count();
            if($hay_violencia > 0) {
                $res=1;
            }
            $excel->interes_exilio = $res;
            $excel->procesamiento_cerrado = $fila->id_cerrado ==1 ? 1 : 0 ;


            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de excel_entrevista: ".$e->getMessage());
            }




        }
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;
        if($total_errores>0) {
            Log::error("ETL de entrevistas individuales finalizada con  $total_errores errores");
        }

        Log::info("ETL de entrevistas individuales: fin del proceso, $total_filas filas generadas ($total_errores errores reportados). Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function scopePermisos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->join('esclarecimiento.e_ind_fvt','excel_entrevista_fvt.id_e_ind_fvt','e_ind_fvt.id_e_ind_fvt')
                ->wherein('e_ind_fvt.id_entrevistador',$arreglo_entrevistadores);
    }


}
