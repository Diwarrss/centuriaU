<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email', 200)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('estado_user', [1, 0])->default(1); //1 activo, 0 Inactivo
            $table->rememberToken();
            $table->unsignedBigInteger('roles_id')->default(1);
            $table->foreign('roles_id')->references('id')->on('roles');
            $table->unsignedBigInteger('sedes_id')->nullable();
            $table->foreign('sedes_id')->references('id')->on('sedes');
            $table->timestamps();
        });

        $password = Hash::make('123456789');

        //inserto a la tabla datos registros
        DB::table('users')->insert(array(
            'id' => '1', 'name' => 'SUPERADMIN', 'email' => 'dialvaro30@gmail.com', 'email_verified_at' => null, 'password' => $password,
            'estado_user' => 1, 'roles_id' => 1, 'sedes_id' => null
        ));

        DB::table('users')->insert(array(
            'id' => '2', 'name' => 'ADMIN SAN GIL', 'email' => 'dialvaro31@gmail.com', 'email_verified_at' => null, 'password' => $password,
            'estado_user' => 1, 'roles_id' => 2, 'sedes_id' => 1
        ));

        DB::table('users')->insert(array(
            'id' => '3', 'name' => 'ADMIN YOPAL', 'email' => 'dialvaro32@gmail.com', 'email_verified_at' => null, 'password' => $password,
            'estado_user' => 1, 'roles_id' => 2, 'sedes_id' => 3
        ));

        DB::table('users')->insert(array(
            'id' => '4', 'name' => 'ADMIN CHIQUI', 'email' => 'dialvaro33@gmail.com', 'email_verified_at' => null, 'password' => $password,
            'estado_user' => 1, 'roles_id' => 2, 'sedes_id' => 2
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
