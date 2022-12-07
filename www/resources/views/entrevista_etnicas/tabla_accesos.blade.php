@php
    $entrevista =  $entrevistaEtnica;
    $entrevista->id_subserie = config('expedientes.ee');
    $id_primaria = $entrevistaEtnica->id_entrevista_etnica;
@endphp

@include('partials.tabla_accesos')


