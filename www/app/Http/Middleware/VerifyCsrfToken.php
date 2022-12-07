<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'json/geo',
        'json/geo_todo',
        'json/geo_cev',
        'json/geo_todo_cev',
        'json/geo_aa',
        'json/geo_todo_aa',
        'json/geo_tc',
        'json/geo_todo_tc',
        'json/geo_violencia',
        'json/geo_todo_violencia',
        'json/geo_tesauro',
        'json/geo_todo_tesauro',
        '/upload',
        '/upload_adjuntar',
        '/upload_adjuntar_caso_informe',
        '/expedientes.test'
    ];
}
