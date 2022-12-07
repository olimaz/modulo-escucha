<?php

namespace App\Exports;

use App\Models\analitica_victima;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class victima_personaExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    //listado de entrevistas a exportar
    protected $arreglo;
    protected $query;
    var $columnas_ocultas=['insert_id_entrevistador','insert_fecha_hora','insert_fecha','insert_fecha_mes','update_id_entrevistador','update_fecha_hora'];


    public function __construct($arreglo)
    {
        $this->arreglo = $arreglo;
        $this->query = analitica_victima::wherein('victima.id_persona',$this->arreglo)
            ->select('victima.id_victima', 'victima.id_entrevista', 'victima.id_persona',  'victima.codigo_entrevista', 'victima.nombre', 'victima.apellido', 'victima.otros_nombres', 'victima.fec_nac_anio', 'victima.fec_nac_mes', 'victima.fec_nac_dia', 'victima.lugar_nac_codigo',  'victima.lugar_nac_n1_txt',  'victima.lugar_nac_n2_txt',  'victima.sexo_txt', 'victima.orientacion_sexual_txt', 'victima.identidad_genero_txt', 'victima.pertenencia_etnica_txt', 'victima.pertenencia_indigena_txt', 'victima.documento_identidad_tipo_txt', 'victima.documento_identidad_numero', 'victima.nacionalidad_txt',  'victima.estado_civil_txt',  'victima.educacion_formal_txt', 'victima.profesion', 'victima.d_sensorial', 'victima.d_intelectual', 'victima.d_psicosocial', 'victima.d_fisica', 'victima.cargo_publico', 'victima.cargo_publico_cual', 'victima.fuerza_publica_miembro', 'victima.fuerza_publica_estado', 'victima.fuerza_publica_especificar', 'victima.actor_armado_ilegal', 'victima.actor_armado_ilegal_especificar', 'victima.organizacion_colectivo_participa', 'victima.relacion_persona_entrevistada')
            ->orderby('victima.apellido')
            ->orderby('victima.nombre')
            ->orderby('victima.otros_nombres')
            ->orderby('victima.fec_nac_anio');


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
                //Codigo:
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13) ;
                $event->sheet->getDelegate()->getStyle('B1:B1')->getFont()->setBold( true );
            },

        ];
    }
}
