<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdLugarNacimientoDeptoToPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fichas.persona', function (Blueprint $table) {
            $table->integer('id_lugar_nacimiento_depto')->index()->nullable();
            $table->foreign('id_lugar_nacimiento_depto')->references('id_geo')->on('catalogos.geo')
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
        Schema::table('fichas.persona', function (Blueprint $table) {
            //
        });
    }
}
