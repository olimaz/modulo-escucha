<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExilioCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="exilio_categoria";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_exilio_categoria');
            $table->integer('id_exilio');
            $table->integer('id_categoria');
            //
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //
            $table->index('id_exilio');
            $table->foreign('id_exilio')->references('id_exilio')->on('fichas.exilio')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_categoria');
            $table->foreign('id_categoria')->references('id_item')->on('catalogos.cat_item')
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
