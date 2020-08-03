<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCenturiaBdAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centuria_bd_accesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cargo')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('estado')->nullable();
            $table->string('maac_fechamatricula')->nullable();
            $table->string('matriculaestado')->nullable();
            $table->string('pege_documentoidentidad');
            $table->string('peng_primerapellido');
            $table->string('peng_primernombre');
            $table->string('peng_segundoapellido')->nullable();
            $table->string('peng_segundonombre')->nullable();
            $table->string('programa')->nullable();
            $table->string('tidg_abreviatura')->nullable();
            $table->string('tidg_id')->nullable();
            $table->string('tipo_persona')->nullable();
            $table->string('tipoestudiante')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centuria_bd_accesses');
    }
}
