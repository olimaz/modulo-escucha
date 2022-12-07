<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaJusticiaNoSirveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="entrevista_justicia_no_sirve";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_entrevista_justicia');
            $table->integer('id_e_ind_fvt');
            $table->integer('id_institucion');
            $table->integer('id_porque');
            $table->integer('id_objetivo');
            //VAlores opcionales
            $table->string('transgeneracionales',200)->null();
            $table->string('afrentamiento_proceso',200)->null();
            //
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //
            $table->index('id_e_ind_fvt');
            $table->foreign('id_e_ind_fvt')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_institucion');
            $table->foreign('id_institucion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_porque');
            $table->foreign('id_porque')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
            $table->index('id_objetivo');
            $table->foreign('id_objetivo')->references('id_item')->on('catalogos.cat_item')
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
