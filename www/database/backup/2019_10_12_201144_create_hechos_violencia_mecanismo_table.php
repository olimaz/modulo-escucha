<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosViolenciaMecanismoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho_violencia_mecanismo";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho_violencia_mecanismo');
            $table->integer('id_hecho_violencia');
            $table->integer('id_mecanismo');
            $table->timestamps();

            $table->index('id_hecho_violencia');
            $table->foreign('id_hecho_violencia')->references('id_hecho_violencia')->on('fichas.hecho_violencia')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_mecanismo');
            $table->foreign('id_mecanismo')->references('id_item')->on('catalogos.cat_item')
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
