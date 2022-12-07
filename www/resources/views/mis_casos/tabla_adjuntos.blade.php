@php
    $expediente = $miCaso;
    $llave_primaria = 'id_mis_casos_adjunto';
    $action = 'mis_casosController@quitar_adjunto';
@endphp

@include('partials.tabla_adjuntos')
