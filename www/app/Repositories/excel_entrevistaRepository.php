<?php

namespace App\Repositories;

use App\Models\excel_entrevista;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class excel_entrevistaRepository
 * @package App\Repositories
 * @version June 5, 2019, 8:32 pm -05
 *
 * @method excel_entrevista findWithoutFail($id, $columns = ['*'])
 * @method excel_entrevista find($id, $columns = ['*'])
 * @method excel_entrevista first($columns = ['*'])
*/
class excel_entrevistaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'correlativo',
        'codigo_entrevista',
        'codigo_entrevistador',
        'macroterritorio_id',
        'macroterritorio_txt',
        'territorio_id',
        'territorio_txt',
        'entrevista_fecha',
        'entrevista_lugar_n1_codigo',
        'entrevista_lugar_n1_txt',
        'entrevista_lugar_n2_codigo',
        'entrevista_lugar_n2_txt',
        'entrevista_lugar_n3_codigo',
        'entrevista_lugar_n3_txt',
        'titulo',
        'hechos_lugar_n1_codigo',
        'hechos_lugar_n1_txt',
        'hechos_lugar_n2_codigo',
        'hechos_lugar_n2_txt',
        'hechos_lugar_n3_codigo',
        'hechos_lugar_n3_txt',
        'hechos_del',
        'hechos_al',
        'anotaciones',
        'aa_paramilitar',
        'aa_guerrilla',
        'aa_fuerza_publica',
        'aa_terceros_civiles',
        'aa_otro',
        'viol_homicidio',
        'viol_atentado_vida',
        'viol_amenaza_vida',
        'viol_desaparicion_f',
        'viol_tortura',
        'viol_violencia_sexual',
        'viol_esclavitud',
        'viol_detencion_arbitraria',
        'viol_secuestro',
        'viol_confinamiento',
        'viol_pillaje',
        'viol_extorsion',
        'viol_ataque_bien_protegido',
        'viol_ataque_indiscriminado',
        'viol_despojo_tierras',
        'viol_desplazamiento_forzado',
        'viol_exilio',
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
        'dinamica_1',
        'dinamica_2',
        'dinamica_3',
        'a_consentimiento',
        'a_audio',
        'a_ficha_corta',
        'a_ficha_larga',
        'a_otros',
        'a_transcripcion_preliminar',
        'a_transcripcion_final',
        'a_retroalimentacion',
        'created_at',
        'updated_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return excel_entrevista::class;
    }
}
