<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaEntrevistadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas.persona_entrevistada', function (Blueprint $table) {
            $table->increments('id_persona_entrevistada');
            $table->integer('id_persona');
            $table->integer('id_e_ind_fvt');
            $table->integer('es_victima')->default(2);
            $table->integer('es_testigo')->default(2);
            $table->timestamps();

            $table->unique(['id_persona', 'id_e_ind_fvt']);

            $table->index('id_persona');
            $table->foreign('id_persona')->references('id_persona')->on('fichas.persona')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');


            $table->index('id_e_ind_fvt');
            $table->foreign('id_e_ind_fvt')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                ->onDelete('cascade')
                ->onUpdate('cascade');                  


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichas.persona_entrevistada');
    }
}
