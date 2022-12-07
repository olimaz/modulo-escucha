<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaTestigoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     var $esquema="fichas";
     var $tabla="entrevista_testigo";
     public function up()
     {
         Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {

            $table->increments('id_entrevista_testigo');
            $table->integer('id_entrevista');
              $table->string('nombre',200);
              $table->string('contacto',200)->nullable();

            $table->timestamps();

            $table->foreign('id_entrevista')->references('id_entrevista')->on('fichas.entrevista')
                ->onDelete('cascade')->onUpdate('cascade');
                $table->index('id_entrevista');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrevista_testigo');
    }
}
