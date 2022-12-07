<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVictimaDuplicadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas.victima_duplicada', function (Blueprint $table) {
            $table->increments('id_victima_duplicada');
            $table->integer('id_victima')->index();
            $table->integer('id_e_inv_fvt_nueva');
            $table->integer('id_e_inv_fvt_existente');
            $table->boolean('estado')->default(true); // true: pendiente, false. cerrado
            $table->timestamps();

            $table->foreign('id_victima')->references('id_victima')->on('fichas.victima')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');

            $table->foreign('id_e_inv_fvt_nueva')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');

            $table->foreign('id_e_inv_fvt_existente')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');                   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichas.victima_duplicada');
    }
}
