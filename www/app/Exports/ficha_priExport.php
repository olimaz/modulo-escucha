<?php

namespace App\Exports;

use App\Models\analitica_pri;
use App\Models\analitica_victima;
use App\Modelsanalitica_pri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ficha_priExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStrictNullComparison
{
    //listado de entrevistas a exportar
    protected $a_pri = array();
    protected $query;
    var $columnas_ocultas=['creacion_fh','creacion_fecha',	'creacion_mes'];


    public function __construct($a_pri=array())
    {
        $this->a_pri = $a_pri;
        $this->query = analitica_pri::join('analitica.violencia','presunto_responsable_individual.id_hecho','violencia.id_hecho')
                                    ->join('analitica.metadatos', 'presunto_responsable_individual.id_entrevista','metadatos.id_entrevista')
                                    ->wherein('presunto_responsable_individual.id_responsable',$this->a_pri)
            //->wherein('victima_violencia.id_hecho',$this->a_hecho)
            ->orderby('presunto_responsable_individual.apellido')
            ->orderby('presunto_responsable_individual.nombre')
            ->orderby('presunto_responsable_individual.otros_nombres')
            ->orderby('violencia.fecha_inicio')
            ->orderby('violencia.id_hecho');
            //->select('presunto_responsable_inddividual.*', 'metadatos.id_entrevista', 'victima.id_persona',  'victima.codigo_entrevista', 'victima.nombre', 'victima.apellido', 'victima.otros_nombres', 'victima.fec_nac_anio', 'victima.fec_nac_mes', 'victima.fec_nac_dia', 'victima.lugar_nac_codigo',  'victima.lugar_nac_n1_txt',  'victima.lugar_nac_n2_txt', 'victima.sexo_txt', 'victima.orientacion_sexual_txt', 'victima.identidad_genero_txt', 'victima.pertenencia_etnica_txt', 'victima.pertenencia_indigena_txt', 'victima.documento_identidad_tipo_txt', 'victima.documento_identidad_numero', 'victima.nacionalidad_txt',  'victima.estado_civil_txt',  'victima.educacion_formal_txt', 'victima.profesion', 'victima.ocupacion_actual', 'victima.d_sensorial', 'victima.d_intelectual', 'victima.d_psicosocial', 'victima.d_fisica', 'victima.cargo_publico', 'victima.cargo_publico_cual', 'victima.fuerza_publica_miembro', 'victima.fuerza_publica_estado', 'victima.fuerza_publica_especificar', 'victima.actor_armado_ilegal', 'victima.actor_armado_ilegal_especificar', 'victima.organizacion_colectivo_participa', 'victima.relacion_persona_entrevistada',  'victima_violencia.edad', 'victima_violencia.ocupacion', 'victima_violencia.lugar_res_codigo',  'victima_violencia.lugar_res_n1_txt',  'victima_violencia.lugar_res_n2_txt', 'victima_violencia.lugar_res_n3_txt', 'victima_violencia.lugar_res_n3_lat', 'victima_violencia.lugar_res_n3_lon', 'victima_violencia.lugar_res_zona_txt','victima_violencia.id_hecho')
            //->addSelect(\DB::raw('violencia.*'));



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
        //Grandes secciones
        $secciones=array();
        $secciones[]="Información del presunto responsable inidividual";
        for($i=1; $i<=31; $i++) {
            $secciones[]=null;
        }
        $secciones[]="Información de la violencia ejercida";
        for($i=1; $i<=335; $i++) {
            $secciones[]=null;
        }
        $secciones[]="Información de la entrevista";
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

        return [$secciones, $encabezados];

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
                $cellRange = 'A1:TZ2'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //encabezados de violencia: letra azul
                $cellRange = 'AG1:ND2';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()
                    ->getColor()->setRGB('0000ff');
                // Encabezados de entrevista: fondo gris
                $cellRange = 'NE1:TZ2';
                $event->sheet->getDelegate()->getStyle($cellRange)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('aaaaaa');
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo:
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(13) ;
                $event->sheet->getDelegate()->getStyle('B1:B1')->getFont()->setBold( true );
            },

        ];
    }
}
