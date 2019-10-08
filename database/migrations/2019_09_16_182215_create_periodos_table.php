<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 150)->unique();
            $table->string('descripcion', 200)->nullable();
            $table->enum('estado_periodo', [1, 0])->default(1); //1 activo, 0 Inactivo
            $table->unsignedBigInteger('universidad_id')->default(1);
            $table->foreign('universidad_id')->references('id')->on('universidades');
            $table->timestamps();
        });

        DB::table('periodos')->insert(array(
            'id' => '1', 'nombre' => '2019-2', 'estado_periodo' => 1, 'universidad_id' => 1
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
    }
}
