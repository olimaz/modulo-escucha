@extends('layouts.app')


@section('content_header')
    <h1 class="page-title">
        Autorizar el acceso a los archivos adjuntos de una  entrevista R-2 o R-3
    </h1>
@endsection

@section('content')
    @include('entrevista_etnicas.tabla_accesos')

    <h1 class="page-title">
        (#{!! $entrevistaEtnica->entrevista_correlativo !!}) {!! $entrevistaEtnica->entrevista_codigo !!} <small> Entrevista a sujeto colectivo [R-{{ $entrevistaEtnica->clasificacion_nivel }}]</small>
    </h1>

    <div class="box">
        <div class="box-header">

        </div>
        <div class="box-body">
            @include('entrevista_etnicas.show_fields')
        </div>
    </div>



@endsection