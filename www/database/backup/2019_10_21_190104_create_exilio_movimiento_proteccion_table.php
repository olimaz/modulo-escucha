<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExilioMovimientoProteccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="exilio_movimiento_proteccion";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_exilio_movimiento_proteccion');
            $table->integer('id_exilio_movimiento');
            $table->integer('id_proteccion');
            //
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //
            $table->index('id_exilio_movimiento');
            $table->foreign('id_exilio_movimiento')->references('id_exilio_movimiento')->on('fichas.exilio_movimiento')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_proteccion');
            $table->foreign('id_proteccion')->references('id_item')->on('catalogos.cat_item')
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
