<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\mis_casos_persona;
use Faker\Generator as Faker;

$factory->define(mis_casos_persona::class, function (Faker $faker) {

    return [
        'id_mis_casos' => $faker->randomDigitNotNull,
        'nombre' => $faker->word,
        'id_sexo' => $faker->randomDigitNotNull,
        'contacto' => $faker->text,
        'id_contactado' => $faker->randomDigitNotNull,
        'id_entrevistado' => $faker->randomDigitNotNull,
        'id_subserie' => $faker->randomDigitNotNull,
        'id_entrevista' => $faker->randomDigitNotNull,
        'anotaciones' => $faker->text,
        'fh_insert' => $faker->date('Y-m-d H:i:s'),
        'fh_update' => $faker->date('Y-m-d H:i:s')
    ];
});
