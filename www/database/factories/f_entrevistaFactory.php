<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\f_entrevista;
use Faker\Generator as Faker;

$factory->define(f_entrevista::class, function (Faker $faker) {

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
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'identificacion_consentimiento' => $faker->word,
        'conceder_entrevista' => $faker->randomDigitNotNull,
        'grabar_audio' => $faker->randomDigitNotNull,
        'elaborar_informe' => $faker->randomDigitNotNull,
        'tratamiento_datos_analizar' => $faker->randomDigitNotNull,
        'tratamiento_datos_analizar_sensible' => $faker->randomDigitNotNull,
        'tratamiento_datos_utilizar' => $faker->randomDigitNotNull,
        'tratamiento_datos_utilizar_sensible' => $faker->randomDigitNotNull,
        'tratamiento_datos_publicar' => $faker->randomDigitNotNull,
        'insert_ent' => $faker->randomDigitNotNull,
        'insert_ip' => $faker->word,
        'insert_fh' => $faker->date('Y-m-d H:i:s'),
        'update_ent' => $faker->randomDigitNotNull,
        'update_ip' => $faker->word,
        'update_fh' => $faker->date('Y-m-d H:i:s'),
        'id_entrevista_etnica' => $faker->randomDigitNotNull
    ];
});
