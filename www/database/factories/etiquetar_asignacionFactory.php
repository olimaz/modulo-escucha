<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\etiquetar_asignacion;
use Faker\Generator as Faker;

$factory->define(etiquetar_asignacion::class, function (Faker $faker) {

    return [
        'id_e_ind_fvt' => $faker->randomDigitNotNull,
        'id_entrevista_profundidad' => $faker->randomDigitNotNull,
        'id_entrevista_colectiva' => $faker->randomDigitNotNull,
        'id_entrevista_etnica' => $faker->randomDigitNotNull,
        'id_diagnostico_comunitario' => $faker->randomDigitNotNull,
        'id_historia_vida' => $faker->randomDigitNotNull,
        'id_autoriza' => $faker->randomDigitNotNull,
        'id_transcriptor' => $faker->randomDigitNotNull,
        'id_situacion' => $faker->randomDigitNotNull,
        'id_causa' => $faker->randomDigitNotNull,
        'urgente' => $faker->randomDigitNotNull,
        'observaciones' => $faker->text,
        'fh_asignado' => $faker->date('Y-m-d H:i:s'),
        'fh_revocado' => $faker->date('Y-m-d H:i:s'),
        'fh_transcrito' => $faker->date('Y-m-d H:i:s'),
        'fh_anulado' => $faker->date('Y-m-d H:i:s'),
        'fh_inicio' => $faker->date('Y-m-d H:i:s'),
        'fh_fin' => $faker->date('Y-m-d H:i:s'),
        'terceros' => $faker->randomDigitNotNull,
        'duracion_etiquetado_minutos' => $faker->randomDigitNotNull,
        'duracion_etiquetado_real_minutos' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
