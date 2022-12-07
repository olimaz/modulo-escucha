<?php

namespace App\Exports;

use App\Models\excel_entrevista;
use App\Models\excel_ficha_persona_entrevistada;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ficha_persona_entrevistadaExporte implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    var $columnas_ocultas=array();
    public function __construct($anonimizar=false) {
        if(\Gate::allows('nivel-1')) {
            $this->columnas_ocultas=array();
        }
        else {
            $this->columnas_ocultas=array('nombre' ,'apellido','otros_nombres');
        }

        if($anonimizar) {
            $this->columnas_ocultas = [
                'id_excel_ficha_persona_entrevistada',
                'id_entrevista',
                'id_persona',
                'id_persona_entrevistada',
                'lugar_entrevista_n2',
                'lugar_entrevista_n3',
                'fecha_entrevista_anio',
                'fecha_entrevista',
                'transcrita',
                'etiquetada',
                'clasificacion_acceso',
                'nombre',
                'apellido',
                'otros_nombres',
                'fec_nac_mes',
                'fec_nac_dia',
                'lugar_nac_codigo',
                'lugar_nac_n2',
                'lugar_nac_n3',
                'lugar_nac_n3_lat',
                'lugar_nac_n3_lon',
                'pertenencia_indigena',
                'lugar_residencia_codigo',
                'lugar_residencia_n1',
                'lugar_residencia_n2',
                'lugar_residencia_n3',
                'lugar_residencia_n3_lat',
                'lugar_residencia_n3_lon',
                'ocupacion_actual',
                'cargo_publico_cual',
                'fuerza_publica_estado',
                'relato',
            ];
        }
    }
    public function collection()
    {
        //excel_entrevista::generar_plana();
        $listado = excel_ficha_persona_entrevistada::selectRaw(\DB::raw('excel_ficha_persona_entrevistada.*'))->permisos()->orderby('codigo_entrevista')->get();

        //Ocultar la transcripción
        //$listado->makeHidden(['transcripcion_html']);
        $listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }

    public function headings(): array
    {

        $encabezados=array();

        $primero = excel_ficha_persona_entrevistada::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array( $var, $this->columnas_ocultas)) {
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
                $cellRange = 'A1:EA1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                $event->sheet->getDelegate()->getStyle('A1:A1')->getFont()->setBold( true ); //Para quitar la selección del encabezado
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                $event->sheet->getColumnDimension('E')->setAutoSize(true); //Codigo de entrevista
            },

        ];
    }
}
