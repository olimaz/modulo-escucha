<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\blog;
use Faker\Generator as Faker;

$factory->define(blog::class, function (Faker $faker) {

    return [
        'id_entrevistador' => $faker->randomDigitNotNull,
        'fecha_hora' => $faker->date('Y-m-d H:i:s'),
        'titulo' => $faker->word,
        'html' => $faker->text,
        'texto' => $faker->text,
        'id_activo' => $faker->randomDigitNotNull,
        'id_blog_respondido' => $faker->randomDigitNotNull,
        'fh_update' => $faker->date('Y-m-d H:i:s')
    ];
});
