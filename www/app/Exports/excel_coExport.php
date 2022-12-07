<?php

namespace App\Exports;

use App\Models\excel_co;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class excel_coExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    //listado de entrevistas a exportar
    protected $arreglo;
    var $columnas_ocultas=array();


    public function __construct($arreglo,$anonimo=false)
    {
        $this->arreglo = $arreglo;
        if($anonimo) {
            $this->columnas_ocultas = [
                'id',
                'id_entrevista_colectiva',
                'medios_virtuales',
                'situacion_actual',
                'codigo_entrevistador',
                'grupo_entrevistador',
                'entrevista_fecha_inicio',
                'entrevista_fecha_final',
                'clasificacion',
                'entrevista_lugar_n3',
                'entrevista_lat',
                'entrevista_lon',
                'tema_lugar_n3',
                'titulo',
                'observaciones',
                'dinamica_1',
                'dinamica_2',
                'dinamica_3',
                'transcrita_fecha',
                'transcrita_fecha_a',
                'transcrita_fecha_m',
                'etiquetada_fecha',
                'etiquetada_fecha_a',
                'etiquetada_fecha_m',
                'a_consentimiento',
                'a_audio',
                'a_ficha_corta',
                'a_ficha_larga',
                'a_otros',
                'a_transcripcion_preliminar',
                'a_transcripcion_final',
                'a_etiquetado',
                'a_retroalimentacion',
                'a_relatoria',
                'a_certificacion_inicial',
                'a_certificacion_final',
                'a_plan_trabajo',
                'a_valoracion',
                'fecha_carga',
                'mes_carga',
                'id_entrevistador',
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
                'minutos_entrevista',
                'minutos_transcripcion',
                'minutos_etiquetado',
                'minutos_diligenciado',
            ];
        }

    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $listado = excel_co::selectRaw(\DB::raw('excel_co.*'))->wherein('id_entrevista_colectiva',$this->arreglo)->orderby('id_entrevista_colectiva')->get();
        //Ocultar columnas
        $listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }
    public function headings(): array
    {
        $encabezados=array();

        $primero = excel_co::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array($var,$this->columnas_ocultas)) {
                    $encabezados[]=$var;
                }
            }

        }
        return $encabezados;

    }
    public function columnFormats(): array
    {
        return [
            //'I'=> 'dd-mm-yyyy',
            'A' => '@',
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
                $event->writer->getProperties()->setCreator("E".\Auth::user()->fmt_numero_entrevistador);
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:IV1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo:
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13) ;
                $event->sheet->getDelegate()->getStyle('B1:B1')->getFont()->setBold( true );
            },

        ];
    }
}
