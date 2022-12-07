<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaDiscapacidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="persona_discapacidad";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_persona_discapacidad');
            $table->integer('id_persona');
            $table->integer('id_discapacidad')->comment('C44');            
            $table->timestamps();


            $table->index('id_persona');
            $table->foreign('id_persona')->references('id_persona')->on('fichas.persona')
                ->onDelete('cascade')->onUpdate('cascade'); 

            $table->index('id_discapacidad');
            $table->foreign('id_discapacidad')->references('id_item')->on('catalogos.cat_item')
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
