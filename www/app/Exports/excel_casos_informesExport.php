<?php

namespace App\Exports;

use App\excel_casos_informes;
use App\Models\excel_entrevista_pr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class excel_casos_informesExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    public function __construct()
    {
        $this->columnas_ocultas=[
            'json_adjuntos',
            'json_interes',
            'json_mandato',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //excel_entrevista_pr::generar_plana();
        $listado = \App\Models\excel_casos_informes::selectRaw(\DB::raw('excel_casos_informes.*'))->orderby('codigo')->get();

        //Ocultar la transcripción
        //$listado->makeHidden(['transcripcion_html']);
        //Ocultar columnas
        $listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }
    public function headings(): array
    {

        $encabezados=array();

        $primero = \App\Models\excel_casos_informes::first();
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
            'C' => '@',
            'J' => 'yyyy-mm-dd',
            'G' => 'yyyy-mm-dd',
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
                $cellRange = 'A1:DM1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //
                $columnas=array('C','E','F');
                foreach($columnas as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth(13) ;
                }

                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },

        ];
    }
}
