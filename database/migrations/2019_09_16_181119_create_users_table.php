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
            $table->unsignedBigInteger('sedes_id')->default(1)->nullable();
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
        Schema::dropIfExists('users');
    }
}
