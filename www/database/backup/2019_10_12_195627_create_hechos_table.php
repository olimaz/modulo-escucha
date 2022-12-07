<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho');
            $table->integer('id_e_ind_fvt');
            $table->integer('cantidad_victimas')->default(1);
            $table->integer('id_lugar');
            $table->string('sitio_especifico',200)->nullable();
            $table->integer('id_lugar_tipo');
            $table->integer('fecha_ocurrencia_d')->nullable();
            $table->integer('fecha_ocurrencia_m')->nullable();
            $table->integer('fecha_ocurrencia_a')->nullable();
            $table->integer('fecha_fin_d')->nullable();
            $table->integer('fecha_fin_m')->nullable();
            $table->integer('fecha_fin_a')->nullable();
            $table->integer('aun_continuan')->default(2);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('id_e_ind_fvt');
            $table->foreign('id_e_ind_fvt')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_lugar');
            $table->foreign('id_lugar')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_lugar_tipo');
            $table->foreign('id_lugar_tipo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('fecha_ocurrencia_d');
            $table->index('fecha_ocurrencia_m');
            $table->index('fecha_ocurrencia_a');

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
