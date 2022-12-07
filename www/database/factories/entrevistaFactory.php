<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\entrevista;
use Faker\Generator as Faker;

$factory->define(entrevista::class, function (Faker $faker) {

    return [
        'id_e_ind_fvt' => $faker->randomDigitNotNull,
        'id_idioma' => $faker->randomDigitNotNull,
        'id_nativo' => $faker->randomDigitNotNull,
        'nombre_interprete' => $faker->word,
        'documentacion_aporta' => $faker->randomDigitNotNull,
        'documentacion_especificar' => $faker->text,
        'identifica_testigos' => $faker->randomDigitNotNull,
        'ampliar_relato' => $faker->randomDigitNotNull,
        'ampliar_relato_temas' => $faker->text,
        'priorizar_entrevista' => $faker->randomDigitNotNull,
        'priorizar_entrevista_asuntos' => $faker->text,
        'contiene_patrones' => $faker->randomDigitNotNull,
        'contiene_patrones_cuales' => $faker->text,
        'indicaciones_transcripcion' => $faker->text,
        'observaciones' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
