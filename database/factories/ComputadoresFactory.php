<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Computadore::class, function (Faker $faker) {
    return [
        'nombre' => Str::random(10),
        'descripcion' => Str::random(20),
        'estado_computador' => $faker->randomElement(['0', '1', '2']),
        'sedes_id' => \App\Sede::all()->random()->id,
    ];
});
