<?php
/*
 * Igual que entrevista_export, pero acepta un arreglo para delimitar cuales se exportan
 */

namespace App\Exports;

use App\Models\excel_entrevista;
use App\Models\nvivo_clasificador;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;


class entrevista_resultadosExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    var $columnas_ocultas=array();
    protected $arreglo;


    public function __construct($arreglo, $anonimo=false) {
        $this->arreglo=$arreglo;
        if(\Gate::allows('nivel-1')) {
            $this->columnas_ocultas=[
                'macroterritorio_id',
                'territorio_id',
                'grupo_id',
                'entrevista_lugar_n1_codigo',
                'entrevista_lugar_n2_codigo',
                'entrevista_lugar_n3_codigo',
                'hechos_lugar_n1_codigo',
                'hechos_lugar_n2_codigo',
                'hechos_lugar_n3_codigo',
                'id_entrevistador',
                'transcripcion_html',
                'etiquetado_json',
            ];
        }
        else {
            $this->columnas_ocultas=[
                'macroterritorio_id',
                'territorio_id',
                'grupo_id',
                'entrevista_lugar_n1_codigo',
                'entrevista_lugar_n2_codigo',
                'entrevista_lugar_n3_codigo',
                'hechos_lugar_n1_codigo',
                'hechos_lugar_n2_codigo',
                'hechos_lugar_n3_codigo',
                'id_entrevistador',
                'transcripcion_html',
                'etiquetado_json',
            ];
        }
        if($anonimo) {
            $this->columnas_ocultas=[
                'macroterritorio_id',
                'territorio_id',
                'grupo_id',
                'entrevista_lugar_n1_codigo',
                'entrevista_lugar_n2_codigo',
                'entrevista_lugar_n3_codigo',
                'hechos_lugar_n1_codigo',
                'hechos_lugar_n2_codigo',
                'hechos_lugar_n3_codigo',
                'id_entrevistador',
                'transcripcion_html',
                'etiquetado_json',
                //
                'id_e_ind_fvt',
                'correlativo',
                'es_virtual',
                'codigo_entrevistador',
                'grupo_id',
                'grupo_txt',
                'tiempo_entrevista',
                'entrevista_lugar_n3_codigo',
                'entrevista_lugar_n3_txt',
                'titulo',
                'hechos_lugar_n3_codigo',
                'hechos_lugar_n3_txt',
                'hechos_del',
                'hechos_al',
                'anotaciones',
                'es_prioritario',
                'prioritario_tema',
                'interes_etnico',
                'remitido',
                'transcripcion_fecha',
                'transcripcion_fecha_a',
                'transcripcion_fecha_m',
                'etiquetado_fecha',
                'etiquetado_fecha_a',
                'etiquetado_fecha_m',
                'dinamica_1',
                'dinamica_2',
                'dinamica_3',
                'a_consentimiento',
                'a_audio',
                'a_ficha_corta',
                'a_ficha_larga',
                'a_otros',
                'a_relatoria',
                'a_transcripcion_preliminar',
                'a_transcripcion_final',
                'a_etiquetado',
                'a_retroalimentacion',
                'a_casos_informes',
                'a_otros',
                'a_autorizaciones',
                'a_referencias',
                'a_comunicacion_oficial',
                'a_plan_trabajo',
                'a_valoracion',
                'a_certificaciones',
                'a_certificacion_inicial',
                'a_certificacion_final',
                'a_evaluacion_vulnerabilidad',
                'a_evaluacion_seguridad',
                'a_retroalimentacion',
                'a_otranscribe',

                'entrevista_lat',
                'entrevista_lon',
                'hechos_lat',
                'hechos_lon',
                'created_at',
                'created_at_month',
                'updated_at',
                'sintesis_relato',
                'ficha_priorizar_entrevista',
                'ficha_priorizar_entrevista_asuntos',
                'ficha_contiene_patrones',
                'ficha_contiene_patrones_cuales',
                'ci_conceder_entrevista',
                'ci_grabar_audio',
                'ci_elaborar_informe',
                'ci_tratamiento_datos_analizar',
                'ci_tratamiento_datos_analizar_sensible',
                'ci_tratamiento_datos_utilizar',
                'ci_tratamiento_datos_utilizar_sensible',
                'ci_tratamiento_datos_publicar',
                'cantidad_fichas_exilio',
                'prioridad_fluidez',
                'prioridad_d_hecho',
                'prioridad_d_contexto',
                'prioridad_d_impacto',
                'prioridad_d_justicia',
                'prioridad_cierre',
                'prioridad_ponderacion',
                'prioridad_ahora_entiendo',
                'prioridad_cambio_perspectiva',
                'procesamiento_requisitos_minimos',
                'procesamiento_cerrado',
                'interes_exilio',
            ];
        }
    }

    public function collection()
    {
        //dd($this->arreglo);
        //excel_entrevista::generar_plana();
        $listado = excel_entrevista::selectRaw(\DB::raw('excel_entrevista_fvt.*'))->wherein('id_e_ind_fvt',$this->arreglo)->orderby('id_e_ind_fvt')->get();

        //Ocultar columnas
        $listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }

    public function headings(): array
    {
        $encabezado_largo=array();
        $encabezado_largo['id_e_ind_fvt']='identificador';
        $encabezado_largo['tipo_entrevista']='Tipo de entrevista';
        $encabezado_largo['correlativo']='Correlativo';
        $encabezado_largo['clasificacion']='Clasificación';
        $encabezado_largo['codigo_entrevista']='Código';
        $encabezado_largo['macroterritorio_txt']='Macroterritorio';
        $encabezado_largo['territorio_txt']='Territorio';
        $encabezado_largo['grupo_txt']='Entrevistador - Grupo';
        $encabezado_largo['entrevista_fecha']='Fecha de la entrevista';
        $encabezado_largo['tiempo_entrevista']='Duración de la entrevista';
        $encabezado_largo['entrevista_lugar_n1_txt']='Lugar de la entrevista - Departamento';
        $encabezado_largo['entrevista_lugar_n2_txt']='Lugar de la entrevista - Municipio';
        $encabezado_largo['entrevista_lugar_n3_txt']='Lugar de la entrevista - Vereda';
        $encabezado_largo['titulo']='Título de la entrevista';
        $encabezado_largo['hechos_lugar_n1_txt']='Lugar de los hechos -Departamento';
        $encabezado_largo['hechos_lugar_n2_txt']='Lugar de los hechos - Municipio';
        $encabezado_largo['hechos_lugar_n3_txt']='Lugar de los hechos - Vereda';
        $encabezado_largo['hechos_del']='Fecha de los hechos - desde';
        $encabezado_largo['hechos_al']='Fecha de los hechos - hasta';
        $encabezado_largo['anotaciones']='Anotaciones';
        $encabezado_largo['es_prioritario']='Contiene temas poco documentados';
        $encabezado_largo['prioritario_tema']='Temas poco documentados que contiene';
        $encabezado_largo['sector_victima']='Sector con el que se asocia la víctima';
        $encabezado_largo['interes_etnico']='Es de interés étnico';
        $encabezado_largo['remitido']='Es un entrevistado remitido';
        $encabezado_largo['transcrita']='Entrevista transcrita';
        $encabezado_largo['transcripcion_fecha']='Fecha de transcripción';
        $encabezado_largo['transcripcion_fecha_a']='Fecha de transcripción - año';
        $encabezado_largo['transcripcion_fecha_m']='Fecha de transcripción - mes';
        $encabezado_largo['etiquetada']='Entrevista etiquetada';
        $encabezado_largo['etiquetado_fecha']='Fecha de etiquetado';
        $encabezado_largo['etiquetado_fecha_a']='Fecha de etiquetado - año';
        $encabezado_largo['etiquetado_fecha_m']='Fecha de etiquetado - mes';
        $encabezado_largo['aa_paramilitar']='AA: paramilitar';
        $encabezado_largo['aa_guerrilla']='AA: guerrilla';
        $encabezado_largo['aa_fuerza_publica']='AA: fuerza pública';
        $encabezado_largo['aa_terceros_civiles']='AA: terceros civiles';
        $encabezado_largo['aa_otro_grupo_armado']='AA: otro grupo armado';
        $encabezado_largo['aa_otro_agente_estado']='AA: otro agente del estado';
        $encabezado_largo['aa_otro_actor']='AA: otro actor armado';
        $encabezado_largo['aa_ns_nr']='AA: no sabe / no responde';
        $encabezado_largo['aa_internacional']='AA: actor internacional';
        $encabezado_largo['viol_homicidio']='Violencia: homicidio';
        $encabezado_largo['viol_atentado_vida']='Violencia: atentado a la vida';
        $encabezado_largo['viol_amenaza_vida']='Violencia: amenaza a la vida';
        $encabezado_largo['viol_desaparicion_f']='Violencia: desaparición forzada';
        $encabezado_largo['viol_tortura']='Violencia: tortura';
        $encabezado_largo['viol_violencia_sexual']='Violencia: violencia sexual';
        $encabezado_largo['viol_esclavitud']='Violencia: esclavitud';
        $encabezado_largo['viol_reclutamiento']='Violencia: reclutamiento forzado';
        $encabezado_largo['viol_detencion_arbitraria']='Violencia: detención arbitraria';
        $encabezado_largo['viol_secuestro']='Violencia: secuestro';
        $encabezado_largo['viol_confinamiento']='Violencia: confinamiento';
        $encabezado_largo['viol_pillaje']='Violencia: pillaje';
        $encabezado_largo['viol_extorsion']='Violencia: extorsión';
        $encabezado_largo['viol_ataque_bien_protegido']='Violencia: ataque a bien protegido';
        $encabezado_largo['viol_ataque_indiscriminado']='Violencia: ataque indiscriminado';
        $encabezado_largo['viol_despojo_tierras']='Violencia: despojo de tierras';
        $encabezado_largo['viol_desplazamiento_forzado']='Violencia: desplazamiento forzado';
        $encabezado_largo['viol_exilio']='Violencia: exilio';
        $encabezado_largo['i_objetivo_esclarecimiento']='Interés para: esclarecimiento';
        $encabezado_largo['i_objetivo_reconocimiento']='Interés para: reconocimiento';
        $encabezado_largo['i_objetivo_convivencia']='Interés para: convivencia';
        $encabezado_largo['i_objetivo_no_repeticion']='Interés para: no repetición';
        $encabezado_largo['i_enfoque_genero']='Interés para: enfoque de género';
        $encabezado_largo['i_enfoque_psicosocial']='Interés para: psicosocial';
        $encabezado_largo['i_enfoque_curso_vida']='Interés para: curso de vida';
        $encabezado_largo['i_direccion_investigacion']='Interés para: dirección de investigación';
        $encabezado_largo['i_direccion_territorios']='Interés para: dirección de territorios';
        $encabezado_largo['i_direccion_etnica']='Interés para: dirección étnica';
        $encabezado_largo['i_comisionados']='Interés para: comisionados';
        $encabezado_largo['i_estrategia_arte']='Interés para: estrategia - arte';
        $encabezado_largo['i_estrategia_comunicacion']='Interés para: estrategia - comunicación';
        $encabezado_largo['i_estrategia_participacion']='Interés para: estrategia - participación';
        $encabezado_largo['i_estrategia_pedagogia']='Interés para: estrategia - pedagogía';
        $encabezado_largo['i_grupo_acceso_informacion']='Interés para: grupo de acceso a la información';
        $encabezado_largo['i_presidencia']='Interés para: presidencia';
        $encabezado_largo['i_otra']='Interés para: otros';
        $encabezado_largo['i_enlace']='Interés para: enlace institucional';
        $encabezado_largo['i_sistema_informacion']='Interés para: SIM';
        $encabezado_largo['ia_pueblo_etnico']='Interés para el área: pueblos étnicos';
        $encabezado_largo['ia_dialogo_social']='Interés para el área: diálogo social';
        $encabezado_largo['ia_ds_o_convivencia']='Interés para el área: diálogo social - convivencia';
        $encabezado_largo['ia_ds_o_reconocimiento']='Interés para el área: diálogo social - reconocimiento';
        $encabezado_largo['ia_ds_o_no_repeticion']='Interés para el área: diálogo social - no repetición';
        $encabezado_largo['ia_genero']='Interés para el área: género';
        $encabezado_largo['ia_enfoque_ps']='Interés para el área: enfoque psicosocial';
        $encabezado_largo['ia_curso_vida']='Interés para el área: curso de vida';
        $encabezado_largo['nucleo_01']='Interés para el núcleo 01';
        $encabezado_largo['nucleo_02']='Interés para el núcleo 02';
        $encabezado_largo['nucleo_03']='Interés para el núcleo 03';
        $encabezado_largo['nucleo_04']='Interés para el núcleo 04';
        $encabezado_largo['nucleo_05']='Interés para el núcleo 05';
        $encabezado_largo['nucleo_06']='Interés para el núcleo 06';
        $encabezado_largo['nucleo_07']='Interés para el núcleo 07';
        $encabezado_largo['nucleo_08']='Interés para el núcleo 08';
        $encabezado_largo['nucleo_09']='Interés para el núcleo 09';
        $encabezado_largo['nucleo_10']='Interés para el núcleo 10';
        $encabezado_largo['mandato_01']='Coincide con el mandato 01';
        $encabezado_largo['mandato_02']='Coincide con el mandato 02';
        $encabezado_largo['mandato_03']='Coincide con el mandato 03';
        $encabezado_largo['mandato_04']='Coincide con el mandato 04';
        $encabezado_largo['mandato_05']='Coincide con el mandato 05';
        $encabezado_largo['mandato_06']='Coincide con el mandato 06';
        $encabezado_largo['mandato_07']='Coincide con el mandato 07';
        $encabezado_largo['mandato_08']='Coincide con el mandato 08';
        $encabezado_largo['mandato_09']='Coincide con el mandato 09';
        $encabezado_largo['mandato_10']='Coincide con el mandato 10';
        $encabezado_largo['mandato_11']='Coincide con el mandato 11';
        $encabezado_largo['mandato_12']='Coincide con el mandato 12';
        $encabezado_largo['mandato_13']='Coincide con el mandato 13';
        $encabezado_largo['dinamica_1']='Dinámica identificada 1';
        $encabezado_largo['dinamica_2']='Dinámica identificada 2';
        $encabezado_largo['dinamica_3']='Dinámica identificada 3';
        $encabezado_largo['a_consentimiento']='Adjunto: consentimiento informado';
        $encabezado_largo['a_audio']='Adjunto: audio';
        $encabezado_largo['a_ficha_corta']='Adjunto: Ficha corta';
        $encabezado_largo['a_ficha_larga']='Adjunto: Ficha larga';
        $encabezado_largo['a_otros']='Adjunto: otros';
        $encabezado_largo['a_transcripcion_preliminar']='Adjunto:  transcripción preliminar';
        $encabezado_largo['a_transcripcion_final']='Adjunto: transcripción final';
        $encabezado_largo['a_etiquetado']='Adjunto: etiquetado';
        $encabezado_largo['a_retroalimentacion']='Adjunto: retroalimentación';
        $encabezado_largo['a_relatoria']='Adjunto: relatoría';
        $encabezado_largo['a_certificacion_inicial']='Adjunto: certificación inicial';
        $encabezado_largo['a_certificacion_final']='Adjunto: certificación final';
        $encabezado_largo['a_plan_trabajo']='Adjunto: plan de trabajo';
        $encabezado_largo['a_valoracion']='Adjunto: valoración';
        $encabezado_largo['entrevista_lat']='Lugar entrevista - latitud';
        $encabezado_largo['entrevista_lon']='Lugar entrevista - longitud';
        $encabezado_largo['hechos_lat']='Lugar de los hechos - latitud';
        $encabezado_largo['hechos_lon']='Lugar de los hechos - longitud';
        $encabezado_largo['created_at']='Fecha en que se carga al sistema';
        $encabezado_largo['created_at_month']='Mes en que se carga al sistema';
        $encabezado_largo['updated_at']='Fecha de última modificación';
        $encabezado_largo['sintesis_relato']='Síntesis del relato';
        $encabezado_largo['ficha_priorizar_entrevista']='fichas: se recomienda priorizar entrevista';
        $encabezado_largo['ficha_priorizar_entrevista_asuntos']='fichas: temas por los que se recomienda priorizar';
        $encabezado_largo['ficha_contiene_patrones']='fichas: contiene patrones ';
        $encabezado_largo['ficha_contiene_patrones_cuales']='fichas: descripcion de los patrones';
        $encabezado_largo['ci_conceder_entrevista']='consentimiento: concede entrevista';
        $encabezado_largo['ci_grabar_audio']='consentimiento: autoriza grabar audio';
        $encabezado_largo['ci_elaborar_informe']='consentimiento: autoriza para elaborar informe';
        $encabezado_largo['ci_tratamiento_datos_analizar']='consentieminto: autoriza uso de datos para analisis';
        $encabezado_largo['ci_tratamiento_datos_analizar_sensible']='consentimiento: autoriza uso de informacion sensible para análisis';
        $encabezado_largo['ci_tratamiento_datos_utilizar']='consentimiento: autoriza uso de datos personales';
        $encabezado_largo['ci_tratamiento_datos_utilizar_sensible']='consentimiento: autoriza el uso de datos sensibles';
        $encabezado_largo['ci_tratamiento_datos_publicar']='consentimiento: autoriza publicar sus datos personales';
        $encabezado_largo['persona_entrevistada_sexo']='persona entrevistada: sexo';
        $encabezado_largo['persona_entrevistada_es_victima']='persona entrevistada: es víctima';
        $encabezado_largo['persona_entrevistada_es_testigo']='persona entrevistada: es testigo';
        $encabezado_largo['prioridad_fluidez']='Priorización: fluidez de la entrevista';
        $encabezado_largo['prioridad_d_hecho']='Priorización: descripción de los hechos';
        $encabezado_largo['prioridad_d_contexto']='Priorización: descripción del contexto';
        $encabezado_largo['prioridad_d_impacto']='Priorización: descripción de los impactos';
        $encabezado_largo['prioridad_d_justicia']='Priorización: acceso a la justicia, NR';
        $encabezado_largo['prioridad_cierre']='Priorización: cierre de la entrevista';
        $encabezado_largo['prioridad_poderacion']='Priorización: ponderación de la prioridad';
        $encabezado_largo['prioridad_ahora_entiendo']='Priorización: Ahora entiendo...';
        $encabezado_largo['prioridad_cambio_perspectiva']='Priorización: Me cambió la perspectiva...';


        $encabezados=array();

        $primero = excel_entrevista::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array( $var, $this->columnas_ocultas)) {
                    if(isset($encabezado_largo[$var])) {
                        $encabezados[]=$encabezado_largo[$var];
                    }
                    else {
                        $encabezados[]=$var;
                    }
                }
            }
        }



        return $encabezados;

    }
    public function columnFormats(): array
    {
        return [
            //'I'=> 'dd-mm-yyyy',
            'J' => '@',
            'L' => '@',
            'N' => '@',
            'Q' => '@',
            'S' => '@',
            'U' => '@',
        ];
    }
    public function title(): string
    {
        $numero=\Auth::user()->fmt_numero_entrevistador;
        return "E$numero ".date("Y-m-d H_i");
    }
    public function registerEvents(): array
    {

        return [
            BeforeExport::class => function(BeforeExport $event) {
               // $event->writer->getProperties()->setCreator("E".\Auth::user()->fmt_numero_entrevistador);
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:FF1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13) ;
            },

        ];
    }
}
