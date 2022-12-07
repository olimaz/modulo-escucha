<?php

namespace App\Exports;

use App\Models\entrevista_individual;
use App\Models\excel_entrevista;
use App\Models\excel_entrevista_dinamica;
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

class dinamicaExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{

    public function collection()
    {
        //excel_entrevista_dinamica::generar_plana();
        $listado = excel_entrevista_dinamica::selectRaw(\DB::raw('excel_entrevista_dinamica.*'))->permisos()->get();
        //Ocultar la transcripción
        $listado->makeHidden(['transcripcion_html']);
        //return excel_entrevista_dinamica::all();
        return $listado;
    }

    public function headings(): array
    {
        $encabezados=array();

        $primero = excel_entrevista_dinamica::first();
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
                $cellRange = 'A1:CP1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
            },

        ];
    }
}
