@php
    $entrevista =  $historiaVida;
    $entrevista->id_subserie = config('expedientes.hv');
    $id_primaria = $historiaVida->id_historia_vida;
@endphp

@include('partials.tabla_accesos')
