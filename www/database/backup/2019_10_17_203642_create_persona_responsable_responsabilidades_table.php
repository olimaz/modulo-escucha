<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaResponsableResponsabilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     var $esquema="fichas";
     var $tabla="persona_responsable_responsabilidades";
     public function up()
     {
         Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_persona_responsable_responsabilidades');
            $table->integer('id_persona_responsable');
            $table->integer('id_responsabilidad')->comment('C36');
            $table->timestamps();
            $table->index('id_persona_responsable');
            $table->index('id_responsabilidad');

            $table->foreign('id_responsabilidad')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('id_persona_responsable')->references('id_persona_responsable')->on('fichas.persona_responsable')
                ->onDelete('cascade')->onUpdate('cascade');


        });
     }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona_responsable_responsabilidades');
    }
}
