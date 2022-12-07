<?php

namespace App\Exports;



use App\Models\excel_control_adjuntos;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class excel_control_adjuntosExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $oculto = ['nombre_original','justificacion_01','justificacion_02','justificacion_03','justificacion_04','justificacion_05','justificacion_06','justificacion_07','justificacion_08','justificacion_09','justificacion_10'];
    public function collection()
    {

        $listado = excel_control_adjuntos::orderby('id_excel_control_adjuntos')->get();
        //Ocultar la transcripción
        $listado->makeHidden($this->oculto);
        return $listado;
    }
    public function headings(): array
    {

        $encabezados=array();

        $primero = excel_control_adjuntos::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array($var, $this->oculto)) {
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
                $cellRange = 'A1:U1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Tipo
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(6) ;
                //Codigo
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13) ;
                //Tipo adjunto
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25) ;
                //Calificacion
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(25) ;
                //justificaciones
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(25) ;


                //Dejar seleccionada la primera celda
                $cellRange = 'A1:A1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );

            },

        ];
    }
}
