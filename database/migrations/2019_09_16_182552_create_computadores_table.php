<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 20);
            $table->string('descripcion', 200)->nullable();
            $table->string('observacion', 250)->nullable();
            $table->enum('estado_computador', [0, 1, 2])->default(1); //2 Ocupado, 1 activo, 0 Inactivo
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
        Schema::dropIfExists('computadores');
    }
}
