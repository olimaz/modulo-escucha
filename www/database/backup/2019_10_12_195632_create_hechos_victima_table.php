<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosVictimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho_victima";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho_victima');
            $table->integer('id_hecho');
            $table->integer('id_victima');
            $table->integer('edad')->nullable();
            $table->integer('id_lugar_residencia')->nullable();
            $table->integer('id_lugar_residencia_tipo')->nullable();
            $table->string('ocupacion',200)->nullable();


            $table->index('id_hecho');
            $table->foreign('id_hecho')->references('id_hecho')->on('fichas.hecho')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_victima');
            $table->foreign('id_victima')->references('id_victima')->on('fichas.victima')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_lugar_residencia');
            $table->foreign('id_lugar_residencia')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_lugar_residencia_tipo');
            $table->foreign('id_lugar_residencia_tipo')->references('id_item')->on('catalogos.cat_item')
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
