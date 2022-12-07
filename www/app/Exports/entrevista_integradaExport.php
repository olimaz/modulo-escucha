<?php

namespace App\Exports;

use App\Models\excel_entrevista;
use App\Models\excel_entrevista_integrado;
use App\Modelsentrevista_individual;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class entrevista_integradaExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    var $columnas_ocultas=array();
    public function __construct($anonimo=false) {
        if(\Gate::allows('nivel-1')) {
            $this->columnas_ocultas=[

            ];
        }
        else {
            $this->columnas_ocultas=[
                'entrevistada_nombres',
                'entrevistada_apellidos',
            ];
        }
        if($anonimo) {
            $this->columnas_ocultas=[
                'entrevistada_nombres',
                'entrevistada_apellidos',
                'id',
                'es_virtual',
                'situacion_actual',
                'clasificacion_nivel',
                'clasificacion_nna',
                'clasificacion_sex',
                'clasificacion_res',
                'clasificacion_r1',
                'clasificacion_r2',
                'codigo_entrevistador',
                'grupo_entrevistador',
                'entrevista_fecha',
                'tiempo_entrevista',
                'entrevista_lugar_n3',
                'conteo_consultas',
                'interes_exilio',
                'titulo',
                'dinamica_1',
                'dinamica_2',
                'dinamica_3',
                'conteo_caracteres',
                'transcrita_fecha',
                'transcrita_fecha_a',
                'transcrita_fecha_m',
                'conteo_etiquetas',
                'etiquetada_fecha',
                'etiquetada_fecha_a',
                'etiquetada_fecha_m',
                'a_consentimiento',
                'a_audio',
                'a_ficha_corta',
                'a_ficha_larga',
                'a_relatoria',
                'a_transcripcion_preliminar',
                'a_transcripcion_final',
                'a_etiquetado',
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
                'a_total_adjuntos',
                'entrevista_lat',
                'entrevista_lon',
                'prioridad_e_fecha',
                'prioridad_e_ponderacion',
                'prioridad_e_fluidez',
                'prioridad_e_d_hecho',
                'prioridad_e_d_contexto',
                'prioridad_e_d_impacto',
                'prioridad_e_d_justicia',
                'prioridad_e_cierre',
                'prioridad_e_ahora_entiendo',
                'prioridad_e_cambio_perspectiva',
                'prioridad_t_fecha',
                'prioridad_t_ponderacion',
                'prioridad_t_fluidez',
                'prioridad_t_d_hecho',
                'prioridad_t_d_contexto',
                'prioridad_t_d_impacto',
                'prioridad_t_d_justicia',
                'prioridad_t_cierre',
                'prioridad_t_ahora_entiendo',
                'prioridad_t_cambio_perspectiva',
                'procesamiento_requisitos_minimos',
                'procesamiento_transcrito',
                'procesamiento_etiquetado',
                'procesamiento_cerrado',
                'consentimiento_conceder_entrevista',
                'consentimiento_grabar_audio',
                'consentimiento_elaborar_informe',
                'consentimiento_tratamiento_datos_analizar',
                'consentimiento_tratamiento_datos_analizar_sensible',
                'consentimiento_tratamiento_datos_utilizar',
                'consentimiento_tratamiento_datos_utilizar_sensible',
                'consentimiento_tratamiento_datos_publicar',
                'fichas_estado_diligenciado',
                'fichas_conteo_entrevistado',
                'fichas_conteo_victima',
                'fichas_conteo_responsable',
                'fichas_conteo_hechos',
                'fichas_conteo_violaciones',
                'fichas_conteo_violencia',
                'fichas_conteo_exilio',
                'fichas_conteo_alertas',
                'minutos_entrevista',
                'minutos_transcripcion',
                'minutos_etiquetado',
                'minutos_diligenciado',
                'entrevistada_nombres',
                'entrevistada_apellidos',
                'entrevistada_sexo',
                'entrevistada_edad',
                'entrevistada_es_victima',
                'entrevistada_es_testigo',
                'fecha_carga',
                'mes_carga',
                'fecha_cierre',
                'mes_cierre',
                'max_fecha_adjunto',
                'max_mes_adjunto',
                'id_entrevistador',
                'tipo_especifico',
                'tema',
                'objetivo',
            ];
        }
}

    public function collection()
    {
        //excel_entrevista::generar_plana();

        $listado = excel_entrevista_integrado::permitidos()->orderby('id')->get();

        //Ocultar columnas
        $listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }

    public function headings(): array
    {

        $encabezados=array();
        $encabezado_largo = excel_entrevista_integrado::encabezados();



        $primero = excel_entrevista_integrado::first();
        if($primero) {
            $segundo=array();
            $vacio=array();
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array( $var, $this->columnas_ocultas)) {
                    if(isset($encabezado_largo[$var])) {
                        $encabezados[]=$encabezado_largo[$var];
                    }
                    else {
                        $encabezados[]=$var;
                    }
                    $segundo[]=$var;
                    $vacio[]="";
                }


            }
            $nuevos[0]=$encabezados;
            $nuevos[1]=$vacio;
            $nuevos[2]=$segundo;
            //dd($nuevos);
            return $nuevos;
        }



        return $encabezados;

//        $primero = excel_entrevista_integrado::first();
//        if($primero) {
//            //dd($fila);
//            foreach($primero->toArray() as $var=>$val) {
//                if(!in_array( $var, $this->columnas_ocultas)) {
//                    $encabezados[]=$var;
//                }
//            }
//        }
//
//        return $encabezados;

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
                $cellRange = 'A3:FO3'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(13) ;
            },

        ];
    }
    public function properties(): array
    {
        return [
            'keywords' => \Auth::user()->email ?? 'sin especificar',
        ];
    }
}
