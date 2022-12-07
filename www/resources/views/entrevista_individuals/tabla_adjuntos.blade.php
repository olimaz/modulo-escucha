
@php
    $expediente = $entrevistaIndividual;
    $llave_primaria = 'id_e_ind_fvt_adjunto';
    $action = 'entrevista_individual_adjuntoController@quitar';
    $edicion = !isset($solo_lectura)
@endphp

@include('partials.tabla_adjuntos')

