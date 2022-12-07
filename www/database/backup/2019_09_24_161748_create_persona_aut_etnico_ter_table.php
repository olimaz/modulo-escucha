<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaAutEtnicoTerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="persona_aut_etnico_ter";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_persona_aut_etnico_ter');
            $table->integer('id_persona');
            $table->integer('id_aut_etnico_ter')->comment('C47');
            $table->timestamps();

            $table->index('id_persona');
            $table->foreign('id_persona')->references('id_persona')->on('fichas.persona')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_aut_etnico_ter');
            $table->foreign('id_aut_etnico_ter')->references('id_item')->on('catalogos.cat_item')
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
        Schema::dropIfExists($this->esquema.".".$this->tabla);
    }
}
