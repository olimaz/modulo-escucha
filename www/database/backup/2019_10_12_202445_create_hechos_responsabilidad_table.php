<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosResponsabilidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho_responsabilidad";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho_responsabilidad');
            $table->integer('id_hecho');
            $table->integer('aa_id_tipo')->nullable();
            $table->integer('aa_id_subtipo')->nullable();
            $table->string('aa_nombre_grupo',200)->nullable();
            $table->string('aa_bloque',200)->nullable();
            $table->string('aa_frente',200)->nullable();
            $table->string('aa_unidad',200)->nullable();
            //
            $table->integer('tc_id_tipo')->nullable();
            $table->integer('tc_id_subtipo')->nullable();
            $table->string('tc_detalle')->nullable();
            // OTros
            $table->string('aa_otro_cual',200)->nullable();
            $table->string('tc_otro_cual',200)->nullable();
            // Otro actor
            $table->string('otro_actor_cual',200)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            ///

            $table->index('id_hecho');
            $table->foreign('id_hecho')->references('id_hecho')->on('fichas.hecho')
                ->onDelete('cascade')->onUpdate('cascade');

            //aa
            $table->index('aa_id_tipo');
            $table->foreign('aa_id_tipo')->references('id_geo')->on('catalogos.aa')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('aa_id_subtipo');
            $table->foreign('aa_id_subtipo')->references('id_geo')->on('catalogos.aa')
                ->onDelete('restrict')->onUpdate('cascade');
            //tc
            $table->index('tc_id_tipo');
            $table->foreign('tc_id_tipo')->references('id_geo')->on('catalogos.tc')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('tc_id_subtipo');
            $table->foreign('tc_id_subtipo')->references('id_geo')->on('catalogos.tc')
                ->onDelete('restrict')->onUpdate('cascade');
            //



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
