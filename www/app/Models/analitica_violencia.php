<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id_hecho
 * @property int $id_entrevista
 * @property string $codigo_entrevista
 * @property int $victimas_total
 * @property int $victimas_identificadas
 * @property int $responsables_identificados
 * @property int $cantidad_muertos
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property int $hechos_continuan
 * @property string $lugar_codigo
 * @property string $lugar_n1_codigo
 * @property string $lugar_n1_txt
 * @property string $lugar_n2_codigo
 * @property string $lugar_n2_txt
 * @property string $lugar_n3_codigo
 * @property string $lugar_n3_txt
 * @property string $lugar_n3_lat
 * @property string $lugar_n3_lon
 * @property string $lugar_sitio
 * @property string $lugar_zona
 * @property int $v_m_homicidio
 * @property int $v_m_masacre
 * @property int $v_m_combates
 * @property int $v_m_minas
 * @property int $v_m_atentado_bombas
 * @property int $v_m_ataque_bienes
 * @property int $v_m_sevicia
 * @property int $v_at_herido
 * @property int $v_at_sin_lesiones
 * @property int $v_at_civil_herido_combate
 * @property int $v_at_civil_herido_bomba
 * @property int $v_at_civil_minas
 * @property int $v_at_civil_ataque_bienes
 * @property int $v_amenaza
 * @property string $v_amenaza_mecanismos
 * @property string $v_amenaza_ind_col
 * @property int $v_desaparicion_forzada
 * @property int $v_desaparicion_forzada_mecanismos
 * @property int $v_tortura_fisica
 * @property string $v_tortura_fisica_mecanismos
 * @property string $v_tortura_fisica_ind_col
 * @property int $v_tortura_fisica_publico
 * @property int $v_tortura_psicologica
 * @property string $v_tortura_psicologica_mecanismos
 * @property string $v_tortura_psicologica_ind_col
 * @property int $v_tortura_psicologica_publico
 * @property int $v_vs_violacion_sexual
 * @property int $v_vs_embarazo_forzado
 * @property int $v_vs_amenaza
 * @property int $v_vs_anticoncepcion
 * @property int $v_vs_trata_personas
 * @property int $v_vs_prostitucion_forzada
 * @property int $v_vs_tortura_embarazo
 * @property int $v_vs_mutilacion
 * @property int $v_vs_enamoramiento
 * @property int $v_vs_acoso_sexual
 * @property int $v_vs_aborto_forzado
 * @property int $v_vs_obligar_presenciar
 * @property int $v_vs_obligar_realizar
 * @property int $v_vs_cambios_forzados
 * @property int $v_vs_otra_forma
 * @property int $v_vs_esclavitud
 * @property int $v_vs_desnudez_forzada
 * @property int $v_vs_maternidad_forzada
 * @property int $v_vs_cohabitacion_forzada
 * @property string $v_vs_ind_col
 * @property int $v_vs_publico
 * @property int $v_vs_multiple_responsable
 * @property int $v_vs_embarazo
 * @property int $v_vs_embarazo_nacimiento
 * @property int $v_esclavitud
 * @property int $v_esclavitud_publico
 * @property int $v_reclutamiento
 * @property int $v_reclutamiento_publico
 * @property string $v_reclutamiento_ind_col
 * @property int $v_secuestro
 * @property string $v_secuestro_ind_col
 * @property int $v_secuestro_publico
 * @property int $v_detencion
 * @property string $v_detencion_ind_col
 * @property int $v_confinamiento
 * @property string $v_confinamiento_ind_col
 * @property int $v_pillaje
 * @property int $v_extorsion
 * @property int $v_abp_civil
 * @property int $v_abp_religioso
 * @property int $v_abp_sagrado
 * @property int $v_abp_cultural
 * @property int $v_abp_peligroso
 * @property int $v_abp_medioambiente
 * @property int $v_ataque_indiscriminado
 * @property int $v_despojo
 * @property string $v_despojo_modalidad
 * @property string $v_despojo_ind_col
 * @property int $v_despojo_hectareas
 * @property int $v_despojo_recupero_tierras
 * @property int $v_despojo_recupero_derechos
 * @property int $v_desplazamiento
 * @property string $v_desplazamiento_ind_col
 * @property string $v_desplazamiento_origen_n1_codigo
 * @property string $v_desplazamiento_origen_n1_txt
 * @property string $v_desplazamiento_origen_n2_codigo
 * @property string $v_desplazamiento_origen_n2_txt
 * @property string $v_desplazamiento_origen_n3_codigo
 * @property string $v_desplazamiento_origen_n3_txt
 * @property string $v_desplazamiento_origen_codigo
 * @property string $v_desplazamiento_origen_n3_lat
 * @property string $v_desplazamiento_origen_n3_lon
 * @property string $v_desplazamiento_llegada_codigo
 * @property string $v_desplazamiento_llegada_n1_codigo
 * @property string $v_desplazamiento_llegada_n1_txt
 * @property string $v_desplazamiento_llegada_n2_codigo
 * @property string $v_desplazamiento_llegada_n2_txt
 * @property string $v_desplazamiento_llegada_n3_codigo
 * @property string $v_desplazamiento_llegada_n3_txt
 * @property string $v_desplazamiento_llegada_n3_lat
 * @property string $v_desplazamiento_llegada_n3_lon
 * @property string $v_desplazamiento_sentido
 * @property int $v_desplazamiento_retorno
 * @property string $v_desplazamiento_retorno_ind_col
 * @property int $v_exilio
 * @property int $aa_p_grupo_paramilitar
 * @property int $aa_p_ns_nr
 * @property int $aa_g_farc
 * @property int $aa_g_eln
 * @property int $aa_g_otro
 * @property int $aa_g_ns_nr
 * @property int $aa_fp_ejercito
 * @property int $aa_fp_armada
 * @property int $aa_fp_fuerza_aerea
 * @property int $aa_fp_policia
 * @property int $aa_oga_otro_grupo_armado
 * @property int $aa_oga_otro_pais
 * @property int $aa_ns_nr
 * @property int $tc_tc_politico
 * @property int $tc_tc_medios_comunicacion
 * @property int $tc_tc_social_comunitario
 * @property int $tc_tc_academico
 * @property int $tc_tc_religioso
 * @property int $tc_tc_econcomico
 * @property int $tc_tc_otros
 * @property int $tc_oae_ejecutivo_legislativo
 * @property int $tc_oae_organos_control
 * @property int $tc_oae_justicia
 * @property int $tc_oae_inteligencia
 * @property int $tc_oae_otro
 * @property int $tc_int_gobierno_extranjero
 * @property int $tc_int_empresa_transnacional
 * @property int $tc_int_otros
 * @property int $tc_otro_actor
 * @property string $creacion_fh
 * @property string $creacion_fecha
 * @property string $creacion_mes
 */
