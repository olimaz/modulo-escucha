<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="persona";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments('id_persona');
            // $table->integer('es_victima')->default(2);
            // $table->integer('es_testigo')->default(2);
            $table->string('nombre',200)->nullable();
            $table->string('apellido',200)->nullable();
            $table->string('alias',200)->nullable(); // Nombre Indentitario, otros nombres, apodo
            $table->integer('fec_nac_a')->nullable(); //Fecha de nacimiento - anio
            $table->integer('fec_nac_m')->nullable(); //Fecha de nacimiento - mes
            $table->integer('fec_nac_d')->nullable(); //Fecha de nacimiento - dia            
            $table->integer('id_lugar_nacimiento')->nullable(); // Lugar de nacimiento
            $table->integer('id_sexo')->nullable();
            $table->integer('id_orientacion')->nullable();
            $table->integer('id_identidad')->nullable(); // Identidad de genero
            $table->integer('id_etnia')->nullable(); // Pertenencia etnico-racial
            $table->integer('id_tipo_documento')->nullable();            
            $table->string('num_documento',20)->nullable();
            $table->integer('id_nacionalidad')->nullable();
            $table->integer('id_estado_civil')->nullable();                      
            $table->integer('id_lugar_residencia')->nullable();
            $table->string('telefono',20)->nullable(); // Lugar residencia
            $table->string('correo_electronico',200)->nullable(); //
            $table->integer('id_zona')->nullable();
            $table->integer('id_edu_formal')->nullable(); // educacion formal
            $table->string('profesion', 100)->nullable();
            $table->string('ocupacion_actual', 100)->nullable();
            $table->integer('cargo_publico')->default(2); // Ejerce cargo publico
            $table->string('cargo_publico_cual', 100)->nullable();
            $table->integer('id_fuerza_publica_estado')->nullable(); // Miembro fuerza publica (Activo, Retirado)
            $table->integer('id_fuerza_publica')->nullable();
            $table->integer('id_actor_armado')->nullable();
            $table->integer('organizacion_colectivo')->default(2); //participa organizacion colectiva
            // $table->string('nombre_organizacion')->nullable(); //nombre organizacion colectiva
            $table->integer('id_discapacidad')->nullable();

            $table->timestamps();
          
            $table->index('id_edu_formal');
            $table->foreign('id_edu_formal')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_lugar_nacimiento');
            $table->foreign('id_lugar_nacimiento')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_sexo');
            $table->foreign('id_sexo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_identidad');
            $table->foreign('id_identidad')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_orientacion');
            $table->foreign('id_orientacion')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_etnia');
            $table->foreign('id_etnia')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_tipo_documento');
            $table->foreign('id_tipo_documento')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_nacionalidad');
            $table->foreign('id_nacionalidad')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_estado_civil');
            $table->foreign('id_estado_civil')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_lugar_residencia');
            $table->foreign('id_lugar_residencia')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_zona');
            $table->foreign('id_zona')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');                

            $table->index('id_fuerza_publica_estado');
            $table->foreign('id_fuerza_publica_estado')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');                

            $table->index('id_fuerza_publica');
            $table->foreign('id_fuerza_publica')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');
                
            $table->index('id_actor_armado');
            $table->foreign('id_actor_armado')->references('id_item')->on('catalogos.cat_item')
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
