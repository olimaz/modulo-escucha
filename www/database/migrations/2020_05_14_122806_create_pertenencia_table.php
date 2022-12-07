<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePertenenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas.pertenencia', function (Blueprint $table) {
            $table->increments('id_pertenencia');

            $table->integer('id_e_ind_fvt')->nullable();
            $table->index('id_e_ind_fvt');
            $table->foreign('id_e_ind_fvt')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('id_lugar')->nullable();
            $table->index('id_lugar');
            $table->foreign('id_lugar')->references('id_geo')->on('catalogos.geo')
            ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('fecha_v_d')->nullable(); //Fecha vinculación
            $table->integer('fecha_v_m')->nullable();
            $table->integer('fecha_v_a')->nullable();

            $table->integer('fecha_r_d')->nullable(); //Fecha retiro
            $table->integer('fecha_r_m')->nullable();
            $table->integer('fecha_r_a')->nullable();

            $table->integer('edad_v')->nullable(); //Edad vinculación
            $table->integer('edad_r')->nullable(); //Edad retiro

            $table->string('rango_v',100)->nullable(); //Rango vinculación
            $table->string('rango_r',100)->nullable(); //Rango retiro

            $table->integer('id_fuerza_publica')->nullable();
            $table->integer('id_guerrilla')->nullable();
            $table->integer('id_grupo_paramilitar')->nullable();
            $table->integer('id_como_ingreso')->nullable();
            $table->integer('id_porque_ingreso')->nullable();
            $table->integer('id_experiencia_intrafilas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichas.pertenencia');
    }
}
