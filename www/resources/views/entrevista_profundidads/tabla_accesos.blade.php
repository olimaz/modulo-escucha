@php
    $entrevista =  $entrevistaProfundidad;
    $entrevista->id_subserie = config('expedientes.pr');
    $id_primaria = $entrevistaProfundidad->id_entrevista_profundidad;
@endphp

@include('partials.tabla_accesos')

