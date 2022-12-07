@php
    $entrevista =  $casosInformes;
    $entrevista->id_subserie = config('expedientes.ci');
    $id_primaria = $casosInformes->id_casos_informes;
@endphp

@include('partials.tabla_accesos')

