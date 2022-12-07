<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExilioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="exilio";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_exilio');
            $table->integer('id_e_ind_fvt');
            $table->integer('id_ha_tenido_retorno')->nullable();
            $table->integer('entidad_apoyo_retorno')->nullable();
            $table->integer('id_ha_tenido_ayuda')->nullable();
            $table->string('institucion_ayuda',200)->nullable();
            $table->integer('id_retorno')->nullable();
            $table->integer('id_otro_exilio')->nullable();
            //
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            //
            $table->index('id_e_ind_fvt');
            $table->foreign('id_e_ind_fvt')->references('id_e_ind_fvt')->on('esclarecimiento.e_ind_fvt')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->index('id_ha_tenido_retorno');
            $table->index('id_ha_tenido_ayuda');
            $table->index('id_retorno');
            $table->index('id_otro_exilio');


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
