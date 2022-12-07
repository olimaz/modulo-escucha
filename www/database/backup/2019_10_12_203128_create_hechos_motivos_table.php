<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHechosMotivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="hecho_contexto";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_hecho_contexto');
            $table->integer('id_hecho');
            $table->integer('id_contexto');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //
            $table->index('id_hecho');
            $table->foreign('id_hecho')->references('id_hecho')->on('fichas.hecho')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_contexto');
            $table->foreign('id_contexto')->references('id_item')->on('catalogos.cat_item')
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
