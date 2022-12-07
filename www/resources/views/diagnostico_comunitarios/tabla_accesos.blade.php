@php
    $entrevista =  $diagnosticoComunitario;
    $entrevista->id_subserie = config('expedientes.dc');
    $id_primaria = $diagnosticoComunitario->id_diagnostico_comunitario;
@endphp

@include('partials.tabla_accesos')
