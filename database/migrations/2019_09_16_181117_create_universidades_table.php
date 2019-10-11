<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 255);
            $table->string('siglas', 15);
            $table->string('direccion', 200);
            $table->string('telefonos', 200)->nullable();
            $table->string('url_imagen', 200)->nullable();
            $table->timestamps();
        });

        $now = new \DateTime();
        DB::table('universidades')->insert(array(
            'id' => '1', 'nombre' => 'Fundación Universitaria de San Gil - UNISANGIL',
            'siglas' => 'UNISANGIL', 'direccion' => 'Km 2 vía San Gil - Charalá', 'telefonos' => '(7) 7245757 - 7246565',
            'url_imagen' => 'storage/1570649175.png', 'created_at' => $now
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universidades');
    }
}
