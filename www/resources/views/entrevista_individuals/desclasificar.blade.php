@extends('layouts.app')


@section('content_header')
    <h1 class="page-title">
        Autorizar el acceso a los archivos adjuntos de una  entrevista R-2 o R-3
    </h1>
@endsection

@section('content')
    @include('entrevista_individuals.tabla_accesos')

    <h1 class="page-title">
        (#{!! $entrevistaIndividual->entrevista_correlativo !!}) {!! $entrevistaIndividual->entrevista_codigo !!} <small> {{ $entrevistaIndividual->fmt_id_subserie }} [R-{{ $entrevistaIndividual->clasifica_nivel }}]</small>
    </h1>

    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('entrevista_individuals.show_fields')
        </div>
    </div>



@endsection