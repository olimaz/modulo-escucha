<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\mis_casos_entrevistador;
use Faker\Generator as Faker;

$factory->define(mis_casos_entrevistador::class, function (Faker $faker) {

    return [
        'id_mis_casos' => $faker->randomDigitNotNull,
        'id_entrevistador' => $faker->randomDigitNotNull,
        'id_perfil' => $faker->randomDigitNotNull,
        'fh_insert' => $faker->date('Y-m-d H:i:s')
    ];
});
