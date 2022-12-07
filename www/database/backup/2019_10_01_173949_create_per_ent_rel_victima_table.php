<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerEntRelVictimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas.per_ent_rel_victima', function (Blueprint $table) {
            $table->increments('id_per_ent_rel_victima');
            $table->integer('id_persona_entrevistada');
            $table->integer('id_rel_victima')->comment('C51');

            $table->timestamps();

            $table->index('id_persona_entrevistada');
            $table->foreign('id_persona_entrevistada')->references('id_persona_entrevistada')->on('fichas.persona_entrevistada')
                ->onDelete('cascade')
                ->onUpdate('cascade'); 


            $table->index('id_rel_victima');
            $table->foreign('id_rel_victima')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')
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
        Schema::dropIfExists('fichas.per_ent_rel_victima');
    }
}
