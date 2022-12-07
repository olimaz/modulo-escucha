<?php

namespace App\Exports;

use App\excel_entrevista_seguimiento;
use App\Models\excel_entrevista_dinamica;
use App\Models\excel_seguimiento_entrevistas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class excel_entrevista_seguimientoExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //excel_entrevista_dinamica::generar_plana();
        $listado = excel_seguimiento_entrevistas::selectRaw(\DB::raw('excel_seguimiento_entrevistas.*'))->get();
        //Ocultar la transcripción
        //$listado->makeHidden(['transcripcion_html']);
        //return excel_entrevista_dinamica::all();
        return $listado;
    }

    public function headings(): array
    {
        $encabezados=array();

        $primero = excel_seguimiento_entrevistas::first();
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
                $cellRange = 'A1:Q1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },

        ];
    }
}
