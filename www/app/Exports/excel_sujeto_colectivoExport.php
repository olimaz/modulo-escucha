<?php

namespace App\Exports;


use App\Models\excel_sujeto_colectivo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class excel_sujeto_colectivoExport implements FromCollection, WithHeadings, WithStrictNullComparison, WithColumnFormatting, WithTitle, WithEvents
{
    protected $a_ocultas=['transcripcion_html'];
    public function __construct($anonimo=false)
    {
        if($anonimo) {
            $this->a_ocultas = [
                'transcripcion_html',
                'id',
                'id_entrevista_etnica',
                'medios_virtuales',
                'situacion_actual',
                'territorio',
                'clasificacion',
                'codigo_entrevistador',
                'grupo_entrevistador',
                'entrevista_fecha',
                'entrevista_lugar_n2',
                'entrevista_lugar_n3',
                'entrevista_lat',
                'entrevista_lon',
                'tema',
                'objetivo',
                'hechos_lugar_n2',
                'hechos_lugar_n3',
                'descripcin_eventos',
                'titulo',
                'dinamica_1',
                'dinamica_2',
                'dinamica_3',
                'transcrita',
                'transcrita_fecha',
                'transcrita_fecha_a',
                'transcrita_fecha_m',
                'etiquetada',
                'etiquetada_fecha',
                'etiquetada_fecha_a',
                'etiquetada_fecha_m',
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
                'a_consentimiento',
                'a_audio',
                'a_ficha_corta',
                'a_ficha_larga',
                'a_otros',
                'a_transcripcion_preliminar',
                'a_transcripcion_final',
                'a_etiquetado',
                'a_retroalimentacion',
                'a_relatoria',
                'a_certificacion_inicial',
                'a_certificacion_final',
                'a_plan_trabajo',
                'a_valoracion',
                'fecha_carga',
                'mes_carga',
                'id_entrevistador',
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
                'consentimiento_nombre_autoridad',
                'consentimiento_nombre_identitario',
                'consentimiento_pueblo_representado',
                'consentimiento_numero_identificacion',
                'consentimiento_conceder_entrevista',
                'consentimiento_grabar_audio',
                'consentimiento_elaborar_informe',
                'consentimiento_grabar_video',
                'consentimiento_tomar_fotos',
                'consentimiento_tratamiento_datos_analizar',
                'consentimiento_tratamiento_datos_analizar_sensible',
                'consentimiento_tratamiento_datos_utilizar',
                'consentimiento_tratamiento_datos_utilizar_sensible',
                'consentimiento_tratamiento_datos_publicar',
                'minutos_transcripcion',
                'minutos_etiquetado',
                'minutos_diligenciado'
                , 'i_achagua','i_ambalo','i_amorua','i_andoke','i_arhuaco','i_awa','i_barasan','i_bara','i_bari','i_betoye','i_bora','i_carapana','i_chiricoa','i_cocama','i_coreguaje','i_curripako','i_desano','i_embera_chami','i_embrea_dobida','i_embera_katio','i_eperara','i_ett','i_guanaca','i_guane','i_guna','i_hitnu','i_hupde','i_ijku','i_inga','i_jiw','i_jupda','i_juhup','i_kakua','i_kamentsa','i_kankuamo','i_karijona','i_kawiyari','i_kofan','i_kogui','i_kokonuko','i_kubeo','i_leguama','i_makaguaje','i_makuma','i_mapayerri','i_masiguare','i_matapi','i_mirana','i_misak','i_mokana','i_muina','i_muisca','i_nasa','i_nonyha','i_nukak','i_nutabe','i_okaina','i_pastos','i_piapoco','i_piarona','i_pijao','i_piratapuyo','i_pisamira','i_plindara','i_pubense','i_puinave','i_quichua','i_quillanciga','i_quizgo','i_sikuani','i_siona','i_saliba','i_taiwano','i_tama','i_tanigua','i_tanimuka','i_tariano','i_tatuyo','i_tikuna','i_totoro','i_tsiripu','i_tubu','i_tucano','i_tuyuka','i_uitoto','i_uwa','i_wamonae','i_wanano','i_waunan','i_wayuu','i_wipijiki','i_wiwa','i_yagua','i_yamalero','i_yanacona','i_yari','i_yaruro','i_yauna','i_yeral','i_yukpa','i_yukuna','i_yuri','i_yuruti','i_zenu'
                , 'r_cucuta','r_envigado','r_giron','r_ibague','r_pasto','r_prorom','r_sabanalarga','r_sahagun','r_sampues','r_san_pelayo','r_union_romani'
            ];
        }
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $listado = excel_sujeto_colectivo::orderby('id')->get();
        //Ocultar la transcripción
        $listado->makeHidden($this->a_ocultas);

        return $listado;

    }
    public function headings(): array
    {
        $encabezados=array();

        $primero = excel_sujeto_colectivo::first();
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
                $cellRange = 'A1:IV1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold( true );
                //$cellRange='Y1:Y20000';
                //$event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setWrapText(true);
                //Codigo:
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(13) ;
                $event->sheet->getDelegate()->getStyle('B1:B1')->getFont()->setBold( true );
            },

        ];
    }
}
