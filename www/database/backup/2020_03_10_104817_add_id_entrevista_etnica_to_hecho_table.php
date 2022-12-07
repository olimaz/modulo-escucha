<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdEntrevistaEtnicaToHechoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fichas.hecho', function (Blueprint $table) {
            
            $table->integer('id_entrevista_etnica')->nullable();
            $table->integer('id_e_ind_fvt')->nullable()->change();

            $table->foreign('id_entrevista_etnica')->references('id_entrevista_etnica')->on('esclarecimiento.entrevista_etnica')
                   ->onDelete('restrict')
                   ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fichas.hecho', function (Blueprint $table) {
            //
        });
    }
}
