<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\censo_archivos_permisos;
use Faker\Generator as Faker;

$factory->define(censo_archivos_permisos::class, function (Faker $faker) {

    return [
        'id_censo_archivos' => $faker->randomDigitNotNull,
        'id_entrevistador' => $faker->randomDigitNotNull,
        'id_perfil' => $faker->randomDigitNotNull,
        'fh_insert' => $faker->date('Y-m-d H:i:s')
    ];
});
