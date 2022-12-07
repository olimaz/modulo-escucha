<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaOrganizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas.persona_organizacion', function (Blueprint $table) {
            $table->increments('id_persona_organizacion');            
            $table->integer('id_persona');
            $table->string('nombre', 100)->nullable();
            $table->string('rol', 30)->nullable();
            $table->integer('id_tipo_organizacion')->comment('C51');             
            $table->timestamps();


            $table->index('id_persona');
            $table->foreign('id_persona')->references('id_persona')->on('fichas.persona')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_tipo_organizacion');
            $table->foreign('id_tipo_organizacion')->references('id_item')->on('catalogos.cat_item')
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
        Schema::dropIfExists('fichas.persona_organizacion');
    }
}
