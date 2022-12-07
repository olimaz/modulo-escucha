<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileAndBioToPersonaResponsable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('fichas.persona_responsable', function (Blueprint $table) {
        $table->integer('id_edad_aproximada')->nullable();
        $table->integer('id_rango_cargo')->nullable();
        $table->integer('id_grupo_paramilitar')->nullable();
        $table->integer('id_guerrilla')->nullable();
        $table->integer('id_fuerza_publica')->nullable();
        $table->integer('id_fuerza_publica')->nullable();
        $table->integer('id_otro')->nullable();
        $table->string('nombre_superior',200)->nullable();
        $table->integer('conoce_info')->default(2);
        $table->string('que_hace',200)->nullable();
        $table->string('donde_esta',200)->nullable();
        $table->integer('otros_hechos')->default(2);
        $table->string('cuales',200)->nullable();
        $table->string('nombre_indigena',200)->nullable();



        $table->index('id_edad_aproximada');
        $table->foreign('id_edad_aproximada')->references('id_item')->on('catalogos.cat_item')
            ->onDelete('restrict')->onUpdate('cascade');

        $table->index('id_rango_cargo');
        $table->foreign('id_rango_cargo')->references('id_item')->on('catalogos.cat_item')
            ->onDelete('restrict')->onUpdate('cascade');

        $table->index('id_grupo_paramilitar');
        $table->foreign('id_grupo_paramilitar')->references('id_item')->on('catalogos.cat_item')
            ->onDelete('restrict')->onUpdate('cascade');

        $table->index('id_guerrilla');
        $table->foreign('id_guerrilla')->references('id_item')->on('catalogos.cat_item')
            ->onDelete('restrict')->onUpdate('cascade');

        $table->index('id_fuerza_publica');
        $table->foreign('id_fuerza_publica')->references('id_item')->on('catalogos.cat_item')
            ->onDelete('restrict')->onUpdate('cascade');

        $table->index('id_otro');
        $table->foreign('id_otro')->references('id_item')->on('catalogos.cat_item')
            ->onDelete('restrict')->onUpdate('cascade');


      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
