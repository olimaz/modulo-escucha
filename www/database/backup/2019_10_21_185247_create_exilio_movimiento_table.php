<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExilioMovimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="exilio_movimiento";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_exilio_movimiento');
            $table->integer('id_exilio');
            $table->integer('id_tipo_movimiento')->comment('Criterio fijo 30');
            $table->integer('fecha_salida_d')->default(0);
            $table->integer('fecha_salida_m')->default(0);
            $table->integer('fecha_salida_a')->default(0);
            $table->integer('id_lugar_salida')->nullable();
            $table->string('salida_pais',200)->nullable();
            $table->string('salida_estado',200)->nullable();
            $table->string('salida_ciudad',200)->nullable();
            $table->integer('fecha_llegada_d')->default(0);
            $table->integer('fecha_llegada_m')->default(0);
            $table->integer('fecha_llegada_a')->default(0);
            $table->integer('id_lugar_llegada')->nullable();
            $table->string('llegada_pais',200)->nullable();
            $table->string('llegada_estado',200)->nullable();
            $table->string('llegada_ciudad',200)->nullable();
            $table->string('llegada_2_pais',200)->nullable();
            $table->string('llegada_2_estado',200)->nullable();
            $table->string('llegada_2_ciudad',200)->nullable();
            $table->integer('fecha_asentamiento_d')->default(0);
            $table->integer('fecha_asentamiento_m')->default(0);
            $table->integer('fecha_asentamiento_a')->default(0);
            $table->integer('id_modalidad');
            $table->integer('cant_personas_salieron')->default(0);
            $table->integer('cant_personas_familia_salieron')->default(0);
            $table->integer('cant_personas_familia_quedaron')->default(0);
            //
            $table->integer('id_solicitado_proteccion')->nullable();
            $table->integer('id_estado_proteccion')->nullable();
            $table->integer('id_aprobada_proteccion')->nullable();
            $table->integer('id_denegada_proteccion')->nullable();
            $table->integer('id_residencia_proteccion')->nullable();
            $table->integer('id_expulsion');

            //
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //
            $table->index('id_tipo_movimiento');
            $table->index('id_exilio');
            $table->foreign('id_exilio')->references('id_exilio')->on('fichas.exilio')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_modalidad');
            $table->foreign('id_modalidad')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_lugar_salida');
            $table->foreign('id_lugar_salida')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_lugar_llegada');
            $table->foreign('id_lugar_llegada')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');


            $table->index('id_solicitado_proteccion');
            $table->foreign('id_solicitado_proteccion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_estado_proteccion');
            $table->foreign('id_estado_proteccion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_aprobada_proteccion');
            $table->foreign('id_aprobada_proteccion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_denegada_proteccion');
            $table->foreign('id_denegada_proteccion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_residencia_proteccion');
            $table->foreign('id_residencia_proteccion')->references('id_item')->on('catalogos.cat_item')
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
