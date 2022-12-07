<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\mis_casos_adjunto_compartir;
use Faker\Generator as Faker;

$factory->define(mis_casos_adjunto_compartir::class, function (Faker $faker) {

    return [
        'id_mis_casos_adjunto_compartir' => $faker->randomDigitNotNull,
        'id_mis_casos_adjunto' => $faker->randomDigitNotNull,
        'id_autorizador' => $faker->randomDigitNotNull,
        'id_autorizado' => $faker->randomDigitNotNull,
        'anotaciones' => $faker->text,
        'id_situacion' => $faker->randomDigitNotNull,
        'fh_autorizado' => $faker->date('Y-m-d H:i:s'),
        'fh_revocado' => $faker->date('Y-m-d H:i:s')
    ];
});
