<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVictimaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    var $esquema="fichas";
    var $tabla="victima";
    public function up()
    {
        Schema::create($this->esquema.".".$this->tabla, function (Blueprint $table) {
            $table->increments("id_$this->tabla");
            //$table->integer('id_e_ind_fvt');
            $table->string('nombres',100)->nullable();
            $table->string('apellidos',100)->nullable();
            $table->string('nombres_otros',100)->nullable();
            $table->integer('hechos_edad')->nullable();
            $table->integer('nacimiento_lugar')->nullable();
            $table->integer('id_sexo')->comment('Catalogo 24')->nullable();
            $table->integer('id_orientacion_sexual')->comment('Catalogo 25')->nullable();
            $table->integer('id_identidad_genero')->comment('Catalogo 26')->nullable();
            $table->string('id_identidad_genero_otro',100)->comment('Catalogo 26')->nullable();
            $table->integer('id_pertenencia_etnico_racial')->comment('Catalogo 27')->nullable();
            $table->string('id_pertenencia_etnico_racial_otro',100)->comment('Catalogo 27')->nullable();
            $table->integer('id_pertenencia_indigena')->comment('Catalogo 28')->nullable();
            $table->string('id_pertenencia_indigena_otro',100)->comment('Catalogo 28')->nullable();
            $table->integer('id_tipo_documento')->comment('Catalogo 41')->nullable();
            $table->string('id_tipo_documento_otro',100)->comment('Catalogo 41')->nullable();
            $table->string('numero_documento',100)->nullable();
            $table->integer('id_nacionalidad')->comment('Catalogo 42')->nullable();
            $table->string('id_nacionalidad_otro',100)->comment('Catalogo 42')->nullable();
            $table->integer('id_nacionalidad_adicional')->comment('Catalogo 42')->nullable();
            $table->integer('id_estado_civil')->comment('Catalogo 43')->nullable();
            $table->string('id_estado_civil_otro',100)->comment('Catalogo 43')->nullable();


            $table->string('contacto_telefono',100)->nullable();
            $table->string('contacto_email',100)->nullable();
            $table->integer('id_educacion_formal')->comment('Catalogo 46')->nullable();
            $table->string('id_educacion_formal_otro',100)->comment('Catalogo 46')->nullable();
            $table->string('profesion_oficio',100)->nullable();
            $table->string('ocupacion',100)->nullable();
            $table->integer('autoridad_ejerce')->default(2)->nullable();
            $table->string('autoridad_ejerce_cual',100)->nullable();
            $table->integer('id_autoridad_etnica')->comment('Catalogo 47')->nullable();
            $table->string('id_autoridad_etnica_otro',100)->comment('Catalogo 47')->nullable();
            $table->integer('fuerza_publica_activo')->comment('Catalogo 48')->nullable();
            $table->integer('fuerza_publica_cual')->comment('Catalogo 49')->nullable();
            $table->string('fuerza_publica_especificar',100)->nullable();
            $table->integer('actor_armado_ilegal')->comment('Catalogo 50')->nullable();
            $table->integer('actor_armado_ilegal_otro')->comment('Catalogo 50')->nullable();
            $table->integer('organizacion_participa')->default(2)->nullable();

            $table->timestamps();

            //Llaves foraneas


            $table->index('nacimiento_lugar');
            $table->foreign('nacimiento_lugar')->references('id_geo')->on('catalogos.geo')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_sexo');
            $table->foreign('id_sexo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_orientacion_sexual');
            $table->foreign('id_orientacion_sexual')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_identidad_genero');
            $table->foreign('id_identidad_genero')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_pertenencia_etnico_racial');
            $table->foreign('id_pertenencia_etnico_racial')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_pertenencia_indigena');
            $table->foreign('id_pertenencia_indigena')->references('id_item')->on('catalogos.cat_item')
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



            $table->index('id_educacion_formal');
            $table->foreign('id_educacion_formal')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('id_autoridad_etnica');
            $table->foreign('id_autoridad_etnica')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('fuerza_publica_activo');
            $table->foreign('fuerza_publica_activo')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            $table->index('fuerza_publica_cual');
            $table->foreign('fuerza_publica_cual')->references('id_item')->on('catalogos.cat_item')
                ->onDelete('restrict')->onUpdate('cascade');

            //
            $table->index('nombres');
            $table->index('apellidos');
            $table->index('nombres_otros');
            $table->index('autoridad_ejerce');
            $table->index('organizacion_participa');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->esquema.".".$this->tabla)->cascade();
    }
}
