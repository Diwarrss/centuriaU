<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 100);
            $table->string('descripcion', 255);
            $table->timestamps();
        });

        $now = new \DateTime();

        //inserto a la tabla datos registros
        DB::table('roles')->insert(array('id' => '1', 'nombre' => 'Superadmin', 'descripcion' => 'Usuario que se encarga del control total de todas las sedes.', 'created_at' => $now));
        DB::table('roles')->insert(array('id' => '2', 'nombre' => 'Administrador', 'descripcion' => 'Usuario que se encarga del control total de una sede especifica.', 'created_at' => $now));
        DB::table('roles')->insert(array('id' => '3', 'nombre' => 'Ingreso', 'descripcion' => 'Usuario para registrar los ingresos y prestamos', 'created_at' => $now));
        DB::table('roles')->insert(array('id' => '4', 'nombre' => 'Consulta', 'descripcion' => 'Usuario de solo consulta reportes etc.', 'created_at' => $now));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
