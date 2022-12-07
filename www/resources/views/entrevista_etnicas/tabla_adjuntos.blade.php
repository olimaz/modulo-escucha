
@php
    $expediente = $entrevistaEtnica;
    $llave_primaria = 'id_entrevista_etnica_adjunto';
    $action = 'entrevista_etnica_adjuntoController@quitar';

@endphp

@include('partials.tabla_adjuntos')

