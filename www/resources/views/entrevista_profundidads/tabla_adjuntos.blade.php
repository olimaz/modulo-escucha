
@php
    $expediente = $entrevistaProfundidad;
    $llave_primaria = 'id_entrevista_profundidad_adjunto';
    $action = 'entrevista_profundidad_adjuntoController@quitar';

@endphp

@include('partials.tabla_adjuntos')

