@php
    $entrevista =  $entrevistaIndividual;
    $entrevista->id_subserie = $entrevistaIndividual->id_subserie;
    $id_primaria = $entrevistaIndividual->id_e_ind_fvt;
@endphp

@include('partials.tabla_accesos')

