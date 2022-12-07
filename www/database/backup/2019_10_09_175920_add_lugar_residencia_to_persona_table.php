<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLugarResidenciaToPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fichas.persona', function (Blueprint $table) {
            $table->integer('id_lugar_residencia_depto')->index()->nullable();
            $table->integer('id_lugar_residencia_muni')->index()->nullable();
            // $table->integer('id_lugar_residencia_vereda')->index()->nullable();
            $table->string('lugar_residencia_nombre_vereda', 100)->index()->nullable();


            $table->foreign('id_lugar_residencia_depto')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->foreign('id_lugar_residencia_muni')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            // $table->foreign('id_lugar_residencia_vereda')->references('id_geo')->on('catalogos.geo')
            //    ->onDelete('restrict')->onUpdate('cascade');                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fichas.persona', function (Blueprint $table) {
            //
        });
    }
}
