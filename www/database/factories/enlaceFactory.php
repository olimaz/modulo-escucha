<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\enlace;
use Faker\Generator as Faker;

$factory->define(enlace::class, function (Faker $faker) {

    return [
        'id_subserie' => $faker->randomDigitNotNull,
        'id_primaria' => $faker->randomDigitNotNull,
        'id_subserie_e' => $faker->randomDigitNotNull,
        'id_primaria_e' => $faker->randomDigitNotNull,
        'id_tipo' => $faker->randomDigitNotNull,
        'id_entrevistador' => $faker->randomDigitNotNull,
        'anotaciones' => $faker->text,
        'id_activo' => $faker->randomDigitNotNull,
        'fh_insert' => $faker->date('Y-m-d H:i:s')
    ];
});
