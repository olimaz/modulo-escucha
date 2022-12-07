<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho_responsable";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho_victima');
            $table->integer('id_hecho');
            $table->integer('id_persona_responsable');

            $table->index('id_hecho');
            $table->foreign('id_hecho')->references('id_hecho')->on('fichas.hecho')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_persona_responsable');
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
        Schema::dropIfExists($this->esquema.".".$this->tabla);
    }
}