class analitica_violencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'analitica.violencia';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_hecho';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_entrevista', 'codigo_entrevista', 'victimas_total', 'victimas_identificadas', 'responsables_identificados', 'cantidad_muertos', 'fecha_inicio', 'fecha_fin', 'hechos_continuan', 'lugar_codigo', 'lugar_n1_codigo', 'lugar_n1_txt', 'lugar_n2_codigo', 'lugar_n2_txt', 'lugar_n3_codigo', 'lugar_n3_txt', 'lugar_n3_lat', 'lugar_n3_lon', 'lugar_sitio', 'lugar_zona', 'v_m_homicidio', 'v_m_masacre', 'v_m_combates', 'v_m_minas', 'v_m_atentado_bombas', 'v_m_ataque_bienes', 'v_m_sevicia', 'v_at_herido', 'v_at_sin_lesiones', 'v_at_civil_herido_combate', 'v_at_civil_herido_bomba', 'v_at_civil_minas', 'v_at_civil_ataque_bienes', 'v_amenaza', 'v_amenaza_mecanismos', 'v_amenaza_ind_col', 'v_desaparicion_forzada', 'v_desaparicion_forzada_mecanismos', 'v_tortura_fisica', 'v_tortura_fisica_mecanismos', 'v_tortura_fisica_ind_col', 'v_tortura_fisica_publico', 'v_tortura_piscologica', 'v_tortura_psicologica_mecanismos', 'v_tortura_psicologica_ind_col', 'v_tortura_psicologica_publico', 'v_vs_violacion_sexual', 'v_vs_embarazo_forzado', 'v_vs_amenaza', 'v_vs_anticoncepcion', 'v_vs_trata_personas', 'v_vs_prostitucion_forzada', 'v_vs_tortura_embarazo', 'v_vs_mutilacion', 'v_vs_enamoramiento', 'v_vs_acoso_sexual', 'v_vs_aborto_forzado', 'v_vs_obligar_presenciar', 'v_vs_obligar_realizar', 'v_vs_cambios_forzados', 'v_vs_otra_forma', 'v_vs_esclavitud', 'v_vs_desnudez_forzada', 'v_vs_maternidad_forzada', 'v_vs_cohabitacion_forzada', 'v_vs_ind_col', 'v_vs_publico', 'v_vs_multiple_responsable', 'v_vs_embarazo', 'v_vs_embarazo_nacimiento', 'v_esclavitud', 'v_esclavitud_publico', 'v_reclutamiento', 'v_reclutamiento_publico', 'v_reclutamiento_ind_col', 'v_secuestro', 'v_secuestro_ind_col', 'v_secuestro_publico', 'v_detencion', 'v_detencion_ind_col', 'v_confinamiento', 'v_confinamiento_ind_col', 'v_pillaje', 'v_extorsion', 'v_abp_civil', 'v_abp_religioso', 'v_abp_sagrado', 'v_abp_cultural', 'v_abp_peligroso', 'v_abp_medioambiente', 'v_ataque_indiscriminado', 'v_despojo', 'v_despojo_modalidad', 'v_despojo_ind_col', 'v_despojo_hectareas', 'v_despojo_recupero_tierras', 'v_despojo_recupero_derechos', 'v_desplazamiento', 'v_desplazamiento_ind_col', 'v_desplazamiento_origen_n1_codigo', 'v_desplazamiento_origen_n1_txt', 'v_desplazamiento_origen_n2_codigo', 'v_desplazamiento_origen_n2_txt', 'v_desplazamiento_origen_n3_codigo', 'v_desplazamiento_origen_n3_txt', 'v_desplazamiento_origen_codigo', 'v_desplazamiento_origen_n3_lat', 'v_desplazamiento_origen_n3_lon', 'v_desplazamiento_llegada_codigo', 'v_desplazamiento_llegada_n1_codigo', 'v_desplazamiento_llegada_n1_txt', 'v_desplazamiento_llegada_n2_codigo', 'v_desplazamiento_llegada_n2_txt', 'v_desplazamiento_llegada_n3_codigo', 'v_desplazamiento_llegada_n3_txt', 'v_desplazamiento_llegada_n3_lat', 'v_desplazamiento_llegada_n3_lon', 'v_desplazamiento_sentido', 'v_desplazamiento_retorno', 'v_desplazamiento_retorno_ind_col', 'v_exilio', 'aa_p_grupo_paramilitar', 'aa_p_ns_nr', 'aa_g_farc', 'aa_g_eln', 'aa_g_otro', 'aa_g_ns_nr', 'aa_fp_ejercito', 'aa_fp_armada', 'aa_fp_fuerza_aerea', 'aa_fp_policia', 'aa_oga_otro_grupo_armado', 'aa_oga_otro_pais', 'aa_ns_nr', 'tc_tc_politico', 'tc_tc_medios_comunicacion', 'tc_tc_social_comunitario', 'tc_tc_academico', 'tc_tc_religioso', 'tc_tc_econcomico', 'tc_tc_otros', 'tc_oae_ejecutivo_legislativo', 'tc_oae_organos_control', 'tc_oae_justicia', 'tc_oae_inteligencia', 'tc_oae_otro', 'tc_int_gobierno_extranjero', 'tc_int_empresa_transnacional', 'tc_int_otros', 'tc_otro_actor', 'creacion_fh', 'creacion_fecha', 'creacion_mes'];

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
    public static function generar_plana() {
        $inicio = Carbon::now();
        //Registrar el evento
        Log::notice("ETL de analitica-violencia: inicio del proceso");
        //Inicializar la tabla
        analitica_violencia::truncate();

        $listado = hecho::join('esclarecimiento.e_ind_fvt','e_ind_fvt.id_e_ind_fvt','=','hecho.id_e_ind_fvt')
            ->where('e_ind_fvt.id_activo',1)
            ->where('e_ind_fvt.id_subserie',config('expedientes.vi'))
            ->orderby('hecho.id_hecho')
            ->selectraw(\DB::raw('hecho.*'))
            ->get();

        $campos_dinamicos = self::listar_campos_dinamicos();

        $total_filas=0;
        $total_errores=0;
        foreach($listado as $fila) {
            //Buscar referencias
            $entrevista = entrevista_individual::find($fila->id_e_ind_fvt);
            //Crear registro
            $excel = new analitica_violencia();
            //Información del hecho
            $excel->id_hecho = $fila->id_hecho;
            $excel->id_entrevista = $fila->id_e_ind_fvt;
            $excel->codigo_entrevista = $entrevista->entrevista_codigo;
            $excel->victimas_total = $fila->cantidad_victimas;
            $excel->victimas_identificadas = $fila->rel_victima()->count();
            $excel->responsables_identificados = $fila->rel_responsable()->count();
            $cantidad_muertos=null;  //Si en violencias aparece masacre, se actualiza esta variable
            $excel->fecha_inicio = $fila->fecha_ocurrencia;
            $excel->fecha_fin = $fila->fecha_fin;
            $excel->hechos_continuan = $fila->aun_continuan == 1 ? 1 : 0;
            $sufijo = analitica_exilio_salida::calcular_campos_geo($fila->id_lugar);
            foreach($sufijo as $var=>$val) {
                $campo = "lugar_$var";
                $excel->$campo=$val;
            }
            $excel->lugar_sitio = $fila->sitio_especifico;
            $excel->lugar_zona = cat_item::describir($fila->id_lugar_tipo);
            //Detalle de violencia
            $lis_viol = $fila->rel_violencia;
            foreach($lis_viol as $violencia) {
                $tipo = $violencia->rel_id_subtipo_violencia;

                switch ($tipo->codigo) {
                    case '0501': //Ejecucion extra
                        $excel->v_m_homicidio =1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos == 0 ? 1 : $cantidad_muertos;
                        break;
                    case '0502': //Masacre
                        $excel->v_m_masacre =1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos < $violencia->cantidad_muertos ? $violencia->cantidad_muertos : $cantidad_muertos;
                        break;
                    case '0503':
                        $excel->v_m_combates = 1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos == 0 ? 1 : $cantidad_muertos;
                        break;
                    case '0504':
                        $excel->v_m_atentado_bombas = 1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos == 0 ? 1 : $cantidad_muertos;
                        break;
                    case '0505':
                        $excel->v_m_minas = 1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos == 0 ? 1 : $cantidad_muertos;
                        break;
                    case '0506':
                        $excel->v_m_ataque_bienes = 1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos == 0 ? 1 : $cantidad_muertos;
                        break;
                    case '0507':
                        $excel->v_m_sevicia = 1;
                        $excel->v_muerte_homicidio=1;
                        $cantidad_muertos = $cantidad_muertos == 0 ? 1 : $cantidad_muertos;
                        break;
                    case '0601':
                        $excel->v_at_herido = 1;
                        $excel->v_atentado = 1;
                        break;
                    case '0602':
                        $excel->v_at_sin_lesiones = 1;
                        $excel->v_atentado = 1;
                        break;
                    case '0603':
                        $excel->v_at_civil_herido_combate = 1;
                        $excel->v_atentado = 1;
                        break;
                    case '0604':
                        $excel->v_at_civil_herido_bomba = 1;
                        $excel->v_atentado = 1;
                        break;
                    case '0605':
                        $excel->v_at_civil_minas = 1;
                        $excel->v_atentado = 1;
                        break;
                    case '0606':
                        $excel->v_at_civil_ataque_bienes = 1;
                        $excel->v_atentado = 1;
                        break;
                    case '0701':
                        $excel->v_amenaza = 1;
                        $viol_mecanismo=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $viol_mecanismo[$mecanismo->id_mecanismo]=cat_item::describir($mecanismo->id_mecanismo);
                        }
                        //$excel->v_amenaza_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_amenaza_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        //Mecanimsos
                        $otros=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $cat_item = cat_item::find($mecanismo->id_mecanismo);
                            if(strlen($cat_item->otro) >0) {
                                $campo=$cat_item->otro;

                                if(in_array($campo, $campos_dinamicos)) {
                                    $excel->$campo = 1;
                                }
                                else {
                                    $otros[]=$cat_item->descripcion;
                                }
                            }
                            else {
                                $otros[]=$cat_item->descripcion;
                            }
                        }
                        //$excel->v_tortura_fisica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_a_m_otros = implode(";",$otros);
                        break;
                    case '0801':
                        $excel->v_desaparicion_forzada = 1;
                        $viol_mecanismo=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $viol_mecanismo[$mecanismo->id_mecanismo]=cat_item::describir($mecanismo->id_mecanismo);
                        }
                        //$excel->v_desaparicion_forzada_mecanismos=json_encode($viol_mecanismo);
                        //Mecanimsos
                        $otros=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $cat_item = cat_item::find($mecanismo->id_mecanismo);
                            if(strlen($cat_item->otro) >0) {
                                $campo=$cat_item->otro;

                                if(in_array($campo, $campos_dinamicos)) {
                                    $excel->$campo = 1;
                                }
                                else {
                                    $otros[]=$cat_item->descripcion;
                                }
                            }
                            else {
                                $otros[]=$cat_item->descripcion;
                            }
                        }
                        //$excel->v_tortura_fisica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_d_m_otros = implode(";",$otros);
                        break;
                    case '0901':
                        $excel->v_tortura_fisica = 1;
                        $excel->v_tortura = 1;
                        $viol_mecanismo=array();
                        $otros=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $cat_item = cat_item::find($mecanismo->id_mecanismo);
                            if(strlen($cat_item->otro) >0) {
                                $campo=$cat_item->otro;

                                if(in_array($campo, $campos_dinamicos)) {
                                    $excel->$campo = 1;
                                }
                                else {
                                    $otros[]=$cat_item->descripcion;
                                }
                            }
                            else {
                                $otros[]=$cat_item->descripcion;
                            }
                        }
                        //$excel->v_tortura_fisica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_t_m_fisica_otros = implode(";",$otros);
                        $excel->v_tortura_fisica_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_tortura_fisica_publico = criterio_fijo::describir(2,$violencia->id_frente_otros);
                        break;
                    case '0902':
                        $excel->v_tortura_psicologica = 1;
                        $excel->v_tortura = 1;
                        $viol_mecanismo=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $viol_mecanismo[$mecanismo->id_mecanismo]=cat_item::describir($mecanismo->id_mecanismo);
                        }
                        //$excel->v_tortura_psicologica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_tortura_psicologica_ind_col= cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_tortura_psicologica_publico = criterio_fijo::describir(2,$violencia->id_frente_otros);
                        //Mecanismos
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $cat_item = cat_item::find($mecanismo->id_mecanismo);
                            if(strlen($cat_item->otro) >0) {
                                $campo=$cat_item->otro;

                                if(in_array($campo, $campos_dinamicos)) {
                                    $excel->$campo = 1;
                                }
                                else {
                                    $otros[]=$cat_item->descripcion;
                                }
                            }
                            else {
                                $otros[]=$cat_item->descripcion;
                            }
                        }
                        //$excel->v_tortura_fisica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_t_m_psicologica_otros = implode(";",$otros);
                        break;
                    case '1001':
                        $excel->v_vs_violacion_sexual = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_violacion_sexual_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_violacion_sexual_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_violacion_sexual_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_violacion_sexual_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_violacion_sexual_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1002':
                        $excel->v_vs_embarazo_forzado = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_embarazo_forzado_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_embarazo_forzado_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_embarazo_forzado_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_embarazo_forzado_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_embarazo_forzado_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1003':
                        $excel->v_vs_amenaza = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_amenaza_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_amenaza_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_amenaza_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_amenaza_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_amenaza_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1004':
                        $excel->v_vs_anticoncepcion= 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_anticoncepcion_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_anticoncepcion_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_anticoncepcion_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_anticoncepcion_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_anticoncepcion_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1005':
                        $excel->v_vs_trata_personas = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_trata_personas_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_trata_personas_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_trata_personas_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_trata_personas_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_trata_personas_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1006':
                        $excel->v_vs_prostitucion_forzada = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_prostitucion_forzada_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_prostitucion_forzada_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_prostitucion_forzada_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_prostitucion_forzada_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_prostitucion_forzada_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1007':
                        $excel->v_vs_tortura_embarazo = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_tortura_embarazo_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_tortura_embarazo_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_tortura_embarazo_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_tortura_embarazo_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_tortura_embarazo_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1008':
                        $excel->v_vs_mutilacion = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_mutilacion_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_mutilacion_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_mutilacion_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_mutilacion_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_mutilacion_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1009':
                        $excel->v_vs_enamoramiento = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_enamoramiento_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_enamoramiento_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_enamoramiento_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_enamoramiento_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_enamoramiento_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1010':
                        $excel->v_vs_acoso_sexual = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_acoso_sexual_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_acoso_sexual_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_acoso_sexual_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_acoso_sexual_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_acoso_sexual_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1011':
                        $excel->v_vs_aborto_forzado = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_aborto_forzado_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_aborto_forzado_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_aborto_forzado_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_aborto_forzado_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_aborto_forzado_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1012':
                        $excel->v_vs_obligar_presenciar = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_obligar_presenciar_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_obligar_presenciar_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_obligar_presenciar_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_obligar_presenciar_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_obligar_presenciar_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1013':
                        $excel->v_vs_obligar_realizar = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_obligar_realizar_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_obligar_realizar_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_obligar_realizar_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_obligar_realizar_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_obligar_realizar_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1014':
                        $excel->v_vs_cambios_forzados = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_cambios_forzados_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_cambios_forzados_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_cambios_forzados_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_cambios_forzados_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_cambios_forzados_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1015':
                        $excel->v_vs_otra_forma = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_otra_forma_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_otra_forma_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_otra_forma_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_otra_forma_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_otra_forma_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1016':
                        $excel->v_vs_esclavitud = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_esclavitud_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_esclavitud_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_esclavitud_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_esclavitud_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_esclavitud_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1017':
                        $excel->v_vs_desnudez_forzada = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_desnudez_forzada_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_desnudez_forzada_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_desnudez_forzada_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_desnudez_forzada_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_desnudez_forzada_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1018':
                        $excel->v_vs_maternidad_forzada = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_maternidad_forzada_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_maternidad_forzada_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_maternidad_forzada_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_maternidad_forzada_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_maternidad_forzada_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1019':
                        $excel->v_vs_cohabitacion_forzada = 1;
                        $excel->v_violencia_sexual = 1;
                        $excel->v_vs_cohabitacion_forzada_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $excel->v_vs_cohabitacion_forzada_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_vs_cohabitacion_forzada_multiple_responsable = criterio_fijo::describir(2,$violencia->id_cometido_varios);
                        $excel->v_vs_cohabitacion_forzada_embarazo = criterio_fijo::describir(2,$violencia->id_hubo_embarazo);
                        $excel->v_vs_cohabitacion_forzada_embarazo_nacimiento = criterio_fijo::describir(2,$violencia->id_hubo_nacimiento);
                        break;
                    case '1101':
                        $excel->v_esclavitud_no_sexual = 1;
                        $excel->v_esclavitud_no_sexual_publico= criterio_fijo::describir(2,$violencia->id_frente_otros);
                        break;
                    case '1201':
                        $excel->v_reclutamiento = 1;
                        $excel->v_reclutamiento_publico = criterio_fijo::describir(2,$violencia->id_frente_otros);
                        $excel->v_reclutamiento_ind_col = cat_item::describir($violencia->id_individual_colectiva);
                        $viol_mecanismo=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $viol_mecanismo[$mecanismo->id_mecanismo]=cat_item::describir($mecanismo->id_mecanismo);
                        }
                        //$excel->v_reclutamiento_mecanismos=json_encode($viol_mecanismo);
                        //Mecanimsos
                        $otros=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $cat_item = cat_item::find($mecanismo->id_mecanismo);
                            if(strlen($cat_item->otro) >0) {
                                $campo=$cat_item->otro;

                                if(in_array($campo, $campos_dinamicos)) {
                                    $excel->$campo = 1;
                                }
                                else {
                                    $otros[]=$cat_item->descripcion;
                                }
                            }
                            else {
                                $otros[]=$cat_item->descripcion;
                            }
                        }
                        //$excel->v_tortura_fisica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_r_m_otros = implode(";",$otros);
                        break;
                    case '1301':
                        $excel->v_detencion = 1;
                        $excel->v_detencion_ind_col = cat_item::describir($violencia->id_ind_fam_col);
                        break;
                    case '1401':
                        $excel->v_secuestro = 1;
                        $excel->v_secuestro_ind_col = cat_item::describir($violencia->id_ind_fam_col);
                        $excel->v_secuestro_publico = criterio_fijo::describir(2,$violencia->id_frente_otros);
                        break;
                    case '1501':
                        $excel->v_confinamiento = 1;
                        $excel->v_confinamiento_ind_col = cat_item::describir($violencia->id_ind_fam_col);
                        break;
                    case '1601':
                        $excel->v_pillaje = 1;
                        break;
                    case '1701':
                        $excel->v_extorsion = 1;
                        break;
                    case '1801':
                        $excel->v_abp_civil = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1802':
                        $excel->v_abp_sanitario = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1803':
                        $excel->v_abp_religioso = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1804':
                        $excel->v_abp_sagrado = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1805':
                        $excel->v_abp_cultural = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1806':
                        $excel->v_abp_peligroso = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1807':
                        $excel->v_abp_medioambiente = 1;
                        $excel->v_ataque_bien_protegido = 1;
                        break;
                    case '1901':
                        $excel->v_ataque_indiscriminado = 1;
                        break;
                    case '2001':
                        $excel->v_despojo = 1;
                        $excel->v_despojo_ind_col = cat_item::describir($violencia->id_ind_fam_col);
                        $viol_mecanismo=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $viol_mecanismo[$mecanismo->id_mecanismo]=cat_item::describir($mecanismo->id_mecanismo);
                        }
                        //$excel->v_despojo_modalidad=json_encode($viol_mecanismo);
                        $excel->v_despojo_hectareas = $violencia->despojo_hectareas;
                        $excel->v_despojo_recupero_tierras = criterio_fijo::describir(10,$violencia->despojo_recupero_tierras);
                        $excel->v_despojo_recupero_derechos = criterio_fijo::describir(2,$violencia->despojo_recupero_derechos);
                        //Mecanimsos
                        $otros=array();
                        foreach($violencia->rel_mecanismo as $mecanismo) {
                            $cat_item = cat_item::find($mecanismo->id_mecanismo);
                            if(strlen($cat_item->otro) >0) {
                                $campo=$cat_item->otro;

                                if(in_array($campo, $campos_dinamicos)) {
                                    $excel->$campo = 1;
                                }
                                else {
                                    $otros[]=$cat_item->descripcion;
                                }
                            }
                            else {
                                $otros[]=$cat_item->descripcion;
                            }
                        }
                        //$excel->v_tortura_fisica_mecanismos=json_encode($viol_mecanismo);
                        $excel->v_dp_m_otros = implode(";",$otros);
                        break;
                    case '2101':
                        $excel->v_desplazamiento = 1;
                        $excel->v_desplazamiento_ind_col = cat_item::describir($violencia->id_ind_fam_col);
                        $sufijo = analitica_exilio_salida::calcular_campos_geo($violencia->id_lugar_salida);
                        foreach($sufijo as $var=>$val) {
                            $campo = "v_desplazamiento_origen_$var";
                            $excel->$campo=$val;
                        }
                        $sufijo = analitica_exilio_salida::calcular_campos_geo($violencia->id_lugar_llegada);
                        foreach($sufijo as $var=>$val) {
                            $campo = "v_desplazamiento_llegada_$var";
                            $excel->$campo=$val;
                        }
                        $excel->v_desplazamiento_sentido = cat_item::describir($violencia->id_sentido_desplazamiento);
                        $excel->v_desplazamiento_retorno = criterio_fijo::describir(2,$violencia->id_tuvo_retorno);
                        $excel->v_desplazamiento_retorno_ind_col = cat_item::describir($violencia->id_tuvo_retorno_tipo);
                        break;
                    case '2201':
                        $excel->v_exilio = 1;
                        break;
                }
            }
            //Actualizar la cantidad de muertos con el valor mas alto
            $excel->cantidad_muertos = $cantidad_muertos;
            //Detalle de responsables
            $lis_res = $fila->rel_responsabilidad;
            foreach($lis_res as $responsabilidad) {
                if($responsabilidad->aa_id_subtipo >0 ) {
                    $grupo = tipo_aa::find($responsabilidad->aa_id_subtipo);
                    $detalle_aa = "Cual grupo: $responsabilidad->aa_nombre_grupo.  Bloque: $responsabilidad->aa_bloque, Frente: $responsabilidad->aa_frente, Unidad: $responsabilidad->aa_unidad. ";
                    if(strlen($responsabilidad->aa_otro_cual)>0) {
                        $detalle_aa.= " Otro, cual: ".$responsabilidad->aa_otro_cual;
                    }

                    switch ($grupo->codigo) {
                        case '0101':
                            $excel->aa_p_grupo_paramilitar = 1;
                            $excel->aa_p_grupo_paramilitar_detalle = $detalle_aa;
                            break;
                        case '0199':
                            $excel->aa_p_ns_nr = 1;
                            //$excel->aa_p_ns_nr_detalle = $responsabilidad->aa_nombre_grupo;
                            break;
                        case '0201':
                            $excel->aa_g_farc = 1;
                            $excel->aa_g_farc_detalle = $detalle_aa;
                            break;
                        case '0202':
                            $excel->aa_g_eln = 1;
                            $excel->aa_g_eln_detalle = $detalle_aa;
                            break;
                        case '0203':
                            $excel->aa_g_otro = 1;
                            $excel->aa_g_otro_detalle = $detalle_aa;
                            break;
                        case '0299':
                            $excel->aa_g_ns_nr = 1;
                            $excel->aa_g_ns_nr_detalle =$responsabilidad->aa_otro_cual;
                            break;
                        case '0301':
                            $excel->aa_fp_ejercito = 1;
                            $excel->aa_fp_ejercito_detalle = "Batallón/brigada/unidad: $responsabilidad->aa_unidad";
                            break;
                        case '0302':
                            $excel->aa_fp_armada = 1;
                            $excel->aa_fp_armada_detalle = "Batallón/brigada/unidad: $responsabilidad->aa_unidad";
                            break;
                        case '0303':
                            $excel->aa_fp_fuerza_aerea = 1;
                            $excel->aa_fp_fuerza_aerea_detalle ="Batallón/brigada/unidad: $responsabilidad->aa_unidad";
                            break;
                        case '0304':
                            $excel->aa_fp_policia = 1;
                            $excel->aa_fp_policia_detalle = "Batallón/brigada/unidad: $responsabilidad->aa_unidad";
                            break;
                        case '0401':
                            $excel->aa_oga_otro_grupo_armado = 1;
                            $excel->aa_oga_otro_grupo_armado_detalle = $responsabilidad->aa_otro_cual;
                            break;
                        case '0402':
                            $excel->aa_oga_otro_pais = 1;
                            $excel->aa_oga_otro_pais_detalle = $responsabilidad->aa_unidad;
                            break;
                        case '0501':
                            $excel->aa_ns_nr = 1;
                            $excel->aa_ns_nr_detalle = $responsabilidad->aa_unidad;
                            break;
                    }
                }
                if($responsabilidad->tc_id_subtipo >0 ) {
                    $grupo = tipo_tc::find($responsabilidad->tc_id_subtipo);
                    switch ($grupo->codigo) {
                        case '0101':
                            $excel->tc_tc_politico = 1;
                            $excel->tc_tc_politico_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0102':
                            $excel->tc_tc_medios_comunicacion = 1;
                            $excel->tc_tc_medios_comunicacion_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0103':
                            $excel->tc_tc_social_comunitario = 1;
                            $excel->tc_tc_social_comunitario_detalle = $responsabilidad->tc_detalle;
                            0104;
                        case '0104':
                            $excel->tc_tc_academico = 1;
                            $excel->tc_tc_academico_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0105':
                            $excel->tc_tc_religioso = 1;
                            $excel->tc_tc_religioso_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0106':
                            $excel->tc_tc_econcomico = 1;
                            $excel->tc_tc_econcomico_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0107':
                            $excel->tc_tc_otros = 1;
                            $excel->tc_tc_otros_detalle = "Detalle: ".$responsabilidad->tc_detalle.". Cual: ".$responsabilidad->tc_otro_cual;
                            break;
                        case '0201':
                            $excel->tc_oae_ejecutivo_legislativo = 1;
                            $excel->tc_oae_ejecutivo_legislativo_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0202':
                            $excel->tc_oae_organos_control = 1;
                            $excel->tc_oae_organos_control_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0203':
                            $excel->tc_oae_justicia = 1;
                            $excel->tc_oae_justicia_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0204':
                            $excel->tc_oae_inteligencia = 1;
                            $excel->tc_oae_inteligencia_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0205':
                            $excel->tc_oae_otro = 1;
                            $excel->tc_oae_otro_detalle = "Detalle: ".$responsabilidad->tc_detalle.". Cual: ".$responsabilidad->tc_otro_cual;
                            break;
                        case '0301':
                            $excel->tc_int_gobierno_extranjero = 1;
                            $excel->tc_int_gobierno_extranjero_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0302':
                            $excel->tc_int_empresa_transnacional = 1;
                            $excel->tc_int_empresa_transnacional_detalle = $responsabilidad->tc_detalle;
                            break;
                        case '0303':
                            $excel->tc_int_otros = 1;
                            $excel->tc_int_otros_detalle = "Detalle: ".$responsabilidad->tc_detalle.". Cual: ".$responsabilidad->tc_otro_cual;
                            break;
                        case '0401':
                            $excel->tc_otro_actor = 1;
                            $excel->tc_otro_actor_detalle = $responsabilidad->otro_actor_cual;
                            break;
                    }
                }
            }
            if(!is_null($fila->insert_fh)) {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',$fila->insert_fh);
                $excel->creacion_fh = $fecha->format('Y-m-d H:i:s');
                $excel->creacion_fecha = $fecha->format('Y-m-d');
                $excel->creacion_mes = $fecha->format('Y-m');
            }
            else {
                $fecha = Carbon::createFromFormat('Y-m-d H:i:s',"2019-01-01 00:00:00");
                $excel->creacion_fh = $fecha->format('Y-m-d H:i:s');
                $excel->creacion_fecha = $fecha->format('Y-m-d');
                $excel->creacion_mes = $fecha->format('Y-m');
            }

            //Persistir a la BD
            try {
                $excel->save();
                $total_filas++;
            }
            catch(\Exception $e) {
                $total_errores++;
                Log::debug("Error en generar registro de analitica-violencia: ".$e->getMessage());
            }
        }
        //Registrar el fin del proceso
        $fin = Carbon::now();
        $respuesta = new \stdClass();
        $respuesta->inicio = $inicio;
        $respuesta->fin = $fin;
        $respuesta->duracion = $fin->diffForHumans($inicio);
        $respuesta->total_errores = $total_errores;
        $respuesta->total_filas = $total_filas;

        Log::info("ETL de analitica-violencia: fin del proceso, $total_filas filas generadas. Tiempo: $respuesta->duracion.");
        if($total_errores>0) {
            Log::error("ETL de analitica-violencia finalizada con  $total_errores errores");
        }
        return $respuesta;

    }

    //Campos definidos en cat_item. utilizados para especificar mecanismo de tortura, de amenaza, etc.
    public static function listar_campos_dinamicos() {
        return cat_item::wherein('id_cat',[120,121,122,123,124,125])->wherenotnull('otro')->pluck('otro')->toArray();
    }


    /**
     * Encontrar las combinaciones a nivel de víctima
     */
    public static function concurrencia_victima() {


        $primero = \DB::table('analitica.concurrencia_victima')->first();

        $campos = array();
        foreach($primero as $var=>$val) {
            if ($var<>'id_victima') {
                $campos[]=$var;
            }
        }

        //Armar la matriz
        $matriz=array();
        $tabla = array();
        foreach($campos as $x) {
            foreach($campos as $y) {
                if($x <> $y) {
                    $sql = "select count(1) from analitica.concurrencia_victima where $x=1 and $y=1";
                    $res = \DB::select($sql);
                    $nodo =  array();
                    $nodo['x']=$x;
                    $nodo['y']=$y;
                    $nodo['conteo']=$res[0]->count;
                    $matriz[] = $nodo;
                    $tabla[$x][$y]=$nodo['conteo'];
                }

            }
        }

        //dd($matriz);
        $keys = array_column($matriz, 'conteo');
        array_multisort($keys, SORT_DESC, $matriz);

        return array('pares'=>$matriz, 'tabla'=>$tabla, 'campos'=>$campos);

    }


    //Concurrencia de violencia a nivel de entrevista
    public static function concurrencia_entrevista() {


        $primero = \DB::table('analitica.concurrencia_entrevista')->first();

        $campos = array();
        foreach($primero as $var=>$val) {
            if ($var<>'codigo_entrevista') {
                $campos[]=$var;
            }
        }

        //Armar la matriz
        $matriz=array();
        $tabla = array();
        foreach($campos as $x) {
            foreach($campos as $y) {
                if($x <> $y) {
                    $sql = "select count(1) from analitica.concurrencia_entrevista where $x=1 and $y=1";
                    $res = \DB::select($sql);
                    $nodo =  array();
                    $nodo['x']=$x;
                    $nodo['y']=$y;
                    $nodo['conteo']=$res[0]->count;
                    $matriz[] = $nodo;
                    $tabla[$x][$y]=$nodo['conteo'];
                }

            }
        }

        //dd($matriz);
        $keys = array_column($matriz, 'conteo');
        array_multisort($keys, SORT_DESC, $matriz);

        return array('pares'=>$matriz, 'tabla'=>$tabla, 'campos'=>$campos);

    }


    //concurrencia de responsabilidad a nivel de victima
    public static function concurrencia_responsabilidad_victima() {


        $primero = \DB::table('analitica.concurrencia_responsabilidad_victima')->first();

        $campos = array();
        foreach($primero as $var=>$val) {
            if ($var<>'id_victima') {
                $campos[]=$var;
            }
        }

        //Armar la matriz
        $matriz=array();
        $tabla = array();
        foreach($campos as $x) {
            foreach($campos as $y) {
                if($x <> $y) {
                    $sql = "select count(1) from analitica.concurrencia_responsabilidad_victima where $x=1 and $y=1";
                    $res = \DB::select($sql);
                    $nodo =  array();
                    $nodo['x']=$x;
                    $nodo['y']=$y;
                    $nodo['conteo']=$res[0]->count;
                    $matriz[] = $nodo;
                    $tabla[$x][$y]=$nodo['conteo'];
                }

            }
        }

        //dd($matriz);
        $keys = array_column($matriz, 'conteo');
        array_multisort($keys, SORT_DESC, $matriz);

        return array('pares'=>$matriz, 'tabla'=>$tabla, 'campos'=>$campos);

    }



}
