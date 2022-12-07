<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\desclasificar;
use Faker\Generator as Faker;

$factory->define(desclasificar::class, function (Faker $faker) {

    return [
        'id_autorizador' => $faker->randomDigitNotNull,
        'id_autorizado' => $faker->randomDigitNotNull,
        'id_subserie' => $faker->randomDigitNotNull,
        'id_primaria' => $faker->randomDigitNotNull,
        'fh_insert' => $faker->date('Y-m-d H:i:s'),
        'id_activo' => $faker->randomDigitNotNull,
        'id_denegador' => $faker->randomDigitNotNull,
        'fh_update' => $faker->date('Y-m-d H:i:s'),
        'fh_del' => $faker->date('Y-m-d H:i:s'),
        'fh_al' => $faker->date('Y-m-d H:i:s'),
        'id_adjunto' => $faker->randomDigitNotNull
    ];
});
