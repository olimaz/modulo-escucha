<?php

namespace App\Exports;

use App\Models\excel_entrevista;
use App\Models\nvivo_clasificador;
use App\Models\uso_tesauro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class uso_tesauroExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    var $columnas_ocultas=array();


    public function collection()
    {
        //excel_entrevista::generar_plana();
        $listado = uso_tesauro::selectRaw(\DB::raw('uso_tesauro.*'))->orderby('codigo')->get();
        //Ocultar columnas
        //$listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }

    public function headings(): array
    {
        $encabezados = uso_tesauro::encabezados();
        $primero = uso_tesauro::first();
        $revisados = array();
        foreach($primero->getAttributes() as $var => $val) {
            if(isset($encabezados[$var])) {
                $revisados[$var] = $encabezados[$var];
            }
            else {
                $revisados[$var] = $var;
            }

        }
        return $revisados;
    }
    public function columnFormats(): array
    {
        return [
            //'I'=> 'dd-mm-yyyy',
            // 'J' => '@',
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
                $cellRange = 'A1:OF1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                $event->sheet->getDelegate()->getStyle('A1:A1')->getFont()->setBold( true ); //para que desmarque
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13) ;
            },

        ];
    }
}
