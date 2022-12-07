<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrazaCatalogoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.traza_catalogo', function (Blueprint $table) {
            $table->increments('id_traza_catalogo');
            $table->integer('id_directorio_catalogo');
            $table->integer('id_entrevistador');
            $table->integer('valor_anterior');
            $table->integer('valor_nuevo');
            $table->timestamp('created_at')->useCurrent();

            $table->index('id_directorio_catalogo');
            $table->foreign('id_directorio_catalogo')->references('id_directorio_catalogo')->on('public.directorio_catalogo')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traza_catalogo');
    }
}
