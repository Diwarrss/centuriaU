<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('estado_prestamo', [1, 0])->default(1); //1 , 0  = 1 Actualmente prestado el equipo Activo; 0 Equipo ya entregado Finalizado
            $table->string('observacion', 250)->nullable();
            $table->unsignedBigInteger('users_id')->comment('Usuario quien registra el prestamo');
            $table->foreign('users_id')->references('id')->on('users');
            $table->unsignedBigInteger('computadores_id')->comment('Computador que se presta');
            $table->foreign('computadores_id')->references('id')->on('computadores');
            $table->unsignedBigInteger('ingresos_id')->comment('Ingresos del día actual');
            $table->foreign('ingresos_id')->references('id')->on('ingresos');
            $table->unsignedBigInteger('sedes_id')->default(1);
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
        Schema::dropIfExists('prestamos');
    }
}
