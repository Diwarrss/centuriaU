<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_documento', 6);
            $table->string('numero_documento', 20);
            $table->string('nombre1', 50);
            $table->string('nombre2', 50)->nullable();
            $table->string('apellido1', 50);
            $table->string('apellido2', 50)->nullable();
            $table->string('estado_persona', 50)->default('Activo'); //Activo, Inactivo de la matricula
            $table->string('tipo_persona', 100); //egresado, administrativo, docente, estudiante, particular o visitante,
            $table->string('programa', 255)->nullable();
            $table->string('sede', 100);
            $table->string('cargo', 255)->nullable()->comment('Ejemplo = dba, director centuria'); //dba, director centuria, docente
            $table->unsignedBigInteger('periodos_id')->comment('Se asigna el periodo actual vigente');
            $table->foreign('periodos_id')->references('id')->on('periodos');
            $table->enum('registroComo', [1, 2])->comment('Campo para colocar desde donde se registra ejm: Manual o Automatico (1 , 2)');
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
        Schema::dropIfExists('personas');
    }
}
