<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


/**
 * @property int $id_entrevista_profundidad
 * @property int $correlativo
 * @property int $clasificacion
 * @property string $codigo_entrevista
 * @property string $codigo_entrevistador
 * @property int $macroterritorio_id
 * @property string $macroterritorio_txt
 * @property int $territorio_id
 * @property string $territorio_txt
 * @property int $grupo_id
 * @property string $grupo_txt
 * @property string $entrevista_fecha_inicio
 * @property string $entrevista_fecha_final
 * @property string $entrevista_avance_codigo
 * @property string $entrevista_avance_txt
 * @property string $entrevista_lugar_n1_codigo
 * @property string $entrevista_lugar_n1_txt
 * @property string $entrevista_lugar_n2_codigo
 * @property string $entrevista_lugar_n2_txt
 * @property string $entrevista_lugar_n3_codigo
 * @property string $entrevista_lugar_n3_txt
 * @property string $titulo
 * @property string $objetivo
 * @property string $entrevistado_nombres
 * @property string $entrevistado_apellidos
 * @property string $sector_entrevistado
 * @property string $anotaciones
 * @property string $remitido
 * @property string $transcrita
 * @property string $tiempo_entrevista
 * @property int $aa_paramilitar
 * @property int $aa_guerrilla
 * @property int $aa_fuerza_publica
 * @property int $aa_terceros_civiles
 * @property int $aa_otro_grupo_armado
 * @property int $aa_otro_agente_estado
 * @property int $aa_otro_actor
 * @property int $aa_ns_nr
 * @property int $aa_internacional
 * @property int $viol_homicidio
 * @property int $viol_atentado_vida
 * @property int $viol_amenaza_vida
 * @property int $viol_desaparicion_f
 * @property int $viol_tortura
 * @property int $viol_violencia_sexual
 * @property int $viol_esclavitud
 * @property int $viol_reclutamiento
 * @property int $viol_detencion_arbitraria
 * @property int $viol_secuestro
 * @property int $viol_confinamiento
 * @property int $viol_pillaje
 * @property int $viol_extorsion
 * @property int $viol_ataque_bien_protegido
 * @property int $viol_ataque_indiscriminado
 * @property int $viol_despojo_tierras
 * @property int $viol_desplazamiento_forzado
 * @property int $viol_exilio
 * @property int $i_objetivo_esclarecimiento
 * @property int $i_objetivo_reconocimiento
 * @property int $i_objetivo_convivencia
 * @property int $i_objetivo_no_repeticion
 * @property int $i_enfoque_genero
 * @property int $i_enfoque_psicosocial
 * @property int $i_enfoque_curso_vida
 * @property int $i_direccion_investigacion
 * @property int $i_direccion_territorios
 * @property int $i_direccion_etnica
 * @property int $i_comisionados
 * @property int $i_estrategia_arte
 * @property int $i_estrategia_comunicacion
 * @property int $i_estrategia_participacion
 * @property int $i_estrategia_pedagogia
 * @property int $i_grupo_acceso_informacion
 * @property int $i_presidencia
 * @property int $i_otra
 * @property int $i_enlace
 * @property int $i_sistema_informacion
 * @property int $ia_pueblo_etnico
 * @property int $ia_dialogo_social
 * @property int $ia_ds_o_convivencia
 * @property int $ia_ds_o_reconocimiento
 * @property int $ia_ds_o_no_repeticion
 * @property int $ia_genero
 * @property int $ia_enfoque_ps
 * @property int $ia_curso_vida
 * @property int $mandato_01
 * @property int $mandato_02
 * @property int $mandato_03
 * @property int $mandato_04
 * @property int $mandato_05
 * @property int $mandato_06
 * @property int $mandato_07
 * @property int $mandato_08
 * @property int $mandato_09
 * @property int $mandato_10
 * @property int $mandato_11
 * @property int $mandato_12
 * @property int $mandato_13
 * @property string $dinamica_1
 * @property string $dinamica_2
 * @property string $dinamica_3
 * @property string $a_consentimiento
 * @property string $a_audio
 * @property string $a_relatoria
 * @property string $a_otros
 * @property string $a_transcripcion_preliminar
 * @property string $a_transcripcion_final
 * @property string $a_retroalimentacion
 * @property float $entrevista_lat
 * @property float $entrevista_lon
 * @property string $transcripcion_html
 * @property string $created_at
 * @property string $updated_at
 */
