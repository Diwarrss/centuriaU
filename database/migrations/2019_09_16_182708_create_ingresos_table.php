<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('personas_id')->comment('Persona que se registra al ingresar');
            $table->foreign('personas_id')->references('id')->on('personas');
            $table->unsignedBigInteger('periodos_id')->comment('Periodo de registro');
            $table->foreign('periodos_id')->references('id')->on('periodos');
            $table->unsignedBigInteger('users_id')->comment('Usuario quien registra el ingreso');
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('sedes_id');
            $table->foreign('sedes_id')->references('id')->on('sedes');
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
        Schema::dropIfExists('ingresos');
    }
}
