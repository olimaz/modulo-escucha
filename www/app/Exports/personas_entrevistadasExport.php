<?php

//A partir de tabla con personas entrevistadas de diferentes tipos de entrevistas

namespace App\Exports;

use App\Models\excel_entrevista_pr;
use App\Models\excel_personas_entrevistadas;
use App\Models\persona_entrevistada;
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


class personas_entrevistadasExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    //Arreglo de id_entrevista_profundidad a exportar
    protected $arreglo;
    protected $a_ocultas=['id_excel_personas_entrevistadas','id_subserie','id_entrevista','id_personas_entrevistadas','fts','id_sexo','id_sector','id_macroterritorio','id_territorio','id_entrevista_lugar'];
    //Constructor
    public function __construct($arreglo, $anonimo=false)
    {
        $this->arreglo = $arreglo;
        if($anonimo) {
            $this->a_ocultas = [
                'id_excel_personas_entrevistadas','id_subserie','id_entrevista','id_personas_entrevistadas','fts','id_sexo','id_sector','id_macroterritorio','id_territorio','id_entrevista_lugar',
                'tipo_entrevista',
                'cedula',
                'nombres',
                'apellidos',
                'otros_nombres',
                'clasificacion_nivel',
                'territorio',
                'entrevista_fecha',
                'entrevista_lugar_n1_codigo',
                'entrevista_lugar_n2_codigo',
                'entrevista_lugar_n2_txt',
                'entrevista_lugar_n3_codigo',
                'entrevista_lugar_n3_txt',
                'entrevista_lugar_n3_lat',
                'entrevista_lugar_n3_lon',
                'id_persona',
            ];
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //excel_entrevista_pr::generar_plana();
        $listado = excel_personas_entrevistadas::wherein('id_excel_personas_entrevistadas',$this->arreglo)->ordenar()->get();

        //Ocultar la transcripción
        $listado->makeHidden($this->a_ocultas);

        return $listado;
    }
    public function headings(): array
    {

        $encabezados=array();

        $primero = excel_personas_entrevistadas::first();
        if($primero) {
            //dd($fila);
            foreach($primero->toArray() as $var=>$val) {
                if(!in_array($var,$this->a_ocultas)) {
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
            'E' => '@',
            'F' => '@',
            //'N' => '@',
            //'Q' => '@',
            //'S' => '@',
            //'U' => '@',
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
                $cellRange = 'A1:T1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //Para evitar que marque la fila superior
                $cellRange='A1:A1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //Tipo
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(18) ;
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(10) ;
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(18) ;
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(18) ;
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(18) ;
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(15) ;
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20) ;
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15) ;
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(20) ;
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(20) ;
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(20) ;
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(20) ;
                //Codigo
                //$event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13) ;
            },
        ];
    }
}
