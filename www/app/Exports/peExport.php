<?php

namespace App\Exports;

use App\Models\analitica_persona_entrevistada;
use App\Models\analitica_victima;
use App\Modelsanalitica_persona_entrevistada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class peExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    //listado de entrevistas a exportar
    protected $a_persona_entrevistada = array();
    protected $query;
    var $columnas_ocultas=['apellido','nombre','otros_nombres','insert_id_entrevistador','insert_fecha_hora','insert_fecha','insert_mes','update_id_entrevistador'];


    public function __construct($a_victima)
    {
        $this->a_victima = $a_victima;

        $this->query = analitica_persona_entrevistada::wherein('id_persona_entrevistada',$this->a_victima)
            //->wherein('victima_violencia.id_hecho',$this->a_hecho)
            ->orderby('apellido')
            ->orderby('nombre')
            ->orderby('otros_nombres')
            ->orderby('fec_nac_anio')
            ->orderby('fec_nac_mes')
            ->orderby('fec_nac_dia')
            ;



    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //



        $query = clone $this->query;
        $listado = $query->get();
        //Ocultar columnas
        $listado->makeHidden($this->columnas_ocultas);


        return $listado;
    }
    public function headings(): array
    {
        $encabezados=array();
        $query = clone $this->query;
        $primero = $query->first();
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
                $cellRange = 'A1:NN1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                /*
                //encabezados de violencia
                $cellRange = 'AV1:NN1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->getColor()->setRGB('0000ff');
                // Encabezados de victima_violencia
                $cellRange = 'AM1:AU1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('aaaaaa');
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo:
                */
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(13) ;
                $event->sheet->getDelegate()->getStyle('B1:B1')->getFont()->setBold( true );
            },

        ];
    }
}