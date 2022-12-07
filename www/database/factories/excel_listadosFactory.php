<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\excel_listados;
use Faker\Generator as Faker;

$factory->define(excel_listados::class, function (Faker $faker) {

    return [
        'id_entrevistador' => $faker->randomDigitNotNull,
        'id_activo' => $faker->randomDigitNotNull,
        'id_adjunto' => $faker->randomDigitNotNull,
        'descripcion' => $faker->word,
        'cantidad_codigos_si' => $faker->randomDigitNotNull,
        'cantidad_codigos_no' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s')
    ];
});
