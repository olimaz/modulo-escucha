@php
    $expediente = $historiaVida;
    $llave_primaria = 'id_historia_vida_adjunto';
    $action = 'historia_vida_adjuntoController@quitar';
@endphp

@include('partials.tabla_adjuntos')
