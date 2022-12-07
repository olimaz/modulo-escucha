<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtraNacionalidadToPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fichas.persona', function (Blueprint $table) {
            
            $table->integer('id_otra_nacionalidad')->nullable();
            $table->index('id_otra_nacionalidad');
            $table->foreign('id_otra_nacionalidad')->references('id_item')->on('catalogos.cat_item')
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
