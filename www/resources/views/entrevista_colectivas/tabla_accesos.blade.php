@php
    $entrevista =  $entrevistaColectiva;
    $entrevista->id_subserie = config('expedientes.co');
    $id_primaria = $entrevistaColectiva->id_entrevista_colectiva;
@endphp

@include('partials.tabla_accesos')


