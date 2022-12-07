<?php

namespace App\Exports;

use App\Models\excel_entrevista;
use App\Models\nvivo_clasificador;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class nvivo_clasificadorExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    var $columnas_ocultas=array();


    public function collection()
    {
        //excel_entrevista::generar_plana();
        $listado = nvivo_clasificador::selectRaw(\DB::raw('metadatos_nvivo.*'))->orderby('codigo_entrevista')->get();

        //Ocultar columnas
        //$listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }

    public function headings(): array
    {
        $encabezado_largo=array();
        $encabezado_largo['codigo_entrevista']='Entrevista';
        $encabezado_largo['es_virtual']='Medios Virtuales';
        $encabezado_largo['personas_entrevistadas']='Cantidad de personas entrevistadas';
        $encabezado_largo['tipo_entrevista']='Tipo de entrevista';
        $encabezado_largo['nivel_acceso']='Clasificación de acceso';
        $encabezado_largo['macroterritorio']='Macroterritorio';
        $encabezado_largo['territorio']='Territorio';
        $encabezado_largo['codigo_entrevistador']='Entrevistador - Código';
        $encabezado_largo['grupo_entrevistador']='Entrevistador - Grupo';
        $encabezado_largo['entrevista_fecha']='Fecha de la entrevista';
        $encabezado_largo['entrevista_mes']='Fecha de la entrevista - Mes';
        $encabezado_largo['entrevista_anyo']='Fecha de la entrevista - Año';
        $encabezado_largo['tiempo_entrevista']='Duración de la entrevista';
        $encabezado_largo['entrevista_lugar_n1']='Lugar de la entrevista - Departamento';
        $encabezado_largo['entrevista_lugar_n2']='Lugar de la entrevista - Municipio';
        $encabezado_largo['entrevista_lugar_n3']='Lugar de la entrevista - Vereda';
        $encabezado_largo['entrevista_lat']='Lugar de la entrevista - Latitud';
        $encabezado_largo['entrevista_lon']='Lugar de la entrevista - Longitud';
        $encabezado_largo['hechos_lugar_n1']='Lugar de los hechos -Departamento';
        $encabezado_largo['hechos_lugar_n2']='Lugar de los hechos - Municipio';
        $encabezado_largo['hechos_lugar_n3']='Lugar de los hechos - Vereda';
        $encabezado_largo['hechos_lat']='Lugar de los hechos - Latitud';
        $encabezado_largo['hechos_lon']='Lugar de los hechos - Longitud';
        $encabezado_largo['hechos_del']='Fecha de los hechos - desde';
        $encabezado_largo['hechos_al']='Fecha de los hechos - hasta';
        $encabezado_largo['sector_entrevistado']='Sector con el que se asocia la víctima';
        $encabezado_largo['transcrita']='Entrevista transcrita';
        $encabezado_largo['etiquetada']='Entrevista etiquetada';
        $encabezado_largo['fecha_carga']='Fecha en que se carga al sistema';
        $encabezado_largo['fecha_carga_mes']='Mes en que se carga al sistema';
        $encabezado_largo['fecha_carga_anyo']='Año en que se carga al sistema';
        //
        $encabezado_largo['interes_exilio']='Entrevista de interes de exilio';
        $encabezado_largo['interes_etnico']='Entrevista de interés étnico';
        //
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
        //Prioridad entrevistador
        $encabezado_largo['prioridad_e_fecha']='Priorización del entrevistador: fecha de priorización';
        $encabezado_largo['prioridad_ponderacion']='Priorización del entrevistador: ponderación de la prioridad';
        $encabezado_largo['prioridad_fluidez']='Priorización del entrevistador: fluidez de la entrevista';
        $encabezado_largo['prioridad_d_hecho']='Priorización del entrevistador: descripción de los hechos';
        $encabezado_largo['prioridad_d_contexto']='Priorización del entrevistador: descripción del contexto';
        $encabezado_largo['prioridad_d_impacto']='Priorización del entrevistador: descripción de los impactos';
        $encabezado_largo['prioridad_d_justicia']='Priorizacióndel entrevistador: acceso a la justicia, NR';
        $encabezado_largo['prioridad_cierre']='Priorización del entrevistador: cierre de la entrevista';
        $encabezado_largo['prioridad_ahora_entiendo']='Priorización del entrevistador: Ahora entiendo...';
        $encabezado_largo['prioridad_cambio_perspectiva']='Priorización del entrevistador: Me cambió la perspectiva...';
        //Prioridad transcriptor
        $encabezado_largo['prioridad_e_fecha']='Priorización del transcriptor: fecha de priorización';
        $encabezado_largo['prioridad_ponderacion']='Priorización del transcriptor: ponderación de la prioridad';
        $encabezado_largo['prioridad_fluidez']='Priorización del transcriptor: fluidez de la entrevista';
        $encabezado_largo['prioridad_d_hecho']='Priorización del transcriptor: descripción de los hechos';
        $encabezado_largo['prioridad_d_contexto']='Priorización del transcriptor: descripción del contexto';
        $encabezado_largo['prioridad_d_impacto']='Priorización del transcriptor: descripción de los impactos';
        $encabezado_largo['prioridad_d_justicia']='Priorizacióndel transcriptor: acceso a la justicia, NR';
        $encabezado_largo['prioridad_cierre']='Priorización del transcriptor: cierre de la entrevista';
        $encabezado_largo['prioridad_ahora_entiendo']='Priorización del transcriptor: Ahora entiendo...';
        $encabezado_largo['prioridad_cambio_perspectiva']='Priorización del transcriptor: Me cambió la perspectiva...';
        // Consentimiento
        $encabezado_largo['consentimiento_conceder_entrevista']='consentimiento: concede entrevista';
        $encabezado_largo['consentimiento_grabar_audio']='consentimiento: autoriza grabar audio';
        $encabezado_largo['consentimiento_elaborar_informe']='consentimiento: autoriza para elaborar informe';
        $encabezado_largo['consentimiento_tratamiento_datos_analizar']='consentieminto: autoriza uso de datos para analisis';
        $encabezado_largo['consentimiento_tratamiento_datos_analizar_sensible']='consentimiento: autoriza uso de informacion sensible para análisis';
        $encabezado_largo['consentimiento_tratamiento_datos_utilizar']='consentimiento: autoriza uso de datos personales';
        $encabezado_largo['consentimiento_tratamiento_datos_utilizar_sensible']='consentimiento: autoriza el uso de datos sensibles';
        $encabezado_largo['consentimiento_tratamiento_datos_publicar']='consentimiento: autoriza publicar sus datos personales';
        $encabezado_largo['fichas_estado_diligenciado']='Diligenciar fichas: estado';
        $encabezado_largo['fichas_conteo_entrevistado']='Cantidad de fichas de persona entrevistada';
        $encabezado_largo['fichas_conteo_victima']='Cantidad de fichas de víctima';
        $encabezado_largo['fichas_conteo_responsable']='Cantidad de fichas de presunto responsable individual';
        $encabezado_largo['fichas_conteo_hechos']='Cantidad de hechos';
        $encabezado_largo['fichas_conteo_violaciones']='Cantidad de violaciones';
        $encabezado_largo['fichas_conteo_violencia']='Cantidad de violencias';
        $encabezado_largo['fichas_conteo_exilio']='Cantidad de fichas de exilio';


        $encabezados=array();

        $primero = nvivo_clasificador::first();
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
                $cellRange = 'A1:EN1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                $event->sheet->getDelegate()->getStyle('A1:A1')->getFont()->setBold( true ); //para que desmarque
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(13) ;
            },

        ];
    }
}
