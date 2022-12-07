<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\censo_archivos;
use Faker\Generator as Faker;

$factory->define(censo_archivos::class, function (Faker $faker) {

    return [
        'id_tipo' => $faker->randomDigitNotNull,
        'custodio' => $faker->text,
        'direccion' => $faker->text,
        'id_geo' => $faker->randomDigitNotNull,
        'contacto_correo' => $faker->word,
        'contacto_telefono' => $faker->word,
        'contacto_url' => $faker->text,
        'archivo_fisico' => $faker->randomDigitNotNull,
        'archivo_fisico_volumen' => $faker->word,
        'archivo_fisico_ubicacion' => $faker->text,
        'archivo_electronico' => $faker->randomDigitNotNull,
        'archivo_electronico_volumen' => $faker->word,
        'archivo_electronico_ubicacion' => $faker->text,
        'archivo_virtual' => $faker->randomDigitNotNull,
        'archivo_virtual_volumen' => $faker->word,
        'archivo_virutal_ubicacion' => $faker->text,
        'acceso_publico' => $faker->randomDigitNotNull,
        'acceso_publico_volumen' => $faker->word,
        'acceso_publico_descripcion' => $faker->text,
        'acceso_clasificado' => $faker->randomDigitNotNull,
        'acceso_clasificado_volumen' => $faker->word,
        'acceso_clasificado_descripcion' => $faker->text,
        'acceso_reservado' => $faker->randomDigitNotNull,
        'acceso_reservado_volumen' => $faker->word,
        'acceso_reservado_descripcion' => $faker->text,
        'anotaciones' => $faker->text,
        'ficha_diligenciada_nombre' => $faker->word,
        'ficha_diligenciada_telefono' => $faker->word,
        'ficha_diligenciada_correo' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