class excel_entrevista_pr extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'esclarecimiento.excel_entrevista_pr';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_entrevista_profundidad';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['correlativo', 'clasificacion', 'codigo_entrevista', 'codigo_entrevistador', 'macroterritorio_id', 'macroterritorio_txt', 'territorio_id', 'territorio_txt', 'grupo_id', 'grupo_txt', 'entrevista_fecha_inicio', 'entrevista_fecha_final', 'entrevista_avance_codigo', 'entrevista_avance_txt', 'entrevista_lugar_n1_codigo', 'entrevista_lugar_n1_txt', 'entrevista_lugar_n2_codigo', 'entrevista_lugar_n2_txt', 'entrevista_lugar_n3_codigo', 'entrevista_lugar_n3_txt', 'titulo', 'objetivo', 'entrevistado_nombres', 'entrevistado_apellidos', 'sector_entrevistado', 'anotaciones', 'remitido', 'transcrita', 'tiempo_entrevista', 'i_objetivo_esclarecimiento', 'i_objetivo_reconocimiento', 'i_objetivo_convivencia', 'i_objetivo_no_repeticion', 'i_enfoque_genero', 'i_enfoque_psicosocial', 'i_enfoque_curso_vida', 'i_direccion_investigacion', 'i_direccion_territorios', 'i_direccion_etnica', 'i_comisionados', 'i_estrategia_arte', 'i_estrategia_comunicacion', 'i_estrategia_participacion', 'i_estrategia_pedagogia', 'i_grupo_acceso_informacion', 'i_presidencia', 'i_otra', 'i_enlace', 'i_sistema_informacion', 'ia_pueblo_etnico', 'ia_dialogo_social', 'ia_ds_o_convivencia', 'ia_ds_o_reconocimiento', 'ia_ds_o_no_repeticion', 'ia_genero', 'ia_enfoque_ps', 'ia_curso_vida', 'mandato_01', 'mandato_02', 'mandato_03', 'mandato_04', 'mandato_05', 'mandato_06', 'mandato_07', 'mandato_08', 'mandato_09', 'mandato_10', 'mandato_11', 'mandato_12', 'mandato_13', 'dinamica_1', 'dinamica_2', 'dinamica_3', 'a_consentimiento', 'a_audio', 'a_relatoria', 'a_otros', 'a_transcripcion_preliminar', 'a_transcripcion_final', 'a_retroalimentacion', 'entrevista_lat', 'entrevista_lon', 'transcripcion_html', 'created_at', 'updated_at'];

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

    //
    public static function generar_plana($vaciar=false) {
        $inicio = Carbon::now();
        // Nueva logica, siempre truncar
        Log::notice("ETL de entrevistas a profundidad: inicio del proceso");

        //No está al día, procesar
        $total_filas=0;
        $total_errores=0;
        excel_entrevista_pr::truncate();
        //$listado = entrevista_individual::filtrar($filtros)->orderby('entrevista_correlativo')->get();
        $listado = entrevista_profundidad::where('id_activo',1)->orderby('entrevista_correlativo')->get();

        foreach($listado as $fila) {
            $excel = new excel_entrevista_pr();
            $excel->id_entrevista_profundidad = $fila->id_entrevista_profundidad;
            $excel->correlativo = $fila->entrevista_correlativo;
            $excel->clasificacion = $fila->clasificacion_nivel;
            $excel->tipo_entrevista = $fila->fmt_id_tipo;
            $excel->codigo_entrevista = $fila->entrevista_codigo;
            $excel->codigo_entrevistador = $fila->rel_id_entrevistador->numero_entrevistador;
            $excel->macroterritorio_id = $fila->id_macroterritorio;
            $excel->macroterritorio_txt = $fila->fmt_id_macroterritorio;
            $excel->territorio_id = $fila->id_territorio;
            $excel->territorio_txt = $fila->fmt_id_territorio;

            //Entrevistador
            $excel->id_entrevistador = $fila->id_entrevistador;
            $quien=$fila->rel_id_entrevistador;
            $excel->grupo_id = $quien->id_grupo;
            $excel->grupo_txt = $quien->fmt_grupo;

            $excel->entrevista_fecha_inicio = $fila->fmt_entrevista_fecha_inicio;
            $excel->entrevista_fecha_final = $fila->fmt_entrevista_fecha_final;
            $excel->entrevista_avance_codigo = $fila->entrevista_avance;
            $excel->entrevista_avance_txt = $fila->fmt_entrevista_avance;
            $excel->tiempo_entrevista = $fila->tiempo_entrevista;
            $id_lugar = $fila->entrevista_lugar;
            while($geo = geo::find($id_lugar)) {
                $nivel = $geo->nivel;
                $campo_c = "entrevista_lugar_n".$nivel."_codigo";
                $campo_t = "entrevista_lugar_n".$nivel."_txt";
                $excel->$campo_c = $geo->codigo;
                $excel->$campo_t = $geo->descripcion;
                $id_lugar=$geo->id_padre;
            }
            $excel->titulo = $fila->titulo;
            $excel->objetivo = $fila->entrevista_objetivo;
            //$excel->entrevistado_nombres = $fila->entrevistado_nombres;
            //$excel->entrevistado_apellidos = $fila->entrevistado_apellidos;
            $excel->entrevistado_nombres = 'NN';
            $excel->entrevistado_apellidos = 'AA';
            $excel->sector_entrevistado = $fila->fmt_id_sector;
            $excel->anotaciones = $fila->observaciones;

            $excel->remitido = $fila->fmt_id_remitido;
            //$excel->transcrita = strip_tags($fila->fmt_estado_transcripcion);
            $excel->transcrita = is_null($fila->html_transcripcion) ? "0" : "1";
            $excel->etiquetada = is_null($fila->json_etiquetado) ? "0" : "1";
            //Hizo parte de
            $excel->policia_parte = $fila->id_policia_parte == 1 ? 1 : 0;
            $excel->policia_rango = $fila->fmt_id_policia_rango;
            $excel->paramilitar_parte = $fila->id_paramilitar_parte ==1 ? 1 : 0;
            $excel->paramilitar_rango = $fila->fmt_id_paramilitar_rango;
            $excel->guerrilla_parte = $fila->id_guerrilla_parte == 1 ? 1 : 0;
            $excel->guerrilla_rango = $fila->fmt_id_guerrilla_rango;
            $excel->ejercito_parte = $fila->id_ejercito_parte == 1 ? 1 : 0;
            $excel->ejercito_rango = $fila->fmt_id_ejercito_rango;
            $excel->fuerza_aerea_parte = $fila->id_fuerza_aerea_parte == 1 ? 1 : 0;
            $excel->fuerza_aerea_rango = $fila->fmt_id_fuerza_aerea_rango;
            $excel->fuerza_naval_parte = $fila->id_fuerza_naval_parte == 1 ? 1 : 0;
            $excel->fuerza_naval_rango = $fila->fmt_id_fuerza_naval_rango;
            $excel->tercero_civil_parte = $fila->id_tercero_civil_parte == 1 ? 1 : 0;
            $excel->tercero_civil_cual = $fila->id_tercero_civil_cual;
            $excel->agente_estado_parte = $fila->id_agente_estado_parte == 1 ? 1 : 0;
            $excel->agente_estado_cual = $fila->id_agente_estado_cual;

            //Temas
            $i=1;

            foreach($fila->rel_tema as $item) {
                $campo="tema_$i";
                if($i<=5) {
                    $excel->$campo=$item->tema;
                }
                $i++;
            }
            //Rellenar
            $j=$i;
            while($j <= 5) {
                $campo="tema_$j";
                $excel->$campo="(Sin Especificar)";
                $j++;
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
            /*
            //Interes_area
            $aa = $fila->rel_interes_area;
            foreach($aa as $item) {
                $campo=$item->rel_id_interes->otro;
                if(strlen($campo)>0) {
                    $excel->$campo=1;
                }
                //dd($campo);
            }
            */
            //Mandato
            $aa = $fila->rel_mandato;
            foreach($aa as $item) {
                $campo=$item->rel_id_mandato->otro;
                if(strlen($campo)>0) {

                    $excel->$campo=1;
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

            //Priorizacion el entrevistador
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.pr'))
                ->where('prioridad.id_tipo',1)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_e($excel,$prioridad);

            //Priorizacion del transcriptor
            $prioridad = $fila->rel_prioridad()
                ->where('prioridad.id_subserie',config('expedientes.pr'))
                ->where('prioridad.id_tipo',2)
                ->orderby('prioridad.fecha_hora','desc')
                ->first();
            self::procesar_prioridad_t($excel,$prioridad);

            //Adjuntos

            $adjuntos[1]="a_consentimiento";
            $adjuntos[2]="a_audio";
            $adjuntos[3]="a_ficha_corta";
            $adjuntos[4]="a_otros";
            $adjuntos[5]="a_ficha_larga";
            $adjuntos[6]="a_transcripcion_final";
            $adjuntos[8]="a_transcripcion_preliminar";
            $adjuntos[10]="a_retroalimentacion";
            $adjuntos[11]="a_relatoria";
            $adjuntos[17]="a_certificacion_inicial";
            $adjuntos[18]="a_certificacion_final";
            $adjuntos[21]="a_plan_trabajo";
            $adjuntos[22]="a_valoracion";
            $adjuntos[23]="a_comunicacion_oficial";

            foreach($fila->rel_adjunto as $adjunto) {
                if(isset($adjuntos[$adjunto->id_tipo])) {
                    $campo=$adjuntos[$adjunto->id_tipo];
                    $excel->$campo=1;
                }
            }

            //Campos nuevos
            $lugar_e = $fila->rel_entrevista_lugar;
            if($lugar_e) {
                $excel->entrevista_lat = $lugar_e->lat;
                $excel->entrevista_lon = $lugar_e->lon;
            }


            //Buscar transcripcion html
            $lis_adjunto = $fila->rel_adjunto()->where('id_tipo',6)->get();
            $html="";
            foreach($lis_adjunto as $opcion) {
                $adjunto = $opcion->rel_id_adjunto;
                try {
                    $info = pathinfo($adjunto->ubicacion);
                }
                catch(\Exception $e) {

                }

                $ext = isset($info['extension']) ? $info['extension'] : "xxx";
                $ext=mb_strtolower($ext);
                if($ext=='html') {
                    $ubica='public'.$adjunto->ubicacion;
                    if(Storage::exists($ubica)) {
                        try {
                            $html .= Storage::get($ubica);
                        }
                        catch(\Exception $e) {
                            //no hacer nada
                        }

                    }
                }
            }
            //$excel->transcripcion_html = $html;
            $excel->transcripcion_html = $fila->html_transcripcion;
            $excel->etiquetado_json = $fila->json_etiquetado;

            //Actualizar la base de datos
            // Actualizar la base de datos con transcripcion Para no hacer lecturas a disco innecesarias
            if(strlen($fila->json_etiquetado)<=0 && strlen($fila->html_transcripcion)<=0) {
                if(strlen($html)>0){
                    $fila->html_transcripcion = $html;
                    $fila->save();
                }
            }

            //dd($fila->fh_insert);
            if(!is_null($fila->created_at)) {
                $excel->created_at = Carbon::createFromFormat('Y-m-d H:i:s',$fila->created_at);
            }

            if(!is_null($fila->updated_at)) {
                $excel->updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $fila->updated_at);
            }
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                //$excel->ERROR=$e->getMessage();
                $total_errores++;
                Log::error('Problemas con el ETL de entrevistas a profundidad'.PHP_EOL.$e->getMessage());
                //dd($excel);
            }



        }
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_filas = $total_filas;
        $respuesta->total_errores = $total_errores;


        Log::info("ETL de entrevistas a profundidad: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        return $respuesta;

    }

    public static function scopePermisos($query) {
        $arreglo_entrevistadores = entrevistador::permitidos_acceso_entrevistas();
        $query->join('esclarecimiento.entrevista_profundidad','excel_entrevista_pr.id_entrevista_profundidad','entrevista_profundidad.id_entrevista_profundidad')
            ->wherein('entrevista_profundidad.id_entrevistador',$arreglo_entrevistadores);
    }
    //Para usarla en todos los instrumentos
    public static function procesar_prioridad_e($excel,$prioridad) {
        if($prioridad) {//Puedo recibir valores nulos
            $excel->prioridad_e_fecha = substr($prioridad->fecha_hora,0,10);
            $excel->prioridad_e_fluidez = $prioridad->fluidez;
            $excel->prioridad_e_d_hecho = $prioridad->d_hecho;
            $excel->prioridad_e_d_contexto = $prioridad->d_contexto;
            $excel->prioridad_e_d_impacto = $prioridad->d_impacto;
            $excel->prioridad_e_d_justicia = $prioridad->d_justicia;
            $excel->prioridad_e_cierre = $prioridad->cierre;
            $excel->prioridad_e_ponderacion = $prioridad->ponderacion;
            $excel->prioridad_e_ahora_entiendo = $prioridad->ahora_entiendo;
            $excel->prioridad_e_cambio_perspectiva = $prioridad->cambio_perspectiva;
        }

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

}
