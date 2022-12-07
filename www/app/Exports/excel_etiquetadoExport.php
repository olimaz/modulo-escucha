<?php

namespace App\Exports;

use App\Models\excel_etiquetado;
use App\Models\excel_hv;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class excel_etiquetadoExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    //listado de entrevistas a exportar
    protected $arreglo;
    var $columnas_ocultas=array('id','id_entrevistador','fecha_carga',	'mes_carga');

    public function __construct($arreglo)
    {
        $this->arreglo = $arreglo;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
        $listado = excel_etiquetado::selectRaw(\DB::raw('distinct excel_etiquetado.*'))->wherein('id_etiqueta_entrevista',$this->arreglo)->orderby('id')->get();
        //Ocultar columnas
        $listado->makeHidden($this->columnas_ocultas);

        return $listado;
    }
    public function headings(): array
    {
        $encabezados=array();

        $primero = excel_etiquetado::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array( $var, $this->columnas_ocultas)) {
                    $encabezados[] = $var;
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
                $cellRange = 'A1:BF1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo:
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(13) ;
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13) ;
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13) ;
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(39) ;
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13) ;
                $event->sheet->getDelegate()->getStyle('B1:B1')->getFont()->setBold( true );
            },

        ];
    }
}
