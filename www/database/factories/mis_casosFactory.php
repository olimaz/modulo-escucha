<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\mis_casos;
use Faker\Generator as Faker;

$factory->define(mis_casos::class, function (Faker $faker) {

    return [
        'id_macroterritorio' => $faker->randomDigitNotNull,
        'id_territorio' => $faker->randomDigitNotNull,
        'id_entrevistador' => $faker->randomDigitNotNull,
        'entrevista_correlativo' => $faker->randomDigitNotNull,
        'entrevista_numero' => $faker->randomDigitNotNull,
        'entrevista_codigo' => $faker->word,
        'nombre' => $faker->text,
        'descripcion' => $faker->text,
        'id_activo' => $faker->randomDigitNotNull,
        'fts' => $faker->text,
        'id_usuario' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
