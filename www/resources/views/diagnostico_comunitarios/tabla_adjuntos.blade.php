
@php
    $expediente = $diagnosticoComunitario;
    $llave_primaria = 'id_diagnostico_comunitario_adjunto';
    $action = 'diagnostico_comunitario_adjuntoController@quitar';

@endphp

@include('partials.tabla_adjuntos')

