<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaCondicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     var $esquema="fichas";
     var $tabla="entrevista_condiciones";
     public function up()
     {
         Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_entrevista_condiciones');
            $table->integer('id_entrevista');
            $table->integer('id_condicion')->comment('C40');
            $table->timestamps();
            $table->index('id_entrevista');
            $table->index('id_condicion');

            $table->foreign('id_condicion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('id_entrevista')->references('id_entrevista')->on('fichas.entrevista')
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
        Schema::dropIfExists('entrevista_condiciones');
    }
}
