<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectorioCatalogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public.directorio_catalogo', function (Blueprint $table) {
            $table->increments('id_directorio_catalogo');
            $table->integer('id_catalogo');
            $table->string('tabla',200);
            $table->string('campo',200);
            $table->string('descripcion',200);
            $table->timestamp('created_at')->useCurrent();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public.directorio_catalogo');
    }
}
