<?php

namespace App\Exports;

use App\Models\excel_entrevista_pr;
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


class entrevista_pr_resultadosExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    //Arreglo de id_entrevista_profundidad a exportar
    protected $arreglo;
    protected $a_ocultas=['transcripcion_html'];
    //Constructor
    public function __construct($arreglo,$anonimo=false)
    {
        $this->arreglo = $arreglo;
        if($anonimo) {
            $this->a_ocultas = [
                'transcripcion_html',
                'id_entrevista_profundidad',
                'correlativo',
                'clasificacion',
                'codigo_entrevistador',
                'macroterritorio_id',
                'territorio_id',
                'territorio_txt',
                'grupo_id',
                'grupo_txt',
                'entrevista_fecha_inicio',
                'entrevista_fecha_final',
                'entrevista_avance_codigo',
                'entrevista_avance_txt',
                'entrevista_lugar_n1_codigo',
                'entrevista_lugar_n2_codigo',
                'entrevista_lugar_n2_txt',
                'entrevista_lugar_n3_codigo',
                'entrevista_lugar_n3_txt',
                'titulo',
                'objetivo',
                'tema_1',
                'tema_2',
                'tema_3',
                'tema_4',
                'tema_5',
                'dinamica_1',
                'dinamica_2',
                'dinamica_3',
                'entrevistado_nombres',
                'entrevistado_apellidos',
                'anotaciones',
                'policia_rango',
                'paramilitar_rango',
                'guerrilla_rango',
                'ejercito_rango',
                'fuerza_aerea_rango',
                'fuerza_naval_rango',
                'tercero_civil_cual',
                'agente_estado_cual',
                'transcrita',
                'etiquetada',
                'i_objetivo_esclarecimiento',
                'i_objetivo_reconocimiento',
                'i_objetivo_convivencia',
                'i_objetivo_no_repeticion',
                'i_enfoque_genero',
                'i_enfoque_psicosocial',
                'i_enfoque_curso_vida',
                'i_direccion_investigacion',
                'i_direccion_territorios',
                'i_direccion_etnica',
                'i_comisionados',
                'i_estrategia_arte',
                'i_estrategia_comunicacion',
                'i_estrategia_participacion',
                'i_estrategia_pedagogia',
                'i_grupo_acceso_informacion',
                'i_presidencia',
                'i_otra',
                'i_enlace',
                'i_sistema_informacion',
                'ia_pueblo_etnico',
                'ia_dialogo_social',
                'ia_ds_o_convivencia',
                'ia_ds_o_reconocimiento',
                'ia_ds_o_no_repeticion',
                'ia_genero',
                'ia_enfoque_ps',
                'ia_curso_vida',
                'nucleo_01',
                'nucleo_02',
                'nucleo_03',
                'nucleo_04',
                'nucleo_05',
                'nucleo_06',
                'nucleo_07',
                'nucleo_08',
                'nucleo_09',
                'nucleo_10',
                'mandato_01',
                'mandato_02',
                'mandato_03',
                'mandato_04',
                'mandato_05',
                'mandato_06',
                'mandato_07',
                'mandato_08',
                'mandato_09',
                'mandato_10',
                'mandato_11',
                'mandato_12',
                'mandato_13',
                'prioridad_e_fecha',
                'prioridad_e_ponderacion',
                'prioridad_e_fluidez',
                'prioridad_e_d_hecho',
                'prioridad_e_d_contexto',
                'prioridad_e_d_impacto',
                'prioridad_e_d_justicia',
                'prioridad_e_cierre',
                'prioridad_e_ahora_entiendo',
                'prioridad_e_cambio_perspectiva',
                'prioridad_t_fecha',
                'prioridad_t_ponderacion',
                'prioridad_t_fluidez',
                'prioridad_t_d_hecho',
                'prioridad_t_d_contexto',
                'prioridad_t_d_impacto',
                'prioridad_t_d_justicia',
                'prioridad_t_cierre',
                'prioridad_t_ahora_entiendo',
                'prioridad_t_cambio_perspectiva',
                'a_consentimiento',
                'a_audio',
                'a_ficha_corta',
                'a_ficha_larga',
                'a_otros',
                'a_transcripcion_preliminar',
                'a_transcripcion_final',
                'a_retroalimentacion',
                'a_relatoria',
                'a_certificacion_inicial',
                'a_certificacion_final',
                'a_comunicacion_oficial',
                'a_plan_trabajo',
                'a_valoracion',
                'entrevista_lat',
                'entrevista_lon',
                'etiquetado_json',
                'created_at',
                'updated_at',
                'id_entrevistador',
            ];
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //excel_entrevista_pr::generar_plana();
        $listado = excel_entrevista_pr::selectRaw(\DB::raw('excel_entrevista_pr.*'))->wherein('id_entrevista_profundidad',$this->arreglo)->orderby('id_entrevista_profundidad')->get();

        //Ocultar la transcripción
        $listado->makeHidden($this->a_ocultas);

        return $listado;
    }
    public function headings(): array
    {
        $encabezados=array();
        $primero = excel_entrevista_pr::first();
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
                $cellRange = 'A1:CW1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Tipo
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(18) ;
                //Codigo
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(13) ;
            },

        ];
    }
}
