<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('fichas.persona_responsable', function (Blueprint $table) {
          $table->increments('id_persona_responsable');
          $table->integer('id_persona')->index();
          $table->integer('id_e_ind_fvt')->index();
          
          $table->timestamps();

          $table->foreign('id_persona')->references('id_persona')->on('fichas.persona')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('fichas.persona_responsable');
    }
}
