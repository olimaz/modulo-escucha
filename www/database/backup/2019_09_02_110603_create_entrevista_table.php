<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="entrevista";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_entrevista');
            $table->integer('id_e_ind_fvt');
            $table->integer('id_idioma');
            $table->integer('id_nativo')->nullable();
            $table->string('nombre_interprete',200)->nullable();
            $table->integer('documentacion_aporta')->default(2);
            $table->text('documentacion_especificar')->nullable();
            $table->integer('identifica_testigos')->default(2);
            $table->integer('ampliar_relato')->default(2);
            $table->text('ampliar_relato_temas')->nullable();
            $table->integer('priorizar_entrevista')->default(2);
            $table->text('priorizar_entrevista_asuntos')->nullable();
            $table->integer('contiene_patrones')->default(2);
            $table->text('contiene_patrones_cuales')->nullable();
            $table->text('indicaciones_transcripcion')->nullable();
            $table->text('observaciones')->nullable();

            //CONSENTIMIENTO INFORMADO
            $table->string('identificacion_consentimiento',100)->nullable();
            $table->integer('conceder_entrevista')->default(2);
            $table->integer('grabar_audio')->default(2);
            $table->integer('elaborar_informe')->default(2);
            $table->integer('tratamiento_datos_analizar')->default(2);
            $table->integer('tratamiento_datos_analizar_sensible')->default(2);
            $table->integer('tratamiento_datos_utilizar')->default(2);
            $table->integer('tratamiento_datos_utilizar_sensible')->default(2);
            $table->integer('tratamiento_datos_publicar')->default(2);
            //
            $table->timestamps();
            //Llaves foraneas
            $table->index('id_e_ind_fvt');
            $table->foreign('id_e_ind_fvt')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_idioma');
            $table->foreign('id_idioma')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_nativo');
            $table->foreign('id_nativo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            //Otros indices
            $table->index('documentacion_aporta');
            $table->index('identifica_testigos');
            $table->index('ampliar_relato');
            $table->index('priorizar_entrevista');
            $table->index('contiene_patrones');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->esquema.".".$this->tabla);
    }
}
