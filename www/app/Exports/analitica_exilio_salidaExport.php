<?php

namespace App\Exports;

use App\analitica_exilio_salida;
use App\Models\excel_entrevista_dinamica;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class analitica_exilio_salidaExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return \App\Models\analitica_exilio_salida::all();
    }
    public function headings(): array
    {
        $encabezados=array();

        $primero = \App\Models\analitica_exilio_salida::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                $encabezados[]=$var;
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
                $cellRange = 'A1:BK1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },

        ];
    }
}
