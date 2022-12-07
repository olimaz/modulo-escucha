<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposAuditoriaFichasToPersonaCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fichas.persona', function (Blueprint $table) {
            
            $table->integer('insert_ent')->nullable();
            $table->string('insert_ip', 100)->nullable();
            $table->timestamp('insert_fh')->nullable();

            $table->integer('update_ent')->nullable();
            $table->string('update_ip', 100)->nullable();
            $table->timestamp('update_fh')->nullable();            
        });

        Schema::table('fichas.victima', function (Blueprint $table) {
            
            $table->integer('insert_ent')->nullable();
            $table->string('insert_ip', 100)->nullable();
            $table->timestamp('insert_fh')->nullable();

            $table->integer('update_ent')->nullable();
            $table->string('update_ip', 100)->nullable();
            $table->timestamp('update_fh')->nullable();            
        });        

        Schema::table('fichas.persona_entrevistada', function (Blueprint $table) {
            
            $table->integer('insert_ent')->nullable();
            $table->string('insert_ip', 100)->nullable();
            $table->timestamp('insert_fh')->nullable();

            $table->integer('update_ent')->nullable();
            $table->string('update_ip', 100)->nullable();
            $table->timestamp('update_fh')->nullable();            
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
            Schema::dropColumn('insert_ent');
            Schema::dropColumn('insert_ip');
            Schema::dropColumn('insert_fh');

            Schema::dropColumn('update_ent');
            Schema::dropColumn('update_ip');
            Schema::dropColumn('update_fh');

        });

        Schema::table('fichas.victima', function (Blueprint $table) {
            Schema::dropColumn('insert_ent');
            Schema::dropColumn('insert_ip');
            Schema::dropColumn('insert_fh');

            Schema::dropColumn('update_ent');
            Schema::dropColumn('update_ip');
            Schema::dropColumn('update_fh');
        });
        
        Schema::table('fichas.persona_entrevistada', function (Blueprint $table) {
            Schema::dropColumn('insert_ent');
            Schema::dropColumn('insert_ip');
            Schema::dropColumn('insert_fh');

            Schema::dropColumn('update_ent');
            Schema::dropColumn('update_ip');
            Schema::dropColumn('update_fh');
        });        
    }
}
