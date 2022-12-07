<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExcel3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="esclarecimiento";
    var $tabla="excel_entrevista_fvt";
    public function up()
    {
        Schema::dropIfExists($this->esquema.'.'.$this->tabla);
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {

            $table->integer('id_e_ind_fvt')->nullable();
            $table->integer('correlativo')->nullable()->nullable();
            $table->text('codigo_entrevista')->nullable()->nullable();
            $table->text('codigo_entrevistador')->nullable();
            $table->integer('macroterritorio_id')->nullable();
            $table->text('macroterritorio_txt')->nullable();
            $table->integer('territorio_id')->nullable();
            $table->text('territorio_txt')->nullable();
            $table->integer('grupo_id')->nullable();
            $table->text('grupo_txt')->nullable();
            $table->text('entrevista_fecha')->nullable();
            $table->text('entrevista_lugar_n1_codigo')->nullable();
            $table->text('entrevista_lugar_n1_txt')->nullable();
            $table->text('entrevista_lugar_n2_codigo')->nullable();
            $table->text('entrevista_lugar_n2_txt')->nullable();
            $table->text('entrevista_lugar_n3_codigo')->nullable();
            $table->text('entrevista_lugar_n3_txt')->nullable();
            $table->text('titulo')->nullable();
            $table->text('hechos_lugar_n1_codigo')->nullable();
            $table->text('hechos_lugar_n1_txt')->nullable();
            $table->text('hechos_lugar_n2_codigo')->nullable();
            $table->text('hechos_lugar_n2_txt')->nullable();
            $table->text('hechos_lugar_n3_codigo')->nullable();
            $table->text('hechos_lugar_n3_txt')->nullable();
            $table->text('hechos_del')->nullable();
            $table->text('hechos_al')->nullable();
            $table->text('anotaciones')->nullable();
            $table->integer('es_prioritario')->default(0)->nullable();
            $table->text('prioritario_tema')->nullable();
            $table->text('sector_victima')->nullable();
            $table->text('interes_etnico')->nullable();
            $table->text('remitido')->nullable();
            $table->text('transcrita')->nullable();
            $table->integer('aa_paramilitar')->default(0)->nullable();
            $table->integer('aa_guerrilla')->default(0)->nullable();
            $table->integer('aa_fuerza_publica')->default(0)->nullable();
            $table->integer('aa_terceros_civiles')->default(0)->nullable();
            $table->integer('aa_otro_grupo_armado')->default(0)->nullable();
            $table->integer('aa_otro_agente_estado')->default(0)->nullable();
            $table->integer('aa_otro_actor')->default(0)->nullable();
            $table->integer('aa_ns_nr')->default(0)->nullable();
            $table->integer('aa_internacional')->default(0)->nullable();
            $table->integer('viol_homicidio')->default(0)->nullable();
            $table->integer('viol_atentado_vida')->default(0)->nullable();
            $table->integer('viol_amenaza_vida')->default(0)->nullable();
            $table->integer('viol_desaparicion_f')->default(0)->nullable();
            $table->integer('viol_tortura')->default(0)->nullable();
            $table->integer('viol_violencia_sexual')->default(0)->nullable();
            $table->integer('viol_esclavitud')->default(0)->nullable();
            $table->integer('viol_reclutamiento')->default(0)->nullable();
            $table->integer('viol_detencion_arbitraria')->default(0)->nullable();
            $table->integer('viol_secuestro')->default(0)->nullable();
            $table->integer('viol_confinamiento')->default(0)->nullable();
            $table->integer('viol_pillaje')->default(0)->nullable();
            $table->integer('viol_extorsion')->default(0)->nullable();
            $table->integer('viol_ataque_bien_protegido')->default(0)->nullable();
            $table->integer('viol_ataque_indiscriminado')->default(0)->nullable();
            $table->integer('viol_despojo_tierras')->default(0)->nullable();
            $table->integer('viol_desplazamiento_forzado')->default(0)->nullable();
            $table->integer('viol_exilio')->default(0)->nullable();
            $table->integer('i_objetivo_esclarecimiento')->default(0)->nullable();
            $table->integer('i_objetivo_reconocimiento')->default(0)->nullable();
            $table->integer('i_objetivo_convivencia')->default(0)->nullable();
            $table->integer('i_objetivo_no_repeticion')->default(0)->nullable();
            $table->integer('i_enfoque_genero')->default(0)->nullable();
            $table->integer('i_enfoque_psicosocial')->default(0)->nullable();
            $table->integer('i_enfoque_curso_vida')->default(0)->nullable();
            $table->integer('i_direccion_investigacion')->default(0)->nullable();
            $table->integer('i_direccion_territorios')->default(0)->nullable();
            $table->integer('i_direccion_etnica')->default(0)->nullable();
            $table->integer('i_comisionados')->default(0)->nullable();
            $table->integer('i_estrategia_arte')->default(0)->nullable();
            $table->integer('i_estrategia_comunicacion')->default(0)->nullable();
            $table->integer('i_estrategia_participacion')->default(0)->nullable();
            $table->integer('i_estrategia_pedagogia')->default(0)->nullable();
            $table->integer('i_grupo_acceso_informacion')->default(0)->nullable();
            $table->integer('i_presidencia')->default(0)->nullable();
            $table->integer('i_otra')->default(0)->nullable();
            $table->integer('i_enlace')->default(0)->nullable();
            $table->integer('i_sistema_informacion')->default(0)->nullable();
            $table->integer('ia_pueblo_etnico')->default(0)->nullable();
            $table->integer('ia_dialogo_social')->default(0)->nullable();
            $table->integer('ia_genero')->default(0)->nullable();
            $table->integer('ia_enfoque_ps')->default(0)->nullable();
            $table->integer('ia_curso_vida')->default(0)->nullable();
            $table->integer('nucleo_01')->default(0)->nullable();
            $table->integer('nucleo_02')->default(0)->nullable();
            $table->integer('nucleo_03')->default(0)->nullable();
            $table->integer('nucleo_04')->default(0)->nullable();
            $table->integer('nucleo_05')->default(0)->nullable();
            $table->integer('nucleo_06')->default(0)->nullable();
            $table->integer('nucleo_07')->default(0)->nullable();
            $table->integer('nucleo_08')->default(0)->nullable();
            $table->integer('nucleo_09')->default(0)->nullable();
            $table->integer('nucleo_10')->default(0)->nullable();
            $table->integer('mandato_01')->default(0)->nullable();
            $table->integer('mandato_02')->default(0)->nullable();
            $table->integer('mandato_03')->default(0)->nullable();
            $table->integer('mandato_04')->default(0)->nullable();
            $table->integer('mandato_05')->default(0)->nullable();
            $table->integer('mandato_06')->default(0)->nullable();
            $table->integer('mandato_07')->default(0)->nullable();
            $table->integer('mandato_08')->default(0)->nullable();
            $table->integer('mandato_09')->default(0)->nullable();
            $table->integer('mandato_10')->default(0)->nullable();
            $table->integer('mandato_11')->default(0)->nullable();
            $table->integer('mandato_12')->default(0)->nullable();
            $table->integer('mandato_13')->default(0)->nullable();
            $table->text('dinamica_1')->nullable();
            $table->text('dinamica_2')->nullable();
            $table->text('dinamica_3')->nullable();
            $table->text('a_consentimiento')->default(0)->nullable();
            $table->text('a_audio')->default(0)->nullable();
            $table->text('a_ficha_corta')->default(0)->nullable();
            $table->text('a_ficha_larga')->default(0)->nullable();
            $table->text('a_otros')->default(0)->nullable();
            $table->text('a_transcripcion_preliminar')->default(0)->nullable();
            $table->text('a_transcripcion_final')->default(0)->nullable();
            $table->text('a_retroalimentacion')->default(0)->nullable();
            //
            $table->float('entrevista_lat')->nullable();
            $table->float('entrevista_lon')->nullable();
            $table->float('hechos_lat')->nullable();
            $table->float('hechos_lon')->nullable();
            $table->text('transcripcion_html')->nullable();
            //
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            //
            $table->primary('id_e_ind_fvt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->esquema.'.'.$this->tabla);
    }
}
