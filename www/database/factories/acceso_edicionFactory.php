<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\acceso_edicion;
use Faker\Generator as Faker;

$factory->define(acceso_edicion::class, function (Faker $faker) {

    return [
        'id_entrevista' => $faker->randomDigitNotNull,
        'id_subserie' => $faker->randomDigitNotNull,
        'id_autoriza' => $faker->randomDigitNotNull,
        'id_autorizado' => $faker->randomDigitNotNull,
        'observaciones' => $faker->text,
        'id_situacion' => $faker->randomDigitNotNull,
        'id_revocado' => $faker->randomDigitNotNull,
        'fh_autorizado' => $faker->date('Y-m-d H:i:s'),
        'fh_revocado' => $faker->date('Y-m-d H:i:s')
    ];
});
