<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosViolenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho_violencia";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho_violencia');
            $table->integer('id_hecho');
            $table->integer('id_tipo_violencia');
            $table->integer('id_subtipo_violencia');
            $table->string('otro_cual',200)->nullable();

            //Masacre
            $table->integer('cantidad_muertos')->nullable();
            //Acotaciones de varias violencias
            $table->integer('id_individual_colectiva')->nullable();
            $table->integer('id_frente_otros')->nullable();
            $table->integer('id_cometido_varios')->nullable();
            $table->integer('id_hubo_embarazo')->nullable();
            $table->integer('id_hubo_nacimiento')->nullable();
            $table->integer('id_ind_fam_col')->nullable();
            //Despojo
            $table->integer('despojo_hectareas')->nullable();
            $table->integer('despojo_recupero_tierras')->nullable();
            $table->integer('despojo_recupero_derechos')->nullable();
            //Desplazamiento
            $table->integer('id_lugar_salida')->nullable();
            $table->integer('id_lugar_llegada')->nullable();
            $table->integer('id_lugar_llegada_tipo')->nullable();
            $table->integer('id_sentido_desplazamiento')->nullable();
            $table->integer('id_tuvo_retorno')->nullable();
            $table->integer('id_tuvo_retorno_tipo')->nullable();
            $table->integer('id_lugar_llegada_2')->nullable();
            $table->integer('id_lugar_llegada_2_tipo')->nullable();
            $table->integer('id_sentido_desplazamiento_2')->nullable();
            $table->integer('id_tuvo_otros_desplazamientos')->nullable();
            ///
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            ///
            $table->index('id_hecho');
            $table->foreign('id_hecho')->references('id_hecho')->on('fichas.hecho')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_tipo_violencia');
            $table->foreign('id_tipo_violencia')->references('id_geo')->on('catalogos.violencia')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_subtipo_violencia');
            $table->foreign('id_subtipo_violencia')->references('id_geo')->on('catalogos.violencia')
                ->onDelete('cascade')->onUpdate('cascade');
            //Acotaciones comunes
            $table->index('id_individual_colectiva');
            $table->index('id_frente_otros');
            $table->index('id_cometido_varios');
            $table->index('id_hubo_embarazo');
            $table->index('id_hubo_nacimiento');
            $table->index('id_ind_fam_col');
            //Desplazamiento
            $table->index('id_lugar_salida');
            $table->foreign('id_lugar_salida')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_lugar_llegada');
            $table->foreign('id_lugar_llegada')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_lugar_llegada_tipo');
            $table->foreign('id_lugar_llegada_tipo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_sentido_desplazamiento');
            $table->foreign('id_sentido_desplazamiento')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_tuvo_retorno');
            $table->index('id_tuvo_retorno_tipo');
            $table->foreign('id_tuvo_retorno_tipo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_lugar_llegada_2');
            $table->foreign('id_lugar_llegada_2')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_lugar_llegada_2_tipo');
            $table->foreign('id_lugar_llegada_2_tipo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_sentido_desplazamiento_2');
            $table->foreign('id_sentido_desplazamiento_2')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_tuvo_otros_desplazamientos');

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
