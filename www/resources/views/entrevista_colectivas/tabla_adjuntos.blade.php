

@php
    $expediente = $entrevistaColectiva;
    $llave_primaria = 'id_entrevista_colectiva_adjunto';
    $action = 'entrevista_colectiva_adjuntoController@quitar';

@endphp

@include('partials.tabla_adjuntos')

